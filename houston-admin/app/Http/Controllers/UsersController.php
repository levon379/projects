<?php namespace App\Http\Controllers;

use App\User;
use App\UsersLanguage;
use App\UserType;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Validator;

class UsersController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

    public function add(){
        $userTypes = UserType::all();
        $mode = 'add';

        $enabled = Input::old('disabled_flag_value', true);

        return view('users.add_edit',compact('userTypes','mode' , 'enabled'));
    }

    public function postAdd(){
        $password = Input::get('password');
        $username = Input::get('username');
        $firstName = Input::get('first_name');
        $lastName = Input::get('last_name');
        $email = Input::get('email');
        $notes = Input::get('notes');
        $telNo = Input::get('tel_no');
        $patentino = Input::get('patentino');
        $ncc = Input::get('ncc');
        $userTypeId = Input::get('user_type_id');
        $enabled = Input::get('disabled');

        $user = new User;
        $user->username = strtolower($username);
        $user->password = Hash::make($password);
        $user->firstname = $firstName;
        $user->lastname = $lastName;
        $user->email = $email;
        $user->notes = $notes;
        $user->tel_no = $telNo;
        $user->patentino = empty($patentino) ? false : true;
        $user->ncc = empty($ncc) ? false : true;
        $user->user_type_id = $userTypeId;
        $user->disabled = empty($enabled) ?  true : false ;

        $language_ids = Input::get('languages');

        $input = Input::all();

        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:8|strong_password'
        );

        $messages = array(
            'user_name.unique' => 'This username is already used',
            'user_name.required' => 'This username field is required',
            'first_name.required' => 'The first name field is required',
            'last_name.required' => 'The last name field is required',
            'email.unique' => 'This email is already used',
            'password.required' => 'The password field is required' ,
            'password.min' => 'The password should be 8 characters or more',
            'password.strong_password' => 'The password should have a number, a letter and a symbol'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $user->save();

            if($user->id){

                // attach language to user
                if(!empty($language_ids)){
                    $user->languages()->attach(explode(",",$language_ids));
                }

                return redirect("/admin/users/")
                    ->with('success','User successfully added');
            }
        }

        return redirect("/admin/users/add")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $user = User::find($id);
        $userTypes = UserType::all();


        $language_list = $user->languages;
        $languages = array();
        foreach($language_list as $language){
            $languages[] = $language->id;
        }
        $language_selection = implode(",",$languages);

        $enabled = Input::old('disabled_flag_value', !($user->disabled));

        $mode = 'edit';
        return view('users.add_edit',compact('user','userTypes','mode','language_selection' ,'enabled'));
    }

    public function postEdit($id){

        $password = Input::get('password');
        $firstName = Input::get('first_name');
        $lastName = Input::get('last_name');
        $email = Input::get('email');
        $notes = Input::get('notes');
        $telNo = Input::get('tel_no');
        $patentino = Input::get('patentino');
        $ncc = Input::get('ncc');
        $userTypeid = Input::get('user_type_id');
        $enabled = Input::get('disabled');

        $user = User::find($id);
        if(!empty($password)){
            $user->password = Hash::make($password);
        }
        $user->firstname = $firstName;
        $user->lastname = $lastName;
        $user->email = $email;
        $user->notes = $notes;
        $user->tel_no = $telNo;
        $user->patentino = empty($patentino) ? false : true;
        $user->ncc = empty($ncc) ? false : true;
        $user->user_type_id = $userTypeid;
        $user->disabled = empty($enabled) ?  true : false ;

        $language_ids = Input::get('languages');

        $input = Input::all();

        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'min:8|strong_password'
        );

        $messages = array(
            'first_name.required' => 'The first name field is required',
            'last_name.required' => 'The last name field is required',
            'email.unique' => 'This email is already used',
            'password.required' => 'The password field is required' ,
            'password.min' => 'The password should be 8 characters or more',
            'password.strong_password' => 'The password should have a number, a letter and a symbol'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $user->save();

            if($user->id){

                if(!empty($language_ids)){
                    $language_ids_old = $user->languages;
                    $language_ids_old_array = [];
                    foreach($language_ids_old as $language){
                        $language_ids_old_array[] = $language->id;
                    }
                    $language_ids = explode(",",$language_ids);
                    $language_ids_old = array_diff($language_ids_old_array,$language_ids);

                    foreach($language_ids_old as $language_id){
                        $user->languages()->detach($language_id);
                    }

                    $language_ids_new = array_diff($language_ids,$language_ids_old_array);

                    foreach($language_ids_new as $language_id){
                        $user->languages()->attach($language_id);
                    }
                } else {
                    if(count($user->languages)>0){
                        $user->languages()->detach();
                    }
                }

                $userlink = "<a href='/admin/users/$id/edit'>$user->username</a>";

                return redirect("/admin/users/")
                    ->with('success',"User $userlink successfully updated");
            }
        }

        return redirect("/admin/users/$id/edit")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $user = User::find($id);
        $userName = $user->username;
        $currUserName = $this->auth->user()->username;

        if($userName == $currUserName){
            return redirect('/admin/users')->with("error","Your account cannot be deleted while you are logged in");
        }

        try {
            UsersLanguage::where('user_id',$user->id)->delete();
            $user->delete();
        } catch (QueryException $e) {
            dd($e);
            return redirect('/admin/users')->with("error","<b>$userName</b> cannot be deleted it is being used by the system");
        }

        return redirect('/admin/users')->with("success","<b>$userName</b> has been deleted successfully");

    }
}