<?php
class welcome_text_model extends CI_Model
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
	

	//###################################################################################
	
	//##################################Edit Pages#######################################
	
	function get_welcome_text($language_id, $text_id) //Get all text according to language for edit
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_text_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$text_arr=$this->db->get("lb_welcome_text")->result_array();
			$all_text_arr[$i]['id']=$languages['id'];
			$all_text_arr[$i]['language_id']=$text_arr[0]['language_id'];
			$all_text_arr[$i]['text']=$text_arr[0]['text'];
			$all_text_arr[$i]['language_name']=$languages['language_name'];
			$all_text_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_text_arr;
	}
	
	function get_unique_details($banner_id) //Get details of page unique to both languages e.g page_slug
	{
		$result=$this->db->get_where("lb_banner", array("id"=>$banner_id))->result_array();
		return $result;
	}
	

	
	//Getting All Welcome text At Once
	function get_rows($language_id, $id = 0)//Get all rows for listing page
    {
        $result = array();
        if ($id == 0) //all rows requested according to language id
        {
			$this->db->where('language_id', $language_id);
			$this->db->order_by('id');
            $query = $this->db->get('lb_welcome_text');
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_welcome_text');
        }
        foreach ($query->result() as $row) 
		{
			$result[] = array(
				'id' 					=> $row->id,
				'language_id' 			=> $row->language_id,
				'text' 					=> $row->text
			);
        }
        return $result;
    }

	function welcome_text_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_text_id=$this->input->post("text_id");
		$posted_language_id=$this->input->post("language_id");
		foreach($languages_err as $language)
		{
			$welcome_text=$this->input->post("welcome_text".$language['id']);
			$upd_arr_1=array(
				"text"=>$welcome_text
			);
			
			$this->db->update("lb_welcome_text", $upd_arr_1, array("language_id"=>$language['id']));
		}
		return "edit_success";
	}
}
	

?>