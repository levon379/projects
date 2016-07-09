<?php
class season_model extends CI_Model
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
	
	

	//######################ADDING SEASON ACCORDING TO LANGUAGE###########################
	
	function season_add()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		//Inserting data in database
		$insert_arr=array(
			"is_active"=>"Y",
			"months"=>implode("^", $this->input->post('months'))
		);
		$this->db->insert("lb_season", $insert_arr);
		$last_id=$this->db->insert_id();
		foreach($languages_err as $language)
		{
			$language_id=$language['id'];
			$season_id=$last_id;
			$season_name=$this->input->post("season_name".$language['id']);
			$insert_arr_1=array(
				"language_id"=>$language_id,
				"season_id"=>$season_id,
				"season_name"=>$season_name
			);
			$this->db->insert("lb_season_lang", $insert_arr_1);
		}
		return "add_success";
	}
		
	function get_unique_details($season_id)
	{
		$seasons_arr=$this->db->get_where("lb_season", array("id"=>$season_id))->result_array();
		return $seasons_arr;
	}	
	
	//###################################################################################
	
	//##################################Edit Season#######################################
	
	function get_season($language_id, $season_id) //Get all season according to language for edit
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_season_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("season_id", $season_id);
			$season_arr=$this->db->get("lb_season_lang")->result_array();
			$all_season_arr[$i]['id']=$languages['id'];
			$all_season_arr[$i]['language_id']=$season_arr[0]['language_id'];
			$all_season_arr[$i]['season_id']=$season_arr[0]['season_id'];
			$all_season_arr[$i]['season_name']=$season_arr[0]['season_name'];
			$all_season_arr[$i]['language_name']=$languages['language_name'];
			$all_season_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_season_arr;
	}
	
	
	//Getting All Season At Once
	function get_rows($language_id, $id = 0)//Get all rows for listing page
    {
        $result = array();
        if ($id == 0) //all rows requested according to language id
        {
			$this->db->where('language_id', $language_id);
			$this->db->order_by('id');
            $query = $this->db->get('lb_season_lang');
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_season_lang');
        }
        foreach ($query->result() as $row) 
		{
			$season_id=$row->season_id;
			$season_details_arr=$this->db->get_where("lb_season", array("id"=>$season_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'season_id' 			=> $row->season_id,
				'language_id' 			=> $row->language_id,
				'season_name' 			=> $row->season_name,
				'months'				=> $season_details_arr[0]['months'],
				'is_active'				=> $season_details_arr[0]['is_active']
			);
        }
        return $result;
    }
	
	
	//function to inactivate season
	function inactive($season_id)
	{
		$this->db->update("lb_season", array("is_active"=>"N"), array("id"=>$season_id));
	}
	//function to activate season
	function active($season_id)
	{
		$this->db->update("lb_season", array("is_active"=>"Y"), array("id"=>$season_id));
	}
	//function to delete season
	function delete($season_id)
	{
		$this->db->delete("lb_season", array("id"=>$season_id));
		$this->db->delete("lb_season_lang", array("season_id"=>$season_id));
	}
	
	//function to Edit season
	function season_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_season_id=$this->input->post("season_id");
		$posted_language_id=$this->input->post("language_id");
		
		//update data in database
		$upd_arr=array(
			"months"=>implode("^", $this->input->post('months'))
		);
		$this->db->update("lb_season", $upd_arr, array("id"=>$posted_season_id));
		
		foreach($languages_err as $language)
		{
			$season_name=$this->input->post("season_name".$language['id']);
			$upd_arr_1=array(
				"season_name"=>$season_name
			);
			
			$this->db->update("lb_season_lang", $upd_arr_1, array("language_id"=>$language['id'], "season_id"=>$posted_season_id));
		}
		return "edit_success";
	}
}
	

?>