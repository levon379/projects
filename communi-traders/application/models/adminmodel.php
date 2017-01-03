<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminmodel extends CI_Model {
    public function index() {
        return true;
    }
    
    /**
     * @desc Function  add_new_asset
     * @params $asset, $short_name, $full_name
     * @return 0 or 1
     */
    public function add_new_asset($asset, $short_name, $full_name)
    {
        $asset      = trim($asset);
        $short_name = trim($short_name);
        $full_name  = trim($full_name);
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('id');
        $this->db->from($asset);
        $this->db->where('short_name', $short_name);
        $this->db->where('full_name', $full_name);
        $res  = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            return 0;
        }
        else {
            $data = array('short_name' => $short_name, 'full_name' => $full_name);
            $this->db->insert($asset, $data);
            return 1;
        } 
    }
    
    /**
     * @desc Function get_assets_list 
     * @return $assets_list
     */
    public function get_assets_list()
    {
        $assets_list = array();
        
        $assets_list['stock']       = $this->get_stock_list();
        $assets_list['commodities'] = $this->get_commodities_list();
        $assets_list['currency']    = $this->get_currency_list();
        $assets_list['indices']     = $this->get_indices_list();
        
        return $assets_list;
    }
    
    /**
     * @desc Function get_stock_list
     * @return $data 
     */
    private function get_stock_list()
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('symbols_company');
        $res  = $this->db->get();
        $data = $res->result_array();
        return $data;
    }
    
    /**
     * @desc Function get_commodities_list
     * @return $data 
     */
    private function get_commodities_list()
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('symbols_metall');
        $res  = $this->db->get();
        $data = $res->result_array();
        return $data;
    }
    
    /**
     * @desc Function get_currency_list
     * @return $data 
     */
    private function get_currency_list()
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('symbols_currency');
        $res  = $this->db->get();
        $data = $res->result_array();
        return $data;
    }
    
    /**
     * @desc Function get_indices_list
     * @return $data
     */
    private function get_indices_list()
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('symbols_indices');
        $res  = $this->db->get();
        $data = $res->result_array();
        return $data;
    }
    
    /**
     * Function get_asset_info
     * @params $asset_type, $asset_id
     * @return $data
     */
    public function get_asset_info($asset_type, $asset_id)
    {
        $asset_table = $this->get_asset_table($asset_type);
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from($asset_table);
        $this->db->where('id', $asset_id);
        $res  = $this->db->get();
        $data = $res->result_array();
        return $data;
    }
    
    /**
     * @desc Function  add_update_asset
     * @params $short_name, $full_name, $asset_type, $asset_id
     * @return $result
     */
    public function add_update_asset($short_name, $full_name, $asset_type, $asset_id)
    {
        $result = 0;
        $asset_table = $this->get_asset_table($asset_type);
        $this->db = $this->load->database('default', TRUE, TRUE);
        
        // Check if exists
        $this->db->select('id');
        $this->db->from($asset_table);
        $this->db->where('short_name', $short_name);
        $res  = $this->db->get();
        $data = $res->result_array();
        if (count($data) == 0) {
            // Update
            $data = array('short_name' => $short_name, 'full_name' => $full_name);
            $this->db->where('id', $asset_id);
            $this->db->update($asset_table, $data);
            $result = 1;
        }
        else {
            if ($data[0]['id'] == $asset_id) {
                $data = array('short_name' => $short_name, 'full_name' => $full_name);
                $this->db->where('id', $asset_id);
                $this->db->update($asset_table, $data);
                $result = 1;
            }
        }
        return $result;
    }
    
    /**
     * @desc Function  
     * @params $asset_type, $asset_id
     */
    public function delete_asset($asset_type, $asset_id)
    {
        $asset_table = $this->get_asset_table($asset_type);
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->from($asset_table);
        $this->db->where('id', $asset_id);
        $this->db->delete();
    }
    
    /**
     * @desc Function get_asset_table
     * @params $asset_type
     * @return $asset_table
     */
    private function get_asset_table($asset_type)
    {
        $asset_table = '';
        switch($asset_type) {
            case 'stock':
                $asset_table = 'symbols_company';
            break;
            case 'commodities':
                $asset_table = 'symbols_metall';
            break;
            case 'currency':
                $asset_table = 'symbols_currency';
            break;
            case 'indices':
                $asset_table = 'symbols_indices';
            break;
        }
        return $asset_table;
    }
    
    /*
     * Function mass_assets_update
     * @params $visible, $invisible
     */
    public function mass_assets_update($visible, $invisible)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $make_visible = explode(',', $visible);
        foreach ($make_visible as $make_v) {
            $temp = explode('_', $make_v);
            $asset_type = $temp[0];
            $asset_id   = $temp[1];
            switch ($asset_type) {
                case 'stock':
                    $data = array('visibility' => 1);
                    $this->db->where('id', $asset_id);
                    $this->db->update('symbols_company', $data);
                break;
                case 'currency':
                    $data = array('visibility' => 1);
                    $this->db->where('id', $asset_id);
                    $this->db->update('symbols_currency', $data);
                break;
                case 'commodities':
                    $data = array('visibility' => 1);
                    $this->db->where('id', $asset_id);
                    $this->db->update('symbols_metall', $data);
                break;
                case 'indices':
                    $data = array('visibility' => 1);
                    $this->db->where('id', $asset_id);
                    $this->db->update('symbols_indices', $data);
                break;
            }
        }
        $make_invisible = explode(',', $invisible);
        foreach ($make_invisible as $make_inv) {
            $temp = explode('_', $make_inv);
            $asset_type = $temp[0];
            $asset_id   = $temp[1];
            switch ($asset_type) {
                case 'stock':
                    $data = array('visibility' => 0);
                    $this->db->where('id', $asset_id);
                    $this->db->update('symbols_company', $data);
                break;
                case 'currency':
                    $data = array('visibility' => 0);
                    $this->db->where('id', $asset_id);
                    $this->db->update('symbols_currency', $data);
                break;
                case 'commodities':
                    $data = array('visibility' => 0);
                    $this->db->where('id', $asset_id);
                    $this->db->update('symbols_metall', $data);
                break;
                case 'indices':
                    $data = array('visibility' => 0);
                    $this->db->where('id', $asset_id);
                    $this->db->update('symbols_indices', $data);
                break;
            }
        }
    }
}
