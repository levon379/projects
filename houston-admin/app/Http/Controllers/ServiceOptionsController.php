<?php namespace App\Http\Controllers;

use App\Libraries\Helpers;
use App\Service;
use App\ServiceOption;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class ServiceOptionsController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index($serviceId){
		$service = Service::find($serviceId);
        $serviceOptions = $service->options;
        return view('services.options.index',compact('serviceOptions', 'service'));
    }

    public function add($serviceId){
		$service = Service::find($serviceId);
        $services = Service::all();
        $mode = 'add';
        return view('services.options.add_edit',compact('mode','services', 'service'));
    }

    public function postAdd(){
        $name = Input::get('name');
        $serviceId = Input::get('service_id');
        $unitPrice = Helpers::cleanPrice(Input::get('unit_price'));
		$iva = Helpers::cleanPrice(Input::get('iva'));
        $unitPricePlusIva = Helpers::cleanPrice(Input::get('unit_price_plus_iva'));
        $description = Input::get('description');

        $unitPrice = Helpers::cleanPrice($unitPrice);

        $serviceOption = new ServiceOption;
        $serviceOption->name = $name;
        $serviceOption->service_id = $serviceId;
        $serviceOption->unit_price = $unitPrice;
		$serviceOption->iva = $iva;
		$serviceOption->unit_price_plus_iva = $unitPricePlusIva;
        $serviceOption->description = $description;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
            'service_id' => 'required',
            'unit_price' => 'required' ,
            'description' => 'required'
        );

        $messages = array(
            'name.required' => 'This name field is required',
            'service_id.required' => 'This service field is required',
            'unit_price.required' => 'This unit price field is required',
            'description.required' => 'This description field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $serviceOption->save();

            if($serviceOption->id){
                return redirect("/admin/services/$serviceId/options/")
                    ->with('success','Service option successfully added');
            }
        }

        return redirect("/admin/services/$serviceId/options/add")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $services = Service::all();
        $serviceOption = ServiceOption::find($id);
		$service = $serviceOption->service;
        $mode = 'edit';
        return view('services.options.add_edit',compact('serviceOption','services', 'service', 'mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');
        $serviceId = Input::get('service_id');
        $unitPrice = Helpers::cleanPrice(Input::get('unit_price'));
        $iva = Helpers::cleanPrice(Input::get('iva'));
        $unitPricePlusIva = Helpers::cleanPrice(Input::get('unit_price_plus_iva'));
        $description = Input::get('description');

        $unitPrice = Helpers::cleanPrice($unitPrice);

        $serviceOption = ServiceOption::find($id);
        $serviceOption->name = $name;
        $serviceOption->service_id = $serviceId;
        $serviceOption->unit_price = $unitPrice;
		$serviceOption->iva = $iva;
		$serviceOption->unit_price_plus_iva = $unitPricePlusIva;
        $serviceOption->description = $description;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
            'service_id' => 'required',
            'unit_price' => 'required' ,
            'description' => 'required'
        );

        $messages = array(
            'name.required' => 'This name field is required',
            'service_id.required' => 'This service field is required',
            'unit_price.required' => 'This unit price field is required',
            'description.required' => 'This description field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

            $serviceOption->save();

            if($serviceOption->id){
                return redirect("/admin/services/$serviceId/options/")
                    ->with('success','Service option successfully updated');
            }
        }

        return redirect("/admin/services/options/$id/edit")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $serviceOption = ServiceOption::find($id);
        $name = $serviceOption->name;

        try {
            $serviceOption->delete();
        } catch (QueryException $e) {
            return redirect('/admin/services/options')->with("error","<b>$name</b> cannot be deleted it is being used by a service");
        }

        return redirect('/admin/services/options')->with("success","<b>$name</b> has been deleted successfully");

    }
}