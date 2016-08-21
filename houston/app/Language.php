<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {

	protected $fillable = [];

	const ENGLISH = 1;
    const ESPANOL = 2;
    const DEUSTCH = 3;
    const ITALIANO = 4;
    const FRANCES = 5;

	public static $languageTypes = array(
        self::ENGLISH  => 'en',
        self::ESPANOL  => 'es',
        self::DEUSTCH  => 'de',
        self::ITALIANO => 'ita',
        self::FRANCES => 'fr'
    );

    public function options(){
        return $this->belongsToMany('App\ProductOption','product_options_languages', 'language_id' , 'product_option_id');
    }

}
