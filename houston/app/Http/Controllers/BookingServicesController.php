<?php namespace App\Http\Controllers;

use App\AvailabilityRule;
use App\Booking;
use App\Addon;
use App\FeedbackEmail;
use App\OrderBooking;
use App\Promo;
use App\PromoType;
use App\BookingAddon;
use App\BookingClient;
use App\BookingComment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Language;
use App\Libraries\Helpers;
use App\ProductOption;
use App\ProductOptionUnavailableDay;
use App\Libraries\Repositories\BookingsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class BookingServicesController extends Controller {


    // this needs to be fixed for front-end booking
    public function validateDate(){
        $productOptionId = Input::get('product_option_id');
        $travelDateInput = Input::get('date');
        $totalPerson = (int)Input::get('total');
        $language = Input::get('language');
        $referenceNo = Input::get('reference_no');
        
        $bookingsRepository = new BookingsRepository();

        // check for all factors of booking availability.
        $warningMessages = $bookingsRepository->checkProductOptionAvailability(
            $productOptionId, 
            $travelDateInput, 
            $totalPerson, 
            $referenceNo,
            $language
        );

        return json_encode([ 'wcount' => count($warningMessages) , 'w' => $warningMessages ]);

    }
	
	public function computeTourPrice(){

        
		$productOptionId = Input::get('product_option_id');
		$productOption = ProductOption::find($productOptionId);
                $productId = $productOption->product_id;
		$adultNo = Input::get('adult_no');
		$childNo = Input::get('child_no');

        //
        $promoId = Input::get('promo_id');

        $bookingsRepository = new BookingsRepository();

        $tourPrice = $bookingsRepository->computeTourPrice( 
            $productOptionId,
            $adultNo, 
            $childNo, 
            $promoId
        );

        return $tourPrice;
	}
	
	public function computeAddonPrice(){
		$addonId = Input::get('addon_id');
		$addon = Addon::find($addonId);
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

    
}
