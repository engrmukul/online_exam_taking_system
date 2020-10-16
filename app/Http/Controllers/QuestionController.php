<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Contracts\QuestionContract;
use App\Http\Requests\QuestionStoreFormRequest;
use App\Http\Requests\QuestionUpdateFormRequest;

class QuestionController extends BaseController
{
    /**
     * @var QuestionContract
     */
    protected $questionRepository;

    /**
     * QuestionController constructor.
     * @param QuestionContract $questionRepository
     */
    public function __construct(QuestionContract $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle('Questions', 'Questions List');
        $data = [
            'tableHeads' => [ trans('question.SN'), trans('question.subject'), trans('question.question'), trans('question.status'), trans('question.action')],
            'dataUrl' => 'questions/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'subject', 'name' => 'subject'],
                ['data' => 'question', 'name' => 'question'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        return view('questions.index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return $this->questionRepository->listQuestion($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Questions', 'Create Question');
        $subjects = Subject::all();
        return view('questions.create', compact('subjects'));
    }

    /**
     * @param StoreQuestionFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionStoreFormRequest $request)
    {
        $params = $request->except('_token');

        $question = $this->questionRepository->createQuestion($params);

        if (!$question) {
            return $this->responseRedirectBack( trans('common.create_error'), 'error', true, true);
        }
        return $this->responseRedirect('questions.index', trans('common.create_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $this->setPageTitle('Questions', 'Edit Question');

        $question = $this->questionRepository->findQuestionById($id);

        $subjects = Subject::all();

        return view('questions.edit', compact('question','subjects'));
    }

    /**
     * @param UpdateQuestionFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionUpdateFormRequest $request, Question $questionModel)
    {
        $params = $request->except('_token');

        $question = $this->questionRepository->updateQuestion($params);

        if (!$question) {
            return $this->responseRedirectBack(trans('common.update_error'), 'error', true, true);
        }
        return $this->responseRedirect('questions.index', trans('common.update_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $params = $request->except('_token');
        $question = $this->questionRepository->deleteQuestion($id, $params);

        if (!$question) {
            return $this->responseRedirectBack(trans('common.delete_error'), 'error', true, true);
        }
        return $this->responseRedirect('questions.index', trans('common.delete_success') ,'success',false, false);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore()
    {
        $questions = $this->questionRepository->restore();

        if (!$questions) {
            return $this->responseRedirectBack(trans('common.restore_error'), 'error', true, true);
        }
        return $this->responseRedirect('questions.index', trans('common.restore_success') ,'success',false, false);
    }
}
