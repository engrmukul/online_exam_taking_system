<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Contracts\PermissionContract;
use App\Http\Requests\PermissionStoreFormRequest;
use App\Http\Requests\PermissionUpdateFormRequest;

class PermissionController extends BaseController
{
    /**
     * @var PermissionContract
     */
    protected $permissionRepository;

    /**
     * PermissionController constructor.
     * @param PermissionContract $permissionRepository
     */
    public function __construct(PermissionContract $permissionRepository)
    {
        $this->middleware('auth');
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle('Permissions', 'Permissions List');
        $data = [
            'tableHeads' => [ trans('permission.SN'), trans('permission.name'), trans('permission.slug'), trans('permission.status'), trans('permission.action')],
            'dataUrl' => 'permissions/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'name', 'name' => 'name'],
                ['data' => 'slug', 'name' => 'slug'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        return view('permissions.index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return $this->permissionRepository->listPermission($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Permissions', 'Create Permission');
        return view('permissions.create');
    }

    /**
     * @param StorePermissionFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PermissionStoreFormRequest $request)
    {
        $params = $request->except('_token');

        $permission = $this->permissionRepository->createPermission($params);

        if (!$permission) {
            return $this->responseRedirectBack( trans('common.create_error'), 'error', true, true);
        }
        return $this->responseRedirect('permissions.index', trans('common.create_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $this->setPageTitle('Permissions', 'Edit Permission');

        $permission = $this->permissionRepository->findPermissionById($id);

        return view('permissions.edit', compact('permission'));
    }

    /**
     * @param UpdatePermissionFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PermissionUpdateFormRequest $request, Permission $permissionModel)
    {
        $params = $request->except('_token');

        $permission = $this->permissionRepository->updatePermission($params);

        if (!$permission) {
            return $this->responseRedirectBack(trans('common.update_error'), 'error', true, true);
        }
        return $this->responseRedirect('permissions.index', trans('common.update_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $params = $request->except('_token');
        $permission = $this->permissionRepository->deletePermission($id, $params);

        if (!$permission) {
            return $this->responseRedirectBack(trans('common.delete_error'), 'error', true, true);
        }
        return $this->responseRedirect('permissions.index', trans('common.delete_success') ,'success',false, false);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore()
    {
        $permissions = $this->permissionRepository->restore();

        if (!$permissions) {
            return $this->responseRedirectBack(trans('common.restore_error'), 'error', true, true);
        }
        return $this->responseRedirect('permissions.index', trans('common.restore_success') ,'success',false, false);
    }
}
