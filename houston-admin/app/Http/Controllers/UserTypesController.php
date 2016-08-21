<?php namespace App\Http\Controllers;

use App\UserType;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class UserTypesController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $userTypes = UserType::all();
        return view('users.types.index',compact('userTypes', 'mode'));
    }

    public function add(){
        $mode = 'add';
        $userTypes = UserType::all();
        return view('users.types.index',compact('userTypes', 'mode'));
    }

    public function postAdd(){
        $name = Input::get('name');

        $userType = new UserType;
        $userType->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $userType->save();

            if($userType->id){
                return redirect("/admin/users/types/")
                    ->with('success','User type successfully added');
            }
        }

        return redirect("/admin/users/types")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $userType = UserType::find($id);
		$userTypes = UserType::all();
        $mode = 'edit';
        return view('users.types.index',compact('userType', 'userTypes', 'mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');

        $userType = UserType::find($id);
        $userType->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $userType->save();

            if($userType->id){
                return redirect("/admin/users/types")
                    ->with('success','User type successfully updated');
            }
        }

        return redirect("/admin/users/types")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $userType = UserType::find($id);
        $name = $userType->name;

        try {
            $userType->delete();
        } catch (QueryException $e) {
            return redirect('/admin/users/types')->with("error","<b>$name</b> cannot be deleted it is being used by the system");
        }

        return redirect('/admin/users/types')->with("success","<b>$name</b> has been deleted successfully");

    }
}