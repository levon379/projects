<?php
class options_model extends CI_Model
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
	
	

	//######################ADDING BANNERS ACCORDING TO LANGUAGE###########################
	
	function options_add()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$charges_in_dollars=$this->input->post("charge_in_dollars");
		$charges_in_euro=$this->input->post("charge_in_euro");
		$insert_arr=array(
			"is_active"=>"Y",
			"charge_in_dollars"=>$charges_in_dollars,
			"charge_in_euro"=>$charges_in_euro
		);
		$this->db->insert("lb_bunglow_options", $insert_arr);
		$last_id=$this->db->insert_id();
		foreach($languages_err as $language)
		{
			$language_id=$language['id'];
			$options_id=$last_id;
			$options_name=$this->input->post("options_name".$language['id']);
			$insert_arr_1=array(
				"language_id"=>$language_id,
				"options_id"=>$options_id,
				"options_name"=>$options_name
			);
			
			$this->db->insert("lb_bunglow_options_lang", $insert_arr_1);
		}
		return "add_success";
	}
		
	
	//###################################################################################
	
	//##################################Edit Pages#######################################
	
	function get_options($language_id, $options_id) //Get all options according to language for edit
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_options_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("options_id", $options_id);
			$options_arr=$this->db->get("lb_bunglow_options_lang")->result_array();
			$all_options_arr[$i]['id']=$languages['id'];
			$all_options_arr[$i]['language_id']=$options_arr[0]['language_id'];
			$all_options_arr[$i]['options_id']=$options_arr[0]['options_id'];
			$all_options_arr[$i]['options_name']=$options_arr[0]['options_name'];
			$all_options_arr[$i]['language_name']=$languages['language_name'];
			$all_options_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_options_arr;
	}
	
	function get_unique_details($options_id) //Get details of page unique to both languages e.g page_slug
	{
		$result=$this->db->get_where("lb_bunglow_options", array("id"=>$options_id))->result_array();
		return $result;
	}
	

	
	//Getting All Options At Once
	function get_rows($language_id, $id = 0)//Get all rows for listing page
    {
        $result = array();
        if ($id == 0) //all rows requested according to language id
        {
			$this->db->where('language_id', $language_id);
			$this->db->order_by('id');
            $query = $this->db->get('lb_bunglow_options_lang');
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_bunglow_options_lang');
        }
        foreach ($query->result() as $row) 
		{
			$options_id=$row->options_id;
			$options_details_arr=$this->db->get_where("lb_bunglow_options", array("id"=>$options_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'options_id' 			=> $row->options_id,
				'language_id' 			=> $row->language_id,
				'options_name' 			=> $row->options_name,
				'charges_in_dollars' 	=> $options_details_arr[0]['charge_in_dollars'],
				'charges_in_euro' 		=> $options_details_arr[0]['charge_in_euro'],
				'is_active' 			=> $options_details_arr[0]['is_active']
			);
        }
        return $result;
    }

	function inactive($options_id)
	{
		$this->db->update("lb_bunglow_options", array("is_active"=>"N"), array("id"=>$options_id));
	}
	function active($options_id)
	{
		$this->db->update("lb_bunglow_options", array("is_active"=>"Y"), array("id"=>$options_id));
	}
	
	function delete($options_id)
	{
		$this->db->delete("lb_bunglow_options", array("id"=>$options_id));
		$this->db->delete("lb_bunglow_options_lang", array("options_id"=>$options_id));
	}
	
	
	function options_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_options_id=$this->input->post("options_id");
		$posted_language_id=$this->input->post("language_id");
		$languages_err=$this->db->get("mast_language")->result_array();
		$charges_in_dollars=$this->input->post("charge_in_dollars");
		$charges_in_euro=$this->input->post("charge_in_euro");
		$update_arr=array(
			"charge_in_dollars"=>$charges_in_dollars,
			"charge_in_euro"=>$charges_in_euro
		);
		$this->db->update("lb_bunglow_options", $update_arr, array("id"=>$posted_options_id));
		foreach($languages_err as $language)
		{
			$language_id=$language['id'];
			$options_name=$this->input->post("options_name".$language['id']);
			$update_arr_1=array(
				"options_name"=>$options_name
			);
			
			$this->db->update("lb_bunglow_options_lang", $update_arr_1, array("language_id"=>$language['id'], "options_id"=>$posted_options_id));
		}
		return "edit_success";
	}
}
	

?>