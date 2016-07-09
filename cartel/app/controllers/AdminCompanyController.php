<?php
class AdminCompanyController extends \BaseController {

  public $adminVars;
  
  /*------------------------------------------------------------------------*/
  /* __construct(): default constructor */
  /*------------------------------------------------------------------------*/
  public function __construct() {
    parent::__construct();
		$this->adminVars['adminWord']      = 'company';
		$this->adminVars['adminWords']     = 'companies';
		$this->adminVars['adminWordCap']   = 'Company';
		$this->adminVars['adminClassType'] = 'Company';
		$this->adminVars['adminURI']       = 'admin-company';
		$this->adminVars['adminActiveID']  = '13';
		$this->adminVars['adminDeleteID']  = '15';
	}	// __construct()
	
  
	/** -----------------------------------------------------------------------
	* index(): 
  *           Display a listing of the resource.
	*
	* @return Response
	-------------------------------------------------------------------------*/
	public function index() {
		/* Get the list of user ids belonging to the company */
		$itemIDs = Company::getNestedItems($this->pageData['locale_id'],
                                      $this->pageData['language_id'], 0);
		$items = array();

		/* Retrieve details for each item */
    foreach ($itemIDs as $key => $value) {
      $items[$value->id] = Company::getCompanyInfo($value->id);

      foreach ($value->sub as $subkey => $subvalue) {
        $items[$value->id]->sub[$subkey] = User::getUserInfo($subvalue->id);		
      };
    }
    
    return View::make($this->adminVars['adminURI'])
			->with('pageData', $this->pageData)
			->with('view', 'index')
			->with('adminVars', $this->adminVars)
      ->with('items', $items);
  } // index()
  

	/** -----------------------------------------------------------------------
	* edit(): 
  *          Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	-------------------------------------------------------------------------*/
	public function edit($item_id = 0) {
		/* Build arrays used to build the form options */
		$formOptions['statusOptions'] = Status::whereRaw("
      filter = ? AND
      active = ?",
      array($this->adminVars['adminClassType'], 1))
			->orderBy('ordernum')
			->get(array('id', 'name'));

		$formOptions['provinceOptions'] = Province::whereRaw("
      locale_id = ? AND 
      language_id = ? AND 
      status_id = ? AND 
      country_id != ?",
      array($this->pageData['locale_id'], $this->pageData['language_id'], 38, 0))
			->groupBy('country_id', 'name')
			->get(array('country_id', 'id', 'name'));

		$formOptions['countryOptions'] = Country::whereRaw("
      locale_id = ? AND
      language_id = ? AND
      status_id = ?",
      array($this->pageData['locale_id'], $this->pageData['language_id'], 41))
			->orderBy('name')
			->get(array('id', 'name'));			

		$formOptions['companyTypeOptions'] = Company_type::whereRaw("
      locale_id = ? AND
      language_id = ? AND
      status_id = ?",
      array($this->pageData['locale_id'], $this->pageData['language_id'], 80))
			->orderBy('name')
			->get(array('id', 'name'));			
      
    /* means a new item, so setup the form with default values */		
		if($item_id == 0) {	
			$details = new stdClass();
			$details->id = '0';
			$details->name = '';
			$details->address = '';
			$details->address2 = '';
			$details->city = '';
			$details->postal_code = '';
			$details->province_id = '2';
			$details->country_id = '1';
			$details->default_email = '';
			$details->website = '';
			$details->phone = '';
			$details->fax = '';
			$details->status_id = $this->adminVars['adminActiveID'];
			$details->message = '';
			$details->credit_limit = '';
			$details->credit_limit_exp = '';
			$details->ap_email = '';
			$details->ar_email = '';
			$details->shipping_email = '';
			$details->receiving_email = '';
			$details->logistics_email = '';
			$details->internal_notes = '';
			$details->payable_notes = '';
			$details->company_type_id = '';
		}
		elseif(is_numeric($item_id)) {	
      /* this is a Redirect-back -> withInput, so grab those vars instead of
         pulling from the database */
			if(Input::old()) {	
				$details->id               = $item_id;
				$details->name             = Input::old('name', '');
				$details->address          = Input::old('address', '');
				$details->address2         = Input::old('address2', '');
				$details->city             = Input::old('city', '');
				$details->postal_code      = Input::old('postal_code', '');
				$details->province_id      = Input::old('province_id', 0);
				$details->country_id       = Input::old('country_id', 0);
				$details->default_email    = Input::old('default_email', '');
				$details->website          = Input::old('website', '');
				$details->phone            = Input::old('phoone', '');
				$details->fax              = Input::old('fax', '');
				$details->status_id        = Input::old('status_id', 0);
				$details->message          = Input::old('message', '');
				$details->credit_limit     = Input::old('credit_limit', '');
				$details->credit_limit_exp = Input::old('credit_limit_exp', '');
				$details->ap_email         = Input::old('ap_email', '');
				$details->ar_email         = Input::old('ar_email', '');
				$details->shipping_email   = Input::old('shipping_email', '');
				$details->receiving_email  = Input::old('receiving_email', '');
				$details->logistics_email  = Input::old('logistics_email', '');
				$details->internal_notes   = Input::old('internal_notes', '');
				$details->payable_notes    = Input::old('payable_notes', '');
				$details->company_type_id  = Input::old('company_type_id', '');

			}
			else {
				/* Is an existing item, so retrieve item details for the form */
				$details = Company::getCompanyInfo($item_id);
        /* check to make sure the array isn't empty  */
				if (!count($details)) {	
          return Redirect::to($this->adminVars['adminURI'])
						->with('messages', 
                    array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
                          $this->pageData['error']));
				}	
			}
		}
		else {
			return Redirect::to($this->adminVars['adminURI'])
        ->with('messages', 
                array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
                      $this->pageData['error']));
		}

		return View::make($this->adminVars['adminURI'])
			->with('pageData', $this->pageData)
			->with('view', 'form')
			->with('adminVars', $this->adminVars)
			->with('formOptions', $formOptions)
			->with('details', $details); 
	} // edit()


	/** -----------------------------------------------------------------------
	* store(): 
  *           Save new or update the item.
	*
	* @return Response
	-------------------------------------------------------------------------*/
	public function store($item_id = 0) {
		/* Retrieve POST variables */
		$name             = Input::get('name', '');
		$address          = Input::get('address', '');
		$address2         = Input::get('address2', '');
		$city             = Input::get('city', '');
		$province_id      = Input::get('province_id', '');
		$country_id       = Input::get('country_id', '');
		$postal_code      = Input::get('postal_code', '');
		$default_email    = Input::get('default_email', '');
		$website          = Input::get('website', '');
		$phone            = Input::get('phone', '');
		$status_id        = Input::get('status_id', 0);
		$fax              = Input::get('fax', '');
		$message          = Input::get('message', '');
		$credit_limit     = Input::get('credit_limit', '');
		$credit_limit_exp = Input::get('credit_limit_exp', '');
		$ap_email         = Input::get('ap_email', '');
		$ar_email         = Input::get('ar_email', '');
		$shipping_email   = Input::get('shipping_email', '');
		$receiving_email  = Input::get('receiving_email', '');
		$logistics_email  = Input::get('logistics_email', '');
		$internal_notes   = Input::get('internal_notes', '');
		$payable_notes    = Input::get('payable_notes', '');
		$company_type_id  = Input::get('company_type_id', '');

		/* Build the array that supports validating the post data */
		$validator_data = array( 
			'name'             => $name,
			'address'          => $address,
			'city'             => $city,
			'postal_code'      => $postal_code,
			'province_id'      => $province_id,
			'country_id'       => $country_id,
			'default_email'    => $default_email,
			'website'          => $website,
			'phone'            => $phone,
			'status_id'        => $status_id,
			'credit_limit'     => $credit_limit,
			'credit_limit_exp' => $credit_limit_exp,
			'ap_email'         => $ap_email,
			'ar_email'         => $ar_email,
			'shipping_email'   => $shipping_email,
			'receiving_email'  => $receiving_email,
			'logistics_email'  => $logistics_email,
		);

		$validator_rules = array( // rules
			'name'             => 'required',
			'address'          => 'required',
			'city'             => 'required',
			'postal_code'      => 'required',
			'province_id'      => 'required|integer|min:1',
			'country_id'       => 'required|integer|min:1',
			'default_email'    => 'required',
			'website'          => 'required',
			'phone'            => 'required',
			'status_id'        => 'required|integer|min:1',
			'credit_limit'     => 'required',
			'credit_limit_exp' => 'required',
			'ap_email'         => 'required',
			'ar_email'         => 'required',
			'shipping_email'   => 'required',
			'receiving_email'  => 'required',
			'logistics_email'  => 'required',
		);

		/* Validate the post data */
		$validator = Validator::make($validator_data, $validator_rules);

		/* Go back if validation fails */
		if($validator->fails()) {	
			return Redirect::back()
		  		->withErrors($validator)
		  		->withInput();		
		}

    /* means a new item, so establish a new item class to save */		
		if($item_id == 0) {	
			$itemToSave=new Company;
		}
    /* Is an existing item, so establish item class to update */
		elseif (is_numeric($item_id)) {	
			$itemToSave = Company::find($item_id);
		}

		/* Establish the rest of the object variables to prepare for inserting */
		$itemToSave->locale_id        = $this->pageData['locale_id'];
		$itemToSave->language_id      = $this->pageData['language_id'];
		$itemToSave->name             = $name;
		$itemToSave->address          = $address;
		$itemToSave->address2         = $address2;
		$itemToSave->city             = $city;
		$itemToSave->postal_code      = $postal_code;
		$itemToSave->province_id      = $province_id;
		$itemToSave->country_id       = $country_id;
		$itemToSave->default_email    = $default_email;
		$itemToSave->website          = $website;
		$itemToSave->phone            = $phone;
		$itemToSave->fax              = $fax;
		$itemToSave->status_id        = $status_id;
		$itemToSave->message          = $message;
		$itemToSave->credit_limit     = $credit_limit;
		$itemToSave->credit_limit_exp = Util::postGenInsertDate($credit_limit_exp);
		$itemToSave->ap_email         = $ap_email;
		$itemToSave->ar_email         = $ar_email;
		$itemToSave->shipping_email   = $shipping_email;
		$itemToSave->receiving_email  = $receiving_email;
		$itemToSave->logistics_email  = $logistics_email;
		$itemToSave->internal_notes   = $internal_notes;
		$itemToSave->payable_notes    = $payable_notes;
		$itemToSave->company_type_id  = $company_type_id;

		$itemToSave->save();

    /* The item save was SUCCESSFUL, redirect to item listing page.  */
		if($itemToSave->id) {	
			$messages = array(Lang::get('site_content_admin.global_admin_Successful_Save'),
                      $this->pageData['success']);
			return Redirect::to($this->adminVars['adminURI'])
				->with('pageData', $this->pageData)
				->with('messages', $messages);
		}
    /* The item save FAILED, redirect back and try again */
		else {	
			$messages = array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
                      $this->pageData['error']);
			return Redirect::back()
				->withInput()
				->with('pageData', $this->pageData)
				->withErrors($messages);
		}	
	}	// store()


	/** -----------------------------------------------------------------------
	* destroy(): 
  *           Mark the item as deleted 
	*           -we rarely truly delete an item to protect data integrity
	*
	* @param  int  $id
	* @return Response
	-------------------------------------------------------------------------*/
	public function destroy($item_id = 0) { 	
		/* protect against invalid IDs */
    App::error(function(ModelNotFoundException $e) {	
      return Redirect::to($this->adminVars['adminURI'])
        ->with('messages', 
                array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
                      $this->pageData['error']));
    });

		/* We don't actually delete the item - we keep it in the db with a deleted
    status code assigned to it, to protect data integrety */
		$itemToDelete = Company::findOrFail($item_id);
		$itemToDelete->status_id = $this->adminVars['adminDeleteID'];
		$itemToDelete->save();
		
		return Redirect::to($this->adminVars['adminURI'])
			->with('messages', 
        array(Lang::get('site_content_admin.global_admin_Successful_Delete'),
              $this->pageData['success']));
	} // destroy()
} // class
