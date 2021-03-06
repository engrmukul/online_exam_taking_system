<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    /**
     * @var string
     */
    protected $table = 'roles_permissions';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = [
        'role_id',
        'permission_id',
    ];


}
