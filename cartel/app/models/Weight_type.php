<?php
class Weight_type extends Eloquent {
	protected $table = 'weight_type';
	protected $fillable = [];

  /**-------------------------------------------------------------------------
   * getItems():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getItems($locale_id, $language_id, $isbulk) {
		$items = DB::select(DB::raw("
			SELECT c.id FROM weight_type c
			WHERE c.locale_id = :locale_id AND c.language_id = :language_id AND c.status_id IN (44,45) AND isbulk = :isbulk
			ORDER BY c.ordernum, c.name"), 
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
   *-------------------------------------------------------------------------*/
	public static function getItemInfo($item_id) {
		$itemInfo = DB::select(DB::raw("		
			select c.*, status.name as status_name, status.color as status_color FROM weight_type c
			LEFT JOIN status ON c.status_id = status.id
			WHERE c.id = :weight_type_id"), array('weight_type_id' => $item_id));

      /* Exceptions for empty queries where return is assumed to exist */
      if(empty($itemInfo))
        throw new ModelNotFoundException("getItemInfo(): \$itemInfo is empty");
        
			$itemInfo = $itemInfo[0];

			/*  Get previous item in Ordered list  */
			$prevItemID = Weight_Type::where('ordernum', '<', $itemInfo->ordernum)
				->whereIn('status_id', array(44,45))
				->orderby('ordernum','desc')
				->first(array('id'));
			$itemInfo->prev_id = $prevItemID['id'];

			/* Get next item in Ordered list */
			$nextItemID = Weight_Type::where('ordernum', '>', $itemInfo->ordernum)
				->whereIn('status_id', array(44,45))
				->orderby('ordernum','asc')
				->first(array('id'));
			$itemInfo->next_id = $nextItemID['id'];

			return $itemInfo;
	}
}
?>
