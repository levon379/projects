<?php namespace App\Http\Controllers;

use App\ServiceType;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class ServiceTypesController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $serviceTypes = ServiceType::all();
        return view('services.types.index',compact('serviceTypes', 'mode'));
    }

    public function add(){
        $mode = 'add';
        $serviceTypes = ServiceType::all();
        return view('services.types.index',compact('serviceTypes', 'mode'));
    }

    public function postAdd(){
        $name = Input::get('name');

        $serviceType = new ServiceType;
        $serviceType->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $serviceType->save();

            if($serviceType->id){
                return redirect("/admin/services/types/")
                    ->with('success','Service type successfully added');
            }
        }

        return redirect("/admin/services/types")->withInput()->withErrors($validation);

    }

    public function edit($id){
		$serviceTypes = ServiceType::all();
        $serviceType = ServiceType::find($id);
        $mode = 'edit';
        return view('services.types.index',compact('serviceType', 'serviceTypes', 'mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');

        $serviceType = ServiceType::find($id);
        $serviceType->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $serviceType->save();

            if($serviceType->id){
                return redirect("/admin/services/types")
                    ->with('success','Service type successfully updated');
            }
        }

        return redirect("/admin/services/types")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $serviceType = ServiceType::find($id);
        $name = $serviceType->name;

        try {
            $serviceType->delete();
        } catch (QueryException $e) {
            return redirect('/admin/services/types')->with("error","<b>$name</b> cannot be deleted it is being used by a service");
        }

        return redirect('/admin/services/types')->with("success","<b>$name</b> has been deleted successfully");

    }
}