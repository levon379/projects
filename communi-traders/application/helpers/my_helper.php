<?php


function pars_asset($asset_data)
{
	$data = explode(",", $asset_data);
	 $y = '';
        $avg_ex_price   = trim($data[2]);
        if (preg_match("/\-/", $avg_ex_price)) {
            $avg_ex_price = preg_replace("/\-/", '', $avg_ex_price);
            $avg_ex_price = floatval($avg_ex_price);
            $y = floatval($data[7]) - $avg_ex_price;
            $avg_ex_price = '-' . $avg_ex_price;
        }
        else {
            $avg_ex_price = preg_replace("/\+/", '', $avg_ex_price);
            $avg_ex_price = floatval($avg_ex_price);
            $y = floatval($data[7]) + $avg_ex_price;
        }
        if ($y == '' || $y == 0 || $y == 'N/A' || $y == '0.00') {
            $y = floatval($data[1]);
        }
        
        if (preg_match("/N\/A/", $avg_ex_price)) {
            $avg_ex_price = '';
        }
        
		return $y;
}

?>