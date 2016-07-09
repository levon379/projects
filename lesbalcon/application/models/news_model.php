<?php
class news_model extends CI_Model
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
	//Function to create unique slug
	public function create_unique_slug($string,$table,$field='slug',$key=NULL,$value=NULL)
	{
		$slug = url_title($string);
		$slug = strtolower($slug);
		$i = 0;
		$params = array ();
		$params[$field] = $slug;
	 
		if($key)$params["$key !="] = $value;
	 
		while ($this->db->where($params)->get($table)->num_rows())
		{  
			if (!preg_match ('/-{1}[0-9]+$/', $slug ))
				$slug .= '-' . ++$i;
			else
				$slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
			 
			$params [$field] = $slug;
		}  
		return $slug;  
	}
	

	//######################ADDING NEWS ACCORDING TO LANGUAGE###########################
	
	function news_add()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$title_for_slug=$this->create_unique_slug($this->input->post("news_title1"), "lb_news");
		//Inserting data in database
		$insert_arr=array(
			"is_active"=>"Y",
			"creation_date"=>date("Y-m-d H:i:s"),
			"slug"=>$title_for_slug
		);
		$this->db->insert("lb_news", $insert_arr);
		$last_id=$this->db->insert_id();
		foreach($languages_err as $language)
		{
			$language_id=$language['id'];
			$news_id=$last_id;
			$news_title=$this->input->post("news_title".$language['id']);
			$news_content=$this->input->post("news_content".$language['id']);
			$insert_arr_1=array(
				"language_id"=>$language_id,
				"news_id"=>$news_id,
				"title"=>$news_title,
				"content"=>$news_content
			);
			$this->db->insert("lb_news_lang", $insert_arr_1);
		}
		return "add_success";
	}
		
	
	//###################################################################################
	
	//##################################Edit Pages#######################################
	
	function get_news($language_id, $news_id) //Get all news according to language for edit
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_news_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("news_id", $news_id);
			$news_arr=$this->db->get("lb_news_lang")->result_array();
			$all_news_arr[$i]['id']=$languages['id'];
			$all_news_arr[$i]['language_id']=$news_arr[0]['language_id'];
			$all_news_arr[$i]['news_id']=$news_arr[0]['news_id'];
			$all_news_arr[$i]['title']=$news_arr[0]['title'];
			$all_news_arr[$i]['content']=$news_arr[0]['content'];
			$all_news_arr[$i]['language_name']=$languages['language_name'];
			$all_news_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_news_arr;
	}
	
	
	//Getting All Banner At Once
	function get_rows($language_id, $id = 0)//Get all rows for listing page
    {
        $result = array();
        if ($id == 0) //all rows requested according to language id
        {
			$this->db->where('language_id', $language_id);
			$this->db->order_by('id');
            $query = $this->db->get('lb_news_lang');
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_news_lang');
        }
        foreach ($query->result() as $row) 
		{
			$news_id=$row->news_id;
			$news_details_arr=$this->db->get_where("lb_news", array("id"=>$news_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'news_id' 				=> $row->news_id,
				'language_id' 			=> $row->language_id,
				'title' 				=> $row->title,
				'content' 				=> $row->content,
				'is_active'				=> $news_details_arr[0]['is_active'],
				'is_featured'			=> $news_details_arr[0]['is_featured']
			);
        }
        return $result;
    }
	
	
	//function to inactivate news
	function inactive($news_id)
	{
		$this->db->update("lb_news", array("is_active"=>"N"), array("id"=>$news_id));
	}
	//function to activate news
	function active($news_id)
	{
		$this->db->update("lb_news", array("is_active"=>"Y"), array("id"=>$news_id));
	}
	//function to delete news
	function delete($news_id)
	{
		$this->db->delete("lb_news", array("id"=>$news_id));
		$this->db->delete("lb_news_lang", array("news_id"=>$news_id));
	}
	
	//function to set news as featured
	function set_featured($news_id)
	{
		$news_details=$this->db->get_where("lb_news", array("id"=>$news_id))->result_array();
		if($news_details[0]['is_featured']=="N")
		{
			$this->db->update("lb_news", array("is_featured"=>"Y"), array("id"=>$news_id));
		}
		if($news_details[0]['is_featured']=="Y")
		{
			$this->db->update("lb_news", array("is_featured"=>"N"), array("id"=>$news_id));
		}
	}
	
	function news_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_news_id=$this->input->post("news_id");
		$posted_language_id=$this->input->post("language_id");
		$upd_arr=array(
			"modified_date"=>date("Y-m-d H:i:s")
		);
		$this->db->update("lb_news", $upd_arr, array("id"=>$posted_news_id));

		foreach($languages_err as $language)
		{
			$news_title=$this->input->post("news_title".$language['id']);
			$news_content=$this->input->post("news_content".$language['id']);
			$upd_arr_1=array(
				"title"=>$news_title,
				"content"=>$news_content
			);
			
			$this->db->update("lb_news_lang", $upd_arr_1, array("language_id"=>$language['id'], "news_id"=>$posted_news_id));
		}
		return "edit_success";
	}
}
	

?>