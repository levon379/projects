<?php namespace App\Http\Controllers;


use App\TimeOfDay;

class TimeOfDaysServicesController extends Controller {


    public function getAll()
    {
        return TimeOfDay::all();
    }


    public function getTimeOfDayInfo($id){
        return TimeOfDay::find($id);
    }
}