<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVideo extends Model {

    protected $fillable = [];

    public function videoPlacements(){
        return $this->belongsToMany('App\ProductImagePlacement','product_videos_product_video_placements' , 'product_video_id','product_video_placement_id');
    }

    public function getVideoPlacementsList() {
        $video_placements_list = $this->videoPlacements;
        $video_placements = array();
        foreach($video_placements_list as $video_placement){
            $video_placements[] = $video_placement->id;
        }
        if(count($video_placements)){
            return implode(",",$video_placements);
        }
        return "";
    }
}
