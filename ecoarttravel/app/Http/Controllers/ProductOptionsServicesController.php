<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Libraries\Repositories\ProductOptionsRepository;
use App\ProductOption;
use Illuminate\Support\Facades\Input;

class ProductOptionsServicesController extends Controller {


    public function __construct(ProductOptionsRepository $productOptionsRepository){
        $this->productOptionsRepository = $productOptionsRepository;
    }

    public function getAll($id = 0)
    {
        $query = Input::get('q');
        $languageIds = Input::get('languages');
        $name = Input::get('name');

        if(empty($name)){
            $productOptions = $this->productOptionsRepository->getProductOptionsForPackage($id,$languageIds,$query);
        } else {
            $productOption = ProductOption::find($id);
            return response()->json([
                'id' => $productOption->id,
                'name' => $productOption->name,
            ]);
        }

        $result = array();

        foreach($productOptions as $productOption){
            $result[] = [
                'id' => $productOption->id,
                'name' => $productOption->getProductOptionName(),
            ];
        }

        return response()->json($result);
    }


    public function getProductOptionsInfo($id){
        $productOption = ProductOption::find($id);

        $result = [
            'id' => $productOption->id,
            'name' => $productOption->getProductOptionName()
        ];

        return response()->json($result);
    }

    public function getProductOptionsByProductIdLanguageIdAndDate(){
        $id = Input::get('product_id');
        $languageId = Input::get('language_id');
        $travelDate = Input::get('travel_date');
        $bookingDate = Input::get('booking_date');
		$name = Input::get('name');

        $productOptions = $this->productOptionsRepository->getProductOptionsByProductLanguageDates($id,$languageId,$bookingDate,$travelDate);

        $options = [];
        foreach($productOptions as $po){
            $options[] = array(
                'id' => $po->id,
                'text' => empty($name) ? $po->getNameWithFromTo() : $po->name,
            );
        }
        return response()->json($options);
    }
	
	public function getProductOptionChildPrice(){
		return $this->productOptionsRepository->checkIfPriceIsZero(Input::get('product_option_id',0)) ? "true" : "false";
	}
}
