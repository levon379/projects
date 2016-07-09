<?php namespace App\Http\Controllers;

use App\DepartureCity;
use App\Libraries\Helpers;
use App\Product;
use App\ProductImage;
use App\ProductVideo;
use App\ProductsCategory;
use App\ProductType;
use App\Provider;
use App\ProductImagePlacement;
use App\ProductVideoPlacement;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Validator;
use File;

class ProductsController extends Controller {

    public function __construct(Request $request, Guard $auth){
        $this->request = $request;
        $this->auth = $auth;
    }

    public function index(){
        $products = Product::paginate(10);
        return view('products.index',compact('products'));
    }

    public function add(){
        $providers = Provider::all();
        $cityList = DepartureCity::all();
        $productTypes = ProductType::all();
        return view('products.add',compact('providers','cityList','productTypes'));
    }

    public function postAdd(){
        $name = Input::get('name');
        $startTimes = Input::get('start_times');
        $files = $this->request->file('product_images');
        $defaultPrice = Input::get('default_price');
        $providerId = Input::get('provider_id');
        $departureCityId = Input::get('departure_city_id');
        $productTypeId = Input::get('product_type_id');


        $defaultPrice = Helpers::cleanPrice($defaultPrice);

        $product = new Product;
        $product->name = $name;
        $product->start_times = $startTimes;
        $product->default_price = $defaultPrice;
        $product->provider_id = $providerId;
        $product->departure_city_id = $departureCityId;
        $product->product_type_id = $productTypeId;
        $product->user_id = $this->auth->user()->id;

        $category_ids = Input::get('categories');
        $rProduct_ids = Input::get('recommended_products');

        $input = Input::all();

        $rules = array(
            'name' => 'required',
            'start_times' => 'required',
            'default_price' => 'required',
            'provider_id' => 'required',
            'departure_city_id' => 'required',
            'product_type_id' => 'required' ,
        );

        $messages = array(
            'name.required' => 'This name field is required',
            'start_times.required' => 'This start times field is required',
            'default_price.required' => 'This default price field is required',
            'provider_id.required' => 'This provider field is required',
            'departure_city_id.required' => 'This departure city field is required',
            'product_type_id.required' => 'This product type field is required'
        );



        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $product->save();

            if($product->id){


                if(!empty($category_ids)){
                    $product->categories()->attach(explode(",",$category_ids));
                }

                if(!empty($rProduct_ids)){
                    $product->recommendedProducts()->attach(explode(",",$rProduct_ids));
                }

                $path = storage_path()."/uploads/products/".$product->id;

                if (!is_dir($path)) {
                    mkdir($path,0755,true);
                }


                foreach($files as $file) {

                    if(!empty($file)){

                        $productImage = new ProductImage;
                        $extension = $file->getClientOriginalExtension();
                        $file_hash = md5_file($file->getPathname());
                        $file_name = $file_hash.".".$extension;
                        $productImage->hash = $file_hash;
                        $productImage->mime_type = $file->getClientMimeType();
                        $productImage->extension = $extension;
                        $productImage->product_id = $product->id;
                        $productImage->name = $file->getClientOriginalName();

                        Image::make($file->getPathname())->resize(800, 790, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save("$path/$file_name");

                        $productImage->save();

                    }

                }

                return redirect("/admin/products/")->with('success','Product successfully added');
            }
        }

        return redirect("/admin/products/add")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $product = Product::find($id);
        $providers = Provider::all();
        $cityList = DepartureCity::all();
        $productTypes = ProductType::all();
        $images = ProductImage::where('product_id',$id)->get();
        $videos = ProductVideo::where('product_id',$id)->get();

        $category_list = $product->categories;
        $categories = array();
        foreach($category_list as $category){
            $categories[] = $category->id;
        }
        $category_selection = implode(",",$categories);

        $recommended_list = $product->recommendedProducts;
        $recommendedProductsIds = array();
        foreach($recommended_list as $rProduct){
            $recommendedProductsIds[] = $rProduct->id;
        }
        $recommended_products_selection = implode(",",$recommendedProductsIds);


        return view('products.edit',compact(
            'product','providers','cityList',
            'productTypes','images', 
            'videos','category_selection',
            'recommended_products_selection'));
    }

    public function postEdit($id){

        $name = Input::get('name');
        $startTimes = Input::get('start_times');
        $defaultPrice = Input::get('default_price');
        $providerId = Input::get('provider_id');
        $departureCityId = Input::get('departure_city_id');
        $productTypeId = Input::get('product_type_id');

        $defaultPrice = Helpers::cleanPrice($defaultPrice);

        $product = Product::find($id);
        $product->name = $name;
        $product->start_times = $startTimes;
        $product->default_price = $defaultPrice;
        $product->provider_id = $providerId;
        $product->departure_city_id = $departureCityId;
        $product->product_type_id = $productTypeId;
        $product->user_id = $this->auth->user()->id;

        $category_ids = Input::get('categories');
        $rProduct_ids = Input::get('recommended_products');

        $input = Input::all();

        $rules = array(
            'name' => 'required',
            'start_times' => 'required',
            'default_price' => 'required',
            'provider_id' => 'required',
            'departure_city_id' => 'required',
            'product_type_id' => 'required'
        );

        $messages = array(
            'name.required' => 'This name field is required',
            'start_times.required' => 'This start times field is required',
            'default_price.required' => 'This default price field is required',
            'provider_id.required' => 'This provider field is required',
            'departure_city_id.required' => 'This departure city field is required',
            'product_type_id.required' => 'This product type field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $product->save();

            $productlink = "<a href='/admin/products/$id/edit'>$product->name</a>";

            if($product->id){

                if(!empty($category_ids)){
                    $category_ids_old = $product->categories;
                    $category_ids_old_array = [];
                    foreach($category_ids_old as $category){
                        $category_ids_old_array[] = $category->id;
                    }
                    $category_ids = explode(",",$category_ids);
                    $category_ids_old = array_diff($category_ids_old_array,$category_ids);

                    foreach($category_ids_old as $category_id){
                        $product->categories()->detach($category_id);
                    }

                    $category_ids_new = array_diff($category_ids,$category_ids_old_array);

                    foreach($category_ids_new as $category_id){
                        $product->categories()->attach($category_id);
                    }
                } else {
                    if(count($product->categories)>0){
                        $product->categories()->detach();
                    }
                }

                if(!empty($rProduct_ids)){
                    $rProduct_ids_old = $product->recommendedProducts;
                    $rProduct_ids_old_array = [];
                    foreach($rProduct_ids_old as $rProduct){
                        $rProduct_ids_old_array[] = $rProduct->id;
                    }
                    $rProduct_ids = explode(",",$rProduct_ids);
                    $rProduct_ids_old = array_diff($rProduct_ids_old_array,$rProduct_ids);

                    foreach($rProduct_ids_old as $rProduct_id){
                        $product->recommendedProducts()->detach($rProduct_id);
                    }

                    $rProduct_ids_new = array_diff($rProduct_ids, $rProduct_ids_old_array);

                    foreach($rProduct_ids_new as $rProduct_ids){
                        $product->recommendedProducts()->attach($rProduct_ids);
                    }
                } else {
                    if(count($product->recommendedProducts)>0){
                        $product->recommendedProducts()->detach();
                    }
                }

                return redirect("/admin/products/")->with('success',"Product $productlink successfully updated");
            }
        }

        return redirect("/admin/products/$id/edit")->withInput()->withErrors($validation);
    }

    // update image only
    public function postUpdate($id){
        
        $files = $this->request->file('product_images');
        
        
        if(count($files)){
            $path = storage_path()."/uploads/products/".$id;

            if (!is_dir($path)) {
                mkdir($path,0755,true);
            }
            
            
            foreach($files as $file) {

                if(!empty($file)){

                    $productImage = new ProductImage;
                    $extension = $file->getClientOriginalExtension();
                    $fileHash = md5($file->getPathname());
                    $fileName = $fileHash.".".$extension;
                    $productImage->hash = $fileHash;
                    $productImage->mime_type = $file->getClientMimeType();
                    $productImage->extension = $extension;
                    $productImage->product_id = $id;
                    $productImage->name = $file->getClientOriginalName();


                    Image::make($file->getPathname())->resize(800, 790, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save("$path/$fileName");

                    $productImage->save();
                }
            }
            return redirect("/admin/products/$id/edit")->with('success','Product images successfully updated');
        }
        
        
        $input = Input::all();
        
        $rules = array(
            'product_video_name' => 'required',
            'product_video_embed_code' => 'required'
        );

        $messages = array(
            'product_video_name.required' => 'This Video name field is required',
            'product_video_embed_code' => 'This Video embed code is required'
        );

        $validation = Validator::make($input, $rules,$messages);
        if($validation->fails()){
            return redirect("/admin/products/$id/edit")->withInput()->withErrors($validation);
        }

        if($this->request->get("product_video_embed_code")){

            $files_video = $this->request->file('product_video_thumb');
            $videoEmbedCode = $this->request->get("product_video_embed_code");
            $product_video_id = $this->request->get("id");
            if($product_video_id){
                $productVideo = ProductVideo::find($this->request->get("id"));
            }else{
                $productVideo = new ProductVideo;
            }
            
            $fileName = "";
            if(count($files_video)){
                $path_video_thumb = storage_path()."/uploads/products/video_thumb/".$id;
                if (!is_dir($path_video_thumb)) {
                    mkdir($path_video_thumb,0755,true);
                }
                if($product_video_id){
                    $extension = $files_video[$input['id']][0]->getClientOriginalExtension();
                    $fileHash = md5($files_video[$input['id']][0]->getPathname());
                    $fileName_default = $fileHash.".default.".$extension;
                    $fileName = $fileHash.".".$extension;

                    Image::make($files_video[$input['id']][0]->getPathname())->resize(200, 200, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save("$path_video_thumb/$fileName");
                    
                    Image::make($files_video[$input['id']][0]->getPathname())->resize(800, 800, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save("$path_video_thumb/$fileName_default");
                }else{
                    if(!is_null($files_video[0])){
                        $extension = $files_video[0]->getClientOriginalExtension();
                        $fileHash = md5($files_video[0]->getPathname());
                        $fileName_default = $fileHash.".default.".$extension;
                        $fileName = $fileHash.".".$extension;

                        Image::make($files_video[0]->getPathname())->resize(200, 200, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save("$path_video_thumb/$fileName");
                        Image::make($files_video[0]->getPathname())->resize(800, 800, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save("$path_video_thumb/$fileName_default");
                    }
                }

            }
            
            
            $productVideo->product_id = $id;
            $productVideo->embed_code = $videoEmbedCode;
            
            if($productVideo->video_thumb){
                $extension = explode('.',$productVideo->video_thumb);
                File::delete(storage_path()."/uploads/products/video_thumb/".$id.'/'.$extension[0].'.default.'.$extension[1]);
                File::delete(storage_path()."/uploads/products/video_thumb/".$id.'/'.$productVideo->video_thumb);
            }
            $productVideo->video_thumb = $fileName;
            $productVideo->name = $this->request->get("product_video_name");
            $productVideo->save();
            return redirect("/admin/products/$id/edit")->with('success','Product Video successfully updated');
        }

        
    }

    public function deleteImage($id){
        $productImage = ProductImage::find($id);
        //$count = ProductImage::where('product_id',$productImage->product_id)->count();
        //if($count > 1){
        Helpers::deleteFileHash($productImage->product_id,$productImage->hash);
        if(count($productImage->websites)>0){
            $productImage->websites()->detach();
        }
        // remove related image placement entries
        if(count($productImage->image_placements)>0){
            $productImage->image_placements()->detach();
        }
        $productImage->delete();
        //}
    }

    public function addWebsitesToImage($id){
        $website_ids = Input::get('websites');

        $productImage = ProductImage::find($id);

        if(!empty($website_ids)){
            $website_ids_old = $productImage->websites;
            $website_ids_old_array = [];
            foreach($website_ids_old as $website){
                $website_ids_old_array[] = $website->id;
            }
            $website_ids = explode(",",$website_ids);
            $website_ids_old = array_diff($website_ids_old_array,$website_ids);

            foreach($website_ids_old as $website_id){
                $productImage->websites()->detach($website_id);
            }

            $website_ids_new = array_diff($website_ids,$website_ids_old_array);

            foreach($website_ids_new as $website_id){
                $productImage->websites()->attach($website_id);
            }
        }else {
            if(count($productImage->websites)>0){
                $productImage->websites()->detach();
            }
        }
    }

    public function addProductImageTypeToImage($id){
        $product_image_placement_ids = Input::get('placements');
        $productImage = ProductImage::find($id);
        if(!empty($product_image_placement_ids)){
            $productImage->imagePlacements()->sync(explode(",",$product_image_placement_ids));
        }else {
            if(count($productImage->imagePlacements)>0){
                $productImage->imagePlacements()->detach();
            }
        }
    }
	
	public function addAltTextToImage($id){
		$altText = Input::get('alt_text');
		$productImage = ProductImage::find($id);
		$productImage->alt_text = $altText;
		$productImage->save();
	}

    public function addUpdateImageName($id){
        $name = Input::get('name');
        $productImage = ProductImage::find($id);
        $productImage->name = $name;
        $productImage->save();
    }

    public function delete($id){
        $product = Product::find($id);
        $name = $product->name;

        try {
            $categories = ProductsCategory::where('product_id',$product->id)->lists('id');
            ProductsCategory::destroy($categories);
            $product->delete();
            $images = ProductImage::where('product_id',$product->id)->lists('id');
            ProductImage::destroy($images);
            $path = storage_path()."/uploads/products/".$product->id;
            Helpers::deleteDir($path);
        } catch (QueryException $e) {
            return redirect('/admin/products')->with("error","<b>$name</b> cannot be deleted it is being used by the system. ");
        }

        return redirect('/admin/products')->with("success","<b>$name</b> has been deleted successfully");

    }


    public function getImagePlacements($id = null){
        $productImagePlacements = ProductImagePlacement::paginate(10);
        $productImagePlacement = null;
        if(!$id){
            $mode = "add";
        }else{
            $mode = "edit";
            $productImagePlacement = ProductImagePlacement::find($id);
        }
        
        return view('product_image_placements.index',compact('productImagePlacements', 'mode', 'productImagePlacement'));
    }

    public function postAddImagePlacement(){

        $input = Input::all();
        $rules = array(
            'name' => 'required',
            'description' => 'required',
        );
        $messages = array(
            'name.required' => 'This name field is required',
            'description.required' => 'This description field is required'
        );
        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

            $name = Input::get('name');
            $description = Input::get('description');

            $productImagePlacement = new ProductImagePlacement;
            $productImagePlacement->name = $name;
            $productImagePlacement->description = $description;

            $productImagePlacement->save();

            if($productImagePlacement->id){
                return redirect("/admin/products/images/placements")
                    ->with('success','Product image placement successfully added');
            }
        }

        return redirect("/admin/products/images/placements")->withInput()->withErrors($validation);
    }

    public function postUpdateImagePlacement($id){

        $input = Input::all();
        $rules = array(
            'name' => 'required',
            'description' => 'required',
        );
        $messages = array(
            'name.required' => 'This name field is required',
            'description.required' => 'This description field is required'
        );
        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

            $name = Input::get('name');
            $description = Input::get('description');
            $productImagePlacement = ProductImagePlacement::find($id);
            $productImagePlacement->name = $name;
            $productImagePlacement->description = $description;

            $productImagePlacement->save();

            if($productImagePlacement->id){
                return redirect("/admin/products/images/placements")
                    ->with('success','Product image placement successfully updated');
            }
        }

        return redirect("/admin/products/images/placements")->withInput()->withErrors($validation);
    }

    public function getImagePlacementDelete($id){
        $productImagePlacement = ProductImagePlacement::find($id);
        if($productImagePlacement){
            $productImagePlacement->delete();
            return redirect("/admin/products/images/placements")
                    ->with('success','Product image placement successfully deleted');
        }
        return redirect("/admin/products/images/placements")->with("error", "Something went wrong, Please Try again");
    }

    public function getVideoPlacements($id = null){
        $productVideoPlacements = ProductVideoPlacement::paginate(10);
        $productVideoPlacement = null;
        if(!$id){
            $mode = "add";
        }else{
            $mode = "edit";
            $productVideoPlacement = ProductVideoPlacement::find($id);
        }
        
        return view('product_video_placements.index',compact('productVideoPlacements', 'mode', 'productVideoPlacement'));
    }

    public function postAddVideoPlacement(){
        
        $input = Input::all();
        $rules = array(
            'name' => 'required',
            'description' => 'required',
        );
        $messages = array(
            'name.required' => 'This name field is required',
            'description.required' => 'This description field is required'
        );
        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

            $name = Input::get('name');
            $description = Input::get('description');

            $productVideoPlacement = new ProductVideoPlacement;
            $productVideoPlacement->name = $name;
            $productVideoPlacement->description = $description;

            $productVideoPlacement->save();

            if($productVideoPlacement->id){
                return redirect("/admin/products/videos/placements")
                    ->with('success','Product Video placement successfully added');
            }
        }

        return redirect("/admin/products/videos/placements")->withInput()->withErrors($validation);
    }

    public function postUpdateVideoPlacement($id){
        
        $input = Input::all();
        $rules = array(
            'name' => 'required',
            'description' => 'required',
        );
        $messages = array(
            'name.required' => 'This name field is required',
            'description.required' => 'This description field is required'
        );
        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

            $name = Input::get('name');
            $description = Input::get('description');

            $productVideoPlacement = ProductVideoPlacement::find($id);
            $productVideoPlacement->name = $name;
            $productVideoPlacement->description = $description;

            $productVideoPlacement->save();

            if($productVideoPlacement->id){
                return redirect("/admin/products/videos/placements")
                    ->with('success','Product Video placement successfully updated');
            }
        }

        return redirect("/admin/products/videos/placements")->withInput()->withErrors($validation);
    }

    public function getVideoPlacementDelete($id){
        $productVideoPlacement = ProductVideoPlacement::find($id);
        dd($productVideoPlacement);
        if($productVideoPlacement){
            $productVideoPlacement->delete();
            return redirect("/admin/products/videos/placements")
                    ->with('success','Product Video placement successfully deleted');
        }
        return redirect("/admin/products/videos/placements")->with("error", "Something went wrong, Please Try again");
    }

    public function getVideoDelete($id){
        $productVideo = ProductVideo::find($id);
        if($productVideo){
            if($productVideo->video_thumb){
                File::delete(storage_path()."/uploads/products/video_thumb/".$productVideo->product_id.'/'.$productVideo->video_thumb);
            }
            $productId = $productVideo->product_id;
            $productVideo->videoPlacements()->detach();
            $productVideo->delete();
            return redirect("admin/products/{$productId}/edit")
                    ->with('success','Product Video successfully deleted');
        }
        return redirect("admin/products/{$productId}/edit")->with("error", "Something went wrong, Please Try again");
    }

    public function addProductVideoPlacementToVideo($id){
        $product_video_placement_ids = Input::get('placements');

        $productVideo = ProductVideo::find($id);

        if(!empty($product_video_placement_ids)){
            $productVideo->videoPlacements()->sync(explode(",",$product_video_placement_ids));
        }else {
            if(count($productVideo->videoPlacements)>0){
                $productVideo->videoPlacements()->detach();
            }
        }
    }

}