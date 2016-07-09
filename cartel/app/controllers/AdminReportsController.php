<?php

class AdminReportsController extends \BaseController {
	/** -----------------------------------------------------------------------
	* completedTransactions(): 
  *                           Display a listing of the resource.
	*
	* @return Response
	-------------------------------------------------------------------------*/
	public function completedTransactions() {
    
    /* Get all active orders */
    $orderIDList = DB::table('order')->whereRaw
      ("locale_id=1 AND
       (status_id IN (63,72,73) OR 
        receivable_status_id IN (65) OR 
        payable_status_id IN (67))
       ORDER BY accounting_number")->get(['id']);

    /* Initialize List of orders */
    $items = array();

    /* Retrieve details for each item */
    foreach ($orderIDList as $orderID) {
      $items[$orderID->id] = Order::getOrderInfo($orderID->id);
      $items[$orderID->id]->date_color = '';

      /* If date is today */
      if (date('Y-m-d', strtotime($items[$orderID->id]->created_at)) ==
          date('Y-m-d', time())) {
        $items[$orderID->id]->date_color = $this->pageData['darkGreen'];
      }
      /* If date is within past week */ 
      elseif (date('Y-m-d', strtotime($items[$orderID->id]->created_at)) >=
          date('Y-m-d', strtotime('-1 week', time())) &&
          date('Y-m-d', strtotime($items[$orderID->id]->created_at)) <
          date('Y-m-d', time())) {
        $items[$orderID->id]->date_color = $this->pageData['lightGreen'];
      }
    }

    return View::make('admin-reports-completed-transactions')
      ->with('pageData', $this->pageData)
      ->with('items', $items);
  }


  /** -----------------------------------------------------------------------
   *getTopCompanies(): 
   *                Gets the top companies given a timeframe in past days
   *
   * @return Response
   ------------------------------------------------------------------------- */
  public static function getTopCompanies($days){
    /* Start date and end date */
    $start_day = date('Y-m-d', strtotime( '-'.$days.' day', time()));
    $end_day = date('Y-m-d', time());
    $start_date = $start_day.' 00:00:00 ';
    $end_date = $end_day.' 00:00:00';
    
    $result = DB::select(DB::raw("		
    SELECT BuyerCompany.id as buyer_id,
           BuyerCompany.name as buyer_name, 
           SellerCompany.id as seller_id, 
           SellerCompany.name as seller_name,
           Orders.brokerage
    FROM `order` Orders
    
    INNER JOIN bid Bid
    on Bid.id = Orders.bid_id

    # Buyer 
    #----------------------------------
    INNER JOIN user Buyer
    ON Bid.user_id = Buyer.id
    
    INNER JOIN company BuyerCompany
    ON Buyer.company_id = BuyerCompany.id

    
    # Seller 
    #----------------------------------
    INNER JOIN product Product
    ON Bid.product_id = Product.id
    
    INNER JOIN user Seller
    ON Product.user_id = Seller.id
    
    INNER JOIN company SellerCompany
    ON Seller.company_id = SellerCompany.id
    
    # Date filter 
    #----------------------------------
    WHERE 
    Orders.created_at BETWEEN ? AND ?
    ORDER BY
    Orders.brokerage
    DESC;
    "), array($start_date, $end_date));
    
    if(empty($result))
      $result = array();
      
    $companies = array();
    foreach($result as $key => $value){
      /* Add the company to the list if it doesn't exist */
      if(!isset($companies[$value->buyer_id])) {
        $companies[$value->buyer_id] = array();
        $companies[$value->buyer_id]['name'] = $value->buyer_name;
        $companies[$value->buyer_id]['brokerage'] = 0;
      }
      if(!isset($companies[$value->seller_id])){
        $companies[$value->seller_id] = array();
        $companies[$value->seller_id]['name'] = $value->seller_name;
        $companies[$value->seller_id]['brokerage'] = 0;
      }
      $companies[$value->seller_id]['brokerage'] += $value->brokerage;
      $companies[$value->buyer_id]['brokerage'] += $value->brokerage;
    }
    return $companies;
  }
  /** -----------------------------------------------------------------------
   *topCompanies(): 
   *                Shows a page of the top companies
   *
   * @return Response
   ------------------------------------------------------------------------- */
  public function topCompanies($days) {
    
    $monthly_results = $this->getTopCompanies(30);
    $yearly_results = $this->getTopCompanies(365);
    
    return View::make('admin.top-companies.index')
      ->with('monthly_results', $monthly_results)
      ->with('yearly_results', $yearly_results)
      ->with('days', $days);
  }
  
	/** -----------------------------------------------------------------------
	*  customerHistory():
  *                     Shows a page of customer history.
	*
	* @return Response
	-------------------------------------------------------------------------*/
	public function customerHistory() {
		/* Get the list of IDs */
		$formOptions['start_date'] = Input::get('start_date',
                                          date('Y-m-d',
                                               strtotime( '-1 month', time()))
                                          );
		$formOptions['end_date'] = Input::get('end_date', date('Y-m-d'));

		$bidList = Bid::getRecentBids($this->pageData['locale_id'],
                                  $this->pageData['language_id'],
                                  $formOptions['start_date'],
                                  $formOptions['end_date']);

    return View::make('admin-reports-customer-history')
			->with('pageData', $this->pageData)
			->with('formOptions', $formOptions)
      ->with('bidList', $bidList);
  } // index()
  
  
	/** -----------------------------------------------------------------------
	* recentBids():
  *               Shows a page of the most recent bids
	*
	* @return Response
	-------------------------------------------------------------------------*/
	public function recentBids() {
		/* Get the list of IDs */
		$formOptions['start_date'] = Input::get('start_date',
                                            date('Y-m-d',
                                            strtotime( '-1 month', time())));
		$formOptions['end_date'] = Input::get('end_date', date('Y-m-d'));

		$bidList=Bid::getRecentBids($this->pageData['locale_id'],
                                $formOptions['start_date'],
                                $formOptions['end_date']);

    return View::make('admin-reports-recent-bids')
			->with('pageData', $this->pageData)
			->with('formOptions', $formOptions)
      ->with('bidList', $bidList);
  }
} // class
