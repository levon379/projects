<?php

class AdminWeightTypeController extends \BaseController {

  public $adminVars;
  
  /*------------------------------------------------------------------------*/
  /* __construct(): default constructor */
  /*------------------------------------------------------------------------*/
  public function __construct() {
    parent::__construct();
		$this->adminVars['adminWord']      = 'weight type';
		$this->adminVars['adminWords']     = 'weight types';
		$this->adminVars['adminWordCap']   = 'Weight Type';
		$this->adminVars['adminClassType'] = 'Weight_type';
		$this->adminVars['adminURI']       = 'admin-weight-type';
		$this->adminVars['adminActiveID']  = '44';
		$this->adminVars['adminDeleteID']  = '46';
	}	// __construct()
	
	/** -----------------------------------------------------------------------
	* index(): 
  *           Display a listing of the resource.
	*
	* @return Response
	-------------------------------------------------------------------------*/
	public function index() {
		/* Get the list of IDs */
		$bulkitemIDs = Weight_type::getItems($this->pageData['locale_id'],
                                       $this->pageData['language_id'], 1);
		$bulkitems = array();

		/* Retrieve details for each item */
		foreach ($bulkitemIDs as $value)
			$bulkitems[$value->id] = Weight_type::getItemInfo($value->id);

		/* Get the list of IDs */
		$itemIDs = Weight_type::getItems($this->pageData['locale_id'],
                                   $this->pageData['language_id'],
                                   0);
		$items = array();

		/* Retrieve details for each item */
		foreach ($itemIDs as $value)
			$items[$value->id] = Weight_type::getItemInfo($value->id);

    return View::make($this->adminVars['adminURI'])
			->with('pageData', $this->pageData)
			->with('view', 'index')
			->with('adminVars', $this->adminVars)
      ->with('bulkitems', $bulkitems)
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
		$statusOptions = Status::whereRaw("filter=? AND active=?",
      array($this->adminVars['adminClassType'], 1))
			->orderBy('ordernum')
			->get(array('id', 'name'));

    /* means a new item, so setup the form with default values */		
		if($item_id == 0) {	
			$details = new stdClass();
      $details->id = '0';
      $details->name = '';
      $details->isbulk = '1';
      $details->value_wrt_grams = '0';
      $details->ordernum = '100';
      $details->status_id = $this->adminVars['adminActiveID'];
		}
    /* Is an existing item, so retrieve item details for the form */
		elseif(is_numeric($item_id)) {	
			$details = Weight_type::getItemInfo($item_id);
      
      /* check to make sure the array isn't empty  */
			if (!count($details))  {	
        return Redirect::to($this->adminVars['adminURI'])
					->with('messages',
            array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
                  $this->pageData['error']));
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
		$name            = Input::get('name', '');
		$isbulk          = Input::get('isbulk', 0);
		$value_wrt_grams = Input::get('value_wrt_grams', 0);
		$ordernum        = Input::get('ordernum', 0);
		$status_id       = Input::get('status_id', 0);
		
		/* Build the array that supports validating the post data */
		$validator_data = array( // data to test
			'name'            => $name,
			'isbulk'          => $isbulk,
			'value_wrt_grams' => $value_wrt_grams,
			'ordernum'        => $ordernum,
			'status_id'       => $status_id,
		);

		$validator_rules = array( // rules
			'name'            => 'required|min:1',
			'isbulk'          => 'required|integer|min:0',
			'value_wrt_grams' => 'required|numeric|min:0',
			'ordernum'        => 'required|integer|min:1',
			'status_id'       => 'required|integer|min:1',
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
			$itemToSave = new Weight_type;
		}
    /* Is an existing item, so establish item class to update */
		elseif (is_numeric($item_id)) {	
			$itemToSave = Weight_type::find($item_id);
		}

		/* Establish the rest of the object variables to prepare for inserting */
		$itemToSave->locale_id       = $this->pageData['locale_id'];
		$itemToSave->language_id     = $this->pageData['language_id'];
		$itemToSave->name            = $name;
		$itemToSave->isbulk          = $isbulk;
		$itemToSave->value_wrt_grams = $value_wrt_grams;
		$itemToSave->ordernum        = $ordernum;
		$itemToSave->status_id       = $status_id;
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
		$itemToDelete = Weight_type::findOrFail($item_id);
		$itemToDelete->ordernum = 0;
		$itemToDelete->status_id = $this->adminVars['adminDeleteID'];
		$itemToDelete->save();

		return Redirect::to($this->adminVars['adminURI'])
			->with('messages',
        array(Lang::get('site_content_admin.global_admin_Successful_Delete'),
              $this->pageData['success']));
	} // destroy(

	/** -----------------------------------------------------------------------
	* swap(): 
  *         Swap the items in the list, changing their order num
	*
	* @param  int  $id
	* @return Response
	-------------------------------------------------------------------------*/
	public function swap($item_id = 0, $swap_id = 0) { 	
		if($item_id == 0 || $swap_id == 0) {
			return Redirect::to($this->adminVars['adminURI'])
				->with('messages',
          array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
                $this->pageData['error']));		
		}
		else {
			$currItem = Weight_type::findOrFail($item_id);
			$swapItem = Weight_type::findOrFail($swap_id);
			$temp = $currItem->ordernum;

			$currItem->ordernum = $swapItem->ordernum;
			$currItem->save();

			$swapItem->ordernum = $temp;
			$swapItem->save();

			return Redirect::to($this->adminVars['adminURI']);
		}
	}	// swap()
} // class
