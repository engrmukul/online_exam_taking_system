<?php

namespace App\Repositories;

use App\Models\RoleMenu;
use App\Models\User;
use App\Contracts\UserContract;
use App\Models\UserRole;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserRepository extends BaseRepository implements UserContract
{
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listUser(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        $query = $this->model->select();
        return Datatables::of($query)->with('roles')
            ->addColumn('action', function ($row) {
                $actions = '';

                $actions.= '<a class="btn btn-primary btn-xs float-left mr-1" href="' . route('users.edit', [$row->id]) . '" title="User Edit"><i class="fa fa-pencil"></i>'. trans("common.edit") . '</a>';

                $actions.= '
                    <form action="'.route('users.destroy', [$row->id]).'" method="POST">
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i>'. trans("common.delete") . '</button>
                    </form>
                ';

                return $actions;
            })
            ->editColumn('role', function ($row) {
                return implode(",", array_column($row->roles->toArray(), "name"));
            })
            ->make(true);
    }


    public function listStudentUser(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        $query = $this->model->with('roles')->select();
        $query->whereHas('roles', function ($q) {
            $q->where('slug', 'student');
        });
        return Datatables::of($query)

            ->addColumn('action', function ($row) {
                $actions = '';

                $actions.= '<a class="btn btn-primary btn-xs float-left mr-1" href="' . route('users.edit', [$row->id]) . '" title="User Edit"><i class="fa fa-pencil"></i>'. trans("common.edit") . '</a>';

                $actions.= '
                    <form action="'.route('users.destroy', [$row->id]).'" method="POST">
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i>'. trans("common.delete") . '</button>
                    </form>
                ';

                return $actions;
            })
            ->editColumn('role', function ($row) {
                return implode(",", array_column($row->roles->toArray(), "name"));
            })
            ->make(true);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return User|mixed
     */
    public function createUser(array $params)
    {
        try {
            $collection = collect($params);

            $created_by = auth()->user()->id;

            $password = Hash::make($collection['password']);

            $merge = $collection->merge(compact('created_by','password'));

            $user = new User($merge->all());

            $user->save();

            //SAVE ROLE PERMISSION
            $userRoleArray = array();
            foreach ($collection['role_id'] as $key => $rid){
                $urData['user_id'] = $user->id;
                $urData['role_id'] = $rid ;

                $userRoleArray[] = $urData;
            }

            $userRoleObj = new UserRole();

            $userRoleObj::insert($userRoleArray);

            //SAVE MENU
            $roleMenuArray = array();
            foreach ($collection['role_id'] as $key => $roleId){
                foreach ($collection['menu_id'] as $mkey => $menuId){
                    $rmData['role_id'] = $roleId;
                    $rmData['menu_id'] = $menuId;

                    $roleMenuArray[] = $rmData;
                }
            }

            $roleMenuObj = new RoleMenu();

            $roleMenuObj::insert($roleMenuArray);


            return $user;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateUser(array $params)
    {
        $user = $this->findUserById($params['id']);

        $collection = collect($params)->except('_token');

        $password = Hash::make($collection['password']);

        $updated_by = auth()->user()->id;

        $merge = $collection->merge(compact('updated_by', 'password'));

        $user->update($merge->all());

        //UPDATE ROLE
        $userRoleArray = array();
        foreach ($collection['role_id'] as $key => $rid){
            $urData['user_id'] = $user->id;
            $urData['role_id'] = $rid;

            $userRoleArray[] = $urData;
        }

        $userRoleObj = new UserRole();

        $userRoleObj::where('user_id', $user->id)->delete();

        $userRoleObj::insert($userRoleArray);


        //SAVE MENU
        $roleMenuObj = new RoleMenu();
        $roleMenuArray = array();
        foreach ($collection['role_id'] as $key => $roleId){
            foreach ($collection['menu_id'] as $mkey => $menuId){
                $rmData['role_id'] = $roleId;
                $rmData['menu_id'] = $menuId;

                $roleMenuArray[] = $rmData;
            }
            $roleMenuObj::where('role_id', $roleId)->delete();
        }

        $roleMenuObj::insert($roleMenuArray);


        return $user;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteUser($id, array $params)
    {
        $user = $this->findUserById($id);

        $user->delete();

        $collection = collect($params)->except('_token');

        $deleted_by = auth()->user()->id;

        $merge = $collection->merge(compact('deleted_by'));

        $user->update($merge->all());

        return $user;
    }
}
