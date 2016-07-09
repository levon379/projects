<?php
class Order extends Eloquent {
	protected $table = 'order';
	protected $fillable = [];	 
	
  /**-------------------------------------------------------------------------
   * getOrderInfo(): returns an array of relevant data about an order given 
   *                 it's id.
   *                 
   *--------------------------------------------------------------------------
   * @param  int  $id
   * @return 2D array of order information
   *-------------------------------------------------------------------------*/
	public static function getOrderInfo($order_id) {
    
    /*--------------------------------------------------------------------*/
    /* Get data from the order table from id */
    /*--------------------------------------------------------------------*/
		$orderInfo = DB::select(DB::raw("
			SELECT o.*, status.color AS status_color, status_ar.color AS receivable_status_color , status_ap.color AS payable_status_color FROM `order` o
			LEFT JOIN status ON status.id = status_id
			LEFT JOIN status AS status_ar ON status_ar.id = o.receivable_status_id
			LEFT JOIN status AS status_ap ON status_ap.id = o.payable_status_id
			WHERE o.id = :order_id"), 
			array(
			'order_id' => $order_id
		))[0];
    /* Exceptions for empty queries where return is assumed to exist */
		if(empty($orderInfo))
      throw new ModelNotFoundException("getOrderInfo(): \$orderInfo is empty");
    /* Format the order's created time for display */
    $orderInfo->created_at = date("Y-m-d H:i:s", strtotime($orderInfo->created_at));
    
    /*--------------------------------------------------------------------*/
    /* Get the accounting prefix */
    /*--------------------------------------------------------------------*/
    $accounting_prefix = DB::table('locale')
                            ->where('id', '=', $orderInfo->locale_id)
                            ->pluck('accounting_prefix');
    /* Exceptions for empty queries where return is assumed to exist */
    if($accounting_prefix == null)
      throw new ModelNotFoundException("getOrderInfo(): \$accounting_prefix is empty");
    /* Add the prefix to the accounting number */
    $orderInfo->accounting_number = $accounting_prefix.$orderInfo->accounting_number;
      
    /*--------------------------------------------------------------------*/
    /* Get the bid info */
    /*--------------------------------------------------------------------*/
    $orderInfo->bidInfo = Bid::getBidInfo($orderInfo->bid_id);
    
    /*--------------------------------------------------------------------*/
    /* Get the bid info */
    /*--------------------------------------------------------------------*/
    $orderInfo->productInfo = Product::getProductInfo($orderInfo->bidInfo->product_id);
    

    /* Get details of the people involved with the product/bid  */	
    
    /* When bidding to sell, the bidder (current user) is the seller, and the original poster is the buyer */
    if($orderInfo->bidInfo->bid_type == 'sell') {	
      $orderInfo->sellerInfo = User::getUserInfo($orderInfo->bidInfo->user_id);
      $orderInfo->buyerInfo = User::getUserInfo(Auth::id());
      $orderInfo->originalPosterInfo = User::getUserInfo($orderInfo->bidInfo->product_owner_id);
      $orderInfo->sellerInfo->pickupAddress = Company_address::getOneShippingAddress($orderInfo->bidInfo->company_address_id);
      $orderInfo->buyerInfo->deliveryAddress = Company_address::getOneShippingAddress($orderInfo->productInfo->company_address_id);
    }
    else {	
      $orderInfo->sellerInfo = User::getUserInfo(Auth::id());
      $orderInfo->buyerInfo = User::getUserInfo($orderInfo->bidInfo->user_id);
      $orderInfo->originalPosterInfo = User::getUserInfo($orderInfo->bidInfo->product_owner_id);
      $orderInfo->sellerInfo->pickupAddress = Company_address::getOneShippingAddress($orderInfo->productInfo->company_address_id);
      $orderInfo->buyerInfo->deliveryAddress = Company_address::getOneShippingAddress($orderInfo->bidInfo->company_address_id);
    }

    /* Set proper working qty  */
    if($orderInfo->status_id == 63)	// New-ish order
      $orderInfo->chargeable_qty = $orderInfo->bidInfo->qty;
    elseif ($orderInfo->status_id == 72) // Shipped Order
      $orderInfo->chargeable_qty = $orderInfo->shipped_qty;
    elseif ($orderInfo->status_id == 73) // Rec'd Order
      $orderInfo->chargeable_qty = $orderInfo->received_qty;

    /* Retrieve corresponding tax rates  */
    $taxInfo = Tax::lookupTaxes($orderInfo->locale_id,$orderInfo->language_id, $orderInfo->tax_group_id,$orderInfo->created_at);
    $orderInfo->taxes = $taxInfo;
    
    /* Retrieve brokerage details and the corresponding brokerage minimum from the same group (just for reference/display)  */
    $orderInfo->brokerageInfo = Brokerage::lookupBrokerage($orderInfo->brokerage_id);
    $orderInfo->brokerageInfo->display = $orderInfo->brokerageInfo->rate * 100;
    $orderInfo->brokerageInfo->display = str_replace(':rate:',$orderInfo->brokerageInfo->display,$orderInfo->brokerageInfo->display);
    
    /* Retrieve related misc_charges  */
    //$miscChargesInfo = Order_Misc_Charge::lookupMiscCharge($orderInfo->locale_id, $orderInfo->language_id, $orderInfo->tax_group_id, 
    $orderInfo->misc_charges_amount = 0;

    /*  Determine subtotals, taxes, and a grandtotal  */ 	
    /*  Taxes are normally negative on a PO, to the -1 reverses the sign of the PO product/brokerage taxes.  MiscCharge Taxes not negated. */
    $orderInfo->product_amount = round($orderInfo->chargeable_qty * ($orderInfo->bidInfo->price - $orderInfo->per_item_discount),2);
    
    if($orderInfo->taxes->tax_product) {	
      $orderInfo->po_product_taxes = -1*round($orderInfo->product_amount*$orderInfo->taxes->rate_decimal,2);
      $orderInfo->bol_product_taxes = round($orderInfo->product_amount*$orderInfo->taxes->rate_decimal,2);
    }
    else {
      $orderInfo->po_product_taxes = $orderInfo->bol_product_taxes = 0;
    }

    $orderInfo->po_brokerage_amount = -1*$orderInfo->brokerage;
    $orderInfo->bol_brokerage_amount = $orderInfo->brokerage;
    
    if($orderInfo->taxes->tax_brokerage) {	
      $orderInfo->po_brokerage_taxes = round($orderInfo->po_brokerage_amount*$orderInfo->taxes->rate_decimal,2);	
      $orderInfo->bol_brokerage_taxes = round($orderInfo->bol_brokerage_amount*$orderInfo->taxes->rate_decimal,2);
    }
    else {	
      $orderInfo->po_brokerage_taxes = $orderInfo->bol_brokerage_taxes = 0;	
    }

    /*  this next line will likely change once we add support for misc_charges through the Admin  */
    $orderInfo->misc_charges_taxes = round($orderInfo->misc_charges_amount * $orderInfo->taxes->rate_decimal,2);  			
    
    /*  The misc_charge taxes are always added, since these are charges being tagged to the company (buyer or seller), and are not offset by the HST of the buyer like normal taxes are.   The Misc taxes might be large enough to offset the -ve product/brokerage taxes of a PO and make the PO_taxes seem positive again  */
    $orderInfo->po_total_taxes = round($orderInfo->po_product_taxes + $orderInfo->po_brokerage_taxes + $orderInfo->misc_charges_taxes,2);
    $orderInfo->bol_total_taxes = round($orderInfo->bol_product_taxes + $orderInfo->bol_brokerage_taxes + $orderInfo->misc_charges_taxes,2);

    $orderInfo->po_grand_total = round($orderInfo->product_amount + ($orderInfo->po_brokerage_amount) + $orderInfo->misc_charges_amount + $orderInfo->po_total_taxes,2);
    $orderInfo->bol_grand_total = round($orderInfo->product_amount + $orderInfo->bol_brokerage_amount + $orderInfo->misc_charges_amount + $orderInfo->bol_total_taxes,2);
      
    return $orderInfo;
	}
}
?>
