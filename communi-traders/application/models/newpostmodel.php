<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Newpostmodel extends CI_Model {

    public function index() {
        return true;
    }

    public function insertNewThread($data, $game_id) 
    {
        $this->load->model('authmodel');
        $this->load->model('rooms_model');
        if (!$this->rooms_model->get_room_status_by_forum_id($data['forumid'])) {
			$data['forumid'] = $this->rooms_model->get_default_room();
		};
		$url  = $this->config->item('base_url');
        $user_info = $this->authmodel->getUserParam();
        $date = time();
        
        $ipaddress = $_SERVER["REMOTE_ADDR"];
		$data['comment_kw'] = '';
        $thread_array = array(
            'title'        => $data['title'],
            'postuserid'   => $user_info['userId'],
            'postusername' => $user_info['userName'],
            'lastposter'   => $user_info['userName'],
            'lastposterid' => $user_info['userId'],
            'lastposterid' => $user_info['userId'],
            'forumid'      => $data['forumid'],
            'open'         => 1,
            'iconid'       => $data['iconid'],
            'visible'      => 1,//$data['visible'],
            'keywords'     => $data['comment_kw'],
            'dateline'     => $date,
            'lastpost'     => $date
        );
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->insert('thread', $thread_array);
        
        $this->db->select('threadid');
        $this->db->from('thread');
        $this->db->where('postuserid', $user_info['userId']);
        $this->db->order_by("threadid", "desc");
        $array = $this->db->get();
        $result = $array->result_array();
         
        $this->mysmarty->assign("chart_message", $data['comment_field']);
        $this->mysmarty->assign("game_id", $game_id);
        $this->mysmarty->assign("url", $url);
        $this->mysmarty->assign("forum_url", $this->config->item('forum_url'));
        $this->mysmarty->assign("title",$data['title']);
        $msg = $this->mysmarty->fetch("analysis_attachment.tpl");
        $post_array = array(
            'threadid'    => $result[0]['threadid'],
            'title'       => $data['title'],
            'username'    => $user_info['userName'],
            'userid'      => $user_info['userId'],
            'dateline'    => $date,
            'visible'     => 1,
            'pagetext'    => $msg,
            'allowsmilie' => 1,
            'ipaddress'   => $ipaddress
        );
        
        $this->db->insert('post', $post_array);



        //get inserted post object
        $this->db->select('*');
        $this->db->from('post');
        $this->db->where('userid', $user_info['userId']);
        $this->db->order_by('postid', 'DESC');
        $this->db->limit(1);
        $res  = $this->db->get();
        $data = $res->result_array();
        $post_data = $data[0];

        //update thread info
        $this->db->select('*');
        $this->db->from('thread');
        $this->db->where('threadid', $result[0]['threadid']);
        $array = $this->db->get();
        $data_thread = $array->result_array();

        $thread_update_array = array(
            'firstpostid'    => $post_data['postid'],
            'lastpostid'    => $post_data['postid'],
            "lastpost" => $date,
            "replycount" => $data_thread[0]["replycount"]+1,
            "lastposter" => $user_info['userName'],
            "lastposterid" => $user_info['userId'],
            "dateline" => $date,

        );

        $this->db->where('threadid', $result[0]['threadid']);
        $this->db->update('thread', $thread_update_array);

        $this->db = $this->load->database('default', TRUE, TRUE);
        //set post_id in game

        $data = array(
            "post_id" => $post_data['postid'],
            "thread_url" => $result[0]['threadid']."-".str_replace(" ", "-", $data_thread[0]['title'])
        );

        $this->db->where('id', $game_id);
        $this->db->update('game', $data);

        return $data_thread[0]['threadid'];
        
        //redirect($this->config->item('forum_url').'showthread.php/'.$result[0]['threadid']);
    }


    public function postInThread($data, $game_id, $thread_id)
    {

        $this->load->model('authmodel');
        $user_info = $this->authmodel->getUserParam();
        $date = time();

        $ipaddress = $_SERVER["REMOTE_ADDR"];
		$url  = $this->config->item('base_url');
        $this->mysmarty->assign("chart_message", $data['comment_field']);
        $this->mysmarty->assign("url", $url);
        $this->mysmarty->assign("game_id", $game_id);
        $this->mysmarty->assign("forum_url", $this->config->item('forum_url'));
        $this->mysmarty->assign("title",$data['title']);
        $msg = $this->mysmarty->fetch("analysis_attachment.tpl");
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $post_array = array(
            'threadid'    => $thread_id,
            'title'       => $data['title'],
            'username'    => $user_info['userName'],
            'userid'      => $user_info['userId'],
            'dateline'    => $date,
            'visible'     => 1,
            'pagetext'    => $msg,
            'allowsmilie' => 1,
            'ipaddress'   => $ipaddress
        );

        $this->db->insert('post', $post_array);

        //get inserted post object
        $this->db->select('*');
        $this->db->from('post');
        $this->db->where('userid', $user_info['userId']);
        $this->db->order_by('postid', 'DESC');
        $this->db->limit(1);
        $res  = $this->db->get();
        $data = $res->result_array();
        $post_data = $data[0];


        //update thread info
        $this->db->select('*');
        $this->db->from('thread');
        $this->db->where('threadid', $thread_id);
        $array = $this->db->get();
        $thread_result = $array->result_array();

        $thread_update_array = array(
            'lastpostid'    => $post_data['postid'],
            "lastpost" => $date,
            "replycount" => $thread_result[0]["replycount"]+1,
            "lastposter" => $user_info['userName'],
            "lastposterid" => $user_info['userId'],
            "dateline" => $date,

        );

        $this->db->where('threadid', $thread_id);
        $this->db->update('thread', $thread_update_array);

        $this->db = $this->load->database('default', TRUE, TRUE);
        //set post_id in game

        $data = array(
            "post_id" => $post_data['postid'],
            "thread_url" => $thread_id . "-" . str_replace(" ", "-", $thread_result[0]['title'])
        );

        $this->db->where('id', $game_id);
        $this->db->update('game', $data);

        return $post_data['postid'];

        //redirect($this->config->item('forum_url').'showthread.php/'.$result[0]['threadid']);
    }
	public function get_post($postid)
	{
		$this->db = $this->load->database('offpista', TRUE, TRUE);
		$this->db->select('dateline');
        $this->db->from('post');
        $this->db->where('postid', $postid);
        $array = $this->db->get();
		return $array->result_array();
	}
	public function update_post($post_id)
	{
		$this->db = $this->load->database('offpista', TRUE, TRUE);
		$data = array('looked'=>1);
		$this->db->where('postid', $post_id);
		$this->db->update('post', $data);
		
	}
	public function get_user_post_count($userid)
	{
		$this->db = $this->load->database('offpista', TRUE, TRUE);
		$this->db->select('id');
		$this->db->from('post');
		$this->db->where('userid', $userid);
		$this->db->join('thread','thread.threadid=post.threadid');
        $count = $this->db->count_all_results();
		return $count;
	}

}
