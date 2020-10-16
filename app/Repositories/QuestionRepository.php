<?php

namespace App\Repositories;

use App\Contracts\QuestionContract;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Yajra\DataTables\Facades\DataTables;

class QuestionRepository extends BaseRepository implements QuestionContract
{
    /**
     * QuestionRepository constructor.
     * @param Question $model
     */
    public function __construct(Question $model)
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
    public function listQuestion(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        //return $this->all($columns, $order, $sort);
        $query = $this->all($columns, $order, $sort);
        return Datatables::of($query)->with('subject')
            ->addColumn('action', function ($row) {
                $actions = '';

                $actions.= '<a class="btn btn-primary btn-xs float-left mr-1" href="' . route('questions.edit', [$row->id]) . '" title="Question Edit"><i class="fa fa-pencil"></i> '. trans("common.edit") . '</a>';

                $actions.= '
                    <form action="'.route('questions.destroy', [$row->id]).'" method="POST">
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
    public function findQuestionById(int $id)
    {
        try {
            //return $this->findOneOrFail($id);
            return Question::with('answers')->findOrFail($id);


        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return Question|mixed
     */
    public function createQuestion(array $params)
    {
        try {
            $collection = collect($params);

           // dd($collection);

            $created_by = auth()->user()->id;
            
            $merge = $collection->merge(compact('created_by'));

            $question = new Question($merge->all());

            $question->save();

            //SAVE ANSWERS
            $answerArray = array();
            foreach ($collection['answer'] as $key => $answer){
                $answerData['question_id'] = $question->id;
                $answerData['answer'] = $collection['answer'][$key] ;
                $answerData['is_correct'] = ($collection['is_correct'] == intval($key + 1)) ? '1' : '0';
                $answerData['created_by'] = $created_by;
                $answerData['created_at'] = date('Y-m-d');

                $answerArray[] = $answerData;
           }

            Answer::insert($answerArray);

            return $question;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateQuestion(array $params)
    {
        $question = $this->findQuestionById($params['id']);

        $collection = collect($params)->except('_token');

        $updated_by = auth()->user()->id;

        $merge = $collection->merge(compact('updated_by'));

        $question->update($merge->all());

        //SAVE ANSWERS
        $answerArray = array();
        foreach ($collection['answer'] as $key => $answer){
            $answerData['question_id'] = $question->id;
            $answerData['answer'] = $collection['answer'][$key] ;
            $answerData['is_correct'] = ($collection['is_correct'] == intval($key + 1)) ? '1' : '0';
            $answerData['created_by'] = $updated_by;
            $answerData['created_at'] = date('Y-m-d');

            $answerArray[] = $answerData;
        }

        $answerObj = new Answer();

        $answerObj::where('question_id', $question->id)->delete();

        $answerObj::insert($answerArray);

        return $question;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteQuestion($id, array $params)
    {
        $question = $this->findQuestionById($id);

        $question->delete();

        $collection = collect($params)->except('_token');

        $deleted_by = auth()->user()->id;

        $merge = $collection->merge(compact('deleted_by'));

        $question->update($merge->all());

        return $question;
    }

    /**
     * @return mixed
     */
    public function restore()
    {
        return $this->restoreOnlyTrashed();
    }
}
