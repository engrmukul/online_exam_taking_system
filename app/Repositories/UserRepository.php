<?php

namespace App\Repositories;

use App\Models\User;
use App\Contracts\UserContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
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
        if(auth()->user()->role == 'owner'){
            $query = $this->shopWiseAllData();
        }elseif(auth()->user()->role == 'system_admin'){
            $query = $this->model->select();
        }

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

            $shop_id = auth()->user()->shop_id;

            $merge = $collection->merge(compact('created_by', 'shop_id'));

            $user = new User($merge->all());

            $user->save();

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

        $updated_by = auth()->user()->id;

        $merge = $collection->merge(compact('updated_by'));

        $user->update($merge->all());

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
