<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;

use Illuminate\Support\Facades\Input;

class CategoriesServicesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getAll()
	{
        $q = Input::get('q');
        if(empty($q)) {
		    return Category::all();
        } else {
            return Category::where('name', 'LIKE', "%$q%")->get();
        }
	}


   public function getCategoryInfo($id){
       return Category::find($id);
   }
}
