<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Attribute
 * @package App\Models
 */
class Question extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'questions';

    /**
     * @var array
     */
    protected $fillable = [
        'subject_id',
        'question',
        'image',
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
        return $this->hasOne(Subject::class,'id','subject_id');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }

}
