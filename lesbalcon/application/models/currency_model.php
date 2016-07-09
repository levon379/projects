<?php
class currency_model extends CI_Model
{
	
	function  __construct() 
	{
        parent::__construct();
    }

	//Get all pages according to language for edit
	function get_currency($language_id, $currency_auto_id) 
	{
		//Get data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_pages_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("currency_auto_id", $currency_auto_id);
			$pages_arr=$this->db->get("lb_currency_master_lang")->result_array();
			$all_pages_arr[$i]['id']=$languages['id'];
			$all_pages_arr[$i]['language_id']=$pages_arr[0]['language_id'];
			$all_pages_arr[$i]['currency_auto_id']=$pages_arr[0]['currency_auto_id'];
			$all_pages_arr[$i]['currency_name']=$pages_arr[0]['currency_name'];
			$all_pages_arr[$i]['language_name']=$languages['language_name'];
			$all_pages_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_pages_arr;
	}
	
	//Get details of page unique to both languages e.g page_slug
	function get_unique_details($currency_auto_id) 
	{
		$result=$this->db->get_where("lb_currency_master", array("currency_id"=>$currency_auto_id))->result_array();
		return $result;
	}
	
	
	function currency_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$currency_auto_id=$this->input->post("currency_auto_id");
		$currency_symbol=$this->input->post("currency_symbol");
		$currency_code=$this->input->post("currency_code");
		$update_arr=array(
			"currency_symbol"=>$currency_symbol,
			"currency_code"=>$currency_code
		);
		$this->db->update("lb_currency_master",  $update_arr, array("currency_id"=>$currency_auto_id));
		foreach($languages_err as $language)
		{
			$language_id=$language['id'];
			$currency_name=$this->input->post("currency_name".$language['id']);
			$update_arr_1=array(
				"currency_name"=>$currency_name
			);
			$this->db->update("lb_currency_master_lang", $update_arr_1, array("language_id"=>$language_id, "currency_auto_id"=>$currency_auto_id));
		}
		return "edit_success";
	}
	

	function get_rows($language_id, $id = 0)//Get all rows for listing page
    {
        $result = array();

        if ($id == 0) //all rows requested according to language id
        {
			$this->db->where('language_id', $language_id);
			$this->db->order_by('id');
            $query = $this->db->get('lb_currency_master_lang');
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_currency_master_lang');
        }
    
        foreach ($query->result() as $row) 
		{
			$currency_auto_id=$row->currency_auto_id;
			$currency_language_id=$row->language_id;
			$currency_details_arr=$this->db->get_where("lb_currency_master", array("currency_id"=>$currency_auto_id))->result_array();
			
			$result[] = array(
				'id' 					=> $row->id,
				'currency_auto_id' 		=> $currency_auto_id,
				'language_id' 			=> $row->language_id,
				'currency_name' 		=> $row->currency_name,
				'currency_code' 		=> $currency_details_arr[0]['currency_code'],
				'currency_symbol' 		=> $currency_details_arr[0]['currency_symbol'],
				'set_as_default'		=> $currency_details_arr[0]['set_as_default'],
				'is_active'				=> $currency_details_arr[0]['is_active'],
				'is_base_currency'		=> $currency_details_arr[0]['is_base_currency']
				
			);
        }

		//print_r($result);exit;
        return $result;
    }
	
	//######################Setting Base Currency#####################
	function set_base_currency($currency_id)
	{
		$this->db->update("lb_currency_master", array("is_base_currency"=>"Y"), array("currency_id"=>$currency_id));
		$this->db->update("lb_currency_master", array("is_base_currency"=>"N"), array("currency_id !="=>$currency_id));
	}
	##################################################################
	
	//######################Setting default Currency###################
	function set_default($currency_id)
	{
		$this->db->update("lb_currency_master", array("set_as_default"=>"Y"), array("currency_id"=>$currency_id));
		$this->db->update("lb_currency_master", array("set_as_default"=>"N"), array("currency_id !="=>$currency_id));
	}
	##################################################################
	
	//######################get default Currency###################
	function get_default_currency()
	{
		$language_id=$current_lang_id=$this->session->userdata("current_lang_id");
		$array=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		$currency_arr=array();
		$currency_arr['currency_id']=$array[0]['currency_id'];
		$currency_arr['currency_symbol']=$array[0]['currency_symbol'];
		$currency_arr['currency_code']=$array[0]['currency_code'];
		return $currency_arr;
	}
	##################################################################
}
	

?>