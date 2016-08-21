<?php namespace App\Http\Controllers;

use App\Libraries\Helpers;
use App\Promo;
use App\PromosProduct;
use App\PromosProductsAddon;
use App\PromosProductsOption;
use App\PromosWebsite;
use App\PromoType;
use App\Product;
use App\ProductOption;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Validator;

class PromosController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
        $promos = Promo::all();
		$promoTypes = PromoType::all();
        return view('promos.index',compact('promos', 'promoTypes'));
    }

    public function add(){
        $mode = 'add';
        $promos = Promo::all();
		$promoTypes = PromoType::all();
		
		$products = Product::all();
        $productId = Input::old('product_id',0);
		$productOptions = ProductOption::where('product_id','=',$productId)->get();
		
		// Populate Dynamic Array Values (promo products)
        $promosProductsOld = Helpers::getPromosProducts(Input::old('promos_product_id',[]),Input::old('product_id',[]),Input::old('product_option_ids',[]),Input::old('addon_ids',[]));

        return view('promos.add_edit',compact('promos', 'promoTypes', 'mode', 'products', 'productId', 'productOptions', 'promosProductsOld'));
    }

    public function postAdd(){
        $promoTypeId 		= Input::get('promo_type_id');
        $name 				= Input::get('name');
        $travelStartDate 	= Input::get('travel_start_date');
        $travelEndDate 		= Input::get('travel_end_date');
        $bookStartDate 		= Input::get('book_start_date');
        $bookEndDate 		= Input::get('book_end_date');
		$percentDiscount 	= Input::get('percent_discount');
        $euroOffDiscount 	= Input::get('euro_off_discount');
        $adultPrice 		= Input::get('adult_price');
        $childPrice 		= Input::get('child_price');
        $newDefaultPrice	= Input::get('new_default_price');
        $code 				= Input::get('code');
        $minimum			= Input::get('minimum');
        $maximum			= Input::get('maximum');
		$website_ids        = Input::get('websites');

        $promosProducts = Helpers::getPromosProducts(Input::get('promos_product_id'),Input::get('product_id'),Input::get('product_option_ids'),Input::get('addon_ids'));

        $promo = new Promo;
		$promo->promo_type_id 		= $promoTypeId;
        $promo->name 				= $name;
        $promo->travel_start_date 	= $travelStartDate ? Helpers::formatDate($travelStartDate) : null;
        $promo->travel_end_date 	= $travelEndDate ? Helpers::formatDate($travelEndDate) : null;
        $promo->book_start_date 	= $bookStartDate ? Helpers::formatDate($bookStartDate) : null;
        $promo->book_end_date 		= $bookEndDate ? Helpers::formatDate($bookEndDate) : null;
		$promo->percent_discount 	= Helpers::cleanPercentage($percentDiscount);
        $promo->euro_off_discount 	= Helpers::cleanPrice($euroOffDiscount);
        $promo->adult_price 		= Helpers::cleanPrice($adultPrice);
        $promo->child_price 		= Helpers::cleanPrice($childPrice);
        $promo->new_default_price 	= Helpers::cleanPrice($newDefaultPrice);
        $promo->code 				= $code;
        $promo->minimum				= $minimum;
        $promo->maximum				= $maximum ?: null;

        $input = Input::all();

        switch($promoTypeId){
            case PromoType::NEWPRICING:
                $rules = array(
                    'name' 					=> 'required',
                    'adult_price' 			=> 'required_zero'
                );
                break;
            case PromoType::FIXEDDISCOUNT:
                $rules = array(
                    'name' 					=> 'required',
                    'euro_off_discount' 	=> 'required_zero'
                );
                break;
            case PromoType::FREEADDON:
                $rules = array(
                    'name' 					=> 'required'
                );
                break;
            case PromoType::PERCENTDISCOUNT:
                $rules = array(
                    'name' 					=> 'required',
                    'percent_discount'	 	=> 'required_zero'
                );
                break;
            default:
                $rules = array(
                    'name' 					=> 'required'
                );
        }


        $messages = array(
			'name.required'						=> 'This name field is required',
			'percent_discount.required_zero'	=> 'Please enter percent discount greater than 0',
			'euro_off_discount.required_zero'	=> 'Please enter euro off discount greater than 0',
            'adult_price.required_zero'		    => 'This adult price field is required',
	        'child_price.required_zero' 		=> 'This child price field is required'
	   );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $promo->save();

            if($promo->id){
			
				if(!empty($website_ids)){
					$promo->websites()->attach(explode(",",$website_ids));
                }

                if(!empty($promosProducts)){
                    foreach($promosProducts as $promosProduct){
                        $promoProduct = new PromosProduct;
                        $promoProduct->promo_id = $promo->id;
                        $promoProduct->product_id = $promosProduct->product_id;
                        $promoProduct->save();

                        $productOptions = array_filter(explode(",",$promosProduct->product_option_id));

                        if(!empty($productOptions)){
                            $promoProduct->options()->attach($productOptions);
                        }

                        $addons = array_filter(explode(",",$promosProduct->addon_id));

                        if(!empty($addons)){
                            $promoProduct->addons()->attach($addons);
                        }

                    }
                }
				
                return redirect("/admin/promos/")
                    ->with('success','Promo successfully added');
            }
        }

        return redirect("/admin/promos/add")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $mode = 'edit';
        $promo = Promo::find($id);
        $promos = Promo::all();
		$promoTypes = PromoType::all();

        $products = Product::all();
        $productId = Input::old('product_id',$promo->product_id);
        $productOptions = ProductOption::where('product_id','=',$productId)->get();

        $websites = $promo->websites->lists('id');

        $website_selection = implode(",",$websites);
		
		//TODO: add map
		// Populate Dynamic Array Values (promo products)
        $promosProductsOld = Helpers::getPromosProducts(Input::old('promos_product_id',[]),Input::old('product_id',[]),Input::old('product_option_ids',[]),Input::old('addon_ids',[]));
        $promosProductsOld = count($promosProductsOld) > 0 ? $promosProductsOld : Helpers::mapPromosProducts($promo->promos_products);
        return view('promos.add_edit',compact('promo', 'promos', 'promoTypes', 'website_selection', 'mode', 'products', 'productId', 'productOptions', 'promosProductsOld'));
    }

    public function postEdit($id){

        $promoTypeId 		= Input::get('promo_type_id');
        $name 				= Input::get('name');
        $travelStartDate 	= Input::get('travel_start_date');
        $travelEndDate 		= Input::get('travel_end_date');
        $bookStartDate 		= Input::get('book_start_date');
        $bookEndDate 		= Input::get('book_end_date');
        $percentDiscount 	= Input::get('percent_discount');
        $euroOffDiscount 	= Input::get('euro_off_discount');
        $adultPrice 		= Input::get('adult_price');
        $childPrice 		= Input::get('child_price');
        $newDefaultPrice	= Input::get('new_default_price');
        $code 				= Input::get('code');
		$minimum			= Input::get('minimum');
        $maximum			= Input::get('maximum');
		$website_ids        = Input::get('websites');

        $promosProducts = Helpers::getPromosProducts(Input::get('promos_product_id'),Input::get('product_id'),Input::get('product_option_ids'),Input::get('addon_ids'));

        $promo = Promo::find($id);
        $promo->promo_type_id 		= $promoTypeId;
        $promo->name 				= $name;
        $promo->travel_start_date 	= $travelStartDate ? Helpers::formatDate($travelStartDate) : null;
        $promo->travel_end_date 	= $travelEndDate ? Helpers::formatDate($travelEndDate) : null;
        $promo->book_start_date 	= $bookStartDate ? Helpers::formatDate($bookStartDate) : null;
        $promo->book_end_date 		= $bookEndDate ? Helpers::formatDate($bookEndDate) : null;
        $promo->percent_discount 	= Helpers::cleanPercentage($percentDiscount);
        $promo->euro_off_discount 	= Helpers::cleanPrice($euroOffDiscount);
        $promo->adult_price 		= Helpers::cleanPrice($adultPrice);
        $promo->child_price 		= Helpers::cleanPrice($childPrice);
        $promo->new_default_price 	= Helpers::cleanPrice($newDefaultPrice);
        $promo->code 				= $code;
		$promo->minimum				= $minimum;
        $promo->maximum				= $maximum ?: null;

        $input = Input::all();


        switch($promoTypeId){
            case PromoType::NEWPRICING:
                $rules = array(
                    'name' 					=> 'required',
                    'adult_price' 			=> 'required_zero'
                );
                break;
            case PromoType::FIXEDDISCOUNT:
                $rules = array(
                    'name' 					=> 'required',
                    'euro_off_discount' 	=> 'required_zero'
                );
                break;
            case PromoType::FREEADDON:
                $rules = array(
                    'name' 					=> 'required'
                );
                break;
            case PromoType::PERCENTDISCOUNT:
                $rules = array(
                    'name' 					=> 'required',
                    'percent_discount'	 	=> 'required_zero'
                );
                break;
            default:
                $rules = array(
                    'name' 					=> 'required'
                );
        }




        $messages = array(
			'name.required'						=> 'This name field is required',
			'percent_discount.required_zero'	=> 'Please enter percent discount greater than 0',
			'euro_off_discount.required_zero'	=> 'Please enter euro off discount greater than 0',
            'adult_price.required_zero'		    => 'This adult price field is required',
	        'child_price.required_zero' 		=> 'This child price field is required'
	   );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){
			
			if(!empty($website_ids)){
                $website_ids_old_array = $promo->websites->lists('id');

                $website_ids = explode(",",$website_ids);

                $website_ids_old = array_diff($website_ids_old_array,$website_ids);

                if(!empty($website_ids_old)){
                    $promo->websites()->detach($website_ids_old);
                }

                $website_ids_new = array_diff($website_ids,$website_ids_old_array);

                if(!empty($website_ids_new)){
                    $promo->websites()->attach($website_ids_new);
                }
            } else {
                if(count($promo->websites)>0){
                    $promo->websites()->detach();
                }
            }

            if(!empty($promosProducts)){
                foreach($promosProducts as $promosProduct){

                    if($promosProduct->id > 0 ){
                        $promoProduct = PromosProduct::find($promosProduct->id);
                    } else {
                        $promoProduct = new PromosProduct;
                    }

                    $promoProduct->promo_id = $promo->id;
                    $promoProduct->product_id = $promosProduct->product_id;
                    $promoProduct->save();

                    $productOptions = array_filter(explode(",",$promosProduct->product_option_id));

                    if(!empty($productOptions)){
                        $productOptions_old_array = $promoProduct->options->lists('id');

                        $productOptions_old = array_diff($productOptions_old_array,$productOptions);

                        if(!empty($productOptions_old)){
                            $promoProduct->options()->detach($productOptions_old);
                        }

                        $productOptions_new = array_diff($productOptions,$productOptions_old_array);

                        if(!empty($productOptions_new)){
                            $promoProduct->options()->attach($productOptions_new);
                        }

                    }

                    $addons = array_filter(explode(",",$promosProduct->addon_id));

                    if(!empty($addons)){

                        $addons_old_array = $promoProduct->addons->lists('id');

                        $addons_old = array_diff($addons_old_array,$addons);

                        if(!empty($addons_old)){
                            $promoProduct->addons()->detach($addons_old);
                        }

                        $addons_new = array_diff($addons,$addons_old_array);

                        if(!empty($addons_new)){
                            $promoProduct->addons()->attach($addons_new);
                        }

                    }

                }
            }

            $promo->save();
			
			$promolink = "<a href='/admin/promos/$id/edit'>$promo->name</a>";

            if($promo->id){
                return redirect("/admin/promos/")
                    ->with('success',"Promo $promolink successfully updated");
            }
        }

        return redirect("/admin/promos/$id/edit")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $promo = Promo::find($id);
        $name = $promo->name;

        try {
            PromosWebsite::where('promo_id',$promo->id)->delete();
            $promosProduct = PromosProduct::where('promo_id',$promo->id)->first();
            PromosProductsAddon::where('promo_product_id',$promosProduct->id)->delete();
            PromosProductsOption::where('promo_product_id',$promosProduct->id)->delete();
            $promosProduct->delete();
            $promo->delete();
        } catch (QueryException $e) {
            return redirect('/admin/promos')->with("error","<b>$name</b> cannot be deleted it is being used by the system");
        }

        return redirect('/admin/promos')->with("success","<b>$name</b> has been deleted successfully");

    }

    public function deletePromoProduct($id){
        $promoProduct = PromosProduct::find($id);
        $promoProduct->delete();
    }
}