<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Contracts\TestContract;
use App\Http\Requests\TestStoreFormRequest;
use App\Http\Requests\TestUpdateFormRequest;

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
        $this->testRepository = $testRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle('Tests', 'Tests List');
        $data = [
            'tableHeads' => [ trans('test.SN'), trans('test.subject'), trans('test.test_title'), trans('test.test_date'), trans('test.noq'), trans('test.start_time'), trans('test.end_time'), trans('test.test_status'), trans('test.status'), trans('test.action')],
            'dataUrl' => 'tests/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'subject', 'name' => 'subject'],
                ['data' => 'test_title', 'name' => 'test_title'],
                ['data' => 'test_date', 'name' => 'test_date'],
                ['data' => 'noq', 'name' => 'noq'],
                ['data' => 'start_time', 'name' => 'start_time'],
                ['data' => 'end_time', 'name' => 'end_time'],
                ['data' => 'test_status', 'name' => 'test_status'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        return view('tests.index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return $this->testRepository->listTest($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Tests', 'Create Test');
        $subjects = Subject::all();
        return view('tests.create', compact('subjects'));
    }

    /**
     * @param StoreTestFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TestStoreFormRequest $request)
    {
        $params = $request->except('_token');

        $test = $this->testRepository->createTest($params);

        if (!$test) {
            return $this->responseRedirectBack( trans('common.create_error'), 'error', true, true);
        }
        return $this->responseRedirect('tests.index', trans('common.create_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $this->setPageTitle('Tests', 'Edit Test');

        $test = $this->testRepository->findTestById($id);

        $subjects = Subject::all();

        return view('tests.edit', compact('test','subjects'));
    }

    /**
     * @param UpdateTestFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TestUpdateFormRequest $request, Test $testModel)
    {
        $params = $request->except('_token');

        $test = $this->testRepository->updateTest($params);

        if (!$test) {
            return $this->responseRedirectBack(trans('common.update_error'), 'error', true, true);
        }
        return $this->responseRedirect('tests.index', trans('common.update_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $params = $request->except('_token');
        $test = $this->testRepository->deleteTest($id, $params);

        if (!$test) {
            return $this->responseRedirectBack(trans('common.delete_error'), 'error', true, true);
        }
        return $this->responseRedirect('tests.index', trans('common.delete_success') ,'success',false, false);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore()
    {
        $tests = $this->testRepository->restore();

        if (!$tests) {
            return $this->responseRedirectBack(trans('common.restore_error'), 'error', true, true);
        }
        return $this->responseRedirect('tests.index', trans('common.restore_success') ,'success',false, false);
    }
}
