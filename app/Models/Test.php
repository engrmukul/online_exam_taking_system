<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Attribute
 * @package App\Models
 */
class Test extends Model
{
    /**
     * @var string
     */
    protected $table = 'tests';

    /**
     * @var array
     */
    protected $fillable = [
        'exam_id',
        'student_id',
        'question_id',
        'answer_id',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $casts  = [

    ];

    public function questions() {

        return $this->belongsTo('App\Models\Question', 'question_id');
    }

    public function answers() {

        return $this->belongsTo('App\Models\Answer', 'answer_id');
    }

}
