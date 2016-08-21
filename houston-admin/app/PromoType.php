<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoType extends Model {

	protected $fillable = [];

	const NEWPRICING = 2;
    const FREEADDON = 3;
    const FIXEDDISCOUNT = 4;
    const PERCENTDISCOUNT = 5;

	public static $promoTypes = array(
        self::NEWPRICING => 'New Pricing',
        self::FREEADDON => 'Free Add On',
        self::FIXEDDISCOUNT => 'Fixed Discount',
        self::PERCENTDISCOUNT => '% Discount'
    );
}
