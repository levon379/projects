<?php
class Product_Type extends Eloquent {
	protected $table = 'product_type';
	protected $guarded = ['id'];
	
  /**-------------------------------------------------------------------------
   * getBoardProductTypes():
	 *   Get all of a users Product IDs, and those belonging to the same company
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getBoardProductTypes($locale_id, $language_id, $status_id) {
		$boardProductTypes = DB::select(DB::raw("		
			SELECT pt.id, pt.name, pt.image, pt.jump_link, pt.bgcolor FROM product_type pt
			WHERE pt.locale_id = :locale_id AND pt.language_id = :language_id AND pt.status_id = :status_id
			ORDER BY pt.ordernum, pt.id
			"), 
			array(
            'locale_id' => $locale_id,
            'language_id' => $language_id,
            'status_id' => $status_id,
      )
    );
    if(empty($boardProductTypes))
      return array();
		
    /* Store the jump link ie. "hot-house" as the key */
		foreach ($boardProductTypes as $key => &$value) {
			$new_id = $value->jump_link;
			$new_boardProductTypes[$new_id] = $value;
		}
    
		return $new_boardProductTypes;
	}
}
?>
