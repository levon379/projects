<?php namespace App\Http\Controllers;

use App\PaymentMethod;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class PaymentMethodsController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $paymentMethods = PaymentMethod::all();
        return view('payment_methods.index',compact('paymentMethods','mode'));
    }

    public function add(){
        $mode = 'add';
        return view('payment_methods.index',compact('mode'));
    }

    public function postAdd(){
        $name = Input::get('name');

        $paymentMethod = new PaymentMethod;
        $paymentMethod->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $paymentMethod->save();

            if($paymentMethod->id){
                return redirect("/admin/payment-methods/")
                    ->with('success','Payment methods successfully added');
            }
        }

        return redirect("/admin/payment-methods")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $paymentMethod = PaymentMethod::find($id);
		$paymentMethods = PaymentMethod::all();
        $mode = 'edit';
        return view('payment_methods.index',compact('paymentMethod', 'paymentMethods', 'mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');

        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $paymentMethod->save();

            if($paymentMethod->id){
                return redirect("/admin/payment-methods")
                    ->with('success','Payment methods successfully updated');
            }
        }

        return redirect("/admin/payment-methods")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $paymentMethod = PaymentMethod::find($id);
        $name = $paymentMethod->name;

        try {
            $paymentMethod->delete();
        } catch (QueryException $e) {
            return redirect('/admin/payment-methods')->with("error","<b>$name</b> cannot be deleted it is being used by the system");
        }

        return redirect('/admin/payment-methods')->with("success","<b>$name</b> has been deleted successfully");

    }
}