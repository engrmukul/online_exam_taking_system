<?php

namespace App\Http\Controllers;

use App\Models\Permission;
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
    public function index(Request $request)
    {
        if ($request->user()->can('role_list')) {
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
        }else{
            return redirect('/');
        }

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
    public function create(Request $request)
    {
        if ($request->user()->can('role_add')) {
            $this->setPageTitle('Roles', 'Create Role');

            $permissions = Permission::all();

            return view('roles.create', compact('permissions'));
        }else{
            return redirect('/');
        }
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
    public function edit(Request $request, $id)
    {
        if ($request->user()->can('role_edit')) {

            $this->setPageTitle('Roles', 'Edit Role');

            $role = Role::with('permissions')->where('id', $id)->first();

            $allPermissions = Permission::all();

            return view('roles.edit', compact('role', 'allPermissions'));
        }else{
            return redirect('/');
        }
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
        if ($request->user()->can('role_delete')) {
            $params = $request->except('_token');
            $role = $this->roleRepository->deleteRole($id, $params);

            if (!$role) {
                return $this->responseRedirectBack(trans('common.delete_error'), 'error', true, true);
            }
            return $this->responseRedirect('roles.index', trans('common.delete_success') ,'success',false, false);

        }else{
            return redirect('/');
        }
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
