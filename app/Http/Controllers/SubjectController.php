<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Contracts\SubjectContract;
use App\Http\Requests\SubjectStoreFormRequest;
use App\Http\Requests\SubjectUpdateFormRequest;

class SubjectController extends BaseController
{
    /**
     * @var SubjectContract
     */
    protected $subjectRepository;

    /**
     * SubjectController constructor.
     * @param SubjectContract $subjectRepository
     */
    public function __construct(SubjectContract $subjectRepository)
    {
        $this->middleware('auth');
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->user()->can('subject_list')) {
            $this->setPageTitle('Subjects', 'Subjects List');
            $data = [
                'tableHeads' => [trans('subject.SN'), trans('subject.code'), trans('subject.name'), trans('subject.status'), trans('subject.action')],
                'dataUrl' => 'subjects/get-data',
                'columns' => [
                    ['data' => 'id', 'name' => 'id'],
                    ['data' => 'code', 'name' => 'code'],
                    ['data' => 'name', 'name' => 'name'],
                    ['data' => 'status', 'name' => 'status'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false]
                ],
            ];
            return view('subjects.index', $data);
        } else {
            return redirect('/');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return $this->subjectRepository->listSubject($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->user()->can('subject_add')) {
            $this->setPageTitle('Subjects', 'Create Subject');
            return view('subjects.create');
        }else{
            return redirect('/');
        }
    }

    /**
     * @param StoreSubjectFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SubjectStoreFormRequest $request)
    {
        $params = $request->except('_token');

        $subject = $this->subjectRepository->createSubject($params);

        if (!$subject) {
            return $this->responseRedirectBack( trans('common.create_error'), 'error', true, true);
        }
        return $this->responseRedirect('subjects.index', trans('common.create_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        if ($request->user()->can('subject_edit')) {
            $subject = $this->subjectRepository->findSubjectById($id);


            $this->setPageTitle('Subjects', 'Edit Subject');
            return view('subjects.edit', compact('subject'));
        }else{

        }
    }

    /**
     * @param UpdateSubjectFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SubjectUpdateFormRequest $request, Subject $subjectModel)
    {
        $params = $request->except('_token');

        $subject = $this->subjectRepository->updateSubject($params);

        if (!$subject) {
            return $this->responseRedirectBack(trans('common.update_error'), 'error', true, true);
        }
        return $this->responseRedirect('subjects.index', trans('common.update_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $params = $request->except('_token');
        $subject = $this->subjectRepository->deleteSubject($id, $params);

        if (!$subject) {
            return $this->responseRedirectBack(trans('common.delete_error'), 'error', true, true);
        }
        return $this->responseRedirect('subjects.index', trans('common.delete_success') ,'success',false, false);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore()
    {
        $subjects = $this->subjectRepository->restore();

        if (!$subjects) {
            return $this->responseRedirectBack(trans('common.restore_error'), 'error', true, true);
        }
        return $this->responseRedirect('subjects.index', trans('common.restore_success') ,'success',false, false);
    }
}
