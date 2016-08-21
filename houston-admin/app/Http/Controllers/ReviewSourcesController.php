<?php namespace App\Http\Controllers;

use App\ReviewSource;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Input;
use Validator;

class ReviewSourcesController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $reviewSources = ReviewSource::all();
        return view('reviews.sources.index',compact('reviewSources','mode'));
    }

    public function add(){
        $mode = 'add';
        $reviewSources = ReviewSource::all();
        return view('reviews.sources.index',compact('reviewSources','mode'));
    }

    public function postAdd(){
        $name = Input::get('name');

        $reviewSource = new ReviewSource;
        $reviewSource->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $reviewSource->save();

            if($reviewSource->id){
                return redirect("/admin/reviews/sources/")
                    ->with('success','Review source successfully added');
            }
        }

        return redirect("/admin/reviews/sources")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $reviewSource = ReviewSource::find($id);
		$reviewSources = ReviewSource::all();
        $mode = 'edit';
        return view('reviews.sources.index',compact('reviewSource', 'reviewSources', 'mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');

        $reviewSource = ReviewSource::find($id);
        $reviewSource->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $reviewSource->save();

            if($reviewSource->id){
                return redirect("/admin/reviews/sources/")
                    ->with('success','Review source successfully updated');
            }
        }

        return redirect("/admin/reviews/sources/")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $reviewSource = ReviewSource::find($id);
        $name = $reviewSource->name;

        try {
            $reviewSource->delete();
        } catch (QueryException $e) {
            return redirect('/admin/reviews/sources')->with("error","<b>$name</b> cannot be deleted it is being used by the system");
        }

        return redirect('/admin/reviews/sources')->with("success","<b>$name</b> has been deleted successfully");

    }
}