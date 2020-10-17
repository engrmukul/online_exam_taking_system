<?php

namespace App\Repositories;

use App\Contracts\QuestionAssignContract;
use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionAssign;
use App\Models\QuestionPaper;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Yajra\DataTables\Facades\DataTables;

class QuestionAssignRepository extends BaseRepository implements QuestionAssignContract
{
    /**
     * QuestionAssignRepository constructor.
     * @param QuestionAssign $model
     */
    public function __construct(QuestionAssign $model)
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
    public function listQuestionAssign(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        //return $this->all($columns, $order, $sort);
        $query = $this->all($columns, $order, $sort);
        return Datatables::of($query)->with('exam','student','questionPaper')
            ->addColumn('action', function ($row) {
                $actions = '';

                $actions.= '<a class="btn btn-primary btn-xs float-left mr-1" href="' . route('question-assigns.edit', [$row->id]) . '" title="QuestionAssign Edit"><i class="fa fa-pencil"></i> '. trans("common.edit") . '</a>';

                $actions.= '
                    <form action="'.route('question-assigns.destroy', [$row->id]).'" method="POST">
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> '. trans("common.delete") . '</button>
                    </form>
                ';

                return $actions;
            })
            ->editColumn('exam', function ($row) {
                return $row->exam->exam_title;
            })
            ->editColumn('student', function ($row) {
                return $row->student->username;
            })
            ->editColumn('question_paper', function ($row) {
                return $row->questionPaper->question_set;
            })
            ->make(true);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findQuestionAssignById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return QuestionAssign|mixed
     */
    public function createQuestionAssign(array $params)
    {
        try {
            $collection = collect($params);

            //dd($collection);

            //SAVE
            $questionPapers = QuestionPaper::select('id')->where('exam_id', $collection['exam_id'])->get();

            $assignArray = array();

            foreach ($collection['student_id'] as $key => $student){

                $questionPaperIndex = array_rand($questionPapers->toArray(), 1);

                $questionPaperId = $questionPapers->toArray()[$questionPaperIndex]['id'];

                $assignData['exam_id'] = $collection['exam_id'];
                $assignData['student_id'] = $student ;
                $assignData['question_paper_id'] = $questionPaperId ;
                $assignData['created_by'] = auth()->user()->id;
                $assignData['created_at'] = date('Y-m-d');

                $assignArray[] = $assignData;
           }

            $questionAssign = QuestionAssign::insert($assignArray);

            return $questionAssign;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateQuestionAssign(array $params)
    {
        $question = $this->findQuestionAssignById($params['id']);

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
    public function deleteQuestionAssign($id, array $params)
    {
        $question = $this->findQuestionAssignById($id);

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
