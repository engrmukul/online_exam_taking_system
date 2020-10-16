<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Attribute
 * @package App\Models
 */
class QuestionPaper extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'question_papers';

    /**
     * @var array
     */
    protected $fillable = [
        'exam_id',
        'question_set',
        'question_ids',
        'generate_by',
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

}
