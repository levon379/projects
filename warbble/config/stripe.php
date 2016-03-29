<?php
require_once(ABSPATH.'libraries/vendor/autoload.php');
//ID's plans in stripe
$eur = array(
    "lite"     => 2,
    "bronze"   => 3,
    "silver"   => 4,
    "gold"     => 5,
    "platinum" => 6,
);

$gbp = array(
    "lite"     => 7,
    "bronze"   => 8,
    "silver"   => 9,
    "gold"     => 10,
    "platinum" => 11,
);

$usd = array(
    "lite"     => 12,
    "bronze"   => 13,
    "silver"   => 14,
    "gold"     => 15,
    "platinum" => 16,
);

$usdQuarterly  = array(
    "lite"     => 27,
    "bronze"   => 28,
    "silver"   => 29,
    "gold"     => 30,
    "platinum" => 31,
);

$eurQuarterly  = array(
    "lite"     => 17,
    "bronze"   => 18,
    "silver"   => 19,
    "gold"     => 20,
    "platinum" => 21,
);

$gbpQuarterly  = array(
    "lite"     => 22,
    "bronze"   => 23,
    "silver"   => 24,
    "gold"     => 25,
    "platinum" => 26,
);
//ID's plans in stripe end//
$conf = array(
    "usd"      => $usd,
    "eur"      => $eur,
    "gbp"      => $gbp,
    "trial"    => 1,
    "quarterly_usd" => $usdQuarterly,
    "quarterly_eur" => $eurQuarterly,
    "quarterly_gbp" => $gbpQuarterly,
    //ID's products in stripe
    0 => array("setup"  => "sku_77d38PUoQf4K5B",
        "design" => "sku_77d4KwKJiXgAa5"),
    1 => array("setup"  => "sku_77d4dCJmBm9BpQ",
        "design" => "sku_77d5jyyBAZX5ns"),
    2 => array("setup"  => "sku_7HyIpfSmtxd2CC",   // Blogger
        "design" => "sku_7HyJDVqWcwBmWE"),         // Blogger
    //ID's products in stripe end //
    //"secret_key"       => "sk_test_qaI98nIAn0TK20LoyzB3Z2xh", // Test local
    //"publishable_key"  => "pk_test_fSAfBMNKoVpLjR3ENEndI5pH" // Test local
    "secret_key"      => "sk_test_p8GIW6yjmeAAC3cBDs2nD0WF", // Warbble
    "publishable_key" => "pk_test_NIwwXJYyU2HnQ8PWJ5rSKIwl", // Warbble

);
\Stripe\Stripe::setApiKey($conf['secret_key']);
return $conf;
?>