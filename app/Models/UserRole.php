<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * @var string
     */
    protected $table = 'users_roles';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role_id',
    ];

    /**
     * @var array
     */
    protected $casts  = [

    ];

}
