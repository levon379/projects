<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminCategoryController extends \BaseController {

  public $adminVars;
  
  /*------------------------------------------------------------------------*/
  /* __construct(): default constructor */
  /*------------------------------------------------------------------------*/
  public function __construct() {
    parent::__construct();
  }	// __construct()
	
  /* -----------------------------------------------------------------------
  * index(): Display a listing of the resource.
  *
  * @return Response
  ------------------------------------------------------------------------*/
  public function index() {
    /* Get the list of IDs */
    $itemIDs = Category::getNestedItems(
      $this->pageData['locale_id'],
      $this->pageData['language_id'],
      0);
    $items=array();

    /* Retrieve details for each item */
    foreach ($itemIDs as $key => $value) {
      $items[$value->id] = Category::getItemInfo($value->id);
      
      foreach ($value->sub as $subkey => $subvalue){
        $items[$value->id]->sub[$subkey] =
            Category::getItemInfo($subvalue->id);		
      }
    }
    
    return View::make('admin-category')
      ->with('pageData', $this->pageData)
      ->with('view', 'index')
      ->with('items', $items);
  } // index()

  /** -----------------------------------------------------------------------
  * edit(): Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return Response
  *------------------------------------------------------------------------*/
  public function edit($item_id = 0) {
    /* Build arrays used to build the form options */
    $statusOptions=Status::whereRaw("
      filter = ? AND
      active = ?",
      array('Category', 1))
      ->orderBy('ordernum')
      ->get(array('id', 'name'));

    $parentIDOptions=Category::whereRaw( 
      "locale_id = ? AND
      language_id = ? AND
      status_id 
      IN 
      (23,24) AND
      parent_id = 0 AND
      isother = 0",
      array($this->pageData['locale_id'], $this->pageData['language_id']))
      ->orderBy('name')
      ->get(array('id', 'name'));

    /* means a new item, so setup the form with default values */		
    if($item_id == 0) {	
      $details = new stdClass();
      $details->id = '0';
      $details->name = '';
      $details->parent_id = '0';
      $details->status_id = '23';
    }
    elseif(is_numeric($item_id)) {	
      /* Is an existing item, so retrieve item details for the form */
      $details = Category::getItemInfo($item_id);

      $messages = array(
        Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
        $this->pageData['error']);
      
      /* check to make sure the array isn't empty  */
      if (!count($details))
        return Redirect::to('admin-category')
          ->with('messages', $messages);
    }
    else {
      $messages = array(
        Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
                  $this->pageData['error']);
      return Redirect::to('admin-category')
        ->with('messages', $messages);
    }

    return View::make('admin-category')
      ->with('pageData', $this->pageData)
      ->with('view', 'form')
      ->with('adminVars', $this->adminVars)
      ->with('statusOptions', $statusOptions)
      ->with('parentIDOptions', $parentIDOptions)
      ->with('details', $details);
  } // edit()

  /* -----------------------------------------------------------------------
  * store(): Save new or update the item.
  *
  * @return Response
  *------------------------------------------------------------------------*/
  public function store($item_id = 0) {
    
    /* Retrieve POST variables */
    $name=Input::get('name', '');
    $parent_id = Input::get('parent_id', 0);
    $status_id = Input::get('status_id', 0);
    
    /* Build the array that supports validating the post data */
    $validator_data = array(
      'name' => $name,
      'parent_id' => $parent_id,
      'status_id' => $status_id,
    );
    $validator_rules = array( 
      'name' => 'required|min:1',
      'parent_id' => 'required|integer|min:0',
      'status_id' => 'required|integer|min:1',
    );

    /* Validate the post data */
    $validator = Validator::make($validator_data, $validator_rules);

    /* Go back if validation fails */
    if($validator->fails()) 
      return Redirect::back()
        ->withErrors($validator)
        ->withInput();		

    /* means a new item, so establish a new item class to save */		
    if($item_id == 0)
      $itemToSave = new Category;
    /* Is an existing item, so establish item class to update */
    elseif (is_numeric($item_id))
      $itemToSave=Category::find($item_id);

    /* Establish the rest of the object variables to prepare for inserting */
    $itemToSave->locale_id = $this->pageData['locale_id'];
    $itemToSave->language_id = $this->pageData['language_id'];
    $itemToSave->name = $name;
    $itemToSave->parent_id = $parent_id;
    $itemToSave->isother = 0;
    $itemToSave->status_id = $status_id;
    $itemToSave->ordernum = 0;

    $itemToSave->save();

    /* The item save was SUCCESSFUL, redirect to item listing page.  */
    if($itemToSave->id) {	
      $messages = array(
        Lang::get('site_content_admin.global_admin_Successful_Save'),
                  $this->pageData['success']);
      
      return Redirect::to('admin-category')
        ->with('pageData', $this->pageData)
        ->with('messages', $messages);
    }
    /* The item save FAILED, redirect back and try again */
    else {	
      $messages = array(
        Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
        $this->pageData['error']);
      return Redirect::back()
        ->withInput()
        ->with('pageData', $this->pageData)
        ->withErrors($messages);
    }	

  }	// store()

  /* -----------------------------------------------------------------------
  * destroy(): Mark the item as deleted 
  *             (we rarely truly delete an item to protect data integrity)
  *
  * @param  int  $id
  * @return Response
  *------------------------------------------------------------------------*/
  public function destroy($item_id = 0) { 	
    
    /* protect against invalid IDs */
    App::error(function(ModelNotFoundException $e) {	
      return Redirect::to('admin-category')
        ->with('messages', array(
            Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
            $this->pageData['error']));
    });

    /*--------------------------------------------------------------------*/
    /* Check if there are any product images that exist for this category */
    /*--------------------------------------------------------------------*/
    $violatingProductImages = array();
    
    /* Get any product images matching the category exactly */
    $category = Category::find($item_id); 
    $category_image = Product_image::where('category_id', '=', $category->id )
      ->get()
      ->toArray();

    if(!empty($category_image))
      array_push($violatingProductImages, $category_image[0]);

    /* Get any product images matching the categories, children */
    if($category->parent_id == 0) {
      /* get children */
      $varieties = Category::where('parent_id', '=', $category->id)
        ->get()
        ->toArray();
      
      /* loop through children and see if they have associated product images */
      foreach($varieties as $variety) {
        $violatingImage = 
          Product_image::where('category_id', '=', $variety['id'])
            ->get()
            ->toArray();
        if(!empty($violatingImage))
          array_push($violatingProductImages, $violatingImage[0]);
      }
    }
    $hasProductImages = !empty($violatingProductImages);

    if($hasProductImages){
      return Redirect::back()->withErrors([
      "Cannot Delete Item: There exists product images for the selected
      category or it's sub-categoryies.", "You must first remove the
      category's product images before removing the category itself.", 
      
      "If the category has sub-categories, their product images must also be
      removed"]);
    }

    /* We don't actually delete the item - we keep it in the db with a*/
    /* deleted status code assigned to it, to protect data integrety */
    $itemToDelete=Category::findOrFail($item_id);
    $itemToDelete->ordernum = 0;
    $itemToDelete->status_id='25';
    $itemToDelete->save();

    return Redirect::to('admin-category')
      ->with('messages', array(
        Lang::get('site_content_admin.global_admin_Successful_Delete'),
        $this->pageData['success']));
  } // destroy()

  /* -----------------------------------------------------------------------
  * swap(): Swap the items in the list, changing their order num
  *
  * @param  int  $id
  * @return Response
  *------------------------------------------------------------------------*/
  public function swap($item_id = 0, $swap_id = 0) { 	
    if($item_id == 0 || $swap_id == 0) {
      return Redirect::to('admin-category')
        ->with('messages', array(
          Lang::get('site_content_admin.global_admin_Item_Not_Exist'),
                    $this->pageData['error']));		
    }
    else {
      $currItem = Category::findOrFail($item_id);
      $swapItem = Category::findOrFail($swap_id);
      $temp = $currItem->ordernum;

      $currItem->ordernum = $swapItem->ordernum;
      $currItem->save();

      $swapItem->ordernum = $temp;
      $swapItem->save();

      return Redirect::to('admin-category');
    }
  }	 // swap()
} // class
