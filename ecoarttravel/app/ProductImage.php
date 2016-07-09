<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model {

    protected $fillable = [];

    public function websites(){
        return $this->belongsToMany('App\Website','product_images_websites' , 'product_image_id','website_id');
    }

    public function imagePlacements(){
        return $this->belongsToMany('App\ProductImagePlacement','product_images_product_image_placements' , 'product_image_id','product_image_placement_id');
    }

    public function getWebsiteList() {
        $website_list = $this->websites;
        $websites = array();
        if(!count($website_list)) return "";
        foreach($website_list as $website){
            $websites[] = $website->id;
        }
        return implode(",",$websites);
    }

    public function getImagePlacementsList() {
        $image_placements_list = $this->imagePlacements;
        $image_placements = array();
        if(!count($image_placements_list)) return "";
        foreach($image_placements_list as $image_type){
            $image_placements[] = $image_type->id;
        }
        if(count($image_placements)){
            return implode(",",$image_placements);
        }
        return "";
    }
}
