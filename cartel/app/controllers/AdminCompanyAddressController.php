<?php
class AdminCompanyAddressController extends \BaseController {

  /*------------------------------------------------------------------------*/
  /* __construct(): default constructor */
  /*------------------------------------------------------------------------*/
  public function __construct() {
    parent::__construct();
	}	 // __construct()
	
	/** -----------------------------------------------------------------------
	* index(): Display a listing of the resource.
	*
	* @return Response
	-------------------------------------------------------------------------*/
	public function index($company_id) {
    
		/* Get the list of IDs */
		$itemIDs=Company_address::getItems($this->pageData['locale_id'],
                                       $this->pageData['language_id'],
                                       $company_id);
    
		/* Retrieve details for each item */
		$items = array();
		foreach ($itemIDs as $key => $value)
      $items[$value->id] = Company_address::getOneShippingAddress($value->id);

    $companyInfo = new stdClass();
		$companyInfo->id = $company_id;
		$companyInfo->company_name = DB::table('company')
                                      ->where('id', '=', $company_id )
                                      ->pluck('name');
    return View::make('admin.company-address.index')
			->with('pageData', $this->pageData)
			->with('companyInfo', $companyInfo)
      ->with('items', $items);
  } // index()

	/** -----------------------------------------------------------------------
	* edit(): Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	-------------------------------------------------------------------------*/
	public function edit($company_id = 0, $item_id = 0) {
		/* Build arrays used to build the form options */
		$formOptions['statusOptions'] = Status::whereRaw("
      filter = ? AND
      active = ?",
      array('Company_address', 1))
      ->orderBy('ordernum')
      ->get(array('id', 'name'));
    $formOptions['provinceOptions'] = Province::whereRaw("
      locale_id = ? AND
      language_id = ? AND
      status_id = ? AND
      country_id != ?",
      array($this->pageData['locale_id'],
            $this->pageData['language_id'],
            38, 0))
			->groupBy('country_id', 'name')
			->get(array('country_id', 'id', 'name'));
		$formOptions['countryOptions'] = Country::whereRaw("
      locale_id = ? AND
      language_id = ? AND
      status_id = ?",
      array($this->pageData['locale_id'],
            $this->pageData['language_id'],
            41))
			->orderBy('name')
			->get(array('id', 'name'));			
		$formOptions['shipRecvOptions'] = array(
			'Ship' => 'Shipping Only',
			'Recv' => 'Receiving Only',
			'Both' => 'Shipping and Receiving');

    $companyInfo = new stdClass();
		$companyInfo->id = $company_id;
		$companyInfo->company_name = DB::table('company')
                                    ->where('id', '=', $company_id )
                                    ->pluck('name');

    /* means a new item, so setup the form with default values */		
		if($item_id == 0) {	
			$details               = new stdClass();
			$details->id           = '0';
			$details->company_id   = $company_id;
		  $details->ship_or_recv = '';
			$details->company      = '';
			$details->address      = '';
			$details->address2     = '';
			$details->city         = '';
			$details->postal_code  = '';
			$details->province_id  = '';
			$details->country_id   = '';
			$details->status_id    = '52';
		}
		elseif(is_numeric($item_id)) {	
			if(Input::old()) {	
        /* This is a Redirect-back -> withInput, so grab those vars instead of
           pulling from the database */
        $details = new stdClass();
				$details->id           = $item_id;
				$details->ship_or_recv = Input::old('ship_or_recv', '');
				$details->company      = Input::old('company', '');
				$details->address      = Input::old('address', '');
				$details->address2     = Input::old('address2', '');
				$details->city         = Input::old('city', '');
				$details->postal_code  = Input::old('postal_code', '');
				$details->province_id  = Input::old('province_id', 0);
				$details->country_id   = Input::old('country_id', 0);
				$details->status_id    = Input::old('status_id', 0);
			}
			else {	
				/* Is an existing item, so retrieve item details for the form */
				$details = Company_address::getOneShippingAddress($item_id);
        
        /* check to make sure the array isn't empty  */
				if(!count($details))  {	
          return Redirect::to('admin-company-address')
						->with('messages', 
              array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
                    $this->pageData['error']));
				}	
			}
		}
		else {
			return Redirect::to('admin-company-address')
					->with('messages', 
              array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
                    $this->pageData['error']));
		}

		return View::make('admin.company-address.create')
			->with('pageData', $this->pageData)
			->with('formOptions', $formOptions)
			->with('companyInfo', $companyInfo)
			->with('details', $details);
	} // edit()

	/** -----------------------------------------------------------------------
	* store(): Save new or update the item.
	*
	* @return Response
	-------------------------------------------------------------------------*/
	public function store($company_id = 0, $item_id = 0) {
		/* Retrieve POST variables */
		$ship_or_recv = Input::get('ship_or_recv', '');
		$company      = Input::get('company', '');
		$address      = Input::get('address', '');
		$address2     = Input::get('address2', '');
		$city         = Input::get('city', '');
		$postal_code  = Input::get('postal_code', '');
		$province_id  = Input::get('province_id', '');
		$country_id   = Input::get('country_id', '');
		$status_id    = Input::get('status_id', 0);
				
		/* Build the array that supports validating the post data */
		$validator_data = array( // data to test
			'ship_or_recv' => $ship_or_recv,
			'company'      => $company,
			'address'      => $address,
			'city'         => $city,
			'postal_code'  => $postal_code,
			'province_id'  => $province_id,
			'country_id'   => $country_id,
			'status_id'    => $status_id,
		);

		$validator_rules = array( // rules
			'ship_or_recv' => 'required',
			'company'      => 'required',
			'address'      => 'required',
			'city'         => 'required',
			'postal_code'  => 'required',
			'province_id'  => 'required',
			'country_id'   => 'required',
			'status_id'    => 'required|integer|min:1',
		);

		/* Validate the post data */
		$validator = Validator::make($validator_data, $validator_rules);

		/* Go back if validation fails */
		if($validator->fails())
			return Redirect::back()->withErrors($validator)->withInput();		

    /* means a new item, so establish a new item class to save */		
		if($item_id == 0)
			$itemToSave = new Company_address;
    /* Is an existing item, so establish item class to update */
		elseif (is_numeric($item_id))
			$itemToSave = Company_address::find($item_id);

		/* Establish the rest of the object variables to prepare for inserting */
		$itemToSave->locale_id    = $this->pageData['locale_id'];
		$itemToSave->language_id  = $this->pageData['language_id'];
		$itemToSave->company_id   = $company_id;
		$itemToSave->ship_or_recv = $ship_or_recv;
		$itemToSave->company      = $company;
		$itemToSave->address      = $address;
		$itemToSave->address2     = $address2;
		$itemToSave->city         = $city;
		$itemToSave->postal_code  = $postal_code;
		$itemToSave->province_id  = $province_id;
		$itemToSave->country_id   = $country_id;
		$itemToSave->status_id    = $status_id;

		$itemToSave->save();

    /* The item save was SUCCESSFUL, redirect to item listing page.  */
		if($itemToSave->id) {	
			$messages = array(Lang::get('site_content_admin.global_admin_Successful_Save'),
                        $this->pageData['success']);
			return Redirect::to('admin-company-address/'.$company_id)
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
  *         Mark the item as deleted 
	*         -we rarely truly delete an item to protect data integrity
	*
	* @param  int  $id
	* @return Response
	-------------------------------------------------------------------------*/
	public function destroy($item_id = 0) { 	
		/* We don't actually delete the item - we keep it in the db with a deleted
       status code assigned to it, to protect data integrety */
		$address = Company_address::findOrFail($item_id);
		$address->status_id = '52';
		$address->save();
    
    $company_id = Company::findOrFail($address->company_id)->id;

		return Redirect::to('admin-company-address/'.$company_id)
			->with('messages', 
              array(Lang::get('site_content_admin.global_admin_Successful_Delete'),
              $this->pageData['success']));
	} // destroy()
} // class
