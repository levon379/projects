<?php
/**
 * Created by PhpStorm.
 * User: Aivan
 * Date: 3/7/2016
 * Time: 10:52 PM
 */

namespace App\Libraries\Gateways;


use App\Libraries\Helpers;
use App\Libraries\Repositories\TourManagerRepository;
use Illuminate\Http\Request;

class TourManagerGateway {

    public function __construct(TourManagerRepository $tourManagerRepository){
        $this->tourManagerRepository = $tourManagerRepository;
    }

    /**
     * @param Request $request
     * @param $pageSize
     * @param $page
     * @param $startDate
     * @param $filters
     * @return array
     */
    public function getTourDates(Request $request,$pageSize,$page,$startDate,$filters = "",$user = null){

        $startDate = Helpers::formatDate($startDate);
        $filters = explode(",",$filters);
        $filters = array_filter($filters);

        /*
         * 1 Rome By Segway
         * 2 Goseek Adventures
         * 3 Ecoart Travel
         * 4 Packages
         */

        $providerFilter = Helpers::removeItem($filters,4);


        if(count($providerFilter)<1){
            $dates = new \StdClass;
            $dates->total = 0;
            $dates->dates = [];
        } else {
            $dates = $this->tourManagerRepository->getDates($pageSize,$page,$startDate,$providerFilter,$user);
        }
        $queryString = $request->query();
        $path = $request->url();
        $query =  array_except($queryString,'page');
        $pages = 1;
        if($pageSize != 0){
            $pages = ceil($dates->total / $pageSize);
        }
        $disablePrev = false;
        $disableNext = false;

        $prevNo = ($page - 1) ? $page - 1 : 1 ;
        $query['page'] = $prevNo;
        $prevLink = $path."?".http_build_query($query);

        if($prevNo == 1){
            $disablePrev = true;
        }
        $nextNo = ($page < $pages) ? $page + 1 :  $pages;
        $query['page'] = $nextNo;
        $nextLink = $path."?".http_build_query($query);

        if($nextNo == $pages){
            $disableNext = true;
        }

        return compact('dates','total','disablePrev','disableNext','prevLink','nextLink');
    }
}