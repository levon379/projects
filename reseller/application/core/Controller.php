<?php

class Controller extends CI_Controller {

//    private static $instance;
    public $menu_active = 'home';
    public $submenu_active = 'home';
    public $admin_menus = null;
    public $page_title = 'Codeigniter CMS';
    public $site_title = 'Codeigniter CMS';
    public $_js_variables = array();
    public $userlogin = array();

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

    public function __construct($menu = '') {
//        self::$instance =& $this;
        parent::__construct();
        $this->load->model('users_model');
        $this->load->library('Menu');
        $this->menu_reseller = $menu."_menu";
        $user['email'] = $this->session->userdata('email');
        $this->userlogin = (object)$this->users_model->getUser($user)[0];
    }

    function view_front($dis, $include = true) {
        $dis['this'] = $this;
        $dis['page_title'] = $this->page_title;
        $dis['site_title'] = $this->site_title;
//        $admin_login = $this->session->userdata('login');
//        $dis['userlogin'] = Users_Model::find_by_user_id( $admin_login['user_id'] );
        $dis['js_variables'] = $this->_js_variables;
        $dis['js_scripts'] = $this->_js;
        $dis['csses'] = $this->_css;
        $dis['content'] = 'frontend/' . $dis['view'];
        $dis['userlogin'] = "";
        $user_login = (array) $this->userlogin;
        if(!empty( $user_login )){
            $dis['userlogin'] = $this->userlogin;
        }
        if (!isset($dis['menu_active']) || empty($dis['menu_active'])) {
            $dis['menu_active'] = $this->menu_active;
        }
        if ($include) {
            $this->load->view('front_layout/content', $dis);
        } else {
            $this->load->view($dis['view'], $dis);
        }
    }

    function view_admin($dis, $include = true) {
        if(!$this->session->userdata('logged_in')){
            redirect('/login');
        }
        $dis['base_url'] = base_url();
        $dis['this'] = $this;
        $dis['page_title'] = $this->page_title;
        $dis['site_title'] = $this->site_title;
        $dis['js_variables'] = $this->_js_variables;
        $dis['js_scripts'] = $this->_js;
        $dis['csses'] = $this->_css;
        $dis['content'] = 'backend/' . $dis['view'];       
        $dis['main_menu'] = new Menu($this->menu_reseller);
        $dis['userlogin'] = $this->userlogin;
//        $admin_login = $this->session->userdata('login');
//        $this->load->model('Users_Model');
//        if (empty($admin_login))
//            redirect(BASE_URL . "Users/login");
//        $dis['userlogin'] = Users_Model::find_by_user_id($admin_login['user_id']);

        if (!isset($dis['menu_active']) || empty($dis['menu_active'])) {
            $dis['menu_active'] = $this->menu_active;
        }

        if ($include) {
            $this->load->view('admin_layout/content', $dis);
        } else {
            $this->load->view($dis['view'], $dis);
        }
    }

    public function layout($type = '', $views = '', $data = array(), $menu = false) {
        $dis['base_url'] = BASE_URL;
        $dis['this'] = $this;
        $dis['page_title'] = $this->page_title;
        $dis['site_title'] = $this->site_title;
        $dis['js_variables'] = $this->_js_variables;
        $dis['js_scripts'] = $this->_js;
        $dis['csses'] = $this->_css;
        if (!$menu) {
            $dis['main_menu'] = $this->main_menu;
        } else {
            $dis['main_menu'] = new Menu($menu);
        }
        $login = $this->session->userdata('login');

        $this->load->model('Users_Model');
        $dis['userlogin'] = Users_Model::find_by_user_id($login['user_id']);

        if (!isset($dis['menu_active']) || empty($dis['menu_active'])) {
            $dis['menu_active'] = $this->menu_active;
        }

        $data = array_merge($dis, $data);

        $this->load->view("layout/$type/header", $data);
        $this->load->view($views, $data);
        $this->load->view("layout/$type/footer", $data);
    }

}
