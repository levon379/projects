<?php namespace App\Http\Controllers;

use App\Service;
use App\ServiceType;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class ServicesController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
        $services = Service::all();
        return view('services.index',compact('services'));
    }

    public function add(){
        $serviceTypes = ServiceType::all();
        $mode = 'add';
        return view('services.add_edit',compact('mode','serviceTypes'));
    }

    public function postAdd(){
        $name = Input::get('name');
        $serviceTypeId = Input::get('service_type_id');
        $contactName = Input::get('contact_name');
        $contactTel = Input::get('contact_tel');
        $vatNo = Input::get('vat_no');
        $email = Input::get('email');
        $addressLine1 = Input::get('address_line_1');
        $addressLine2 = Input::get('address_line_2');
		$city = Input::get('city');
		$stateProvince = Input::get('state_province');
		$country = Input::get('country');
		$zip = Input::get('zip');
		$notes = Input::get('notes');

        $service = new Service;
        $service->name = $name;
        $service->service_type_id = $serviceTypeId;
        $service->contact_name = $contactName;
        $service->contact_tel = $contactTel;
        $service->vat_no = $vatNo;
        $service->email = $email;
		$service->address_line_1 = $addressLine1;
		$service->address_line_2 = $addressLine2;
		$service->city = $city;
		$service->state_province = $stateProvince;
		$service->country = $country;
		$service->zip = $zip;
		$service->notes = $notes;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
            'service_type_id' => 'required',
            'contact_name' => 'required' ,
            'contact_tel' => 'required',
			'address_line_1' => 'required',
			'state_province' => 'required',
			'country' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required',
            'service_type_id.required' => 'This service type field is required',
            'contact_name.required' => 'This contact name field is required',
            'contact_tel.required' => 'This contact telephone number field is required',
			'address_line_1.required' => 'This address line 1 field is required',
			'state_province.required' => 'This state/province field is required',
			'country.required' => 'This country field is required',
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $service->save();

            if($service->id){
                return redirect("/admin/services/")
                    ->with('success','Service successfully added');
            }
        }

        return redirect("/admin/services/add")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $serviceTypes = ServiceType::all();
        $service = Service::find($id);
        $mode = 'edit';
        return view('services.add_edit',compact('service','serviceTypes','mode'));
    }

    public function postEdit($id){

        $name = Input::get('name');
        $serviceTypeId = Input::get('service_type_id');
        $contactName = Input::get('contact_name');
        $contactTel = Input::get('contact_tel');
        $vatNo = Input::get('vat_no');
        $email = Input::get('email');
		$addressLine1 = Input::get('address_line_1');
        $addressLine2 = Input::get('address_line_2');
		$city = Input::get('city');
		$stateProvince = Input::get('state_province');
		$country = Input::get('country');
		$zip = Input::get('zip');
		$notes = Input::get('notes');

        $service = Service::find($id);
        $service->name = $name;
        $service->service_type_id = $serviceTypeId;
        $service->contact_name = $contactName;
        $service->contact_tel = $contactTel;
        $service->vat_no = $vatNo;
        $service->email = $email;
		$service->notes = $notes;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
            'service_type_id' => 'required',
            'contact_name' => 'required' ,
            'contact_tel' => 'required',
			'address_line_1' => 'required',
			'state_province' => 'required',
			'country' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required',
            'service_type_id.required' => 'This service type field is required',
            'contact_name.required' => 'This contact name field is required',
            'contact_tel.required' => 'This contact telephone number field is required',
			'address_line_1.required' => 'This address line 1 field is required',
			'state_province.required' => 'This state/province field is required',
			'country.required' => 'This country field is required',
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $service->save();

            if($service->id){
				
				$service = "<a href='/admin/services/$id/edit'>$service->name</a>";

                return redirect("/admin/services")
                    ->with('success',"Service $service successfully updated");
            }
        }

        return redirect("/admin/services/$id/edit")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $service = Service::find($id);
        $name = $service->name;

        try {
            $service->delete();
        } catch (QueryException $e) {
            return redirect('/admin/services')->with("error","<b>$name</b> cannot be deleted it is being used by the system");
        }

        return redirect('/admin/services')->with("success","<b>$name</b> has been deleted successfully");

    }
}