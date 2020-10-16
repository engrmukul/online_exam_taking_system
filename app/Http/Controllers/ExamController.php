<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Contracts\ExamContract;
use App\Http\Requests\ExamStoreFormRequest;
use App\Http\Requests\ExamUpdateFormRequest;

class ExamController extends BaseController
{
    /**
     * @var ExamContract
     */
    protected $examRepository;

    /**
     * ExamController constructor.
     * @param ExamContract $examRepository
     */
    public function __construct(ExamContract $examRepository)
    {
        $this->examRepository = $examRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle('Exams', 'Exams List');
        $data = [
            'tableHeads' => [ trans('exam.SN'), trans('exam.subject'), trans('exam.exam_title'), trans('exam.exam_date'), trans('exam.noq'), trans('exam.start_time'), trans('exam.end_time'), trans('exam.exam_status'), trans('exam.status'), trans('exam.action')],
            'dataUrl' => 'exams/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'subject', 'name' => 'subject'],
                ['data' => 'exam_title', 'name' => 'exam_title'],
                ['data' => 'exam_date', 'name' => 'exam_date'],
                ['data' => 'noq', 'name' => 'noq'],
                ['data' => 'start_time', 'name' => 'start_time'],
                ['data' => 'end_time', 'name' => 'end_time'],
                ['data' => 'exam_status', 'name' => 'exam_status'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        return view('exams.index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return $this->examRepository->listExam($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Exams', 'Create Exam');
        $subjects = Subject::all();
        return view('exams.create', compact('subjects'));
    }

    /**
     * @param StoreExamFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ExamStoreFormRequest $request)
    {
        $params = $request->except('_token');

        $exam = $this->examRepository->createExam($params);

        if (!$exam) {
            return $this->responseRedirectBack( trans('common.create_error'), 'error', true, true);
        }
        return $this->responseRedirect('exams.index', trans('common.create_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $this->setPageTitle('Exams', 'Edit Exam');

        $exam = $this->examRepository->findExamById($id);

        $subjects = Subject::all();

        return view('exams.edit', compact('exam','subjects'));
    }

    /**
     * @param UpdateExamFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ExamUpdateFormRequest $request, Exam $examModel)
    {
        $params = $request->except('_token');

        $exam = $this->examRepository->updateExam($params);

        if (!$exam) {
            return $this->responseRedirectBack(trans('common.update_error'), 'error', true, true);
        }
        return $this->responseRedirect('exams.index', trans('common.update_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $params = $request->except('_token');
        $exam = $this->examRepository->deleteExam($id, $params);

        if (!$exam) {
            return $this->responseRedirectBack(trans('common.delete_error'), 'error', true, true);
        }
        return $this->responseRedirect('exams.index', trans('common.delete_success') ,'success',false, false);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore()
    {
        $exams = $this->examRepository->restore();

        if (!$exams) {
            return $this->responseRedirectBack(trans('common.restore_error'), 'error', true, true);
        }
        return $this->responseRedirect('exams.index', trans('common.restore_success') ,'success',false, false);
    }
}
