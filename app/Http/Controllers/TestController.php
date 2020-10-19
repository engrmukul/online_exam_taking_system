<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use App\Models\QuestionAssign;
use App\Models\Test;
use App\Models\Subject;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use App\Contracts\TestContract;
use App\Http\Requests\TestStoreFormRequest;
use App\Http\Requests\TestUpdateFormRequest;
use stdClass;

class TestController extends BaseController
{
    /**
     * @var TestContract
     */
    protected $testRepository;

    /**
     * TestController constructor.
     * @param TestContract $testRepository
     */
    public function __construct(TestContract $testRepository)
    {
        $this->middleware('auth');

        $this->testRepository = $testRepository;

        date_default_timezone_set('Asia/Dhaka');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->user()->can('test')) {
            $this->setPageTitle('Tests', 'Tests');


            $pageData = new stdClass();
            $date = date('Y-m-d h:i:s');
            $query = QuestionAssign::where('student_id', auth()->user()->id)->with('exam', 'student', 'questionPaper');

            $query->whereHas('exam', function ($q) use ($date){
                $q->where('exam_end_date_time', '>=', $date);
                $q->orderBy('exam_start_date_time', 'ASC')->limit(1);
            });

            $testInfo = $query->first();

            if ($testInfo) {
                $questions = Question::with('answers')->whereIn('id', explode(',', $testInfo->questionPaper->question_ids))->get();
                if ($questions) {

                    $studentTestInfo = Test::where(['student_id' => auth()->user()->id, 'exam_id' => $testInfo->exam_id, 'status' => 'finished'])->count();

                    if ($studentTestInfo == 1) {
                        $pageData->examInfo = 'Exam Finished';

                        return view('tests.exam_info', compact('pageData'));
                    } else {

                        if ($testInfo->exam->exam_date < date('Y-m-d')) {
                            $pageData->examInfo = 'Exam Date Expire' . $testInfo->exam->exam_date;

                            return view('tests.exam_info', compact('pageData'));
                        } else if ($testInfo->exam->exam_date > date('Y-m-d')) {
                            $pageData->examInfo = 'Exam Date ' . $testInfo->exam->exam_date;

                            return view('tests.exam_info', compact('pageData'));
                        } else if ($testInfo->exam->exam_date == date('Y-m-d') AND (strtotime($testInfo->exam->exam_date . ' ' . $testInfo->exam->start_time) <= strtotime(date('Y-m-d h:i:s'))) AND (strtotime($testInfo->exam->exam_date . ' ' . $testInfo->exam->end_time) >= strtotime(date('Y-m-d h:i:s'))) AND $testInfo->exam->exam_status == 'on_going') {
                            $savedAnswers = array_map('current', Test::select('answer_id')->where(['student_id' => $testInfo->student->id, 'exam_id' => $testInfo->exam_id])->get()->toArray());

                            return view('tests.index', compact('testInfo', 'questions', 'savedAnswers'));
                        } else {
                            $pageData->examInfo = 'Last Exam Finished ' . $testInfo->exam->exam_date . ' ' . date('h:i:s a', strtotime($testInfo->exam->end_time));

                            return view('tests.exam_info', compact('pageData'));
                        }
                    }

                } else {
                    $pageData->examInfo = 'Exam Not Published';

                    return view('tests.exam_info', compact('pageData'));
                }
            } else {
                $pageData->examInfo = 'Exam Not Published';

                return view('tests.exam_info', compact('pageData'));
            }
        }else{
            return redirect('/');
        }
    }

    /**
     * @param StoreTestFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $params = $request->except('_token');

        $test = $this->testRepository->createTest($params);

        if (!$test) {
            return $this->responseRedirectBack(trans('common.create_error'), 'error', true, true);
        }
        return $this->responseRedirect('tests.index', trans('common.create_success'), 'success', false, false);
    }

    /**
     * @param $examId
     * @return string
     */
    public function examFinish($examId)
    {
        Test::where('exam_id', $examId)
            ->where('student_id', auth()->user()->id)
            ->orderBy('id','desc')
            ->take(1)
            ->update(['status' => 'finished']);

        $this->answerMail($examId);

        return 'success';
    }

    /**
     * @param $examId
     * @return string
     */
    public function examExpired($examId)
    {
        Exam::where('id', $examId)
            ->update(['exam_status' => 'expired']);

        $this->answerMail($examId);

        return 'success';
    }

    public function answerMail($examId)
    {
        //EMAIL FUNCTION CALL

        $testResult = Test::with('questions', 'answers')->where(['exam_id'=>$examId, 'student_id'=>auth()->user()->id])->get();

        $details = [
            'title' => 'Mail from student',
            'testResult' => $testResult
        ];

        $adminEmail = Exam::with('admin')->where('id', $examId)->first();

        \Mail::to( $adminEmail->admin->email )->send(new \App\Mail\AnswerMail($details));

        return true;
    }

    /**
     * @param $examId
     * @return string
     */
    public function saveAnswer(Request $request)
    {
        $test = new Test();
        $test->exam_id = $request->exam_id;
        $test->student_id = auth()->user()->id;
        $test->question_id = $request->question_id;
        $test->answer_id = $request->answer_id;

        //CHECK EXISTING
        $count = Test::where(['exam_id'=>$test->exam_id, 'student_id'=>$test->student_id, 'question_id'=>$test->question_id])->count();
        if($count == 1){
            $affectedRows = Test::where(['exam_id'=>$test->exam_id, 'student_id'=>$test->student_id, 'question_id'=>$test->question_id])->update(array('answer_id' => $test->answer_id));

            if($affectedRows){
                return response(array('status'=>'success','message'=>'Your answer successfully updated'));
            }else{
                return response(array('status'=>'failed'));
            }
        }else if($count == 0){
            if($test->save()){
                return response(array('status'=>'success', 'message'=>'Your answer successfully saved'));
            }else{
                return response(array('status'=>'failed'));
            }
        }else{
            return response(array('status'=>'failed'));
        }
    }

}
