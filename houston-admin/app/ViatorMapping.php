<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ViatorMapping extends Model {

	protected $fillable = [];

	public function product(){
		return $this->belongsTo("\App\Product", "SupplierProductCode");
	}

	public function productOption(){
		return $this->belongsTo("\App\ProductOption", "SupplierOptionCode");
	}

	public function language(){
		return $this->belongsTo("\App\Language", "Language");
	}

	public function country(){
		return $this->belongsTo("\App\Country", "Country");
	}

	public function addon(){
		return $this->belongsTo("\App\Addon", "AddonID");
	}

}
