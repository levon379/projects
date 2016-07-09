<?php

class AdminPermissionController extends \BaseController {

  public $adminVars;
  
  /*------------------------------------------------------------------------*/
  /* __construct(): default constructor */
  /*------------------------------------------------------------------------*/
  public function __construct() {
    parent::__construct();
		$this->adminVars['adminWord']      = 'permission';
		$this->adminVars['adminWords']     = 'permissions';
		$this->adminVars['adminWordCap']   = 'Permission';
		$this->adminVars['adminClassType'] = 'Perm_group';
		$this->adminVars['adminURI']       = 'admin-permission';
		$this->adminVars['adminActiveID']  = '5';
		$this->adminVars['adminDeleteID']  = '7';
	}	// __construct()
	
	/** -----------------------------------------------------------------------
	* index(): 
  *         Display a listing of the resource.
	*
	* @return Response
	-------------------------------------------------------------------------*/
	public function index() {
    
		/* Get the list of IDs */
		$itemIDs = Perm_group::getItems();
		$items = array();

		/* Retrieve details for each item */
		foreach ($itemIDs as $value)
			$items[$value->id] = Perm_group::getItemInfo($value->id);

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

		$permModuleOptions = Perm_module::whereRaw("
      id > 1 AND
      sort_group='site'")
			->orderBy('id')
			->get(array('id', 'showname'));

		$permModuleAdminOptions = Perm_module::whereRaw("
      id > 1 AND 
      sort_group='admin'")
			->orderBy('id')
			->get(array('id', 'showname'));

    /* means a new item, so setup the form with default values */		
		if($item_id == 0) {	
			$details = new stdClass();
			$details->id = '0';
			$details->showname = '';
			$details->moduleperms = '0';
		}
    /* Is an existing item, so retrieve item details for the form */
		elseif(is_numeric($item_id)) {	
			$details = Perm_group::getItemInfo($item_id);
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
			->with('permModuleOptions', $permModuleOptions)
			->with('permModuleAdminOptions', $permModuleAdminOptions)
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
		$moduleperms = array_sum(Input::get('moduleperms', -1));
    
		/* Is an existing item, so establish item class to update */
		$itemToSave = Perm_group::find($item_id);

		/* Establish the rest of the object variables to prepare for saving */
		$itemToSave->moduleperms = $moduleperms;

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
} // class
