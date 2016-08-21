<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\ProductImagePlacement;
use Illuminate\Support\Collection;

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

    public function images(){
        return $this->hasMany('App\ProductImage','product_id' , 'id');
    }

    public function videos(){
        return $this->hasMany('App\ProductVideo','product_id' , 'id');
    }

    public function reviews(){
        return $this->hasMany('App\Review');
    }

    public function languages(){
        return $this->belongsToManyThrough('App\Language', 'App\ProductOption', 'product_id', 'language_id');
    }


    public function faqs(){
        return $this->belongsToMany('App\Faq', 'faqs_products', 'product_id');
    }

    public function language_details(){
        return $this->hasMany('App\ProductLanguageDetail','product_id' , 'id');
    }
    
    public function languageDetail(  ){
        return $this->hasOne('App\ProductLanguageDetail','product_id' , 'id');
    }

    public function getNameOfUser(){

        $firstname = $this->user->firstname;
        $lastname = $this->user->lastname;

        return $lastname.", ".$firstname;
    }

    public function averageRating()
    {
      return $this->hasOne('App\Review')
        ->selectRaw('product_id, avg(rating) as aggregate')
        ->whereFlagShow(1)
        ->groupBy('product_id');
    }
     
    public function getAverageRatingAttribute()
    {
      // if relation is not loaded already, let's do it first
      if ( ! array_key_exists('averageRating', $this->relations)) 
        $this->load('averageRating');
     
      $related = $this->getRelation('averageRating');
     
      // then return the aggregate directly
      return ($related) ? (int) $related->aggregate : 0;
    }

    public function runningDays()
    {
      return $this->hasOne('App\ProductOption')
        ->selectRaw('product_id, LPAD(CONV(BIT_OR(CONV(running_days, 2, 10)), 10, 2), 7, 0) as aggregate');
    }
     
    public function getRunningDaysAttribute()
    {
        // if relation is not loaded already, let's do it first
        //if ( ! array_key_exists('runningDays', $this->relations)) 
        $this->load('runningDays');
     
        $related = $this->getRelation('runningDays');

        // then return the aggregate directly
        return ($related) ? $related->aggregate : '0000000';
    }

    public function reviewsCount()
    {
      return $this->hasOne('App\Review')
        ->selectRaw('product_id, count(id) as aggregate')
        ->groupBy('product_id');
    }
     
    public function getReviewsCountAttribute()
    {
      // if relation is not loaded already, let's do it first
      if ( ! array_key_exists('reviewsCount', $this->relations)) 
        $this->load('reviewsCount');
     
        $related = $this->getRelation('reviewsCount');
     
      // then return the aggregate directly
      return ($related) ? (int) $related->aggregate : 0;
    }

    public function departureCityDetails(){
        return $this->belongsTo('App\DepartureCityLanguageDetail','departure_city_id');
    }

    public function getUrl(){
        if(isset($this->departureCityDetails->slug) && isset($this->language_details->first()->url)){
            return url("/en/{$this->departureCityDetails->slug}/{$this->language_details->first()->url}");
        }
        return "#";
    }

    public function getBigImage(){
        $sql = "SELECT * FROM product_images AS p_i
                LEFT JOIN product_images_product_image_placements AS pipip ON pipip.product_image_id = p_i.`id`
                LEFT JOIN product_image_placements AS pip ON pip.id = pipip.product_image_placement_id
                WHERE pip.id = 1 AND product_id = 2";
        //$image = DB::select($sql);
        //dd($image);
        $bigPlacement = ProductImagePlacement::bigImagePlacement()->product()->where("product_images.product_id", $this->id)->first();
        return $bigPlacement;
    }

    public function getImage( $type ){
        $sql = "SELECT * FROM product_images AS p_i
                LEFT JOIN product_images_product_image_placements AS pipip ON pipip.product_image_id = p_i.`id`
                LEFT JOIN product_image_placements AS pip ON pip.id = pipip.product_image_placement_id
                WHERE pip.id = 1 AND product_id = 2";
        //$image = DB::select($sql);
        //dd($image);
        $bigPlacement = ProductImagePlacement::imagePlacement($type)->product()->where("product_images.product_id", $this->id)->first();
        return $bigPlacement;
    }

    public function getImages( $type ){
        $bigPlacement = ProductImagePlacement::imagePlacement($type)->product()->where("product_images.product_id", $this->id)->get();
        return $bigPlacement;
    }

    public function getImageUrl($image, $type = "neutral", $default = ""){
        if(isset($image->hash)){
            return url("images/{$image->hash}/{$type}");
        }
        return $default;
    }

    public function productOptionLanguages(){
        return $this->hasManyThrough('App\ProductOptionLanguage', 'App\ProductOption');
    }

    public function gLangs(){
        $languages = $this->productOptionLanguages;

        dd($languages->toArray());exit;
    }

    public function getOptionsCommonUnavailableDays()
    {
        
        $productId = $this->id;  // $this = product

        $query = "
            SELECT POUD.date AS off_date
            FROM `product_options_unavailable_days` AS POUD
            WHERE `product_option_id` IN (
                SELECT PO.id
                FROM `product_options` AS PO
                WHERE PO.`product_id` = $productId
            ) 
            GROUP BY `date` 
            HAVING COUNT(`date`) = (
                SELECT COUNT(PO.id)
                FROM `product_options` AS PO
                WHERE PO.`product_id` = $productId
            ) ;
        ";

        $offDates = collect(\DB::select( $query ))->lists("off_date");
        //echo "<pre>";print_r($offDates);exit;

        return $offDates;
    }

    public function getOptionsCommonLanguageUnavailableDays()
    {
        
        $productId = $this->id;  // $this = product

        $query = "
            SELECT POLUD.date AS off_date 
            FROM `product_options_languages_unavailable_days` AS POLUD
            WHERE `product_options_language_id` IN (
                SELECT POL.id
                FROM `product_options_languages` AS POL
                JOIN product_options AS PO ON PO.id = POL.`product_option_id`
                WHERE PO.`product_id` = '$productId'
            ) 
            GROUP BY `date` 
            HAVING COUNT(`date`) = (
                SELECT COUNT(POL.id)
                FROM `product_options_languages` AS POL
                JOIN product_options AS PO ON PO.id = POL.`product_option_id`
                WHERE PO.`product_id` = '$productId'
            )
        ";

        $offDates = collect(\DB::select( $query ))->lists("off_date");
        //echo "<pre>";print_r($result);exit;

        return $offDates;
    }

    // public function optionsCommonLanguageUnavailableDays()
    // {
    //     //dd($this->toArray());
    //     // \DB::enableQueryLog();
    //     // $this->load('productOptionLanguages');
    //     // $optionLanguages = $this->productOptionLanguages;
    //     // dd($optionLanguages);exit;
    //     // $optionLanguageIds = $optionLanguages->lists("id");


    //     // OPTION LANGUAGE IDS PULLED 
    //     // NOW NEED TO PULL UNAVAILABLE DATES

    //     $this->load('options');
    //     $languages =  $this->options()->productOptionLanguages()->get();
    //     dd($languages->toArray());exit;
    //   return $this->hasMany('App\ProductOptionLanguageUnavailableDay')
    //     ->selectRaw('product_id, count(id) as aggregate')
    //     ->groupBy('product_id');
    // }
     
    // public function getOptionsCommonLanguageUnavailableDaysAttribute()
    // {
    //   // if relation is not loaded already, let's do it first
    //   if ( ! array_key_exists('optionsCommonLanguageUnavailableDays', $this->relations)) 
    //     $this->load('optionsCommonLanguageUnavailableDays');
     
    //     $related = $this->getRelation('optionsCommonLanguageUnavailableDays');
     
    //   // then return the aggregate directly
    //   return ($related) ? (int) $related->aggregate : 0;
    // }



}
