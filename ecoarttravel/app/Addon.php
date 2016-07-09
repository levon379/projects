<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model {

	protected $fillable = ['addon_id'];

    public function products(){
        return $this->belongsToMany('App\Product','addons_products' , 'addon_id','product_id');
    }
}
