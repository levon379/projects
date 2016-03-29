<?php
/**
 * Created by PhpStorm.
 * User: enclaveit
 * Date: 5/21/15
 * Time: 8:25 AM
 */
error_reporting(E_ERROR);
class Router {

    public $controller = 'Home';
    public $method = 'index';
    public $param = array();
    public $routers = array();
    public $include = '';
    public $is_filter = false;

    public function __construct(){
        $this->parseUrl();
    }

    public function parseUrl(){
        $uri = '';
        $url = array();
        if( isset( $_GET['url'] ) ){
            $uri = filter_var( rtrim( $_GET['url'], "/" ), FILTER_SANITIZE_URL );
            $url = explode( "/", filter_var( rtrim( $_GET['url'], "/" ), FILTER_SANITIZE_URL ));
        }
        if( sizeof( $url ) >=2){
            if( file_exists( ABSPATH."controller/".$url[0].".php" ) || file_exists( ABSPATH."controller/".ucfirst($url[0]).".php" ) ){
                $this->controller = ucfirst($url[0]);
                $this->method = $url[1];
                $this->include = "controller/".$this->controller.".php";
                unset($url[0]);
                unset($url[1]);
            }elseif(file_exists( ABSPATH."controller/".$url[0]."/".$url[1].".php" ) || file_exists( ABSPATH."controller/".$url[0]."/".ucfirst($url[1]).".php" )){
                $this->controller = ucfirst($url[1]);
                $this->include = "controller/".$url[0]."/".$this->controller.".php";
                $this->method = $url[2];
                unset($url[0]);
                unset($url[1]);
                unset($url[2]);
            }else{
                $this->include = "controller/".$this->controller.".php";
                unset($url);
            }
            $param = $url ? array_values( $url ) : array();
            $this->param = $param;
        }
        include(ABSPATH."config/router.php");
        $this->routers = isset($route) && !empty($route) ? $route : $this->routers;
        // Loop through the route array looking for wildcards
        foreach($this->routers as $k=>$v){
            $c = str_replace( array(':any',':num'), array('[a-zA-Z0-9]', '[0-9]'), rtrim($k, "/") );
            if(preg_match('/'.$c.'/', $uri)) {
                $this->is_filter = true;
                $s = explode( "/", rtrim( $v, "/" ));
                if( file_exists( ABSPATH."controller/".$s[0].".php" ) || file_exists( ABSPATH."controller/".ucfirst($s[0]).".php" ) ){
                    $this->controller = ucfirst($s[0]);
                    $this->method = $s[1];
                    $this->include = "controller/".$this->controller.".php";
                    unset($s[0]);
                    unset($s[1]);
                }elseif(file_exists( ABSPATH."controller/".$s[0]."/".$s[1].".php" ) || file_exists( ABSPATH."controller/".$s[0]."/".ucfirst($s[1]).".php" )){
                    $this->controller = ucfirst($s[1]);
                    $this->include = "controller/".$s[0]."/".$this->controller.".php";
                    $this->method = $s[2];
                    unset($s[0]);
                    unset($s[1]);
                    unset($s[2]);
                }else{
                    $this->include = "controller/".$this->controller.".php";
                }
                $pr = explode( "/", rtrim($uri,"/"));
                unset($pr[0]);
                $param = $pr ? array_values( $pr ) : array();
                $this->param = $param;
            }
        }
        /**
         * command line
         */
        $options = getopt("c:m:p:");

        if ($options && !empty($options) && isset($options['c']) && isset($options['m'])) {

            $this->controller = $options['c'];
            $this->method = $options['m'];
        }

        if ($options && !empty($options) && isset($options['p'])) {

            $this->param = is_array($options['p'])? $options['p']: array($options['p']);
        }

        if(empty($this->include)){
            $this->include = "controller/".$this->controller.".php";
        }
        require_once( ABSPATH.$this->include );

        /*
         * Load Controller
         */

        $controller = new $this->controller;
        if (!method_exists($controller, $this->method)) {
            error_page();
        }

        if (!$this->is_filter && !empty($uri)) {
            $_url = explode('/', trim($uri));
            if (!class_exists($_url[0]))
                error_page();
        }

        $filters = $controller->get_filters();
        $fist = substr(trim($this->method), 0, 2);
        if ($fist === '__') return;
        if (array_key_exists($this->method, $filters)) {
            $current_user = Users_Model::get_current_user();
            $_index = array_search(Roles_Model::TYPE_LEVEL_LOGGED_IN, $filters[$this->method]);
            if ($_index !== FALSE) {
                if (Users_Model::is_loged_in()) {
                    call_user_func_array(array($controller, $this->method), $this->param);
                } else {
                    if ($controller->is_ajax()) {
                        echo json_encode(array('status' => 'session_expired'));
                        exit;
                    } else {
                        redirect(base_url('login'));
                    }
                }
            } else if ($current_user && $current_user->check_permission($filters[$this->method])) {
                call_user_func_array(array($controller, $this->method), $this->param);
            } else {
                if ($controller->is_ajax()) {
                    echo json_encode(array('status' => 'session_expired'));
                    exit;
                } else {
                    redirect(base_url());
                }
            }
        } else {
            call_user_func_array(array($controller, $this->method), $this->param);
        }

    }
} 