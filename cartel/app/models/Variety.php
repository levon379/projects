<?php
class Variety extends Eloquent {
	protected $table = 'variety';
	protected $fillable = [];

  /**-------------------------------------------------------------------------
   * getIdentifier():
	 *      Get the unique identifier for the object.
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getIdentifier() {
	  return $this->getKey();
	}

  /**-------------------------------------------------------------------------
   * getLocale():
	 *              Get the locale of this object 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getLocale() {
	  return $this->locale_id;
	}

  /**-------------------------------------------------------------------------
   * getLanguage():
   *                 
	 *      Get the language of this object 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getLanguage() {
	  return $this->language_id;
	}
}
