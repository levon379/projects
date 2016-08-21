<?php namespace App;

use App\Libraries\Helpers;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model {

	protected $fillable = [];
	
	public $timestamps = false;

    public function unavailable(){
        return $this->hasMany('App\ProductOptionUnavailableDay','product_option_id' , 'id');
    }

    public $true = "<i class='fa fa-check text-success'></i>";
    public $false = "<i class='fa fa-times text-danger'></i>";

    public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }

    public function availslot()
    {
        return $this->belongsTo('App\AvailabilitySlot','availability_slot_id');
    }

    public function promo()
    {
        return $this->belongsTo('App\Promo','promo_id');
    }

    public function language()
    {
        return $this->belongsTo('App\Language','language_id');
    }
	
	public function languages(){
        return $this->belongsToMany('App\Language','product_options_languages' , 'product_option_id','language_id');
    }

    public function options(){
        return $this->belongsToMany('App\ProductOption','product_package_options' , 'product_option_id','package_id');
    }

    public function getPrivate(){
        return $this->private ? $this->true : $this->false;
    }

    public function getPackage(){
        return $this->package_flag ? $this->true : $this->false;
    }

    public function getPromo(){
        if($this->promo !=null)
            return $this->promo->name;
        return "";
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

    public function getProductOptionName(){
        return $this->product->name." - ".$this->name;
    }

    public function getNameWithFromTo(){
        $dateFrom = Helpers::displayTableDate($this->trav_season_start);
        $dateTo = Helpers::displayTableDate($this->trav_season_end);
        if($dateFrom == "All dates"){
            return "$this->name - (All dates)";
        }
        return "$this->name - ($dateFrom - $dateTo)";
    }

	public function getShown(){
        return $this->flag_show ? $this->true : $this->false;
    }

    public function getOnRequest(){
        return $this->on_request_flag ? $this->true : $this->false;
    }

    public function getFixedPrice(){
        return $this->fixed_price_flag ? $this->true : $this->false;
    }
}
