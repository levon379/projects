<?php
class Maturity extends Eloquent {
	protected $table = 'maturity';
	protected $fillable = [];

  /**-------------------------------------------------------------------------
   * getItems():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getItems($locale_id, $language_id) {
		$items = DB::select(DB::raw("
			SELECT c.id FROM maturity c
			WHERE c.locale_id = :locale_id AND c.language_id = :language_id AND c.status_id IN (19,21)
			ORDER BY c.ordernum, c.name
			"), 
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
   * @param  int  $id
   * @return Response
   *-------------------------------------------------------------------------*/
	public static function getItemInfo($item_id) {
		$itemInfo = DB::select(DB::raw("		
			select c.*, status.name as status_name, status.color as status_color FROM maturity c
			LEFT JOIN status ON c.status_id = status.id
			WHERE c.id = :maturity_id
			"), 
			array('maturity_id' => $item_id));

    /* Exceptions for empty queries where return is assumed to exist */
    if(empty($itemInfo))
     throw new ModelNotFoundException("getItemInfo(): \$itemInfo are empty ");

    $itemInfo = $itemInfo[0];

    /*  Get previous item in Ordered list  */
    $prevItemID = Maturity::where('ordernum', '<', $itemInfo->ordernum)
      ->whereIn('status_id', array(19,21))
      ->orderby('ordernum','desc')
      ->first();
    
    /* Store the previous item or null if there is none */
    if($prevItemID != null)
      $itemInfo->prev_id = $prevItemID->id;
    else
      $itemInfo->prev_id = null;

    /*  Get next item in Ordered list  */
    $nextItemID = Maturity::where('ordernum', '>', $itemInfo->ordernum)
      ->whereIn('status_id', array(19,21))
      ->orderby('ordernum','asc')
      ->first(array('id'));
    if($nextItemID != null)
      $itemInfo->next_id = $nextItemID->id;
    else
      $itemInfo->next_id = null;
      
    return $itemInfo;
	}
}
?>
