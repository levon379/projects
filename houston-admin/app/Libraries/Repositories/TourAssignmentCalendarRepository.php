<?php namespace App\Libraries\Repositories;


use App\Libraries\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TourAssignmentCalendarRepository {

    public function getTour($id,$timestamp){

        $timestamp = substr($timestamp, 0, -3);

        $date = Carbon::createFromTimestamp($timestamp);

        $month = $date->month;
        $year = $date->year;

        $guide = $this->getGuideData($id,$month,$year);
        $tours = $this->getTourData($id,$month,$year);

        $tourData = [];

        // how are we going to deal with class for the circle color?

        foreach($tours as $tour){
            $url = "/admin/tour-manager/%s/details?d=%s&a=%s";
            $url = sprintf($url,$tour->product_id,$tour->date,$tour->availability_slot_id);
            $tourData[] = [
                "url" => $url,
                "id" => $tour->product_assignment_id,
                "availability_slot_id" => $tour->availability_slot_id,
                "availability_slot_color" => $tour->as_color,
                "product_id" => $tour->product_id,
                "title" => $tour->product_name.' ('.$this->getProductOptions($tour->options).')',
                "product_assigned_guides_id" => $tour->product_assigned_guides_id,
                "confirmed" => $tour->confirmed,
                "start" => Carbon::createFromFormat('Y-m-d H:i:s',$tour->date." 00:00:00")->getTimestamp()."000",
                "end" => Carbon::createFromFormat('Y-m-d H:i:s',$tour->date." 00:00:00")->getTimestamp()."000"
            ];
        }

        $mainCalendar = [
            "success" => 1,
            "id" => $guide->id,
            "name" => $guide->firstname.' '.$guide->lastname,
            "tours_assigned" => $guide->total_assigned,
            "tours_confirmed" => (int)$guide->total_confirmed,
            "tours" => $tourData
        ];

        return $mainCalendar;

    }

    private function getProductOptions($options){
        $optionList = explode(",",$options);
        foreach($optionList as $key =>$option){
            $optionElement = explode("-",$option);
            $optionElement = implode(" - ",$optionElement);
            $optionList[$key] = $optionElement;
        }
        return implode(", ",$optionList);
    }

    public function getGuideData($id,$month,$year){

        $query = "SELECT u.id,
                           u.firstname,
                           u.lastname,
                           IFNULL(SUM(pag.confirmed), 0) AS total_confirmed,
                           COUNT(u.id)                   AS total_assigned
                    FROM   product_assigned_guides pag
                           LEFT JOIN users u
                                  ON u.id = pag.guide_user_id
                           LEFT JOIN product_assignments pa
                                  ON pa.id = pag.product_assignment_id
                    WHERE  u.id = $id
                           AND YEAR(pa.date) = $year
                           AND MONTH(pa.date) = $month ";

        $result = DB::select($query)[0];

        return $result;
    }

    public function getTourData($id,$month,$year){
        $query = "SELECT *,
                           GROUP_CONCAT(CONCAT(product_option_name, '-', language_name)) AS options
                    FROM   (SELECT tc.*
                            FROM   bookings b
                                   JOIN (SELECT tb.day,
                                                tb.confirmed,
                                                tb.product_assigned_guides_id,
                                                product_name,
                                                tb.availability_slot_name,
                                                tb.as_color,
                                                tb.availability_slot_id,
                                                tb.product_id,
                                                tb.date,
                                                lg.name AS language_name,
                                                lg.id   AS language_id,
                                                tb.product_option_id,
                                                tb.product_option_name,
                                                tb.product_assignment_id
                                         FROM   product_options_languages AS pol
                                                LEFT JOIN languages lg
                                                       ON lg.id = pol.language_id
                                                JOIN (SELECT u.id         AS user_id,
                                                             u.firstname,
                                                             u.lastname,
                                                             pr.name      AS product_name,
                                                             pa.availability_slot_id,
                                                             pa.product_id,
                                                             ps.id        AS product_option_id,
                                                             ast.name     AS availability_slot_name,
                                                             ast.color    AS as_color,
                                                             ps.name      AS product_option_name,
                                                             DAY(pa.date) AS `day`,
                                                             pag.confirmed,
                                                             pa.date,
                                                             pa.id        AS product_assignment_id,
                                                             pag.id       AS
                                                             product_assigned_guides_id
                                                      FROM   product_assigned_guides pag
                                                             LEFT JOIN users u
                                                                    ON u.id = pag.guide_user_id
                                                             LEFT JOIN product_assignments pa
                                                                    ON
                                                             pa.id = pag.product_assignment_id
                                                             LEFT JOIN availability_slots ast
                                                                    ON pa.availability_slot_id =
                                                                       ast.id
                                                             LEFT JOIN products pr
                                                                    ON pa.product_id = pr.id
                                                             LEFT JOIN product_options ps
                                                                    ON ps.product_id = pr.id
                                                                       AND ps.availability_slot_id =
                                                                           ast.id
                                                      WHERE  u.id = $id
                                                             AND YEAR(pa.date) = $year
                                                             AND MONTH(pa.date) = $month) AS tb
                                                  ON pol.product_option_id = tb.product_option_id)
                                        AS tc
                                     ON b.language_id = tc.language_id
                                        AND b.travel_date = tc.date
                                        AND b.product_option_id = tc.product_option_id
                            GROUP  BY CONCAT(product_assigned_guides_id, tc.product_option_id)) AS
                           td
                    GROUP  BY product_assigned_guides_id  ";

        $result = DB::select($query);

        return $result;
    }

    public function getUserAvailability($id,$startDate,$endDate){
        $query = "SELECT *,
                           GROUP_CONCAT(time_of_day_id) AS tods
                    FROM user_availability
                    WHERE user_id = $id
                    AND date >= '$startDate' AND date <= '$endDate'
                    GROUP BY date";

        $result = DB::select($query);

        $dates = [];

        foreach($result as $item){
            $dates[] = [
                "date" => Helpers::displayDate($item->date),
                "tods" => Helpers::constructUnavailabilityText($item->tods),
                "id" => $item->user_id
            ];
        }

        return $dates;
    }

}