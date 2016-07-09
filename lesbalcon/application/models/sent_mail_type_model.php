<?php
class sent_mail_type_model extends CI_Model
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
	
	

	//######################ADDING SENT MAIL TYPE ACCORDING TO LANGUAGE###########################
	
	function sent_mail_type_add()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		//Inserting data in database
		$insert_arr=array(
			"is_active"=>"Y"
		);
		$this->db->insert("lb_sent_mail_type", $insert_arr);
		$last_id=$this->db->insert_id();
		foreach($languages_err as $language)
		{
			$language_id=$language['id'];
			$type_id=$last_id;
			$title=$this->input->post("title".$language['id']);
			$insert_arr_1=array(
				"language_id"=>$language_id,
				"type_id"=>$type_id,
				"title"=>$title
			);
			$this->db->insert("lb_sent_mail_type_lang", $insert_arr_1);
		}
		return "add_success";
	}
		
	
	//###################################################################################
	
	//##################################Edit Sent Main Type#######################################
	
	function get_sent_mail_type($language_id, $news_id) //Get all Sent Mail type according to language for edit
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_sent_mail_type_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("type_id", $news_id);
			$sent_mail_type_arr=$this->db->get("lb_sent_mail_type_lang")->result_array();
			$all_sent_mail_type_arr[$i]['id']=$languages['id'];
			$all_sent_mail_type_arr[$i]['language_id']=$sent_mail_type_arr[0]['language_id'];
			$all_sent_mail_type_arr[$i]['type_id']=$sent_mail_type_arr[0]['type_id'];
			$all_sent_mail_type_arr[$i]['title']=$sent_mail_type_arr[0]['title'];
			$all_sent_mail_type_arr[$i]['language_name']=$languages['language_name'];
			$all_sent_mail_type_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_sent_mail_type_arr;
	}
	
	
	//Getting All Sent Mail Type At Once
	function get_rows($language_id, $id = 0)//Get all rows for listing page
    {
        $result = array();
        if ($id == 0) //all rows requested according to language id
        {
			$this->db->where('language_id', $language_id);
			$this->db->order_by('id');
            $query = $this->db->get('lb_sent_mail_type_lang');
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_sent_mail_type_lang');
        }
        foreach ($query->result() as $row) 
		{
			$type_id=$row->type_id;
			$type_details_arr=$this->db->get_where("lb_sent_mail_type", array("id"=>$type_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'type_id' 				=> $row->type_id,
				'language_id' 			=> $row->language_id,
				'title' 				=> $row->title,
				'is_active'				=> $type_details_arr[0]['is_active']
			);
        }
        return $result;
    }
	
	
	//function to inactivate Sent Mail Type
	function inactive($type_id)
	{
		$this->db->update("lb_sent_mail_type", array("is_active"=>"N"), array("id"=>$type_id));
	}
	//function to activate Sent Mail Type
	function active($type_id)
	{
		$this->db->update("lb_sent_mail_type", array("is_active"=>"Y"), array("id"=>$type_id));
	}
	//function to delete Sent Mail Type
	function delete($type_id)
	{
		$this->db->delete("lb_sent_mail_type", array("id"=>$type_id));
		$this->db->delete("lb_sent_mail_type_lang", array("type_id"=>$type_id));
	}
	
	//function to edit Sent Mail Type
	function sent_mail_type_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_type_id=$this->input->post("type_id");
		$posted_language_id=$this->input->post("language_id");
		foreach($languages_err as $language)
		{
			$title=$this->input->post("title".$language['id']);
			$upd_arr_1=array(
				"title"=>$title
			);
			
			$this->db->update("lb_sent_mail_type_lang", $upd_arr_1, array("language_id"=>$language['id'], "type_id"=>$posted_type_id));
		}
		return "edit_success";
	}
}
	

?>