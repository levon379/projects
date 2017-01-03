<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Money_model extends CI_Model {

    public function index() {
        return true;
    }

    public function getUserBalance($user_id) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('user_cache,username');
        $this->db->from('user_money');
        $this->db->where('user_id', $user_id);
        $res = $this->db->get();
        $array = $res->result_array();
        if (count($array) == 0) {
            $this->createUserCache($user_id);
            //$this->getUserCache($user_id);
            $this->db->select('user_cache');
            $this->db->from('user_money');
            $this->db->where('user_id', $user_id);
            $res = $this->db->get();
            $array = $res->result_array();
        }
        return $array[0];
    }
    
    public function getResetCounter($user_id) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('reset_counter');
        $this->db->from('user_money');
        $this->db->where('user_id', $user_id);
        $res = $this->db->get();
        $array = $res->result_array();
       
        return $array[0]['reset_counter'];
    }

    public function createUserCache($user_id) {
        $userdata = $this->getUserData($user_id);
        $data  = array(
            'user_id'       => $user_id,
            'user_cache'    => 20000,
            'reset_counter' => 0,
            'email'         => $userdata['email'],
            'username'      => $userdata['username']
        );
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->insert('user_money', $data);
    }
    
    private function getUserData($user_id)
    {
        $this->db  = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select();
        $this->db->from('user');
        $this->db->where('userid', $user_id);
        $res   = $this->db->get();
        $data  = $res->result_array();
        return $data[0];
        
    }
    
    public function renewUserBalance($userId, $userBalance){
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('reset_counter');
        $this->db->from('user_money');
        $this->db->where('user_id', $userId);
        $res = $this->db->get();
        $array = $res->result_array();
        
        $userCounter = $array[0]['reset_counter'];
        $userCounter++;
        $data = array(
            'user_cache' => $userBalance,
            'reset_counter'=> $userCounter           
        );
        
        //$this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->where('user_id',$userId);
        $this->db->update('user_money',$data);
        
        return TRUE;
    }
}
