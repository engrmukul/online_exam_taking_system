<?php

namespace App\Repositories;

use App\Contracts\PermissionContract;
use App\Models\Permission;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PermissionRepository extends BaseRepository implements PermissionContract
{
    /**
     * PermissionRepository constructor.
     * @param Permission $model
     */
    public function __construct(Permission $model)
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
    public function listPermission(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        $query = $this->all($columns, $order, $sort);
        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                $actions.= '<a class="btn btn-primary btn-xs float-left mr-1" href="' . route('permissions.edit', [$row->id]) . '" title="Permission Edit"><i class="fa fa-pencil"></i> '. trans("common.edit") . '</a>';

                $actions.= '
                    <form action="'.route('permissions.destroy', [$row->id]).'" method="POST">
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
    public function findPermissionById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return Permission|mixed
     */
    public function createPermission(array $params)
    {
        try {
            $collection = collect($params);

            $created_by = auth()->user()->id;

            $slug = Str::slug($collection['slug'], '_');

            $merge = $collection->merge(compact('created_by','slug'));

            $permission = new Permission($merge->all());

            $permission->save();

            return $permission;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePermission(array $params)
    {
        $permission = $this->findPermissionById($params['id']);

        $collection = collect($params)->except('_token');

        $updated_by = auth()->user()->id;

        $slug = Str::slug($collection['slug'], '_');

        $merge = $collection->merge(compact('updated_by','slug'));

        $permission->update($merge->all());

        return $permission;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deletePermission($id, array $params)
    {
        $permission = $this->findPermissionById($id);

        $permission->delete();

        $collection = collect($params)->except('_token');

        $deleted_by = auth()->user()->id;

        $merge = $collection->merge(compact('deleted_by'));

        $permission->update($merge->all());

        return $permission;
    }

    /**
     * @return mixed
     */
    public function restore()
    {
        return $this->restoreOnlyTrashed();
    }
}
