<?php
class Bid extends Eloquent {
	protected $table = 'bid';    		
	protected $fillable = [];		
  
  /**-------------------------------------------------------------------------
   * getRecentBids(): build all details of a bid
   *                 
   *--------------------------------------------------------------------------
   * @param  int  $id
   * @return 2D array
   *-------------------------------------------------------------------------*/
	public static function getRecentBids($locale_id, $start_date = 0, $end_date = 0) {
		$bidList = DB::select(DB::raw("		
			SELECT b.id, b.product_id, b.created_at, b.accepter_id, b.bid_type, status.color AS status_color, status.description AS bid_status, b.user_id AS bidder_id, user.name AS bidder_name, company.id AS bidder_company_id, company.name AS bidder_company_name, u2.id AS product_owner_id, u2.name AS product_owner_name, c2.id AS product_owner_company_id, c2.name AS product_owner_company_name, order.id AS order_id, order.accounting_number, locale.accounting_prefix
			FROM bid b
			LEFT JOIN user ON b.user_id = user.id
			LEFT JOIN company ON user.company_id = company.id
			LEFT JOIN product ON b.product_id = product.id
			LEFT JOIN user AS u2 ON product.user_id = u2.id
			LEFT JOIN company AS c2 ON u2.company_id = c2.id
			LEFT JOIN `order` ON b.id = order.bid_id
			LEFT JOIN status ON b.status_id = status.id
			LEFT JOIN locale ON b.locale_id = locale.id
			WHERE b.locale_id = :locale_id AND b.created_at BETWEEN :start_date AND :end_date
			ORDER BY created_at DESC"), 
			array(
			'locale_id' => $locale_id,
			'start_date' => $start_date.' 00:00:00',
			'end_date' => $end_date.'  23:59:59',
		));
    
    if(empty($bidList))
      return array();
      
    return $bidList;
  }
	
	
  /**-------------------------------------------------------------------------
   * getBidInfo: Gets the details of a bid given it's ID
   *                 
   *--------------------------------------------------------------------------
   *
   * @param  int  $id
   * @return 2D array
   *-------------------------------------------------------------------------*/
	public static function getBidInfo($bid_id) {
		$bidInfo = DB::select(DB::raw("		
			select b.*, origin.name AS place_of_origin_name, origin.image AS place_of_origin_image, product_type.name AS productType_name, category.name AS variety_name, category.parent_id AS variety_parent_id, m.name AS maturity_name, q.name AS quality_name, colour.name AS colour_name, user.name AS user, pkg1.name AS carton_package_name, pkg2.name AS bulk_package_name, wt1.name AS carton_weight_type_name, wt2.name AS bulk_weight_type_name, status.name AS status_name FROM bid b 
			LEFT JOIN origin ON b.origin_id = origin.id
			LEFT JOIN product_type ON b.product_type_id = product_type.id
			LEFT JOIN category ON b.category_id = category.id
			LEFT JOIN user ON b.user_id = user.id
			LEFT JOIN package pkg1 ON b.carton_package_id = pkg1.id
			LEFT JOIN package pkg2 ON b.bulk_package_id = pkg2.id
			LEFT JOIN weight_type wt1 ON b.carton_weight_type_id = wt1.id
			LEFT JOIN weight_type wt2 ON b.bulk_weight_type_id = wt2.id
			LEFT JOIN maturity m ON b.maturity_id = m.id
			LEFT JOIN colour ON b.colour_id = colour.id
			LEFT JOIN quality q ON b.quality_id = q.id
			LEFT JOIN status ON b.status_id = status.id
			WHERE b.id = :bid_id"), 
			array('bid_id' => $bid_id));
    
      /* Exceptions for empty queries where return is assumed to exist */
      if(empty($bidInfo))
        throw new ModelNotFoundException("getBidInfo(): \$bidInfo not found");
      $bidInfo = $bidInfo[0];
    
    
      /* Variety is a parent, so swap labels for view presentation */
      if($bidInfo->variety_parent_id == 0) {	
        $bidInfo->product_name = $bidInfo->variety_name;
        $bidInfo->variety_name = '';		
      }
      /* Variety is a child, so get the parent name */
      else {	
        $bidInfo->variety_id = $bidInfo->category_id;
        $parentInfo = Category::whereRaw("id = ?",array($bidInfo->variety_parent_id))->get(array('id', 'name'));
        $bidInfo->product_name = $parentInfo[0]->name;
        $bidInfo->category_id = $parentInfo[0]->id;
      }

      $bidInfo->availability_date  = date('M j Y', strtotime($bidInfo->availability_start));
      $bidInfo->availability_start = date('g:00 A', strtotime($bidInfo->availability_start));
      $bidInfo->availability_end   = date('g:00 A', strtotime($bidInfo->availability_end));

      /* Confirm that the Label image exists, else substitute a generic label */
      if(file_exists(public_path().'/images/labels/'.$bidInfo->place_of_origin_image == 0))
        $bidInfo->place_of_origin_image = '';	

      $bidInfo->product_owner_id = DB::table('product')->where('id', '=', $bidInfo->product_id )->pluck('user_id');
      return $bidInfo;
	} // getBidInfo()
} //class

?>
