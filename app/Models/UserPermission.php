<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    /**
     * @var string
     */
    protected $table = 'users_permissions';
    public $timestamps = false;

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
