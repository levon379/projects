<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProductImagePlacement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductImagePlacementsServicesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getAll()
	{
        $q = Input::get('q');
        if(empty($q)) {
		    return ProductImagePlacement::all();
        } else {
            return ProductImagePlacement::where('name', 'LIKE', "%$q%")->get();
        }
	}


   public function getPlacement($id){
       return ProductImagePlacement::find($id);
   }
}
