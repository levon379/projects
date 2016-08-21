<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model {

	protected $fillable = [];
	
	public function promo_type()
    {
        // foreign key here
        return $this->belongsTo('App\PromoType','promo_type_id');
    }
	
	public function websites(){
        return $this->belongsToMany('App\Website','promos_websites' , 'promo_id','website_id');
    }

    public function promos_products(){
        return $this->hasMany('App\PromosProduct','promo_id');
    }

}
