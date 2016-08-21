<?php namespace App\Http\Controllers;

use App\Language;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class LanguagesController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $languages = Language::all();
        return view('languages.index',compact('languages', 'mode'));
    }

    public function add(){
        $mode = 'add';
        $languages = Language::all();
        return view('languages.index',compact('languages', 'mode'));
    }

    public function postAdd(){
        $name = Input::get('name');

        $language = new Language;
        $language->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $language->save();

            if($language->id){
                return redirect("/admin/languages/")
                    ->with('success','Language successfully added');
            }
        }

        return redirect("/admin/languages")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $language = Language::find($id);
		$languages = Language::all();
        $mode = 'edit';
        return view('languages.index',compact('language', 'languages', 'mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');

        $language = Language::find($id);
        $language->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $language->save();

            if($language->id){
                return redirect("/admin/languages/")
                    ->with('success','Language successfully updated');
            }
        }

        return redirect("/admin/languages/")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $language = Language::find($id);
        $name = $language->name;

        try {
            $language->delete();
        } catch (QueryException $e) {
            return redirect('/admin/languages')->with("error","<b>$name</b> cannot be deleted it is being used by the system");
        }

        return redirect('/admin/languages')->with("success","<b>$name</b> has been deleted successfully");

    }
}