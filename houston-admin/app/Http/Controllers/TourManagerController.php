<?php namespace App\Http\Controllers;

use App\FeedbackEmail;
use App\Libraries\Gateways\TourManagerGateway;
use App\Libraries\Helpers;
use App\Libraries\Repositories\BookingsRepository;
use App\Libraries\Repositories\TourManagerRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;

class TourManagerController extends Controller {

    public function __construct(TourManagerRepository $tourManagerRepository,BookingsRepository $bookingsRepository)
    {
        $this->tourManagerRepository = $tourManagerRepository;
        $this->bookingRepository = $bookingsRepository;
        $this->tourManagerGateway = new TourManagerGateway($tourManagerRepository);
    }

    public function index(Request $request){
        $pageSize = Input::get('ps',7);
        $page = Input::get('page',1);
        $startDate = Input::get('sd',date('d/m/Y'));
        $filters = Input::get('pp','1,2,3,4');
        $user = Auth::user();

        $data = $this->tourManagerGateway->getTourDates($request,$pageSize,$page,$startDate,$filters,$user);

        return view('tour_manager.index',$data);
    }

    public function details($id){
        $date = Input::get('d');
        $availability = Input::get('a');

        $productTotals = $this->tourManagerRepository->getTotalsByProductAvailabilityAndDate($id,$availability,$date);

        $totals = new \StdClass;
        $totals->id = $id;
        $totals->name = $productTotals->product_name;
        $totals->total_bookings = $productTotals->total_bookings;
        $totals->total_package = (int)$productTotals->total_package;
        $totals->assignment_id = $productTotals->product_assignment_id ?: 0;

        $options = $this->bookingRepository->getBookingsByProductAvailabilityAndDate($id,$availability,$date);

        $guides = $this->tourManagerRepository->getGuidesByProductAvailabilityAndDate($id,$availability,$date);

        return view('tour_manager.details',compact('totals','options','date','guides','date','availability'));
    }

}