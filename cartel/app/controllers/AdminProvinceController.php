<?php

class AdminProvinceController extends \BaseController {

  public $adminVars;
  
  /*------------------------------------------------------------------------*/
  /* __construct(): default constructor */
  /*------------------------------------------------------------------------*/
  public function __construct() {
    parent::__construct();
		$this->adminVars['adminWord']      = 'province';
		$this->adminVars['adminWords']     = 'provinces';
		$this->adminVars['adminWordCap']   = 'Province';
		$this->adminVars['adminClassType'] = 'Province';
		$this->adminVars['adminURI']       = 'admin-province';
		$this->adminVars['adminActiveID']  = '38';
		$this->adminVars['adminDeleteID']  = '40';
	}	// __construct()
	
	/** -----------------------------------------------------------------------
	* index():
  *           Display a listing of the resource.
	*
	* @return Response
	-------------------------------------------------------------------------*/
	public function index() {
		/* Get the list of IDs */
		$itemIDs = Province::getItems($this->pageData['locale_id'],
                                  $this->pageData['language_id'], 0);
		$items = array();

		/* Retrieve details for each item */
    foreach ($itemIDs as $key => $value) {
			$items[$value['id']] = Province::getItemInfo($value['id']);
      foreach ($value['sub'] as $subkey => $subvalue) {
				$items[$value['id']]['sub'][$subkey] =
          Province::getItemInfo($subvalue['id']);		
      }
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
	public function edit($parent_type = '', $item_id = 0) {
		/* Build arrays used to build the form options */
		$statusOptions = Status::whereRaw("
      filter = ? AND
      active = ?",
      array($this->adminVars['adminClassType'], 1))
			->orderBy('ordernum')
			->get(array('id', 'name'));

		if($parent_type == 'country') {
			$parentIDOptions = Country::whereRaw("
        locale_id = ? AND
        language_id = ? AND
        status_id IN (41,42)",
        array($this->pageData['locale_id'], $this->pageData['language_id']))
				->orderBy('name')
				->get(array('id', 'name'));
		}
		elseif($parent_type == 'origin') {
			$parentIDOptions = Origin::whereRaw("
        locale_id = ? AND
        language_id = ? AND
        status_id IN (35,36)",
        array($this->pageData['locale_id'], $this->pageData['language_id']))
        ->orderBy('name')
        ->get(array('id', 'name'));
		}

		if($item_id == 0) {	
      /* means a new item, so setup the form with default values */		
			$details = new stdClass();
        $details->id = '0';
        $details->name = '';
        $details->code = '';
        $details->parent_id = '0';
        $details->status_id = $this->adminVars['adminActiveID'];
		}
		elseif(is_numeric($item_id)) {	
      /* Is an existing item, so retrieve item details for the form */
			$details = Province::getItemInfo($item_id);
      /* check to make sure the array isn't empty  */
			if (!count($details))  {	
        return Redirect::to($this->adminVars['adminURI'])
					->with('messages',
            array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
                  $this->pageData['error']));
			}	

			if($parent_type == 'country') {
				$details->parent_id = $details->country_id;
			}
			elseif($parent_type == 'origin') {
				$details->parent_id = $details->origin_id;
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
			->with('parent_type', $parent_type)
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
		$name        = Input::get('name', '');
		$code        = Input::get('code', '');
		$parent_type = Input::get('parent_type', 0);
		$parent_id   = Input::get('parent_id', 0);
		$status_id   = Input::get('status_id', 0);
				
		/* Build the array that supports validating the post data */
		$validator_data = array(
			'name' => $name,
			'code' => $code,
			'parent_id' => $parent_id,
			'status_id' => $status_id,
		);

		$validator_rules = array(
			'name' => 'required',
			'code' => 'required',
			'parent_id' => 'required|integer|min:0',
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
			$itemToSave = new Province;
		}
    /* Is an existing item, so establish item class to update */
		elseif (is_numeric($item_id)) {	
			$itemToSave = Province::find($item_id);
		}

		/* Establish the rest of the object variables to prepare for inserting */
		$itemToSave->locale_id   = $this->pageData['locale_id'];
		$itemToSave->language_id = $this->pageData['language_id'];
		$itemToSave->name        = $name;
		$itemToSave->code        = $code;
		$itemToSave->status_id   = $status_id;

		if($parent_type == 'country') {
			$itemToSave->country_id = $parent_id;
			$itemToSave->origin_id = 0;
			$redirect = 'admin-country';
		}
		elseif($parent_type == 'origin') {
			$itemToSave->country_id = 0;
			$itemToSave->origin_id = $parent_id;
			$redirect = 'admin-origin';
		}
		$itemToSave->save();

    /* The item save was SUCCESSFUL, redirect to item listing page.  */
		if($itemToSave->id) {	
			$messages = array(Lang::get('site_content_admin.global_admin_Successful_Save'),
                      $this->pageData['success']);
			return Redirect::to($redirect)
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
	public function destroy($parent_type = '', $item_id = 0) { 	
		/* protect against invalid IDs */
		App::error(function(ModelNotFoundException $e) {	
			return Redirect::to($this->adminVars['adminURI'])
				->with('messages',
          array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
                $this->pageData['error']));
		});

		/* We don't actually delete the item - we keep it in the db with a deleted
       status code assigned to it, to protect data integrety */
		$itemToDelete = Province::findOrFail($item_id);
		$itemToDelete->status_id = $this->adminVars['adminDeleteID'];
		$itemToDelete->save();

		if($parent_type == 'country') {
			$redirect = 'admin-country';
		}
		elseif($parent_type == 'origin') {
			$redirect = 'admin-origin';
		}
		return Redirect::to($redirect)
			->with('messages',
        array(Lang::get('site_content_admin.global_admin_Successful_Delete'),
              $this->pageData['success']));
	} // destroy()
} // class
