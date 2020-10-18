<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Contracts\RoleContract;
use App\Http\Requests\RoleStoreFormRequest;
use App\Http\Requests\RoleUpdateFormRequest;

class RoleController extends BaseController
{
    /**
     * @var RoleContract
     */
    protected $roleRepository;

    /**
     * RoleController constructor.
     * @param RoleContract $roleRepository
     */
    public function __construct(RoleContract $roleRepository)
    {
        $this->middleware('auth');
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle('Roles', 'Roles List');
        $data = [
            'tableHeads' => [ trans('role.SN'), trans('role.name'), trans('role.slug'), trans('role.status'), trans('role.action')],
            'dataUrl' => 'roles/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'name', 'name' => 'name'],
                ['data' => 'slug', 'name' => 'slug'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        return view('roles.index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return $this->roleRepository->listRole($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Roles', 'Create Role');
        return view('roles.create');
    }

    /**
     * @param StoreRoleFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleStoreFormRequest $request)
    {
        $params = $request->except('_token');

        $role = $this->roleRepository->createRole($params);

        if (!$role) {
            return $this->responseRedirectBack( trans('common.create_error'), 'error', true, true);
        }
        return $this->responseRedirect('roles.index', trans('common.create_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $this->setPageTitle('Roles', 'Edit Role');

        $role = $this->roleRepository->findRoleById($id);

        return view('roles.edit', compact('role'));
    }

    /**
     * @param UpdateRoleFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleUpdateFormRequest $request, Role $roleModel)
    {
        $params = $request->except('_token');

        $role = $this->roleRepository->updateRole($params);

        if (!$role) {
            return $this->responseRedirectBack(trans('common.update_error'), 'error', true, true);
        }
        return $this->responseRedirect('roles.index', trans('common.update_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $params = $request->except('_token');
        $role = $this->roleRepository->deleteRole($id, $params);

        if (!$role) {
            return $this->responseRedirectBack(trans('common.delete_error'), 'error', true, true);
        }
        return $this->responseRedirect('roles.index', trans('common.delete_success') ,'success',false, false);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore()
    {
        $roles = $this->roleRepository->restore();

        if (!$roles) {
            return $this->responseRedirectBack(trans('common.restore_error'), 'error', true, true);
        }
        return $this->responseRedirect('roles.index', trans('common.restore_success') ,'success',false, false);
    }
}
