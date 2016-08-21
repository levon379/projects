<?php namespace App;

use App\Libraries\Helpers;
use Illuminate\Database\Eloquent\Model;

class ProductLanguageDetail extends Model {

    protected $fillable = [];

    public function language()
    {
        return $this->belongsTo('App\Language','language_id');
    }

    public function websites(){
        return $this->belongsToMany('App\Website','product_language_details_websites' , 'product_language_detail_id','website_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }

    public function unavailable(){
        return $this->hasMany('App\ProductLanguageDetailsUnavailableDay','product_language_detail_id' , 'id');
    }

    public function getUnavailableDays(){
        $date_list = $this->unavailable;
        $dates = array();
        foreach($date_list as $date){
            $dates[] = Helpers::displayDate($date->date);
        }
        return implode(",",$dates);
    }

    public function getUnavailableDaysArray(){
        $date_list = $this->unavailable;
        $dates = array();
        foreach($date_list as $date){
            $dates[] = $date->date;
        }
        return $dates;
    }
}
