<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends MX_Controller {

    public function index() {
        return true;
    }

    public function _this() {      
        
        $user_id = $this->uri->segment(3);
            
        $this->load->model('statistic_model');
        $aboutRows = $this->statistic_model->getAboutData($user_id);
        $this->mysmarty->assign('aboutRows', $aboutRows);
        
        $this->load->model('statistic_model');
        $performanceRows = $this->statistic_model->getPerformanceData($user_id);

        $this->mysmarty->assign('performanceRows', $performanceRows);

//        $rows = $this->statistic_model->getStatisticData($user_id);
        $user_name = $this->statistic_model->getUserName($user_id);
        $this->mysmarty->assign('user_name', $user_name);
        
//        $currentTrades = $rows['currentTrades'];
        $currentTrades = array();
        $this->mysmarty->assign('currentTrades', $currentTrades);
        
       $finishedTrades = $this->statistic_model->getClosedGames($user_id);
//      $finishedTrades = $rows['finishedTrades'];
        $this->mysmarty->assign('finishedTrades', $finishedTrades);

        $this->load->model('menu_model');
        $tool_menu = $this->menu_model->createMenu();
        $this->mysmarty->assign('tool_menu', $tool_menu);
        
        $send = $this->statistic_model->getAlert($user_id);
        $this->mysmarty->assign('user_id', $user_id);
    }
}
