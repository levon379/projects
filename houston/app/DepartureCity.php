<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartureCity extends Model {

    protected $table = "departure_city";

	protected $fillable = [];

	public function languageDetails()
	{
		return $this->hasMany('App\DepartureCityLanguageDetail' );
	}

	public function languageDetail()
	{
		return $this->hasOne('App\DepartureCityLanguageDetail' );
	}

	public function products()
	{
		return $this->hasMany('App\Product');
	}

}
