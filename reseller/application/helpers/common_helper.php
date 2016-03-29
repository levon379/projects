<?php

if (!function_exists('price_format')) :
    function price_format($price) {
        return sprintf('€ %.2f', $price);
    }
endif;