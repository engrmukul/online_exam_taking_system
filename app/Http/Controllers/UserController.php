<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Contracts\UserContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\UserStoreFormRequest;
use App\Http\Requests\UserUpdateFormRequest;

class UserController extends BaseController
{
    /**
     * @var UserContract
     */
    protected $userRepository;

    /**
     * UserController constructor.
     * @param UserContract $userRepository
     */
    public function __construct(UserContract $userRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->user()->can('user_list')) {
            $this->setPageTitle('Users', 'Users List');

            $data = [
                'tableHeads' => [trans('user.SN'), trans('user.name'), trans('user.mobile'), trans('user.username'), trans('user.email'), trans('user.role'), trans('user.status'), trans('user.action')],
                'dataUrl' => 'users/get-data',
                'columns' => [
                    ['data' => 'id', 'name' => 'id'],
                    ['data' => 'name', 'name' => 'name'],
                    ['data' => 'mobile', 'name' => 'mobile'],
                    ['data' => 'username', 'name' => 'username'],
                    ['data' => 'email', 'name' => 'email'],
                    ['data' => 'role', 'name' => 'role'],
                    ['data' => 'status', 'name' => 'status'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false]
                ],
            ];
            return view('users.index', $data);
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
        return $this->userRepository->listUser($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getStudentData(Request $request)
    {
        return $this->userRepository->listStudentUser($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->user()->can('user_add')) {
            $this->setPageTitle('Users', 'Create User');

            $roles = Role::all();
            $menus = Menu::all();

            return view('users.create', compact('roles', 'menus'));
        }else{
            return redirect('/');
        }
    }

    /**
     * @param StoreUserFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserStoreFormRequest $request)
    {
        $params = $request->except('_token');

        $user = $this->userRepository->createUser($params);

        if (!$user) {
            return $this->responseRedirectBack( trans('common.create_error'), 'error', true, true);
        }
        return $this->responseRedirect('users.index', trans('common.create_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        if ($request->user()->can('user_edit')) {
            $this->setPageTitle('Users', 'Edit User');

            $user = $this->userRepository->findUserById($id);

            $roles = Role::all();

            $menus = Menu::all();

            return view('users.edit', compact('user', 'roles', 'menus'));
        }else{
            return redirect('/');
        }
    }

    /**
     * @param UpdateUserFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateFormRequest $request, User $userModel)
    {
        $params = $request->except('_token');

        $user = $this->userRepository->updateUser($params);

        if (!$user) {
            return $this->responseRedirectBack(trans('common.update_error'), 'error', true, true);
        }
        return $this->responseRedirect('users.index', trans('common.update_success'), 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $params = $request->except('_token');
        $user = $this->userRepository->deleteUser($id, $params);

        if (!$user) {
            return $this->responseRedirectBack(trans('common.delete_error'), 'error', true, true);
        }
        return $this->responseRedirect('users.index', trans('common.delete_success') ,'success',false, false);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore()
    {
        $users = $this->userRepository->restore();

        if (!$users) {
            return $this->responseRedirectBack(trans('common.restore_error'), 'error', true, true);
        }
        return $this->responseRedirect('users.index', trans('common.restore_success') ,'success',false, false);
    }
}
