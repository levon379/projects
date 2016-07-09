<?php
class Package extends Eloquent {
	protected $table = 'package';
	protected $fillable = [];

  /**-------------------------------------------------------------------------
   * getItems():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getItems($locale_id, $language_id, $isbulk) {
		$items = DB::select(DB::raw("
			SELECT c.id FROM package c
			WHERE c.locale_id = :locale_id AND c.language_id = :language_id AND c.status_id IN (29,30) AND isbulk = :isbulk
			ORDER BY c.ordernum, c.name
			"), 
			array(
        'locale_id' => $locale_id,
        'language_id' => $language_id,
        'isbulk' => $isbulk,
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
   * @param  int  $id
   * @return Response
   *-------------------------------------------------------------------------*/
	public static function getItemInfo($item_id) {
		$itemInfo = DB::select(DB::raw("		
			select c.*, status.name as status_name, status.color as status_color FROM package c
			LEFT JOIN status ON c.status_id = status.id
			WHERE c.id = :package_id
			"), array('package_id' => $item_id));

    /* Exceptions for empty queries where return is assumed to exist */
    if(empty($itemInfo))
     throw new ModelNotFoundException("getItemInfo(): \$itemInfo not found");
     
    $itemInfo = $itemInfo[0];  // collapse the array one level, don't need the extra [0] dimension

    /*  Get previous item in Ordered list  */
    $prevItemID = Package::where('ordernum', '<', $itemInfo->ordernum)
      ->where('isbulk', $itemInfo->isbulk)
      ->whereIn('status_id', array(29,30))
      ->orderby('ordernum','desc')
      ->first(array('id'));
    $itemInfo->prev_id = $prevItemID['id'];

    /*  Get next item in Ordered list  */
    $nextItemID = Package::where('ordernum', '>', $itemInfo->ordernum)
      ->where('isbulk', $itemInfo->isbulk)
      ->whereIn('status_id', array(29,30))
      ->orderby('ordernum','asc')
      ->first(array('id'));
    $itemInfo->next_id = $nextItemID['id'];

    return $itemInfo;
	}
}
?>
