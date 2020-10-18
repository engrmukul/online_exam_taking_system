<?php

namespace App\Repositories;

use App\Contracts\RoleContract;
use App\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Yajra\DataTables\Facades\DataTables;

class RoleRepository extends BaseRepository implements RoleContract
{
    /**
     * RoleRepository constructor.
     * @param Role $model
     */
    public function __construct(Role $model)
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
    public function listRole(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        $query = $this->all($columns, $order, $sort);
        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                $actions.= '<a class="btn btn-primary btn-xs float-left mr-1" href="' . route('roles.edit', [$row->id]) . '" title="Role Edit"><i class="fa fa-pencil"></i> '. trans("common.edit") . '</a>';

                $actions.= '
                    <form action="'.route('roles.destroy', [$row->id]).'" method="POST">
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> '. trans("common.delete") . '</button>
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
    public function findRoleById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return Role|mixed
     */
    public function createRole(array $params)
    {
        try {
            $collection = collect($params);

            $created_by = auth()->user()->id;

            $slug = str_slug($collection['slug'], "_");

            $merge = $collection->merge(compact('created_by','slug'));

            $role = new Role($merge->all());

            $role->save();

            return $role;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateRole(array $params)
    {
        $role = $this->findRoleById($params['id']);

        $collection = collect($params)->except('_token');

        $updated_by = auth()->user()->id;

        $slug = str_slug($collection['slug'], "_");

        $merge = $collection->merge(compact('updated_by','slug'));

        $role->update($merge->all());

        return $role;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteRole($id, array $params)
    {
        $role = $this->findRoleById($id);

        $role->delete();

        $collection = collect($params)->except('_token');

        $deleted_by = auth()->user()->id;

        $merge = $collection->merge(compact('deleted_by'));

        $role->update($merge->all());

        return $role;
    }

    /**
     * @return mixed
     */
    public function restore()
    {
        return $this->restoreOnlyTrashed();
    }
}
