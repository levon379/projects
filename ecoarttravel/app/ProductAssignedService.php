<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAssignedService extends Model {

    public function serviceOption()
    {
        return $this->belongsTo('App\ServiceOption','service_option_id');
    }
} 