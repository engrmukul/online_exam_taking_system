<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
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

	public function permissions() {

	   return $this->belongsToMany(Permission::class,'roles_permissions');
	       
	}

	public function users() {

	   return $this->belongsToMany(User::class,'users_roles');
	       
	}
}
