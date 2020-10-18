<?php

namespace App\Repositories;

use App\Contracts\QuestionPaperContract;
use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionPaper;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Yajra\DataTables\Facades\DataTables;

class QuestionPaperRepository extends BaseRepository implements QuestionPaperContract
{
    /**
     * QuestionPaperRepository constructor.
     * @param QuestionPaper $model
     */
    public function __construct(QuestionPaper $model)
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
    public function listQuestionPaper(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        //return $this->all($columns, $order, $sort);
        $query = $this->all($columns, $order, $sort);
        return Datatables::of($query)->with('exam')
            ->addColumn('action', function ($row) {
                /*$actions = '';

                $actions.= '<a class="btn btn-primary btn-xs float-left mr-1" href="' . route('question-papers.edit', [$row->id]) . '" title="QuestionPaper Edit"><i class="fa fa-pencil"></i> '. trans("common.edit") . '</a>';

                $actions.= '
                    <form action="'.route('question-papers.destroy', [$row->id]).'" method="POST">
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> '. trans("common.delete") . '</button>
                    </form>
                ';

                return $actions;*/
            })
            ->editColumn('exam', function ($row) {
                return $row->exam->exam_title;
            })
            ->make(true);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findQuestionPaperById(int $id)
    {
        try {
            //return $this->findOneOrFail($id);
            return QuestionPaper::with('answers')->findOrFail($id);


        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return QuestionPaper|mixed
     */
    public function createQuestionPaper(array $params)
    {
        try {
            $collection = collect($params);

            //dd($collection);

            //SAVE SET
            $setArray = array();

            foreach ($collection['question_set'] as $key => $set){

                if($collection['generate_by'] == 'custom'){
                    $randQuestion  = $collection['question_ids'];
                    shuffle($randQuestion);
                }

                $setData['exam_id'] = $collection['exam_id'];
                $setData['question_set'] = $set ;
                $setData['question_ids'] = $collection['generate_by'] == 'custom' ? implode(",", $randQuestion) : implode(",", (array_column(Question::select('id')->where('subject_id', $collection['subject_id'])->get()->random($collection['totalquestions'])->toArray(), 'id')));
                $setData['generate_by'] = $collection['generate_by'] ;
                $setData['created_by'] = auth()->user()->id;
                $setData['created_at'] = date('Y-m-d');

                $setArray[] = $setData;
           }

            $questionPaper = QuestionPaper::insert($setArray);

            return $questionPaper;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateQuestionPaper(array $params)
    {
        $question = $this->findQuestionPaperById($params['id']);

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
    public function deleteQuestionPaper($id, array $params)
    {
        $question = $this->findQuestionPaperById($id);

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
