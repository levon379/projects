<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Myperformance extends MX_Controller {

    public function index() {
        return true;
    }

    public function getStatictics() {      
        
        $this->load->model('authmodel');
        $ci_csrf_token = $this->authmodel->getCSRF();
        $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);

        $data = $this->authmodel->getUserParam();
        $this->mysmarty->assign('user_name', $data['userName']);    
        $this->load->model('statistic_model');
        $aboutRows = $this->statistic_model->getAboutData($data['userId']);
        $this->mysmarty->assign('aboutRows', $aboutRows);
        $this->mysmarty->assign('user_id', $data['userId']);
        $this->mysmarty->assign('forum_url', $this->config->item('forum_url'));
        
        $this->load->model('statistic_model');
        $performanceRows = $this->statistic_model->getPerformanceData($data['userId']);

        $this->mysmarty->assign('performanceRows', $performanceRows);

        $rows = $this->statistic_model->getStatisticData($data['userId']);
		
        $user_name = $this->statistic_model->getUserName($data['userId']);
        $this->mysmarty->assign('user_name', $user_name);
        
        $currentTrades = $rows['currentTrades'];
        $this->mysmarty->assign('currentTrades', $currentTrades);
        
        $finishedTrades = $rows['finishedTrades'];
        $this->mysmarty->assign('finishedTrades', $finishedTrades);

        $this->load->model('menu_model');
        $tool_menu = $this->menu_model->createMenu();
        $this->mysmarty->assign('tool_menu', $tool_menu);
        
        $send = $this->statistic_model->getAlert($data['userId']);
        $this->mysmarty->assign('send', $send);

        $this->mysmarty->view('statistic_main');
    }
}
