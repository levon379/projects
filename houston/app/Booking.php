<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

	protected $fillable = [];
    protected $dates = ['feedback_request_sent_date'];

    public $true = "<i class='fa fa-check text-success'></i>";
    public $false = "<i class='fa fa-times text-danger'></i>";
	
	public function product_option()
    {
        // foreign key here
        return $this->belongsTo('App\ProductOption','product_option_id');
    }
	
	public function promo()
    {
        // foreign key here
        return $this->belongsTo('App\Promo','promo_id');
    }

	public function payment_method()
    {
        // foreign key here
        return $this->belongsTo('App\PaymentMethod','payment_method_id');
    }

	public function source_name()
    {
        // foreign key here
        return $this->belongsTo('App\SourceName','source_name_id');
    }

    public function language()
    {
        // foreign key here
        return $this->belongsTo('App\Language','language_id');
    }
	
	public function user()
    {
        // foreign key here
        return $this->belongsTo('App\User','user_id');
    }
	
	public function guide_user()
    {
        // foreign key here
        return $this->belongsTo('App\User','guide_user_id');
    }
	
	public function currency()
    {
        // foreign key here
        return $this->belongsTo('App\Currency','currency_id');
    }


    public function addons(){
        return $this->hasMany('App\BookingAddon','booking_id');
    }


    public function clients(){
        return $this->hasMany('App\BookingClient','booking_id' , 'id');
    }

    public function comments(){
        return $this->hasMany('App\BookingComment','booking_id' , 'id');
    }

	public function getNameOfUser(){

        $firstname = $this->user->firstname;
        $lastname = $this->user->lastname;

        return $lastname.", ".$firstname;
    }
	
	public function getNameOfGuideUser(){

        $guide = $this->guide_user;

        if(!empty($guide)){

            $firstname = $this->guide_user->firstname;
            $lastname = $this->guide_user->lastname;
            return $lastname.", ".$firstname;
        }

    }

    public function getProductName(){
       $product = $this->product_option->product->name;
       $option = $this->product_option->name;


       return "$product ($option)";
    }

    public function getProductOptionLanguage(){
        $language = $this->getLanguage();
        $productName = $this->product_option->product->name;
        if(!empty($language)){
            return $productName." - ".$this->product_option->name." - $language";
        }

        return $productName." - ".$this->product_option->name;
    }

    public function getLanguage(){
        if($this->language != null){
            return $this->language->name;

        }
        return "";
    }

    public function getPaid(){
        return $this->paid_flag ? $this->true : $this->false;
    }

    public function getPaidValue(){
        return $this->paid_flag ? 1 : 0;
    }

    public function getReviewedValue(){
        return $this->feedback_request_sent > 0 ? 1 : 0;
    }

    public function getReviewed(){
        return $this->feedback_request_sent > 0 ? $this->true : $this->false;

    }

}
