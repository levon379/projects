<?php
class Province extends Eloquent {
	protected $table = 'province';
	protected $fillable = [];

  /**-------------------------------------------------------------------------
   * getNestedItems():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getNestedItems($locale_id, $language_id, $parent_type = 'country_id', $parent_id = 0) {
		$items = DB::select(DB::raw("
			SELECT c.id FROM province c
			WHERE c.locale_id = :locale_id AND c.language_id = :language_id AND $parent_type = :parent_id AND c.status_id IN (38,39)
			ORDER BY c.name"), 
			array(
            'locale_id' => $locale_id,
            'language_id' => $language_id,
            'parent_id' => $parent_id,
      )
    );
    if(empty($items))
      return array();
      
		return $items;
	}	
	
  /**-------------------------------------------------------------------------
   * getItemInfo():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getItemInfo($item_id) {
		$itemInfo = DB::select(DB::raw("		
			select c.*, status.name as status_name, status.color as status_color FROM province c
			LEFT JOIN status ON c.status_id = status.id
			WHERE c.id = :item_id"), 
			array('item_id' => $item_id));

    /* Exceptions for empty queries where return is assumed to exist */
    if(empty($itemInfo))
        throw new ModelNotFoundException("getItemInfo(): \$itemInfo not found");
    return $itemInfo[0];
	}
}
?>
