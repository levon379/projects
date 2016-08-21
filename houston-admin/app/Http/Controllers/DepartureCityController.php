<?php namespace App\Http\Controllers;

use App\DepartureCity;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class DepartureCityController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $cityList = DepartureCity::all();
        return view('departure_city.index',compact('cityList', 'mode'));
    }

    public function add(){
        $mode = 'add';
        $cityList = DepartureCity::all();
        return view('departure_city.index',compact('cityList', 'mode'));
    }

    public function postAdd(){
        $name = Input::get('name');

        $departureCity = new DepartureCity;
        $departureCity->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $departureCity->save();

            if($departureCity->id){
                return redirect("/admin/departure-city/")
                    ->with('success','Departure City successfully added');
            }
        }

        return redirect("/admin/departure-city/")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $departureCity = DepartureCity::find($id);
		$cityList = DepartureCity::all();
        $mode = 'edit';
        return view('departure_city.index',compact('departureCity','mode', 'cityList'));
    }

    public function postEdit($id){

        $name = Input::get('name');

        $departureCity = DepartureCity::find($id);
        $departureCity->name = $name;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $departureCity->save();

            if($departureCity->id){
                return redirect("/admin/departure-city/")
                    ->with('success','Departure City successfully updated');
            }
        }

        return redirect("/admin/departure-city/")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $departureCity = DepartureCity::find($id);
        $name = $departureCity->name;

        try {
            $departureCity->delete();
        } catch (QueryException $e) {
            return redirect('/admin/departure-city')->with("error","<b>$name</b> cannot be deleted it is being used by the system");
        }

        return redirect('/admin/departure-city')->with("success","<b>$name</b> has been deleted successfully");

    }
}