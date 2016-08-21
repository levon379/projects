<?php namespace App\Http\Controllers;

use App\AvailabilitySlot;
use App\Language;
use App\Libraries\Helpers;
use App\ProductOption;
use App\Product;
use App\ProductOptionLanguage;
use App\ProductOptionUnavailableDay;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Validator;

class ProductOptionsController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index($productId){
        $product = Product::find($productId);
        $productOptions = $product->options;
        //$productOptions = ProductOption::where('product_id','=',$id)->get();
        return view('products.options.index',compact('productOptions','product'));
    }

    public function add($productId){
        $product = Product::find($productId);
		
		$id = Input::get('id');
		$productOption = ProductOption::find($id);
		$option_list = @$productOption->options ?: array();
		$options = array();
		foreach($option_list as $option){
			$options[] = $option->id;
		}
		$option_selection = implode(",",$options);
		
		$language_list = @$productOption->languages ?: array();
		$languages = array();
		foreach($language_list as $language){
			$languages[] = $language->id;
		}
		$language_selection = implode(",",$languages);
		
		if($productOption){
			$shown = Input::old('flag_show_value', $productOption->flag_show);
			$private = Input::old('private_value', $productOption->private);
		} else {
			$shown = Input::old('flag_show_value', true);
			$private = Input::old('private_value', false);
		}
		
		$availabilitySlots = AvailabilitySlot::all();		
        $mode = 'add';
        return view('products.options.add_edit',compact('mode','product','availabilitySlots',"productId",'id','productOption','option_selection','language_selection','shown','private'));
    }

    public function postAdd(){
        $name = Input::get('name');
        $productId = Input::get('product_id');
        $availabilitySlotId = Input::get('availability_slot_id');
        $startTime = Input::get('start_time');
        $endTime = Input::get('end_time');
        $adultPrice = Input::get('adult_price');
        $adultAgeFrom = Input::get('adult_age_from');
        $adultAgeTo = Input::get('adult_age_to');
        $childPrice = Input::get('child_price');
        $childAgeFrom = Input::get('child_age_from');
        $childAgeTo = Input::get('child_age_to');
        $travSeasonStart = Input::get('trav_season_start');
        $travSeasonEnd = Input::get('trav_season_end');
        $bookSeasonStart = Input::get('book_season_start');
        $bookSeasonEnd = Input::get('book_season_end');
        $minimum = Input::get('minimum');
        $runningDays = Input::get('running_days');
        $unavailableDays = Input::get('unavailable_days');
        $maxGroup = Input::get('max_group');
        // duration is minutes
        $duration = Input::get('duration');
        $packageFlag = Input::get('package_flag');
        $onRequestFlag = Input::get('on_request_flag');
        $private = Input::get('private_value');
        $flagShow = Input::get('flag_show_value');
        $fixedPrice = Input::get("fixed_price_flag");

        if($startTime){
            $startTime =  Carbon::parse($startTime)->toTimeString();    
        }else{
            $startTime = null;
        }
        if($endTime){
            $endTime =  Carbon::parse($endTime)->toTimeString();    
        }else{
            $endTime = null;
        }

        $productOption = new ProductOption;
        $productOption->name = $name;
        $productOption->product_id = $productId;
        $productOption->availability_slot_id = $availabilitySlotId;
        $productOption->start_time = $startTime;
        $productOption->end_time = $endTime;
        $productOption->adult_price = Helpers::cleanPrice($adultPrice);
        $productOption->adult_age_from = $adultAgeFrom;
        $productOption->adult_age_to = $adultAgeTo;
        $productOption->child_price = Helpers::cleanPrice($childPrice);
        $productOption->child_age_from = $childAgeFrom;
        $productOption->child_age_to = $childAgeTo;
        $productOption->trav_season_start = Helpers::formatDate($travSeasonStart);
        $productOption->trav_season_end = Helpers::formatDate($travSeasonEnd);
        $productOption->book_season_start = Helpers::formatDate($bookSeasonStart);
        $productOption->book_season_end = Helpers::formatDate($bookSeasonEnd);
        $productOption->minimum = $minimum;

        // this would be a checkbox group
        $runningDays = Helpers::formatDays($runningDays);
        $productOption->running_days = $runningDays;

        // this would be a control where you are able to choose multiple dates

        $unavailableDays = Helpers::formatDates($unavailableDays);

        $productOption->max_group = $maxGroup;
        $productOption->duration = Helpers::formatDuration($duration);

        $productOption->package_flag = empty($packageFlag) ? false : true;
        $productOption->private = empty($private) ? false : true;
		$productOption->flag_show = empty($flagShow) ? false : true;
        $productOption->on_request_flag = empty($onRequestFlag) ? false : true;
        $productOption->fixed_price_flag = empty($fixedPrice) ? false : true;


        $option_ids = Input::get('options');
        $language_ids = Input::get('languages');

        $input = Input::all();

        $rules = array(
            'name' => 'required',
			'languages' => 'required'
        );

        $messages = array(
            'name.required' => 'This name field is required',
            'languages.required' => 'Please choose at least 1 language'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $productOption->save();

            if($productOption->id){

                if(!empty($option_ids)){
                    $productOption->options()->attach(explode(",",$option_ids));
                }
				
				if(!empty($language_ids)){
                    $productOption->languages()->attach(explode(",",$language_ids));
                }

                if(count($unavailableDays)>0){

                    foreach($unavailableDays as $ud){
                        $productOptionUnavailableDay = new ProductOptionUnavailableDay;
                        $productOptionUnavailableDay->product_option_id = $productOption->id;
                        $productOptionUnavailableDay->date = $ud;
                        if(!empty($ud)) {
                            $productOptionUnavailableDay->save();
                        }
                    }

                }

                return redirect("/admin/products/$productId/options/")
                    ->with('success','Product option successfully added');
            }
        }

        return redirect("/admin/products/$productId/options/add")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $productOption = ProductOption::find($id);
        $productId = $productOption->product_id;
        $unavailableDaysList = $productOption->getUnavailableDays();
        $products = Product::all();
        $availabilitySlots = AvailabilitySlot::all();
        $languages = Language::all();
        $running_days_list = Helpers::displayDays($productOption->running_days);

        $option_list = $productOption->options;
        $options = array();
        foreach($option_list as $option){
            $options[] = $option->id;
        }
        $option_selection = implode(",",$options);
		
		$language_list = $productOption->languages;
        $languages = array();
        foreach($language_list as $language){
            $languages[] = $language->id;
        }

        $language_selection = implode(",",$languages);
		
		$shown = Input::old('flag_show', ($productOption->flag_show));
		$private = Input::old('private', ($productOption->private));

        $mode = 'edit';
        return view('products.options.add_edit',compact('productOption','mode' ,'unavailableDaysList','products','productId','availabilitySlots','languages','running_days_list','option_selection', 'language_selection', 'shown', 'private'));
    }

    public function postEdit($id){

        $name = Input::get('name');
        $productId = Input::get('product_id');
        $availabilitySlotId = Input::get('availability_slot_id');
        $language_ids = Input::get('languages');
        $startTime = Input::get('start_time');
        $endTime = Input::get('end_time');
        $adultPrice = Input::get('adult_price');
        $adultAgeFrom = Input::get('adult_age_from');
        $adultAgeTo = Input::get('adult_age_to');
        $childPrice = Input::get('child_price');
        $childAgeFrom = Input::get('child_age_from');
        $childAgeTo = Input::get('child_age_to');
        $travSeasonStart = Input::get('trav_season_start');
        $travSeasonEnd = Input::get('trav_season_end');
        $bookSeasonStart = Input::get('book_season_start');
        $bookSeasonEnd = Input::get('book_season_end');
        $minimum = Input::get('minimum');
        $runningDays = Input::get('running_days');
        $unavailableDays = Input::get('unavailable_days');
        $maxGroup = Input::get('max_group');
        // duration is minutes
        $duration = Input::get('duration');
        $packageFlag = Input::get('package_flag');
        $private = Input::get('private_value');
		$flagShow = Input::get('flag_show_value');
        $onRequestFlag = Input::get("on_request_flag");
        $fixedPrice = Input::get("fixed_price_flag");

        if($startTime){
            $startTime =  Carbon::parse($startTime)->toTimeString();
        }else{
            $startTime = null;
        }
        if($endTime){
            $endTime =  Carbon::parse($endTime)->toTimeString();    
        }else{
            $endTime = null;
        }

        // dd($startTime, $endTime);

        $productOption = ProductOption::find($id);
        $productOption->name = $name;
        $productOption->product_id = $productId;
        $productOption->availability_slot_id = $availabilitySlotId;
        $productOption->start_time = $startTime;
        $productOption->end_time = $endTime;
        $productOption->adult_price = Helpers::cleanPrice($adultPrice);
        $productOption->adult_age_from = $adultAgeFrom;
        $productOption->adult_age_to = $adultAgeTo;
        $productOption->child_price = Helpers::cleanPrice($childPrice);
        $productOption->child_age_from = $childAgeFrom;
        $productOption->child_age_to = $childAgeTo;
        $productOption->trav_season_start = Helpers::formatDate($travSeasonStart);
        $productOption->trav_season_end = Helpers::formatDate($travSeasonEnd);
        $productOption->book_season_start = Helpers::formatDate($bookSeasonStart);
        $productOption->book_season_end = Helpers::formatDate($bookSeasonEnd);
        $productOption->minimum = $minimum;

        // this would be a checkbox group
        $runningDays = Helpers::formatDays($runningDays);
        $productOption->running_days = $runningDays;

        // this would be a control where you are able to choose multiple dates

        $unavailableDays = Helpers::formatDates($unavailableDays);

        //print_r($unavailableDays);
        //exit;

        $productOption->max_group = $maxGroup;
        $productOption->duration = Helpers::formatDuration($duration);

        $productOption->package_flag = empty($packageFlag) ? false : true;
        $productOption->private = empty($private) ? false : true;
		$productOption->flag_show = empty($flagShow) ? false : true;
        $productOption->on_request_flag = empty($onRequestFlag) ? false : true;
        $productOption->fixed_price_flag = empty($fixedPrice) ? false : true;

        $option_ids = Input::get('options');

        $input = Input::all();

        $rules = array(
            'name' => 'required',
			'languages' => 'required'
        );

        $messages = array(
            'name.required' => 'This name field is required',
			'languages.required' => 'Please choose at least 1 language'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

            $udNew = $unavailableDays;
            $udOld = $productOption->getUnavailableDaysArray();

            if(count($udNew)>0){

                $udRemove = array_diff($udOld,$udNew);
                $productOption->unavailable()->whereIn('date',$udRemove)->delete();
                $udAdd = array_diff($udNew,$udOld);
                foreach($udAdd as $ud){
                    $productOptionUnavailableDay = new ProductOptionUnavailableDay;
                    $productOptionUnavailableDay->product_option_id = $productOption->id;
                    $productOptionUnavailableDay->date = $ud;
                    if(!empty($ud)) {
                        $productOptionUnavailableDay->save();
                    }
                }

            } else {
                ProductOptionUnavailableDay::where('product_option_id',$productOption->id)->delete();
            }

            if(!empty($option_ids)){
                $option_ids_old = $productOption->options;
                $option_ids_old_array = [];
                foreach($option_ids_old as $options){
                    $option_ids_old_array[] = $options->id;
                }
                $option_ids = explode(",",$option_ids);
                $option_ids_old = array_diff($option_ids_old_array,$option_ids);

                foreach($option_ids_old as $option_id){
                    $productOption->options()->detach($option_id);
                }

                $option_ids_new = array_diff($option_ids,$option_ids_old_array);

                foreach($option_ids_new as $option_id){
                    $productOption->options()->attach($option_id);
                }
            } else {
                if(count($productOption->options)>0){
                    $productOption->options()->detach();
                }
            }
			
			if(!empty($language_ids)){
                $language_ids_old = $productOption->languages;
                $language_ids_old_array = [];
                foreach($language_ids_old as $language){
                    $language_ids_old_array[] = $language->id;
                }
                $language_ids = explode(",",$language_ids);
                $language_ids_old = array_diff($language_ids_old_array,$language_ids);

                foreach($language_ids_old as $language_id){
                    $productOption->languages()->detach($language_id);
                }

                $language_ids_new = array_diff($language_ids,$language_ids_old_array);

                foreach($language_ids_new as $language_id){
                    $productOption->languages()->attach($language_id);
                }
            } else {
                if(count($productOption->languages)>0){
                    $productOption->languages()->detach();
                }
            }

            
            // \DB::enableQueryLog();
            $productOption->save();
            // dd($productOption->toArray(), \DB::getQueryLog());
            if($productOption->id){

                $optionLink = "<a href='/admin/products/options/$id/edit'>$productOption->name</a>";

                return redirect("/admin/products/$productId/options")
                    ->with('success',"Product option $optionLink successfully updated");
            }
        }

        return redirect("/admin/products/options/$id/edit")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $productOption = ProductOption::find($id);
        $productId = $productOption->product_id;
        $name = $productOption->name;

        try {
            ProductOptionUnavailableDay::where('product_option_id','=',$productOption->id)->delete();
            ProductOptionLanguage::where('product_option_id',$productOption->id)->delete();
            $productOption->delete();
        } catch (QueryException $e) {
            return redirect("/admin/products/$productId/options")->with("error","<b>$name</b> cannot be deleted it is being used in another product option package");
        }

        return redirect("/admin/products/$productId/options")->with("success","<b>$name</b> has been deleted successfully");

    }

}