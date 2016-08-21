<?php namespace App\Http\Controllers;

use App\Promo;
use App\Libraries\Helpers;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PromosServiceController extends Controller {

    public function getPromos(){
        $productId = Input::get('product_id');
        $productOptionId = Input::get("product_option_id");
        $bookingDate = Input::get("booking_date");
        $travelDate = Input::get("travel_date");
        if(!empty($bookingDate)){
            $bookingDate = Helpers::formatDate($bookingDate);    
        }
        if(!empty($travelDate)){
            $travelDate = Helpers::formatDate($travelDate);
        }
        

        /* Table names */
        $promosTable = "promos";
        $promosProductsTable = "promos_products";
        $promosProductsOptionsTable = "promos_products_options";

        if(empty($productId)) return response()->json(array());

        $query = \DB::table($promosTable . " as p")
                ->select(\DB::raw(
                    "p.*"
                    ))
                ->leftJoin($promosProductsTable . " as pp", function($join){
                    $join->on("pp.promo_id", "=", "p.id");
                });
        $query->leftJoin($promosProductsOptionsTable . " as ppo", function($join){
            $join->on("pp.id", "=", "ppo.promo_product_id");
        });

        if(empty($productOptionId)){
            $query->whereRaw("( pp.product_id = {$productId} AND ppo.product_option_id IS NULL)");
        }else{
            $query->where("pp.product_id", "=", $productId);
            $query->whereRaw("( ppo.product_option_id = {$productOptionId} OR ppo.product_option_id IS NULL )");
        }

        if(!empty($travelDate)){
            $query->whereRaw("(p.travel_start_date <= {$travelDate} OR p.travel_start_date IS NULL)");
            $query->whereRaw("(p.travel_end_date >= {$travelDate} OR p.travel_end_date IS NULL)");
        }

        if(!empty($bookingDate)){
            $query->whereRaw("(p.book_start_date <= {$bookingDate} OR p.book_start_date IS NULL)");
            $query->whereRaw("(p.book_end_date >= {$bookingDate} OR p.book_end_date IS NULL)");
        }


        // \DB::enableQueryLog();
        // dd($query->get(), \DB::getQueryLog());

        

        $promos = $query->get();

        $promo_array = array();
        foreach($promos as $promo){
            $promo_array[] = array(
                'id' => $promo->id,
                'text' => $promo->name
            );
        }
        return response()->json($promo_array);
    }

    public function getPromo($id){
        return response()->json(Promo::find($id));
    }

}


