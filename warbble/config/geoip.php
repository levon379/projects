<?php
require_once(ABSPATH.'libraries/geoip/autoload.php');
use GeoIp2\WebService\Client;

if (file_exists(ABSPATH . "config/geoip.local.php")) {
    $conf = include ABSPATH . "config/geoip.local.php";
} else {
    $conf = array(
        "id"        => 106017,
        "license"   => "b1YNncK1iBXg",
        'IP'        => $_SERVER['REMOTE_ADDR'],
    );
}

return $conf;
?>