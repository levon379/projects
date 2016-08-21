<?php namespace App\Http\Controllers;

use App\PaymentMethod;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PaymentMethodsServicesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getPaymentMethods(){
        $paymentmethods = PaymentMethod::all();
        $paymentmethod_array = array();
        foreach($paymentmethods as $paymentmethod){
            $paymentmethod_array[] = array(
                'id' => $paymentmethod->id,
                'text' => $paymentmethod->name
            );
        }
        return response()->json($paymentmethod_array);
    }
}


