<?php namespace App\Libraries\Repositories;

use App\Booking;
use App\Libraries\Helpers;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingsRepository {


    public function getBookingsByFilter($bookingFrom = null ,
        $bookingTo = null, $travelFrom = null, $travelTo = null, $bookingReference = null,
        $orderReference = null, $sourceGroup = null,$sourceName = null, $product = null, $productOption = null,
        $paymentMethod = null, $paid = "", $pending = "", $provider  = null, $showPackages = 1, /*$showParents = 1,*/ $query = "", 
            $limit = 25, $page = 1 ,$refunded = '0',$deleted = '0'
    ){

        $queryString = "SELECT b.* FROM bookings b ";

        if(!empty($orderReference)){

            $queryString .= "LEFT JOIN order_bookings ob
                                    ON ob.booking_id = b.id
                             LEFT JOIN orders o
                                    ON o.id = ob.order_id ";
        }

        if(!empty($sourceGroup)){
            $queryString .= "LEFT JOIN source_names sn
                                    ON sn.id = b.source_name_id ";
        }
       
        if(!empty($product)){
            $queryString .= "LEFT JOIN product_options po
                                    ON po.id = b.product_option_id ";
            if(!empty($provider)){
                $queryString .= "LEFT JOIN products p
                                        ON p.id = po.product_id ";
            }
        } else {
            if(!empty($provider)){
                $queryString .= "LEFT JOIN product_options po
                                        ON po.id = b.product_option_id
                                 LEFT JOIN products p
                                        ON p.id = po.product_id ";
            }
        }

        $queryString .= "WHERE  b.id > 0 ";
        

        /* Handling booking from and to */
        if(!empty($bookingFrom) && !empty($bookingTo)){
            $bookingFrom = Helpers::formatDate($bookingFrom);
            $bookingTo = Helpers::formatDate($bookingTo);
            $queryString .= " AND ( '$bookingFrom' <= DATE(b.created_at) AND '$bookingTo' >= DATE(b.created_at) )";
        } else {
            if(!empty($bookingFrom)){
                $bookingFrom = Helpers::formatDate($bookingFrom);
                $queryString .= " AND ( '$bookingFrom' <= DATE(b.created_at) )";
            }
            if(!empty($bookingTo)){
                $bookingTo = Helpers::formatDate($bookingTo);
                $queryString .= " AND ( '$bookingTo' >= DATE(b.created_at) )";
            }
        }

        /* Handling travel from and to */
        if(!empty($travelFrom) && !empty($travelTo)){
            $travelFrom = Helpers::formatDate($travelFrom);
            $travelTo = Helpers::formatDate($travelTo);
            $queryString .= " AND ( '$travelFrom' <= b.travel_date AND '$travelTo' >= b.travel_date )";
        } else {
            if(!empty($travelFrom)){
                $travelFrom = Helpers::formatDate($travelFrom);
                $queryString .= " AND ( '$travelFrom' <= b.travel_date )";
            }
            if(!empty($travelTo)){
                $travelTo = Helpers::formatDate($travelTo);
                $queryString .= " AND ( '$travelTo' >= b.travel_date )";
            }
        }
        if($refunded == '0'){
            $queryString .= " AND NOT b.refunded = 1 ";
        }
        
        if($deleted == '0'){
            $queryString .= " AND NOT b.deleted = 1 ";
        }

        if(!empty($bookingReference)){
            $queryString .= " AND b.reference_number = '$bookingReference'";
        }

        if(!empty($orderReference)){
            $queryString .= " AND o.reference_no = '$orderReference'";
        }

        if(!empty($sourceGroup)){
            $queryString .= " AND sn.source_group_id = '$sourceGroup'";
        }

        if(!empty($sourceName)){
            $queryString .= " AND b.source_name_id = '$sourceName'";
        }

        if(!empty($product)){
            $queryString .= " AND po.product_id = '$product'";
        }

        if(!empty($productOption)){
            $queryString .= " AND b.product_option_id = '$productOption'";
        }

        if(!empty($paymentMethod)){
            $queryString .= " AND b.payment_method_id = '$paymentMethod'";
        }

        if($paid != ""){
            $queryString .= " AND b.paid_flag = $paid";
        }

        if($pending != ""){
            $queryString .= " AND b.pending = $pending";
        }

        if(!empty($provider)){
            // for switches
            // AND p.provider IN ()
            $queryString .= " AND p.provider_id IN ($provider) ";
        }
        
        if($showPackages == "chbg"){
           $queryString .= " AND not( b.package != '1' AND po.package_flag != '0' ) ";
        }
        if($showPackages == "pbg"){
           $queryString .= " AND not ( b.package != '0' AND po.package_flag != '1' ) ";
        }
        if($showPackages == '1'){
            
        }
        if($showPackages == '0'){
           $queryString .= "AND not( b.package = '1' AND po.package_flag = '0') AND not ( b.package = '0' AND po.package_flag = '1' )";
        }

        if(!empty($query)){
            $queryString .= " AND b.name LIKE '%$query%' OR b.email LIKE '%$query%' ";
        }

        $startFrom = ($page-1) * $limit;

        // dd($queryString);

        $bookings = Booking::hydrateRaw($queryString." LIMIT $startFrom, $limit");

        // Log::info($queryString." LIMIT $startFrom, $limit");

        // dd($queryString);

        $queryString = str_replace("SELECT b.* FROM","SELECT COUNT(b.id) as count,SUM(no_children) as kids, SUM(no_adult) as adults, SUM(total_pax) as total_pax, SUM(total_paid) as total_paid FROM",$queryString);



        $totalsQuery = DB::select($queryString)[0];

        $output = new \StdClass;
        $output->total = $totalsQuery->count;
        $output->bookings = $bookings;
        $output->kids = $totalsQuery->kids ?: 0;
        $output->adults = $totalsQuery->adults ?: 0;
        $output->total_pax = $totalsQuery->total_pax ?: 0;
        $output->total_paid = $totalsQuery->total_paid;

        return $output;

    }


    public function getBookingsByDateProductOptionAndLanguage($date,$id,$language){
        $bookings = Booking::where("travel_date",$date)->where("product_option_id",$id)->where('language_id',$language)->get();
        return $bookings;
    }

    public function getBookingsByProductAvailabilityAndDate($product,$availability,$date){
        $tourManagerRepository = new TourManagerRepository;
        $options = $tourManagerRepository->getProductOptionsByProductAvailabilityAndDate($product,$availability,$date);
        $result = [];

        foreach($options as $option){

            $optionItem = new \StdClass;
            $optionItem->id = $option->product_option_id;
            $optionItem->language_name = $option->language_name;
            $optionItem->proptions_language_id = $option->proptions_lang_id;
            $optionItem->language_id =  $option->language_id;
            $optionItem->name = $option->product_option_name;
            $optionItem->total_bookings = $option->total_bookings;
            $optionItem->total_package = (int)$option->total_package;
            $optionItem->available = $option->available;
            $optionItem->bookings = [];

            $bookings = $this->getBookingsByDateProductOptionAndLanguage($date,$option->product_option_id,$option->language_id);

            foreach($bookings as $booking){

                $optionItem->bookings[] = $booking;
            }

            $result[] = $optionItem;
        }

        return $result;
    }

}