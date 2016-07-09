<?php

class AdminUserController extends \BaseController {

  public $adminVars;

  /* ------------------------------------------------------------------------ */
  /* __construct(): default constructor */
  /* ------------------------------------------------------------------------ */
  public function __construct() {
    parent::__construct();
    $this->adminVars['adminWord'] = 'User';
    $this->adminVars['adminWords'] = 'users';
    $this->adminVars['adminWordCap'] = 'user';
    $this->adminVars['adminClassType'] = 'User';
    $this->adminVars['adminURI'] = 'admin-user';
    $this->adminVars['adminActiveID'] = '1';
    $this->adminVars['adminDeleteID'] = '3';
  } 

  /** ---------------------------------------------------------------------
   * onlineUsers(): displays all users ordered by company and their
   *                online/offline status
   *---------------------------------------------------------------------- 
   *
   *---------------------------------------------------------------------- */
  public function onlineUsers() {
    /* Get all companies */
    $companies = Company::all();
    
    /* Get all companies, users and user online statuses */
    foreach($companies as &$company) {
      $company->users = User::where('company_id', '=', $company->id)
                              ->orderBy('last_online', 'desc')
                              ->get();
      foreach($company->users as &$user)
        $user->is_online = DatabaseSession::where('user_id', $user->id)->exists();
    }
    return View::make('admin-user-list')->with('companies', $companies);
  }

  /**-------------------------------------------------------------------------
   * edit():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
  public function edit($item_id = 0) {
    /* Build arrays used to build the form options */
    $formOptions['statusOptions'] = Status::whereRaw("
        filter = ? AND 
        active = ?", array($this->adminVars['adminClassType'], 1))
      ->orderBy('ordernum')
      ->get(array('id', 'name'));

    $formOptions['companyIDOptions'] = Company::whereRaw("
        locale_id = ? AND
        language_id = ? AND
        status_id IN (13,14)", array($this->pageData['locale_id'], $this->pageData['language_id']))
      ->orderBy('name')
      ->get(array('id', 'name'));

    $formOptions['languageOptions'] = Language::whereRaw("status_id IN (7,8)")
      ->orderBy('name')
      ->get(array('id', 'name'));

    $formOptions['permGroupOptions'] = Perm_group::whereRaw("
        status_id IN (5,6) AND
        id > 1")
      ->orderBy('ordernum')
      ->orderBy('name')
      ->get(array('id', 'name'));

    /* means a new item, so setup the form with default values */
    if ($item_id == 0) {
      $details = new stdClass();
      $details->id = '0';
      $details->defaultlanguage_id = '';
      $details->company_id = '0';
      $details->name = '';
      $details->email = '';
      $details->email2 = '';
      $details->username = '';
      $details->password = '';
      $details->perm_groups = 8;
      $details->office_phone = '';
      $details->cell_phone = '';
      $details->status_id = $this->adminVars['adminActiveID'];
    } 
    else if(is_numeric($item_id)) {
      /* this is a Redirect-back -> withInput, so grab those vars instead of
         pulling from the database */

      $user = User::findOrFail($item_id);
      $details = new stdClass();
      $details->id = $user->id;
      $details->defaultlanguage_id = $user->language_id;
      $details->company_id = $user->company_id;
      $details->name = $user->name;
      $details->email = $user->email;
      $details->email2 = $user->email2;
      $details->username = $user->username;
      $details->password = $user->password;
      $details->perm_groups = $user->perm_groups;
      $details->office_phone = $user->office_phone;
      $details->cell_phone = $user->cell_phone;
      $details->status_id = $user->status_id;
      $details->file_path = $user->file_path;
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
   *          Save new or update the item.
   *
   * @return Response
   ------------------------------------------------------------------------- */
  public function store($item_id = 0) {
    /*Upload user file in uploads folder*/
    
    
    /* Retrieve POST variables */
    $defaultlanguage_id = Input::get('defaultlanguage_id', '');
    $name = Input::get('name', '');
    $company_id = Input::get('company_id', '');
    $email = Input::get('email', '');
    $email2 = Input::get('email2', '');
    $office_phone = Input::get('office_phone', '');
    $cell_phone = Input::get('cell_phone', '');
    $username = Input::get('username', '');
    $password = Input::get('password', '');
    $perm_groups = Input::get('perm_groups', '');
    $status_id = Input::get('status_id', 0);

    /* Build the array that supports validating the post data */
    $validator_data = array(// data to test
        'defaultlanguage_id' => $defaultlanguage_id,
        'name' => $name,
        'company_id' => $company_id,
        'email' => $email,
        'office_phone' => $office_phone,
        'cell_phone' => $cell_phone,
        'username' => $username,
        'perm_groups' => $perm_groups,
        'status_id' => $status_id,
        );

    $validator_rules = array(// rules
        'defaultlanguage_id' => 'required|integer|min:1',
        'name' => 'required',
        'company_id' => 'required|integer|min:1',
        'email' => 'required',
        'office_phone' => 'required',
        'cell_phone' => 'required',
        'username' => 'required',
        'perm_groups' => 'required',
        'status_id' => 'required|integer|min:1',
        );

    /* Validate the post data */
    $validator = Validator::make($validator_data, $validator_rules);

    /* Go back if validation fails */
    if ($validator->fails()) {
      return Redirect::back()->withInput()
        ->withErrors($validator);
    }
    $file = Input::file('file');
    $destinationPath = 'uploads'; // upload path
    $extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
    $fileName = md5(time().rand(11111,99999)).'.'.$extension; // renameing image
    $file_path= NULL;
    if (Input::hasFile('file'))
    {
        $upload = Input::file('file')->move($destinationPath, $fileName);
        $file_path = $destinationPath.'/'.$fileName;
    }
    /* means a new item, so establish a new item class to save */
    if ($item_id == 0) {
      $itemToSave = new User;
    }
    /* Is an existing item, so establish item class to update */ elseif (is_numeric($item_id)) {
      $itemToSave = User::find($item_id);
    }

    /* Establish the rest of the object variables to prepare for inserting */
    $itemToSave->defaultlanguage_id = $defaultlanguage_id;
    $itemToSave->name = $name;
    $itemToSave->company_id = $company_id;
    $itemToSave->email = $email;
    $itemToSave->email2 = $email2;
    $itemToSave->office_phone = $office_phone;
    $itemToSave->cell_phone = $cell_phone;
    $itemToSave->username = $username;
    $itemToSave->perm_groups = $perm_groups;
    $itemToSave->status_id = $status_id;
    $itemToSave->file_path = $file_path;
    if ($password != '') {
      $itemToSave->password = Hash::make($password);
    }

    $itemToSave->save();

    /* The item save was SUCCESSFUL, redirect to item listing page.  */
    if ($itemToSave->id) {
      $messages = array(Lang::get('site_content_admin.global_admin_Successful_Save'),
          $this->pageData['success']);
      return Redirect::to('admin-company')
        ->with('pageData', $this->pageData)
        ->with('messages', $messages);
    }
    /* The item save FAILED, redirect back and try again */ else {
      $messages = array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
          $this->pageData['error']);
      return Redirect::back()
        ->withInput()
        ->with('pageData', $this->pageData)
        ->withErrors($messages);
    }
  } // store()


  /** -----------------------------------------------------------------------
   * destroy(): 
   *            Mark the item as deleted 
   *            -we rarely truly delete an item to protect data integrity
   *
   * @param  int  $id
   * @return Response
   ------------------------------------------------------------------------- */
  public function destroy($item_id = 0) {
    /* protect against invalid IDs */
    App::error(function(ModelNotFoundException $e) {
        return Redirect::to($this->adminVars['adminURI'])
        ->with('messages', array(Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
            $this->pageData['error']));
        });

    /* We don't actually delete the item - we keep it in the db with a deleted
       status code assigned to it, to protect data integrety */
    $itemToDelete = User::findOrFail($item_id);
    $itemToDelete->status_id = $this->adminVars['adminDeleteID'];
    $itemToDelete->save();

    return Redirect::to('admin-company')
      ->with('messages', array(Lang::get('site_content_admin.global_admin_Successful_Delete'),
            $this->pageData['success']));
  } // destroy()
}

// class
