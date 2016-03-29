<?php

class Menu {

    public $config = array();

    public function __construct($menu = 'reseller_menu') {
        $this->config['menu'] = $this->get_menu($menu);
    }

    function render() {
        $this->view('backend', $this->config);
    }

    function is_active($menu_item) {
        $str_in = $_SERVER['REQUEST_URI'];
        $uri_out = explode('/', preg_replace('/^\/|\/$/', '', trim($menu_item['url'])));
        return strpos($str_in, $uri_out[0]) !== false;
    }

    public function view($view = '', $dis = array(), $return = false) {  
        if (!file_exists(ABSPATH . "application/views/menu/{$view}.php"))
            return;

        extract($dis);
        
        ob_start();
        include(ABSPATH . "application/views/menu/{$view}.php");
        $html = ob_get_contents();
        ob_end_clean();

        if (!$return) {
            echo $html;
        } else {
            return $html;
        }
    }

    public function get_menu($menu = false) {
        $file = ABSPATH . "application/config/$menu.php";
        if (file_exists($file)) {
            return include ($file);
        }
        return false;
    }

}
