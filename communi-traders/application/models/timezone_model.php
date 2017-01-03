<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timezone_model extends CI_Model {

    public function index() {
        return true;
    }
	public function get_time_zones()
	{
		$this->db = $this->load->database('default', TRUE, TRUE);
		return $this->db->select('*')->from('m_time')->get()->result_array();
	
	}
	public function get_time_zone()
	{
		$this->db = $this->load->database('default', TRUE, TRUE);
		return $this->db->select('*')->from('m_time')->get()->result_array();
	
	}
	public function added_assets($data_added)
	{
		$this->db = $this->load->database('default', TRUE, TRUE);
		$this->db->insert('m_time',$data_added);
		
	}
	public function add_update_asset($id,$data)
	{
		//var_dump($data);die;
		$this->db = $this->load->database('default', TRUE, TRUE);
		$this->db->where('id', $id);
		$this->db->update('m_time', $data);
	}
	public function delete_time_zone($id)
	{
		$this->db = $this->load->database('default', TRUE, TRUE);
		$this->db->where('id',$id);
		$this->db->delete('m_time');
		$this->session->set_flashdata('message', 'success');
        $this->session->set_flashdata('message_content', 'Time  successfully delete');
		return true;
	}

}