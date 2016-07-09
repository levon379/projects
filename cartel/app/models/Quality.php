<?php
class Quality extends Eloquent {
	protected $table = 'quality';
	protected $fillable = [];

  /**-------------------------------------------------------------------------
   * getItems():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getItems($locale_id, $language_id) {
		$items = DB::select(DB::raw("
			SELECT c.id FROM quality c
			WHERE c.locale_id = :locale_id AND c.language_id = :language_id AND c.status_id IN (26,27)
			ORDER BY c.ordernum, c.name"), 
			array(
            'locale_id' => $locale_id,
            'language_id' => $language_id,
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
			select c.*, status.name as status_name, status.color as status_color FROM quality c
			LEFT JOIN status ON c.status_id = status.id
			WHERE c.id = :quality_id"), 
			array('quality_id' => $item_id));

    /* Exceptions for empty queries where return is assumed to exist */
    if(empty($itemInfo))
      throw new ModelNotFoundException("getItemInfo(): \$itemInfo not found");
      
    $itemInfo = $itemInfo[0];

    /*  Get previous item in Ordered list  */
    $prevItemID = Quality::where('ordernum', '<', $itemInfo->ordernum)
      ->whereIn('status_id', array(26,27))
      ->orderby('ordernum','desc')
      ->first(array('id'));
    $itemInfo->prev_id = $prevItemID['id'];

    /*  Get next item in Ordered list  */
    $nextItemID = Quality::where('ordernum', '>', $itemInfo->ordernum)
      ->whereIn('status_id', array(26,27))
      ->orderby('ordernum','asc')
      ->first(array('id'));
    $itemInfo->next_id = $nextItemID['id'];
    return $itemInfo;
	}
}
?>
