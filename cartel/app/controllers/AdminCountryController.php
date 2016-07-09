<?php
class AdminCountryController extends \BaseController {

  public $adminVars;
  
  /*------------------------------------------------------------------------*/
  /* __construct(): default constructor */
  /*------------------------------------------------------------------------*/
  public function __construct() {
    parent::__construct();
		$this->adminVars['adminWord']      = 'country';
		$this->adminVars['adminWords']     = 'countries';
		$this->adminVars['adminWordCap']   = 'Country';
		$this->adminVars['adminClassType'] = 'Country';
		$this->adminVars['adminURI']       = 'admin-country';
		$this->adminVars['adminActiveID']  = '41';
		$this->adminVars['adminDeleteID']  = '43';
	}	// __construct()
	
	/** -----------------------------------------------------------------------
	* index():
  *           Display a listing of the resource.
	*
	* @return Response
	-------------------------------------------------------------------------*/
	public function index() {
		/* Get the list of IDs */
		$itemIDs = Country::getNestedItems($this->pageData['locale_id'],
                                     $this->pageData['language_id'], 0);
		$items = array();

    /* Foreach countries */
    foreach ($itemIDs as $key => $val) {
      $items[$val->id] = Country::getItemInfo($val->id);
      
      /* Foreach provinces/states */
      foreach ($val->sub as $subkey => $subval) {
        $items[$val->id]->sub[$subkey] = Province::getItemInfo($subval->id);		
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
  *         Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	-------------------------------------------------------------------------*/
	public function edit($item_id = 0) {
		/* Build arrays used to build the form options */
		$statusOptions = Status::whereRaw("
      filter = ? AND
      active = ?",
      array($this->adminVars['adminClassType'], 1))
			->orderBy('ordernum')
			->get(array('id', 'name'));

		$parentIDOptions = Country::whereRaw("
      locale_id = ? AND
      language_id = ? AND
      status_id IN (23,24)",
      array($this->pageData['locale_id'], $this->pageData['language_id']))
			->orderBy('name')
			->get(array('id', 'name'));

    /* means a new item, so setup the form with default values */		
		if($item_id == 0) {	
			$details = new stdClass();
			$details->id = '0';
			$details->name = '';
			$details->code = '';
			$details->status_id = $this->adminVars['adminActiveID'];
		}
    
    /* Is an existing item, so retrieve item details for the form */
		elseif(is_numeric($item_id)) {	
			$details = Country::getItemInfo($item_id);
			if (!count($details))  {	
        return Redirect::to($this->adminVars['adminURI'])->with('messages', array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'), $this->pageData['error']));
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
			->with('statusOptions', $statusOptions)
			->with('parentIDOptions', $parentIDOptions)
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
		$name = Input::get('name', '');
		$code = Input::get('code','');
		$status_id = Input::get('status_id', 0);
		
		/* Build the array that supports validating the post data */
		$validator_data = array( // data to test
			'name' => $name,
			'code' => $code,
			'status_id' => $status_id,
		);

		$validator_rules = array( // rules
			'name' => 'required',
			'code' => 'required',
			'status_id' => 'required|integer|min:1',
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
			$itemToSave = new Country;
		}
    /* Is an existing item, so establish item class to update */
		elseif (is_numeric($item_id)) {	
			$itemToSave = Country::find($item_id);
		}

		/* Establish the rest of the object variables to prepare for inserting */
		$itemToSave->locale_id = $this->pageData['locale_id'];
		$itemToSave->language_id = $this->pageData['language_id'];
		$itemToSave->name = $name;
		$itemToSave->code = $code;
		$itemToSave->status_id = $status_id;
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
  *             Mark the item as deleted 
	*             -we rarely truly delete an item to protect data integrity
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
		$itemToDelete = Country::findOrFail($item_id);
		$itemToDelete->status_id = $this->adminVars['adminDeleteID'];
		$itemToDelete->save();
		
		/* We also need to soft-delete the underlying Provinces */
		DB::table('province')
      ->where('country_id', $item_id)
      ->update(array('status_id' => 40));
		
		return Redirect::to($this->adminVars['adminURI'])
			->with('messages', 
            array(Lang::get('site_content_admin.global_admin_Successful_Delete'),
                  $this->pageData['success']));
	} // destroy()
} // class
