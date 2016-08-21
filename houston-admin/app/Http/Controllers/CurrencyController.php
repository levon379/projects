<?php namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class CurrencyController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $currencyList = Currency::all();
        return view('currency.index',compact('currencyList', 'mode'));
    }

    public function add(){
        $mode = 'add';
        $currencyList = Currency::all();
        return view('currency.index',compact('currencyList', 'mode'));
    }

    public function postAdd(){
        $name = Input::get('name');

        $currency = new Currency;
        $currency->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $currency->save();

            if($currency->id){
                return redirect("/admin/currency/")
                    ->with('success','Currency successfully added');
            }
        }

        return redirect("/admin/currency")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $currency = Currency::find($id);
		$currencyList = Currency::all();
        $mode = 'edit';
        return view('currency.index',compact('currency', 'currencyList', 'mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');

        $currency = Currency::find($id);
        $currency->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $currency->save();

            if($currency->id){
                return redirect("/admin/currency")
                    ->with('success','Currency successfully updated');
            }
        }

        return redirect("/admin/currency")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $currency = Currency::find($id);
        $name = $currency->name;

        try {
            $currency->delete();
        } catch (QueryException $e) {
            return redirect('/admin/currency')->with("error","<b>$name</b> cannot be deleted it is being used by the system");
        }

        return redirect('/admin/currency')->with("success","<b>$name</b> has been deleted successfully");

    }
}