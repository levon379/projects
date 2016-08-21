<?php namespace App\Http\Controllers;


use App\AvailabilitySlotDateLimit;
use App\Libraries\Helpers;
use App\Libraries\Repositories\TourManagerRepository;
use App\ProductAssignedComment;
use App\ProductAssignedGuide;
use App\ProductAssignedService;
use App\ProductAssignment;
use App\ProductOptionLanguageUnavailableDay;
use App\Service;
use App\ServiceOption;
use App\ServiceType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class TourManagerServicesController extends Controller {

    public function __construct(TourManagerRepository $tourManagerRepository)
    {
        $this->tourManagerRepository = $tourManagerRepository;
    }

    public function get(){
        $date = Input::get('date');
        $total_bookings = Input::get('total_bookings');
        $filters = Input::get('filters');
        $result = $this->tourManagerRepository->getColumn($date,$total_bookings,$filters);
        return response()->json($result);
    }

    public function getAll(){
        $dates = $this->tourManagerRepository->getDates();

        $output = array();

        foreach($dates->dates as $date){
            $output[] = $this->tourManagerRepository->getColumn($date->date,$date->total_bookings);
        }

        dd($output);
    }

    public function getServices(){
        $serviceOptionId = Input::get('service_option_id');
        $serviceTypeId = Input::get('service_type_id');
        $serviceOption = ServiceOption::find($serviceOptionId);
        $serviceId = $serviceOption->service_id;
        $serviceOptions = ServiceOption::where("service_id",$serviceId)->lists('name','id');
        $services = Service::where("service_type_id",$serviceTypeId)->lists('name','id');
        $serviceTypes = ServiceType::all()->lists('name','id');

        $output = [
            "service_types" => $serviceTypes,
            "service_company" => $services,
            "service_options" => $serviceOptions
        ];

        return $output;
    }


    public function getServicesTypes(){
        $serviceTypes = ServiceType::all();
        $list = [];
        foreach($serviceTypes as $sn){
            $list[] = array(
                'id' => $sn->id,
                'text' => $sn->name,
            );
        }
        return response()->json($list);
    }

    //company
    public function getServicesByType(){
        $serviceTypeId = Input::get('service_type_id');
        $services = Service::where("service_type_id",$serviceTypeId)->get();
        $list = [];
        foreach($services as $sn){
            $list[] = array(
                'id' => $sn->id,
                'text' => $sn->name,
            );
        }
        return response()->json($list);
    }

    // service option
    public function getServiceOptionByService(){
        $serviceId = Input::get('service_id');
        $serviceOptions = ServiceOption::where("service_id",$serviceId)->get();
        $list = [];
        foreach($serviceOptions as $sn){
            $list[] = array(
                'id' => $sn->id,
                'text' => $sn->name,
            );
        }
        return response()->json($list);
    }

    public function updateNote(){
        $commentId =  Input::get('id',0);
        $assign = Input::get('assign',0);
        $commentText = Input::get('comment');
        $date = Input::get('date');
        $product = Input::get('product');
        $avail = Input::get('avail');

        if($commentId >= 0){
            $comment = ProductAssignedComment::find($commentId);
        }

        if(empty($comment)){
            if($assign < 1) {
                $productAssign = new ProductAssignment;
                $productAssign->product_id = $product;
                $productAssign->availability_slot_id = $avail;
                $productAssign->date = $date;
                $productAssign->save();
                $assign = $productAssign->id;
            }
            $comment = new ProductAssignedComment;
            $comment->user_id = Auth::user()->id;
            $comment->product_assignment_id = $assign;
        }

        $comment->comment = $commentText;

        $comment->save();

        $arr = [
            'time' => Carbon::parse($comment->created_at)->diffForHumans(),
            'name' => $comment->user->getName(),
            'id' => $comment->id
        ];

        return response()->json($arr);


    }

    public function deleteNote(){
        $commentId =  Input::get('id',0);
        $comment = ProductAssignedComment::find($commentId);
        $comment->delete();
    }

    public function updateLimit(){
        $availabilitySlotId = Input::get('avail');
        $date = Input::get('date');
        $limit = Input::get('limit');

        if($limit === ''){
            $limit = null;
        }

        $values = compact('availabilitySlotId','date','limit');

        Log::info($values);

        $limitOverride = AvailabilitySlotDateLimit::where('availability_slot_id',$availabilitySlotId)->where('date',$date)->first();

        if(empty($limitOverride)){
            $limitOverride = new AvailabilitySlotDateLimit;
            $limitOverride->date = $date;
            $limitOverride->availability_slot_id = $availabilitySlotId;
        }
        $limitOverride->limit = $limit;
        $limitOverride->save();

    }

    public function updateOption(){
        $pol = Input::get('pol');
        $date = Input::get('date');
        $block =  Input::get('block',0);

        $productOptionsLanguageUnavailableDays = ProductOptionLanguageUnavailableDay::where('product_options_language_id',$pol)->where('date',$date)->first();

        if($block){
            if(empty($productOptionsLanguageUnavailableDays)){
                $productOptionsLanguageUnavailableDays = new ProductOptionLanguageUnavailableDay;
                $productOptionsLanguageUnavailableDays->product_options_language_id = $pol;
                $productOptionsLanguageUnavailableDays->date = $date;
                $productOptionsLanguageUnavailableDays->save();
            }
        } else {
            if(!empty($productOptionsLanguageUnavailableDays)){
                $productOptionsLanguageUnavailableDays->delete();
            }
        }
    }

    public function updateGuides(){
        $guides = Input::get('guides',[]);
        $assignId = Input::get('assign',0);
        $productId = Input::get('product',0);
        $availabilitySlotId = Input::get('avail',0);
        $date = Input::get('date');

        $guide_ids = [];

        foreach($guides as $guide){
            $guide_ids[] = $guide['id'];
        }


        if(!empty($guide_ids)){

            if(empty($assignId)){

                $assignment = ProductAssignment::where('product_id',$productId)->where('availability_slot_id',$availabilitySlotId)->where('date',$date)->first();
                if(empty($assignment)){
                    $assignment = new ProductAssignment;
                    $assignment->product_id = $productId;
                    $assignment->availability_slot_id = $availabilitySlotId;
                    $assignment->date = $date;
                    $assignment->save();
                }

                $assignId = $assignment->id;

            }

            $guide_ids_old_array = ProductAssignedGuide::where('product_assignment_id',$assignId)->lists('guide_user_id');

            $guide_ids_old = array_diff($guide_ids_old_array,$guide_ids);

            ProductAssignedGuide::where('product_assignment_id',$assignId)->whereIn('guide_user_id',$guide_ids_old)->delete();

            $guide_ids_new = array_diff($guide_ids,$guide_ids_old_array);

            foreach($guide_ids_new as $id){
                $guide = $guides[Helpers::searchForId($id,$guides)];
                $productAssignedGuide = new ProductAssignedGuide;
                $productAssignedGuide->product_assignment_id = $assignId;
                $productAssignedGuide->guide_user_id = $guide['id'];
                $productAssignedGuide->user_id = Auth::user()->id;
                $productAssignedGuide->confirmed = $guide['active'];
                $productAssignedGuide->save();
            }

            $guide_ids_up = array_intersect($guide_ids,$guide_ids_old_array);

            foreach($guide_ids_up as $id){
                $guide = $guides[Helpers::searchForId($id,$guides)];
                $productAssignedGuide = ProductAssignedGuide::where('product_assignment_id',$assignId)->where('guide_user_id',$guide['id'])->first();
                $productAssignedGuide->confirmed = $guide['active'];
                $productAssignedGuide->save();
            }

        } else {
            if(!empty($assignId)){
                ProductAssignedGuide::where('product_assignment_id',$assignId)->delete();
            }
        }

    }

    public function getprice(){
        $id = Input::get('id',0);
        $serviceOption = ServiceOption::find($id);
        if(!empty($serviceOption)){
            $total = floatval($serviceOption->unit_price) + floatval($serviceOption->iva);
            //$total = number_format((float)$total, 2, '.', '');
            return $total;
        }
        return 0.00;
    }


    public function updateService(){
        $id = Input::get('id',0);
        $quantity = Input::get('quantity');
        $assign = Input::get('assign',0);
        $option = Input::get('option');
        $price = Input::get('price');
        $date = Input::get('date');
        $product = Input::get('product');
        $avail= Input::get('avail');

        $arr = compact('id','assign','option','quantity','price');
        //Log::info($arr);

        // 0 - update, 1 - add
        $mode = 0;

        if($id){
            $service = ProductAssignedService::find($id);
        } else {
            $service = ProductAssignedService::where('product_assignment_id',$assign)->where('service_option_id',$option)->first();
        }

        if(empty($service)){
            $mode = 1;
            if($assign < 1) {
                $productAssign = new ProductAssignment;
                $productAssign->product_id = $product;
                $productAssign->availability_slot_id = $avail;
                $productAssign->date = $date;
                $productAssign->save();
                $assign = $productAssign->id;
            }
            $service = new ProductAssignedService;
            $service->product_assignment_id = $assign;
            $service->user_id = Auth::user()->id;
        }

        $service->service_option_id = $option;
        $service->quantity = $quantity;
        if(!empty($price)){
            $service->total_price = Helpers::cleanPrice($price);
        } else {
            $service->total_price = null;
        }
        $service->save();

        $data = [
            "id" => $service->id,
            "option_id" => $service->serviceOption->id,
            "option_name" => $service->serviceOption->name,
            "type_id" => $service->serviceOption->service->service_type_id,
            "service_id" => $service->serviceOption->service->id,
            "service_name" => $service->serviceOption->service->name,
            "quantity" => $service->quantity,
            "unit_price" => $service->serviceOption->unit_price,
            "total_price" => $service->total_price,
            "iva" => $service->serviceOption->iva,
            "assign_id" => $assign,
            "mode" => $mode
        ];

        return response()->json($data);
    }


    public function deleteService(){
        $id = Input::get('id',0);
        $service = ProductAssignedService::find($id);
        $service->delete();
    }
}