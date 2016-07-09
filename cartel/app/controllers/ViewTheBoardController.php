 <?php
class ViewTheBoardController extends BaseController {

  public function test(){
    return $this->main(true);
  }

  /**-------------------------------------------------------------------------
  * main(): displays the board
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
	public function main() {
    
    /* Check to see if the board should be opened or closed */
    /* - Don't close the board on dev machine */
    if(Config::get('config.boardAlwaysOpen')){
      $currentTime = time();
      $boardOpeningTime =  Configuration::where('cname', '=', 'boardOpeningTime')
                            ->firstOrFail()
                            ->cvalue;
      $boardClosingTime =  Configuration::where('cname', '=', 'boardClosingTime')
                            ->firstOrFail()
                            ->cvalue;
      if ($currentTime <= strtotime($boardOpeningTime) ||
          $currentTime > strtotime($boardClosingTime) 
          //||
          //date('D', $currentTime) == 'Sun')
        )
        return Redirect::to('view-the-board-closed')->with('boardOpeningTime', $boardOpeningTime)->with('boardClosingTime', $boardClosingTime);
    }
    $showModalPopup = 0;
    $bidToViewId = 0;
    /* Get unviewed bids for the current user */
    //$bidToView = Lib::getUnviewedBids($this->userInfo->id);
    //if($bidToView->exists()){
      //$showModalPopup = 1;
      //$bidToViewId = $bidToView->first()->id;
    //}
    //else{
      //$showModalPopup = 0;
      //$bidToViewId = 0;
    //}
    

		/* Get the current users info to pass into the board */
		$userInfo = User::find(Auth::id());

		/* Get all of the BOARD product_types (used for both BUY and SELL) */
		$boardProductTypes =
      Product_Type::getBoardProductTypes($this->pageData['locale_id'],
                                         $this->pageData['language_id'],
                                         32);

		/* Build the array of products */
		$buyProducts = array();
		$sellProducts = array();
		$color = array();


		foreach ($boardProductTypes as $pt_key => $pt_value) {
			/* Get all of the Bid to BUY (Post to Sell) products belong to this
         product_type */
			$buyProductIDs =
        Product::getBoardActiveProducts($this->pageData['locale_id'],
                                        $this->pageData['language_id'],
                                        $pt_value->id,
                                        'sell');
			/* Retrieve product details for each product */
			if(!empty($buyProductIDs)) {
        
				foreach ($buyProductIDs as $key => $value) {
					$buyProducts[$pt_value->jump_link][$value->id] =
            Product::getProductInfo($value->id);
          
          /* Get the product image */
          $product_image = Product_image::whereRaw('category_id = ? and colour_id = ?',
            [ (intval($buyProducts[$pt_value->jump_link][$value->id]->variety_id)),
              (intval($buyProducts[$pt_value->jump_link][$value->id]->colour_id)) ]
          )->first();
          
          /* Get the product image file name */
          $product_image_filename = "";
          if(!is_null($product_image))
            $product_image_filename = $product_image->filename;
            
          $buyProducts[$pt_value->jump_link][$value->id]->product_image_filename =
            $product_image_filename;
        }

				/* Alpha-sort the array based on Product_Name */
				usort($buyProducts[$pt_value->jump_link], function($a, $b) {
				    return strcasecmp( $a->product_name, $b->product_name);
				});
			} 
      else {
				$buyProducts[$pt_value->jump_link] = 0;
			}

			/* Get all of the Bid to SELL (Post to Buy) products belong to this
            product_type */
			$sellProductIDs =
        Product::getBoardActiveProducts($this->pageData['locale_id'],
                                        $this->pageData['language_id'],
                                        $pt_value->id,
                                        'buy');
			if(!empty($sellProductIDs)) {
        
				foreach ($sellProductIDs as $key => $value) {
					$sellProducts[$pt_value->jump_link][$value->id] =
            Product::getProductInfo($value->id);
          
          /* Get the product image */
          if((intval($sellProducts[$pt_value->jump_link][$value->id]->variety_id)) == 0)
          {
            $product_image = Product_image::whereRaw('
              category_id = ? AND
              colour_id = ?',
              array(intval($sellProducts[$pt_value->jump_link][$value->id]->category_id),
                    intval($sellProducts[$pt_value->jump_link][$value->id]->colour_id))
            )->first();
          }
          else
          {
            $product_image = Product_image::whereRaw('category_id = ? and colour_id = ?',
                array(intval($sellProducts[$pt_value->jump_link][$value->id]->variety_id),
                      intval($sellProducts[$pt_value->jump_link][$value->id]->colour_id))
            )->first();
          }
          
          $product_image_filename = "";
          if(!is_null($product_image))
            $product_image_filename = $product_image['filename'];
            
          $sellProducts[$pt_value->jump_link][$value->id]->product_image_filename =
              $product_image_filename;
				}
				/* Alpha-sort the array based on Product_Name */
				usort($sellProducts[$pt_value->jump_link], function($a, $b) {
				    return strcasecmp( $a->product_name, $b->product_name);
				});
			} 
      else {
				$sellProducts[$pt_value->jump_link] = 0;
			}

			/* build the board color parameters */
			$bgcolor[$pt_value->name] = $pt_value->bgcolor;
		}

    return View::make('view-the-board')
			->with('pageData', $this->pageData)
			->with('userInfo', $this->userInfo)
			->with('boardProductTypes', $boardProductTypes)
			->with('buyProducts', $buyProducts)
			->with('sellProducts', $sellProducts)
			->with('showModalPopup', $showModalPopup)
			->with('bidToViewId', $bidToViewId)
			->with('bgcolor', $bgcolor)
			->with('color', $color);
	} // main()

  /**-------------------------------------------------------------------------
  * closed(): displays the closed board
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
	public function closed() {
    $boardOpeningTime =  Configuration::where('cname', '=', 'boardOpeningTime')
                          ->firstOrFail()
                          ->cvalue;
    $boardClosingTime =  Configuration::where('cname', '=', 'boardClosingTime')
                          ->firstOrFail()
                          ->cvalue;
		return View::make('view-the-board-closed')
			->with('boardOpeningTime', $boardClosingTime)
			->with('boardClosingTime', $boardOpeningTime);
	} // closed()

  /**-------------------------------------------------------------------------
  * edit(): displays a page to edit the board settings
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
  public function edit(){
    
    /* Get the db config record */
    $t1db = Configuration::where('cname', '=', 'boardOpeningTime')
      ->firstOrFail()
      ->cvalue;
    $t2db = Configuration::where('cname', '=', 'boardClosingTime')
      ->firstOrFail()
      ->cvalue;
      
    /* Format the config record for the view */
    $t1dt = new DateTime($t1db);
    $t2dt = new DateTime($t2db);
    $t1 = $t1dt->format('h:i A');
    $t2 = $t2dt->format('h:i A');

    /* Pass the config record to the view */
    return View::make('admin.board.edit')
      ->with('t1', $t1)
      ->with('t2', $t2);
  } //edit()
  
  /**-------------------------------------------------------------------------
  * update(): stores new board settings
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
  public function update(){
    $t1 = Input::get('boardopens', 0);
    $t2 = Input::get('boardcloses', 0);

    if(!$t1 || !$t2)
      return Redirect::back()->withErrors("Both times must be specified");

    $t1dt = new DateTime($t1);
    $t2dt = new DateTime($t2);
    
    $t1f = $t1dt->format('H:i:s'); $t2f = $t2dt->format('H:i:s');
    /* Format time for the db */


    /* Update the datbase times */
    $t1db = Configuration::where('cname', '=', 'boardOpeningTime');
    $t2db = Configuration::where('cname', '=', 'boardClosingTime');
    $t1db->update(['cvalue' => $t1f]); 
    $t2db->update(['cvalue' => $t2f]);
    
    /* Format time for the view */
    $t1f = $t1dt->format('h:i A');
    $t2f = $t2dt->format('h:i A');
    return View::make('admin.board.edit')
      ->with('messages', ['Settings Updated', $this->pageData['success']])
      ->with('t1', $t1f)
      ->with('t2', $t2f);
  } // update()
  
} // class
?>
