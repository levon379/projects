<?php namespace App\Http\Controllers;

use App\AddonsProduct;
use App\Booking;
use App\BookingAddon;
use App\BookingClient;
use App\BookingComment;
use App\Language;
use App\Libraries\Helpers;
use App\Libraries\Repositories\BookingsRepository;
use App\Libraries\Repositories\ProductOptionsRepository;
use App\Libraries\Repositories\ProductsRepository;
use App\Order;
use App\OrderBooking;
use App\Product;
use App\ProductOption;
use App\Promo;
use App\Addon;
use App\PaymentMethod;
use App\SourceName;
use App\SourceGroup;
use App\User;
use \App\Voucher;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Validator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Yangqi\Htmldom\Htmldom;

class BookingsController extends Controller {

    public function __construct(Guard $auth, ProductsRepository $productsRepository, ProductOptionsRepository $productOptionsRepository, BookingsRepository $bookingsRepository){
        $this->productsRepository = $productsRepository;
        $this->productOptionsRepository = $productOptionsRepository;
        $this->bookingsRepository = $bookingsRepository;
        $this->auth = $auth;
    }

    public function index(){
        $bookings = Booking::paginate(10);
        return view('bookings.index',compact('bookings'));
    }

    public function search(){
        // parameters
        $provider = Input::get('pr');
        $bookingFrom = Input::get('bf');
        $bookingTo = Input::get('bt');
        $bookingReference = Input::get('br');
        $orderReference = Input::get('or');
        $travelFrom = Input::get('tf');
        $travelTo = Input::get('tt');
        $product = Input::get('pd');
        $productOption = Input::get('po');
        $sourceGroup = Input::get('sg');
        $sourceName = Input::get('sn');
        $paymentMethod = Input::get('pm');
        $paid = Input::get('pa');
        $pending = Input::get('pe');
        $query = Input::get('q');
        $package = Input::get('pk',1);
        $pageSize = Input::get('ps',25);
        $page = Input::get('page',1);
        $refunded = Input::get('refunded', 0);
        $deleted = Input::get('deleted', 0);
        /*
        $bookingFrom = urldecode($bookingFrom);
        $bookingTo = urldecode($bookingTo);
        $travelFrom = urldecode($travelFrom);
        $travelTo = urldecode($travelTo);
        $provider = urldecode($provider);
        $query = urldecode($query);
        */
        if(is_null($deleted)){
            $deleted = '0';
        }
        if(is_null($refunded)){
            $refunded = '0';
        }
        $bookingValues = $this->bookingsRepository->getBookingsByFilter(
            $bookingFrom,$bookingTo,$travelFrom,$travelTo,$bookingReference,
            $orderReference,$sourceGroup,$sourceName,$product,$productOption,
            $paymentMethod,$paid,$pending,$provider,$package,$query,
            $pageSize,$page,$refunded,$deleted
            );

        $bookings = $bookingValues->bookings;
        $bookingsTotal = $bookingValues->total;

        $queryString = (Input::query());

        // dd(Request::url(), $queryString);

        $bookings = new Paginator($bookings,$bookingsTotal,$pageSize, $page, [
            'path' => Request::url(),
            'query' => array_except($queryString,'page')
        ]);


        $paymentMethods = PaymentMethod::all();
        $sourceGroups = SourceGroup::all();
        $products = Product::all();
        return view('bookings.search',compact('bookings','paymentMethods','sourceGroups','products','pagination','bookingValues'));
    }

    public function add(){
        $orderPassedId = Input::get('order');
        $mode = 'add';

        $orderId = Input::old('order_id',$orderPassedId ?: "");

        $productId = Input::old('product_id',0);
        $languageId = Input::old('language_id', 1);
        $sourceGroupId = Input::old('source_group_id',0);

        $travelDate = Input::old('travel_date');
        $bookingDate = Input::old('booking_date');

        // Depends On Product Id
        $addons = AddonsProduct::where('product_id','=',$productId)->get();

        $productOptions = $this->productOptionsRepository->getProductOptionsByProductLanguageDates($productId,$languageId,$bookingDate,$travelDate);

        $products = $this->productsRepository->getProductsByProductOptionLanguageDates($languageId,$bookingDate,$travelDate);

        $sourceNames = SourceName::where('source_group_id','=',$sourceGroupId)->get();

        // Populate Dynamic Array Values (addons,passengers,comments)
        $addonsOld = Helpers::getAddons(Input::old('addon_id',[]),Input::old('no_adult_addons',[]),Input::old('no_children_addons',[]),Input::old('payment_method_id_addons',[]),Input::old('paid_addons',null),Input::old('total_paid_addons',[]),Input::old('booking_addon_id',[]),Input::old('kid_disabled',[]));
        $passengersOld = Helpers::getPassengers(Input::old('client_name',[]),Input::old('adult_flag',null),Input::old('booking_passenger_id',[]));
        $commentsOld = Helpers::getComments(Input::old('comment_text'),Input::old('comment_firstname'),Input::old('comment_lastname'),Input::old('comment_user'),Input::old('comment_date'),Input::old('booking_comment_id'));

        // Always Show
        // $promos = Promo::all();
        $promos =  array();
		$paymentMethods = PaymentMethod::all();
		$sourceGroups = SourceGroup::all();
		$guides = User::where('user_type_id','=',3)->get();
        $languages = Language::all();

        $deleted = false;
        $refunded = false;

        return view('bookings.add_edit',compact('orderId','deleted','refunded','products','languages', 'productOptions', 'promos','paymentMethods', 'addons','addonsOld','passengersOld','commentsOld','sourceNames', 'sourceGroups', 'users', 'mode', 'guides'));
    }

    public function postAdd(){
        $productOptionId 		= Input::get('product_option_id');
        $promoId 				= Input::get('promo_id');
        $paymentMethodId 		= Input::get('payment_method_id');
        $sourceNameId 			= Input::get('source_name_id');
        $guideUserId 			= Input::get('guide_user_id');
        $name 				    = Input::get('name');
        $localContact 			= Input::get('local_contact');
        $hotel 					= Input::get('hotel');
        $email 					= Input::get('email');
        $addressLine1 			= Input::get('address_line1');
        $addressLine2 			= Input::get('address_line2');
        $city 					= Input::get('city');
        $stateProvince 			= Input::get('state_province');
        $country 				= Input::get('country');
        $zip 					= Input::get('zip');
		$totalPax 				= Input::get('total_pax');
		$noChildren 			= Input::get('no_children');
		$noAdult 				= Input::get('no_adult');
		$specialReqs 			= Input::get('special_reqs');
        $tourPaid 			    = Input::get('tour_price');
		$travelDate 			= Input::get('travel_date');
		$totalPaid 				= Input::get('total_price');
		$voucher 				= Input::get('voucher');
		$paidFlag 				= Input::get('paid_flag');
        $pending                = Input::get('pending');
		$feedbackRequestSent 	= Input::get('feedback_request_sent');
		$referenceNumber 	    = Input::get('reference_number');
        $orderId                = Input::get('order_id');
        $languageId             = Input::get('language_id');
        $bookingDate            = Input::get('booking_date');

        // passengers
        $names                   = Input::get('client_name');
        $adultFlag               = Input::get('adult_flag');
        $clientId                = Input::get('booking_passenger_id');

        $passengers              = Helpers::getPassengers($names,$adultFlag,$clientId);

        // addons
        $addonIds                = Input::get('addon_id');
        $noAdultAddons           = Input::get('no_adult_addons');
        $noChildAddons           = Input::get('no_children_addons');
        $paymentMethodIds        = Input::get('payment_method_id_addons');
        $paid                    = Input::get('paid_addons');
        $totalPaidAddons         = Input::get('total_paid_addons');
        $addonId                 = Input::get('booking_addon_id');
        $kidDisabled             = Input::get('kid_disabled');

        $addons                  = Helpers::getAddons($addonIds,$noAdultAddons,$noChildAddons,$paymentMethodIds,$paid,$totalPaidAddons,$addonId,$kidDisabled);

        // comments
        $commentText             = Input::get('comment_text');
        $commentUser             = Input::get('comment_user');
        $commentFirstName        = Input::get('comment_firstname');
        $commentLastName         = Input::get('comment_lastname');
        $commentDate             = Input::get('comment_date');
        $commentId               = Input::get('comment_id');

        $comments                = Helpers::getComments($commentText,$commentFirstName,$commentLastName,$commentUser,$commentDate,$commentId);

        $booking = new Booking;
		$booking->product_option_id			= $productOptionId;	
		$booking->promo_id                  = $promoId;
		$booking->payment_method_id         = $paymentMethodId; 	
		$booking->source_name_id            = $sourceNameId; 		
		$booking->user_id                   = Auth::user()->id;
        $booking->currency_id               = 1;
		$booking->guide_user_id             = $guideUserId; 		
		$booking->name                      = $name;
		$booking->local_contact             = $localContact; 		
		$booking->hotel                     = $hotel; 				
		$booking->email                     = $email;
        $booking->address_line_1            = $addressLine1;
        $booking->address_line_2            = $addressLine2;
        $booking->city                      = $city;
        $booking->state_province            = $stateProvince;
        $booking->country                   = $country;
        $booking->zip                       = $zip;
		$booking->total_pax                 = $totalPax; 			
		$booking->no_children               = $noChildren; 		
		$booking->no_adult                  = $noAdult; 			
		$booking->special_reqs              = $specialReqs; 		
        $booking->tour_paid                 = empty($tourPaid) ? 0 : Helpers::cleanPrice($tourPaid);
		$booking->travel_date				= Helpers::formatDate($travelDate);
		$booking->total_paid				= empty($totalPaid) ? 0 : Helpers::cleanPrice($totalPaid);
		$booking->voucher                   = $voucher; 			
        $booking->paid_flag                 = $paidFlag>0 ? true : false;
        $booking->pending                   = $pending>0 ? true : false;
		$booking->feedback_request_sent     = isset($feedbackRequestSent) ? true : false;
        $booking->deleted                   = false;
        $booking->refunded                  = false;
        $booking->reference_number          = $referenceNumber;
        $booking->language_id               = $languageId;
        $booking->created_at                = Helpers::formatDate($bookingDate);
        $input = Input::all();

	    $rules = array(

            'product_option_id' => 'required',
            'source_name_id' => 'required',

            'name' => 'required',

            'no_adult' => 'at_least:1',
            'travel_date' => 'required',
        );

        $messages = array(
            'product_option_id.required' => 'Please choose a product option',
            'source_name_id.required' => 'Please choose a source name',

            'name.required' => 'This name field is required',

            'no_adult.at_least' => 'There should be at least 1 adult',
            'travel_date.required' => 'This travel date field is required',
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

            $booking->save();

            if($booking->id){

                $isPackage = $booking->product_option->package_flag;
                $packageIds = [];

                if($isPackage){
                    $options = $booking->product_option->options;
                    $packageIds[] = $booking->id;
                    foreach($options as $option){
                        $newBooking = $booking->replicate();
                        $newBooking->total_paid = 0;
                        $newBooking->tour_paid = 0;
                        $newBooking->product_option_id = $option->id;
                        $newBooking->promo_id = null;
                        $newBooking->package = true;
                        $newBooking->save();
                        $packageIds[] = $newBooking->id;

                        //passengers
                        foreach($passengers as $passengerItem){
                            $passenger = new BookingClient;
                            $passenger->booking_id = $newBooking->id;
                            $passenger->name = $passengerItem->name;
                            $passenger->is_adult = $passengerItem->adult_flag;
                            // Check for QueryException
                            try {
                                $passenger->save();
                            } catch (QueryException $e) {
                                //
                            }

                        }

                    }
                }


                if(!empty($orderId)){
                    $orderBookings = new OrderBooking;
                    $orderBookings->order_id = $orderId;
                    $orderBookings->booking_id = $booking->id;
                    $orderBookings->save();
                } else {
                    $order = new Order;
                    $order->reference_no = $booking->reference_number;
                    $order->save();
                    $orderBookings = new OrderBooking;
                    $orderBookings->order_id = $order->id;
                    $orderBookings->booking_id = $booking->id;
                    $orderBookings->save();
                }


                //addons
                foreach($addons as $addonItem){
                    $addon = new BookingAddon;
                    $addon->booking_id = $booking->id;
                    $addon->addon_id = $addonItem->id;
                    $addon->no_adult = $addonItem->no_adult;
                    $addon->no_children = $addonItem->no_children;
                    $addon->payment_method_id = $addonItem->payment_method_id;
                    $addon->paid = Helpers::cleanPrice($addonItem->paid);
                    $addon->paid_flag = $addonItem->paid_flag;
                    // Check for QueryException
                    try {
                        $addon->save();
                    } catch (QueryException $e) {
                        //
                    }

                }


                //passengers
                foreach($passengers as $passengerItem){
                    $passenger = new BookingClient;
                    $passenger->booking_id = $booking->id;
                    $passenger->name = $passengerItem->name;
                    $passenger->is_adult = $passengerItem->adult_flag;
                    // Check for QueryException
                    try {
                        $passenger->save();
                    } catch (QueryException $e) {
                        //
                    }

                }

                //notes
                foreach($comments as $commentItem){
                    $comment = new BookingComment;
                    $comment->booking_id = $booking->id;
                    // this is always the author, the one logged in
                    $comment->user_id = Auth::user()->id;
                    $comment->comment = $commentItem->comment;
                    // Check for QueryException
                    try {
                        $comment->save();
                    } catch (QueryException $e) {
                        //
                    }
                }

                if(!empty($orderId)){
                    $order = Order::find($orderId);
                    return redirect("/admin/orders/")
                        ->with('success',"Booking successfully added to order <b>#$order->reference_no</b>");
                }

                $successRedirectUrl = "/admin/bookings/search?bf=" . date("d/m/Y") . "&bt=" . date("d/m/Y");

                if($isPackage){
                    $bookingString = "";
                    foreach($packageIds as $bookingId){
                        $bookingString .= " <a href='/admin/bookings/$bookingId/edit'>#$bookingId</a>";
                    }
                    return redirect($successRedirectUrl)
                        ->with('success',"Bookings$bookingString successfully added");
                }

                return redirect($successRedirectUrl)
                    ->with('success','Booking successfully added');
            }
        }

        return redirect("/admin/bookings/add")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $orderPassedId = Input::get('order');
        $mode = 'edit';

        $orderId = Input::old('order_id',$orderPassedId ?: "");

        $booking = Booking::find($id);

        if($booking == null){
            return redirect("/admin/bookings/");
        }

        $productId = Input::old('product_id',$booking->product_option->product->id);
        $sourceGroupId = Input::old('source_group_id',$booking->source_name->source_group->id);

        $travelDate = Input::old('travel_date', $booking->travel_date);
        $bookingDate = $booking->created_at->toDateString();
        $bookingDate = $booking->created_at->toDateString();
        $languageId = Input::old('language_id', $booking->language_id);

        // Depends on Product Id
        $addons = AddonsProduct::where('product_id','=',$productId)->get();

        $productOptions = $this->productOptionsRepository->getProductOptionsByProductLanguageDates($productId,$languageId,$bookingDate,$travelDate);

        $products = $this->productsRepository->getProductsByProductOptionLanguageDates($languageId,$bookingDate,$travelDate);

        $sourceNames = SourceName::where('source_group_id','=',$sourceGroupId)->get();

        // Populate Dynamic Array Values (addons,passengers,comments)
        $addonsOld = Helpers::getAddons(Input::old('addon_id',[]),Input::old('no_adult_addons',[]),Input::old('no_children_addons',[]),Input::old('payment_method_id_addons',[]),Input::old('paid_addons',null),Input::old('total_paid_addons',[]),Input::old('booking_addon_id',[]),Input::old('kid_disabled',[]));
        $addonsOld = count($addonsOld)>0 ?  $addonsOld : Helpers::mapAddons($booking->addons) ;
        $passengersOld = Helpers::getPassengers(Input::old('client_name',[]),Input::old('adult_flag',null),Input::old('booking_passenger_id',[]));
        $passengersOld = count($passengersOld)>0 ?$passengersOld :  Helpers::mapPassengers($booking->clients) ;
        $commentsOld = Helpers::getComments(Input::old('comment_text'),Input::old('comment_firstname'),Input::old('comment_lastname'),Input::old('comment_user'),Input::old('comment_date'),Input::old('booking_comment_id'));
        $commentsOld = count($commentsOld)>0 ? $commentsOld : Helpers::mapComments($booking->comments);

        // Always Show
        $promos = Promo::all();
        $paymentMethods = PaymentMethod::all();
        $sourceGroups = SourceGroup::all();
        $guides = User::where('user_type_id','=',3)->get();
        $languages = Language::all();

        $deleted = $booking->deleted;
        $refunded = $booking->refunded;
        $feedbacksent = $booking->feedback_request_sent;
        $feedbackSentBy = $booking->getNameOfUser();
        if($booking->feedback_request_sent_date != null){
            $feedbackDate = Helpers::displayDate($booking->feedback_request_sent_date->toDateString());
        } else {
            $feedbackDate = "";
        }


        return view('bookings.add_edit',compact('feedbacksent','feedbackSentBy','feedbackDate','orderId','deleted','refunded','booking', 'bookingAddons', 'products', 'languages','productOptions', 'promos','paymentMethods', 'addons','addonsOld','passengersOld','commentsOld','sourceNames', 'sourceGroups', 'users', 'mode', 'guides'));
    }

    public function postEdit($id){

        $productOptionId 		= Input::get('product_option_id');
        $promoId 				= Input::get('promo_id');
        $paymentMethodId 		= Input::get('payment_method_id');
        $sourceNameId 			= Input::get('source_name_id');
        $guideUserId 			= Input::get('guide_user_id');
        $name 			    	= Input::get('name');
        $localContact 			= Input::get('local_contact');
        $hotel 					= Input::get('hotel');
        $email 					= Input::get('email');
        $addressLine1 			= Input::get('address_line1');
        $addressLine2 			= Input::get('address_line2');
        $city 					= Input::get('city');
        $stateProvince 			= Input::get('state_province');
        $country 				= Input::get('country');
        $zip 					= Input::get('zip');
        $totalPax 				= Input::get('total_pax');
        $noChildren 			= Input::get('no_children');
        $noAdult 				= Input::get('no_adult');
        $specialReqs 			= Input::get('special_reqs');
        $tourPaid 			    = Input::get('tour_price');
        $travelDate 			= Input::get('travel_date');
        $totalPaid 				= Input::get('total_price');
        $voucher 				= Input::get('voucher');
        $paidFlag 				= Input::get('paid_flag');
        $pending                = Input::get('pending', 0);
        $feedbackRequestSent 	= Input::get('feedback_request_sent');
        $referenceNumber 	    = Input::get('reference_number');
        $orderId                = Input::get('order_id');
        $languageId             = Input::get('language_id');
        $bookingDate            = Input::get('booking_date');

        // passengers
        $names                   = Input::get('client_name');
        $adultFlag               = Input::get('adult_flag');
        $clientId                = Input::get('booking_passenger_id');

        $passengers              = Helpers::getPassengers($names,$adultFlag,$clientId);

        // addons
        $addonIds                = Input::get('addon_id');
        $noAdultAddons           = Input::get('no_adult_addons');
        $noChildAddons           = Input::get('no_children_addons');
        $paymentMethodIds        = Input::get('payment_method_id_addons');
        $paid                    = Input::get('paid_addons');
        $totalPaidAddons         = Input::get('total_paid_addons');
        $addonId                 = Input::get('booking_addon_id');
        $kidDisabled             = Input::get('kid_disabled');

        $addons                  = Helpers::getAddons($addonIds,$noAdultAddons,$noChildAddons,$paymentMethodIds,$paid,$totalPaidAddons,$addonId,$kidDisabled);

        // comments
        $commentText             = Input::get('comment_text');
        $commentUser             = Input::get('comment_user');
        $commentFirstName        = Input::get('comment_firstname');
        $commentLastName         = Input::get('comment_lastname');
        $commentDate             = Input::get('comment_date');
        $commentId               = Input::get('booking_comment_id');

        $comments                = Helpers::getComments($commentText,$commentFirstName,$commentLastName,$commentUser,$commentDate,$commentId);


        $booking = Booking::find($id);
        $booking->product_option_id			= $productOptionId;
        $booking->promo_id                  = $promoId;
        $booking->payment_method_id         = $paymentMethodId;
        $booking->source_name_id            = $sourceNameId;
        $booking->user_id                   = Auth::user()->id;
        $booking->currency_id               = 1;
        $booking->guide_user_id             = $guideUserId;
        $booking->name                      = $name;
        $booking->local_contact             = $localContact;
        $booking->hotel                     = $hotel;
        $booking->email                     = $email;
        $booking->address_line_1            = $addressLine1;
        $booking->address_line_2            = $addressLine2;
        $booking->city                      = $city;
        $booking->state_province            = $stateProvince;
        $booking->country                   = $country;
        $booking->zip                       = $zip;
        $booking->total_pax                 = $totalPax;
        $booking->no_children               = $noChildren;
        $booking->no_adult                  = $noAdult;
        $booking->special_reqs              = $specialReqs;
        $booking->tour_paid                 = empty($tourPaid) ? 0 : Helpers::cleanPrice($tourPaid);
        $booking->travel_date				= Helpers::formatDate($travelDate);
        $booking->total_paid				= empty($totalPaid) ? 0 : Helpers::cleanPrice($totalPaid);
        $booking->voucher                   = $voucher;
        $booking->paid_flag                 = $paidFlag > 0 ? true : false;
        $booking->pending                   = $pending > 0 ? true : false;
        $booking->feedback_request_sent     = isset($feedbackRequestSent) ? true : false;
        $booking->reference_number          = $referenceNumber;
        $booking->language_id               = $languageId;
        $booking->created_at                = Helpers::formatDate($bookingDate);

        $input = Input::all();

        $rules = array(

            'product_option_id' => 'required',
            'source_name_id' => 'required',

            'name' => 'required',

            'no_adult' => 'at_least:1',
            'travel_date' => 'required',
        );

        $messages = array(
            'product_option_id.required' => 'Please choose a product option',
            'source_name_id.required' => 'Please choose a source name',

            'name.required' => 'This name field is required',

            'no_adult.at_least' => 'There should be at least 1 adult',
            'travel_date.required' => 'This travel date field is required',
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

            $booking->save();

            if($booking->id){
                // addons passenger and notes DELETE done using ajax

                //addons
                foreach($addons as $addonItem){

                    if($addonItem->addon_id > 0){
                        $addon = BookingAddon::find($addonItem->addon_id);
                    } else {
                        $addon = new BookingAddon;
                    }

                    $addon->booking_id = $booking->id;
                    $addon->addon_id = $addonItem->id;
                    $addon->no_adult = $addonItem->no_adult;
                    $addon->no_children = $addonItem->no_children;
                    $addon->payment_method_id = $addonItem->payment_method_id;
                    $addon->paid = Helpers::cleanPrice($addonItem->paid);
                    $addon->paid_flag = $addonItem->paid_flag;
                    // Check for QueryException
                    try {
                        $addon->save();
                    } catch (QueryException $e) {
                        //
                    }

                }


                //passengers
                foreach($passengers as $passengerItem){

                    if($passengerItem->client_id > 0){
                        $passenger = BookingClient::find($passengerItem->client_id);
                    } else {
                        $passenger = new BookingClient;
                    }

                    $passenger->booking_id = $booking->id;
                    $passenger->name = $passengerItem->name;
                    $passenger->is_adult = $passengerItem->adult_flag;
                    // Check for QueryException
                    try {
                        $passenger->save();
                    } catch (QueryException $e) {
                        //
                    }

                }

                //notes
                foreach($comments as $commentItem){

                    if($commentItem->comment_id > 0){
                        $comment = BookingComment::find($commentItem->comment_id);
                    } else {
                        // this is always the author, the one logged in
                        $comment = new BookingComment;
                        $comment->user_id = Auth::user()->id;
                    }

                    $comment->booking_id = $booking->id;
                    $comment->comment = $commentItem->comment;
                    // Check for QueryException
                    try {
                        $comment->save();
                    } catch (QueryException $e) {
                        //
                    }
                }

                if(!empty($orderId)){
                    $bookingLink = "<a href='/admin/bookings/$id/edit?order=$orderId'>Booking #$id</a>";
                    return redirect("/admin/orders/$orderId/bookings")
                        ->with('success',"$bookingLink successfully updated ");
                }

                $bookingLink = "<a href='/admin/bookings/$id/edit'>Booking #$id</a>";

                $successRedirectUrl = "/admin/bookings/search?bf=" . date("d/m/Y") . "&bt=" . date("d/m/Y");

                return redirect($successRedirectUrl)
                    ->with('success',"$bookingLink successfully updated");
            }
        }

        return redirect("/admin/bookings/$id/edit")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $booking = Booking::find($id);

        try {
            OrderBooking::where('booking_id','=',$booking->id)->delete();
            BookingComment::where('booking_id','=',$booking->id)->delete();
            BookingAddon::where('booking_id','=',$booking->id)->delete();
            BookingClient::where('booking_id','=',$booking->id)->delete();
            $booking->delete();
        } catch (QueryException $e) {
            Session::flash('error', "Booking cannot be deleted it is being used");
            return;
            //return redirect('/admin/bookings')->with("error","Booking cannot be deleted it is being used");
        }

        Session::flash('success', "Booking has been deleted successfully");
        //return redirect('/admin/bookings')->with("success","Booking has been deleted successfully");

    }

    public function getPrintVoucher($bookingId){

        if($bookingId){

            $booking = Booking::with("payment_method", "addons")->find($bookingId);
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

            $html = \View::make("vouchers.templates.main", compact("booking"))->render();

            $html = Voucher::parseVoucher($html, $voucher, $booking, $productOption, $product);

            return $html;

        }

    }

    public function getEmailVoucher($bookingId, \Illuminate\Mail\Mailer $mail){

        if($bookingId){

            $booking = Booking::with("payment_method", "addons")->find($bookingId);
            // $booking->email = "mohdsajjadashraf@yahoo.com";
            if(!$booking->email){
                return redirect()->to("admin/bookings/{$booking->id}/voucher/print")->with("error", "This booking does not have an email address");
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
                $sent = $mail->send(array(), array(), function($message) use ($booking, $html){
                        $message->replyTo("booking@ecoarttravel.com", "EcoArt Travel");
                        $message->from("booking@ecoarttravel.com", "EcoArt Travel");
                        $message->to($booking->email, $booking->name)->subject("Thank you for your booking!")->cc("booking@ecoarttravel.com");
                        $message->setBody($html, "text/html");
                    });
                return redirect()->back()->with("success", "Email Sent Successfully");
                
            }catch(\Exception $e){
                return redirect()->back()->with("error", "Email Sending failed, Please try again<br>{$e->getMessage()}");
            }

        }

    }

}

