<?php namespace App\Http\Controllers;

use App\Country;
use App\Product;
use App\ProductOption;
use App\Promo;
use App\Booking;
use App\Order;
use App\Voucher;
use App\Libraries\Helpers;
use Yangqi\Htmldom\Htmldom;

use App\Libraries\Repositories\CartRepository;
use App\Libraries\GestPayCryptWS;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ShoppingCartController extends Controller {

	public function __construct(CartRepository $cartRepository)
	{
		ini_set('soap.wsdl_cache_enabled', '0'); 
		ini_set('soap.wsdl_cache_ttl', '0'); 
		$this->cartRepository = $cartRepository;
	}

	public function index()
	{

		// //require_once "../lib/GestPayCryptWS.php";
		// $gestpay = new \GestPayCryptWS();
		// $gestpay->setShopLogin("GESPAY63329"); // Es. 9000001
		// $gestpay->setShopTransactionID("My-Trans-ID-".time()); // Identificativo transazione. Es. "34az85ord19"
		// $gestpay->setAmount("0.01"); // Importo. Es.: 1256.50
		// $gestpay->setCurrency("242"); // Codice valuta. 242 = euro
		// $gestpay->setTestEnv(true);
		
		// if (!$gestpay->encrypt()) {
		//     throw new \Exception(
		//         "Error: " . $gestpay->getErrorCode() . ": " . $gestpay->getErrorDescription()
		//     );
		// }

		// return Redirect($gestpay->getRedirectUrl());

		$countries = Country::all();

		return view('shopping_cart.index', compact('countries'));

	}

	public function postCheckout()
	{
		$rules = array(

            'first_name'			=> 'required',
            'last_name' 			=> 'required',
            'email' 				=> 'required|email|confirmed',
            'special_requirements' 	=> '',
            'phone_number'			=> 'required',
            'hotel'					=> '',
            'country'				=> 'required',
            'terms'					=> 'accepted'

        );

        $validation = \Validator::make(Input::all(), $rules);

        $paymentMethod = Input::get('payment_method');

        // store the user contact information in cart session
    	Session::set('cart.first_name', Input::get('first_name'));
    	Session::set('cart.last_name', Input::get('last_name'));
    	Session::set('cart.email', Input::get('email'));
    	Session::set('cart.email_confirmation', Input::get('email_confirmation'));
    	Session::set('cart.special_requirements', Input::get('special_requirements'));
    	Session::set('cart.phone_number', Input::get('phone_number'));
    	Session::set('cart.hotel', Input::get('hotel'));
    	Session::set('cart.payment_method', $paymentMethod);
    	Session::set('cart.country', Input::get('country'));
    	Session::set('cart.terms', Input::get('terms'));

        if( $validation->passes() )
        {


        	// get cart object from session
        	$cart = $this->cartRepository->getCart();

        	// first create an order
        	$orderId = Session::get('cart.order_id', null);
        	if( $orderId )
        	{
	        	$order = Order::find( $orderId );
	        }
	        else
	        {
	        	$order = new Order();
	        	$order->created_at = date('Y-m-d H:i:s');
	        	Session::set('cart.order_id', $order->id);

	        }

	        $order->updated_at = date('Y-m-d H:i:s');
	        $order->save();

	        // remove existing attachments 
	        $order->bookings()->detach();

        	$cartProducts = $cart['products'];

        	// create booking against each product in order
        	foreach( $cartProducts as &$cartProduct )
        	{
        		$name = Input::get('first_name').' '.Input::get('last_name');
        		$totalPax = $cartProduct->adult_no + $cartProduct->child_no;
        		$travelDate = date('Y-m-d', strtotime($cartProduct->bookingDate));

        		if( $cartProduct->booking_id )
        		{
        			$booking = Booking::find($cartProduct->booking_id);
        		}
        		else
        		{
		        	$booking = new Booking;
        		}

        		// get product option to know if on_request_flag is set to 1
        		$productOption = ProductOption::find($cartProduct->product_option_id);

				$booking->product_option_id			= $cartProduct->product_option_id;	
				$booking->promo_id                  = $cartProduct->promo_id;
				$booking->payment_method_id         = Session::get('cart.paymentMethodId', 3); 	
				$booking->source_name_id            = 8; // Online - EcoArt Website
				$booking->user_id                   = 2; // need to be confirmed
		        $booking->currency_id               = 1;
				$booking->guide_user_id             = 2; // need to be confirmed
				$booking->name                      = $name;
				$booking->local_contact             = Input::get('phone_number', null);
				$booking->hotel                     = Input::get('hotel', null);
				$booking->email                     = Input::get('email', null);
		        $booking->country                   = Input::get('country', null);
				$booking->total_pax                 = $totalPax;
				$booking->no_children               = $cartProduct->child_no;
				$booking->no_adult                  = $cartProduct->adult_no;
				$booking->special_reqs              = Input::get('special_requirements', null);
		        $booking->tour_paid                 = $cartProduct->price;
				$booking->travel_date				= $travelDate;
				$booking->total_paid				= $cartProduct->totalPrice;
		        $booking->paid_flag                 = 0;
		        $booking->pending 					= $productOption->on_request_flag; // if product option has on_request_flag=1 then make the booking as pending.
				$booking->feedback_request_sent     = false;
		        $booking->deleted                   = false;
		        $booking->refunded                  = false;
		        $booking->reference_number          = '';
		        $booking->language_id               = $cartProduct->language_id;
		        $booking->created_at                = date('Y-m-d');
		        $booking->save();

		        $cartProduct->booking_id = $booking->id;

		        // attach this booking to order
		        $order->bookings()->attach($booking->id);
		    }

		    // reset the cart products to new values if changed
		    Session::set('cart.products', $cartProducts);

		    // now redirect to GestPay Payment page based on the payment method selected
			$gestpay = new GestPayCryptWS();

			if( $paymentMethod == 'Web-PayPal' )
			{
				$gestpay->setOptParam('paymentTypes', ['PAYPAL']);
			}
			elseif( $paymentMethod == 'Web-CC' )
			{
				//$gestpay->setOptParam('paymentTypes', ['CREDITCARD']);
			}

			$gestpay->setShopLogin( Config::get('app.shopLogin') ); // Es. 9000001
			$gestpay->setShopTransactionID($order->id); // Identificativo transazione. Es. "34az85ord19"
			$gestpay->setAmount( $cart['totalCartValue'] ); // Importo. Es.: 1256.50
			//$gestpay->setAmount( 0.01 ); // Importo. Es.: 1256.50
			$gestpay->setCurrency("242"); // Codice valuta. 242 = euro
			//$gestpay->setLanguage( 2 ); // English. 1 = Italiano
			$gestpay->setTestEnv( Config::get('app.shopTestEnvironment') );
			
			if (!$gestpay->encrypt()) {
			    throw new \Exception(
			        "Error: " . $gestpay->getErrorCode() . ": " . $gestpay->getErrorDescription()
			    );
			}

			return Redirect($gestpay->getRedirectUrl());
		    //return \Redirect::back()->withInput();
        }
        else
        {
        	return \Redirect::back()->withErrors($validation)->withInput();
        }

        
	}
	
	public function gestpayCallback(\Illuminate\Mail\Mailer $mail)
	{
		$successMsg = '';
		$errorMsg = '';
        $a = Input::get("a");
        $b = Input::get("b");

        if(empty($a) or empty($b))
        {
        	$result = "ParamMissing";
        }
        else
        {

			$gestpay = new GestPayCryptWS();
			$gestpay->setShopLogin( Input::get("a") );
			$gestpay->setEncryptedString( Input::get("b") );
			//$gestpay->setLanguage( 2 ); // English. 1 = Italiano
			$gestpay->setTestEnv( Config::get('app.shopTestEnvironment') );

			$gestpay->decrypt();
			
			$result = $gestpay->getTransactionResult();

			$errorCode = $gestpay->getErrorCode();
			$errorDescription = $gestpay->getErrorDescription();
			

			// if ($result == "XX" or $result == "OK")
			// {
			// 	if( $result == "XX" )
			// 	{
			// 		$successMsg = "Grazie per il pagamento. Il tuo ordine sarà confermato come soos il vostro pagamento è confermato dalla banca. Ci informare il via email.";
			// 	}
			//     elseif( $result == "OK" )
			//     {
			//     	$successMsg = "Grazie per il pagamento. Il vostro ordine è confermato. Un nostro agente può rivolgersi via e-mail, se necessario.";
			//     }

			// }
			// elseif ($result == "KO")
			// {
			// 	return redirect("/shopping-cart")->withError("Siamo spiacenti, il pagamento è fallito. Per favore riprova più tardi.");
			//     //echo "Esito transazione negativo\n";
			// } 
			// else 
			// {
			// 	return redirect("/shopping-cart")->withError("Ci dispiace. Un errore sconosciuto si è verificato durante il pagamento. Per favore riprova più tardi.");
			//     //echo "Esito transazione indefinito\n";
			// }

			// on success remove the cart entries from session.
			if( $result == "XX" or $result == "OK" )
			{
				Session::set('cart', []);
				Session::set('cart.products', []);

				// update the paid flag in booking to true
				$orderId = $shopTransactionId = $gestpay->getShopTransactionID();
				$bankTransactionId = $gestpay->getBankTransactionID();
				$authorizationCode = $gestpay->getAuthorizationCode();

				//$orderId = 683;

				//$order = Order::find($orderId);
				$order = Order::with(
							'bookings.product_option.product', 
							'bookings.product_option.language'
						)->find( $orderId );

				if( $order )
				{
					foreach( $order->bookings as $booking )
					{
						$reference_number = $bankTransactionId ." - ". $authorizationCode;
						$booking->reference_number = $reference_number;
						$booking->paid_flag = 1;

						$booking->save();

						// donot send a voucher email because we already have sent this in S2S call
						//$this->sendEmailVoucher($booking->id, $mail);
					}
				}
				else
				{
					$result = "OKButOrderNotFound";
					//return redirect("/shopping-cart")->withError("Il pagamento è stato autorizzato, ma un errore si è verificato sul server. Si prega di contattare l'amministratore del sito.");
				}

				//return redirect("/shopping-cart")->withSuccess($successMsg);
			}
		}

		//$result = "KO";
		// $orderId = 1382;
		// $order = Order::with('bookings.product_option.product', 'bookings.product_option.language')->find( $orderId );
		//dd($order->toArray());
		

		return view('shopping_cart.success', compact('result', 'order', 'errorCode', 'errorDescription'));

	}

	public function gestpayServerCallback(\Illuminate\Mail\Mailer $mail)
	{
		$a = Input::get("a");
        $b = Input::get("b");


        try{

	        if(empty($a) or empty($b))
	        {
	        	$result = "ParamMissing";
	        }
	        else
	        {

				$gestpay = new GestPayCryptWS();
				$gestpay->setShopLogin( Input::get("a") );
				$gestpay->setEncryptedString( Input::get("b") );
				//$gestpay->setLanguage( 2 ); // English. 1 = Italiano
				$gestpay->setTestEnv( Config::get('app.shopTestEnvironment') );

				if (!$gestpay->decrypt()) 
				{
				    $result = "GestPayErrorOrDecryptFailed";
				}
				else
				{
					$result = $gestpay->getTransactionResult();
				}

				
				// on success remove the cart entries from session.
				if( $result == "XX" or $result == "OK" )
				{
					// update the paid flag in booking to true
					$orderId = $shopTransactionId = $gestpay->getShopTransactionID();
					$bankTransactionId = $gestpay->getBankTransactionID();
					$authorizationCode = $gestpay->getAuthorizationCode();

					$order = Order::with(
								'bookings.product_option.product', 
								'bookings.product_option.language'
							)->find( $orderId );

					if( $order )
					{
						foreach( $order->bookings as $booking )
						{
							$reference_number = $bankTransactionId ." - ". $authorizationCode;
							$booking->reference_number = $reference_number;
							$booking->paid_flag = 1;

							$booking->save();

							// now send the voucher emails
							$this->sendEmailVoucher($booking->id, $mail);
						}
					}
					else
					{
						$result = "OKButOrderNotFound";
						//return redirect("/shopping-cart")->withError("Il pagamento è stato autorizzato, ma un errore si è verificato sul server. Si prega di contattare l'amministratore del sito.");
					}

					//return redirect("/shopping-cart")->withSuccess($successMsg);
				}
			}

		
			$errorCode = $gestpay->getErrorCode();
			$errorDescription = $gestpay->getErrorDescription();
			Log::info("GestPay Error: $result - $errorCode - $errorDescription");

			$orderId = $shopTransactionId = $gestpay->getShopTransactionID();
			Log::info("GestPay OrderId = $result - $orderId");

		} catch( \Exception $e ) {
			Log::error("GestPay Exception: ". $e->getMessage());
		} catch( \FatalErrorException $e ) {
			Log::error("GestPay Exception: ". $e->getMessage());
		} catch( \Symfony\Component\Debug\Exception\FatalErrorException $e) {
			Log::error("GestPay Exception: ". $e->getMessage());
		}
		
		return "<html></html>";

	}

	public function addTours()
	{
		// get a random tourse to add to cart for testing
		$tour = Product::orderByRaw('RAND()')->first();

		//Session::set('cart.products', []);
		if(!Session::has('cart.products'))
		{ 
			Session::set('cart.products', []);
			Session::set('cart.promo_code', null);
			Session::set('cart.promo_id', null);
		}

		$booking = new \stdClass();
		$booking->cartItemId = time(); // This must be unique
		$booking->productId = $tour->id;
		$booking->bookingDate = Helpers::displayDateShort(date("d M Y",strtotime("+1 week")));
		$booking->adult_no = rand(1,5);
		$booking->child_no = rand(1,5);
		$booking->booking_id = null;

		$option = $tour->options()->first();
		$booking->product_option_id = $option ? $option->id : null;

		Session::push('cart.products', $booking);

		if(Input::get('clearCart') == 'yes')
		{
			Session::set('cart.products', []);
		}

		echo "<a href='/add-tours?clearCart=yes'>Clear Cart</a><br>
			<a href='/add-tours'>Add Tour</a><br>
		";

	}

	public function orderSummary()
	{
		// fetch order history products from session.
		$products = Session::get('cart.products');
		$cart = $this->cartRepository->getCart();
		
		//dd(Session::get('cart'));
		return view('partials.cart-order-summary', compact('cart','products'));
	}

	public function removeItem($id)
	{
		// fetch order history products from session.

		$products = Session::get('cart.products');
		
		foreach($products as $key => $product)
		{
			if($product->cartItemId == $id)
			{
				unset($products[$key]);
			}
		}

		Session::set('cart.products', $products);
		
		
		return 'Success';

	}



	public function addPromoCode()
	{
		// fetch order history products from session.

		Session::set('cart.promo_code', Input::get('promo_code'));

		$promo = Promo::where('code', '=', Input::get('promo_code'))->first();

		if( $promo ) 
		{
			Session::set('cart.promo_id', $promo->id);
		}
		else
		{
			Session::set('cart.promo_id', null);
		}

		return 'Success';

	}

	public function sendEmailVoucher($bookingId, \Illuminate\Mail\Mailer $mail){

        if($bookingId){

            $booking = Booking::with("payment_method", "addons")->find($bookingId);

            // $booking->email = "mohdsajjadashraf@yahoo.com";
            if(!$booking->email){
                return "This booking does not have an email address";
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

                        $to = $booking->email;
                        $cc = null;

			            // dont send voucher for on-request options.
			            if( $booking->product_option->on_request_flag == 1 )
			            {
			            	$to = $booking->product_option->product->provider->email;
			            	$cc = "booking@ecoarttravel.com";

			            	if($to == $cc)
			            	{
			            		$cc = null;
			            	}

							$message->to($to)->subject("Thank you for your booking!");
			            	
                        }
                        else
                        {
                        	$to = $booking->email;
                        	$name = $booking->name;

			            	$cc = $booking->product_option->product->provider->email;

			            	if($cc != "booking@ecoarttravel.com")
			            	{
			            		$cc = [$cc, "booking@ecoarttravel.com"];
			            	}

							$message->to($to, $name)->subject("Thank you for your booking!");
                        }

                        if(!empty($cc))
                        {
                        	$message->cc($cc);
                        }

                        //$message->cc("a2zbits@gmail.com");

                        $message->setBody($html, "text/html");
                    });
                //return redirect()->back()->with("success", "Email Sent Successfully");
                
            }catch(\Exception $e){
                //return redirect()->back()->with("error", "Email Sending failed, Please try again<br>{$e->getMessage()}");
            }

        }

    }
	

}
