<?php

class Users_model extends CI_Model {

    var $title = '';
    var $content = '';
    var $date = '';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getUser($userdata,$user_info = false) {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('email', $userdata['email']);
        if($user_info){
            $this->db->where('pass', md5($userdata['password']));
        }
        
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->result_array();
    }
    
    public function getAllUser() {
        $this->db->select();
        $this->db->from('users');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->result_array();
    }
    
    public function signUp($data, $return_id = false) {
        $array = array(
            'active' => $data['active'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'pass' => MD5($data['password1'] . now()),
            'registration_date' => date("Y-m-d H:i:s"),
            'type' => $data['account_type']
        );

        $this->db->set($array);
        $this->db->insert('users');
        if ($return_id) {
            return $this->db->insert_id();
        }
        return true;
    }
    public function delete($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->delete('users');
    }

}
