<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Contracts\UserContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreUserFormRequest;
use App\Http\Requests\UpdateUserFormRequest;

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
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle('Users', 'Users List');
        $data = [
            'tableHeads' => [ trans('user.SN'), trans('user.name'), trans('user.mobile'), trans('user.username'), trans('user.email'),trans('user.role'),trans('user.status')],
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Users', 'Create User');
        return view('users.create');
    }

    /**
     * @param StoreUserFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserFormRequest $request)
    {
        $params = $request->except('_token');

        $user = $this->userRepository->createUser($params);

        if (!$user) {
            return $this->responseRedirectBack(trans('category.create_error'), 'error', true, true);
        }
        return $this->responseRedirect('users.index', 'User added successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->userRepository->findUserById($id);

        $this->setPageTitle('Users', 'Edit User');
        return view('users.edit', compact('user'));
    }

    /**
     * @param UpdateUserFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserFormRequest $request, User $userModel)
    {
        $params = $request->except('_token');

        $user = $this->userRepository->updateUser($params);

        if (!$user) {
            return $this->responseRedirectBack('Error occurred while updating User.', 'error', true, true);
        }
        return $this->responseRedirect('users.index', 'User updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        $params = $request->except('_token');
        $user = $this->userRepository->deleteUser($id, $params);

        if (!$user) {
            return $this->responseRedirectBack('Error occurred while deleting user.', 'error', true, true);
        }
        return $this->responseRedirect('users.index', 'User deleted successfully' ,'success',false, false);
    }
}
