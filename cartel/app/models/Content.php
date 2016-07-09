<?php
class Content extends Eloquent {
	protected $table = 'content'; 
	protected $fillable = [];

  /**-------------------------------------------------------------------------
   * getItems():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getItems($language_id, $content_group = 'site', $type = 'text') {
		$items = DB::select(DB::raw("
			SELECT c.id FROM content c
			WHERE c.language_id = :language_id AND c.content_group = :content_group AND c.type = :type
			ORDER BY c.name
			"), 
			array(
            'language_id' => $language_id,
            'content_group' => $content_group,
            'type' => $type,
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
		$item_query = DB::select(DB::raw("		
			select c.* FROM content c
			WHERE c.id = :content_id
			"), array('content_id' => $item_id));
      /* Exceptions for empty queries where return is assumed to exist */
      if(empty($item_query))
        throw new ModelNotFoundException("getItemInfo: \$itemInfo is empty");
			$item = $item_query[0];

			$item->language_name = Language::findOrFail($item->language_id )->name;
      
			return $item;
	}
}
?>
