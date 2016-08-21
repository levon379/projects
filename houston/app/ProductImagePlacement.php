<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImagePlacement extends Model {

    protected $fillable = [];

    public function scopeBigImagePlacement($query){
    	return $query->where("product_image_placements.id", 1);
    }

    public function scopeImagePlacement($query, $type){
        return $query->where("product_image_placements.id", $type);
    }


    public function scopeProduct($query){
    	return $query
    			->join('product_images_product_image_placements', 'product_images_product_image_placements.product_image_placement_id', '=', 'product_image_placements.id')
    			->join("product_images", "product_images.id", "=", "product_images_product_image_placements.product_image_id");
    }

    // public function product($id){
    // 	\DB::enableQueryLog();
    // 	$image = $this->belongsToMany("\App\ProductImage", "product_images_product_image_placements", "product_image_id", "product_image_placement_id")->where("product_images.product_id", $id)->first();
    // 	dd(\DB::getQueryLog());
    // }

}
