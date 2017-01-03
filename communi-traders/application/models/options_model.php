<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Options_model extends CI_Model {

    public function index() {
        return true;
    }

    public function getToolsOptions() {
        $what = $this->_getWhatValues();
        $strategy = $this->_getStrategyValues();
        $expiry = $this->_getExpiryValues();
        $investment = $this->_getInvestmentValues();
        $userCache = $this->_getUserBalanceValue();
        $array = array(
            "what" => $what,
            "strategy" => $strategy,
            "expiry" => $expiry,
            "investment" => $investment,
            "userCache" => $userCache
        );
        $this->isLoggedToday();
        return $array;
    }

    public function _getWhatValues() {
        /* select the WHAT values - currency,metalls,company */

        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('symbols_currency');
        $this->db->where('visibility', 1);
        $this->db->order_by("short_name", "asc");
        $res = $this->db->get();
        $symbols_currency = $res->result_array();

        //$this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('symbols_metall');
        $this->db->where('visibility', 1);
        $this->db->order_by("short_name", "asc");
        $res = $this->db->get();
        $symbols_metall = $res->result_array();

        //$this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('symbols_company');
        $this->db->where('visibility', 1);
        $this->db->order_by("short_name", "asc");
        $res = $this->db->get();
        $symbols_company = $res->result_array();
        
        //$this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('symbols_indices');
        $this->db->where('visibility', 1);
        $this->db->order_by("short_name", "asc");
        $res = $this->db->get();
        $symbols_indices = $res->result_array();

        $data = array(
            "symbols_currency" => $symbols_currency,
            "symbols_metall" => $symbols_metall,
            "symbols_company" => $symbols_company,
            "symbols_indices" => $symbols_indices
        );

        return $data;
    }

    public function _getStrategyValues() {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game_strategy');
        $this->db->order_by("sort", "asc");
        $res = $this->db->get();
        $array = $res->result_array();
        for ($i = 0; $i < count($array); $i++) {
            $array[$i]['short_name'] = preg_replace("/\s/", '_', $array[$i]['short_name']);
        }
        return $array;
    }

    public function _getExpiryValues() {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('expiry_time');
        $this->db->order_by("sort", "asc");
        $res = $this->db->get();
        $array = $res->result_array();
        return $array;
    }

    public function _getInvestmentValues() {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game_investment');
        $this->db->limit(1);
        $res = $this->db->get();
        $array = $res->result_array();

        $min_value = $array[0]['min_value'];
        $max_value = $array[0]['max_value'];
        $value_increment = $array[0]['value_increment'];
        $data = array();
        $i = 0;
        while ($min_value <= $max_value) {
            $data[$i]['value'] = $min_value;
            $min_value = $min_value + $value_increment;
            $i++;
        }

        return $data;
    }

    public function _getUserBalanceValue() {
        $this->load->model('authmodel');
        $userParam = $this->authmodel->getUserParam();

        $this->load->model('money_model');
        $userCahe = $this->money_model->getUserBalance($userParam['userId']);

        return $userCahe;
    }

    public function getStrategyPromt($shortName) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('promt');
        $this->db->from('game_strategy');
        $this->db->where('short_name', $shortName);
        $this->db->limit(1);
        $res = $this->db->get();
        $array = $res->result_array();

        return $array[0]['promt'];
    }
    
    public function getDefaultAsset($forumid)
    {
        $forumid = trim($forumid);
        $def_asset = 'AAPL';
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('def_asset');
        $this->db->from('forum_rooms');
        $this->db->where('forumid', $forumid);
        $res  = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            $def_room = $data[0]['def_asset'];
        }
        return $def_asset;
    }
    
    private function isLoggedToday()
    {
        $this->load->model('authmodel');
        $user_param = $this->authmodel->getUserParam();
        $user_id    = $user_param['userId'];
        $this->db = $this->load->database('default', TRUE, TRUE);
        $date = date('Y-m-d');
        $this->db->select('user_id');
        $this->db->from('login_log');
        $this->db->where('user_id', $user_id);
        $this->db->where('last_login', $date);
        $res  = $this->db->get();
        $data = $res->result_array();
		//print_r($data);die;
        if (count($data) > 0) {
            return;
        }
        else {
            $data = array('user_id' => $user_id, 'last_login' => $date);
            $this->db->insert('login_log', $data);
        }
    }
	
}
