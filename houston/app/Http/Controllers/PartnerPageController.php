<?php namespace App\Http\Controllers;

class PartnerPageController extends Controller {

	public function __construct()
	{
		//$this->middleware('auth');
	}

	public function index()
	{
		return view('partner_page.index');
	}
	

}
