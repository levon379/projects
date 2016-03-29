<?php


class Menu
{
    public $instance    = false;
    public $config = array();

    public function __construct()
    {
        $this->instance = Controller::get_instance();
        $this->config['menu'] = get_config('menu');
    }

    function render()
    {
        $this->config['current_user'] = Users_Model::get_current_user();
        $this->view('index', $this->config);
    }

    function render_mobile()
    {
        $this->config['current_user'] = Users_Model::get_current_user();
        $this->view('mobile', $this->config);
    }

    function is_active($menu_item)
    {
        $str_in  = explode('/', preg_replace('/^\/|\/$/', '', trim($_SERVER['REQUEST_URI'])));
        $uri_out = explode('/', preg_replace('/^\/|\/$/', '', trim($menu_item['url'])));
        return $str_in[0] == $uri_out[0];
    }

    public function view($view='', $dis = array(), $return = false )
    {
        if (!file_exists(ABSPATH . "libraries/Menu/views/{$view}.php")) return;

        extract($dis);
        ob_start();
        include(ABSPATH . "libraries/Menu/views/{$view}.php");
        $html = ob_get_contents();
        ob_end_clean();

        if (!$return) {
            echo $html;
        } else {
            return $html;
        }

    }
}