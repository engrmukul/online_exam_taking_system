<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPermission extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'user_permissions';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'permission_id',
    ];

    /**
     * @var array
     */
    protected $casts  = [

    ];

}
