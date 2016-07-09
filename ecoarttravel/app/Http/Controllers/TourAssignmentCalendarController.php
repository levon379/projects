<?php namespace App\Http\Controllers;

use App\Libraries\Repositories\TourAssignmentCalendarRepository;
use App\ProductAssignedGuide;
use App\UserAvailability;
use App\UserType;
use Carbon\Carbon;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TourAssignmentCalendarController extends Controller{

    public function __construct(Guard $auth, TourAssignmentCalendarRepository $tourAssignmentCalendarRepository){
        $this->auth = $auth;
        $this->tourAssignmentCalendarRepository = $tourAssignmentCalendarRepository;
    }

    public function index(){

        $user = Auth::user();
        $guide = $user->getName();
        $showGuide = false;
        if($user->user_type_id == UserType::GUIDE){
            $showGuide = true;
        }

        return view("tour_assignment_calendar.index",compact("guide","showGuide"));
    }

    public function confirmGuide(Request $request){
        $id = $request->input("id");
        $productAssignedGuide = ProductAssignedGuide::find($id);
        $productAssignedGuide->confirmed = 1;
        $productAssignedGuide->save();
    }
}