<?php namespace App\Http\Controllers;

use App\Libraries\Helpers;
use App\Addon;
use App\Product;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Validator;

class AddonsController extends Controller {

    public function __construct(Request $request, Guard $auth){
        $this->request = $request;
        $this->auth = $auth;
    }

    public function index(){
        $addons = Addon::paginate(10);
        return view('addons.index',compact('addons'));
    }

    public function add(){
        $mode = 'add';
        $addons = Addon::all();
		$products = Product::all();
        $newImage = true;
        return view('addons.add_edit',compact('addons', 'products', 'mode' , 'newImage'));
    }

    public function postAdd(){
        $name 				= Input::get('name');
		$adultPrice 		= Input::get('adult_price');
		$adultAge			= Input::get('adult_age');
        $childPrice 		= Input::get('child_price');
        $childAge 			= Input::get('child_age');
        $photo			 	= $this->request->file('photo');
		$enDescriptionTitle	= Input::get('en_description_title');
        $enDescription 		= Input::get('en_description');
        $frDescriptionTitle	= Input::get('fr_description_title');
        $frDescription 		= Input::get('fr_description');
        $deDescriptionTitle	= Input::get('de_description_title');
        $deDescription 		= Input::get('de_description');
        $itaDescriptionTitle= Input::get('ita_description_title');
        $itaDescription		= Input::get('ita_description');
        $esDescriptionTitle	= Input::get('es_description_title');
        $esDescription 		= Input::get('es_description');

        $addon = new Addon;
        $addon->name 					= $name; 	
        $addon->adult_price 			= Helpers::cleanPrice($adultPrice); 	
        $addon->adult_age 				= $adultAge;		
        $addon->child_price 			= Helpers::cleanPrice($childPrice);
        $addon->child_age 				= $childAge;
        $addon->en_description_title 	= $enDescriptionTitle; 
        $addon->en_description 			= $enDescription; 
        $addon->fr_description_title	= $frDescriptionTitle; 
        $addon->fr_description 			= $frDescription; 
        $addon->de_description_title	= $deDescriptionTitle; 
        $addon->de_description			= $deDescription; 
        $addon->ita_description_title	= $itaDescriptionTitle;
        $addon->ita_description 		= $itaDescription;
        $addon->es_description_title	= $esDescriptionTitle;
        $addon->es_description 			= $esDescription;

        $product_ids = Input::get('products');
									  
        $input = Input::all();

        $rules = array(
			'name' 				=> 'required',
            'adult_price' 		=> 'required',
			'en_description' 	=> 'required'
        );

        $messages = array(
			'name.required'					=> 'This name field is required',
            'adult_price.required'			=> 'This adult price field is required',
            'en_description.required'	    => 'This en description field is required'
	   
	    );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

            $addon->save();

            if($addon->id){

                if(!empty($product_ids)) {
                    $addon->products()->attach(explode(",",$product_ids));
                }

                $path = storage_path()."/uploads/addons/".$addon->id;

                if (!is_dir($path)) {
                    mkdir($path,0755,true);
                }

                if(!empty($photo)){
                    $extension = $photo->getClientOriginalExtension();
                    $file_name = "addon.$extension";
                    $mime_type = $photo->getClientMimeType();

                    Image::make($photo->getPathname())->resize(400, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save("$path/$file_name");


                    $addon->image_extension = $extension;
                    $addon->image_mime_type = $mime_type;

                    $addon->save();

                }

                return redirect("/admin/addons/")
                    ->with('success','Addon successfully added');
            }
        }

        return redirect("/admin/addons/add")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $addon = Addon::find($id);
		$mode = 'edit';
        $addons = Addon::all();
		$products = Product::all();

        $product_list = $addon->products->lists('id');
        $product_selection = implode(",",$product_list);

        $newImage = true;
        if( $addon->image_extension != null){
            $newImage = false;
        }

        return view('addons.add_edit',compact('addon', 'addons', 'products', 'mode', 'newImage','product_selection'));
    }

    public function postEdit($id){

        $productId 			= Input::get('product_id');
        $name 				= Input::get('name');
		$adultPrice 		= Input::get('adult_price');
		$adultAge			= Input::get('adult_age');
        $childPrice 		= Input::get('child_price');
        $childAge 			= Input::get('child_age');
        $photo			 	= $this->request->file('photo');
        $enDescriptionTitle	= Input::get('en_description_title');
        $enDescription 		= Input::get('en_description');
        $frDescriptionTitle	= Input::get('fr_description_title');
        $frDescription 		= Input::get('fr_description');
        $deDescriptionTitle	= Input::get('de_description_title');
        $deDescription 		= Input::get('de_description');
        $itaDescriptionTitle= Input::get('ita_description_title');
        $itaDescription		= Input::get('ita_description');
        $esDescriptionTitle	= Input::get('es_description_title');
        $esDescription 		= Input::get('es_description');

        $addon = Addon::find($id);
        $addon->name 					= $name; 	
        $addon->adult_price 			= Helpers::cleanPrice($adultPrice); 	
        $addon->adult_age 				= $adultAge;		
        $addon->child_price 			= Helpers::cleanPrice($childPrice); 	
        $addon->child_age 				= $childAge;
        $addon->en_description_title 	= $enDescriptionTitle; 
        $addon->en_description 			= $enDescription; 
        $addon->fr_description_title	= $frDescriptionTitle; 
        $addon->fr_description 			= $frDescription; 
        $addon->de_description_title	= $deDescriptionTitle; 
        $addon->de_description			= $deDescription; 
        $addon->ita_description_title	= $itaDescriptionTitle;
        $addon->ita_description 		= $itaDescription;
        $addon->es_description_title	= $esDescriptionTitle;
        $addon->es_description 			= $esDescription;

        $product_ids = Input::get('products');

        $input = Input::all();

        $rules = array(
			'name' 				=> 'required',
            'adult_price' 		=> 'required',
			'en_description' 	=> 'required'
        );

        $messages = array(
			'name.required'					=> 'This name field is required',
            'adult_price.required'			=> 'This adult price field is required',
            'en_description.required'	    => 'This en description field is required'
	   
	    );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

            if(!empty($product_ids)){
                $product_ids_old_array = $addon->products->lists('id');

                $product_ids = explode(",",$product_ids);

                $product_ids_old = array_diff($product_ids_old_array,$product_ids);

                if(!empty($product_ids_old)){
                    $addon->products()->detach($product_ids_old);
                }

                $product_ids_new = array_diff($product_ids,$product_ids_old_array);

                if(!empty($product_ids_new)){
                    $addon->products()->attach($product_ids_new);
                }
            } else {
                if(count($addon->products)>0){
                    $addon->products()->detach();
                }
            }


            $addon->save();

            if($addon->id){


                $path = storage_path()."/uploads/addons/".$addon->id;

                if (!is_dir($path)) {
                    mkdir($path,0755,true);
                }

                if(!empty($photo)){
                    $extension = $photo->getClientOriginalExtension();
                    $file_name = "addon.$extension";
                    $mime_type = $photo->getClientMimeType();

                    Image::make($photo->getPathname())->resize(400, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save("$path/$file_name");


                    $addon->image_extension = $extension;
                    $addon->image_mime_type = $mime_type;

                    $addon->save();

                }

                return redirect("/admin/addons/")
                    ->with('success','Addon successfully updated');
            }
        }

        return redirect("/admin/addons/$id/edit")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $addon = Addon::find($id);
        $name = $addon->name;

        try {
            $addon->delete();
            $path = storage_path()."/uploads/addons/".$addon->id;
            Helpers::deleteDir($path);
        } catch (QueryException $e) {
            return redirect('/admin/addons')->with("error","<b>$name</b> cannot be deleted it is being used by a product");
        }

        return redirect('/admin/addons')->with("success","<b>$name</b> has been deleted successfully");

    }
}