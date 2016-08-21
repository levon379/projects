<?php namespace App\Libraries\Repositories;

use App\Booking;
use App\ProductOption;
use App\Promo;
use App\PromoType;
use App\Libraries\Helpers;

use App\ProductOptionLanguage;
use App\ProductOptionUnavailableDay;
use App\ProductOptionLanguageUnavailableDay;
use App\AvailabilityRule;
use App\Libraries\Repositories\TourManagerRepository;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingsRepository {


    public function getBookingsByFilter($bookingFrom = null ,
        $bookingTo = null, $travelFrom = null, $travelTo = null, $bookingReference = null,
        $orderReference = null, $sourceGroup = null,$sourceName = null, $product = null, $productOption = null,
        $paymentMethod = null, $paid = "", $provider  = null, $showPackages = 1, $showParents = 1,$query = "", $limit = 25, $page = 1
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

        if(!empty($provider)){
            // for switches
            // AND p.provider IN ()
            $queryString .= " AND p.provider_id IN ($provider) ";
        }

        if($showPackages == 0){
           $queryString .= " AND b.package != '1'";
        }

        /* Parent bookings.package 0 and product_options.package_flag 1 */
        if($showParents == 0){
            $queryString .= " AND po.package_flag = '0'";
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

    public function computeTourPrice($productOptionId, $adultNo, $childNo, $promoId)
    {

        $productOption = ProductOption::find($productOptionId);
        $productId = $productOption->product_id;

        $promo = Promo::find($promoId);

        // check if promo is applicable to current product
        $applicableToProduct = false;

        if($promo)
        {
            $promoProductIds = $promo->promos_products->lists('product_id');

            if( count($promoProductIds) == 0 or in_array($productId, $promoProductIds) )
            {
                $applicableToProduct = true;
            }
        }

        $tourPrice = 0;

        if(!empty($productOption) && $productOption->fixed_price_flag != 1){
            $tourPrice = ((int)$adultNo * $productOption->adult_price) + ((int)$childNo * $productOption->child_price);
        }else{
            $tourPrice = $productOption->adult_price;
        }
        
        if(!empty($promo) and $applicableToProduct ){
            $promoType = PromoType::find($promo->promo_type_id);
            switch($promoType->id){
                case PromoType::NEWPRICING:
                    $tourPrice =  floatVal((int)$adultNo * $promo->adult_price) + floatVal((int)$childNo * $promo->child_price);
                    break;
                case PromoType::FREEADDON:
                    break;
                case PromoType::FIXEDDISCOUNT:
                    $tourPrice =  floatval($tourPrice) - floatval($promo->euro_off_discount);
                    break;
                case PromoType::PERCENTDISCOUNT:
                    $tourPrice =  floatval($tourPrice) - floatVal( floatVal($tourPrice) * floatval($promo->percent_discount / 100) );
                    break;
            }
        }

        return $tourPrice;
    }

    public function checkProductOptionAvailability($productOptionId, $travelDateInput, $totalPerson, $referenceNo, $language)
    {
        $date = Helpers::formatDate($travelDateInput);

        $dateCarbon = Carbon::parse($date);
        $dateInput = $dateCarbon->format('d/m/Y');
        $dayOfWeek = $dateCarbon->dayOfWeek;

        $warningMessages = array();

        // $update = false;

        // $booking = Booking::find($bookingId);
        // if(!empty($booking)){
        //     $update = true;
        // }

        $tourManagerRepository = new TourManagerRepository();

        // check for duplicate reference number
        if(!empty($referenceNo)){
            $referenceExists = Booking::where('reference_number','=',$referenceNo)->count();
            if($referenceExists > 0){
                $warningMessages['DuplicateReference'] =  "There is a booking that is using the same reference number ($referenceNo)";
            }
        }

        $checkLimit = true;

        $productOption = ProductOption::find($productOptionId);

        // check if travel date falls in between the travel-dates specified by this product option
        $travelSeasonStartDate = $productOption->trav_season_start;
        $travelSeasonEndDate = $productOption->trav_season_end;
        
        $travelStartCarbonDate = Carbon::parse( $travelSeasonStartDate );
        $travelEndCarbonDate = Carbon::parse( $travelSeasonEndDate );

        list($h, $m, $s) = explode(":", $productOption->start_time);

        if( $travelSeasonStartDate != '0000-00-00' and $travelStartCarbonDate->gt( $dateCarbon ) )
        {
            $warningMessages['TravelRange'] = "The travel date must fall in the date-range specified by this tour option.";
        }
        elseif( Carbon::now()->diffInHours( $dateCarbon->copy()->setTime($h, $m, $s) )  < 24)
        {
            $warningMessages['24HoursCheck'] = "The booking must be made atleast 24 hours before the tour departure time: ".$productOption->start_time;
        }

        if( $travelSeasonEndDate != '0000-00-00' and $travelEndCarbonDate->lt( $dateCarbon ) )
        {
            $warningMessages['TravelRange'] = "The travel date must fall in the date-range specified by this tour option.";
        }

        // check if today/booking date falls in between the booking-dates specified by this product option
        $bookingSeasonStartDate = $productOption->book_season_start;
        $bookingSeasonEndDate = $productOption->book_season_end;
        $bookingStartCarbonDate = Carbon::parse( $bookingSeasonStartDate );
        $bookingEndCarbonDate = Carbon::parse( $bookingSeasonEndDate );


        if( $bookingSeasonStartDate != '0000-00-00' and $bookingStartCarbonDate->gt( Carbon::now() ) )
        {
            $warningMessages['BookingRange'] = "The booking for this tour option will start on ". $bookingStartCarbonDate->format("d F Y");
        }

        if( $bookingSeasonEndDate != '0000-00-00' and $bookingEndCarbonDate->lt( Carbon::now() ) )
        {
            $warningMessages['BookingRange'] = "The booking for this tour option was closed on ". $bookingEndCarbonDate->format("d F Y");;
        }

        // check for availabilitySlot against ProductOption and then get Rules against that Slot
        $availabilitySlotId = $productOption->availability_slot_id;

        $totals = $tourManagerRepository->getTotalsByAvailabilityAndDate($availabilitySlotId,$date);
        if($totals->has_override){
            $bookingLimit = $totals->limit_override;
        } else {
            $bookingLimit = $totals->limit;
        }
        if($bookingLimit == null){
            $checkLimit = false;
        }

        // $availabilityRule = AvailabilityRule::where('availability_slot_id','=',$availabilitySlotId)->first();


        // if(!empty($availabilityRule) && $availabilityRule != null){
        //     // check for booking count and limit
        //     $bookingCount = Booking::where('product_option_id','=',$productOptionId)->count();
        //     $bookingLimit = $availabilityRule->limit;


        // } else {
        //     $checkLimit = false;
        // }

        // check for runningDays against productOption (0000001 = sunday-only)
        $runningDays = Helpers::carbonDays($productOption->running_days);


        if(!in_array($dayOfWeek,$runningDays)){
            $dayArray = [ 'Sun' , 'Mon' , 'Tue' , 'Wed' , 'Thu' , 'Fri' , 'Sat'];
            $day = $dayArray[$dayOfWeek];
            $warningMessages['AvailabeDays'] =  "This product option does not run on this day of the week ($day)";
        }

        $productOptionLanguage = ProductOptionLanguage::where('product_option_id','=',$productOptionId)
                                ->where('language_id',$language)
                                ->first();

        $closedDate = null;

        if(!empty($productOptionLanguage)){
            $closedDate = ProductOptionLanguageUnavailableDay::where('product_options_language_id',$productOptionLanguage->id)->where('date',$date)->first();
        }

        if(!empty($closedDate)){
            $warningMessages["ClosedDate"] =  "You have chosen a date ($date) that was specified as a closed tour option";
        }

        // check for unavailable days
        $unavailableDays = ProductOptionUnavailableDay::where('product_option_id','=',$productOptionId)->get();
        $unavailableDaysArray = array();

        foreach($unavailableDays as $unavailableDay){
            $unavailableDaysArray[] = $unavailableDay->date;
        }

        if(in_array($date,$unavailableDaysArray)){
            $warningMessages['UnavailableDate'] =  "You have chosen a date ($travelDateInput) that was specified as unavailable";
        }

        if($checkLimit){


            $guideCount = $tourManagerRepository->getGuideTotalByAvailabilityAndDate($availabilitySlotId,$date);
            $guideCount = (int)$guideCount->guide_count;
            $remaining = $totals->remaining;
            if(!empty($remaining)){
                $remaining = $remaining - $guideCount;
            }
            // if($update){
            //     $remaining = $remaining + $booking->total_pax;
            // }

            if( ($remaining > 0) &&  ($totalPerson > $remaining)){

                $warningMessages["RemainingSpots"] =  "There are $remaining spots left available for this product option for the date chosen.";
            }
            if($remaining < 1){
                $warningMessages["NoSpotsLeft"] =  "There are no spots left available for this product option for the date chosen.";
            }
        }
        
        // now check for package options
        if( $productOption->package_flag )
        {
            foreach ($productOption->options as $option)
            {
                $tempMessages = $this->checkProductOptionAvailability($option->id, $travelDateInput, $totalPerson, $referenceNo, $language);
                $warningMessages = array_merge($warningMessages, $tempMessages);
            }
        }
        

        return $warningMessages;
    }

}