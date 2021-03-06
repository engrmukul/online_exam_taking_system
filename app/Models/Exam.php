<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Attribute
 * @package App\Models
 */
class Exam extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'exams';

    /**
     * @var array
     */
    protected $fillable = [
        'subject_id',
        'exam_title',
        'exam_date',
        'noq',
        'start_time',
        'end_time',
        'exam_start_date_time',
        'exam_end_date_time',
        'exam_status',
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

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }

    public function admin()
        {
            return $this->belongsTo('App\Models\User', 'created_by');
        }

}
