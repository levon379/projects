<?php
/**
 * Created by PhpStorm.
 * User: HuuHien
 * Date: 5/15/2015
 * Time: 9:20 PM
 */

use Facebook\FacebookSession;

use Facebook\FacebookRedirectLoginHelper;

use Facebook\FacebookRequest;

use Facebook\FacebookResponse;

use Facebook\FacebookSDKException;

use Facebook\FacebookRequestException;

use Facebook\FacebookAuthorizationException;

use Facebook\GraphObject;

use Facebook\Entities\AccessToken;

use Facebook\HttpClients\FacebookCurlHttpClient;

use Facebook\HttpClients\FacebookHttpable;

class Controller {

    private static $instance;
    public $menu_active = 'home';
    public $submenu_active = 'home';
    public $admin_menus = null;
    public $page_title = 'Codeigniter CMS';
    public $site_title = 'Codeigniter CMS';
    public $_js_variables = array();

    const IFRAME_ACCESS_DENY = 'DENY';
    const IFRAME_ACCESS_SELF_DOMAIN = 'SAMEORIGIN';
    /**
     * array ('type' => admin | front, 'file' => 'script.js', 'location' => header | footer)
     * @var array
     */
    public $_js = array();
    /**
     * array ('type' => admin | front, 'file' => 'style.css')
     * @var array
     */
    public $_css = array();

    /**
     * array (action_name => Role_level)
     * @var array
     */
    private $filters = array();

    public function __construct()
    {
        self::$instance =& $this;
        $this->load = new Loader();
        $this->load->library('Session');
        $this->session = new Session();
        // token verifier
        $this->load->library('FormToken/FormToken');
        $this->formToken = new FormToken();
        $this->load->library('Swiftmailer');
        $this->load->library('google/BloggerAPI');
        $this->email = new Swiftmailer();
        $this->load->helper('config');
        $this->load->helper('common');
        $this->load->helper('url');
        $this->load->model('Users_Model');
        $this->load->model('Roles_Model');
        $this->load->model('Api_model');
        $this->load->library('Gridview/Gridview');
        $this->load->library('Menu/Menu');
        $this->main_menu = new Menu();

        /**
         * Run migrate
         */
        /*switch (PHP_OS) {
            // Windows
            case "CYGWIN_NT-5.1":
            case "WIN32":
            case "WINNT":
            case "Windows":
                exec(sprintf("cd %svendor/; bin/phinx.bat migrate -e development; > /dev/null &", ABSPATH), $output);
                break;
            // Unix
            case "Darwin":
            case "FreeBSD":
            case "HP-UX":
            case "IRIX64":
            case "Linux":
            case "NetBSD":
            case "OpenBSD":
            case "SunOS":
            case "Unix":
            default:
                exec(sprintf("cd %svendor/; bin/phinx migrate -e development; > /dev/null &", ABSPATH), $output);
                break;
        }*/

        if ($login_info = $_SESSION['login']) {
            Users_Model::set_current_user(Users_Model::first(array('user_id' => $login_info['user_id'])));
        }
        $this->load->model('Media_Model');
        $this->load->library('Media/media');
        $this->medialibrary = new Medialibrary();
    }

    public static function &get_instance()
    {
        return self::$instance;
    }

    public function set_filters($filters = array())
    {
        $this->filters = $filters;
    }

    public function get_filters()
    {
        return $this->filters;
    }

    function view_front($dis, $include = true){
        $dis['this'] = $this;
        $dis['page_title'] = $this->page_title;
        $dis['site_title'] = $this->site_title;
        $admin_login = $this->session->userdata('login');
        $dis['userlogin'] = Users_Model::find_by_user_id( $admin_login['user_id'] );
        if( $dis['view'] == "init/home"){
            $dis['home'] = true;
        }
        if( $dis['view'] == "users/singup" || $dis['view'] == "users/login"){
            $dis['signup'] = true;
        }
        if( $dis['view'] == "users/login" || $dis['view'] == "users/forgot"){
            $dis['login'] = true;
        }
        
        $dis['js_variables'] = $this->_js_variables;
        $dis['js_scripts'] = $this->_js;
        $dis['csses'] = $this->_css;

        if (!isset($dis['menu_active']) || empty($dis['menu_active'])) {
            $dis['menu_active'] = $this->menu_active;
        }
        if( $include ) {
            $this->load->view('front/init/header', $dis);
            $this->load->view('front/'.$dis['view'],$dis);
            $this->load->view('front/init/footer',$dis);
        }else{
            $this->load->view($dis['view'], $dis );
        }
    }
    function view_admin($dis, $include = true){
        $dis['base_url'] = BASE_URL;
        $dis['this'] = $this;
        $dis['page_title'] = $this->page_title;
        $dis['site_title'] = $this->site_title;
        $dis['js_variables'] = $this->_js_variables;
        $dis['js_scripts'] = $this->_js;
        $dis['csses'] = $this->_css;
        $admin_login = $this->session->userdata('login');
        $this->load->model('Users_Model');
        if( empty( $admin_login ) ) redirect( BASE_URL."Users/login");
        $dis['userlogin'] = Users_Model::find_by_user_id( $admin_login['user_id'] );

        if (!isset($dis['menu_active']) || empty($dis['menu_active'])) {
            $dis['menu_active'] = $this->menu_active;
        }
        if( $include ) {
            $this->load->view('dashboard/init/header', $dis);
            $this->load->view('dashboard/init/menu');
            $this->load->view('dashboard/'.$dis['view']);
            $this->load->view('dashboard/init/footer');
        }else{
            $this->load->view($dis['view'], $dis );
        }
    }

    public function layout($type = '', $views = '', $data = array())
    {
        $dis['base_url']        = BASE_URL;
        $dis['this']            = $this;
        $dis['page_title']      = $this->page_title;
        $dis['site_title']      = $this->site_title;
        $dis['js_variables']    = $this->_js_variables;
        $dis['js_scripts']      = $this->_js;
        $dis['csses']           = $this->_css;
        $dis['main_menu']       = $this->main_menu;
        $dis['count_notification'] = count(Notification_Model::all(array('conditions'=>array('user_id = ? AND status = ?', Users_Model::get_current_user()->id, 0))));
        $login                  = $this->session->userdata('login');

        $this->load->model('Users_Model');
        $dis['userlogin'] = Users_Model::find_by_user_id( $login['user_id'] );

        if (!isset($dis['menu_active']) || empty($dis['menu_active'])) {
            $dis['menu_active'] = $this->menu_active;
        }

        $data = array_merge($dis, $data);

        $this->load->view("layout/$type/header", $data);
        $this->load->view($views, $data);
        $this->load->view("layout/$type/footer", $data);
    }

    /**
     * Return is ajax request
     * @return bool
     */
    public function is_ajax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest");
    }

    public function ajax_response($data, $status = 200)
    {
        header("Content-Type: application/json");
        header("HTTP/1.1 " . $status . " " . $this->__requestStatus($status));
        echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        die;
    }

    private function __requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code])?$status[$code]:$status[500];
    }

    public function access_iframe($access = self::IFRAME_ACCESS_SELF_DOMAIN)
    {
        header(sprintf('X-Frame-Options: %s', $access));
    }
}