<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Howtoplay extends MX_Controller {

    public function _this(){
        $this->index();
    }
    
    public function index() {
       $this->load->model('menu_model');
        $tool_menu = $this->menu_model->createMenu();
        $this->mysmarty->assign('tool_menu',$tool_menu);
    }

}

/* End of file header.php */
/* Location: ./application/controllers/header.php */