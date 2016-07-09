<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model {

    protected $table = "user_types";

    const ADMIN = 1;
    const OFFICE = 2;
    const GUIDE = 3;

	protected $fillable = [];

}
