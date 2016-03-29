<?php
/**
 * Created by PhpStorm.
 */

class Webhook extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function webhook (){

        $config = get_config('stripe');

        // Retrieve the request's body and parse it as JSON
        $input = @file_get_contents("php://input");
        $event_json = json_decode($input);
        http_response_code(200); // PHP 5.4 or greater

        echo "Webhook received";
    }
}

