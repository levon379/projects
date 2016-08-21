<?php namespace App\Http\Controllers;

use App\AvailabilityRule;
use App\AvailabilitySlotDateLimit;
use App\Booking;
use App\Addon;
use App\FeedbackEmail;
use App\Libraries\Repositories\TourManagerRepository;
use App\OrderBooking;
use App\ProductOptionLanguage;
use App\ProductOptionLanguageUnavailableDay;
use App\Promo;
use App\PromoType;
use App\BookingAddon;
use App\BookingClient;
use App\BookingComment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Libraries\Repositories\NetRateRepository;
use App\Language;
use App\Libraries\Helpers;
use App\ProductOption;
use App\ProductOptionUnavailableDay;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class BookingServicesController extends Controller {

    public function __construct(TourManagerRepository $tourManagerRepository){
        $this->tourManagerRepository = $tourManagerRepository;
    }


    public function deleteAddon($id){
        $addon = BookingAddon::find($id);
        $addon->delete();
    }

    public function deleteComment($id){
        $comment = BookingComment::find($id);
        $comment->delete();
    }

    public function deleteClient($id){
        $client = BookingClient::find($id);
        $client->delete();
    }

    public function cancelBooking($id){
        $booking = Booking::find($id);
        $booking->deleted = true;
        $booking->save();
    }

    public function cancelRefundBooking($id){
        $booking = Booking::find($id);
        $booking->deleted = true;
        $booking->refunded = true;
        $booking->tour_paid = 0;
        $booking->total_paid = 0;
        $booking->paid_flag = 0;
        $booking->save();
    }
	
    public function validateDate(){
        $bookingId = Input::get('id',0);
        $productOptionId = Input::get('product_option_id');
        $dateInput = Input::get('date');
        $totalPerson = Input::get('total');
        $referenceNo = Input::get('reference_no');
        $language = Input::get('language');
        $date = Helpers::formatDate($dateInput);
        $dateCarbon = Carbon::parse($date);
        $dayOfWeek = $dateCarbon->dayOfWeek;

        $update = false;

        $booking = Booking::find($bookingId);
        if(!empty($booking)){
            $update = true;
        }

        $warningMessages = array();

        if(!empty($referenceNo)){
            $referenceExists = Booking::where('reference_number','=',$referenceNo)->count();
            if($referenceExists > 0){
                $warningMessages[] =  "There is a booking that is using the same reference number ($referenceNo)";
            }
        }

        $checkLimit = true;

        $productOption = ProductOption::find($productOptionId);
        $availabilitySlotId = $productOption->availability_slot_id;


        $totals = $this->tourManagerRepository->getTotalsByAvailabilityAndDate($availabilitySlotId,$date);
        if($totals->has_override){
            $bookingLimit = $totals->limit_override;
        } else {
            $bookingLimit = $totals->limit;
        }
        if($bookingLimit == null){
            $checkLimit = false;
        }

        $runningDays = Helpers::carbonDays($productOption->running_days);


        if(!in_array($dayOfWeek,$runningDays)){
            $dayArray = [ 'Sun' , 'Mon' , 'Tue' , 'Wed' , 'Thu' , 'Fri' , 'Sat'];
            $day = $dayArray[$dayOfWeek];
            $warningMessages[] =  "This product option does not run on this day of the week ($day)";
        }

        $productOptionLanguage = ProductOptionLanguage::where('product_option_id','=',$productOptionId)->where('language_id',$language)->first();

        $closedDate = null;




        if(!empty($productOptionLanguage)){
            $closedDate = ProductOptionLanguageUnavailableDay::where('product_options_language_id',$productOptionLanguage->id)->where('date',$date)->first();
        }

        if(!empty($closedDate)){
            $warningMessages[] =  "You have chosen a date ($dateInput) that was specified as a closed tour option";
        }

        $unavailableDays = ProductOptionUnavailableDay::where('product_option_id','=',$productOptionId)->get();
        $unavailableDaysArray = array();

        foreach($unavailableDays as $unavailableDay){
            $unavailableDaysArray[] = $unavailableDay->date;
        }

        if(in_array($date,$unavailableDaysArray)){
            $warningMessages[] =  "You have chosen a date ($dateInput) that was specified as unavailable";
        }


        if($checkLimit){


            $guideCount = $this->tourManagerRepository->getGuideTotalByAvailabilityAndDate($availabilitySlotId,$date);
            $guideCount = (int)$guideCount->guide_count;
            $remaining = $totals->remaining;
            if(!empty($remaining)){
                $remaining = $remaining - $guideCount;
            }
            if($update){
                $remaining = $remaining + $booking->total_pax;
            }
            if( ($remaining > 0) &&  ($totalPerson >= $remaining)){

                $warningMessages[] =  "There are $remaining spots left available for this product option for the date chosen.";
            }
            if($remaining < 1){
                $warningMessages[] =  "There are no spots left available for this product option for the date chosen.";
            }
        }

        return response()->json([ 'wcount' => count($warningMessages) , 'w' => $warningMessages ]);

    }
	
	public function computeTourPrice(){ 
		$productOptionId = Input::get('product_option_id');
		$source_name_id = Input::get('source_name_id','');
		$booking_date = Input::get('booking_date','');
		$travel_date = Input::get('travel_date','');
                $promoId = Input::get('promo_id');
                $promo = Promo::find($promoId);
		$productOption = ProductOption::find($productOptionId);
		$adultNo = Input::get('adult_no');
		$childNo = Input::get('child_no');

            $tourPrice = 0;
            $net_rate_error = false;
            $source_matches = (array)NetRateRepository::getRateMatchesNetRate($productOptionId,$source_name_id,$booking_date,$travel_date);
            if(!empty($productOption)){
                if($productOption->fixed_price_flag == 1 && empty($source_matches)){
                    $tourPrice = (int) $productOption->product->default_price;
                }elseif(!empty($source_matches)){
                    if(isset($source_matches['error_message'])){
                        $net_rate_error = true;
                    }else{
                        $tourPrice = ((int)$adultNo * $source_matches['adult_net_rate']) + ((int)$childNo * $source_matches['child_net_rate']);
                    }
                }else{
                    $tourPrice = ((int)$adultNo * $productOption->adult_price) + ((int)$childNo * $productOption->child_price);
                }

            }

            if(!empty($promo)){
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
            if($net_rate_error){
                $response = array('tourPrice'=>$tourPrice,'net_rate_error'=>true);
                return json_encode($response);
            }else{
                return $tourPrice;
            }
	}
	
	public function computeAddonPrice(){
		$addonId = Input::get('addon_id');
		$addon = Addon::find($addonId);
        // if($addon->)
		$adultNo = Input::get('adult_no');
		$childNo = Input::get('child_no');
		$addon_price = ((int)$adultNo * $addon->adult_price) + ((int)$childNo * $addon->child_price);
        return $addon_price;
	}
	
	public function computeTotalPrice(){
		$productPrice = Input::get('product_price');
        $productPrice = Helpers::cleanPrice($productPrice);
		$bookingAddonsTotal = Input::get('booking_addons_total');
		$discountedProductPrice = $productPrice;
		$total_price = floatVal($discountedProductPrice) + floatVal($bookingAddonsTotal);
        return $total_price;
	}
	
	public function getBookingDetails(){
        $id = Input::get('booking_id');
        $booking = Booking::where('id','=',(int)$id)->first();
		$booking_details = [];
		if(!empty($booking)){
		
			$booking_details = array(
				"id" => $booking->id,
				"fullname" => $booking->name, 
				"email" => $booking->email, 
				"product_id" => $booking->product_option->product->id,
				"product_name" => $booking->product_option->product->name,
				"product_option_id" => $booking->product_option->id,
				"product_option_name" => $booking->product_option->name
			);
		}
        return json_encode($booking_details);
    }

    public function applyAction(){
        $action = Input::get('action');
        $ids = Input::get('ids');

        /*
         *  1 - Delete
         *  2 - Send Feedback Request
         *  3 - Mark as Paid
         *  4 - Export to Excel
         *  5 - Copy Email Address
         *  6 - Confirm
         */
        switch($action){
            case 1:
                $this->deleteBookings(explode(",",$ids));
                break;
            case 2:
                return $this->sendFeedbackRequests(explode(",",$ids));
                break;
            case 3:
                $this->markAsPaid(explode(",",$ids));
                break;
            case 4:
                // We just create a separate service that could be accessed via get for exports
                //$this->exportToExcel(explode(",",$ids));
                break;
            case 5:
                return $this->copyEmailAddress(explode(",",$ids));
                break;
            case 6:
                return $this->confirmBookings(explode(",",$ids));
                break;
        }
    }

    public function exportToExcel(){
        $ids = Input::get('ids');
        $ids = explode(",",$ids);
        $data = [];

        $data[] = [
            "Book Date",
            "Travel Date",
            "Name",
            "E-mail",
            "Adults",
            "Kids",
            "Total",
            "Payment Method",
            "Source",
            "Price",
            "Paid?",
            "Review?"
        ];

        foreach($ids as $id){
            $booking = Booking::find($id);
            $data[] = [
                Helpers::displayDate($booking->created_at->toDateString()),
                Helpers::displayDate($booking->travel_date),
                $booking->name,
                $booking->email,
                $booking->no_adult,
                $booking->no_children,
                ($booking->no_adult + $booking->no_children),
                $booking->payment_method->name,
                $booking->source_name->name,
                Helpers::formatPrice($booking->total_paid),
                ($booking->getPaidValue()>0? "true" : "false"),
                ($booking->getReviewedValue()>0? "true" : "false")
            ];
        }

        Excel::create('Bookings', function($excel) use($data) {

            $excel->sheet('Sheet 1', function($sheet) use($data) {

                $sheet->fromArray($data,null, 'A1', true, false);

            });

        })->export('xls');
    }

    public function copyEmailAddress($ids){
        $emails = [];
        foreach($ids as $id){
            $booking = Booking::find($id);
            $emails[] = $booking->email;
        }

        $emails = array_filter($emails);

        return implode(",",$emails);
    }


    public function markAsPaid($ids){
        foreach($ids as $id){
            $booking = Booking::find($id);
            $booking->paid_flag = true;
            $booking->save();
        }
        Session::flash('success', "Bookings have been marked as paid");
    }

    public function deleteBookings($ids){
        $errors = 0;
        foreach($ids as $id){
            if(!$this->deleteBooking($id)){
                $errors++;
            }
        }

        if($errors){
            Session::flash('warning', "Some bookings cannot be deleted it is being used");
        } else {
            Session::flash('success', "Bookings have been deleted successfully");
        }
    }

    public function confirmBookings($ids)
    {
        
        
        foreach($ids as $id) {
            $booking = Booking::find($id);
            $booking->pending = 0;
            $booking->save();
        }
        
        Session::flash('success', "Bookings have been confirmed successfully");

        //return true;
        
    }

    public function deleteBooking($id){
        $booking = Booking::find($id);
        try {
            OrderBooking::where('booking_id','=',$booking->id)->delete();
            BookingComment::where('booking_id','=',$booking->id)->delete();
            BookingAddon::where('booking_id','=',$booking->id)->delete();
            BookingClient::where('booking_id','=',$booking->id)->delete();
            $booking->delete();
        } catch (QueryException $e) {
            return false;
        }
        return true;
    }

    public function sendFeedbackRequests($ids){
        $errors = 0;
        foreach($ids as $id){
            if($this->sendFeedbackRequestMain($id,false)>0){
                $errors++;
            }
        }

        if($errors){
            return response()->json([ 'wcount' => $errors , 'w' => 'An error has ooccured cannot sent feedback request' ,'s' => '']);
        } else {
            return response()->json([ 'wcount' => $errors , 'w' => '' ,'s' => 'The feedback request has been sent.']);
        }

    }

    public function sendFeedbackRequest($id){
        return $this->sendFeedbackRequestMain($id,true);
    }

    public function sendFeedbackRequestMain($id,$ajax){
        $booking = Booking::find($id);

        if($booking->feedback_request_sent){
            if($ajax){
                $warningMessages[] = "The feedback has already been sent";
                return response()->json([ 'wcount' => count($warningMessages) , 'w' => $warningMessages ,'s' => '']);
            } else {
                return 1;
            }
        }

        $warningMessages = array();

        if(!empty($booking->language_id)){
            $feedback = FeedbackEmail::where('provider_id',$booking->product_option->product->provider_id)->where('language_id',$booking->language_id)->first();
        }

        if(empty($feedback)){
            $warningMessages[] = "There is no feedback email for this product provider and language";
        } else {
            if(!empty($booking->email)){
                $body = $feedback->body;
                $body = html_entity_decode($body);
                $body = str_replace("[[Name]]",$booking->name,$body);

                if(!empty($feedback->email_name)){
                    Config::set('mail.from',['address' => 'reviews@ecoarttravel.com', 'name' => $feedback->email_name]);
                } else {
                    Config::set('mail.from',['address' => 'reviews@ecoarttravel.com', 'name' => 'reviews@ecoarttravel.com']);
                }

                Mail::queue('emails.feedback', array('msg' => $body), function($message) use ($booking,$feedback)
                {
                    $message->to( $booking->email , $booking->name)->replyTo($feedback->from_email,$feedback->name)->subject($feedback->subject);
                    $booking->feedback_request_sent = true;
                    $booking->feedback_request_sent_date = Carbon::now();
                    $booking->save();
                });
            } else {
                $warningMessages[] = "There is no email for this booking";
            }
        }


        $date = Helpers::displayDate(Carbon::now()->toDateString());
        $name = $booking->getNameOfUser();
        $successMessage = "Feedback Request Sent on $date by $name";

        if($ajax){
            return response()->json([ 'wcount' => count($warningMessages) , 'w' => $warningMessages ,'s' => $successMessage]);
        }

        return count($warningMessages);
    }

    public function assignGuide(){
        $guide = Input::get('guide');
        $ids = Input::get('ids');
        $ids = explode(",",$ids);
        foreach($ids as $id){
            $booking = Booking::find($id);
            if(!empty($booking)){
                $booking->guide_user_id = $guide;
                $booking->save();
            }
        }

    }
    
}
