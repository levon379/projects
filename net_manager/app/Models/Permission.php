<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name', 'code', 'description'
    ];

    /* ================== Relations ================== */

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions', 'role_id', 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id');
    }
}

