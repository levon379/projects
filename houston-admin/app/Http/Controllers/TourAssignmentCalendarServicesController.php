<?php namespace App\Http\Controllers;

use App\Libraries\Helpers;
use App\Libraries\Repositories\TourAssignmentCalendarRepository;
use App\User;
use App\UserAvailability;
use App\UserType;
use Illuminate\Http\Request;
use Auth;


class TourAssignmentCalendarServicesController extends Controller {

    public function __construct(TourAssignmentCalendarRepository $tourAssignmentCalendarRepository)
    {
        $this->tourAssignmentCalendarRepository = $tourAssignmentCalendarRepository;
    }

    public function get(Request $request){
        $timestamp = $request->input('from');
        $id = $request->input('id');

        if(empty($id)){
            $id = Auth::user()->id;
        }

        $result = [];

        $user = User::find($id);
        $userType = $user->user_type_id;
        if($userType == UserType::GUIDE){
            $result = $this->tourAssignmentCalendarRepository->getTour($id,$timestamp);
        } else {
            $result = ["success" => 1,"tours" => []];
        }

        return response()->json($result);

    }

    public function addUserAvailability(Request $request){
        $user = $request->input('user');
        $user = Auth::user()->id;
        $tods = $request->input('tods');
        $date = $request->input('date');
        $date = Helpers::formatDate($date);

        foreach($tods as $tod){
            $userAvailability = new UserAvailability();
            $userAvailability->user_id = $user;
            $userAvailability->time_of_day_id = $tod;
            $userAvailability->date = $date;
            $userAvailability->save();
        }
    }

    public function removeUserAvailability(Request $request){
        $date = $request->input('date');
        $date = Helpers::formatDate($date);
        $user = $request->input('user');
        $user = Auth::user()->id;
        $userAvailabilityDates = UserAvailability::where('user_id',$user)->where('date',$date)->get();
        foreach($userAvailabilityDates as $userAvailability){
            $userAvailability->delete();
        }
    }

    public function getUserAvailabilityList(Request $request){
        $startDate = $request->input('sdate');
        $startDate = Helpers::formatDate($startDate);
        $endDate = $request->input('edate');
        $endDate = Helpers::formatDate($endDate);
        $user = $request->input('user');
        $user = Auth::user()->id;
        $uvdates = $this->tourAssignmentCalendarRepository->getUserAvailability($user,$startDate,$endDate);
        return response()->json($uvdates);
    }
}