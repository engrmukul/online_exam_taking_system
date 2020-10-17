<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Attribute
 * @package App\Models
 */
class QuestionAssign extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'question_assigns';

    /**
     * @var array
     */
    protected $fillable = [
        'exam_id',
        'student_id',
        'question_paper_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * @var array
     */
    protected $casts  = [

    ];

    public function exam()
    {
        return $this->hasOne(Exam::class,'id','exam_id');
    }

    public function student()
    {
        return $this->hasOne(User::class,'id','student_id');
    }

    public function questionPaper()
    {
        return $this->hasOne(QuestionPaper::class,'id','question_paper_id');
    }

}
