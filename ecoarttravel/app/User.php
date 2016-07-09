<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
    //protected $primaryKey = 'user_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['firstname', 'lastname', 'username', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    public $true = "<i class='fa fa-check text-success'></i>";
    public $false = "<i class='fa fa-times text-danger'></i>";


    public function getDateAdded(){
        return $this->created_at->format('m/d/Y');
    }

    public function getDisabled(){
        return $this->disabled ? $this->true : $this->false;
    }

    public function getEnabled(){
        // reverse of above , to understand it on the front end
        return $this->disabled ? $this->false : $this->true;
    }

    public function getPatentino(){

        // 3 is for guides
        if($this->user_type_id === 3){
            return $this->patentino ? $this->true : $this->false;
        }
        return "";
    }

    public function getNcc(){
        // 3 is for guides
        if($this->user_type_id === 3){
            return $this->ncc ?  $this->true : $this->false;
        }
        return "";
    }

    public function type()
    {
        // foreign key here
        return $this->belongsTo('App\UserType','user_type_id');
    }

    public function languages(){
        return $this->belongsToMany('App\Language','users_languages');
    }

    public function getLanguages(){
        $languages = $this->languages;

        $language_list = array();

        foreach($languages as $language){
            $language_list[] = $language->name;
        }

        $language_string = implode(", ",$language_list);
        return $language_string;
    }
	
	public function getName(){
		return $this->firstname . ' ' . $this->lastname;
	}

}
