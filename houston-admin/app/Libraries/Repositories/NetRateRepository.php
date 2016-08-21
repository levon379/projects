<?php

namespace App\Libraries\Repositories;

use App\Source;
use App\SourceOption;
use App\Libraries\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NetRateRepository {

    public static function getRateMatchesNetRate($product_option_id, $source_name_id, $booking_dates, $travel_dates) {

        $booking_dates = Helpers::formatDate($booking_dates);
        $travel_dates = Helpers::formatDate($travel_dates);
        $queryString = "SELECT snc.* FROM source_names_commissions snc ";
        $queryString .= "WHERE snc.source_name_id = $source_name_id ";
        $sources_without_time = Source::hydrateRaw($queryString);
        if ($sources_without_time->count() >= 1) {
            foreach ($sources_without_time as $key => $source) {
                if ($source->trav_season_start != '0000-00-00' && $source->trav_season_end != '0000-00-00') {
                    $queryString .= " AND ( '$travel_dates'  BETWEEN snc.trav_season_start AND snc.trav_season_end )";
                }elseif($source->trav_season_start == '0000-00-00' && $source->trav_season_end != '0000-00-00'){
                    $queryString .= " AND ( '$travel_dates'  <= DATE(snc.trav_season_end))";
                }elseif($source->trav_season_start != '0000-00-00' && $source->trav_season_end == '0000-00-00'){
                    $queryString .= " AND ( '$travel_dates'  => DATE(snc.trav_season_start))";
                }
                if ($source->book_season_start != '0000-00-00' && $source->book_season_end != '0000-00-00') {
                    $queryString .= " AND '$booking_dates'  BETWEEN snc.book_season_start AND snc.book_season_end";
                }elseif($source->book_season_start == '0000-00-00' && $source->book_season_start != '0000-00-00'){
                    $queryString .= " AND ( '$travel_dates'  <= DATE(snc.book_season_end))";
                }elseif($source->book_season_start != '0000-00-00' && $source->book_season_start == '0000-00-00'){
                    $queryString .= " AND ( '$travel_dates'  => DATE(snc.book_season_start))";
                }
                
            }
        }
        
        $sources = Source::hydrateRaw($queryString);
        $source_option = [];
        $sources_option = [];
        $output = new \StdClass;
        $source_key = [];
        if ($sources->count() > 1) {
            foreach ($sources as $key => $source) {
                if ($source->default_flag) {
                    $queryString = "SELECT sop.* FROM source_option sop ";
                    $queryString .= " WHERE sop.product_opt_id = '$product_option_id' AND sop.source_id = '$source->id' ";
                    $sources_option = SourceOption::hydrateRaw($queryString);
                    $source_key[] = $key;
                }
            }

            if (count($source_key) > 1) {
                $output->error_message = true;
            } elseif (count($source_key) == 1) {
                $output->adult_net_rate = $sources[$source_key[0]]->adult_net_rate;
                $output->child_net_rate = $sources[$source_key[0]]->child_net_rate;
                // $output->error_message = false;
            }
        } elseif ($sources->count() == 1) {
            if ($sources[0]->default_flag) {
                $output->adult_net_rate = $sources[0]->adult_net_rate;
                $output->child_net_rate = $sources[0]->child_net_rate;
                // $output->error_message = false;
            } else {
                $output->error_message = true;
            }
        }

        return $output;
    }

}
