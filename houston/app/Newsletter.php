<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model {

    protected $table = "newsletter";

    public $timestamps = false;

	protected $fillable = [];

    public static $rules = array(
        "email" => "required|email|unique:newsletter",
        "website" => "required"
        );

}
