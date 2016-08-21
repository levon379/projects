<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activation_code'
    ];

    /**
     * User status
     *
     * @var array
     */
    public static $statuses = array(
        0 => ['text' => 'Pending', 'class' => 'warning'],
        1 => ['text' => 'Activated', 'class' => 'success'],
        2 => ['text' => 'Suspended', 'class' => 'danger'],
    );

    /* ================== Scopes ================== */


    /* ================== Relations ================== */

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permissions::class);
    }


    /* ================== Helpers ================== */

    public function hasPermissions($permission)
    {
        if (is_array($permission)) {
            
        }
        
    }

}
