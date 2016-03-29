<?php
header("Expires: on, 01 Jan 1970 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.10.15
 * Time: 15:58
 *
 *use guzzlehttp/guzzle": "^6.1"
 *https://github.com/guzzle/guzzle
 *http://guzzle.readthedocs.org/en/latest/
 *
 *take like:  ~/var/www/reseller$ composer.phar require guzzlehttp/guzzle
 */
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Exception\ServerException;

class WarbbleApiClient
{
    public $authUrl = "";
    public function __construct($baseUrl = ""){
        $this->baseUrl = $baseUrl;
        $this->authUrl = rtrim($baseUrl, '/') .  "/Api/auth";
    }

    /**
     *fetch token from $_POST
     * @return bool
     */
    public function fetchCredentials()
    {
        return isset($_POST['warbble_api_response'])? $_POST['warbble_api_response']: false;
    }

    public function warbbleLogin($token = ""){

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $this->baseUrl,
            // You can set any number of default request options.
            //'timeout'  => 2.0,
        ]);

        try {
            $responce = $client->request('GET', $this->authUrl, [
                'query' => [
                    'apiDomain' => $_SERVER['SERVER_NAME'],
                    'apiToken' => "$token",
                    'apiIP' => $_SERVER['SERVER_ADDR']
                ]
            ]);

            $mydata = urldecode($responce->getBody()->getContents());

            $myArray = json_decode($mydata, true);

            return $myArray;


        } catch (Exception $e) {
            echo $e->getMessage();
            echo $e->getTraceAsString();
            echo $e->getRequest();
            if ($e->hasResponse()) {
                echo $e->getResponse();
            }
        }
    }

    public function redirect($url, $status = 301)
    {
        header("Location: " . $url, true, $status);
    }
}