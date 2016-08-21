<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {

	protected $fillable = [];
	
	public $true = "<i class='fa fa-check text-success'></i>";
    public $false = "<i class='fa fa-times text-danger'></i>";
	
	public function source()
    {
        // foreign key here
        return $this->belongsTo('App\ReviewSource','review_source_id');
    }
	
	public function booking()
    {
        // foreign key here
        return $this->belongsTo('App\Booking','booking_id');
    }
	
	public function product()
    {
        // foreign key here
        return $this->belongsTo('App\Product','product_id');
    }
	
	public function language()
    {
        // foreign key here
        return $this->belongsTo('App\Language','language_id');
    }
	
	public function getShown(){
        return $this->flag_show ? $this->true : $this->false;
    }
	
	public function showRating(){
		$filled = "<i class='fa-star fa'></i>";
		$hollow = "<i class='fa-star-o fa'></i>";
		$rating = (int)$this->rating;
		$ratingDisplay = "";
		for($count = 1; $count <= 5; $count++){
			$ratingDisplay = ($count <= $rating) ? $ratingDisplay.$filled : $ratingDisplay.$hollow;
		}
		return $ratingDisplay;
	}

}
