<?php namespace App\Http\Controllers;

use App\ProductType;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class ProductTypesController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $productTypes = ProductType::all();
        return view('products.types.index',compact('productTypes', 'mode'));
    }

    public function add(){
        $mode = 'add';
        $productTypes = ProductType::all();
        return view('products.types.index',compact('productTypes', 'mode'));
    }

    public function postAdd(){
        $name = Input::get('name');

        $productType = new ProductType;
        $productType->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $productType->save();

            if($productType->id){
                return redirect("/admin/products/types/")
                    ->with('success','Product type successfully added');
            }
        }

        return redirect("/admin/products/types/")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $productType = ProductType::find($id);
		$productTypes = ProductType::all();
        $mode = 'edit';
        return view('products.types.index',compact('productType','productTypes','mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');

        $productType = ProductType::find($id);
        $productType->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $productType->save();

            if($productType->id){
                return redirect("/admin/products/types")
                    ->with('success','Product type successfully updated');
            }
        }

        return redirect("/admin/products/types")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $productType = ProductType::find($id);
        $name = $productType->name;

        try {
            $productType->delete();
        } catch (QueryException $e) {
            return redirect('/admin/products/types')->with("error","<b>$name</b> cannot be deleted it is being used by a product");
        }

        return redirect('/admin/products/types')->with("success","<b>$name</b> has been deleted successfully");

    }
}