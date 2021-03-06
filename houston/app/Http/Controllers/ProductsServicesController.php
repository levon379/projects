<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Libraries\Repositories\ProductsRepository;

use App\Product;
use Illuminate\Support\Facades\Input;

class ProductsServicesController extends Controller {

    public function getProductsByLanguageIdAndDates(ProductsRepository $productsRepository){
        $languageId = Input::get('language_id');
        $travelDate = Input::get('travel_date');
        $bookingDate = date('d/m/Y');

        $products = $productsRepository->getProductsByProductOptionLanguageDates($languageId,$bookingDate,$travelDate);

        $result = [];

        foreach($products as $product){
            $result[] = [
                'id' => $product->id,
                'text' => $product->name
            ];
        }

        return json_encode($result);
    }

    public function getProductInfo($id){
        $product = Product::find($id);

        $result =  [
            'id' => $product->id,
            'text' => $product->name
        ];

        return json_encode($result);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getAll(){
        $products = Product::all();
        $product_array = array();
        foreach($products as $product){
            $product_array[] = array(
                'id' => $product->id,
                'text' => $product->name
            );
        }
        return json_encode($product_array);
    }
}

