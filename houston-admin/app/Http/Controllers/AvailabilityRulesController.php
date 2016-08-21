<?php namespace App\Http\Controllers;

use App\AvailabilityRule;
use App\AvailabilitySlot;
use App\Libraries\Helpers;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class AvailabilityRulesController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $availabilityRules = AvailabilityRule::all();
		$availabilitySlots = AvailabilitySlot::all();
        return view('availability.rules.index',compact('availabilityRules', 'availabilitySlots', 'mode'));
    }

    public function add(){
		$availabilityRules = AvailabilityRule::all();
        $availabilitySlots = AvailabilitySlot::all();
        $mode = 'add';
        return view('availability.rules.index',compact('mode','availabilitySlots', 'availabilityRules'));
    }

    public function postAdd(){
        $limit = Input::get('limit');
        $startDate = Input::get('start_date');
        $endDate = Input::get('end_date');
        $availabilitySlotId = Input::get('availability_slot_id');

        $availabilityRule = new AvailabilityRule;
        $availabilityRule->limit = $limit;
        $availabilityRule->start_date = Helpers::formatDate($startDate);

        $availabilityRule->end_date = Helpers::formatDate($endDate);
        $availabilityRule->availability_slot_id = $availabilitySlotId;

        $input = Input::all();

        $rules = array(
            'limit' => 'required|integer',
            'start_date' => 'required|date_eur',
            'end_date' => 'required|date_eur',
            'availability_slot_id' => 'required',
        );

        $messages = array(
            'limit.required' => 'This limit field is required',
            'start_date.required' => 'This start date field is required',
            'end_date.required' => 'This end date field is required',
            'availability_slot_id.required' => 'This availability slot field is required',
            'limit.integer' => 'Only numbers are allowed on limit field',
            'start_date.date_eur' => 'Enter a valid date for start date',
            'end_date.date_eur' => 'Enter a valid date for end date'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $availabilityRule->save();

            if($availabilityRule->id){
                return redirect("/admin/availability/rules/")
                    ->with('success','Availability rule successfully added');
            }
        }

        return redirect("/admin/availability/rules/")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $availabilitySlots = AvailabilitySlot::all();
        $availabilityRule = AvailabilityRule::find($id);
		$availabilityRules = AvailabilityRule::all();
        $mode = 'edit';
        return view('availability.rules.index',compact('availabilitySlots','availabilityRule', 'availabilityRules', 'mode'));
    }

    public function postEdit($id){

        $limit = Input::get('limit');
        $startDate = Input::get('start_date');
        $endDate = Input::get('end_date');
        $availabilitySlotId = Input::get('availability_slot_id');

        $availabilityRule = AvailabilityRule::find($id);
        $availabilityRule->limit = $limit;
        $availabilityRule->start_date = Helpers::formatDate($startDate);
        $availabilityRule->end_date = Helpers::formatDate($endDate);
        $availabilityRule->availability_slot_id = $availabilitySlotId;

        $input = Input::all();

        $rules = array(
            'limit' => 'required|integer',
            'start_date' => 'required|date_eur',
            'end_date' => 'required|date_eur',
            'availability_slot_id' => 'required',
        );

        $messages = array(
            'limit.required' => 'This limit field is required',
            'start_date.required' => 'This start date field is required',
            'end_date.required' => 'This end date field is required',
            'availability_slot_id.required' => 'This availability slot field is required',
            'limit.integer' => 'Only numbers are allowed on limit field',
            'start_date.date_eur' => 'Enter a valid date for start date',
            'end_date.date_eur' => 'Enter a valid date for end date'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $availabilityRule->save();

            if($availabilityRule->id){
                return redirect("/admin/availability/rules/")
                    ->with('success','Availability rule successfully updated');
            }
        }

        return redirect("/admin/availability/rules/")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $availabilityRule = AvailabilityRule::find($id);
        $id = $availabilityRule->id;

        try {
            $availabilityRule->delete();
        } catch (QueryException $e) {
            return redirect('/admin/availability/rules')->with("error","Availability rule cannot be deleted it is being used by an availability slot");
        }

        return redirect('/admin/availability/rules')->with("success","<b>Availability rule #$id</b> has been deleted successfully");

    }
}