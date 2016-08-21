<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = "categories";

	protected $fillable = [];

	public function languageDetails()
	{
		return $this->hasMany('App\CategoryLanguageDetail' );
	}

	public function languageDetail()
	{
		return $this->hasOne('App\CategoryLanguageDetail' );
	}

	public function products()
	{
		return $this->belongsToMany('App\Product', 'products_categories');
	}

}
