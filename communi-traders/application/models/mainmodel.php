<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mainmodel extends CI_Model {
    
    public function Mainmodel() {
        parent::__construct();
    }
    
    public function index(){
        return true;
    }
    
    public function _build_blocks($par) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('id, name');
        $this->db->from('blocks');
        $this->db->where('parent', $par);
        $this->db->where('visible', '1');
        $this->db->order_by("sort", "asc");
        $data = $this->db->get();
        return $data;
    }  
    
    function _build_sub_blocks($par) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('id');
        $this->db->from('blocks');
        $this->db->where('name', $par);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $block = $row['id'];
        }
        $this->db->select('id, name');
        $this->db->from('blocks');
        $this->db->where('parent', $block);
        $this->db->where('visible', '1');
        $this->db->order_by("sort", "asc");
        $data = $this->db->get();
        return $data;
    }  
}