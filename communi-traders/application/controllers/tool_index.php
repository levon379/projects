<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tool_index extends MX_Controller {

    public function _this() {
        Tool_index::index();
    }

    public function index() {
		
        $CI =& get_instance();
        $this->load->model('authmodel');
		$user_id = $this->session->userdata('user_id');
		$login_log = $this->authmodel->first_login($user_id);
		$this->mysmarty->assign('login_log', $login_log); 
		//$html = $this->mysmarty->fetch('last_closed_games.tpl');
		
		
        $ci_csrf_token = $this->authmodel->getCSRF();
        $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);
       
        $validation_erros = $this->session->flashdata('msg');
        $this->mysmarty->assign('validation_erros', $validation_erros);
        $this->session->set_flashdata('msg', '');
        
        $inputRows = $this->session->flashdata('inputRows');
        $this->mysmarty->assign('inputRows', $inputRows);
        $this->session->set_flashdata('inputRows', '');
        
        $this->load->model('menu_model');
        $tool_menu = $this->menu_model->createMenu();
        $this->mysmarty->assign('tool_menu',$tool_menu);
        
        $this->load->model('gamemodel');
        $news = $this->gamemodel->get_news('AAPL');
        $this->mysmarty->assign('news', $news);
	
        $this->load->model('options_model');
        $data = $this->options_model->getToolsOptions();

        $symbols_currency = $data['what']['symbols_currency'];
        $symbols_metall = $data['what']['symbols_metall'];
        $symbols_company = $data['what']['symbols_company'];
        $symbols_indices = $data['what']['symbols_indices'];
        $strategy = $data['strategy'];
        $expiry = $data['expiry'];
        $investment = $data['investment'];
        $userCache = $data['userCache'];
        $currentTrades = array();
                      
        $location = $this->authmodel->getLocation();
       
		$forumid = '';
		
        if (preg_match("/^\d+/", $location[0])) {
            $forumid  = $location[0];
        }
        else { 
            if (preg_match("/^\d+/", $location[1])) {
                $forumid  = $location[1];
            }
        }
		
		$this->load->model('timezone_model');
		$time = $this->timezone_model->get_time_zone();
		$time_to = array();
		$now_time = date('H:m:s');
		foreach($time as $key=>$value){
			$t_1 = strtotime(date('H:m:s',strtotime($value['close_time'])));
			$t_2 = strtotime($now_time);
			$diff = $t_1 - $t_2;
			$isclose = false;
			if($diff <= 0){
				$isclose = true;
			}
			$time_to[] = array('name'=>$value['name'],'open_time'=>$value['open_time'],'close_time'=>$value['close_time'],'isclosed'=>$isclose);
			
		}

		$game = $this->gamemodel->get_user_game($user_id);
        $default_asset = $this->options_model->getDefaultAsset($forumid);
        $this->load->model('rooms_model');
        $link = $this->rooms_model->get_real_trade_link();

        $this->mysmarty->assign('link', $link);
        $this->mysmarty->assign('now_time', $now_time);
        $this->mysmarty->assign('default_asset', $default_asset);
        $this->mysmarty->assign('location', $forumid); 
        $this->mysmarty->assign('time', $time_to); 
        $this->mysmarty->assign('game', $game); 
        $this->mysmarty->assign('userid',$user_id); 
        $this->mysmarty->assign('symbols_currency',$symbols_currency);
        $this->mysmarty->assign('symbols_metall',$symbols_metall);
        $this->mysmarty->assign('symbols_company',$symbols_company);
        $this->mysmarty->assign('symbols_indices',$symbols_indices);
        $this->mysmarty->assign('strategy',$strategy);
        $this->mysmarty->assign('expiry',$expiry);
        $this->mysmarty->assign('investment',$investment);
        $this->mysmarty->assign('userCache',$userCache);
        $this->mysmarty->assign('forum_url', $this->config->item('forum_url'));
        $this->mysmarty->assign('url', $this->config->item('base_url'));
        $this->mysmarty->assign('currentTrades', $currentTrades);
        $this->mysmarty->assign('reply_to_thread', intval($CI->input->get("reply")));
        $this->mysmarty->view('index_main');
        return true;
    }
}
/* End of file main.php */
/* Location: ./application/controllers/main.php */
