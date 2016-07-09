<?php
class PostToController extends BaseController {

/**-------------------------------------------------------------------------
 * __construct():
 *                 default constructor
 *-------------------------------------------------------------------------*/
  public function __construct(){
    parent::__construct();
  }
  
  /*-------------------------------------------------------------------------
  * getPostType():
  *                 
  * @return 2D array of information specific to post-to-buy/sell pages.
  *-------------------------------------------------------------------------*/
	public static function getPostType($url = '') {
		if(strpos($url, 'post-to-sell') !== false) {	
      $postType['name']         = 'sell';
			$postType['db_name']      = 'sell';
			$postType['word']         = Lang::get('site_content.post_to_Post_Type_Word_Sell');
			$postType['word_cap']     = Lang::get('site_content.post_to_Post_Type_Word_Cap_Sell');
			$postType['address_type'] = 'Ship';
		}		
		else {	
      $postType['name']         = 'buy';
			$postType['db_name']      = 'buy';
			$postType['word']         = Lang::get('site_content.post_to_Post_Type_Word_B');
			$postType['word_cap']     = Lang::get('site_content.post_to_Post_Type_Word_Cap_Buy');
			$postType['address_type'] = 'Recv';
		}
		return $postType;
	} // getPostType()


  /*-------------------------------------------------------------------------
  * create(): Shows a page to create a post to Buy or Sell
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
	public function create($product_id=0) {

    /* Check if this is a repost */
    $isRepost = Session::get('isRepost', false);
    Session::forget('isRepost');
    
		/* Get Display and selection options */
		$postType = PostToController::getPostType(Request::url());
    
		$formOptions = FormOptions::getAllFormOptions($this->pageData['locale_id'], $this->pageData['language_id']);
    
		/* Uses getShippingAddress in MODEL:Company_Address, returns array */
		$formOptions['shiprecvAddressOptions'] =
      Company_address::getShipRcvAddresses($this->pageData['locale_id'],
                                           $this->pageData['language_id'], 
                                           $this->userInfo->company_id, 
                                           $postType['address_type'], 50);

    /* Means a new product, so setup the form with default values */
		if($product_id == 0) {	
			$form_action = 'post-to-'.$postType['name'].'/'.$product_id.'/store';

      /* Default values for each of the form elements */
      $prod_details = new stdClass();
      $prod_details->id= '';
      $prod_details->postType= $postType['db_name'];
      $prod_details->origin_id= '';
      $prod_details->category_id= '';
      $prod_details->product_type_id= '';
      $prod_details->province_id= '';
      $prod_details->qty= '';
      $prod_details->minqty= '';
      $prod_details->price= '';
      $prod_details->isbulk= '';
      $prod_details->bulk_weight= '';
      $prod_details->bulk_weight_type_id= '';
      $prod_details->bulk_package_id= '';
      $prod_details->carton_pieces= '';
      $prod_details->carton_weight= '';
      $prod_details->carton_weight_type_id= '';
      $prod_details->carton_package_id= '';
      $prod_details->maturity_id= '';
      $prod_details->colour_id= '';
      $prod_details->quality_id= '';
      $prod_details->availability_start= '';
      $prod_details->availability_end= '';
      $prod_details->description= '';
      $prod_details->company_address_id= '';
      $prod_details->varietyOther= '';
		  $prod_details->availability_date = date('M j Y');
		  $prod_details->availability_start = '';
		  $prod_details->availability_end = '';		
    }
    
    elseif (is_numeric($product_id)) {
      $form_action = '/post-to-'.$postType['name'].'/'.$product_id.'/store';

      if(Input::old()) {	
        /* This is a Redirect-back -> withInput, so grab those vars instead of
           pulling from the database */
        $prod_details->origin_id             = Input::old('origin_id', 0);
        $prod_details->province_id           = Input::old('province_id', 0);
        if($prod_details->province_id == '')
          $prod_details->province_id = 0;	
        $prod_details->product_type_id       = Input::old('product_type_id', 0);
        $prod_details->category_id           = Input::old('category_id', 0);
        $prod_details->variety_id            = Input::old('variety_id', 0);
        $prod_details->variety_other         = Input::old('varietyOther', '');
        $prod_details->varietyOther          = Input::old('varietyOther', '');
        $prod_details->qty                   = Input::old('qty', 0);
        $prod_details->price                 = Input::old('price', 0);
        $prod_details->minqty                = Input::old('minqty', 0);
        $prod_details->isbulk                = Input::old('isbulk', 0);
        $prod_details->bulk_weight           = Input::old('bulk_weight',0);
        $prod_details->bulk_weight_type_id   = Input::old('bulk_weight_type_id', 0);
        $prod_details->bulk_package_id       = Input::old('bulk_package_id', 0);
        $prod_details->carton_pieces         = Input::old('carton_pieces', 0); // # of cartons
        $prod_details->carton_weight         = Input::old('carton_weight', 0);
        $prod_details->carton_weight_type_id = Input::old('carton_weight_type_id', 0);
        $prod_details->carton_package_id     = Input::old('carton_package_id', 0);
        $prod_details->maturity_id           = Input::old('maturity_id', 0);
        $prod_details->colour_id             = Input::old('colour_id', 0);
        $prod_details->quality_id            = Input::old('quality_id', 0);
        $prod_details->availability_date     = Input::old('availability_date', 0);
        $prod_details->availability_start    = Input::old('availability_start', 0);
        $prod_details->availability_end      = Input::old('availability_end', 0);
        $prod_details->description           = Input::old('description', 0);
        $prod_details->qty                   = Input::old('qty', 0);
        $prod_details->company_address_id    = Input::old('company_address_id', '');
        $prod_details->other_company         = Input::old('other_company', '');
        $prod_details->other_address         = Input::old('other_address', '');
        $prod_details->other_address2        = Input::old('other_address2', '');
        $prod_details->other_city            = Input::old('other_city', '');
        $prod_details->other_province_id     = Input::old('other_province_id', '');
        $prod_details->other_country_id      = Input::old('other_country_id', '');
        $prod_details->other_postal_code     = Input::old('other_postal_code', '');
      }
      else {
        /* Is an existing product, so retrieve product details for the product */
        $prod_details = Product::getProductInfo($product_id);
        
        /* check to make sure the array isn't empty */
        if (!count($prod_details))  {
          return Redirect::to('/create-edit-a-post')
            ->with('messages',
                array(Lang::get('site_content.post_to_Product_Not_Exist'),
                      $this->pageData['error']));
        }	

        if ($prod_details->active_bid_id) {	
          return Redirect::to('/create-edit-a-post')
            ->with('messages', Lang::get('site_content.post_to_Product_Has_A_Bid'));
        }	

        /* Add in the remaining fields required by the form */
        $prod_details->varietyOther = '';
        if($prod_details->variety_isother == 1) {
          /* I know it's bad form to specify the array key, but it was just so
             much easier!  Odds of hitting 100000 array elements is NIL. --*/
          $formOptions['varietyOptions'][100000] =
            Category::find($prod_details->variety_id);
        }
      }
    }
    else {
      echo "Fail";
    }

    $messages = array(Lang::get('site_content.post_to_Instruction_Message',
                array('type_word_cap'=>$postType['word_cap'])), '');

    return View::make('post-to-'.$postType['name'])
      ->with('pageData', $this->pageData)
      ->with('formOptions', $formOptions)
      ->with('form_action', $form_action)
      ->with('prod_details', $prod_details)
      ->with('messages', $messages)
      ->with('isRepost', $isRepost);
	} // create()
	
  /*-------------------------------------------------------------------------
  * store(): accepts post data to create a new post to buy or sell
  *                 
  * @param  int  $id
  * @return Response
  *-------------------------------------------------------------------------*/
	public function store($product_id = 0) {
		$postType = PostToController::getPostType(Request::url());

    /*----------------------------------------------------*/
		/*  Retrieve POST variables */
    /*----------------------------------------------------*/
		$origin_id             = Input::get('origin_id', 0);
		$province_id           = Input::get('province_id', 0);
		if($province_id == '')
      $province_id         = 0;
		$product_type_id       = Input::get('product_type_id', 0);
		$category_id           = Input::get('category_id', 0);
		$variety_id            = Input::get('variety_id', 0);
		$variety_other         = Input::get('varietyOther', '');
		$qty                   = Input::get('qty', 0);
		$price                 = Input::get('price', 0);
		$minqty                = Input::get('minqty', 0);
		$isbulk                = Input::get('isbulk', 0);
		$bulk_weight           = Input::get('bulk_weight', 0);
		$bulk_weight_type_id   = Input::get('bulk_weight_type_id', 0);
		$bulk_package_id       = Input::get('bulk_package_id', 0);
		$carton_pieces         = Input::get('carton_pieces', 0); // # of cartons
		$carton_weight         = Input::get('carton_weight', 0);
		$carton_weight_type_id = Input::get('carton_weight_type_id', 0);
		$carton_package_id     = Input::get('carton_package_id', 0);
		$maturity_id           = Input::get('maturity_id', 0);
		$colour_id             = Input::get('colour_id', 0);
		$quality_id            = Input::get('quality_id', 0);
		$availability_date     = Input::get('availability_date', 0);
		$availability_start    = Input::get('availability_start', 0);
		$availability_end      = Input::get('availability_end', 0);
		$description           = Input::get('description', 0);
		$company_address_id    = Input::get('company_address_id', '');
		$other_company         = Input::get('other_company', '');
		$other_address         = Input::get('other_address', '');
		$other_address2        = Input::get('other_address2', '');
		$other_city            = Input::get('other_city', '');
		$other_province_id     = Input::get('other_province_id', '');
		$other_country_id      = Input::get('other_country_id', '');
		$other_postal_code     = Input::get('other_postal_code', '');
		$password              = Input::get('password');

	
    /*----------------------------------------------------*/
		/* Check to see if the password is correct */
    /*----------------------------------------------------*/
		$userInfo = User::find(Auth::id());
		if(!(Hash::check($password, $userInfo->password))) {
			$messages = array(Lang::get('site_content.global_Incorrect_Password'),
                        $this->pageData['error']);
			return Redirect::back()
					->withInput(Input::except('password'))
					->with('messages', $messages);
		}
   
    /*----------------------------------------------------*/
    /* Variables to validate */
    /*----------------------------------------------------*/
		$validator_data = array( // data to test
			'origin_id'             => $origin_id,
			'product_type_id'       => $product_type_id,
			'qty'                   => $qty,
			'price'                 => $price,
			'minqty'                => $minqty,
			'isbulk'                => $isbulk,
			'bulk_weight'           => $bulk_weight,
			'bulk_weight_type_id'   => $bulk_weight_type_id,
			'bulk_package_id'       => $bulk_package_id,
			'carton_pieces'         => $carton_pieces,
			'carton_weight'         => $carton_weight,
			'carton_weight_type_id' => $carton_weight_type_id,
			'carton_package_id'     => $carton_package_id,
			'maturity_id'           => $maturity_id,
			'colour_id'             => $colour_id,
			'quality_id'            => $quality_id,
			'availability_date'     => $availability_date,
			'availability_start'    => $availability_start,
			'availability_end'      => $availability_end,
			'description'           => $description,
			'company_address_id'    => $company_address_id,
			'other_company'         => $other_company,
			'other_address'         => $other_address,
			'other_address2'        => $other_address2,
			'other_city'            => $other_city,
			'other_province_id'     => $other_province_id,
			'other_country_id'      => $other_country_id,
			'other_postal_code'     => $other_postal_code
		);

    
    /*----------------------------------------------------*/
    /* Simple validator rules
    /*----------------------------------------------------*/
		$validator_rules = array( 
			'origin_id'          => 'required|integer|min:1',
			'product_type_id'    => 'required|integer|min:1',
			'qty'                => 'required|integer|min:1',
			'price'              => array('required','regex:/^(((0)|([1-9][0-9]*))(\\.[0-9][0-9])?)$/'),
			'minqty'             => 'required|integer|min:1',
			'isbulk'             => 'required|in:0,1',
			'bulk_weight'        => 'required',
			//'bulk_weight_type_id' => 'required|integer|min:1',
			'bulk_package_id'    => 'required|integer|min:1',
			'maturity_id'        => 'required|integer|min:1',
			'colour_id'          => 'required|integer|min:1',
			'quality_id'         => 'required|integer|min:1',
      // TEMP:  Temp commented out - it doesn`t like this date formatting...
      // 'availability_date' => 'required|date_format:M j Y',	// TEMP TEMP
			'availability_start' => 'required|date_format:h:m A',
			'availability_end'   => 'required|date_format:h:m A',
			'company_address_id' => 'required',
			'other_company'      => 'required_if:company_address_id,other',
			'other_address'      => 'required_if:company_address_id,other',
			'other_city'         => 'required_if:company_address_id,other',
      // Not always required (is it?) province doesn't apply for some places
			//'other_province_id' => 'required_if:company_address_id,other', 
			'other_country_id'   => 'required_if:company_address_id,other',
			'other_postal_code'  => 'required_if:company_address_id,other',
		);
      
    /* Add carton rules if bulk is no */
    $carton_rules = [
      'carton_pieces' => array('required','min:0','regex:/^([1-9][0-9]*)$/'),
      'carton_weight' => array('required','min:0',
        'regex:/^(((0)|([1-9][0-9]*))(\\.[0-9][0-9]?[0-9]?[0-9]?[0-9]?)?)$/'),
      'carton_weight_type_id' => 'required|integer|min:1',
      'carton_package_id' => 'required|integer|min:1',
    ];
    if($isbulk == 0)
      array_merge($validator_rules, $carton_rules);
      
      
    /*----------------------------------------------------*/
    /* Province validation 
    /*----------------------------------------------------*/
		$province_origin_id = Province::whereRaw('
      locale_id=? AND
      language_id=? AND 
      status_id=? AND
      origin_id IN
        (select id from origin WHERE 
          locale_id=? AND 
          language_id=? AND
          status_id=?
        )',
      array($this->pageData['locale_id'],
            $this->pageData['language_id'],
            38,
            $this->pageData['locale_id'],
            $this->pageData['language_id'],
            35))
      ->groupby('origin_id')
			->get(array('origin_id'));
      
		foreach ($province_origin_id as $key => $value) {
			if($value->origin_id == $origin_id) {
				$validator_data['province_id'] = $province_id;
				$validator_rules['province_id'] = 'required_if:origin_id,'.$origin_id.'|integer|min:1';
			}
		}

		/* if $variety_id is set, it's a SubCat (has a parent), capture that ONLY.
        Don't need category_id in that case */
		/* if $variety_id was OTHER (==0), then OTHER is required	 */
		if($variety_id != '')		{
			if($variety_id == 0 && $variety_other != '') {	
				$validator_data['variety_other'] = $variety_other;
				$validator_rules['variety_other'] = 'required';
			}
			else {	
				$validator_data['variety_id'] = $variety_id;
				$validator_rules['variety_id'] = 'required|integer|min:1';
			}
		}
		else {	
			$validator_data['category_id'] = $category_id;
			$validator_rules['category_id'] = 'required|integer|min:1';
		}

		/* Validate the post data */
		$validator = Validator::make($validator_data, $validator_rules);

		/* Go back if validation fails */
		if($validator->fails()) {	
			return Redirect::to('post-to-'.$postType['name'])
		  	->withErrors($validator)
				->withInput(Input::except('password'));
		}

		if($product_id == 0) {	
      # means a new product, so establish a new product class to save
			$productToSave = new Product;
			$productToSave->status_id = 55;  // new products get set to Inactive
		}
		elseif (is_numeric($product_id)) {	
      # Is an existing product, so establish product class to update
			$productToSave = Product::find($product_id);
		}

		/* If $origin_id has provinces, then capture $province_id  (select
       count(id) from province where origin_id=$origin_id) */
		$origin_has_provinces = Province::where('origin_id', '=', $origin_id)
			->count();
      
		if($origin_has_provinces > 0 && $province_id != '')
      $productToSave->province_id = $province_id;
		else
      $productToSave->province_id = 0;				

		/*-IF $variety_id is set, it's a SubCat (has a parent), capture that
      ONLY. Don't need category_id in that case
      -IF $variety_id was OTHER (==0), then capture that OTHER DETAIL as a
      dedicated_variety (status=53) */
		if($variety_id != '')		{
			if($variety_id == 0 && $variety_other != '') {	
				$new_dedicated_category = Category::firstOrCreate(array(
					'locale_id' => $this->pageData['locale_id'],
					'language_id' => $this->pageData['language_id'],
					'name' => $variety_other,
					'parent_id' => $category_id,
					'isother' => 1,
					'status_id' => 53,
					'ordernum' => 0,
          )
        );
				$new_dedicated_category->save();
				$productToSave->category_id = $new_dedicated_category->id;
			}
			else {	
        $productToSave->category_id = $variety_id;
      }
		}
		else {	
      $productToSave->category_id = $category_id;
    }

		/* if $isbulk is 0, then capture $carton_pieces, $carton_weight,
        $carton_weight_type_id, $carton_package_id */
		if($isbulk == 0) {	
			$productToSave->carton_pieces = $carton_pieces;
			$productToSave->carton_weight = $carton_weight;
			$productToSave->carton_weight_type_id = $carton_weight_type_id;
			$productToSave->carton_package_id = $carton_package_id;
		}
		else {	
			$productToSave->carton_pieces = 0;
			$productToSave->carton_weight = 0;
			$productToSave->carton_weight_type_id = 0;
			$productToSave->carton_package_id = 0;
		}

		/* Combine $availability_date  with $availability_start/$availability_end
       for timestampe insert */
		$productToSave->availability_end=
        Util::postGenInsertDate($availability_date.$availability_end);
		$productToSave->availability_start=
        Util::postGenInsertDate($availability_date.$availability_start);

		/* if $company_address_id was OTHER, then capture that address and return
       the new company_address->id */
		if($company_address_id == 'other')   {	
			$companyAddressToSave = Company_address::firstOrCreate(array(
				'locale_id'    => $this->pageData['locale_id'],
				'language_id'  => $this->pageData['language_id'],
				'company_id'   => $this->userInfo->company_id,
				'ship_or_recv' => $postType['address_type'],
				'company'      => $other_company,
				'address'      => $other_address,
				'address2'     => $other_address2,
				'city'         => $other_city,
				'postal_code'  => $other_postal_code,
				'province_id'  => $other_province_id,
				'country_id'   => $other_country_id,
				'status_id'    => 50,
			));

			$companyAddressToSave->save();
			$productToSave->company_address_id = $companyAddressToSave->id;
		}
		else {	
			$productToSave->company_address_id = $company_address_id;
		}

		/* Establish the rest of the object variables to prepare for inserting */
		$productToSave->locale_id           = $this->pageData['locale_id'];
		$productToSave->language_id         = $this->pageData['language_id'];
		$productToSave->user_id             = Auth::id();
		$productToSave->post_type           = $postType['db_name'];
		$productToSave->origin_id           = $origin_id;
		$productToSave->product_type_id     = $product_type_id;
		$productToSave->province_id         = $province_id;
		$productToSave->qty                 = $qty;
		$productToSave->price               = $price;
		$productToSave->minqty              = $minqty;
		$productToSave->isbulk              = $isbulk;
		$productToSave->bulk_weight         = $bulk_weight;
		$productToSave->bulk_weight_type_id = $bulk_weight_type_id;
		$productToSave->bulk_package_id     = $bulk_package_id;
		$productToSave->maturity_id         = $maturity_id;
		$productToSave->colour_id           = $colour_id;
		$productToSave->quality_id          = $quality_id;
		$productToSave->description         = $description;
		$productToSave->save();
    
    /* Reponse message color dependant on buy/sell  */
    if($postType['name'] == 'buy')
      $color = $this->pageData['lightGreen'];
    else
      $this->pageData['lightPink'];
      
    /* (peterb) I am intentionally forcing green.  From a usability
       perspective, I disagree with Joe's request to make the message pink when
       Post to Sell as it looks like an error message. Let's discuss before
       changing it back. */
    $color = $this->pageData['lightGreen'];  
    
    /* The BID save was SUCCESSFUL, redirect to Create/Edit a post page.  */
		if($productToSave->id) {	
			$messages = array(Lang::get('site_content.post_to_Successful_Save',
                        array('type_word_cap'=>$postType['word_cap'])), $color);
			return Redirect::to('post-to-'.$postType['name'].'/'.$productToSave->id.'/preview')
				->with('pageData', $this->pageData)
				->with('messages', $messages);
		}
    /* The BID save FAILED, redirect back and try again */
		else {	
			$messages = array(Lang::get('site_content.post_to_Unsuccessful_Save',
                array('type_word_cap'=>$postType['word_cap'])), $color);
			return Redirect::back()
				->withInput(Input::except('password'))
				->with('pageData', $this->pageData)
				->with('messages', $messages);
		}
	} // store()
	
	/*-------------------------------------------------------------------------
	* preview():  preivew a post-to-buy-sell after editing it.
  *
	* @return Response
	*-------------------------------------------------------------------------*/
	public function preview($product_id) {
		$postType = PostToController::getPostType(Request::url());
		
    $prod_details = Product::getProductInfo($product_id);

    /* check to make sure the array isn't empty */
    if (!count($prod_details))
      return Redirect::to('/create-edit-a-post')
        ->with('messages', 
                array(Lang::get('site_content.post_to_Product_Not_Exist'),
                      $this->pageData['error']));

    if ($prod_details->active_bid_id)
      return Redirect::to('/create-edit-a-post')
        ->with('messages', Lang::get('site_content.post_to_Product_Has_A_Bid'));

    /* Add in the remaining fields required by the form */
    $prod_details->varietyOther='';

    $messages = array(Lang::get('site_content.post_to_preview_Instruction_Message',
                      array('type_word_cap'=>$postType['word_cap'])), '');

    $addressInfo = Company_address::getOneShippingAddress($prod_details->company_address_id);
      
    $prod_details->other_company     = $addressInfo->company;
    $prod_details->other_address     = $addressInfo->address;
    $prod_details->other_address2    = $addressInfo->address2;
    $prod_details->other_city        = $addressInfo->city;
    $prod_details->other_province_id = $addressInfo->province_id;
    $prod_details->other_country_id  = $addressInfo->country_id;
    $prod_details->other_postal_code = $addressInfo->postal_code;

    $response_page = 'post-to-'.$postType['name'].'-preview';
    return View::make($response_page)
      ->with('pageData', $this->pageData)
      ->with('prod_details', $prod_details)
      ->with('messages', $messages);
  } // preview()

  /*-------------------------------------------------------------------------
  * commit():  commit to a post-to-buy-sell after previewing it.
  *
  * @return Response
  *-------------------------------------------------------------------------*/
  public function commit($product_id) {
		$postType = PostToController::getPostType(Request::url());

		/*  protect against invalid IDs */
		App::error(function(ModelNotFoundException $e) {	
			return Redirect::to('/create-edit-a-post')
				->with('messages',
          array(Lang::get('site_content.post_to_Product_Not_Exist'),
                $this->pageData['error']));
		});

		/* We don't actually delete the product - we keep it in the db with a
       deleted status code assigned to it, to protect data integrety */
		$productToDelete = Product::findOrFail($product_id);
		$productToDelete->status_id=54;
		$productToDelete->save();

		$messages = array(Lang::get('site_content.post_to_Successful_Save',
                    array('type_word_cap'=>$postType['word_cap'])),
                          $this->pageData['success']);
		return Redirect::to('/create-edit-a-post')
      ->with('messages', $messages);
  } // commit()

  /*-------------------------------------------------------------------------
  * destroy(): deletes a post given it's ID
  *
  * @return Redirect
  *-------------------------------------------------------------------------*/
	public function destroy($product_id) { 	
		/* protect against invalid IDs */
		App::error(function(ModelNotFoundException $e) {	
			return Redirect::to('/create-edit-a-post')
				->with('messages',
            array(Lang::get('site_content.post_to_Product_Not_Exist'),
                  $this->pageData['error']));
		});

		/* We don't actually delete the product - we keep it in the db with a
       deleted status code assigned to it, to protect data integrety */
		$productToDelete = Product::findOrFail($product_id);
		$productToDelete->status_id = 56;
		$productToDelete->save();

		return Redirect::to('/create-edit-a-post')
			->with('messages', Lang::get('site_content.post_to_Successful_Delete'));		
	} // destroy()

  /*-------------------------------------------------------------------------
  * favorite(): Creates a Favorite post by replicating a current item, given it's ID
  *
  * @return Redirect
  *-------------------------------------------------------------------------*/
	public function favorite($product_id) { 	
		/* protect against invalid IDs */
		App::error(function(ModelNotFoundException $e) {	
      return Redirect::to('/create-edit-a-post')
				->with('messages',
            array(Lang::get('site_content.post_to_Product_Not_Exist'),
                  $this->pageData['error']));
		});
		/* Duplicate the product, and mark it as a Favorite (Status_id=57) */
		$productToFavorite = Product::findOrFail($product_id)->replicate();
		$productToFavorite->save();
		$productToFavorite->status_id = 57;
		$productToFavorite->save();
		return Redirect::to('/create-edit-a-post')
			->with('messages', Lang::get('site_content.post_to_Successful_Favorite'));		
	} // favorite()


  /*-------------------------------------------------------------------------
  * repost(): Creates a NEW post by replicating a current item, given it's ID
  *                 
  * @return Redirect to Post To XX page
  *-------------------------------------------------------------------------*/
	public function repost($product_id) { 	
		/* protect against invalid IDs */
		App::error(function(ModelNotFoundException $e) {	
			return Redirect::to('/create-edit-a-post')
				->with('messages',
                array(Lang::get('site_content.post_to_Product_Not_Exist'),
                      $this->pageData['error']));
		});

		/* Duplicate the product, and mark it as Pending Repost (Status_id=58) */
		/* They are then redirected to the Edit page where they'll edit the Status
    /*   to View: Yes/No (Status_id=54/55) */
		/* This prevents mid-step products and accidently click "reposts" from
       showing anywhere on the site */
		$productToCopy = Product::findOrFail($product_id)->replicate();
		$productToCopy->save();    
		$productToCopy->status_id = 58;
		$productToCopy->save();
    
    $isRepost = true; // Store in the session that this is a repost

    /* This should not be a redirect but rather an autofilled create */
		return Redirect::intended('/post-to-'.$productToCopy['post_type'].'/'.$productToCopy['id'].'/edit')
			->with('messages', Lang::get('site_content.post_to_Successful_Repost'))
      ->with('isRepost', $isRepost);		
	} // repost()
  
  
  /*-------------------------------------------------------------------------
  * counterRepost(): Reposts a bid-to-sell (from a post-to-buy) as a
  *               post-to-sell and vice versa
  *                 
  * @return Redirect to Post To XX page
  *-------------------------------------------------------------------------*/
	public function counterRepost($product_id) { 	
		$postType = PostToController::getPostType(Request::url());
    
		/* protect against invalid IDs */
		App::error(function(ModelNotFoundException $e) {	
			return Redirect::to('/create-edit-a-post')
				->with('messages',
            array(Lang::get('site_content.post_to_Product_Not_Exist'),
                  $this->pageData['error']));
		});

		/* Duplicate the product, and mark it as Pending Repost (Status_id=58) */
		/* They are then redirected to the Edit page where they'll edit the Status
    /*  to View: Yes/No (Status_id=54/55) */
		/* This prevents mid-step products and accidently click "reposts" from showing anywhere on the site */
		$productToCopy = Product::findOrFail($product_id)->replicate();
		$productToCopy->status_id = 58;
    $productToCopy->post_type = $postType["name"];
    $productToCopy->save();
    return Redirect::to('/post-to-'.$postType["name"].'/'.$productToCopy->id.'/edit')
      ->with('messages', Lang::get('site_content.post_to_Successful_Repost'));		
	} // counterRepost()
} // class

?>
