<?php

if (file_exists(ABSPATH . "config/payment.local.php")) {
    return include ABSPATH . "config/payment.local.php";
} else {
    return array(
        'secret_key'            => 'sk_test_p8GIW6yjmeAAC3cBDs2nD0WF',
        'publishable_key'       => 'pk_test_NIwwXJYyU2HnQ8PWJ5rSKIwl',
    );
}