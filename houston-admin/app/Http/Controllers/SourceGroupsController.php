<?php namespace App\Http\Controllers;

use App\SourceGroup;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class SourceGroupsController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
        $mode = 'add';
        $sourceGroups = SourceGroup::all();
        return view('sources.groups.index',compact('sourceGroups','mode'));
    }

    public function add(){
        $mode = 'add';
        return view('sources.groups.index',compact('mode'));
    }

    public function postAdd(){
        $name = Input::get('name');

        $sourceGroup = new SourceGroup;
        $sourceGroup->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $sourceGroup->save();

            if($sourceGroup->id){
                return redirect("/admin/sources/groups")
                    ->with('success','Source group successfully added');
            }
        }

        return redirect("/admin/sources/groups")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $sourceGroup = SourceGroup::find($id);
        $sourceGroups = SourceGroup::all();
        $mode = 'edit';
        return view('sources.groups.index',compact('sourceGroup', 'sourceGroups', 'mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');

        $sourceGroup = SourceGroup::find($id);
        $sourceGroup->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $sourceGroup->save();

            if($sourceGroup->id){
                return redirect("/admin/sources/groups")
                    ->with('success','Source group successfully updated');
            }
        }

        return redirect("/admin/sources/groups")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $sourceGroup = SourceGroup::find($id);
        $name = $sourceGroup->name;

        try {
            $sourceGroup->delete();
        } catch (QueryException $e) {
            return redirect('/admin/sources/groups')->with("error","<b>$name</b> cannot be deleted it is being used by a source name");
        }

        return redirect('/admin/sources/groups')->with("success","<b>$name</b> has been deleted successfully");

    }
}