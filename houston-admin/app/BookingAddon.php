<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingAddon extends Model {

	protected $fillable = [];

	public function addon(){
		return $this->hasOne("\App\Addon", "id", "addon_id");
	}

	public function paymentMethod(){
		return $this->hasOne("\App\PaymentMethod", "id", "payment_method_id");
	}

}
