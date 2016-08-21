<?php namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class ProfileController extends Controller{

    public function edit(Request $request){
        $id = Auth::user()->id;
        $user = User::find($id);


        $language_list = $user->languages;
        $languages = array();
        foreach($language_list as $language){
            $languages[] = $language->id;
        }
        $language_selection = implode(",",$languages);

        $enabled = $request->old('disabled_flag_value', !($user->disabled));

        return view('profile.edit',compact('user','language_selection' ,'enabled'));
    }

    public function postEdit(Request $request){
        $id = Auth::user()->id;

        $password = $request->input('password');
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $email = $request->input('email');
        $notes = $request->input('notes');
        $telNo = $request->input('tel_no');
        $patentino = $request->input('patentino');
        $ncc = $request->input('ncc');

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

        $language_ids = $request->input('languages');

        $input = $request->all();

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

                return redirect("/admin/profile")
                    ->with('success',"Profile successfully updated");
            }
        }

        return redirect("/admin/profile")->withInput()->withErrors($validation);
    }
}