<?php
error_reporting(E_ALL);
//$url = 'http://www.amazon.co.uk/product-reviews/B00IZODKWS/ref=dp_top_cm_cr_acr_pop_hist_all/277-4156618-4058216?ie=UTF8&showViewpoints=1';
$url = 'http://www.amazon.com/Crime-Punishment-Fyodor-Dostoyevsky/dp/0486415872/ref=sr_1_2?s=books&ie=UTF8&qid=1433358720&sr=1-2&keywords=crime';
$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:19.0) Gecko/20100101 Firefox/19.0');
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

$x = curl_exec( $ch );
echo json_encode($x);
die();