<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\QuestionPaper;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Contracts\QuestionPaperContract;
use App\Http\Requests\QuestionPaperStoreFormRequest;
use App\Http\Requests\QuestionPaperUpdateFormRequest;

class QuestionPaperController extends BaseController
{
    /**
     * @var QuestionPaperContract
     */
    protected $questionPaperRepository;

    /**
     * QuestionPaperController constructor.
     * @param QuestionPaperContract $questionPaperRepository
     */
    public function __construct(QuestionPaperContract $questionPaperRepository)
    {
        $this->questionPaperRepository = $questionPaperRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle('question-papers', 'QuestionPapers List');
        $data = [
            'tableHeads' => [ trans('questionPaper.SN'), trans('questionPaper.exam'), trans('questionPaper.question_set'), trans('questionPaper.generate_by'), trans('questionPaper.status'), trans('questionPaper.action')],
            'dataUrl' => 'question-papers/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'exam', 'name' => 'exam'],
                ['data' => 'question_set', 'name' => 'question_set'],
                ['data' => 'generate_by', 'name' => 'generate_by'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        return view('questionPapers.index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return $this->questionPaperRepository->listQuestionPaper($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('question-papers', 'Create QuestionPaper');

        $exams = Exam::all();

        $data = [
            'tableHeads' => [ trans('question.SN'), trans('question.subject'), trans('question.question'), trans('question.status')],
            'dataUrl' => 'questions/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'subject', 'name' => 'subject'],
                ['data' => 'question', 'name' => 'question'],
                ['data' => 'status', 'name' => 'status'],
                //['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];


        return view('questionPapers.create', $data, compact('exams'));
    }

    /**
     * @param StoreQuestionPaperFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionPaperStoreFormRequest $request)
    {
        $params = $request->except('_token');

        $questionPaper = $this->questionPaperRepository->createQuestionPaper($params);

        if (!$questionPaper) {
            return $this->responseRedirectBack( trans('common.create_error'), 'error', true, true);
        }
        return $this->responseRedirect('question-papers.index', trans('common.create_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $this->setPageTitle('question-papers', 'Edit QuestionPaper');

        $questionPaper = $this->questionPaperRepository->findQuestionPaperById($id);

        $exams = Exam::all();

        return view('question-papers.edit', compact('questionPaper','exams'));
    }

    /**
     * @param UpdateQuestionPaperFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionPaperUpdateFormRequest $request, QuestionPaper $questionPaperModel)
    {
        $params = $request->except('_token');

        $questionPaper = $this->questionPaperRepository->updateQuestionPaper($params);

        if (!$questionPaper) {
            return $this->responseRedirectBack(trans('common.update_error'), 'error', true, true);
        }
        return $this->responseRedirect('question-papers.index', trans('common.update_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $params = $request->except('_token');

        $questionPaper = $this->questionPaperRepository->deleteQuestionPaper($id, $params);

        if (!$questionPaper) {
            return $this->responseRedirectBack(trans('common.delete_error'), 'error', true, true);
        }
        return $this->responseRedirect('question-papers.index', trans('common.delete_success') ,'success',false, false);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore()
    {
        $questionPapers = $this->questionPaperRepository->restore();

        if (!$questionPapers) {
            return $this->responseRedirectBack(trans('common.restore_error'), 'error', true, true);
        }
        return $this->responseRedirect('question-papers.index', trans('common.restore_success') ,'success',false, false);
    }
}
