<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\QuestionAssign;
use App\Models\QuestionPaper;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Contracts\QuestionAssignContract;
use App\Http\Requests\QuestionAssignStoreFormRequest;
use App\Http\Requests\QuestionAssignUpdateFormRequest;

class QuestionAssignController extends BaseController
{
    /**
     * @var QuestionAssignContract
     */
    protected $questionAssignRepository;

    /**
     * QuestionAssignController constructor.
     * @param QuestionAssignContract $questionAssignRepository
     */
    public function __construct(QuestionAssignContract $questionAssignRepository)
    {
        $this->questionAssignRepository = $questionAssignRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle('question-assigns', 'QuestionAssigns List');
        $data = [
            'tableHeads' => [ trans('questionAssign.SN'), trans('questionAssign.exam'), trans('questionAssign.student'),trans('questionAssign.question_paper')],
            'dataUrl' => 'question-assigns/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'exam', 'name' => 'exam'],
                ['data' => 'student', 'name' => 'student'],
                ['data' => 'question_paper', 'name' => 'question_paper'],
                //['data' => 'status', 'name' => 'status'],
               // ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        return view('questionAssigns.index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return $this->questionAssignRepository->listQuestionAssign($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('question-assigns', 'Create QuestionAssign');

        $query = QuestionPaper::with('exam');

        $query->whereHas('exam', function ($q) {
            $q->where('exam_status', 'not_start');
        });

        $exams = $query->groupBy('exam_id')->get();

        $data = [
            'tableHeads' => [ trans('user.SN'), trans('user.name'), trans('user.mobile'), trans('user.username'), trans('user.email')],
            'dataUrl' => 'users/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'name', 'name' => 'name'],
                ['data' => 'mobile', 'name' => 'mobile'],
                ['data' => 'username', 'name' => 'username'],
                ['data' => 'email', 'name' => 'email']
            ],
        ];


        return view('questionAssigns.create', $data, compact('exams'));
    }

    /**
     * @param StoreQuestionAssignFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionAssignStoreFormRequest $request)
    {
        $params = $request->except('_token');

        $questionAssign = $this->questionAssignRepository->createQuestionAssign($params);

        if (!$questionAssign) {
            return $this->responseRedirectBack( trans('common.create_error'), 'error', true, true);
        }
        return $this->responseRedirect('question-assigns.index', trans('common.create_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $this->setPageTitle('question-assigns', 'Edit QuestionAssign');

        $questionAssign = $this->questionAssignRepository->findQuestionAssignById($id);

        $exams = Exam::all();

        return view('question-assigns.edit', compact('questionAssign','exams'));
    }

    /**
     * @param UpdateQuestionAssignFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionAssignUpdateFormRequest $request, QuestionAssign $questionAssign)
    {
        $params = $request->except('_token');

        $questionAssign = $this->questionAssignRepository->updateQuestionAssign($params);

        if (!$questionAssign) {
            return $this->responseRedirectBack(trans('common.update_error'), 'error', true, true);
        }
        return $this->responseRedirect('question-assigns.index', trans('common.update_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $params = $request->except('_token');

        $questionAssign = $this->questionAssignRepository->deleteQuestionAssign($id, $params);

        if (!$questionAssign) {
            return $this->responseRedirectBack(trans('common.delete_error'), 'error', true, true);
        }
        return $this->responseRedirect('question-assigns.index', trans('common.delete_success') ,'success',false, false);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore()
    {
        $questionAssigns = $this->questionAssignRepository->restore();

        if (!$questionAssigns) {
            return $this->responseRedirectBack(trans('common.restore_error'), 'error', true, true);
        }
        return $this->responseRedirect('question-assigns.index', trans('common.restore_success') ,'success',false, false);
    }
}
