<?php
class tax_model extends CI_Model
{
    
	//###############################################################//
	//############### INITIALIZE CONSTRUCTOR CLASS ##################//
	//###############################################################//
	
	function  __construct() 
	{
        parent::__construct();
    }
	
	//###############################################################//
	//############### INITIALIZE CONSTRUCTOR CLASS ##################//
	//###############################################################//
	
	//*******************************************ADMIN PANEL CATEGORY**********************************************************************//
	
	

	//######################ADDING TAX ACCORDING TO LANGUAGE###########################
	
	function tax_add()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$rate_in_percentage=$this->input->post("rate_in_percentage");
		$insert_arr=array(
			"is_active"=>"Y",
			"rate"=>$rate_in_percentage
		);
		$this->db->insert("lb_tax", $insert_arr);
		$last_id=$this->db->insert_id();
		foreach($languages_err as $language)
		{
			$language_id=$language['id'];
			$tax_id=$last_id;
			$tax_name=$this->input->post("tax_name".$language['id']);
			$insert_arr_1=array(
				"language_id"=>$language_id,
				"tax_id"=>$tax_id,
				"tax_name"=>$tax_name
			);
			
			$this->db->insert("lb_tax_lang", $insert_arr_1);
		}
		return "add_success";
	}
		
	
	//###################################################################################
	
	//##################################Edit Tax#######################################
	
	function get_tax($language_id, $tax_id) //Get all Tax according to language for edit
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_tax_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("tax_id", $tax_id);
			$tax_arr=$this->db->get("lb_tax_lang")->result_array();
			$all_tax_arr[$i]['id']=$languages['id'];
			$all_tax_arr[$i]['language_id']=$tax_arr[0]['language_id'];
			$all_tax_arr[$i]['tax_id']=$tax_arr[0]['tax_id'];
			$all_tax_arr[$i]['tax_name']=$tax_arr[0]['tax_name'];
			$all_tax_arr[$i]['language_name']=$languages['language_name'];
			$all_tax_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_tax_arr;
	}
	
	function get_unique_details($tax_id) //Get details of tax unique to both languages e.g page_slug
	{
		$result=$this->db->get_where("lb_tax", array("id"=>$tax_id))->result_array();
		return $result;
	}
	

	
	//Getting All taxes At Once
	function get_rows($language_id, $id = 0)//Get all rows for listing page
    {
        $result = array();
        if ($id == 0) //all rows requested according to language id
        {
			$this->db->where('language_id', $language_id);
			$this->db->order_by('id');
            $query = $this->db->get('lb_tax_lang');
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_tax_lang');
        }
        foreach ($query->result() as $row) 
		{
			$tax_id=$row->tax_id;
			$tax_details_arr=$this->db->get_where("lb_tax", array("id"=>$tax_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'tax_id' 				=> $row->tax_id,
				'language_id' 			=> $row->language_id,
				'tax_name' 				=> $row->tax_name,
				'rate' 					=> $tax_details_arr[0]['rate'],
				'is_active' 			=> $tax_details_arr[0]['is_active']
			);
        }
        return $result;
    }

	function inactive($tax_id)
	{
		$this->db->update("lb_tax", array("is_active"=>"N"), array("id"=>$tax_id));
	}
	function active($tax_id)
	{
		$this->db->update("lb_tax", array("is_active"=>"Y"), array("id"=>$tax_id));
	}
	
	function delete($tax_id)
	{
		$this->db->delete("lb_tax", array("id"=>$tax_id));
		$this->db->delete("lb_tax_lang", array("tax_id"=>$tax_id));
	}
	
	//Function for editing tax
	function tax_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_tax_id=$this->input->post("tax_id");
		$posted_language_id=$this->input->post("language_id");
		$rate=$this->input->post("rate_in_percentage");
		$update_arr=array(
			"rate"=>$rate
		);
		$this->db->update("lb_tax", $update_arr, array("id"=>$posted_tax_id));
		foreach($languages_err as $language)
		{
			$language_id=$language['id'];
			$tax_name=$this->input->post("tax_name".$language['id']);
			$update_arr_1=array(
				"tax_name"=>$tax_name
			);
			
			$this->db->update("lb_tax_lang", $update_arr_1, array("language_id"=>$language['id'], "tax_id"=>$posted_tax_id));
		}
		return "edit_success";
	}
}
	

?>