<?php namespace App\Libraries\Repositories;

class StatisticsRepository{

    public $columnNames = array(
        "pr" => "product_id",

        );

    public function generateGraph($dataOptions, $graphOptions){
        // return false;
        $bookingTable = "bookings";
        $productOptionsTable = "product_options";
        $productTable = "products";
        $sourceNamesTable = "source_names";
        $sourceGroupTable = "source_groups";
        $paymentMethodsTable = "payment_methods";
        
        if($graphOptions["xAxis"] == "mn"){
            $format = "%m-%Y";
        }elseif($graphOptions["xAxis"] == "yr"){
            $format = "%Y";
        }else{
            $format = "%d-%m-%Y";
        }
        
        // needs to be updated for all options
        if($graphOptions["data"] == "1"){
            $data = "SUM(b.total_paid) as all_paid , ";
        }else{
            $data = "SUM(b.total_pax) as all_pax , ";
        }

        $query = \DB::table($bookingTable . " as b")
                ->select(\DB::raw(
                    "b.*, DATE_FORMAT(b.created_at, '{$format}') as booking_date, 
                    {$data} p.id as product_id ,p.name as product_name, 
                    p.provider_id, p.start_times, 
                    p.departure_city_id, p.default_price, 
                    po.name as product_option_name, po.start_time, 
                    po.end_time, po.adult_price, sn.name as source_name, 
                    sn.source_group_id, sg.name as source_group_name,
                    pm.name as payment_method_name"
                    ))
                ->leftJoin($productOptionsTable . " as po", function($join){
                    $join->on("po.id", "=", "b.product_option_id");
                })->leftJoin($productTable . " as p", function($join){
                    $join->on("po.product_id", "=", "p.id");
                })->leftJoin($sourceNamesTable . " as sn", function($join){
                    $join->on("sn.id", "=", "b.source_name_id");
                })->leftJoin($sourceGroupTable . " as sg", function($join){
                    $join->on("sg.id", "=", "sn.source_group_id");
                })->leftJoin($paymentMethodsTable . " as pm", function($join){
                    $join->on("pm.id", "=", "b.payment_method_id");
                });

        // all the options from the data selection fields
        // have there respected where clauses here

        if($dataOptions["bookingDateFrom"]){
            $query->where("b.created_at", ">", $this->getMysqlDate($dataOptions["bookingDateFrom"]));
        }
        if($dataOptions["bookingDateTo"]){
            $query->where("b.created_at", "<", $this->getMysqlDate($dataOptions["bookingDateTo"]));
        }
        if($dataOptions["travelDateFrom"]){
            $query->where("b.travel_date", ">", $this->getMysqlDate($dataOptions["travelDateFrom"], "j/m/Y", "Y-m-d"));
        }
        if($dataOptions["bookingDateTo"]){
            $query->where("b.travel_date", "<", $this->getMysqlDate($dataOptions["bookingDateTo"], "j/m/Y", "Y-m-d"));
        }
        if($dataOptions["productOptionId"]){
            $query->where("b.product_option_id", $dataOptions["productOptionId"]);
        }
        if($dataOptions["sourceGroupId"]){
            $query->where("sg.id", "=", $dataOptions["sourceGroupId"]);
        }
        if($dataOptions["isPaid"] !== null && $dataOptions["isPaid"] !== ""){
            $query->where("b.paid_flag", "=", $dataOptions["isPaid"]);
        }
        if($dataOptions["paymentMethodId"]){
            $query->where("b.payment_method_id", "=", $dataOptions["paymentMethodId"]);
        }
        if($dataOptions["sourceNameId"]){
            $query->where("b.source_name_id", "=", $dataOptions["sourceNameId"]);
        }
        if($dataOptions["productId"]){
            $query->where("p.id", "=", $dataOptions["productId"]);
        }

        /* Grouping the data here from graphing options */

        if($graphOptions["yAxis"] == "pr"){
            $query->groupBy("po.product_id");
        }elseif($graphOptions["yAxis"] == "po"){
            $query->groupBy("b.product_option_id");
        }elseif($graphOptions["yAxis"] == "sg"){
            $query->groupBy("sn.source_group_id");
        }elseif($graphOptions["yAxis"] == "sn"){
            $query->groupBy("b.source_name_id");
        }elseif($graphOptions["yAxis"] == "pm"){
            $query->groupBy("b.payment_method_id");
        }


        if($graphOptions["xAxis"] == "mn"){
            $query->groupBy(\DB::raw("MONTH(b.created_at)"));
        }elseif($graphOptions["xAxis"] == "yr"){
            $query->groupBy(\DB::raw("YEAR(b.created_at)"));
        }

        $query->orderBy("b.created_at", "ASC");

        \DB::enableQueryLog();
        $data = $query->get();

        // dd($dataOptions, $graphOptions, \DB::getQueryLog(), $data);
        // dd(\DB::getQueryLog());

        $xAxis = array();
        $xParam = "booking_date";
        foreach ($data as $key => $value) {
            if($graphOptions["xAxis"] == "mn"){
                $val = date("M Y", strtotime("1-{$value->{$xParam}}"));
            }elseif($graphOptions["xAxis"] == "yr"){
                $val = date("Y", strtotime("1-1-{$value->{$xParam}}"));
            }else{
                $val = $key;
            }
            if(!in_array($val, $xAxis)){
                array_push($xAxis, $val);
            }
        }

        //dd("Die");

        // dd($xAxis, $graphOptions, $data);

        $graphData = array(
            $graphOptions["xAxis"] => $xAxis,
            );
        $maxVals = count($xAxis);
        foreach ($data as $key => $value) {
            if(isset($value->all_paid)){
                $val = $value->all_paid;
            }elseif(isset($value->all_pax)){
                $val = $value->all_pax;
            }else{
                $val = $value->total_paid;
            }
            if($graphOptions["yAxis"] == "pr"){
                $newKey = $value->product_name;
            }elseif($graphOptions["yAxis"] == "po"){
                $newKey = $value->product_option_name;
            }elseif($graphOptions["yAxis"] == "sg"){
                $newKey = $value->source_group_name;
            }elseif($graphOptions["yAxis"] == "sn"){
                $newKey = $value->source_name;
            }elseif($graphOptions["yAxis"] == "pm"){
                $newKey = $value->payment_method_name;
            }else{
                $newKey = $value->product_name;
            }
            $graphData[$newKey][] = $val;
        }
        foreach ($graphData as $key => &$value) {
            if(count($value) < $maxVals){
                $requiredVals = $maxVals - count($value);
                for ($i=0; $i < $requiredVals; $i++) { 
                    $value[] = "0";
                }
            }
        }

        return $graphData;
    }

    public function getMysqlDate($date, $currentFormat = "j/m/Y", $newFormat = "Y-m-d H:i:s"){
        return \DateTime::createFromFormat($currentFormat, $date)->format($newFormat);
    }

}