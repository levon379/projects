<?php namespace App\Http\Controllers;

use App\SourceName;
use App\SourceGroup;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;

class SourceNamesController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $sourceNames = SourceName::all();
		$sourceGroups = SourceGroup::all();
        return view('sources.names.index',compact('sourceNames','sourceGroups','mode'));
    }

    public function add(){
        $mode = 'add';
        $sourceNames = SourceName::all();
		$sourceGroups = SourceGroup::all();
        return view('sources.names.index',compact('sourceNames','sourceGroups','mode'));
    }

    public function postAdd(){
        $name = Input::get('name');
        $sourceGroupid = Input::get('sourceGroupid');

        $sourceName = new SourceName;
        $sourceName->name = $name;
        $sourceName->source_group_id = $sourceGroupid;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $sourceName->save();

            if($sourceName->id){
                return redirect("/admin/sources/names/")
                    ->with('success','Source name successfully added');
            }
        }

        return redirect("/admin/sources/names/add")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $sourceName = SourceName::find($id);
		$sourceNames = SourceName::all();
        $sourceGroups = SourceGroup::all();
        $mode = 'edit';
        return view('sources.names.index',compact('sourceName', 'sourceNames', 'sourceGroups','mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');
        $sourceGroupId = Input::get('sourceGroupid');

        $sourceName = SourceName::find($id);
        $sourceName->name = $name;
        $sourceName->source_group_id = $sourceGroupId;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $sourceName->save();

            if($sourceName->id){
                return redirect("/admin/sources/names/")
                    ->with('success','Source name successfully updated');
            }
        }

        return redirect("/admin/sources/names")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $sourcename = SourceName::find($id);
        $name = $sourcename->name;

        try {
            $sourcename->delete();
        } catch (QueryException $e) {
            return redirect('/admin/sources/names')->with("error","<b>$name</b> cannot be deleted it is being used by the system");
        }

        return redirect('/admin/sources/names')->with("success","<b>$name</b> has been deleted successfully");

    }
}