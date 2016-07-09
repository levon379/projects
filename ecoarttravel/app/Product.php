<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model {

	protected $fillable = [];

    public function provider()
    {
        // foreign key here
        return $this->belongsTo('App\Provider','provider_id');
    }

    public function city()
    {
        // foreign key here
        return $this->belongsTo('App\DepartureCity','departure_city_id');
    }

    public function type()
    {
        // foreign key here
        return $this->belongsTo('App\ProductType','product_type_id');
    }


    public function user()
    {
        // foreign key here
        return $this->belongsTo('App\User','user_id');
    }

    public function categories(){
        return $this->belongsToMany('App\Category','products_categories' , 'product_id','category_id');
    }

    public function recommendedProducts(){
        return $this->belongsToMany('App\Product','product_recommended_products' , 'product_id','recommend_id');
    }

    public function options(){
        return $this->hasMany('App\ProductOption','product_id' , 'id');
    }

    public function language_details(){
        return $this->hasMany('App\ProductLanguageDetail','product_id' , 'id');
    }

    public function reviews(){
        return $this->hasMany('App\Review','product_id' , 'id');
    }

    public function getNameOfUser(){

        $firstname = $this->user->firstname;
        $lastname = $this->user->lastname;

        return $lastname.", ".$firstname;
    }
}
