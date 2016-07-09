<?php
class Product extends Eloquent {
	protected $table = 'product';
	protected $guarded = ['id'];

  /**-------------------------------------------------------------------------
   * getUsersProducts():
   *                 
	 *  get all of a users Product IDs, and those belonging to the same company  
   *--------------------------------------------------------------------------
   *
   * @param  int  $id
   * @return Response
   *-------------------------------------------------------------------------*/
	public static function getUsersProducts($locale_id, $language_id, $user_id, $post_type, $start_date, $end_date, $status_id) {
		$status_query = 'AND (p.status_id = 0';
    
		foreach($status_id as $status)
      $status_query.=' OR p.status_id = '.$status;
      
		$status_query.= ')';

		$usersProducts = DB::select(DB::raw("
			SELECT p.id FROM product p
			WHERE p.locale_id = :locale_id AND p.language_id = :language_id ".$status_query." AND p.post_type = :post_type 
				AND p.created_at BETWEEN :starttime AND :endtime
				AND p.user_id IN 
					(SELECT id FROM user WHERE company_id IN 
						(SELECT company_id FROM user WHERE id = :user_id)
					)
			ORDER BY created_at DESC"), 
			array(
            'locale_id' => $locale_id,
            'language_id' => $language_id,
            'post_type' => $post_type,
            'starttime' => $start_date.' 00:00:00',
            'endtime' => $end_date.' 23:59:59',
            'user_id' => $user_id,
      )
    );
    if(empty($usersProducts))
      return array();
       
		return $usersProducts;
	}

  /**-------------------------------------------------------------------------
   * getBoardActiveProducts():
	 *  get Product IDs belonging to a board product-type 
   *                 
   *--------------------------------------------------------------------------
   *
   * @param  int  $id
   * @return Response
   *-------------------------------------------------------------------------*/
	public static function getBoardActiveProducts($locale_id, $language_id, $product_type_id, $post_type) {
		$today = date('Y-m-d');
		$boardProducts = DB::select(DB::raw("
			SELECT p.id FROM product p
			WHERE p.locale_id = :locale_id AND p.language_id = :language_id AND p.product_type_id = :product_type_id AND p.status_id IN (54,79) AND p.post_type = :post_type
				AND p.created_at BETWEEN :starttime AND :endtime

			ORDER BY p.id"), 
			array(
            'locale_id' => $locale_id,
            'language_id' => $language_id,
            'product_type_id' => $product_type_id,
            'post_type' => $post_type,
            'starttime' => $today.' 00:00:00',
            'endtime' => $today.' 23:59:59',
      )
    );
    if(empty($boardProducts))
      return array();
		return $boardProducts;
	}
		
  /**-------------------------------------------------------------------------
   * getProductInfo():
	 *            Build all the details of a product
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getProductInfo($product_id) {
		$productInfo = DB::select(DB::raw("
			select p.*, origin.name as place_of_origin_name, origin.image as place_of_origin_image, product_type.name as productType_name, category.name as variety_name, category.parent_id as variety_parent_id, category.isother as variety_isother, m.name as maturity_name, q.name as quality_name, colour.name as colour_name, user.name as user, pkg1.name as carton_package_name, pkg2.name as bulk_package_name, wt1.name as carton_weight_type_name, wt2.name as bulk_weight_type_name, status.name as status_name FROM product p 
			LEFT JOIN origin ON p.origin_id = origin.id
			LEFT JOIN product_type ON p.product_type_id = product_type.id
			LEFT JOIN category ON p.category_id = category.id
			LEFT JOIN user ON p.user_id = user.id
			LEFT JOIN package pkg1 ON p.carton_package_id = pkg1.id
			LEFT JOIN package pkg2 ON p.bulk_package_id = pkg2.id
			LEFT JOIN weight_type wt1 ON p.carton_weight_type_id = wt1.id
			LEFT JOIN weight_type wt2 ON p.bulk_weight_type_id = wt2.id
			LEFT JOIN maturity m ON p.maturity_id = m.id
			LEFT JOIN colour ON p.colour_id = colour.id
			LEFT JOIN quality q ON p.quality_id = q.id
			LEFT JOIN status ON p.status_id = status.id
			WHERE p.id = :product_id"), 
			array('product_id' => $product_id));
    /* Exceptions for empty queries where return is assumed to exist */
    if(empty($productInfo))
        throw new ModelNotFoundException("getProductInfo(): \$productInfo not found");
    $productInfo = $productInfo[0];  // collapse the array one level, don't need the extra [0] dimension
    
    
    /* Get the product's seller's company id */
    $productInfo->user_company_id = DB::table('user')->where('id', '=', $productInfo->user_id )->pluck('company_id');
    /* Exceptions for empty queries where return is assumed to exist */
    if(empty($productInfo->user_company_id))
        throw new ModelNotFoundException("getProductInfo(): \$productInfo['user_company_id'] not found");
    
    
    /* Variety is a parent, so swap labels for view presentation */
    if($productInfo->variety_parent_id == 0) {	
      $productInfo->product_name = $productInfo->variety_name;
      $productInfo->variety_name = '';		
      $productInfo->variety_id = '';
    }
    /* Variety has a parent, so get the parent name */
    else {	
      $productInfo->variety_id = $productInfo->category_id;
      
      $parentInfo = Category::whereRaw("id = ?",array($productInfo->variety_parent_id))->get(array('id', 'name'));
      /* Exceptions for empty queries where return is assumed to exist */
      if(empty($parentInfo))
          throw new ModelNotFoundException("getProductInfo(): \$parentInfo not found");
      
      $productInfo->product_name = $parentInfo[0]->name;
      $productInfo->category_id = $parentInfo[0]->id;
    }

    $productInfo->availability_date = date('M j Y', strtotime($productInfo->availability_start));
    $productInfo->availability_start = date('g:00 A', strtotime($productInfo->availability_start));
    $productInfo->availability_end = date('g:00 A', strtotime($productInfo->availability_end));

    /* confirm that the Label image exists, else substitute a generic label */
    if(file_exists(app_path().'/../images/labels/'.$productInfo->place_of_origin_image == 0) || $productInfo->place_of_origin_image == '')
      $productInfo->place_of_origin_image = '';

    /* Determine if the product has any active Bids, store '0' if none */
    $starttime = date('Y-m-d').' 00:00:00';
    $endtime = date('Y-m-d').' 23:59:59'; 
    $bid_id  =  Bid::where('product_id', '=', $product_id)
                   ->where('status_id', '=', 59)
                   ->where('created_at', '<', $endtime)
                   ->where('created_at', '>', $starttime)
                   ->first(array('id'));
    if(!empty($bid_id))
      $productInfo->active_bid_id = $bid_id['id'];
    else
      $productInfo->active_bid_id = 0;

    /* Strip trailing decimal zeros from bulk weight and carton weight */
    $productInfo->bulk_weight = (float)$productInfo->bulk_weight;
    $productInfo->carton_weight = (float)$productInfo->carton_weight;
    
    /* Get the details of the shipping address  */
    if($productInfo->company_address_id != 0) {	
      $addressInfo = Company_address::getOneShippingAddress($productInfo->company_address_id);
      $productInfo->address = $addressInfo;
    }
    return $productInfo;
	}
} //class
?>
