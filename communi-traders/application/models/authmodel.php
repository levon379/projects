<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authmodel extends CI_Model {

    public function index() {
        return true;
    }

    public function getCSRF() {
        $str = '<input type="hidden" name="' . $this->security->get_csrf_token_name() . '" value="' . $this->security->get_csrf_hash() . '" />';
        return $str;
    }
	public function getCSRF_cash() {
        $str = $this->security->get_csrf_hash();
        return $str;
    }

    public function chekauth() {
        $bb__sessionhash = $_COOKIE['bb_sessionhash'];
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select('loggedin');
        $this->db->from('session');
        $this->db->where('sessionhash', $bb__sessionhash);
        $arry = $this->db->get();
        $result = $arry->result_array();
        $this->setSession();
		
        if ($result[0]['loggedin'] > 0) {
            $this->setSession();
            return TRUE;
        } else {
            redirect($this->config->item('forum_url').'threads/4772-CommuniTraders-Troubleshooting-amp-Suggestions');
        }
    }

    public function getLocation() {
        $bb__sessionhash = $_COOKIE['bb_sessionhash'];
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select('location');
        $this->db->from('session');
        $this->db->where('sessionhash', $bb__sessionhash);
        $arry = $this->db->get();
        $result = $arry->result_array();
        $location = explode('=', $result[0]['location']);
        if (count($location) < 2) {
            $this->db = $this->load->database('default', TRUE, TRUE);
            $this->load->model('rooms_model');
            $location[1] = $this->rooms_model->get_default_room();
        }
        /*$this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select('title,forumid');
        $this->db->from('forum');
        $this->db->where('forumid', $location[1]);
        $arry = $this->db->get();
        $result = $arry->result_array();*/
        return $location;
    }

    public function setSession() {
        $bb__sessionhash = $_COOKIE['bb_sessionhash'];
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select();
        $this->db->from('session');
        $this->db->where('sessionhash', $bb__sessionhash);
        $arry = $this->db->get();

        $result = $arry->result_array();
        $result[0]['lastactivity'] = time();
        $data = $result[0];
        $this->db->where('sessionhash', $bb__sessionhash);
        $this->db->update('session', $data);
        return TRUE;
    }

    public function getUserParam() 
	{
        $user_id = '';
        $bb__sessionhash = $_COOKIE['bb_sessionhash'];
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select();
        $this->db->from('session');
        $this->db->where('sessionhash',$bb__sessionhash);     
        $res  = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            $user_id = $data[0]['userid'];
            $this->set_session_vars($user_id);
        }
        if ($user_id > 0){
            $userName = $this->getUserName($user_id);
        }
        if ($user_id > 0 && $userName != '') {
            $data = array(
                'userId' => $user_id,
                'userName' => $userName
            );
        } 
        else {
            $user_id   = $this->session->userdata('user_id');
            $user_name = $this->getUserName($user_id);
            $data = array(
                'userId' => $user_id,
                'userName' => $user_name
            );
        }
        return $data;
    }

    public function getUserName($userId) {
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select('username');
        $this->db->from('user');
        $this->db->where('userid', $userId);
        $arry = $this->db->get();
        $result = $arry->result_array();
        if (count($result) > 0) {
            $userName = $result[0]['username'];
        } else {
            $userName = 'name';
        }
        return $userName;
    }

    public function getUser($login, $password) {
        $hash = $this->getPasswordHash($password);
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('users');
        $this->db->where('username', $login);
        $this->db->where('password', $hash);
        $this->db->limit(1);
        $arry = $this->db->get();
        $result = $arry->result_array();
        if (count($result) > 0) {
            $data = array('is_logged' => 1, 'user_role' => 1);
            $this->session->set_userdata($data);
            return true;
        } else {
            return false;
        }
    }

    public function getPasswordHash($password) {
        $solt = $this->config->item('solt');
        return sha1($solt . sha1($solt . $password));
    }
    
    private function set_session_vars($user_id)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->load->library('session');
        $this->session->set_userdata('user_id', $user_id);
    }
	public function first_login($id){
		$this->db = $this->load->database('default', TRUE, TRUE);
		$this->db->select('last_login');
        $this->db->from('login_log');
        $this->db->where('user_id', $id);
		$arry = $this->db->get();
		return $arry->result_array();
	}
	

	
	
}
