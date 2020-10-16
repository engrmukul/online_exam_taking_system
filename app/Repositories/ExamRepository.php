<?php

namespace App\Repositories;

use App\Contracts\ExamContract;
use App\Models\Exam;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Yajra\DataTables\Facades\DataTables;

class ExamRepository extends BaseRepository implements ExamContract
{
    /**
     * ExamRepository constructor.
     * @param Exam $model
     */
    public function __construct(Exam $model)
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
    public function listExam(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        //return $this->all($columns, $order, $sort);
        $query = $this->all($columns, $order, $sort);
        return Datatables::of($query)->with('subject')
            ->addColumn('action', function ($row) {
                $actions = '';

                $actions.= '<a class="btn btn-primary btn-xs float-left mr-1" href="' . route('exams.edit', [$row->id]) . '" title="Exam Edit"><i class="fa fa-pencil"></i> '. trans("common.edit") . '</a>';

                $actions.= '
                    <form action="'.route('exams.destroy', [$row->id]).'" method="POST">
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> '. trans("common.delete") . '</button>
                    </form>
                ';

                return $actions;
            })
            ->editColumn('subject', function ($row) {
                return $row->subject->name;
            })
            ->make(true);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findExamById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return Exam|mixed
     */
    public function createExam(array $params)
    {
        try {
            $collection = collect($params);

            $created_by = auth()->user()->id;
            
            $merge = $collection->merge(compact('created_by'));

            $subject = new Exam($merge->all());

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
    public function updateExam(array $params)
    {
        $subject = $this->findExamById($params['id']);

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
    public function deleteExam($id, array $params)
    {
        $subject = $this->findExamById($id);

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
