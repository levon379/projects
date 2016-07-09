<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TourFee extends Model {

	protected $fillable = [];
	
	public function product()
    {
        // foreign key here
        return $this->belongsTo('App\Product','product_id');
    }

}
