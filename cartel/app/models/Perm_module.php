<?php
class Perm_module extends Eloquent {
	protected $table = 'perm_module';
	protected $fillable = [];
	
  /**-------------------------------------------------------------------------
   * getItems():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getItems($locale_id, $language_id) {
		$items = DB::select(DB::raw("
			SELECT c.id FROM perm_module c
			WHERE c.status_id IN (16,17) AND id>1
			ORDER BY c.ordernum, c.name"));
    
    if(empty($items))
      return array();
      
		return $items;
	}

  /**-------------------------------------------------------------------------
   * getItemInfo():
   *                 
   *--------------------------------------------------------------------------
   *
   * @param  int  $id
   * @return Response
   *-------------------------------------------------------------------------*/
	public static function getItemInfo($item_id) {
		$itemInfo = DB::select(DB::raw("		
			select c.*, status.name as status_name, status.color as status_color FROM perm_module c
			LEFT JOIN status ON c.status_id = status.id
			WHERE c.id = :item_id"), 
			array('item_id' => $item_id));

    /* Exceptions for empty queries where return is assumed to exist */
    if(empty($itemInfo))
     throw new ModelNotFoundException("getItemInfo(): \$itemInfo not found");
       
    $itemInfo = $itemInfo[0];  // collapse the array one level, don't need the extra [0] dimension
    return $itemInfo;
	}
}
?>
