<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model {

	protected $fillable = [];
	
	public function language()
    {
        return $this->belongsTo('App\Language','language_id');
    }
	
	public function websites(){
        return $this->belongsToMany('App\Website','faqs_websites' , 'faq_id','website_id');
    }

    public function products(){
        return $this->belongsToMany('App\Product', 'faqs_products','faq_id', 'product_id');
    }

}
