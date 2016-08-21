<?php namespace App\Http\Controllers;

use App\Addon;
use App\AddonsProduct;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Libraries\Repositories\AddonsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AddonsServicesController extends Controller {


    public function __construct(AddonsRepository $addonsRepository){
        $this->addonsRepository = $addonsRepository;
    }

    public function getAddons(){
        $id = Input::get('product_id');
        $addons = AddonsProduct::where('product_id','=',$id)->get();
        $addon_array = array();
        foreach($addons as $addon){
            $addon_array[] = array(
                'id' => $addon->addon_id,
                'text' => $addon->addon->name
            );
        }
        return response()->json($addon_array);
    }


    public function getAddOn($id){
        return response()->json(Addon::find($id));
    }

	public function getAddonChildPrice(){
        return $this->addonsRepository->checkIfPriceIsZero(Input::get('addon_id',0)) ? "true" : "false";
	}

    public function getAddonPromos(){
        dd(Input::all());
    }
}


