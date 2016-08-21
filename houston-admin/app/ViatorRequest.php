<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ViatorRequest extends Model {

	protected $fillable = ['request' ,'response', 'request_json', 'remote_ip'];

}
