<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Header extends MX_Controller {

    public function index() {
        $this->mysmarty->assign('forum_url', $this->config->item('forum_url'));
        $editor = tinymce($this->config->item("base_url"), 'comment_field', 'exact', 'advanced');
        $this->mysmarty->assign("editor", $editor);

//      $logouthash = $_COOKIE['bb__sessionhash'];
//      $this->mysmarty->assign("logouthash", $logouthash);
//      

		$domein_name = $_SERVER['SERVER_NAME'];

        $this->load->model('authmodel');
        $this->load->model('statistic_model');
        $this->load->model('gamemodel');
		
        $data = $this->authmodel->getUserParam();
        $userName = $data['userName'];
		
        $this->mysmarty->assign("username", $userName);
        $userId = $data['userId'];
				
        $this->mysmarty->assign("userid", $userId);
        $this->mysmarty->assign("domein_name", $domein_name);

		$user_notification = $this->statistic_model->get_follow_users($userId,true,false);	
		$this->mysmarty->assign("follow_not", $user_notification);
		$count_user_follow_notification = count($user_notification);
		
		$this->mysmarty->assign("follow_notification_count_hidden", $count_user_follow_notification);
		
		$user_post_notification = $this->statistic_model->get_post_thread_id($userId);
		$not_empty_comment = array();
		foreach($user_post_notification as $key=>$val)
		{
			$post_comment = $this->statistic_model->get_post_comment_notification($userId,$val['postid'],$val['threadid']);
			if(!empty($post_comment)){
			
				$not_empty_comment = $post_comment;
			}
		}
		//echo "<pre>";
		//print_r($val['postid']);die;
		$count_post_notification = count($not_empty_comment);
		$this->mysmarty->assign("post_comment", $not_empty_comment);
		$this->mysmarty->assign("post_notification_count_hidden", $count_post_notification);
		
		
		
		$expair_game = $this->gamemodel->get_game_expire($userId);
		$this->mysmarty->assign("expair_game", $expair_game);	
		
		$count_expair_game = count($expair_game);
		$this->mysmarty->assign("expair_game_count_hidden", $count_expair_game);
		
		$user_game_like = $this->statistic_model->chek_notification($userId);
		$this->mysmarty->assign("user_game_like", $user_game_like);
		$count_like_notification = count($user_game_like);
		$this->mysmarty->assign("like_notification_count_hidden", $count_like_notification);
		
		$user_post_notification1 = $this->statistic_model->get_post_notification($userId);
		$this->mysmarty->assign("user_post_notification", $user_post_notification1);
		
		
		
		$follow_user_active_game = $this->statistic_model->get_follow_user_active_game($userId);

		$this->mysmarty->assign("follow_user_active_game", $follow_user_active_game);

		$follow_user_game = $this->statistic_model->get_follow_users_trade($userId);

		$count_follow_user_game = 0;
		if(!empty($follow_user_game[0])){
			foreach($follow_user_game[0] as $key=>$val)
			{
				if(!empty($val))
				{
					$count_follow_user_game++;
				}
			}
		}
		$this->mysmarty->assign("follow_user_game_count_hidden", $count_follow_user_game);
//echo "<pre>";
//echo 'count_like_notification: 	'.$count_like_notification.'<br>';
//echo 'count_post_notification: 	'.$count_post_notification.'<br>';
//echo 'count_expair_game: 	'.$count_expair_game.'<br>';
//echo 'count_follow_user_game: 	'.$count_follow_user_game.'<br>';
//echo 'count_user_follow_notification: 	'.$count_user_follow_notification;
//echo "</pre>";
		$notification_count = $count_like_notification + $count_post_notification + $count_expair_game + $count_follow_user_game + $count_user_follow_notification;
		$this->mysmarty->assign("notification_count", $notification_count);

	
        $this->mysmarty->view('header_main');
        $this->mysmarty->view('head');
    }
}
/* End of file header.php */
/* Location: ./application/controllers/header.php */