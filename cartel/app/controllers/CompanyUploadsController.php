<?php
class CompanyUploadsController extends \BaseController {
  public $adminVars;
  
  /*------------------------------------------------------------------------*/
  /* __construct(): default constructor */
  /*------------------------------------------------------------------------*/
  public function __construct() {
    parent::__construct();
		$this->adminVars['adminURI']       = 'admin-company';

	}
    
        public function index($company_id)
        {
           $company_files = CompanyUploads::getCompanyUploads($company_id);
           $files = array();
           foreach ($company_files as $key=>$value){
             $files[] = $value;
           }

           return View::make('admin.company-uploads.index')
			->with('view', 'index')
			->with('adminVars', $this->adminVars)
			->with('company_id', $company_id)
                        ->with('items', $company_files);
        }
        public function show($company_id,$item_id)
        {
          $item = CompanyUploads::getCompanyFile($item_id);
          return View::make('admin.company-uploads.index')
			->with('view', 'edit')
			->with('company_id', $company_id)
			->with('item', $item)
			->with('adminVars', $this->adminVars);
        }//Show each file for company
        
        public function store($company_id = 0)
        {
            $file        = Input::file('file');
            $file_name = "";
            if(Input::hasFile('file')){
              $file_name   = Input::file('file')->getClientOriginalName();
            }
            $name        = Input::get('file_name', '');
            $description = Input::get('file_desc', '');
            $data_store = array('name'=>$name,'description'=>$description,'filename'=>$file_name,'company_id'=>$company_id);
            $return_id = CompanyUploads::storeCompanyFile($data_store);
            $destinationPath = 'uplds/companyuploads'; // upload path
            $fileName = $return_id.'-'.$file_name; // renameing image
            if (Input::hasFile('file'))
            {
                $upload = Input::file('file')->move($destinationPath, $fileName);
            }
            
            return Redirect::back()
                ->with('messages', ["Product Image Uploaded", $this->pageData['success']]);
             
        }//Store new file for company
        
        /*I don't know we have need for this function*/
        public function edit($company_id,$item_id)
        {
            $file        = Input::file('file');
            $file_name = "";
            if(Input::hasFile('file')){
              $file_name   = Input::file('file')->getClientOriginalName();
            }
            $name        = Input::get('file_name', '');
            $description = Input::get('file_desc', '');
            if($file_name != "")
            {
              $data_store = array('name'=>$name,'description'=>$description,'filename'=>$file_name,'company_id'=>$company_id);
            }else{
              $data_store = array('name'=>$name,'description'=>$description,'company_id'=>$company_id);
            }
            $file_info = CompanyUploads::getCompanyFile($item_id);
            CompanyUploads::updateCompanyFile($item_id,$data_store);
            $destinationPath = 'uplds/companyuploads'; // upload path
            $fileName = $item_id.'-'.$file_name; // renameing image
            if (Input::hasFile('file'))
            {
                unlink(public_path().'/uplds/companyuploads/'.$item_id.'-'.$file_info->filename);
                $upload = Input::file('file')->move($destinationPath, $fileName);
            }
          
             return Redirect::to('admin-company/'.$company_id.'/uploads')
                ->with('messages', ["Product Image Uploaded", $this->pageData['success']]);
        }

        public function destroy($company_id,$item_id) { 
            $product_image = CompanyUploads::findOrFail($item_id);
            //$product_image->delete();
            //File::delete(public_path().'/uplds/companyuploads',$id.'-'.$product_image->filename);
           
            unlink(public_path().'/uplds/companyuploads/'.$item_id.'-'.$product_image->filename);
            $product_image->delete();
              return Redirect::back()
                ->with('messages', ["Product Image Deleted", $this->pageData['success']]);
              } // destroy()
} // class
