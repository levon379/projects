<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model {

	protected $fillable = [];

    public function type()
    {
        // foreign key here
        return $this->belongsTo('App\ServiceType','service_type_id');
    }
	
	public function options(){
        return $this->hasMany('App\ServiceOption','service_id' , 'id');
    }
}
