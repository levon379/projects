<?php
/**
 * Created by PhpStorm.
 * User: Aivan
 * Date: 5/1/15
 * Time: 4:29 AM
 */

namespace App\Libraries\Repositories;


use App\Libraries\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TourManagerRepository {
    public function checkIfDateExists($date){
        //2015-03-27
        $queryString = "SELECT 1 FROM bookings WHERE travel_date BETWEEN '$date'  GROUP BY travel_date";
        $result = DB::select($queryString);
        return count($result) ? true : false;
    }

    public function getDates($limit = 6 , $page = 1 , $startDate = "",$providerFilter = []){

        $startFrom = ($page-1) * $limit;

        $queryString = "SELECT b.travel_date AS `date`, SUM(b.total_pax) AS total_bookings
                        FROM   bookings b ";

        if(count($providerFilter)<3 && count($providerFilter) > 0){
            $queryString .="LEFT JOIN product_options po
                                   ON b.product_option_id = po.id
                            LEFT JOIN products p
                                   ON po.product_id = p.id ";
        }

        $queryString .= " WHERE 1 = 1 ";

        if(!empty($startDate)){
            $queryString .= " AND travel_date >= '$startDate' ";
        }

        if(count($providerFilter)<3 && count($providerFilter) > 0){
            $filter = implode(",", $providerFilter);
            $queryString .= " AND p.provider_id IN ($filter)";
        }

        $queryString .= " AND b.deleted = 0 AND b.refunded = 0";

        $queryString .= " GROUP  BY travel_date";

        $dates = $queryString." LIMIT $startFrom, $limit";

        $results = DB::select($dates);

        $queryString = "SELECT COUNT(*) as count FROM ($queryString) as tb";

        $totalsQuery = DB::select($queryString)[0];

        $output = new \StdClass;
        $output->total = $totalsQuery->count;
        $output->dates = $results;

        return $output;

    }

    public function getAvailabilitySlotsByDate($date,$showPackage,$providerFilter){

        $queryString = "SELECT av.id AS availability_slot_id
                        FROM   bookings b
                               LEFT JOIN product_options po
                                      ON po.id = b.product_option_id
                               LEFT JOIN products p
                                      ON p.id = po.product_id
                               LEFT JOIN availability_slots av
                                      ON av.id = po.availability_slot_id
                        WHERE  b.travel_date = '$date' ";

        // TODO: static 6 'Packages'
        if(!$showPackage){
            $queryString .= " AND av.id != 6";
        }

        if(count($providerFilter)<3 && count($providerFilter) > 0){
            $filter = implode(",", $providerFilter);
            $queryString .= " AND p.provider_id IN ($filter)";
        }

        $queryString .= " AND b.deleted = 0 AND b.refunded = 0";

        $queryString .= "  GROUP BY av.id";

        $result = DB::select($queryString);

        $results = array();

        foreach($result as $id){
            $results[] = $id->availability_slot_id;
        }

        return $results;
    }

    public function getProductsByAvailabilityAndDate($availability,$date,$providerFilter){
        $queryString = "SELECT p.id  AS product_id
                        FROM   bookings b
                               LEFT JOIN product_options po
                                      ON po.id = b.product_option_id
                               LEFT JOIN products p
                                      ON p.id = po.product_id
                               LEFT JOIN availability_slots av
                                      ON av.id = po.availability_slot_id
                        WHERE  b.travel_date = '$date'
                        AND av.id = $availability ";

        if(count($providerFilter)<3 && count($providerFilter) > 0){
            $filter = implode(",", $providerFilter);
            $queryString .= " AND p.provider_id IN ($filter)";
        }

        $queryString .= " AND b.deleted = 0 AND b.refunded = 0";

        $queryString .= " GROUP BY p.id";

        $result = DB::select($queryString);

        $results = array();

        foreach($result as $id){
            $results[] = $id->product_id;
        }

        return $results;
    }

    public function getGuideTotalByAvailabilityAndDate($availability,$date){
        $queryString = "SELECT COUNT(DISTINCT guide_user_id) AS guide_count
                        FROM   product_assigned_guides
                        WHERE  product_assignment_id IN (SELECT id
                                                         FROM   product_assignments
                                                         WHERE  availability_slot_id = $availability
                                                                AND date = '$date') ";
        $result = DB::select($queryString);

        if(count($result)){
            return $result[0];
        }

        return [];
    }

    public function getTotalsByAvailabilityAndDate($availability,$date){
        $queryString = "SELECT SUM(total_pax)                                        AS total_bookings,
                               ar.`limit`                                            AS `limit`,
                               ( COALESCE(asd.`limit`,ar.`limit`) - SUM(total_pax) ) AS remaining,
                               asd.`limit`                                           AS limit_override,
                               (SELECT 1 FROM availability_slot_date_limit WHERE availability_slot_id = av.id AND `date` = '$date' LIMIT 1) AS has_override,
                               av.name                                               AS availability_name
                        FROM   bookings b
                               LEFT JOIN product_options po
                                      ON po.id = b.product_option_id
                               LEFT JOIN products p
                                      ON p.id = po.product_id
                               LEFT JOIN availability_slots av
                                      ON av.id = po.availability_slot_id
                               LEFT JOIN availability_rules ar
                                      ON ar.availability_slot_id = av.id
                               LEFT JOIN availability_slot_date_limit asd
                                      ON asd.availability_slot_id = av.id
                                         AND asd.`date` = '$date'
                        WHERE  b.travel_date = '$date'
                               AND av.id = $availability
                               AND b.deleted = 0 AND b.refunded = 0
                        GROUP  BY av.id ";

        $result = DB::select($queryString);

        //Log::info($queryString);

        if(count($result)){
            return $result[0];
        }


        $queryString = "SELECT ar.`limit`,
                               av.name AS availability_name,
                               asd.`limit` AS limit_override,
                               (SELECT 1
                                FROM   availability_slot_date_limit
                                WHERE  availability_slot_id = av.id
                                       AND `date` = '$date'
                                LIMIT  1)  AS has_override
                        FROM   availability_slots av
                               LEFT JOIN availability_rules ar
                                      ON ar.availability_slot_id = av.id
                               LEFT JOIN availability_slot_date_limit asd
                                      ON asd.availability_slot_id = av.id
                                         AND asd.`date` = '$date'
                        WHERE  av.id = $availability ";

        //Log::info($queryString);

        $result = DB::select($queryString);

        if(count($result)){
            $result = $result[0];
            $default = new \StdClass;
            $default->total_bookings = 0;
            $default->limit = $result->limit;
            $default->remaining = $result->limit;
            $default->limit_override = $result->limit_override;
            $default->has_override = $result->has_override;
            $default->availability_name = $result->availability_name;

            return $default;
        }

        return [];
    }

    public function getTotalsByProductAvailabilityAndDate($product,$availability,$date){
        $queryString = "SELECT p.id                                   AS product_id,
                               p.name                                 AS product_name,
                               av.id                                  AS availability_slot_id,
                               (SELECT pas.id
                                FROM   product_assignments pas
                                WHERE  pas.availability_slot_id = $availability
                                       AND pas.id = $product
                                       AND pas.`date` = '$date'
                                LIMIT  1)                             AS product_assignment_id,
                               SUM(b.total_pax)                       total_bookings,
                               SUM(IF(b.package > 0, b.total_pax, 0)) total_package
                        FROM   bookings b
                               LEFT JOIN product_options po
                                      ON po.id = b.product_option_id
                               LEFT JOIN products p
                                      ON p.id = po.product_id
                               LEFT JOIN availability_slots av
                                      ON av.id = po.availability_slot_id
                        WHERE  b.travel_date = '$date'
                               AND p.id = $product
                               AND av.id = $availability
                               AND b.deleted = 0 AND b.refunded = 0 ";


        $queryString .= " GROUP BY p.id";

        //Log::info($queryString);

        $result = DB::select($queryString);

        if(count($result)){
            return $result[0];
        }

        return [];
    }

    public function getProductOptionsByProductAvailabilityAndDate($product,$availability,$date){
        $queryString = "SELECT p.id                          AS product_id,
                               av.id                         AS availability_slot_id,
                               pol.id                        AS product_option_language_id,
                               b.product_option_id,
                               po.name                       AS product_option_name,
                               pol.language_id,
                               pol.id                        AS proptions_lang_id,
                               l.name                        AS language_name,
                               SUM(b.total_pax) AS total_bookings,
                               SUM(IF(b.package > 0 ,b.total_pax,0)) AS total_package,
                               NOT( pou.`date` IS NOT NULL ) AS available
                        FROM   bookings b
                               LEFT JOIN product_options po
                                      ON po.id = b.product_option_id
                               LEFT JOIN products p
                                      ON p.id = po.product_id
                               LEFT JOIN availability_slots av
                                      ON av.id = po.availability_slot_id
                               LEFT JOIN product_options_languages pol
                                      ON pol.product_option_id = po.id
                                         AND pol.language_id = b.language_id
                               LEFT JOIN product_options_languages_unavailable_days pou
                                      ON pou.`date` = '$date'
                                         AND pou.product_options_language_id = pol.id
                               LEFT JOIN languages l
                                      ON l.id = b.language_id
                        WHERE  b.travel_date = '$date'
                               AND p.id = $product
                               AND av.id = $availability
                               AND b.deleted = 0 AND b.refunded = 0 ";

        $queryString .= " GROUP  BY b.product_option_id, b.language_id ";

        //Log::info($queryString);

        $result = DB::select($queryString);

        return $result;
    }

    public function getCommentsByProductAvailabilityAndDate($product,$availability,$date){
        $queryString = "SELECT pac.*,
                               u.firstname,
                               u.lastname
                        FROM   product_assigned_comments pac
                               LEFT JOIN users u
                                      ON pac.user_id = u.id
                               LEFT JOIN product_assignments pa
                                      ON pa.id = pac.product_assignment_id
                        WHERE  pa.product_id = $product
                               AND pa.availability_slot_id = $availability
                               AND pa.date = '$date' ";

        $result = DB::select($queryString);

        return $result;

    }

    public function getGuidesByProductAvailabilityAndDate($product,$availability,$date){
        $queryString = "SELECT pag.*,
                               u.firstname,
                               u.lastname,
                               ug.firstname AS firstname_guide,
                               ug.lastname  AS lastname_guide
                        FROM   product_assigned_guides pag
                               LEFT JOIN users u
                                      ON pag.user_id = u.id
                               LEFT JOIN users ug
                                      ON pag.guide_user_id = ug.id
                               LEFT JOIN product_assignments pa
                                      ON pa.id = pag.product_assignment_id
                        WHERE  pa.product_id = $product
                               AND pa.availability_slot_id = $availability
                               AND pa.date = '$date' ";

        $result = DB::select($queryString);

        return $result;
    }

    public function getServicesByProductAvailabilityAndDate($product,$availability,$date){
        $queryString = "SELECT pas.*,
                               u.firstname,
                               u.lastname,
                               st.name AS service_type_name,
                               so.service_id,
                               so.name AS service_option_name,
                               so.unit_price,
                               so.iva,
                               so.unit_price_plus_iva,
                               s.service_type_id,
                               s.name  AS service_name,
                               s.id    AS service_id
                        FROM   product_assigned_services pas
                               LEFT JOIN users u
                                      ON pas.user_id = u.id
                               LEFT JOIN product_assignments pa
                                      ON pa.id = pas.product_assignment_id
                               LEFT JOIN service_options so
                                      ON so.id = pas.service_option_id
                               LEFT JOIN services s
                                      ON so.service_id = s.id
                               LEFT JOIN service_types st
                                      ON s.service_type_id = st.id
                        WHERE  pa.product_id = $product
                               AND pa.availability_slot_id = $availability
                               AND pa.date = '$date'";

        $result = DB::select($queryString);

        return $result;
    }

    public function getColumn($date,$total,$filters=[]){

        /*
         * 1 Rome By Segway
         * 2 Goseek Adventures
         * 3 Ecoart Travel
         * 4 Packages
         */


        $providerFilter = Helpers::removeItem($filters,4);
        $showPackage = in_array(4,$filters);


        $column["date"] = $date;
        $column["total_bookings"] = (int)$total;
        $slots = $this->getAvailabilitySlotsByDate($date,$showPackage,$providerFilter);
        foreach($slots as $slot){
            $guideCount = $this->getGuideTotalByAvailabilityAndDate($slot,$date);
            $guideCount = (int)$guideCount->guide_count;
            $totals = $this->getTotalsByAvailabilityAndDate($slot,$date);
            $remaining = $totals->remaining;

            if(!empty($remaining)){
                $remaining = $remaining - $guideCount;
            }

            $hasGuide = 0;
            if(!empty($guideCount)){
                $hasGuide = 1;
            }

            $availabilitySlot = [
                "id" => $slot,
                "total_bookings" => (int)$totals->total_bookings,
                "limit" => $totals->limit,
                "limit_override" => $totals->limit_override,
                'has_override' => (int)$totals->has_override,
                "has_guide" => $hasGuide,
                "remaining" => $remaining,
                "name" => $totals->availability_name,
                "products" => []
            ];
            $products = $this->getProductsByAvailabilityAndDate($slot,$date,$providerFilter);
            foreach($products as $product){
                $totals = $this->getTotalsByProductAvailabilityAndDate($product,$slot,$date);
                $productItem = [
                    "id" => $product,
                    "name" => $totals->product_name,
                    "total_bookings" => $totals->total_bookings,
                    "total_package" => (int)$totals->total_package,
                    "assignment_id" => $totals->product_assignment_id ?: 0,
                    "product_options" => [],
                    "comments" => [],
                    "services" => [],
                    "guides" => []
                ];

                $options = $this->getProductOptionsByProductAvailabilityAndDate($product,$slot,$date);
                foreach($options as $option){
                    $optionItem = [
                        "id" => $option->product_option_id,
                        "language_name" => $option->language_name,
                        "proptions_language_id" => $option->proptions_lang_id,
                        "language_id" => $option->language_id,
                        "name" => $option->product_option_name,
                        "total_bookings" => $option->total_bookings,
                        "total_package" => (int)$option->total_package,
                        "available" => $option->available
                    ];

                    $productItem["product_options"][] = $optionItem;
                }

                $comments = $this->getCommentsByProductAvailabilityAndDate($product,$slot,$date);
                foreach($comments as $comment){
                    $commentItem = [
                        "id" => $comment->id,
                        "name" => $comment->firstname." ".$comment->lastname,
                        "comment" => nl2br($comment->comment),
                        "user_id" => $comment->user_id,
                        "time_ago" => Carbon::parse($comment->created_at)->diffForHumans()
                    ];

                    $productItem["comments"][] = $commentItem;
                }

                $services = $this->getServicesByProductAvailabilityAndDate($product,$slot,$date);
                foreach($services as $service){
                    $serviceItem = [
                        "id" => $service->id,
                        "service_id" => $service->service_id,
                        "service_name" => $service->service_name,
                        "type_id" => $service->service_type_id,
                        "type_name" => $service->service_type_name,
                        "option_id" => $service->service_option_id,
                        "option_name" => $service->service_option_name,
                        "quantity" => $service->quantity,
                        "unit_price" => $service->unit_price,
                        "total_price" => $service->total_price,
                        "iva" => $service->iva,
                        "unit_price_plus_iva" =>  $service->unit_price_plus_iva
                    ];

                    $productItem["services"][] = $serviceItem;
                }

                $guides = $this->getGuidesByProductAvailabilityAndDate($product,$slot,$date);
                foreach($guides as $guide){
                    $guideItem = [
                        "id" => $guide->id,
                        "user_id" => $guide->guide_user_id,
                        "name" => $guide->firstname_guide." ".$guide->lastname_guide,
                        "confirmed" => (int)$guide->confirmed
                    ];
                    $productItem["guides"][] = $guideItem;
                }


                $availabilitySlot["products"][] = $productItem;
            }
            $column["availability_slot"][] = $availabilitySlot;
        }
        return $column;
    }
}
