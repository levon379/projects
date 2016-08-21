<?php namespace App\Libraries;

use App\Libraries\Repositories\AddonsRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class Helpers {

    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            Log::error("DeleteDir: $dirPath must be a directory");
            return;
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public static function deleteFileHash($id,$fileHash) {
        $dirPath = storage_path()."/uploads/products/$id/";
        $files = glob($dirPath . "$fileHash*.*", GLOB_MARK);
        foreach ($files as $file) {
           unlink($file);
        }
    }

    public static function cleanPrice($price){
        if($price != null){
            $price = strtok($price, " ");
            return str_replace(',', '.', $price);
        }
        return 0;
    }

    public static function formatPrice($price){
        if($price != null){
            $price = str_replace('.', ',', $price);
            return $price;
        }
        return 0;
    }

    public static function cleanPercentage($percentage){
        if($percentage != null){
            $percentage = strtok($percentage, " ");
            return $percentage;
        }
        return 0;
    }

    public static function displayDate($date){
        if(!empty($date)){
            if($date == '0000-00-00'){
                return "";
            }

            return preg_replace('/(\d{4})\-(\d{2})\-(\d{2})/', '$3/$2/$1', $date);
        }
        return "";
    }

    public static function displayTableDate($date){
        $date = Helpers::displayDate($date);
        if(empty($date)){
            return "All dates";
        }
        return $date;
    }

    public static function formatDate($date){
        if(!empty($date)){
            return preg_replace('/(\d{2})\/(\d{2})\/(\d{4})/', '$3-$2-$1', $date);
        }
        return "";
    }


    public static function formatDates($dates){
        $date_list = explode(",",$dates);
        $dates_arr = array();

        foreach($date_list as $date){
            $dates_arr[] = Helpers::formatDate($date);
        }

        return $dates_arr;
    }

    public static function displayDayDate($date){
        return Carbon::parse($date)->format('l, M d , Y');
    }

    public static function displayDateShort($date){
        return Carbon::parse($date)->format('F j, Y');
    }
    
    public static function displayDateFormat($date, $format = "M d, Y"){
        return Carbon::parse($date)->format($format);
    }

    public static function formatDays($days){
        $day_string = "0000000";

        if(is_array($days)){
            foreach($days as $day){
                $day_string = substr_replace($day_string,1,$day,1);
            }
        }
        return $day_string;
    }

    public static function displayDays($day_string){
        $days = array();
        $strlen = strlen( $day_string );
        for( $i = 0; $i <= $strlen; $i++ ) {
            $char = substr( $day_string, $i, 1 );
            if($char === '1'){
                $days[] = $i;
            }
        }
        return $days;
    }

    public static function carbonDays($day_string){

        $dayMap = [1,2,3,4,5,6,0];

        $days = Helpers::displayDays($day_string);
        $newDays = array();

        foreach($days as $day){
            $newDays[] = $dayMap[$day];
        }

        return $newDays;
    }

    public static function displayViewDays($day_string){
        $days = Helpers::displayDays($day_string);
        $dayArray = [ 'Sun' , 'Mon' , 'Tue' , 'Wed' , 'Thu' , 'Fri' , 'Sat'];
        foreach($days as $key => $day){
            $days[$key] = $dayArray[$key];
        }
        return implode(", ",$days);
    }

    public static function computeDuration($startTime,$endTime){
        $startTime =  new Carbon($startTime);
        $endTime =  new Carbon($endTime);
        $diff = $startTime->diffInSeconds($endTime);
        return Helpers::displayDuration($diff);
    }

    public static function displayDuration($seconds){

        $days = floor ($seconds / 86400);
        if ($days > 1) // 2 days+, we need days to be in plural
        {
            return $days . ' days ' . gmdate ('H:i:s', $seconds);
        }
        else if ($days > 0) // 1 day+, day in singular
        {
            return $days . ' day ' . gmdate ('H:i:s', $seconds);
        }

        $durationString = gmdate ('H:i:s', $seconds);

        return substr($durationString, 0, strripos($durationString, ":"));

    }


    public static function formatDuration($str_time){
        $str_time = $str_time.":00";
        $hours = $minutes = $seconds = 0;
        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
        $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

        return $time_seconds;
    }

    // checking checking and checking....

    public static function getComments($commentText,$commentFirstName,$commentLastName,$commentUser,$commentDate,$commentId){
        $comments = array();

        if($commentText == null || !is_array($commentText)){
            return $comments;
        }

        foreach($commentText as $key => $comment){
            $object = new \StdClass;
            $object->comment = $comment;
            $object->firstname = $commentFirstName[$key];
            $object->lastname = $commentLastName[$key];
            $object->user_id = $commentUser[$key];
            $object->date = $commentDate[$key];
            $object->comment_id = $commentId[$key] ?: 0;
            $comments[] = $object;
        }

        return $comments;
    }

    public static function getAddons($ids,$adults,$children,$payment,$paid,$totalPaid,$addonId,$kidDisabled){
        $addons = array();

        $ids = $ids ?: array();

        foreach($ids as $key => $id){
            $object = new \StdClass;
            $object->id = $id;
            $object->no_adult = $adults[$key];
            $object->no_children = $children[$key];
            $object->total = $object->no_adult + $object->no_children;
            $object->payment_method_id = $payment[$key];
            $object->paid = $totalPaid[$key];
            $object->paid_flag = $paid[$key] ? true : false;
            $object->addon_id = $addonId[$key] ?: 0;
            $object->kid_disabled = $kidDisabled ? true : false;
            $addons[] = $object;
        }

        return $addons;
    }

    public static function getPassengers($names,$flag,$clientId){
        $passengers = array();

        $names = $names ?: array();

        foreach($names as $key => $name){
            $object = new \StdClass;
            $object->name = $name;
            $object->adult_flag = $flag[$key] ? true : false;
            $object->client_id = $clientId[$key] ?: 0;
            $passengers[] = $object;
        }

        return $passengers;
    }
	
	public static function getPromosProducts($ids,$productIds,$productOptionIds,$addonIds){
        $promo_products = array();

        $ids = $ids ?: array();

        foreach($ids as $key => $id){
            $object = new \StdClass;
            $object->id = $id;
            $object->product_id = $productIds[$key];
            $object->product_option_id = $productOptionIds[$key];
            $object->addon_id = $addonIds[$key];
            $promo_products[] = $object;
        }

        return $promo_products;
    }

    public static function mapPromosProducts($promoProductObjects){
        $promosProducts = array();

        foreach($promoProductObjects as $promoProductsObject){
            $object = new \StdClass;
            $object->id = $promoProductsObject->id;
            $object->promo_id = $promoProductsObject->promo_id;
            $object->product_id = $promoProductsObject->product_id;

            $options = $promoProductsObject->options;

            $optionsValue = [];

            foreach($options as $option){
                $optionsValue[] = $option->id;
            }

            $optionsValue = implode(",",$optionsValue);


            $object->product_option_id = $optionsValue;


            $addons = $promoProductsObject->addons;

            $addonsValue = [];

            foreach($addons as $addon){
                $addonsValue[] = $addon->id;
            }

            $addonsValue = implode(",",$addonsValue);

            $object->addon_id = $addonsValue;
            $promosProducts[] = $object;
        }

        return $promosProducts;
    }

    public static function mapAddons($addonObjects){
        $addons = array();

        $addonsRepository = new AddonsRepository;

        foreach($addonObjects as $addonObject){
            $object = new \StdClass;
            $object->addon_id = $addonObject->id;
            $object->id = $addonObject->addon_id;
            $object->no_adult = $addonObject->no_adult;
            $object->no_children = $addonObject->no_children;
            $object->total = $object->no_adult + $object->no_children;
            $object->payment_method_id = $addonObject->payment_method_id;
            $object->paid = $addonObject->paid;
            $object->paid_flag = $addonObject->paid_flag;
            $object->kid_disabled = $addonsRepository->checkIfPriceIsZero($addonObject->addon_id);
            $addons[] = $object;
        }

        return $addons;
    }

    public static function mapPassengers($passengerObjects){
        $passengers = array();

        foreach($passengerObjects as $passengerObject){
            $object = new \StdClass;
            $object->client_id = $passengerObject->id;
            $object->name = $passengerObject->name;
            $object->adult_flag = $passengerObject->is_adult;
            $passengers[] = $object;
        }

        return $passengers;
    }

    public static function mapComments($commentObjects){
        $comments = array();

        foreach($commentObjects as $commentObject){
            $object = new \StdClass;
            $object->comment_id = $commentObject->id;
            $object->comment = $commentObject->comment;
            $object->user_id = $commentObject->user_id;
            $object->firstname = $commentObject->user->firstname;
            $object->lastname = $commentObject->user->lastname;
            $object->date = Carbon::parse($commentObject->created_at)->diffForHumans();
            $comments[] = $object;
        }

        return $comments;
    }

    public static function getFilterUrl($array){
        $url = Request::url();
        $query = Input::query();

        foreach($array as $key => $value){
            $query[$key] = $value;
        }

        $query = array_filter($query);
        return $url."?".http_build_query($query);
    }

    public static function searchForId($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['id'] === $id) {
                return $key;
            }
        }
        return null;
    }

}