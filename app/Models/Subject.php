<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Attribute
 * @package App\Models
 */
class Subject extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'subjects';

    /**
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
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

}
