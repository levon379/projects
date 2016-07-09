<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AddonsProduct extends Model {

    protected $fillable = [];

    public function addon()
    {
        return $this->belongsTo('App\Addon','addon_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }

}
