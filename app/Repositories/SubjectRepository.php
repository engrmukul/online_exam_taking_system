<?php

namespace App\Repositories;

use App\Models\Subject;
use App\Contracts\SubjectContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Yajra\DataTables\Facades\DataTables;

class SubjectRepository extends BaseRepository implements SubjectContract
{
    /**
     * SubjectRepository constructor.
     * @param Subject $model
     */
    public function __construct(Subject $model)
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
    public function listSubject(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        //return $this->all($columns, $order, $sort);
        $query = $this->all($columns, $order, $sort);
        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                $actions.= '<a class="btn btn-primary btn-xs float-left mr-1" href="' . route('subjects.edit', [$row->id]) . '" title="Subject Edit"><i class="fa fa-pencil"></i> '. trans("common.edit") . '</a>';

                $actions.= '
                    <form action="'.route('subjects.destroy', [$row->id]).'" method="POST">
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
    public function findSubjectById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return Subject|mixed
     */
    public function createSubject(array $params)
    {
        try {
            $collection = collect($params);

            $created_by = auth()->user()->id;
            
            $merge = $collection->merge(compact('created_by'));

            $subject = new Subject($merge->all());

            $subject->save();

            return $subject;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSubject(array $params)
    {
        $subject = $this->findSubjectById($params['id']);

        $collection = collect($params)->except('_token');

        $updated_by = auth()->user()->id;

        $merge = $collection->merge(compact('updated_by'));

        $subject->update($merge->all());

        return $subject;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteSubject($id, array $params)
    {
        $subject = $this->findSubjectById($id);

        $subject->delete();

        $collection = collect($params)->except('_token');

        $deleted_by = auth()->user()->id;

        $merge = $collection->merge(compact('deleted_by'));

        $subject->update($merge->all());

        return $subject;
    }

    /**
     * @return mixed
     */
    public function restore()
    {
        return $this->restoreOnlyTrashed();
    }
}
