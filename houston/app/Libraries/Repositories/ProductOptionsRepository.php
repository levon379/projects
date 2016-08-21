<?php namespace App\Libraries\Repositories;


use App\Libraries\Helpers;
use App\ProductOption;
use App\Language;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProductOptionsRepository {

    /**
     *
     * NOTE: Don't use this method. this is deleted. instead use getProductOptionsByProductLanguageDates
     */
    public function getProductOptionsByProductLanguageDates_DEL($productId,$languageId = null,$bookingDate = null,$travelDate = null){


        if(empty($productId)){
            $queryString = "SELECT * FROM product_options";
            return array();
        } else {

            if(!empty($languageId) or $languageId === "0"){
                $queryString = "SELECT p.* FROM product_options_languages l LEFT JOIN product_options p on l.product_option_id = p.id WHERE product_id = $productId ";
                $queryString .= " AND language_id = $languageId";
            } else {
                $queryString = "SELECT * FROM product_options WHERE product_id = $productId";
            }

            if(!empty($travelDate)){
                $travelDate = Helpers::formatDate($travelDate);
                $queryString .= " AND ((trav_season_start <= '$travelDate' AND trav_season_end >= '$travelDate') OR (trav_season_start = '0000-00-00' OR trav_season_end = '0000-00-00'))";
            }

            if(!empty($bookingDate)){
                $bookingDate = Helpers::formatDate($bookingDate);
                $queryString .= " AND ((book_season_start <= '$bookingDate' AND book_season_end >= '$bookingDate') OR (book_season_start = '0000-00-00' OR book_season_end = '0000-00-00'))";
            }

        }

        //Log::info("query : $queryString");
        $productOptions = ProductOption::hydrateRaw($queryString);

        //return DB::select($queryString);
        return $productOptions;
    }

    public function getProductOptionsByProductLanguageDates($productId, $languageId=null, $bookingDate = null, $travelDate = null)
    {
        if(!empty($travelDate)){
            $travelDate = Helpers::formatDate($travelDate);
            $travelDateCarbon = Carbon::createFromFormat("Y-m-d", $travelDate);
            $travelDayOfWeek = $travelDateCarbon->dayOfWeek;
            
            $dayBits = [
                "d-".Carbon::SUNDAY => 1,
                "d-".Carbon::SATURDAY => 2,
                "d-".Carbon::FRIDAY => 4,
                "d-".Carbon::THURSDAY => 8,
                "d-".Carbon::WEDNESDAY => 16,                                                                                        
                "d-".Carbon::TUESDAY => 32,
                "d-".Carbon::MONDAY => 64,
            ];

            //print_r($dayBits);
            
            $travelDayBit = $dayBits[ "d-".$travelDayOfWeek ];

            //echo "$travelDayBit = $travelDayOfWeek";exit;
        }

        $queryString = "SELECT p.* FROM product_options p 

                        JOIN product_options_languages pol on p.id = pol.product_option_id 
                        
                        LEFT JOIN product_options_unavailable_days poud on (
                            p.id = poud.product_option_id ".
                            (!empty($travelDate) ? "AND poud.date='$travelDate'" : "")
                        .")

                        LEFT JOIN product_options_languages_unavailable_days polud on (
                            pol.id = polud.product_options_language_id ".
                            (!empty($travelDate) ? "AND polud.date='$travelDate'" : "")
                        .")
                        
                        WHERE p.product_id = $productId ";

        if(!empty($languageId) or $languageId === "0")
        {
            $queryString .= "
                AND (
                        pol.language_id = $languageId
                    )
            ";
        }

        if(!empty($travelDate)){
            $travelDate = Helpers::formatDate($travelDate);
            $queryString .= " 
                AND (
                        poud.id IS NULL
                    )
                AND (
                        polud.id IS NULL
                    )
                AND (
                        CONV(p.running_days, 2, 10) & $travelDayBit = $travelDayBit
                    )
                AND (
                        (trav_season_start = '0000-00-00' OR trav_season_start <= '$travelDate') AND
                        (trav_season_end = '0000-00-00' OR trav_season_end >= '$travelDate') AND
                        (flag_show = 1)
                    )";
        }

        if(!empty($bookingDate)){
            $bookingDate = Helpers::formatDate($bookingDate);
            $queryString .= " AND ((book_season_start <= '$bookingDate' AND book_season_end >= '$bookingDate') OR (book_season_start = '0000-00-00' OR book_season_end = '0000-00-00'))";
        }

        $queryString .= "GROUP BY p.id";
        //echo $queryString;

        //Log::info("query : $queryString");
        $productOptions = ProductOption::hydrateRaw($queryString);

        //return DB::select($queryString);
        return $productOptions;
    }

    public function getProductOptionsLanguagesByProductDates($productId, $bookingDate = null, $travelDate = null)
    {
        if(!empty($travelDate)){
            $travelDate = Helpers::formatDate($travelDate);
            $travelDateCarbon = Carbon::createFromFormat("Y-m-d", $travelDate);
            $travelDayOfWeek = $travelDateCarbon->dayOfWeek;
            
            $dayBits = [
                "d-".Carbon::SUNDAY => 1,
                "d-".Carbon::SATURDAY => 2,
                "d-".Carbon::FRIDAY => 4,
                "d-".Carbon::THURSDAY => 8,
                "d-".Carbon::WEDNESDAY => 16,                                                                                        
                "d-".Carbon::TUESDAY => 32,
                "d-".Carbon::MONDAY => 64,
            ];

            //print_r($dayBits);
            
            $travelDayBit = $dayBits[ "d-".$travelDayOfWeek ];

            //echo "$travelDayBit = $travelDayOfWeek";exit;
        }

        $queryString = "SELECT l.* FROM languages l 
                        JOIN product_options_languages pol on l.id = pol.language_id 
                        JOIN product_options p on pol.product_option_id = p.id 
                        
                        LEFT JOIN product_options_unavailable_days poud on (
                            p.id = poud.product_option_id ".
                            (!empty($travelDate) ? "AND poud.date='$travelDate'" : "")
                        .")

                        LEFT JOIN product_options_languages_unavailable_days polud on (
                            pol.id = polud.product_options_language_id ".
                            (!empty($travelDate) ? "AND polud.date='$travelDate'" : "")
                        .")
                        
                        WHERE p.product_id = $productId ";


        if(!empty($travelDate)){
            $travelDate = Helpers::formatDate($travelDate);
            $queryString .= " 
                AND (
                        poud.id IS NULL
                    )
                AND (
                        polud.id IS NULL
                    )
                AND (
                        CONV(p.running_days, 2, 10) & $travelDayBit = $travelDayBit
                    )
                AND (
                        (trav_season_start = '0000-00-00' OR trav_season_start <= '$travelDate') AND
                        (trav_season_end = '0000-00-00' OR trav_season_end >= '$travelDate') AND
                        (flag_show = 1)
                    )";
        }

        if(!empty($bookingDate)){
            $bookingDate = Helpers::formatDate($bookingDate);
            $queryString .= " AND ((book_season_start <= '$bookingDate' AND book_season_end >= '$bookingDate') OR (book_season_start = '0000-00-00' OR book_season_end = '0000-00-00'))";
        }

        $queryString .= "GROUP BY l.id";
        //echo $queryString;

        //Log::info("query : $queryString");
        $productOptionLanguages = Language::hydrateRaw($queryString);

        //dd($productOptionLanguages->toArray());

        //return DB::select($queryString);
        return $productOptionLanguages;
    }

    public function getProductOptionsForPackage($productOptionId,$languageIds,$query){
        if(empty($languageIds)){
            return [];
        } else {
            $queryString = "SELECT p.* FROM product_options_languages l
                            LEFT JOIN product_options p on l.product_option_id = p.id
                            LEFT JOIN products ps ON ps.id = p.product_id
                            WHERE p.id != $productOptionId AND l.language_id IN($languageIds) GROUP BY p.id ";
            if(!empty($queryString)){
                $queryString .= " AND CONCAT(ps.name,' - ',p.name) LIKE '%$query%'";
            }
        }

        Log::info("query : $queryString");
        $productOptions = ProductOption::hydrateRaw($queryString);

        return $productOptions;

    }

    public function checkIfPriceIsZero($id){
        $prodOption = ProductOption::find($id);
        if($prodOption){
            return $prodOption->child_price > 0 ? false : true;
        }

        return false;
    }
    public function getProductOptionChildAge($id){
        $prodOption = ProductOption::find($id);
        if($prodOption){
            $result_array = array('childAge_from'=>$prodOption->child_age_from,'childAgeTo'=>$prodOption->child_age_to);
            return $result_array;
        }

        return false;
    }
    public function getProductOptionAdultAge($id){
        $prodOption = ProductOption::find($id);
        if($prodOption){
            $result_array = array('adult_age_from'=>$prodOption->adult_age_from,'adult_age_to'=>$prodOption->adult_age_to);
            return $result_array;
        }

        return false;
    }

} 