<?php
class language_model extends CI_Model
{
	function  __construct() 
	{
        parent::__construct();
		$this->load->library('session');
    }
	
	//Get Language Row
	function get_rows($id = 0)
    {
		if($id == 0)
		{
			$this->db->select('*');
			$query = $this->db->get('mast_language');
			if($query->num_rows() > 0)
			{
				return $query->result_array();
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			$this->db->where('id', $id);
			$query = $this->db->get('mast_language');
			if($query->num_rows() > 0)
			{
				return $query->row_array();
			}
			else
			{
				return FALSE;
			}
		}
    }
	
	//Set Language To Default
	function set_default($lang_id)
	{
		$this->db->update("mast_language", array("set_as_default"=>"Y"), array("id"=>$lang_id));
		$this->db->update("mast_language", array("set_as_default"=>"N"), array("id !="=>$lang_id));
	}
	
	
	//Get Default Language Id
	function get_default_language_id()
	{
		$result=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		return $result[0]['id'];
	}
	
	//Set Language To Active
	function active($lang_id)
    {
		$postdata = array('is_active' => "Y");
		$this->db->where('id', $lang_id);
		$query = $this->db->update('mast_language',$postdata);
		return $query;
    }
	
	//Set Language To Inactive
	function inactive($lang_id)
    {
		$postdata = array('is_active' => "N");
		$this->db->where('id', $lang_id);
		$query = $this->db->update('mast_language',$postdata);
		return $query;
    }

	//Get Default Language Name To Load Default Language 
	function get_default_lang_name()
	{
		$result=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		return $result[0]['language_name'];
	}
	
	
	//Get Default Admin Time Zone
	function get_admin_time_zone()
	{
		$result=$this->db->get_where("mast_setting", array("site_setting_id "=>"1"))->result_array();
		return $result[0]['admin_time_zone'];
	}
	
	
	//function to get_language_details for front end while changing language
	function get_lang_details($langval)
	{
		$lang_id = $langval;
		$sql = $this->db->get_where('mast_language', array("id"=>$lang_id))->result_array();
		$this->session->set_userdata('current_lang_id',$lang_id);
		$this->session->set_userdata('current_lang_name',$sql[0]['language_name']);
	 
	}
	
}
?>