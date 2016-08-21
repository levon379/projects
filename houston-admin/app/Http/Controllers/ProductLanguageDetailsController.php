<?php namespace App\Http\Controllers;

use App\Language;
use App\Libraries\Helpers;
use App\Product;
use App\ProductLanguageDetail;
use App\ProductLanguageDetailsUnavailableDay;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class ProductLanguageDetailsController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index($id){
        $product = Product::find($id);
        $productDetails = $product->language_details;
        return view('products.language_details.index',compact('productDetails', 'mode','product'));
    }

    public function add($id){
        $mode = 'add';
        $productId = $id;
        $product = Product::find($id);
        $languages = Language::all();
        return view('products.language_details.add_edit',compact('mode','product','productId','languages'));
    }

    public function postAdd(){
        $minimum            = Input::get('minimum');
        $runningDays        = Input::get('running_days');
        $unavailableDays    = Input::get('unavailable_days');
        $maxGroup           = Input::get('max_group');
        $productId          = Input::get('product_id');
        $name               = Input::get('name');
        $subtitle           = Input::get('subtitle');
        $miniDescription    = Input::get('mini_description');
        $description        = Input::get('description');
        $inclusions         = Input::get('inclusions');
        $exclusions         = Input::get('exclusions');
        $highlights         = Input::get('highlights');
        $itinerary          = Input::get('itinerary');
        $cancelPolicy       = Input::get('cancelpolicy');
        $departPoint        = Input::get('departpoint');
        $endPoint           = Input::get('endpoint');
        $additionalInfo     = Input::get('additionalinfo');
        $whatToBring        = Input::get('what_to_bring');
        $duration           = Input::get('duration');
        $website_ids        = Input::get('websites');
        $language        	= Input::get('language_id');
		$itineraryMap		= Input::get('itinerary_map');
		$departurePointMap	= Input::get('departure_point_map');
		$metaTitle			= Input::get('meta_title');
		$metaDescription	= Input::get('meta_description');
		$metaTags			= Input::get('meta_tags');
		$url				= Input::get('url');

        $unavailableDays = Helpers::formatDates($unavailableDays);

        $productDetail = new ProductLanguageDetail;
        $productDetail->minimum           = $minimum;
        $productDetail->running_days      = $runningDays;
        $productDetail->maxgroup          = $maxGroup;
        $productDetail->product_id        = $productId;
        $productDetail->name              = $name;
        $productDetail->subtitle          = $subtitle;
        $productDetail->minidescription   = $miniDescription;
        $productDetail->description       = $description;
        $productDetail->inclusions        = $inclusions;
        $productDetail->exclusions        = $exclusions;
        $productDetail->highlights        = $highlights;
        $productDetail->itinerary        = $itinerary;
        $productDetail->cancelpolicy      = $cancelPolicy;
        $productDetail->departpoint       = $departPoint;
        $productDetail->endpoint          = $endPoint;
        $productDetail->additionalinfo    = $additionalInfo;
        $productDetail->what_to_bring     = $whatToBring;
        $productDetail->duration          = $duration;
        $productDetail->language_id       = $language;
		$productDetail->itinerary_map	  = $itineraryMap;
		$productDetail->departure_point_map	= $departurePointMap;
		$productDetail->meta_title			= $metaTitle;
		$productDetail->meta_description	= $metaDescription;
		$productDetail->meta_tags			= $metaTags;
		$productDetail->url					= $url;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
            'subtitle' => 'required',
            'mini_description' => 'required',
            'description' => 'required',
            'inclusions' => 'required',
            'exclusions' => 'required',
            'highlights' => 'required',
            'itinerary' => 'required',
            'cancelpolicy' => 'required',
            'departpoint' => 'required',
            'endpoint' => 'required',
            'additionalinfo' => 'required',
            'what_to_bring' => 'required',
            'duration' => 'required',
            'cancelpolicy' => 'required',
            'running_days' => 'required',
            'minimum' => 'required',
            'max_group' => 'required',
            'language_id' => 'required',
            'url' => 'unique:product_language_details'
        );

        $messages = array(
            'name.required' => 'This name field is required',
            'subtitle.required' => 'This subtitle field is required',
            'mini_description.required' => 'This mini description field is required',
            'description.required' => 'This description field is required',
            'inclusions.required' => 'This inclusions field is required',
            'exclusions.required' => 'This exclusions field is required',
            'highlights.required' => 'This highlights field is required',
            'itinerary.required' => 'This itinerary field is required',
            'cancelpolicy.required' => 'This cancel policy field is required',
            'departpoint.required' => 'This depart point field is required',
            'endpoint.required' => 'This end point field is required',
            'additionalinfo.required' => 'This additional info field is required',
            'what_to_bring.required' => 'This what to bring field is required',
            'duration.required' => 'This duration field is required',
            'cancelpolicy.required' => 'This cancel policy field is required',
            'running_days.required' => 'This running days field is required',
            'minimum.required' => 'This minimum field is required',
            'max_group.required' => 'This max group field is required',
            'language_id.required' => 'This language field is required',
            'url.unique' => 'URL must be unique',
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

            $productDetail->save();

            if($productDetail->id){

                if(!empty($website_ids)){
                    $productDetail->websites()->attach(explode(",",$website_ids));
                }

                if(count($unavailableDays)>0){

                    foreach($unavailableDays as $ud){
                        $productLanguageDetailsUnavailableDay = new ProductLanguageDetailsUnavailableDay;
                        $productLanguageDetailsUnavailableDay->product_language_detail_id = $productDetail->id;
                        $productLanguageDetailsUnavailableDay->date = $ud;
                        if(!empty($ud)) {
                            $productLanguageDetailsUnavailableDay->save();
                        }
                    }

                }

                return redirect("/admin/products/$productId/details/")
                    ->with('success','Product detail successfully added');
            }
        }

        return redirect("/admin/products/$productId/details/add")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $mode = 'edit';
        $languages = Language::all();
        $productDetail = ProductLanguageDetail::find($id);
        $unavailableDaysList = $productDetail->getUnavailableDays();
        $productId = $productDetail->product_id;
        $product = $productDetail->product;

        $website_list = $productDetail->websites;
        $websites = array();
        foreach($website_list as $website){
            $websites[] = $website->id;
        }

        $website_selection = implode(",",$websites);

        return view('products.language_details.add_edit',compact('languages', 'productId', 'product', 'productDetail', 'mode','website_selection','unavailableDaysList'));
    }

    public function postEdit($id){

        $minimum            = Input::get('minimum');
        $runningDays        = Input::get('running_days');
        $unavailableDays    = Input::get('unavailable_days');
        $maxGroup           = Input::get('max_group');
        $productId          = Input::get('product_id');
        $name               = Input::get('name');
        $subtitle           = Input::get('subtitle');
        $miniDescription    = Input::get('mini_description');
        $description        = Input::get('description');
        $inclusions         = Input::get('inclusions');
        $exclusions         = Input::get('exclusions');
        $highlights         = Input::get('highlights');
        $itinerary          = Input::get('itinerary');
        $cancelPolicy       = Input::get('cancelpolicy');
        $departPoint        = Input::get('departpoint');
        $endPoint           = Input::get('endpoint');
        $additionalInfo     = Input::get('additionalinfo');
        $whatToBring        = Input::get('what_to_bring');
        $duration           = Input::get('duration');
        $website_ids        = Input::get('websites');
        $language        	= Input::get('language_id');
		$itineraryMap		= Input::get('itinerary_map');
		$departurePointMap	= Input::get('departure_point_map');
		$metaTitle			= Input::get('meta_title');
		$metaDescription	= Input::get('meta_description');
		$metaTags			= Input::get('meta_tags');
		$url				= Input::get('url');

        $unavailableDays = Helpers::formatDates($unavailableDays);

        $productDetail = ProductLanguageDetail::find($id);
        $productDetail->minimum           = $minimum;
        $productDetail->running_days      = $runningDays;
        $productDetail->maxgroup          = $maxGroup;
        $productDetail->product_id        = $productId;
        $productDetail->name              = $name;
        $productDetail->subtitle          = $subtitle;
        $productDetail->minidescription   = $miniDescription;
        $productDetail->description       = $description;
        $productDetail->inclusions        = $inclusions;
        $productDetail->exclusions        = $exclusions;
        $productDetail->highlights        = $highlights;
        $productDetail->itinerary        = $itinerary;
        $productDetail->cancelpolicy      = $cancelPolicy;
        $productDetail->departpoint       = $departPoint;
        $productDetail->endpoint          = $endPoint;
        $productDetail->additionalinfo    = $additionalInfo;
        $productDetail->what_to_bring     = $whatToBring;
        $productDetail->duration          = $duration;
        $productDetail->language_id       = $language;
		$productDetail->itinerary_map	  = $itineraryMap;
		$productDetail->departure_point_map	= $departurePointMap;
		$productDetail->meta_title			= $metaTitle;
		$productDetail->meta_description	= $metaDescription;
		$productDetail->meta_tags			= $metaTags;
		  

        $input = Input::all();

        $rules = array(
            'name' => 'required',
            'subtitle' => 'required',
            'mini_description' => 'required',
            'description' => 'required',
            'inclusions' => 'required',
            'exclusions' => 'required',
            'highlights' => 'required',
            'itinerary' => 'required',
            'cancelpolicy' => 'required',
            'departpoint' => 'required',
            'endpoint' => 'required',
            'additionalinfo' => 'required',
            'what_to_bring' => 'required',
            'duration' => 'required',
            'cancelpolicy' => 'required',
            'running_days' => 'required',
            'minimum' => 'required',
            'max_group' => 'required',
            'language_id' => 'required',
            'url' => 'required|unique:product_language_details'
        );

        if($productDetail->url == Input::get("url")){
            $rules["url"] = "required";
        }else{
            $productDetail->url = Input::get("url");
        }

        $messages = array(
            'name.required' => 'This name field is required',
            'subtitle.required' => 'This subtitle field is required',
            'mini_description.required' => 'This mini description field is required',
            'description.required' => 'This description field is required',
            'inclusions.required' => 'This inclusions field is required',
            'exclusions.required' => 'This exclusions field is required',
            'highlights.required' => 'This highlights field is required',
            'itinerary.required' => 'This itinerary field is required',
            'cancelpolicy.required' => 'This cancel policy field is required',
            'departpoint.required' => 'This depart point field is required',
            'endpoint.required' => 'This end point field is required',
            'additionalinfo.required' => 'This additional info field is required',
            'what_to_bring.required' => 'This what to bring field is required',
            'duration.required' => 'This duration field is required',
            'cancelpolicy.required' => 'This cancel policy field is required',
            'running_days.required' => 'This running days field is required',
            'minimum.required' => 'This minimum field is required',
            'max_group.required' => 'This max group field is required',
            'language_id.required' => 'This language field is required',
            'url.unique' => "URL must be unique",
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

            $udNew = $unavailableDays;
            $udOld = $productDetail->getUnavailableDaysArray();

            if(count($udNew)>0){

                $udRemove = array_diff($udOld,$udNew);
                $productDetail->unavailable()->whereIn('date',$udRemove)->delete();
                $udAdd = array_diff($udNew,$udOld);
                foreach($udAdd as $ud){
                    $productLanguageDetailsUnavailableDay = new ProductLanguageDetailsUnavailableDay;
                    $productLanguageDetailsUnavailableDay->product_language_detail_id = $productDetail->id;
                    $productLanguageDetailsUnavailableDay->date = $ud;
                    if(!empty($ud)) {
                        $productLanguageDetailsUnavailableDay->save();
                    }
                }

            } else {
                ProductLanguageDetailsUnavailableDay::where('product_language_detail_id',$productDetail->id)->delete();
            }

            if(!empty($website_ids)){
                $website_ids_old = $productDetail->websites;
                $website_ids_old_array = [];
                foreach($website_ids_old as $websites){
                    $website_ids_old_array[] = $websites->id;
                }
                $website_ids = explode(",",$website_ids);
                $website_ids_old = array_diff($website_ids_old_array,$website_ids);

                foreach($website_ids_old as $website_id){
                    $productDetail->websites()->detach($website_id);
                }

                $website_ids_new = array_diff($website_ids,$website_ids_old_array);

                foreach($website_ids_new as $website_id){
                    $productDetail->websites()->attach($website_id);
                }
            } else {
                if(count($productDetail->websites)>0){
                    $productDetail->websites()->detach();
                }
            }

            $productDetail->save();

            if($productDetail->id){

                $productDetailLink = "<a href='/admin/products/details/$id/edit'>$productDetail->name</a>";

                return redirect("/admin/products/$productId/details/")
                    ->with('success',"Product detail $productDetailLink successfully updated");
            }
        }

        return redirect("/admin/products/details/$id/edit")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $productDetail = ProductLanguageDetail::find($id);
        $productId = $productDetail->product_id;
        $name = $productDetail->name;

        try {
            ProductLanguageDetailsUnavailableDay::where('product_language_detail_id','=',$productDetail->id)->delete();
            $productDetail->websites()->detach();
            $productDetail->delete();
        } catch (QueryException $e) {
            return redirect('/admin/products/options')->with("error","<b>$name</b> cannot be deleted it is being used in another product option package");
        }

        return redirect("/admin/products/$productId/details/")->with("success","<b>$name</b> has been deleted successfully");

    }
}