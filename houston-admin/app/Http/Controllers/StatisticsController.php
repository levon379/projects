<?php namespace App\Http\Controllers;

use App\Product;
use App\ProductOption;
use App\PaymentMethod;
use App\SourceGroup;
use App\SourceName;

class StatisticsController extends Controller {

    protected $statisticsRepository;

    public function __construct(\App\Libraries\Repositories\StatisticsRepository $statisticsRepository)
    {
        $this->statisticsRepository = $statisticsRepository;
    }

    public function index(){
        /* Query the database and fetch the form input fields data */
        $products = Product::all();
		$productOptions = ProductOption::all();
		$paymentMethods = PaymentMethod::all();
		$sourceGroups = SourceGroup::all();
		$sourceNames = SourceName::all();

        /* Fields from include data box */
        /* These options determine what data to include */
        $dataOptions = array(
            "bookingDateFrom" => \Input::get("bf"),
            "bookingDateTo" => \Input::get("bt"),
            "travelDateFrom" => \Input::get("tf"),
            "travelDateTo" => \Input::get("tt"),
            "productId" => \Input::get("pd"),
            "productOptionId" => \Input::get("po"),
            "paymentMethodId" => \Input::get("pm"),
            "isPaid" => \Input::get("pa"),
            "sourceGroupId" => \Input::get("sg"),
            "sourceNameId" => \Input::get("sn"),
            "includePackages" => \Input::get("pk", 1),
            );
        /* These Options determine the type of graph */
        $graphOptions = array(
            "xAxis" => \Input::get("xa"),
            "yAxis" => \Input::get("ya"),
            "data" => \Input::get("dt"),
            "btd" => \Input::get("btd") // not sure what to do about this
            );
        // get the data for the graph
        $data = $this->statisticsRepository->generateGraph($dataOptions, $graphOptions);

        return view('statistics.index',compact('products', 'productOptions', 'paymentMethods', 'sourceGroups', 'sourceNames', 'graphData', 'dataOptions', 'yAxis', 'data'));
    }

    public function login(){
        return view('auth.login');
    }

    

}