<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Addon;
use App\Language;
use App\BookingClient;
use App\BookingComment;
use App\BookingAddon;
use App\Order;
use App\OrderBooking;
use App\Product;
use App\ProductOption;
use App\Booking;
use App\ViatorMapping;
use App\ViatorRequest;
use \App\Voucher;
use Yangqi\Htmldom\Htmldom;

use Carbon\Carbon;
use App\Libraries\Repositories\TourManagerRepository;
use App\ProductOptionLanguage;
use App\ProductOptionUnavailableDay;
use App\ProductOptionLanguageUnavailableDay;
use App\AvailabilitySlotDateLimit;
use App\AvailabilityRule;
use App\Libraries\Helpers;

use \DatePeriod;
use \DateInterval;

//use \Illuminate\Support\Collection

class ViatorController extends Controller {

	const APIKEY = "nbUuvQermU4I2mFTgCtg9aKsFzWEr3fgIA-e23NccjU";
	const RESELLER_ID = "1000";
	const RomeBySegwayID = "6700";
	const GoSeekAdventuresID = "6685";
	const SUPPLIER_ID = "2006";

	var $languageCodes = [];
	var $languageIds = [];
	var $mail;

	public function __construct(\Illuminate\Mail\Mailer $mail) {
		$this->_setLanguages();
		$this->mail = $mail;
	}

	public function getCsv(){
		echo "<pre>";
		echo date_default_timezone_get()."\n";
		echo date("Y-m-d\TH:i:s.000P");

	}

	

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	private function _log($data)
	{
		
		if( ($_SERVER["REMOTE_ADDR"] != "127.0.0.1" and $_SERVER["REMOTE_ADDR"] != "173.236.224.148"))
		{
			if(!isset($this->viatorRequest))
			{
				$data["remote_ip"] = $_SERVER["REMOTE_ADDR"];
				//print_r($data);exit;
				$this->viatorRequest = ViatorRequest::create($data);
			} else
			{
				$this->viatorRequest->update($data);
			}
		}
	}	

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function postApi()
	{

		$request = \Input::get();
		//print_r($request);exit;

		$request["data"]["BookingReference"] = (string)@$request["data"]["BookingReference"]; // typecast only

		// temporarily disable validating SupplierId as not yet finalized by Viator
		//$request["data"]["SupplierId"] = 6700;
		$request["data"]["SupplierId"] = (string)$request["data"]["SupplierId"];

		//$this->_log(["request" => print_r($request, true), "request_json" => $request]);
		$this->_log(["request" => print_r($request, true), "request_json" => json_encode($request)]);

		try{ 

			$dontCheck = false;
			if( $dontCheck and $_SERVER["HTTP_HOST"] != "houston.loc" and $_SERVER["HTTP_HOST"] != "testadmin.ecoarttravel.com" )
			{
				throw new \Exception("Viator API is not yet active on production. Please do contact system administrator", 1); exit;
			}
			
			
			$requestType = $request['requestType'];
			$requestData = $request['data'];

			if(
				$requestData['ApiKey'] != self::APIKEY or
				$requestData['ResellerId'] != self::RESELLER_ID or
				$requestData['SupplierId'] != self::SUPPLIER_ID
				//!($requestData['SupplierId'] == self::GoSeekAdventuresID or $requestData['SupplierId'] == self::RomeBySegwayID)
				)
			{
				
				// $message|$status|$code|$tStatus|$tReason
				throw new \Exception("Not Authorized: Invalid Credentials", 401);
			}

			//print_r($request);exit;
			// @TODO: need to verify api credentials here.

			if( $requestType == 'BookingRequest' )
			{
				$response = $this->_BookingRequest($request);
			}
			elseif( $requestType == 'BookingAmendmentRequest' )
			{
				$response = $this->_BookingAmendmentRequest($request);
			}
			elseif( $requestType == 'BookingCancellationRequest' )
			{
				$response = $this->_BookingCancellationRequest($request);
			}
			elseif( $requestType == 'AvailabilityRequest' )
			{
				$response = $this->_AvailabilityRequest($request);
			}
			elseif( $requestType == 'BatchAvailabilityRequest' )
			{
				$response = $this->_BatchAvailabilityRequest($request);
			}
			elseif( $requestType == 'TourListRequest' )
			{
				$response = $this->_TourListRequest($request);
			}
			else
			{
				throw new \Exception("Unknown Request Type");
			}

			$this->_log(["response" => print_r($response, true)]);

			return $response;
		} catch(\ErrorException $e) {
			$response = $this->_generateErrorResponse($e, $request);
			return $response;
		} catch(\Exception $e) {
			$response = $this->_generateErrorResponse($e, $request);
			return $response;
		} 

	}

	/**
	 * Process the BookingRequest
	 *
	 * @return Response
	 */
	public function _BookingRequest($request)
	{
		
		$bookingData = $request['data'];
		//print_r($bookingData);exit;

		// first make sure BookReference doesn't already exist in Booking table
		$bookingReference = $bookingData["BookingReference"];
		$bookingExists = Booking::where("reference_number", "=", $bookingReference)->count();

		if($bookingExists)
		{
			// $message|$status|$code|$tStatus|$tReason
			throw new \Exception("A booking with the reference '$bookingReference' already exists in our system.", 409);
		}

		// fetch product details
		$productCode = $bookingData['SupplierProductCode'];
		$optionCode = $bookingData['TourOptions']['SupplierOptionCode'];
		$optionLanguageId = $this->_findLanguageIdFromOption(@$bookingData['TourOptions']['Option']);

		$mapping = ViatorMapping::where("TourCode", '=', $productCode)
					->where('TourGradeCode', '=', $optionCode)
					->where("Language", "=", $optionLanguageId)
					->first();
		//print_r($mapping->toArray());

		if( count($mapping)==0 )
		{
			throw new \Exception("Option-Language Not Found", 404);
			
		}

		// fetch product and productOption from mapping object
		$product = $mapping->product()->firstOrFail();
		$option = $mapping->productOption()->firstOrFail();
		//print_r($product->toArray());
		//print_r($option->toArray());
		
		
		// now get the option language. if langID is zero in mapping then fetch from TourOptons
		$languageId = $mapping->Language;
		if($languageId==0) 
		{
			$langCode = $bookingData['TourOptions']['Language']['LanguageCode'];
			$language = Language::where('code', '=', $langCode)->firstOrFail();
			$languageId = $language->id;
		}
		//echo "----Language = ". $languageId;exit;

		// check if the product option is available on this date with this language
		$availabilityParams = [
			"referenceNo" => $bookingReference,
			"totalPerson" => $bookingData['TravellerMix']['Total'],
    		"productOptionId" => $option->id,
    		"languageId" => $languageId,
    		"travelDate" => $bookingData['TravelDate']
    	];

    	$result = $this->_checkAvailability($availabilityParams);

    	if($result["status"] == "UNAVAILABLE")
    	{
    		if($result["reason"] == "BLOCKED_OUT") {
    			$reason = "NOT_OPERATING";
    		} else {
    			$reason = "OTHER";
    		}
    		// $message|$status|$code|$tStatus|$tReason
			throw new \Exception("$result[reason]|SUCCESS|-|REJECTED|$reason", 401);
    	}

		// check if any defalt Addon is attached
		$defaultAddon = null;
		if($mapping->AddonID > 0)
		{
			$defaultAddon = Addon::findOrFail($mapping->AddonID);
		}

		// fetch lead traveller and other travellers
		$leadTraveller = [];
		$travellers = isset($bookingData['Traveller']) ? $bookingData['Traveller'] : [];

		// calculate the special requirements
		$specialRequirements = '';
		$questions = isset($bookingData['RequiredInfo']) ? $bookingData['RequiredInfo'] : [];
		$specialRequirements = @$bookingData['SpecialRequirement'] ." \n". json_encode($questions);

		// find the contact details:
		$contactType = @$bookingData['ContactDetail']['ContactType'];
		$contactValue = @$bookingData['ContactDetail']['ContactValue'];
		$localContact = ($contactType == "MOBILE" or $contactType == "ALTERNATE") ? $contactValue : '';
		$email = ($contactType == "EMAIL") ? $contactValue : '';

		// extract the lead traveller out of these travellers
		foreach ($travellers as $key => &$traveller)
		{
			if($traveller['LeadTraveller']=="true")
			{
				$leadTraveller = $traveller;
				unset($travellers[$key]);
			}
		}

		// extract the booking notes/comments
		$comments = [];
		if(!empty($bookingData['SupplierNote']))
		{
			$comments[] = $bookingData['SupplierNote'];
		}

		// add AdditionalRemarks to comments as well:
		$remarks = isset($bookingData['AdditionalRemarks']) ? $bookingData['AdditionalRemarks'] : [];
		foreach($remarks as $remark)
		{
			$comments[] = $remark;
		}
		

		
		@list($city, $country) = @explode(',', $bookingData['Location']);


		// only child will be counted to child. all other AgeBands (young, adult, senior) will count to Adult.
		$adultCount = (int)@$bookingData['TravellerMix']['Total'] - (int)@$bookingData['TravellerMix']['Child'];

		//1st create the booking 
		$booking = new Booking;
		$booking->product_option_id			= $option->id;
		$booking->user_id                   = 2; // need to be confirmed
        $booking->currency_id               = 1;
        $booking->payment_method_id         = 6; // need to be confirmed
        $booking->source_name_id         	= 2; // viator
		$booking->guide_user_id             = 2; // need to be confirmed
		$booking->name                      = @$leadTraveller['TravellerTitle'] ." ". @$leadTraveller['GivenName'] ." ". @$leadTraveller['Surname'];
		$booking->local_contact             = $localContact; 		
		//$booking->hotel                     = $hotel; 				
		$booking->email                     = $email;
        //$booking->address_line_1            = $addressLine1;
        //$booking->address_line_2            = $addressLine2;
        $booking->city                      = $city;
        //$booking->state_province            = $stateProvince;
        $booking->country                   = $country;
        //$booking->zip                       = $zip;
		$booking->total_pax                 = (int)@$bookingData['TravellerMix']['Total'];
		$booking->no_children               = (int)@$bookingData['TravellerMix']['Child'];
		$booking->no_adult                  = $adultCount;
		$booking->special_reqs              = $specialRequirements;
        $booking->tour_paid                 = $bookingData['Amount'];
		$booking->travel_date				= $bookingData['TravelDate'];
		$booking->total_paid				= $bookingData['Amount'];
        $booking->paid_flag                 = true;
        $booking->pending                   = 1;
        $booking->deleted                   = false;
        $booking->refunded                  = false;
        $booking->reference_number          = @$bookingData['BookingReference'];
        $booking->language_id               = $languageId;
        $booking->pickup_point				= @$bookingData['PickupPoint'];
        $booking->created_at                = date('Y-m-d H:i:s');

        // now finally save the booking.
        $booking->save();

        // if packaged booking then add child bookings against child options
        $isPackage = $booking->product_option->package_flag;
        $packageIds = [];

        if($isPackage){
            $options = $booking->product_option->options;
            $packageIds[] = $booking->id;
            foreach($options as $packagedOption){
                $newBooking = $booking->replicate();
                $newBooking->total_paid = 0;
                $newBooking->tour_paid = 0;
                $newBooking->product_option_id = $packagedOption->id;
                $newBooking->promo_id = null;
                $newBooking->package = true;
                $newBooking->save();
                $packageIds[] = $newBooking->id;

                // save all other travellers against booking
		        foreach($travellers as $passengerItem){
		            $passenger = new BookingClient;
		            $passenger->booking_id = $newBooking->id;
		            $passenger->name = @$passengerItem['TravellerTitle'] ." ". @$passengerItem['GivenName'] ." ". @$passengerItem['Surname'];
		            $passenger->is_adult = ( strtolower($passengerItem['AgeBand']) == 'child') ? false : true;
		            $passenger->viator_id = $passengerItem['TravellerIdentifier'];
		            // Check for QueryException
		            try {
		                $passenger->save();
		            } catch (QueryException $e) {
		                //
		            }

		        }

            }
        }

        // now create an order against this booking
        $order = new Order;
        $order->reference_no = $booking->reference_number;
        $order->save();
        $orderBookings = new OrderBooking;
        $orderBookings->order_id = $order->id;
        $orderBookings->booking_id = $booking->id;
        $orderBookings->save();
        

        // save all other travellers against booking
        foreach($travellers as $passengerItem){
            $passenger = new BookingClient;
            $passenger->booking_id = $booking->id;
            $passenger->name = @$passengerItem['TravellerTitle'] ." ". @$passengerItem['GivenName'] ." ". @$passengerItem['Surname'];
            $passenger->is_adult = (strtolower($passengerItem['AgeBand']) == 'child') ? false : true;
            $passenger->viator_id = $passengerItem['TravellerIdentifier'];
            // Check for QueryException
            try {
                $passenger->save();
            } catch (QueryException $e) {
                //
            }

        }

        //addons
        if($defaultAddon)
        {
            $addon = new BookingAddon;
            $addon->booking_id = $booking->id;
            $addon->addon_id = $defaultAddon->id;
            $addon->no_adult = $booking->no_adult;
            $addon->no_children = $booking->no_children;
            $addon->payment_method_id = 6; // BANK TRANSFER
            $addon->paid = 0.00;
            $addon->paid_flag = 1;
            // Check for QueryException
            try {
                $addon->save();
            } catch (QueryException $e) {
                //
            }

        }

        //notes
        foreach($comments as $commentItem){
            $comment = new BookingComment;
            $comment->booking_id = $booking->id;
            // this is always the author, the one logged in
            $comment->user_id = 41; // Viator API user
            $comment->comment = $commentItem;
            // Check for QueryException
            try {
                $comment->save();
            } catch (QueryException $e) {
                //
            }
        }

        $this->_emailVoucher( $booking->id, "VIATOR API: Booking created." );

		$response = [
			'responseType' => "BookingResponse",
			"data" => [
				"ApiKey" => (string)@$bookingData['ApiKey'],
				"ResellerId" => (string)@$bookingData['ResellerId'],
				"SupplierId" => (string)@$bookingData['SupplierId'],
				"ExternalReference" => (string)@$bookingData['ExternalReference'],
				"Timestamp" => date("Y-m-d\TH:i:s.000P"),
				"RequestStatus" => [
					"Status" => "SUCCESS"
				],
				"BookingReference" => (string)@$bookingData['BookingReference'],
				//"SupplierCommentCustomer" => "Be on time.",
				"TransactionStatus" => [
					"Status" => "CONFIRMED",
					//"RejectionReasonDetails" => "Invalid Params",
					//"RejectionReason" => "NOT_OPERATING"
				],
				"SupplierConfirmationNumber" => (string)@$booking->id
			]
		];

		return $response;
		
	}

	/**
	 * Process the BookingAmendmentRequest
	 *
	 * @return Response
	 */
	public function _BookingAmendmentRequest($request)
	{
		
		$bookingData = $request['data'];
		//print_r($bookingData);exit;

		// first make sure BookReference doesn't already exist in Booking table
		$bookingReference = $bookingData["BookingReference"];
		$bookingConfirmationId = $bookingData["SupplierConfirmationNumber"];
		
		try {
		$booking = Booking::where("reference_number", "=", $bookingReference)
							->where("id", $bookingConfirmationId)
							->firstOrFail();
		} catch (\Exception $e) {
			throw new \Exception("Booking Not Found", 404);
		}
		
		// fetch product details
		$productCode = $bookingData['SupplierProductCode'];
		$optionCode = $bookingData['TourOptions']['SupplierOptionCode'];
		$optionLanguageId = $this->_findLanguageIdFromOption(@$bookingData['TourOptions']['Option']);

		$mapping = ViatorMapping::where("TourCode", '=', $productCode)
					->where('TourGradeCode', '=', $optionCode)
					->where('Language', '=', $optionLanguageId)
					->first();
		//print_r($mapping->toArray());

		if( count($mapping)==0 )
		{
			throw new \Exception("Option-Language Not Found", 404);
			
		}

		// fetch product and productOption from mapping object
		$product = $mapping->product()->firstOrFail();
		$option = $mapping->productOption()->firstOrFail();
		//print_r($product->toArray());
		//print_r($option->toArray());

		// first check if the user has changed the product option from non packaged to packaged?
		$bookingProductOptionChanged = ($booking->product_option_id != $option->id);
		
		
		// now get the option language. if langID is zero in mapping then fetch from TourOptons
		$languageId = $mapping->Language;
		if($languageId==0) 
		{
			$langCode = $bookingData['TourOptions']['Language']['LanguageCode'];
			$language = Language::where('code', '=', $langCode)->firstOrFail();
			$languageId = $language->id;
		}
		//echo "----Language = ". $languageId;exit;

		// check if the product option is available on this date with this language
		$availabilityParams = [
			"referenceNo" => $bookingReference,
			"totalPerson" => (int)@$bookingData['TravellerMix']['Total'],
    		"productOptionId" => $option->id,
    		"languageId" => $languageId,
    		"travelDate" => $bookingData['TravelDate']
    	];

    	$result = $this->_checkAvailability($availabilityParams);

    	if($result["status"] == "UNAVAILABLE")
    	{
    		if($result["reason"] == "BLOCKED_OUT") {
    			$reason = "NOT_OPERATING";
    		} else {
    			$reason = "OTHER";
    		}
    		// $message|$status|$code|$tStatus|$tReason
			throw new \Exception("$result[reason]|ERROR|401|REJECTED|$reason", 401);
    	}

		// check if any defalt Addon is attached
		$defaultAddon = null;
		if($mapping->AddonID > 0)
		{
			$defaultAddon = Addon::findOrFail($mapping->AddonID);
		}

		// fetch lead traveller and other travellers
		$leadTraveller = [];
		$travellers = isset($bookingData['Traveller']) ? $bookingData['Traveller'] : [];

		// calculate the special requirements
		$specialRequirements = '';
		$questions = isset($bookingData['RequiredInfo']) ? $bookingData['RequiredInfo'] : [];
		$specialRequirements = @$bookingData['SpecialRequirement'] ." \n". json_encode($questions);

		// find the contact details:
		$contactType = @$bookingData['ContactDetail']['ContactType'];
		$contactValue = @$bookingData['ContactDetail']['ContactValue'];
		$localContact = ($contactType == "MOBILE" or $contactType == "ALTERNATE") ? $contactValue : '';
		$email = ($contactType == "EMAIL") ? $contactValue : '';

		// extract the lead traveller out of these travellers
		foreach ($travellers as $key => &$traveller)
		{

			if($traveller['LeadTraveller']=="true")
			{
				$leadTraveller = $traveller;
				unset($travellers[$key]);
			}
		}

		// extract the booking notes/comments
		$comments = [];
		if(!@empty($bookingData['SupplierNote']))
		{
			$comments[] = $bookingData['SupplierNote'];
		}

		// add AdditionalRemarks to comments as well:
		$remarks = isset($bookingData['AdditionalRemarks']) ? $bookingData['AdditionalRemarks'] : [];
		foreach($remarks as $remark)
		{
			$comments[] = $remark;
		}
		

		
		@list($city, $country) = @explode(',', $bookingData['Location']);


		// only child will be counted to child. all other AgeBands (young, adult, senior) will count to Adult.
		$adultCount = (int)@$bookingData['TravellerMix']['Total'] - (int)@$bookingData['TravellerMix']['Child'];

		//1st create the booking 
		$booking->product_option_id			= $option->id;
		$booking->user_id                   = 2; // need to be confirmed
        $booking->currency_id               = 1;
        $booking->payment_method_id         = 6; // need to be confirmed
        $booking->source_name_id         	= 2; // viator
		$booking->guide_user_id             = 2; // need to be confirmed
		$booking->name                      = @$leadTraveller['TravellerTitle'] ." ". @$leadTraveller['GivenName'] ." ". @$leadTraveller['Surname'];
		$booking->local_contact             = $localContact; 		
		//$booking->hotel                     = $hotel; 				
		$booking->email                     = $email;
        //$booking->address_line_1            = $addressLine1;
        //$booking->address_line_2            = $addressLine2;
        $booking->city                      = $city;
        //$booking->state_province            = $stateProvince;
        $booking->country                   = $country;
        //$booking->zip                       = $zip;
		$booking->total_pax                 = (int)@$bookingData['TravellerMix']['Total'];
		$booking->no_children               = (int)@$bookingData['TravellerMix']['Child'];
		$booking->no_adult                  = $adultCount;
		$booking->special_reqs              = $specialRequirements;
        $booking->tour_paid                 = $bookingData['Amount'];
		$booking->travel_date				= $bookingData['TravelDate'];
		$booking->total_paid				= $bookingData['Amount'];
        $booking->paid_flag                 = true;
        $booking->pending                   = 1;
        $booking->deleted                   = false;
        $booking->refunded                  = false;
        //$booking->reference_number          = $bookingData['BookingReference']; // this need to be constant...
        $booking->language_id               = $languageId;
        $booking->pickup_point				= @$bookingData['PickupPoint'];
        $booking->updated_at                = date('Y-m-d H:i:s');

        // now finally save the booking.
        $booking->save();

        // if packaged booking then add child bookings against child options
        $isPackage = $booking->product_option->package_flag;
        $packageIds = [];

        // remove existing child-packags bookings against this main booking.
        $childBookings = Booking::where("reference_number", "=", $booking->reference_number)
        			->where("package", "=", 1)
        			->get();

        foreach($childBookings as $childBooking)
        {
        	$childBooking->delete();
        }

        // nwo check if this is packaged option then re-create child bookings
        if($isPackage){

            $options = $booking->product_option->options;
            //$packageIds[] = $booking->id; this booking is already added against this order. so skip this id.
            foreach($options as $packagedOption){
                $newBooking = $booking->replicate();
                $newBooking->total_paid = 0;
                $newBooking->tour_paid = 0;
                $newBooking->product_option_id = $packagedOption->id;
                $newBooking->promo_id = null;
                $newBooking->package = true;
                $newBooking->save();
                $packageIds[] = $newBooking->id;

                // save all other travellers against booking
		        foreach($travellers as $passengerItem){
		            $passenger = new BookingClient;
		            $passenger->booking_id = $newBooking->id;
		            $passenger->name = @$passengerItem['TravellerTitle'] ." ". @$passengerItem['GivenName'] ." ". @$passengerItem['Surname'];
		            $passenger->is_adult = ( strtolower($passengerItem['AgeBand']) == 'child') ? false : true;
		            // Check for QueryException
		            try {
		                $passenger->save();
		            } catch (QueryException $e) {
		                //
		            }

		        }

            }
        }

        // save all other travellers against booking
        $viatorTravellerIdentifiers = [];
        foreach($travellers as $passengerItem)
        {
        	$viatorTravellerIdentifiers[] = $passengerItem['TravellerIdentifier'];

            $passenger = $booking->clients()->firstOrNew(['viator_id' => $passengerItem['TravellerIdentifier']]);

            $passenger->booking_id = $booking->id;
            $passenger->name = @$passengerItem['TravellerTitle'] ." ". @$passengerItem['GivenName'] ." ". @$passengerItem['Surname'];
            $passenger->is_adult = (strtolower($passengerItem['AgeBand']) == 'child') ? false : true;
            // Check for QueryException
            try {
                $passenger->save();
            } catch (QueryException $e) {
                //
            }

        }

        //delete older travller records against this booking.
        $booking->clients()->whereNotIn("viator_id", $viatorTravellerIdentifiers)->delete();

        //addons
        if($defaultAddon)
        {
            $addon = $booking->addons()->firstOrNew(['addon_id' => $defaultAddon->id]);
            $addon->booking_id = $booking->id;
            $addon->addon_id = $defaultAddon->id;
            $addon->no_adult = $booking->no_adult;
            $addon->no_children = $booking->no_children;
            $addon->payment_method_id = 6; // BANK TRANSFER
            $addon->paid = 0.00;
            $addon->paid_flag = 1;
            // Check for QueryException
            try {
                $addon->save();
            } catch (QueryException $e) {
                //
            }

        }

        //notes
        foreach($comments as $commentItem){
            $comment = new BookingComment;
            $comment->booking_id = $booking->id;
            // this is always the author, the one logged in
            $comment->user_id = 41; // Viator API user
            $comment->comment = $commentItem;
            // Check for QueryException
            try {
                $comment->save();
            } catch (QueryException $e) {
                //
            }
        }

        $this->_emailVoucher( $booking->id, "VIATOR API: Booking amended." );

		$response = [
			'responseType' => "BookingAmendmentResponse",
			"data" => [
				"ApiKey" => (string)@$bookingData['ApiKey'],
				"ResellerId" => (string)@$bookingData['ResellerId'],
				"SupplierId" => (string)@$bookingData['SupplierId'],
				"ExternalReference" => (string)@$bookingData['ExternalReference'],
				"Timestamp" => date("Y-m-d\TH:i:s.000P"),
				"RequestStatus" => [
					"Status" => "SUCCESS"
				],
				"BookingReference" => (string)@$bookingData['BookingReference'],
				//"SupplierCommentCustomer" => "Be on time.",
				"TransactionStatus" => [
					"Status" => "CONFIRMED",
					//"RejectionReasonDetails" => "Invalid Params",
					//"RejectionReason" => "NOT_OPERATING"
				],
				"SupplierConfirmationNumber" => (string)@$booking->id
			]
		];

		return $response;
		
	}

	/**
	 * Process the BookingCancellationRequest
	 *
	 * @return Response
	 */
	public function _BookingCancellationRequest($request)
	{
		
		$bookingData = $request['data'];
		//print_r($bookingData);exit;

		// first make sure BookReference doesn't already exist in Booking table
		$bookingReference = $bookingData["BookingReference"];
		$bookingConfirmationId = $bookingData["SupplierConfirmationNumber"];

		try {
		$booking = Booking::where("reference_number", "=", $bookingReference)
							->where("id", $bookingConfirmationId)
							->firstOrFail();
		} catch (\Exception $e) {
			throw new \Exception("Booking Not Found", 404);
		}

		$travelDate = Carbon::createFromFormat("Y-m-d H:i:s", 
							$booking->travel_date ." ". $booking->product_option->start_time);

		$cancelDate = Carbon::createFromFormat('Y-m-d', $bookingData['CancelDate']);
		$now = Carbon::now();

		$requestStatus = [
					"Status" => "SUCCESS"
				];

		$transactionStatus = [
						"Status" => "CONFIRMED",
						//"RejectionReasonDetails" => "Invalid Params",
						//"RejectionReason" => "NOT_OPERATING"
					];

		// booking can be canceled only 3 days before start time
		$interval = new DateInterval('P3D');
		
		if($now->gt($travelDate))
		{
			$requestStatus = [
				"Status" => "Error",
				"Error" => [
					"ErrorCode" => "PAST_TOUR_DATE",
					"ErrorMessage" => "Tour Date is past",
					"ErrorDetails" => "Booking must have been cacelled 2 days before Trour Date."
				]
			];

			$transactionStatus = [
				"Status" => "REJECTED",
				"RejectionReasonDetails" => "Tour Date is past",
				"RejectionReason" => "PAST_TOUR_DATE "
			];
		}
		elseif($now->gt($travelDate->copy()->sub($interval)))
		{
			$requestStatus = [
				"Status" => "Error",
				"Error" => [
					"ErrorCode" => "PAST_CANCEL_DATE",
					"ErrorMessage" => "Cancellation date is in past",
					"ErrorDetails" => "Booking must be cancelled 3 days before travel date."
				]
			];

			$transactionStatus = [
				"Status" => "REJECTED",
				"RejectionReasonDetails" => "Booking must be cancelled 3 days before travel date.",
				"RejectionReason" => "PAST_CANCEL_DATE"
			];
		}
		else
		{
			// $booking->deleted = 1;
			// $booking->pending = 1;
			// $booking->save();

			// NOTE: instead of update one booking update all bookings against this reference number.
			$bookings = Booking::where("reference_number", "=", $bookingReference)
							->get();

			foreach($bookings as $b)
			{
				$b->deleted = 1;
				$b->pending = 1;
				$b->save();
			}

			// extract the booking notes/comments
			$comments = [];

			if( (isset($bookingData['Author']) and !empty($bookingData['Author'])) or (isset($bookingData['Reason']) and !empty($bookingData['Reason'])) )
			{
				$comments[] = @$bookingData['Author']." has cancelled the booking. REASON:  ".@$bookingData['Reason'];
			}

			if(isset($bookingData['SupplierNote']) and !empty($bookingData['SupplierNote']))
			{
				$comments[] = @$bookingData['SupplierNote'];
			}

	        //notes
	        foreach($comments as $commentItem){
	            $comment = new BookingComment;
	            $comment->booking_id = $booking->id;
	            // this is always the author, the one logged in
	            $comment->user_id = 41; // Viator API user
	            $comment->comment = $commentItem;
	            // Check for QueryException
	            try {
	                $comment->save();
	            } catch (QueryException $e) {
	                //
	            }
	        }
	    }

	    $this->_emailVoucher( $booking->id, "VIATOR API: Booking cancelled." );
		
		$response = [
			'responseType' => "BookingCancellationResponse",
			"data" => [
				"ApiKey" => (string)@$bookingData['ApiKey'],
				"ResellerId" => (string)@$bookingData['ResellerId'],
				"SupplierId" => (string)@$bookingData['SupplierId'],
				"ExternalReference" => (string)@$bookingData['ExternalReference'],
				"Timestamp" => date("Y-m-d\TH:i:s.000P"),
				"RequestStatus" => $requestStatus,
				"BookingReference" => (string)@$bookingData['BookingReference'],
				//"SupplierCommentCustomer" => "Be on time.",
				"TransactionStatus" => $transactionStatus,
				"SupplierConfirmationNumber" => (string)@$booking->id
			]
		];

		return $response;
		
	}

	/**
	 * Process the Availability Request
	 *
	 * @return Response
	 */
	public function _AvailabilityRequest($request)
	{
		
		$bookingData = $request['data'];
		//print_r($bookingData);exit;

		// fetch product details
		$productCode = $bookingData['SupplierProductCode'];
		$optionCode = @$bookingData['TourOptions']['SupplierOptionCode'];
		$optionLanguageId = $this->_findLanguageIdFromOption(@$bookingData['TourOptions']['Option']);
		
		$mappingQry = ViatorMapping::where("TourCode", '=', $productCode);

		if(!empty($optionCode))
		{
			$mappingQry->where('TourGradeCode', '=', $optionCode)
						->where("Language", "=", $optionLanguageId);
		}
		
		// this will return multiple mappings rows if SupplierOptionCode was not sent with request
		$mappings = $mappingQry->get();

		if( count($mappings) == 0 ) 
		{
			throw new \Exception("Option-Language Not Found", 404);
		}
		
		// this contains the availability responses generated through mappings loop.
		$availabilities = [];

		$availabilityParams = [
			'totalPerson' => isset($bookingData['TravellerMix']['Total']) ? $bookingData['TravellerMix']['Total'] : 0
		];

		$startDate = Carbon::createFromFormat("Y-m-d", $bookingData['StartDate']);
		$startDate2 = Carbon::createFromFormat("Y-m-d", $bookingData['StartDate']);
		$endDate = @$bookingData['EndDate'];

		$interval = new DateInterval('P1D');
		$dateRange = new DatePeriod( $startDate, $interval ,$startDate->copy()->add($interval) );
		
		// in case EndDate is also provide the calculate the complete dateRange
		if(!empty($endDate))
		{
			$endDate = Carbon::createFromFormat("Y-m-d", $bookingData['EndDate']);
			$dateRange = new DatePeriod( $startDate, $interval ,$endDate->add($interval) );
		}

		
		
		foreach($mappings as $mapping)
		{
			// fetch product and productOption from mapping object
			$product = $mapping->product()->firstOrFail();

			
			$option = $mapping->productOption()->firstOrFail();
			//print_r($option->toArray());continue;

			$availabilityParams['productOptionId'] = $option->id;

			// now get the option language. if langID is zero in mapping then fetch from TourOptions
			$languageId = $mapping->Language;

			if($languageId > 0) 
			{
				$optionLanguageIds = [$languageId];
			}
			else
			{
				$optionLanguageIds = $this->languageIds;
			}

			foreach($dateRange as $travelDate)
			{
				foreach($optionLanguageIds as $opLangId)
				{
					$availabilityParams['languageId'] = $opLangId;
					$availabilityParams['travelDate'] = $travelDate->format("Y-m-d");

					// echo PHP_EOL;
					// print_r($availabilityParams);
					// echo PHP_EOL;
					 $result = $this->_checkAvailability($availabilityParams);
					// print_r($result);

					 // mode param is not available in AvailabilityAPI
					 // if( $bookingData['Mode'] == "BLOCKOUTS" && $result["status"] == "AVAILABLE" )
					 // {
					 // 	// ignore AVAILABLE bookings.
					 // 	continue;	
					 // }

					// get language code
					$language = Language::find($opLangId);

					$availabilities[] = [
				        "Date" => $travelDate->format("Y-m-d"),
				        "TourOptions" =>  [
				         	"SupplierOptionCode" => $mapping->TourGradeCode,
				          	//"SupplierOptionName" => $mapping->TourGradeTitle,
				          	"Option" => [
					            [
					              	"Name" => "Language",
					              	"Value"=> strtoupper($language->code)
					            ]
					        ]
				          	// "Language" => [
				           //  	"LanguageCode" => strtoupper($language->code)
				          	// ]
				        ],
				        "AvailabilityStatus" => ($result["status"] == "AVAILABLE") ?  [ "Status" => "AVAILABLE" ] : ["Status" => "UNAVAILABLE", "UnavailabilityReason" => $result["reason"]],
				        //"AvailabilityHold" => []
				    ];
				}
			}
		}
		
		
		$response = [
			'responseType' => "AvailabilityResponse",
			"data" => [
				"ApiKey" => (string)@$bookingData['ApiKey'],
				"ResellerId" => (string)@$bookingData['ResellerId'],
				"SupplierId" => (string)@$bookingData['SupplierId'],
				"ExternalReference" => (string)@$bookingData['ExternalReference'],
				"Timestamp" => date("Y-m-d\TH:i:s.000P"),
				"RequestStatus" => [
					"Status" => "SUCCESS"
				],
				"SupplierProductCode" => (string)@$bookingData["SupplierProductCode"],
				"TourAvailability" => $availabilities
			]
		];

	
		return $response;
		
	}

	/**
	 * Process the Batch Availability Request
	 *
	 * @return Response
	 */
	public function _BatchAvailabilityRequest($request)
	{

		ini_set("max_execution_time", 180);

		$bookingData = $request['data'];
		//print_r($bookingData);exit;

		// fetch product details
		if(isset($bookingData["SupplierProductCode"]) and !empty( $bookingData["SupplierProductCode"] ))
		{
			if(!is_array($bookingData['SupplierProductCode']))
			{
				$productCodes = [ $bookingData['SupplierProductCode'] ];
			}
			else
			{
				$productCodes = $bookingData['SupplierProductCode'];
			}

			$mappingQry = ViatorMapping::whereIn("TourCode", $productCodes);
		}
		else
		{
			$mappingQry = ViatorMapping::where("id", ">", 0);
		}
		

		// this will return multiple mappings rows if SupplierOptionCode was not sent with request
		$mappings = $mappingQry->get();

		// get all supported languages. 
		$languageIds = Language::lists("id");
		
		// this contains the availability responses generated through mappings loop.
		$availabilities = [];

		$availabilityParams = [
			'totalPerson' => 0
		];

		$startDate = Carbon::createFromFormat("Y-m-d", $bookingData['StartDate']);
		$startDate2 = Carbon::createFromFormat("Y-m-d", $bookingData['StartDate']);
		$endDate = @$bookingData['EndDate'];

		$interval = new DateInterval('P1D');
		$dateRange = new DatePeriod( $startDate, $interval ,$startDate->copy()->add($interval) );
		
		// in case EndDate is also provide the calculate the complete dateRange
		if(!empty($endDate))
		{
			$endDate = Carbon::createFromFormat("Y-m-d", $bookingData['EndDate']);
			$dateRange = new DatePeriod( $startDate, $interval ,$endDate->add($interval) );
		}
		
		foreach($mappings as $mapping)
		{
			// fetch product and productOption from mapping object
			$product = $mapping->product()->firstOrFail();

			
			$option = $mapping->productOption()->firstOrFail();
			//print_r($option->toArray());continue;

			$availabilityParams['productOptionId'] = $option->id;

			// now get the option language. if langID is zero in mapping then fetch from TourOptions
			$languageId = $mapping->Language;

			if($languageId > 0) 
			{
				$optionLanguageIds = [$languageId];
			}
			else
			{
				$optionLanguageIds = $languageIds;
			}

			foreach($dateRange as $travelDate)
			{
				foreach($optionLanguageIds as $opLangId)
				{
					$availabilityParams['languageId'] = $opLangId;
					$availabilityParams['travelDate'] = $travelDate->format("Y-m-d");

					// echo PHP_EOL;
					// print_r($availabilityParams);
					// echo PHP_EOL;
					 $result = $this->_checkAvailability($availabilityParams);
					// print_r($result);

					 if( $bookingData['Mode'] == "BLOCKOUTS" && $result["status"] == "AVAILABLE" )
					 {
					 	// ignore AVAILABLE bookings.
					 	continue;	
					 }

					// get language code
					$language = Language::find($opLangId);

					$availabilities[] = [
				        "Date" => $travelDate->format("Y-m-d"),
				        "SupplierProductCode" => $mapping->TourCode,
				        "TourOptions" =>  [
				         	"SupplierOptionCode" => $mapping->TourGradeCode,
				          	//"SupplierOptionName" => $mapping->TourGradeTitle,
				          	"Option" => [
					            [
					              	"Name" => "Language",
					              	"Value"=> strtoupper($language->code)
					            ]
					        ]
				          	// "Language" => [
				           //  	"LanguageCode" => strtoupper($language->code)
				          	// ]
				        ],
				        "AvailabilityStatus" => ($result["status"] == "AVAILABLE") ?  [ "Status" => "AVAILABLE" ] : ["Status" => "UNAVAILABLE", "UnavailabilityReason" => $result["reason"]],
				        //"AvailabilityHold" => []
				    ];
				}
			}
		}
		
		
		$response = [
			'responseType' => "BatchAvailabilityResponse",
			"data" => [
				"ApiKey" => (string)@$bookingData['ApiKey'],
				"ResellerId" => (string)@$bookingData['ResellerId'],
				"SupplierId" => (string)@$bookingData['SupplierId'],
				"ExternalReference" => (string)@$bookingData['ExternalReference'],
				"Timestamp" => date("Y-m-d\TH:i:s.000P"),
				"RequestStatus" => [
					"Status" => "SUCCESS"
				],
				"BatchTourAvailability" => $availabilities
			]
		];

	
		return $response;
		
	}

	/**
	 * Process the Tour List Request
	 *
	 * @return Response
	 */
	public function _TourListRequest($request)
	{

		$bookingData = $request['data'];
		//print_r($bookingData);exit;

		$mappingQry = ViatorMapping::where("SupplierId", "=", $bookingData["SupplierId"]);

		// this will return multiple mappings rows if SupplierOptionCode was not sent with request
		$mappings = $mappingQry->get();

		// get all supported languages. 
		$languageIds = Language::lists("id", "code");
		
		$viatorProducts = [];

		foreach($mappings as $mapping)
		{
			$viatorProducts[$mapping->TourCode]["mapping"] = $mapping;
			$viatorProducts[$mapping->TourCode]["options"][] = $mapping;
			
		}

		$tours = [];

		foreach($viatorProducts as $viatorProduct)
		{
			$vProduct = $viatorProduct["mapping"];
			
			// now loop through tour options
		    $tourOptions = [];

		    foreach($viatorProduct["options"] as $vTourOptionMapping)
		    {
		    	$vTourOption = $vTourOptionMapping->productOption;

		    	$tourOptions[] = [
		            "SupplierOptionCode" => $vTourOptionMapping->TourGradeCode,
		            //"SupplierOptionName" => $vTourOptionMapping->TourGradeTitle,
		            "TourDepartureTime" => $vTourOption->start_time,
		            "TourDuration" => "PT". $vTourOption->duration ."S",
		            // "Option" => [
		            //   	"Name" => "Room",
		            //   	"Value" => "dualocc"
		            // ],
		            "Option" => [
			            [
			              	"Name" => "Language",
			              	"Value"=> strtoupper($vTourOptionMapping->language->code)
			            ]
			        ]
		        ];
		    }

		    $tmpTour = [
		        "SupplierProductCode" => $vProduct->TourCode,
		        "SupplierProductName" => $vProduct->TourName,
		        // "Language" => [
		        //   "LanguageCode" => "EN",
		        //   //"LanguageOption" => "GUIDE"
		        // ],
		        //"TourDepartureTime" => "09:00:00",
		        //"TourDuration" => "PT1D",
		        "CountryCode" => $vProduct->country->code,
		        "DestinationCode" => "IT ROM",
		        "DestinationName" => "Rome",
		        "TourDescription" => $vProduct->TourDescription,
		        "TourOption" => $tourOptions
		    ];

		    // finaly insert the tmpTour to main Tours array.
		    $tours[] = $tmpTour;
		}
		//print_r($tours);exit;
		
		$response = [
			'responseType' => "TourListResponse",
			"data" => [
				"ApiKey" => (string)@$bookingData['ApiKey'],
				"ResellerId" => (string)@$bookingData['ResellerId'],
				"SupplierId" => (string)@$bookingData['SupplierId'],
				"ExternalReference" => (string)@$bookingData['ExternalReference'],
				"Timestamp" => date("Y-m-d\TH:i:s.000P"),
				"RequestStatus" => [
					"Status" => "SUCCESS"
				],
				"Tour" => $tours
			]
		];

	
		return $response;
		
	}

	//400 = Bad Request
	//409 = Conflict / Duplicate
	private function _generateErrorResponse($e, $request) {
		$bookingData = $request['data'];

		$errorMsg = $e->getMessage();
		@list($message, $status, $code, $tStatus, $tReason) = explode("|", $errorMsg);

		$status = !empty($status) ? $status : "ERROR";
		$code = !empty($code) ? $code : $e->getCode();
		$message = !empty($message) ? $message : $e->getMessage();
		$tStatus = !empty($tStatus) ? $tStatus : "REJECTED";
		$tReason = !empty($tReason) ? $tReason : "OTHER";
		//print_r($e->getTrace);exit;

		$response = [
			'responseType' => str_replace("Request", "Response", @$request['requestType']),
			"data" => [
				"ApiKey" => (string)@$bookingData['ApiKey'],
				"ResellerId" => (string)@$bookingData['ResellerId'],
				"SupplierId" => (string)@$bookingData['SupplierId'],
				"ExternalReference" => (string)@$bookingData['ExternalReference'],
				"RequestStatus" => [
					"Status" => (string)$status
				],
				"BookingReference" => (string)@$bookingData['BookingReference'],
				"TransactionStatus" => [
					"Status" => (string)$tStatus,
					"RejectionReasonDetails" => $message . " - " .$e->getLine(),
					"RejectionReason" => (string)$tReason
				]
			]
		];

		if($status != "SUCCESS")
		{
			$response["data"]["RequestStatus"]["Error"] = [
						"ErrorCode" => (string)$code,
						"ErrorMessage" => $message . " - " .$e->getLine(),
						//"ErrorDetails" => $e->getTrace()
					];
		}

		// look for mandatory params and add
		if(isset($bookingData["SupplierConfirmationNumber"]))
		{
			$response["data"]["SupplierConfirmationNumber"] = $bookingData["SupplierConfirmationNumber"];
		}

		$this->_log(["response" => print_r($response, true)]);

		return $response;
	}

	public function _checkAvailability($params=[]){
        $bookingId = @$params['bookingId'];
        $productOptionId = @$params['productOptionId'];
        $dateInput = @$params['travelDate'];
        $totalPerson = @$params['totalPerson'];
        $referenceNo = @$params['referenceNo'];
        $language = @$params['languageId'];
        $date = Helpers::formatDate($dateInput);
        $travelDate = $dateCarbon = Carbon::parse($date); // travelDate
        $dayOfWeek = $dateCarbon->dayOfWeek;
        $today = Carbon::now();

        $bookingDate = Carbon::parse(date("Y-m-d"));
        
        $update = false;

        if($bookingId > 0)
        {
        	$booking = Booking::find($bookingId);
        }
        else
        {
        	$booking = Booking::where("reference_number", "=", $referenceNo)->first();
        }

        if(!empty($booking)){
            $update = true;
        }

        //$warningMessages = array();

        $productOption = ProductOption::find($productOptionId);
        $availabilitySlotId = $productOption->availability_slot_id;
        
        $noEvent = false;

        if( !$noEvent and $productOption->trav_season_start != "0000-00-00" )
        { 
        	$poTravelStartDate = Carbon::createFromFormat("Y-m-d", $productOption->trav_season_start);
        	
        	if($travelDate->lt($poTravelStartDate))
        	{
        		$noEvent = true;
        	}
        }

        if( !$noEvent and $productOption->trav_season_end != "0000-00-00" )
        {
        	$poTravelEndDate = Carbon::createFromFormat("Y-m-d", $productOption->trav_season_end);

        	if($travelDate->gt($poTravelEndDate))
        	{
        		$noEvent = true;
        	}
        }

        if($noEvent)
        {
        	return ["status" => "UNAVAILABLE", "reason" => "NO_EVENT"];
        }

        $cutOffDate = false;

        if( !$cutOffDate and $productOption->book_season_start != "0000-00-00" )
        {
        	$poBookStartDate = Carbon::createFromFormat("Y-m-d", $productOption->book_season_start);

        	if($today->lt($poBookStartDate))
        	{
        		$cutOffDate = true;
        	}
        }

        if( !$cutOffDate and $productOption->book_season_end != "0000-00-00" )
        {
        	$poBookEndDate = Carbon::createFromFormat("Y-m-d", $productOption->book_season_end);

        	if($today->gt($poBookEndDate))
        	{
        		$cutOffDate = true;
        	}
        }

        if($cutOffDate)
        {
        	return ["status" => "UNAVAILABLE", "reason" => "PAST_CUTOFF_DATE"];
        }

        $checkLimit = true;
        $tourManagerRepository = new TourManagerRepository();
        $totals = $tourManagerRepository->getTotalsByAvailabilityAndDate($availabilitySlotId,$date);

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
            //$warningMessages[] =  "This product option does not run on this day of the week ($day)";
            return ["status" => "UNAVAILABLE", "reason" => "BLOCKED_OUT"];
        }

        $productOptionLanguage = ProductOptionLanguage::where('product_option_id','=',$productOptionId)->where('language_id',$language)->first();

        $closedDate = null;

        if(!empty($productOptionLanguage)){
            $closedDate = ProductOptionLanguageUnavailableDay::where('product_options_language_id',$productOptionLanguage->id)->where('date',$date)->first();
        }

        if(!empty($closedDate)){
            //$warningMessages[] =  "You have chosen a date ($dateInput) that was specified as a closed tour option";
            return ["status" => "UNAVAILABLE", "reason" => "BLOCKED_OUT"];
        }

        $unavailableDays = ProductOptionUnavailableDay::where('product_option_id','=',$productOptionId)->get();
        $unavailableDaysArray = array();

        foreach($unavailableDays as $unavailableDay){
            $unavailableDaysArray[] = $unavailableDay->date;
        }

        if(in_array($date,$unavailableDaysArray)){
            //$warningMessages[] =  "You have chosen a date ($dateInput) that was specified as unavailable";
        	return ["status" => "UNAVAILABLE", "reason" => "BLOCKED_OUT"];
        }


        if($checkLimit){


            $guideCount = $tourManagerRepository->getGuideTotalByAvailabilityAndDate($availabilitySlotId,$date);
            $guideCount = (int)$guideCount->guide_count;
            $remaining = $totals->remaining;
            if(!empty($remaining)){
                $remaining = $remaining - $guideCount;
            }
            if($update){
                $remaining = $remaining + $booking->total_pax;
            }
            if( ($remaining > 0) &&  ($totalPerson > $remaining)){

                //$warningMessages[] =  "There are $remaining spots left available for this product option for the date chosen.";
                return ["status" => "UNAVAILABLE", "reason" => "SOLD_OUT"];
            }
            if($remaining < 1){
                //$warningMessages[] =  "There are no spots left available for this product option for the date chosen.";
                return ["status" => "UNAVAILABLE", "reason" => "SOLD_OUT"];
            }
        }

        // now check for package options
        if( $productOption->package_flag )
        {
            foreach ($productOption->options as $option)
            {
                
		        $packagedParams = [
		        	"bookingId" => $bookingId,
		        	"productOptionId" => $option->id,
		        	"travelDate" => $dateInput,
		        	"totalPerson" => $totalPerson,
		        	"referenceNo" => $referenceNo,
		        	"languageId" => $language
		        ];

                $packageResult = $this->_checkAvailability( $packagedParams );

                if( $packageResult["status"] == "UNAVAILABLE" )
                {
                	return $packageResult;
                }
            }
        }

        return ["status" => "AVAILABLE", "reason" => ""];

    }

    private function _setLanguages() 
    {
    	$languages = Language::lists("code", "id");
    	
    	foreach($languages as $id => $code)
    	{
    		$this->languageCodes[$id] = strtoupper($code);
    		$this->languageIds[strtoupper($code)] = $id;
    	}
    }


    private function _findLanguageIdFromOption($options) 
    {
    	$languageCode = "";
    	$options = (array)$options;

    	foreach($options as $option)
    	{
    		if($option["Name"] == "Language")
    		{
    			$languageCode = $option["Value"];
    		}
    	}

    	return (int)@$this->languageIds[$languageCode];
    }

 	private function _emailVoucher($bookingId, $subject=""){

        if($bookingId){

            $booking = Booking::with("payment_method", "addons")->find($bookingId);


            $cc = "booking@ecoarttravel.com";
            $to = $booking->product_option->product->provider->email;

            if($to == "$cc")
            {
            	$cc = null;
            }
            
            $productOption = ProductOption::find($booking->product_option_id);
            $product = Product::find($productOption->product_id);

            $providerId = $product->provider_id;
            $languageId = $booking->language_id;

            // get the voucher based on provider id and language id
            $voucher = Voucher::with("provider")->where(array(
                "provider_id" => $providerId,
                "language_id" => $languageId
                ))->first();

            if(!$voucher){
                return "This booking does not have a voucher";
            }

            $html = \View::make("vouchers.templates.email")->render();

            $html = Voucher::parseVoucher($html, $voucher, $booking, $productOption, $product);

            // now removing the empty values from the dom

            $emailHtmlDOM = new Htmldom;
            $emailHtmlDOM->load($html);
            $infoTableRows = $emailHtmlDOM->find("#infoList tr");
            foreach ($infoTableRows as $key => $tr) {
                if(isset($tr->find("td span")[0])){
                    if(empty($tr->find("td span")[0]->innertext)){
                        $tr->outertext = "";
                        $emailHtmlDOM->save();
                    }   
                }
            }
            $html = $emailHtmlDOM;

            try{
                $sent = $this->mail->send(array(), array(), function($message) use ($booking, $html, $subject, $to, $cc){
                    $message->replyTo("booking@ecoarttravel.com", "EcoArt Travel");
                    $message->from("booking@ecoarttravel.com", "EcoArt Travel");
                    
                    $message->to($to)->subject($subject);

                    if($cc)
                    {
                    	$message->cc("booking@ecoarttravel.com");
                    }
                    $message->cc("a2zbits@gmail.com");

                    $message->setBody($html, "text/html");
                });
                return true;
                
            }catch(\Exception $e){

                return false;
            }

        }

    }

}
