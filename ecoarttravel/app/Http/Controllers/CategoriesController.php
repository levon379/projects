<?php namespace App\Http\Controllers;

use App\Category;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class CategoriesController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $categories = Category::all();
        return view('categories.index',compact('categories', 'mode'));
    }

    public function add(){
        $mode = 'add';
        $categories = Category::all();
        return view('categories.index',compact('categories', 'mode'));
    }

    public function postAdd(){
        $name = Input::get('name');

        $category = new Category;
        $category->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $category->save();

            if($category->id){
                return redirect("/admin/categories/")
                    ->with('success','Category successfully added');
            }
        }

        return redirect("/admin/categories")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $category = Category::find($id);
		$categories = Category::all();
        $mode = 'edit';
        return view('categories.index',compact('category', 'categories', 'mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');

        $category = Category::find($id);
        $category->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $category->save();

            if($category->id){
                return redirect("/admin/categories/")
                    ->with('success','Category successfully updated');
            }
        }

        return redirect("/admin/categories/")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $category = Category::find($id);
        $name = $category->name;

        try {
            $category->delete();
        } catch (QueryException $e) {
            return redirect('/admin/categories')->with("error","<b>$name</b> cannot be deleted it is being used by a product");
        }

        return redirect('/admin/categories')->with("success","<b>$name</b> has been deleted successfully");

    }
}