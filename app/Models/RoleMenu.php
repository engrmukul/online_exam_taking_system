<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    /**
     * @var string
     */
    protected $table = 'roles_menus';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'role_id',
        'menu_id',
    ];

    /**
     * @var array
     */
    protected $casts  = [

    ];

    public function menus() {

        return $this->hasMany('App\Models\Menu');

    }
}
