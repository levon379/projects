<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProductImageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductImageTypesServicesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getAll()
	{
        $q = Input::get('q');
        if(empty($q)) {
		    return ProductImageType::all();
        } else {
            return ProductImageType::where('name', 'LIKE', "%$q%")->get();
        }
	}


   public function getWebsiteInfo($id){
       return ProductImageType::find($id);
   }
}
