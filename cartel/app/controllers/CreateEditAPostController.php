<?php
class CreateEditAPostController extends BaseController {
  private $bidPopup;
  private $locale_id;
  private $language_id;

  /**-------------------------------------------------------------------------
   * __construct():
   *                Default constructor
   *-------------------------------------------------------------------------*/
  public function __construct(){
    parent::__construct();
    $this->bidPopup = 0;
    $this->locale_id = $this->pageData['locale_id'];
    $this->language_id = $this->pageData['language_id'];
  }

  /**-------------------------------------------------------------------------
  * index(): shows a list of posts
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
	public function index($listType = '') {
    $start_date = date('Y-m-d');
    $end_date = date('Y-m-d');
    $status_id =  array(54, 55, 58, 79);
    
    $buyProduct = $this->getProductsByBuyOrSell('buy', $start_date, $end_date, $status_id);
    $sellProduct = $this->getProductsByBuyOrSell('sell', $start_date, $end_date, $status_id);

		return View::make('create-edit-a-post.create-edit-a-post')
		    ->with('pageData', $this->pageData)
		    ->with('bidPopup', $this->bidPopup)
		    ->with('buyProduct', $buyProduct)
		    ->with('sellProduct', $sellProduct);
	} // main()

  /**-------------------------------------------------------------------------
  * past():
  *                 
  *--------------------------------------------------------------------------
  *
  * @param  int  $id
  * @return Response
  *-------------------------------------------------------------------------*/
  public function past() {
		$today = date('Y-m-d');
		$start_date = date('Y-m-d', strtotime('-14 days', strtotime($today)));
		$end_date = date('Y-m-d');
		$status_id = array(54, 55, 79);

    /*--------------------------------------------------------------------------*/
		/* Get all of the PAST BUY products belonging to this user`s company. */
		$buyPastProductIDs = Product::getUsersProducts($this->pageData['locale_id'],
                                                 $this->pageData['language_id'],
                                                 Auth::id(),
                                                 'buy',
                                                 $start_date,
                                                 $end_date,
                                                 $status_id);
    
    $buyProduct = $this->getProductsByBuyOrSell('buy', $start_date, $end_date, $status_id);
    $sellProduct = $this->getProductsByBuyOrSell('sell', $start_date, $end_date, $status_id);

		return View::make('create-edit-a-post.create-edit-a-post-past')
      ->with('pageData', $this->pageData)
      ->with('buyPastProduct', $buyProduct)
      ->with('sellPastProduct', $sellProduct);
  }
  /**-------------------------------------------------------------------------
   * favorites():
   *                 
   *--------------------------------------------------------------------------
   *
   * @param  int  $id
   * @return Response
   *-------------------------------------------------------------------------*/
  public function favorites(){
		$today = date('Y-m-d');
		$status_id = array(57);
		$start_date = '2014-01-01';
		$end_date = '2025-01-01';
		
    $buyProduct = $this->getProductsByBuyOrSell('buy', $start_date, $end_date, $status_id);
    $sellProduct = $this->getProductsByBuyOrSell('sell', $start_date, $end_date, $status_id);

		return View::make('create-edit-a-post.create-edit-a-post-favorites')
      ->with('pageData', $this->pageData)
      ->with('buyFavoriteProduct', $buyProduct)
      ->with('sellFavoriteProduct', $sellProduct);
	} // favorites()
     
  /**-------------------------------------------------------------------------
   * getProductsByBuyOrSell():
   *                                   
   *--------------------------------------------------------------------------
   *
   * @param  string 'buy' or 'sell'
   * @return Response
   *-------------------------------------------------------------------------*/
  private function getProductsByBuyOrSell($buyorsell, $start_date, $end_date, 
                                          $status_id)
  {
    
    if($buyorsell != 'buy' && $buyorsell != 'sell')
      throw new MethodNotFoundException("\$buyorsell must be either 'buy' or 'sell'");
      
		/* Get all of the ACTIVE product IDs belonging to this user`s company. */
		$productIDs = Product::getUsersProducts($this->pageData['locale_id'],
                                            $this->pageData['language_id'],
                                            Auth::id(),
                                            $buyorsell,
                                            $start_date,
                                            $end_date,
                                            $status_id);
    
    /* Populate the products array */
		$products = array();
		foreach ($productIDs as $value) {
			$products[$value->id] = Product::getProductInfo($value->id);
		}

    /* Add the product images to the array */
		foreach ($products as &$product) {
      
      /* Get the database object */
      $product_image = Product_image::whereRaw('category_id = ? and colour_id = ?',
        array($product->category_id, $product->colour_id))
        ->first();
      
      /* Get the product image file name */
      $product_image_filename = "";
      if(!is_null($product_image))
        $product_image_filename = $product_image->filename;
        
      $product->product_image_filename = $product_image_filename;
    }
  
    /* Get this smallest bid id */
		foreach ($products as $product) {
			$bidID = $product->active_bid_id;
			if($this->bidPopup == 0 && $bidID > 0)
        $this->bidPopup = $bidID;
			elseif($bidID > 0 && $bidID < $this->bidPopup)
        $this->bidPopup = $bidID;
    }
    
    return $products;
  }// getProductsByBuyOrSell()


  
} // class
?>
