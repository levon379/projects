<?php
class Category extends Eloquent {
	protected $table = 'category';
	protected $fillable = array('locale_id', 'language_id', 'name', 'parent_id', 'isother', 'status_id', 'ordernum');

  /**-------------------------------------------------------------------------
   * getNestedItems():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getNestedItems($locale_id, $language_id, $parent_id = 0) {
		$items = DB::select(DB::raw("
			SELECT c.id FROM category c
			WHERE c.locale_id = :locale_id AND c.language_id = :language_id AND parent_id = :parent_id AND c.status_id IN (23,24) AND isother = 0
			ORDER BY c.name
			"), 
			array(
			'locale_id' => $locale_id,
			'language_id' => $language_id,
			'parent_id' => $parent_id,
		));
    /* Return empty array if no items */
    if(empty($items))
      return array();
      
    /* Get the sub children of each nested item */
		foreach ($items as $key => &$value) {
			$value->sub = array();		
      $subitem = Category::getNestedItems($locale_id, $language_id, $value->id);
      $value->sub = $subitem;		
		}
		return $items;
	}	
	
	
  /**-------------------------------------------------------------------------
   * getItemInfo:
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getItemInfo($item_id) {
		$itemInfo = DB::select(DB::raw("		
			select c.*, status.name as status_name, status.color as status_color FROM category c
			LEFT JOIN status ON c.status_id = status.id
			WHERE c.id = :colour_id
			"), 
			array(
			'colour_id' => $item_id,
		));
    
    /* Exceptions for empty queries where return is assumed to exist */
    if(empty($itemInfo))
      throw new ModelNotFoundException("getItemInfo(): \$itemInfo is empty");
    
    $itemInfo = $itemInfo[0];
    $itemInfo->sub = array();
    
    /*  Get previous item in Ordered list  */
    $prevItemID = Colour::where('ordernum', '<', $itemInfo->ordernum)
      ->whereIn('status_id', array(16,17))
      ->orderby('ordernum','desc')
      ->first(array('id'));
    $itemInfo->prev_id = $prevItemID['id'];

    /*  Get next item in Ordered list  */
    $nextItemID = Colour::where('ordernum', '>', $itemInfo->ordernum)
      ->whereIn('status_id', array(16,17))
      ->orderby('ordernum','asc')
      ->first(array('id'));
    $itemInfo->next_id = $nextItemID['id'];
    
    return $itemInfo;
	}
}
?>
