<?php namespace App\Http\Controllers;

use App\Website;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class WebsitesController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $websites = Website::all();
        return view('websites.index',compact('websites','mode'));
    }

    public function add(){
        $mode = 'add';
        return view('websites.index',compact('mode'));
    }

    public function postAdd(){
        $name = Input::get('name');

        $website = new Website;
        $website->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $website->save();

            if($website->id){
                return redirect("/admin/websites/")
                    ->with('success','Source group successfully added');
            }
        }

        return redirect("/admin/websites/")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $website = Website::find($id);
		$websites = Website::all();
        $mode = 'edit';
        return view('websites.index',compact('website', 'websites', 'mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');

        $website = Website::find($id);
        $website->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $website->save();

            if($website->id){
                return redirect("/admin/websites/")
                    ->with('success','Source group successfully updated');
            }
        }

        return redirect("/admin/websites/")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $website = Website::find($id);
        $name = $website->name;

        try {
            $website->delete();
        } catch (QueryException $e) {
            return redirect('/admin/websites')->with("error","<b>$name</b> cannot be deleted it is being used by the system");
        }

        return redirect('/admin/websites')->with("success","<b>$name</b> has been deleted successfully");

    }
}