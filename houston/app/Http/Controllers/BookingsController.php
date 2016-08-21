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

