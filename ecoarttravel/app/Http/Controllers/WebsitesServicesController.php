<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class WebsitesServicesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getAll()
	{
        $q = Input::get('q');
        if(empty($q)) {
		    return Website::all();
        } else {
            return Website::where('name', 'LIKE', "%$q%")->get();
        }
	}


   public function getWebsiteInfo($id){
       return Website::find($id);
   }
}
