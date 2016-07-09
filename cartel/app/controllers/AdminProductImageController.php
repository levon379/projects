<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

/* Restful management of product images */
class AdminProductImageController extends \BaseController {

  /*------------------------------------------------------------------------*/
  /* __construct(): default constructor */
  /*------------------------------------------------------------------------*/
  public function __construct() {
    parent::__construct();
    App::error(function(ModelNotFoundException $e) {
        return Response::make('Not Found', 404);
    });
	}	// __construct()
  
  /*-------------------------------------------------------------------------
  * getFormOptions(): 
  *                   Builds the various arrays need to populate the
  *                   SelectBoxes on Post-to, Bid-to and Manual Transaction
  *                   pages
  *                 
  *--------------------------------------------------------------------------
  * @return array of optoins
  *-------------------------------------------------------------------------*/
	public function getFormOptions($pageData) {
    
		$formOptions['productOptions'] = Category::whereRaw("
      locale_id   = ? AND
      language_id = ? AND
      status_id   = ? AND
      parent_id   = ? AND
      isother     = ?",
      array($pageData['locale_id'], $pageData['language_id'], 23, 0, 0))
			->orderBy('name')
			->get(array('id', 'name'));
      
		$formOptions['varietyOptions'] = Category::whereRaw("
      locale_id   = ? AND
      language_id = ? AND
      status_id   = ? AND
      parent_id != ? AND
      isother     = ?",
      array($pageData['locale_id'], $pageData['language_id'], 23, 0, 0))
			->OrderBy('parent_id', 'asc')
			->OrderBy('name', 'asc')
			->get(array('parent_id', 'id', 'name'));
      
		$formOptions['coloursOptions'] = Colour::whereRaw("
      locale_id   = ? AND
      language_id = ? AND
      status_id   = ?",
      array($pageData['locale_id'], $pageData['language_id'],16))
			->OrderBy('name', 'asc')
			->get(array('id', 'name'));
      
		return($formOptions);
	} // getFormOptions()
	
  /*--------------------------------------------------------------------------*/
  /* index(): Show all */
  /*--------------------------------------------------------------------------*/
	public function index() {
    /* Get all product images */
    $product_images = Product_image::get(array(
      'id',
      'category_id', 
      'colour_id', 
      'filename'))->toArray();
    
    foreach($product_images as &$product_image) {
      
      $category = Category::findOrFail($product_image['category_id']);
      $parent_id = $category->parent_id;
      
      /* Category */
      if($category->parent_id == '0'){ 
        $product_image['category_name'] = $category->name;
        $product_image['variety_name'] = "";
      }
      /* Sub Category */
      else{
        $supercategory = Category::find($category->parent_id);
        $product_image['category_name'] = $supercategory->name;
        $product_image['variety_name'] = $category->name;
      }
      
      /* Add variety(product child) name to the product image */
      $product_type = Product_Type::where('parent_id', '=',
                                          $product_image['category_id']);
      
      /* Add colour name to the array product image */
      $colour = Colour::find($product_image['colour_id']);
      $product_image['colour_name'] = $colour->name;
    }
    
    return View::make('admin.product-image.index')
        ->with('product_images', $product_images);
  } // index()
  
  /*--------------------------------------------------------------------------*/
  /* create(): Show a create page */
  /*--------------------------------------------------------------------------*/
  public function create() {
    $formOptions = $this::getFormOptions($this->pageData);
    return View::make('admin.product-image.create-edit')
      ->with('formOptions', $formOptions) ;
  } // create()
  
  /*--------------------------------------------------------------------------*/
  /* store(): Store an image */
  /*--------------------------------------------------------------------------*/
	public function store() {
    $product_id = Input::get('category_id');
    $variety_id = Input::get('variety_id');
    $colour_id = Input::get('colour_id');
    $image = Input::file('image');

    /* Simple Validation rules */
    $rules = array(
      array(
        'Product' => $product_id,
        //'Variety' => $variety_id,
        'Colour' => $colour_id,
        'image' => $image,
      ),
      array(
        'Product' => 'required',
        //'Variety' => $variety_rules,
        'Colour' => 'required',
        'image' => 'image|mimes:png|required',
      )
    );

    $hasChildren = $this->productHasChildren($product_id);
    
    /* Variety is required if the category has child categories */
    if($hasChildren) {
      $rules[0]['Variety'] = 'Variety';
      $rules[1]['Variety'] = 'required';
    }
    
    $category_id = $product_id;
    if($hasChildren)
      $category_id = $variety_id;

    /* Create the validator */
    $validator = Validator::make($rules[0], $rules[1]);
      
    /* Check if the new product_image will be a duplicate */
    $existing_product_image = Product_image::whereRaw('
      category_id = ? AND
      colour_id = ?',
      array($category_id, $colour_id));
    if($existing_product_image->exists()) {
      $validator->addError('Product_Image', 
        'A product image already exists for this product');
    }
    
    /* Check if the product image already exists */
    if($validator->fails())
      return Redirect::to('admin-product-image/create')
        ->withErrors($validator)->withInput();
        
    /* Save the product image in the database */
    $product_image = new Product_image();
    $product_image->category_id = $category_id;
    $product_image->colour_id = $colour_id;
    $product_image->save();
    $product_image->filename = $product_image->id.'.png';
    $product_image->save();
    
    /* Save the image */
    Input::file('image')->move(public_path().'/uplds/productimages', 
      $product_image->id.'.png');

    /* Create a thumbnail for the image */
    $thumb = new Imagick();
    $thumb->readImage(
      public_path().'/uplds/productimages/'.$product_image->id.'.png');
    $thumb->resizeImage(100, 50, Imagick::FILTER_LANCZOS, 1, TRUE);
    $thumb->writeImage(
      public_path().'/uplds/productimages/th-'.$product_image->id.'.png');
    $thumb->clear();
    
    return Redirect::to('admin-product-image/')->with('messages', 'Success');
	}// store()

  /*--------------------------------------------------------------------------*/
  /* edit(): Display Edit page */
  /*--------------------------------------------------------------------------*/
	public function edit($id) {
    $formOptions = $this::getFormOptions($this->pageData);
    $product_image = Product_image::findOrFail($id)->toArray();
    
    /* Get the parent id */
    $category = Category::find($product_image['category_id']);
    $product_image['parent_id'] = $category->parent_id;

    return View::make('admin.product-image.create-edit')
                        ->with('formOptions', $formOptions)
                        ->with('product_image', $product_image)
                        ->with('edit_page', true);
                        
	} // edit()
  
  /*--------------------------------------------------------------------------*/
  /* update(): Accept post data from edit page and update */
  /*--------------------------------------------------------------------------*/
  public function update($id) {
    $product_id = Input::get('category_id');
    $variety_id = Input::get('variety_id');
    $colour_id  = Input::get('colour_id');
    $image      = Input::file('image');
    
    /* Simple Validation rules */
    $rules = array(
      array( 'Product' => $product_id,
             'Colour' => $colour_id,),
      array( 'Product' => 'required',
             'Colour' => 'required',));
    
    /* Image wasn't changed */
    if(Input::hasFile('image') && Input::file('image')->isValid()){ 
      $rules[0]['image'] = $image;
      $rules[1]['image'] = 'image|mimes:png|required';
    }
    
    /* Variety is required if the category has child categories */
    $hasChildren = $this->productHasChildren($product_id);
    if($hasChildren) {
      $rules[0]['Variety'] = 'Variety';
      $rules[1]['Variety'] = 'required';
    }
    
    /* Set the category id to the root category */
    $category_id = $product_id;
    if($hasChildren)
      $category_id = $variety_id;
    
    /* Create the validator */
    $validator = Validator::make($rules[0], $rules[1]);
      
    /* Check if the new product_image will be a duplicate */
    $existing_product_image = Product_image::whereRaw(
      'id != ? AND 
      category_id = ? AND 
      colour_id = ?',
      array($id, $category_id, $colour_id));
    
    if($existing_product_image->exists()) {
      $validator->addError('Product_Image', 
        'A product image already exists for this product');
    }
    
    /* Check if the product image already exists */
    if($validator->fails())
      return Redirect::back()
        ->withErrors($validator)->withInput();
        
    $product_image              = Product_image::find($id);
    $product_image->category_id = $category_id;
    $product_image->colour_id   = $colour_id;
    $product_image->save();

    if(Input::hasFile('image') && Input::file('image')->isValid()){
      $product_image->filename = $product_image->id.'.png';
      $product_image->save();

      /* Delete the old image */
      File::delete(public_path().'/uplds/productimages',
        $product_image->id.'.png');
      
      /* Save the new image */
      Input::file('image')->move(public_path().'/uplds/productimages',
        $product_image->id.'.png');

      /* Create a thumbnail for the image */
      $thumb = new Imagick();
      $thumb->readImage(public_path().
        '/uplds/productimages/'.$product_image->id.'.png');
      $thumb->resizeImage(100, 50, Imagick::FILTER_LANCZOS, 1, TRUE);
      $thumb->writeImage(public_path().
        '/uplds/productimages/th-'.$product_image->id.'.png');
      $thumb->clear();
    }
    
    return Redirect::to('admin-product-image/')
      ->with('messages', ['Edit Successful', $this->pageData['success'] ]);
  } // update()
  
  /*--------------------------------------------------------------------------*/
  /* destroy(): Delete an image */
  /*--------------------------------------------------------------------------*/
	public function destroy($id) { 	
    $product_image = Product_image::findOrFail($id);
    $product_image->delete();
    return Redirect::back()
      ->with('messages', ["Product Image Deleted", $this->pageData['success']]);
	} // destroy()

  /*--------------------------------------------------------------------------*/
  /* productHasChildren(): takes a category id and determins if it is has child
  /*                     categories 
  /*--------------------------------------------------------------------------*/
  public function productHasChildren($product_id) {
    return Category::whereRaw("
      locale_id   = ? AND
      language_id = ? AND
      status_id   = ? AND
      parent_id   = ?",
      array(
        $this->pageData['locale_id'],
        $this->pageData['language_id'],
        23,
        $product_id 
      )
    )->exists();
  } // productHasChildren()
} // class
