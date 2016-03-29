<?php

class Api extends Controller
{
    private $token  = false;
    private $domain = false;
    private $ip     = false;

    private $users  = false;

    /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    protected $method = '';
    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     */
    protected $endpoint = '';
    /**
     * Property: verb
     * An optional additional descriptor about the endpoint, used for things that can
     * not be handled by the basic methods. eg: /files/process
     */
    protected $verb = '';
    /**
     * Property: args
     * Any additional URI components after the endpoint and verb have been removed, in our
     * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
     * or /<endpoint>/<arg0>
     */
    protected $args = Array();
    /**
     * Property: file
     * Stores the input of the PUT request
     */
    protected $file = Null;

    /**
     * Constructor: __construct
     * Allow for CORS, assemble and pre-process the data
     */
    public function __construct() {
        parent::__construct();

        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");
        header("Expires: on, 01 Jan 1970 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                $this->__response('Unexpected Header', 500);
            }
        }

        switch($this->method) {
            case 'DELETE':
            case 'POST':
                $this->request = $this->__cleanInputs($_POST);
                break;
            case 'GET':
                $this->request = $this->__cleanInputs($_GET);
                break;
            case 'PUT':
                $this->request = $this->__cleanInputs($_GET);
                $this->file = file_get_contents("php://input");
                break;
            default:
                $this->__response('Invalid Method', 405);
                break;
        }

        $this->token = isset($this->request['apiToken'])? $this->request['apiToken']: false;
        $this->domain = isset($this->request['apiDomain'])? $this->request['apiDomain']: false;
        $this->ip = isset($this->request['apiIP'])? $this->request['apiIP']: false;

        if (!in_array($this->domain, Api_model::$allow_domains)) {
            $this->__response('Domain isn\'t allowed.', 500);
        }
    }

    public function auth()
    {
        $this->users = Users_Model::find_by_sql(sprintf("
            SELECT users.*
            FROM users
            JOIN api ON api.user_id = users.user_id
            WHERE api.domain = '%s' AND api.token = '%s'
            LIMIT 1
        ", $this->domain, $this->token));

        $this->__response(array(
            'status'    => 200,
            'url'       => base_url('api/login') . sprintf('?domain=%s&token=%s', urlencode($this->domain), urlencode($this->token))
        ));
    }

    private function __response($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->__requestStatus($status));
        echo json_encode($data);
        die;
    }

    private function __cleanInputs($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->__cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

    private function __requestStatus($code) {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code])?$status[$code]:$status[500];
    }
}