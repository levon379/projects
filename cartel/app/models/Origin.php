<?php
class Origin extends Eloquent {
	protected $table = 'origin';
	protected $fillable = [];

  /**-------------------------------------------------------------------------
   * getNestedItems():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getNestedItems($locale_id, $language_id, $parent_id = 0) {
		$items = DB::select(DB::raw("
			SELECT c.id FROM origin c
			WHERE c.locale_id = :locale_id AND c.language_id = :language_id AND c.status_id IN (35,36)
			ORDER BY c.name"), array('locale_id' => $locale_id, 'language_id' => $language_id,)
    );
    if(empty($items))
      return array();
    
		foreach ($items as $key => &$value) {
			$value->sub = array();		
			$subitem = Province::getNestedItems($locale_id, $language_id, 'origin_id', $value->id);
			$value->sub = $subitem;		
		}
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
			select c.*, status.name as status_name, status.color as status_color FROM origin c
			LEFT JOIN status ON c.status_id = status.id
			WHERE c.id = :item_id
			"), array('item_id' => $item_id));
    
    /* Exceptions for empty queries where return is assumed to exist */
    if(empty($itemInfo))
     throw new ModelNotFoundException("getItemInfo(): \$itemInfo is empty");
       
    $itemInfo = $itemInfo[0]; 
    $itemInfo->sub = array();
    return $itemInfo;
	}
}
?>
