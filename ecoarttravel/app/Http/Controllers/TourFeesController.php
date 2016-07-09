<?php namespace App\Http\Controllers;

use App\TourFee;
use App\Product;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class TourFeesController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $tourFees = TourFee::all();
		$products = Product::all();
        return view('tour_fees.index',compact('tourFees', 'products', 'mode'));
    }

    public function add(){
        $mode = 'add';
        $tourFees = TourFee::all();
		$products = Product::all();
        return view('tour_fees.index',compact('tourFees', 'products', 'mode'));
    }

    public function postAdd(){
        $productId 		= Input::get('product_id');
        $wage 			= Input::get('wage');

        $tourFee = new TourFee;
		$tourFee->product_id = $productId;
        $tourFee->wage 				= $wage;
        

        $input = Input::all();

        $rules = array(
            'product_id' => 'required',
			'wage'	=> 'required'
        );

        $messages = array(
			'product_id.required' => 'This product field is required',
            'wage.required'	=> 'This wage start date field is required'
	   
	   );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $tourFee->save();

            if($tourFee->id){
                return redirect("/admin/tour-fees/")
                    ->with('success','Tour Fee successfully added');
            }
        }

        return redirect("/admin/tour-fees")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $tourFee = TourFee::find($id);
		$mode = 'edit';
        $tourFees = TourFee::all();
		$products = Product::all();
        return view('tour_fees.index',compact('tourFee', 'tourFees', 'products', 'mode'));
    }

    public function postEdit($id){

        $productId 	= Input::get('product_id');
        $wage = Input::get('wage');

        $tourFee = TourFee::find($id);
		$tourFee->product_id = $productId;
        $tourFee->wage = $wage;

        $input = Input::all();

        $rules = array(
            'product_id' => 'required',
			'wage'=> 'required'
        );

        $messages = array(
			'product_id.required' => 'This product field is required',
            'wage.required' => 'This wage start date field is required'
	   
		);


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $tourFee->save();

            if($tourFee->id){
                return redirect("/admin/tour-fees/")
                    ->with('success','Tour Fee successfully updated');
            }
        }

        return redirect("/admin/tour-fees/")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $tourFee = TourFee::find($id);
        $name = $tourFee->name;

        try {
            $tourFee->delete();
        } catch (QueryException $e) {
            return redirect('/admin/tour-fees')->with("error","<b>$name</b> cannot be deleted it is being used by the system");
        }


        return redirect('/admin/tour-fees')->with("success","Tour fee has been deleted successfully");

    }
}