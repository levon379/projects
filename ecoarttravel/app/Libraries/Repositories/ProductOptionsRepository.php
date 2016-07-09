<?php namespace App\Libraries\Repositories;


use App\Libraries\Helpers;
use App\ProductOption;
use Illuminate\Support\Facades\Log;

class ProductOptionsRepository {

     public function getProductOptionsByProductLanguageDates($productId = null,$languageId = null,$bookingDate = null,$travelDate = null){


        if(empty($productId)){
            $queryString = "SELECT * FROM product_options";
            return array();
        } else {


            if(!empty($languageId)){
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

} 