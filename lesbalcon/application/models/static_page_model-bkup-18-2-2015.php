<?php
class static_page_model extends CI_Model
{
	function  __construct() 
	{
        parent::__construct();
    }

	//###############function to get services content for service page###############
	function get_services_content()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->select('*');
		$this->db->from('lb_pages');
		$this->db->where('lb_pages.id',"3");
		$this->db->join('lb_pages_lang', 'lb_pages.id = lb_pages_lang.pages_id AND lb_pages_lang.language_id='.$current_lang_id);
		$pages_arr = $this->db->get()->result_array();
		return $pages_arr;
	}
	
	//###############function to get st martin content for service page###############
	function get_stmartin_content()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->select('*');
		$this->db->from('lb_pages');
		$this->db->where('lb_pages.id',"4");
		$this->db->join('lb_pages_lang', 'lb_pages.id = lb_pages_lang.pages_id AND lb_pages_lang.language_id='.$current_lang_id);
		$pages_arr = $this->db->get()->result_array();
		return $pages_arr;
	}
	
	
	//##################function to get faqs#########################
	function get_faq_content()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->select('*');
		$this->db->from('lb_faq');
		$this->db->order_by("lb_faq.id");
		$this->db->join('lb_faq_lang', 'lb_faq.id = lb_faq_lang.faq_id AND lb_faq.is_active="Y" AND lb_faq_lang.language_id='.$current_lang_id);
		$faq_arr = $this->db->get()->result_array();
		return $faq_arr;
	}
	
	//###############function to get properties content###############
	function get_properties_content()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->select('*');
		$this->db->from('lb_pages');
		$this->db->where('lb_pages.id',"6");
		$this->db->join('lb_pages_lang', 'lb_pages.id = lb_pages_lang.pages_id AND lb_pages_lang.language_id='.$current_lang_id);
		$pages_arr = $this->db->get()->result_array();
		return $pages_arr;
	}
	
	//###############function to get activities content###############
	function get_activities_content()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->select('*');
		$this->db->from('lb_pages');
		$this->db->where('lb_pages.id',"7");
		$this->db->join('lb_pages_lang', 'lb_pages.id = lb_pages_lang.pages_id AND lb_pages_lang.language_id='.$current_lang_id);
		$pages_arr = $this->db->get()->result_array();
		return $pages_arr;
	}
	
	//###############function to get rental car content###############
	function get_rental_car_content()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->select('*');
		$this->db->from('lb_pages');
		$this->db->where('lb_pages.id',"8");
		$this->db->join('lb_pages_lang', 'lb_pages.id = lb_pages_lang.pages_id AND lb_pages_lang.language_id='.$current_lang_id);
		$pages_arr = $this->db->get()->result_array();
		return $pages_arr;
	}
	
	//###############function to get situation content###############
	function get_situation_content()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->select('*');
		$this->db->from('lb_pages');
		$this->db->where('lb_pages.id',"6");
		$this->db->join('lb_pages_lang', 'lb_pages.id = lb_pages_lang.pages_id AND lb_pages_lang.language_id='.$current_lang_id);
		$pages_arr = $this->db->get()->result_array();
		return $pages_arr;
	}
}

?>