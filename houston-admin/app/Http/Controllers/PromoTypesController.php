<?php namespace App\Http\Controllers;

use App\PromoType;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class PromoTypesController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $promoTypes = PromoType::all();
        return view('promos.types.index',compact('promoTypes','mode'));
    }

    public function add(){
        $mode = 'add';
		$promoTypes = PromoType::all();
        return view('promos.types.index',compact('mode', 'promoTypes'));
    }

    public function postAdd(){
        $name = Input::get('name');

        $promoType = new PromoType;
        $promoType->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $promoType->save();

            if($promoType->id){
                return redirect("/admin/promos/types/")
                    ->with('success','Promo type successfully added');
            }
        }

        return redirect("/admin/promos/types")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $promoType = PromoType::find($id);
		$promoTypes = PromoType::all();
        $mode = 'edit';
        return view('promos.types.index',compact('promoType', 'promoTypes', 'mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');

        $promoType = PromoType::find($id);
        $promoType->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $promoType->save();

            if($promoType->id){
                return redirect("/admin/promos/types/")
                    ->with('success','Promo type successfully updated');
            }
        }

        return redirect("/admin/promos/types/")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $promoType = PromoType::find($id);
        $name = $promoType->name;

        try {
            $promoType->delete();
        } catch (QueryException $e) {
            return redirect('/admin/promos/types')->with("error","<b>$name</b> cannot be deleted it is being used by a promo");
        }

        return redirect('/admin/promos/types')->with("success","<b>$name</b> has been deleted successfully");

    }
}