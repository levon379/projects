<?php namespace App\Http\Controllers;

use \App\Voucher;
use \App\Language;
use \App\Website;
use \App\Booking;
use \App\ProductOption;
use \App\Product;
use \App\Provider;
use Illuminate\Support\Facades\View;

class VouchersController extends Controller{

	public function index(){
		$vouchers = Voucher::with("language", "provider")->paginate(15);
		$booking = Booking::first();
		$hasBookings = ($booking) ? true : false;
		return view("vouchers.index", compact("vouchers", "hasBookings"));
	}

	public function getAddVoucher(){
		$languages = Language::get();
		$websites = Website::get();
		$providers = Provider::get();
		return view("vouchers.add", compact("websites", "languages", "providers"));
	}

	public function getVoucherPreview($id){
		$voucher = Voucher::with("provider")->find($id);
		$booking = Booking::with("payment_method", "addons")->first();
		if(!$booking){
			return redirect()->to("/admin/vouchers")->with("error", "No bookings found. Please add new bookings");
        }
        $productOption = ProductOption::find($booking->product_option_id);
        $product = Product::find($productOption->product_id);

        $providerId = $product->provider_id;
        $languageId = $booking->language_id;


		$html = View::make("vouchers.templates.main", compact("booking"))->render();


        $html = Voucher::parseVoucher($html, $voucher, $booking, $productOption, $product);
        if(!$html){
        	return "No Voucher Found";
        }
        return $html;
	}

	public function postAddVoucher(){

		$input = Input::all();
		$validator = Validator::make($input, Voucher::$rules, Voucher::$messages);
		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors($validator);
		}else{
			$voucher = new \App\Voucher;
			$voucher->name = $input["name"];
			$voucher->greeting = $input["greeting"];
			$voucher->language_id = $input["language_id"];
			$voucher->provider_id = $input["provider_id"];
			// dd("Passed", $input, $voucher->toArray());
			if($voucher->save()){
				// now update the pivot vouchers_websites
				foreach($input["website_ids"] as $websiteId){
					$voucher->websites()->attach($websiteId);
				}
				return redirect()->to("/admin/vouchers")->with("success", "Voucher successfully added");
			}
		}
	}

	public function getEditVoucher($id){
		$languages = Language::get();
		$websites = Website::get();
		$providers = Provider::get();
		$voucher = Voucher::find($id);
		return view("vouchers.edit", compact("websites", "languages", "providers", "voucher"));
	}

	public function postEditVoucher($id){

		$input = Input::all();
		$validator = Validator::make($input, Voucher::$rules, Voucher::$messages);
		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors($validator);
		}else{
			$voucher = Voucher::find($id);
			$voucher->name = $input["name"];
			$voucher->greeting = $input["greeting"];
			$voucher->language_id = $input["language_id"];
			$voucher->provider_id = $input["provider_id"];
			// dd("Passed", $input, $voucher->toArray());
			if($voucher->save()){
				// now update the pivot vouchers_websites
				$voucher->websites()->sync($input["website_ids"]);
				return redirect()->to("/admin/vouchers")->with("success", "Voucher successfully added");
			}
		}
	}

	public function getDeleteVoucher($id){
		if($id){
			$voucher = Voucher::find($id);
			if($voucher){
				$voucher->websites()->detach();
				$voucher->delete();
				return redirect()->back()->with("success", "Voucher successfully removed");
			}
		}
		return redirect()->back()->with("error", "Something went wrong, Please try again");
	}

}