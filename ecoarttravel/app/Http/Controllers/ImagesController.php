<?php namespace App\Http\Controllers;

use App\Addon;
use App\Libraries\Response;
use App\ProductImage;
use App\ProductVideo;
use App\Provider;
use File;

class ImagesController extends Controller {


    public function viewProductImage($image_hash,$type)
    {

        $productImage = ProductImage::where('hash', $image_hash)->first();
        $path = storage_path()."/uploads/products/".$productImage->product_id."/".$productImage->hash.".".$productImage->extension;
        if (file_exists($path)) {
            return Response::inline($path,$productImage->mime_type,$type);
        }
        return Response::error();
    }
    public function viewProductVideoThumb($video_id)
    {

        $product = ProductVideo::where('id', $video_id)->first();
        $path = storage_path()."/uploads/products/video_thumb/".$product->product_id."/".$product->video_thumb;
        
        $file = File::get($path);
        $extension_array = explode('.',$product->video_thumb);
        $extension = File::extension($path);
        $mime_type = File::mimeType($path);
        if (file_exists($path)) {
            return Response::inline($path);
        }
        return Response::error();
    }

    public function viewAddonImage($id){
        $addon = Addon::find($id);
        $path = storage_path()."/uploads/addons/".$addon->id."/addon.".$addon->image_extension;
        if (file_exists($path)) {
            return Response::inline($path,$addon->image_mime_type,"neutral");
        }
        return Response::error();
    }

    public function viewProviderImage($id){
        $provider = Provider::find($id);
        $path = storage_path()."/uploads/providers/".$provider->id."/provider.".$provider->image_extension;
        if (file_exists($path)) {
            return Response::inline($path,$provider->image_mime_type,"neutral");
        }
        return Response::error();
    }
}
