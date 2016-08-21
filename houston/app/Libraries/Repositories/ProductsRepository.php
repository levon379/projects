<?php namespace App\Libraries\Repositories;


use App\Libraries\Helpers;
use App\Product;
use App\Language;
use Illuminate\Support\Facades\Log;

class ProductsRepository {

    public function getProductsByProductOptionLanguageDates($languageId = null,$bookingDate = null,$travelDate = null){

        if(empty($languageId)){
            $mainQuery = "SELECT * FROM products";
        } else {

            $subQuery = "SELECT DISTINCT(product_id) FROM product_options_languages l LEFT JOIN product_options p on l.product_option_id = p.id  WHERE  language_id = $languageId";

            if(!empty($travelDate)){
                $travelDate = Helpers::formatDate($travelDate);
                $subQuery .= " AND ((trav_season_start <= '$travelDate' AND trav_season_end >= '$travelDate') OR (trav_season_start = '0000-00-00' OR trav_season_end = '0000-00-00'))";
            }

            if(!empty($bookingDate)){
                $bookingDate = Helpers::formatDate($bookingDate);
                $subQuery .= " AND ((book_season_start <= '$bookingDate' AND book_season_end >= '$bookingDate') OR (book_season_start = '0000-00-00' OR book_season_end = '0000-00-00'))";
            }

            $mainQuery = "SELECT * FROM products WHERE id IN ( $subQuery ) ";
        }

        //Log::info("query: $mainQuery");

        $products = Product::hydrateRaw($mainQuery);

        return $products;
    }

    public function getProductLanguages($product)
    {
        

        if( !is_object($product) )
        {
            $product = Product::find($product);
        }

        // get all languages against the options of this product
        $options = $product->options()->with('languages')->get();

        $languageIds = []; // we may need to sort languages by name so fetch only Ids and then query on uniqueIds
        foreach($options as $option)
        {
            foreach($option->languages as $language)
            {
                $languageIds[] = $language->id;
            }
        }

        $languageIds = array_unique($languageIds);

        $languages = Language::whereIn('id', $languageIds)->get();

        return $languages;
    }

} 