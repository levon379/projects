<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Booking;
use Illuminate\Auth\Guard;
use App\User;
use App\Libraries\Gateways\TourManagerGateway;
use App\Libraries\Repositories\TourManagerRepository;
use Illuminate\Http\Request;
use App\Libraries\Repositories\BookingsRepository;

class DashboardController extends Controller {

    public function __construct(TourManagerRepository $tourManagerRepository,BookingsRepository $bookingsRepository)
    {
        $this->tourManagerRepository = $tourManagerRepository;
        $this->bookingRepository = $bookingsRepository;
        $this->tourManagerGateway = new TourManagerGateway($tourManagerRepository);
    }

    public function index(){
        $id = Auth::user()->id;
        $currentuser = User::find($id);
        $pending_booking = Booking::where('pending','=','1')->count();
        $request = new Request;
        $pageSize = date('w');
        $filters = '1,2,3,4';
        $page = 1;
        $startDate = date('d/m/Y');
        $data = $this->tourManagerGateway->getTourDates($request,$pageSize,$page,$startDate,$filters,null,true);
        return view('index',['user'=>$currentuser,'startDate'=>$startDate,'pending_booking_count'=>$pending_booking,'dates'=>$data['dates']]);
    }

    public function login(){
        return view('auth.login');
    }

}