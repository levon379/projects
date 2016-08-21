<?php namespace App\Http\Controllers;

class BlogController extends Controller {

	public function __construct()
	{
		//$this->middleware('auth');
	}

	public function index()
	{
		return view('blog.index');
	}
	
	public function viewBlog($id)
	{
		return view('blog.view');
	}

}
