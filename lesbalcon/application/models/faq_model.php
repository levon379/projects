<?php
class faq_model extends CI_Model
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
	
	

	//######################ADDING FAQ ACCORDING TO LANGUAGE###########################
	
	function faq_add()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		//Inserting data in database
		$insert_arr=array(
			"is_active"=>"Y"
		);
		$this->db->insert("lb_faq", $insert_arr);
		$last_id=$this->db->insert_id();
		foreach($languages_err as $language)
		{
			$language_id=$language['id'];
			$faq_id=$last_id;
			$faq_question=$this->input->post("question".$language['id']);
			$faq_answer=$this->input->post("answer".$language['id']);
			$insert_arr_1=array(
				"language_id"=>$language_id,
				"faq_id"=>$faq_id,
				"faq_question"=>$faq_question,
				"faq_answer"=>$faq_answer
			);
			$this->db->insert("lb_faq_lang", $insert_arr_1);
		}
		return "add_success";
	}
		
	
	//###################################################################################
	
	//##################################Edit Faq#######################################
	
	function get_faq($language_id, $faq_id) //Get all news according to language for edit
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_faq_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("faq_id", $faq_id);
			$faq_arr=$this->db->get("lb_faq_lang")->result_array();
			$all_faq_arr[$i]['id']=$languages['id'];
			$all_faq_arr[$i]['language_id']=$faq_arr[0]['language_id'];
			$all_faq_arr[$i]['faq_id']=$faq_arr[0]['faq_id'];
			$all_faq_arr[$i]['faq_question']=$faq_arr[0]['faq_question'];
			$all_faq_arr[$i]['faq_answer']=$faq_arr[0]['faq_answer'];
			$all_faq_arr[$i]['language_name']=$languages['language_name'];
			$all_faq_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_faq_arr;
	}
	
	
	//Getting All Faq At Once
	function get_rows($language_id, $id = 0)//Get all rows for listing page
    {
        $result = array();
        if ($id == 0) //all rows requested according to language id
        {
			$this->db->where('language_id', $language_id);
			$this->db->order_by('id');
            $query = $this->db->get('lb_faq_lang');
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_faq_lang');
        }
        foreach ($query->result() as $row) 
		{
			$faq_id=$row->faq_id;
			$faq_details_arr=$this->db->get_where("lb_faq", array("id"=>$faq_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'faq_id' 				=> $row->faq_id,
				'language_id' 			=> $row->language_id,
				'faq_question' 			=> $row->faq_question,
				'faq_answer' 			=> $row->faq_answer,
				'is_active'				=> $faq_details_arr[0]['is_active']
			);
        }
        return $result;
    }
	
	
	//function to inactivate faq
	function inactive($faq_id)
	{
		$this->db->update("lb_faq", array("is_active"=>"N"), array("id"=>$faq_id));
	}
	//function to activate faq
	function active($faq_id)
	{
		$this->db->update("lb_faq", array("is_active"=>"Y"), array("id"=>$faq_id));
	}
	//function to delete faq
	function delete($faq_id)
	{
		$this->db->delete("lb_faq", array("id"=>$faq_id));
		$this->db->delete("lb_faq_lang", array("faq_id"=>$faq_id));
	}
	
	
	function faq_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_faq_id=$this->input->post("faq_id");
		$posted_language_id=$this->input->post("language_id");
		
		foreach($languages_err as $language)
		{
			$faq_question=$this->input->post("question".$language['id']);
			$faq_answer=$this->input->post("answer".$language['id']);
			$upd_arr_1=array(
				"faq_question"=>$faq_question,
				"faq_answer"=>$faq_answer
			);
			
			$this->db->update("lb_faq_lang", $upd_arr_1, array("language_id"=>$language['id'], "faq_id"=>$posted_faq_id));
		}
		return "edit_success";
	}
}
	

?>