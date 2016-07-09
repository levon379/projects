<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Language;
use Illuminate\Http\Request;

class LanguagesServicesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getAll()
	{
		return Language::all();
	}


   public function getLanguageInfo($id){
       return Language::find($id);
   }
}
