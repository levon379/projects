<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_menu')) :
    function get_menu($menu = false) {
        $file = ABSPATH . "config/$menu.php";
        if (file_exists($file)) {
            return include ($file);
        }
        return false;
    }
endif;