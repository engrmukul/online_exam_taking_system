<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Attribute
 * @package App\Models
 */
class Answer extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'answers';

    /**
     * @var array
     */
    protected $fillable = [
        'question_id',
        'answer',
        'is_correct',
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
        return $this->hasMany('App\Models\Answer');
    }

}
