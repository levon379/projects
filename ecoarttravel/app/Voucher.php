<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Libraries\Helpers;
use Carbon\Carbon;

class Voucher extends Model{

	protected $fillable = [];

	public static $rules = array(
		"name" => "required|max:50",
		"language_id" => "required",
		"provider_id" => "required",
		"greeting" => "required",
		);

	public static $messages = array(
		"name.required" => "This name field is required",
        "greeting.required" => "This greeting field is required",
		"name.max" => "Name can have a maximum of 50 characters",
		"language_id.required" => "This language field is required",
		"provider_id.required" => "This provider field is required",
		);

	public function websites(){
		return $this->belongsToMany("\App\Website", "vouchers_websites");
	}

	public function language(){
		return $this->belongsTo("\App\Language");
	}

	public function provider(){
		return $this->belongsTo("\App\Provider");
	}

	public static function parseVoucher($html, $voucher, $booking, $productOption, $product){
		// parsing the template
		if(!isset($voucher)){
            return null;
		}
		$html = str_replace("[[greeting]]", $voucher->greeting, $html);
        $html = str_replace("[[created_at]]", Helpers::displayDateFormat($booking->created_at, "M d, Y"), $html);
        $html = str_replace("[[provider_name]]", $voucher->provider->name, $html);
        $html = str_replace("[[name]]", $booking->name, $html);
        $html = str_replace("[[reference_number]]", $booking->reference_number, $html);
        $html = str_replace("[[travel_date]]", Helpers::displayDateFormat($booking->travel_date, "M d, Y"), $html);
        $html = str_replace("[[total_pax]]", $booking->total_pax, $html);
        $html = str_replace("[[no_adult]]", $booking->no_adult, $html);
        $html = str_replace("[[no_children]]", $booking->no_children, $html);
        $html = str_replace("[[product_name]]", "{$product->name} - {$productOption->name} - {$voucher->language->name}", $html);
        $html = str_replace("[[departure_time]]", Carbon::parse($productOption->start_time)->format("H:i A"), $html);
        $html = str_replace("[[total_paid]]", $booking->total_paid . " " . $booking->currency->name, $html);
        $html = str_replace("[[tour_paid]]", $booking->tour_paid . " " . $booking->currency->name, $html);
        $html = str_replace("[[payment_method]]", $booking->payment_method->name, $html);
        $departpoint_instructions = strip_tags(str_replace("<", " <", $product->language_details->first()->departpoint));
        $html = str_replace("[[departpoint_instructions]]", $departpoint_instructions, $html);
        $html = str_replace("[[provider_contact_details]]", $voucher->provider->contact_info, $html);

        $html = str_replace("[[cancelpolicy]]", $product->language_details->first()->cancelpolicy, $html);
        $html = str_replace("[[what_to_bring]]", $product->language_details->first()->what_to_bring, $html);
        $html = str_replace("[[additionalinfo]]", $product->language_details->first()->additionalinfo, $html);

        $clients = "";
        foreach ($booking->clients as $key => $value) {
            $clients .= "{$value->name}, ";   
        }
        $clients = rtrim($clients, ", ");
        $html = str_replace("[[passengers]]", $clients, $html);

        $addonsNames = "";
        foreach ($booking->addons as $key => $addon) {
            $addonsNames .= "{$addon->name} ";
        }
        $addonsNames = trim($addonsNames);

        $html = str_replace("[[addon_names]]", $addonsNames, $html);


        // main_logo
        $providerImagePath = asset("assets/images/ecoart/print-logo.png");
        $html = str_replace("[[main_logo]]", $providerImagePath, $html);

        // small_logo
        $smallLogo = asset("images/providers/{$voucher->provider->id}");
        $html = str_replace("[[small_logo]]", $smallLogo, $html);

        /* Generating map image from google maps iframe */
        $mapUrl = $product->language_details->first()->departure_point_map;
        $queryString = parse_url($mapUrl)["query"];
        parse_str($queryString, $output);
        $query = $output["q"];
        $hnear = urlencode($output['hnear']);
        $newUrl = "center={$query}&ie=UTF8&hq=&hnear={hnear}&markers=color:red|{$query}&ie=UTF8&hq=&hnear={hnear}&size=392x262&zoom=16";
        $newMapUrl = "https://maps.googleapis.com/maps/api/staticmap?" . ($newUrl);
        $html = str_replace("[[map_image]]", $newMapUrl, $html);

        return $html;
	}

}