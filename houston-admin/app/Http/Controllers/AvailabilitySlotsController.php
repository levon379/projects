<?php namespace App\Http\Controllers;

use App\AvailabilitySlot;
use App\Libraries\Helpers;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class AvailabilitySlotsController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $availabilitySlots = AvailabilitySlot::all();
        return view('availability.slots.index',compact('availabilitySlots','mode'));
    }

    public function add(){
        $mode = 'add';
        return view('availability.slots.index',compact('mode'));
    }

    public function postAdd(Request $request){
        $name = $request->input('name');
        $color = $request->input('color');
        $color = Helpers::makeColor($color);

        $timeOfDays = $request->input('tods');

        $availabilitySlot = new AvailabilitySlot;
        $availabilitySlot->name = $name;
        $availabilitySlot->color = $color;

        $input = $request->all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $availabilitySlot->save();

            if($availabilitySlot->id) {

                if (!empty($timeOfDays)) {
                    $availabilitySlot->timeOfDays()->attach(explode(",",$timeOfDays));
                }

                if ($availabilitySlot->id) {
                    return redirect("/admin/availability/slots")
                        ->with('success', 'Availability slot successfully added');
                }
            }
        }

        return redirect("/admin/availability/slots")->withInput()->withErrors($validation);

    }

    public function edit($id){
		$mode = 'edit';
        $availabilitySlot = AvailabilitySlot::find($id);
        $availabilitySlots = AvailabilitySlot::all();

        $timeOfDaysList = $availabilitySlot->timeOfDays;
        $timeOfDays = array();
        foreach($timeOfDaysList as $timeOfDay){
            $timeOfDays[] = $timeOfDay->id;
        }
        $timeOfDays = implode(",",$timeOfDays);

        return view('availability.slots.index',compact('availabilitySlot','availabilitySlots','mode','timeOfDays'));
    }

    public function postEdit(Request $request,$id){

        $name = $request->input('name');
        $color = $request->input('color');
        $color = Helpers::makeColor($color);

        $timeOfDays = $request->input('tods');

        $availabilitySlot = AvailabilitySlot::find($id);
        $availabilitySlot->name = $name;
        $availabilitySlot->color = $color;

        $input = $request->all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $availabilitySlot->save();

            if($availabilitySlot->id) {

                if(!empty($timeOfDays)){
                    $timeOfDays_old = $availabilitySlot->timeOfDays;
                    $timeOfDays_old_array = [];
                    foreach($timeOfDays_old as $timeOfDay){
                        $timeOfDays_old_array[] = $timeOfDay->id;
                    }
                    $timeOfDays = explode(",",$timeOfDays);
                    $timeOfDays_old = array_diff($timeOfDays_old_array,$timeOfDays);

                    foreach($timeOfDays_old as $timeOfDay){
                        $availabilitySlot->timeOfDays()->detach($timeOfDay);
                    }

                    $timeOfDays_new = array_diff($timeOfDays,$timeOfDays_old_array);

                    foreach($timeOfDays_new as $timeOfDay){
                        $availabilitySlot->timeOfDays()->attach($timeOfDay);
                    }
                } else {
                    if(count($availabilitySlot->timeOfDays)>0){
                        $availabilitySlot->timeOfDays()->detach();
                    }
                }

                if ($availabilitySlot->id) {
                    return redirect("/admin/availability/slots")
                        ->with('success', 'Availability slot successfully updated');
                }
            }
        }

        return redirect("/admin/availability/slots")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $availabilitySlot = AvailabilitySlot::find($id);
        $name = $availabilitySlot->name;


        try {
            $availabilitySlot->delete();
        } catch (QueryException $e) {
            return redirect('/admin/availability/slots')->with("error","<b>$name</b> cannot be deleted it is being used by a product option");
        }

        return redirect('/admin/availability/slots')->with("success","<b>$name</b> has been deleted successfully");

    }
}