<?php
class AdminContentController extends \BaseController {

  public $adminVars;
  
  /*------------------------------------------------------------------------*/
  /* __construct(): default constructor */
  /*------------------------------------------------------------------------*/
  public function __construct() {
    parent::__construct();
		$this->adminVars['adminWord']      = 'content';
		$this->adminVars['adminWords']     = 'contents';
		$this->adminVars['adminWordCap']   = 'Content';
		$this->adminVars['adminClassType'] = 'Content';
		$this->adminVars['adminURI']       = 'admin-content';
		$this->adminVars['adminActiveID']  = '16';
		$this->adminVars['adminDeleteID']  = '18';
	}	// __construct()
	
	/** -----------------------------------------------------------------------
	* index(): 
  *           Display a listing of the resource.
	*
	* @return Response
	-------------------------------------------------------------------------*/
	public function index($content_group = 'site', $content_lang = '1') {
		$this->pageData['content_group'] = $content_group;
		$this->pageData['content_lang'] = $content_lang;

		/* Get the list of IDs */
		$itemIDs = Content::getItems($this->pageData['content_lang'],
                               $content_group,
                               'text');
		$items = array();

		/* Retrieve details for each item */
		foreach ($itemIDs as $value) {
			$items[$value['id']] = Content::getItemInfo($value['id']);
		}

		$languageOptions = DB::select(DB::raw("SELECT * FROM language WHERE status_id IN (7,8) ORDER BY name"));

    return View::make($this->adminVars['adminURI'])
			->with('pageData', $this->pageData)
			->with('view', 'index')
			->with('adminVars', $this->adminVars)
			->with('languageOptions', $languageOptions)
      ->with('items', $items);
  } // index()

	/** -----------------------------------------------------------------------
	* edit(): 
  *         Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	-------------------------------------------------------------------------*/
	public function edit($content_group = 'site', $content_lang = '1', $item_id = 0) {
		$this->pageData['content_group'] = $content_group;
		$this->pageData['content_lang'] = $content_lang;

    /* means a new item, so setup the form with default values */		
		if($item_id == 0) {	
			$details = new stdClass();
			$details->id = '0';
			$details->name = '';
			$details->content = '';
			$details->status_id = $this->adminVars['adminActiveID'];
			$details->language_name =	$language_code=DB::table('language')->where('id', '=', $content_lang )->pluck('name');
		}
    /* Is an existing item, so retrieve item details for the form */
		elseif(is_numeric($item_id)) {	
			$details = Content::getItemInfo($item_id);
      
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
			->with('details', $details);
	} // edit()

	/** -----------------------------------------------------------------------
	* store(): 
  *           Save new or update the item.
	*
	* @return Response
	-------------------------------------------------------------------------*/
	public function store($content_group = 'site', $content_lang = '1', $item_id = 0) {
		/* Retrieve POST variables */
		$name = Input::get('name', '');
		$content = Input::get('content', 0);
		
		/* Build the array that supports validating the post data */
		$validator_data = array( // data to test
			'name' => $name,
			'content' => $content,
		);
		$validator_rules = array( // rules
			'name' => 'required',
			'content' => 'required',
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
			$itemToSave = new Content;
		}
    /* Is an existing item, so establish item class to update */
		elseif (is_numeric($item_id)) {	
			$itemToSave = Content::find($item_id);
		}

		/* Establish the rest of the object variables to prepare for inserting */
		$itemToSave->language_id   = $content_lang;
		$itemToSave->name          = $name;
		$itemToSave->content       = $content;
		$itemToSave->type          = 'text';
		$itemToSave->content_group = $content_group;
		$itemToSave->save();

    /* The item save was SUCCESSFUL, redirect to item listing page.  */
		if($itemToSave->id) {
			$messages = array(Lang::get('site_content_admin.global_admin_Successful_Save'),
                      $this->pageData['success']);
			return Redirect::to($this->adminVars['adminURI'].'/'.$content_group.'/'.$content_lang)
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
	public function destroy_x($item_id = 0) { 	
		/* protect against invalid IDs */
		App::error(function(ModelNotFoundException $e) {	
			return Redirect::to($this->adminVars['adminURI'])
				->with('messages', 
            array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
                  $this->pageData['error']));
		});

		/* We don't actually delete the item - we keep it in the db with a deleted
       status code assigned to it, to protect data integrety */
		$itemToDelete = Content::findOrFail($item_id);
		$itemToDelete->ordernum = 0;
		$itemToDelete->status_id = $this->adminVars['adminDeleteID'];
		$itemToDelete->save();

		return Redirect::to($this->adminVars['adminURI'])
			->with('messages', 
          array(Lang::get('site_content_admin.global_admin_Successful_Delete'),
                $this->pageData['success']));
	} // destroy()
} // class
