<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOption extends Model {

	protected $fillable = [];

    public function service()
    {
        // foreign key here
        return $this->belongsTo('App\Service','service_id');
    }
}
