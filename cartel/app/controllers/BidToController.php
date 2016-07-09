<?php
class BidToController extends BaseController {

  /**-------------------------------------------------------------------------
  * getBidType(): stores page-specific data for bid-to-sell and bid-to-buy
  *                 
  * @return 2D array of information specific to bid-to-buy/sell pages.
  *-------------------------------------------------------------------------*/
	public function getBidType($url = '') {
		if(strpos($url, 'bid-to-sell') !== false) {	
      $bidType['name']         = 'sell';
			$bidType['db_name']      = 'sell';
			$bidType['word']         = Lang::get('site_content.post_to_Post_Type_Word_Sell');
			$bidType['word_cap']     = Lang::get('site_content.post_to_Post_Type_Word_Cap_Sell');
			$bidType['address_type'] = 'Ship';
		}		
		else {	
      $bidType['name']         = 'buy';
			$bidType['db_name']      = 'buy';
			$bidType['word']         = Lang::get('site_content.post_to_Post_Type_Word_B');
			$bidType['word_cap']     = Lang::get('site_content.post_to_Post_Type_Word_Cap_Buy');
			$bidType['address_type'] = 'Recv';
		}
		return $bidType;
	} // getBidType()


  /**-------------------------------------------------------------------------
  * create(): opens a page to create a bid-to-buy/sell for a particular post
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
	public function create($product_id = 0, $bid_id = 0) {

		/* Get Display and selection options */
		/*--------------------------------------------------------------------*/
		$bidType = BidToController::getBidType(Request::url());
		$formOptions = FormOptions::getAllFormOptions($this->pageData['locale_id'], $this->pageData['language_id']);		

		/* Uses getShippingAddress in MODEL:Company_Address, returns array */
		$formOptions['shiprecvAddressOptions'] =
      Company_address::getShipRcvAddresses(
        $this->pageData['locale_id'], 
        $this->pageData['language_id'], 
        $this->userInfo->company_id, 
        $bidType['address_type'],
        50);

		$form_action = '/bid-to-'.$bidType['name'].'/'.$bid_id.'/store';

		/* Get the details of the currently posted product to pre-populate the Bid
       form */
		$prod_details = Product::getProductInfo($product_id);
    
    /* Get the product image */
    $product_image = Product_image::whereRaw('category_id = ? and colour_id = ?',
      [ ($prod_details->variety_id),
        ($prod_details->colour_id) ]
    )->first();
    
    /* Get the product image file name */
    $product_image_filename = "";
    if(!is_null($product_image))
      $product_image_filename = $product_image->filename;
      
    /* check to make sure the array isn't empty  */
		if(!count($prod_details))  {	
      return Redirect::to('/view-the-board')
				->with('messages',
          array(Lang::get('site_content.post_to_Product_Not_Exist'),
                $this->pageData['error']));
		}				

		/* Product has an active bid already */
		if($prod_details->active_bid_id) {	
      return Redirect::to('/view-the-board')
				->with('messages',
          array(Lang::get('site_content.bid_to_Product_Has_A_Bid'),
                $this->pageData['error']));
		}	

		/* add in the remaining fields required by the form */		
		$prod_details->varietyOther = '';
		if($prod_details->variety_isother == 1) {
			/* I know it's bad form to specify the array key, but it was just so
         much easier!  Odds of hitting 100000 array elements is NIL. --*/
			$formOptions['varietyOptions'][100000] =
        Category::find($prod_details->variety_id);
		}

		if(Input::old()) {	
      /* this is a Redirect-back -> withInput, so grab those vars and
          over-write what was coming from the database */
			$prod_details->qty = Input::old('qty', 0);
			$prod_details->company_address_id = Input::old('company_address_id', '');
		}

		$messages = array("Below are the details of a product that a member wishes
                       to <B>SELL</B>. Enter the Qty you would like to
                       <B>BUY</B>, the receiving address, and then your
                       password to place your bid. <br><br> Roll your mouse
                       over a <i class='fa fa-times' style='color:
                       #a94442;'></i> to see its error message.",
                       '');

		return View::make('bid-to-'.$bidType['db_name'])
			->with('pageData', $this->pageData)
      ->with('formOptions', $formOptions)
			->with('form_action', $form_action)
			->with('prod_details', $prod_details)
      ->with('product_image_filename', $product_image_filename)
			->with('messages', $messages);
	} // create()

  /**-------------------------------------------------------------------------
  * store(): accepts post data to create a new bid to buy or sell
  *
  * @param  int  $id
  * @return Response
  *-------------------------------------------------------------------------*/
	public function store($bid_id = 0) {
		$bidType = BidToController::getBidType(Request::url());

		/* Retrieve the common submitted variables */
		$product_id         = Input::get('product_id', 0);
		$password           = Input::get('password');
		$qty                = Input::get('qty', 0);
		$price              = Input::get('price', 0);
		$company_address_id = Input::get('company_address_id', '');
		$other_company      = Input::get('other_company', '');
		$other_address      = Input::get('other_address', '');
		$other_address2     = Input::get('other_address2', '');
		$other_city         = Input::get('other_city', '');
		$other_province_id  = Input::get('other_province_id', '');
		$other_country_id   = Input::get('other_country_id', '');
		$other_postal_code  = Input::get('other_postal_code', '');
		$status_id = '59';

		$bid_check = Product::getProductInfo($product_id);
		$product_owner_id = $bid_check->user_id;
		if($bid_check->active_bid_id) {	
      return Redirect::to('/view-the-board')
				->with('messages',
          array(Lang::get('site_content.bid_to_Product_Has_A_Bid'),
                $this->pageData['error']));
		}

		/* User can't bid on a product from their own company */
		if($bid_check->user_company_id == $this->userInfo->company_id) {	
      return Redirect::back()
				->with('messages',
          array(Lang::get('site_content.bid_to_Product_Is_Own'),
                $this->pageData['error']));
		}
		unset($bid_check);

		/* Check to see if the password is correct */
		$userInfo = User::find(Auth::id());
    /* correct password */
		if(!(Hash::check($password, $userInfo->password))) {
			$msg = Lang::get('site_content.global_Incorrect_Password');
			return Redirect::back()
				->withInput(Input::except('password'))
				->withErrors($msg);
		}

    /* Get the details of the currently posted product to pre-populate the Bid
        form */
    $prod_details = Product::getProductInfo($product_id);
    
    /* check to make sure the array isn't empty  */
    if (!count($prod_details))  {	
      return Redirect::to('/view-the-board')
        ->with('messages',
              array(Lang::get('site_content.post_to_Product_Not_Exist'),
                    $this->pageData['error']));
    }				

    /* Establish bidToSave variables from retrieved Product info */
    $origin_id             = $prod_details->origin_id;
    $province_id           = $prod_details->province_id;
    $product_type_id       = $prod_details->product_type_id;
    $category_id           = $prod_details->category_id;
    $variety_id            = $prod_details->variety_id;
    $isbulk                = $prod_details->isbulk;
    $bulk_weight           = $prod_details->bulk_weight;
    $bulk_weight_type_id   = $prod_details->bulk_weight_type_id;
    $bulk_package_id       = $prod_details->bulk_package_id;
    $carton_pieces         = $prod_details->carton_pieces;
    $carton_weight         = $prod_details->carton_weight;
    $carton_weight_type_id = $prod_details->carton_weight_type_id;
    $carton_package_id     = $prod_details->carton_package_id;
    $maturity_id           = $prod_details->maturity_id;
    $colour_id             = $prod_details->colour_id;
    $quality_id            = $prod_details->quality_id;
    
    $availability_date = 
      $prod_details->availability_date = 
        date('M j Y', strtotime($prod_details->availability_start));
        
    $availability_start = 
      $prod_details->availability_start =
        date('g:00 A', strtotime($prod_details->availability_start));
        
    $availability_end = 
      $prod_details->availability_end =
        date('g:00 A', strtotime($prod_details->availability_end));
    /* description should not be copied from the original product */
    $description = ''; 

    /* Build the array that supports validating the bid data */
    $validator_data = array( // data to test
      'qty'                => $qty,
      'price'              => $price,
      'company_address_id' => $company_address_id,
      'other_company'      => $other_company,
      'other_address2'     => $other_address2,
      'other_city'         => $other_city,
      'other_province_id'  => $other_province_id,
      'other_country_id'   => $other_country_id,
      'other_postal_code'  => $other_postal_code
    );

    $validator_rules = array( // rules
      'qty'                => 'required|integer|min:1',
      'price'              => array('required','regex:/^(((0)|([1-9][0-9]*))(\\.[0-9][0-9])?)$/'),
      'company_address_id' => 'required',
      'other_company'      => 'required_if:company_address_id,other',
      'other_address'      => 'required_if:company_address_id,other',
      'other_address2'     => 'required_if:company_address_id,other',
      'other_city'         => 'required_if:company_address_id,other',
      'other_province_id'  => 'required_if:company_address_id,other',
      'other_country_id'   => 'required_if:company_address_id,other',
      'other_postal_code'  => 'required_if:company_address_id,other',
    );


		/* Validate the post data */
		$validator = Validator::make($validator_data, $validator_rules);			

		/* Go back if validation fails */
		if($validator->fails()) {	
			return Redirect::back()
				->withErrors($validator)
				->withInput(Input::except('password'));
		}
	
    /* means a new bid, so establish a new product class to save */		
		if($bid_id == 0) {	
			$bidToSave = new Bid;
		}
    /* Is an existing bid, so establish product class to update */
		elseif(is_numeric($bid_id)) {	
			$bidToSave = Bid::find($bid_id);
		}

		/* If $origin_id has provinces, then capture $province_id  (select
       count(id) from province where origin_id=$origin_id)*/
		$origin_has_provinces = Province::where('origin_id', '=', $origin_id)
			->count();
      
		if($origin_has_provinces > 0 && $province_id != '') {	
      $bidToSave->province_id = $province_id;
    }
		else {	
      $bidToSave->province_id = 0;
    }

		/* if $variety_id is set, it's a SubCat (has a parent), capture that ONLY.
       Don't need category_id in that case */
		/* if $variety_id was OTHER (==0), then capture that OTHER DETAIL as a
       dedicated_variety (status=53) */
		if($variety_id != '')		{
			if($variety_id == 0 && $variety_other != '') {	
				$new_dedicated_category = Category::firstOrCreate(array(
					'locale_id'   => $this->pageData['locale_id'],
					'language_id' => $this->pageData['language_id'],
					'name'        => $variety_other,
					'parent_id'   => $category_id,
					'isother'     => 1,
					'status_id'   => 53,
					'ordernum'    => 0,
				));
				$new_dedicated_category->save();
				$bidToSave->category_id = $new_dedicated_category->id;
			}
			else {	
        $bidToSave->category_id = $variety_id;
      }
		}
		else {	
      $bidToSave->category_id = $category_id;
    }


		/* if $isbulk is 0, then capture $carton_pieces, $carton_weight,
       $carton_weight_type_id, $carton_package_id */
		if($isbulk == 0 &&
       $carton_pieces != '' && 
       $carton_weight != '' && 
       $carton_weight_type_id != '' && 
       $carton_package_id != '') 
    {	
			$bidToSave->carton_pieces         = $carton_pieces;
			$bidToSave->carton_weight         = $carton_weight;
			$bidToSave->carton_weight_type_id = $carton_weight_type_id;
			$bidToSave->carton_package_id     = $carton_package_id;
		}
		else {	
			$bidToSave->carton_pieces         = 0;
			$bidToSave->carton_weight         = 0;
			$bidToSave->carton_weight_type_id = 0;
			$bidToSave->carton_package_id     = 0;
		}

		/* Combine $availability_date  with $availability_start/$availability_end
       for timestampe insert */
		$bidToSave->availability_start =
      Util::postGenInsertDate($availability_date.$availability_start);
		$bidToSave->availability_end =
      Util::postGenInsertDate($availability_date.$availability_end);

		/* if $company_address_id was OTHER, then capture that address and return
       the new company_address->id */
		if($company_address_id == 'other') {	
			$companyAddressToSave = Company_address::firstOrCreate(array(
				'locale_id'    => $this->pageData['locale_id'],
				'language_id'  => $this->pageData['language_id'],
				'company_id'   => $this->userInfo->company_id,
				'ship_or_recv' => $bidType['address_type'],
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
			$bidToSave->company_address_id = $companyAddressToSave->id;
		}
		else {	
			$bidToSave->company_address_id = $company_address_id;
		}

		/* Establish the rest of the object variables to prepare for inserting */
		$bidToSave->locale_id             = $this->pageData['locale_id'];
		$bidToSave->language_id           = $this->pageData['language_id'];
		$bidToSave->user_id               = Auth::id();
		$bidToSave->bid_type              = $bidType['db_name'];
		$bidToSave->product_id            = $product_id;
		$bidToSave->origin_id             = $origin_id;
		$bidToSave->product_type_id       = $product_type_id;
		$bidToSave->province_id           = $province_id;
		$bidToSave->qty                   = $qty;
		$bidToSave->price                 = $price;
		$bidToSave->isbulk                = $isbulk;
		$bidToSave->bulk_weight           = $bulk_weight;
		$bidToSave->bulk_weight_type_id   = $bulk_weight_type_id;
		$bidToSave->bulk_package_id       = $bulk_package_id;
		$bidToSave->carton_pieces         = $carton_pieces;
		$bidToSave->carton_weight         = $carton_weight;
		$bidToSave->carton_weight_type_id = $carton_weight_type_id;
		$bidToSave->carton_package_id     = $carton_package_id;
		$bidToSave->maturity_id           = $maturity_id;
		$bidToSave->colour_id             = $colour_id;
		$bidToSave->quality_id            = $quality_id;
		$bidToSave->description           = $description;
		$bidToSave->status_id             = $status_id;
		$bidToSave->save();

    /* Reponse message color is now dependant on buy/sell, not success/error  */
    $color = $bidType['name'] == 'buy' ? 
             $this->pageData['lightGreen'] : 
             $this->pageData['lightPink'];
    
    /* The BID save was SUCCESSFUL, redirect to Create/Edit a post page.  */
		if($bidToSave->id) {	

			/* get details of the product owner */
			$productOwnerInfo = User::getUserInfo($product_owner_id);

			/* By adding these vars to the viewData array, their details will be
         accessble in the email.view */
			$emailData['pageData']         = array($this->pageData);
			$emailData['productOwnerInfo'] = array($productOwnerInfo);
			$emailData['bidType']          = array($bidType);
			$emailData['bidInfo']          = Util::objectToArray($bidToSave);

			/* if PRETEND is set, then display the email content instead */			
			if(Config::get('mail.pretend')) {
				//echo "<HR>Mail is on Pretend.... so click to advance<A HREF='/create-edit-a-post'>/create-edit-a-post</A><HR>";
				//return View::make('emails.bid-to-email')
					//->with('emailData', $emailData);
			}

			/* email addresses - repeat additional 'toEmail' lines as needed */
			$toEmail = array(
                      array('email' => $productOwnerInfo->email, 
                            'name' => $productOwnerInfo->name)
                    );

      /* companyEmail */
			$fromEmail[0] = (array('email' => $this->pageData['companyEmail'],
                           'name' => $this->pageData['companyName']));
			$subject = $this->pageData['companyName'].' - Product Bid';
			$attachments = array();  //$message->attach($pathToFile);

			/* the $pageData and $userInfo are base as parameters to the mail tag so
         that */
			Mail::send('emails.bid-to-email', 
                 $emailData, 
                 function($message) use ($toEmail, 
                                         $fromEmail, 
                                         $subject,
                                         $attachments) {
				foreach($toEmail as $key => $value) {	
          $message->to($value['email'], $value['name']);
        }
				foreach($fromEmail as $key => $value) {
          $message->from($value['email'], $value['name']);
        }
				$message->subject($subject);
			});

			$messages = array(Lang::get('site_content.post_to_Successful_Save',
        array('type_word_cap' => $bidType['word_cap'])),
              $color);
			return Redirect::to('/view-the-board')
				->with('pageData', $this->pageData)
				->with('messages', $messages);
		}
    /* The BID save FAILED, redirect back and try again */
		else {	
			$messages = array(Lang::get('site_content.post_to_Unsuccessful_Save',
                      array('type_word_cap' => $bidType['word_cap'])));
			return Redirect::back()
				->withInput(Input::except('password'))
				->with('pageData', $this->pageData)
				->withErrors($messages);
		}
	} // store()
} // class
?>
