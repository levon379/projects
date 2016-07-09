<?php
class testimonials_model extends CI_Model
{
    
	//###############################################################//
	//############### INITIALIZE CONSTRUCTOR CLASS ##################//
	//###############################################################//
	
	function  __construct() 
	{
        parent::__construct();
    }
	
	//Function to get all active testimonials 
	function get_rows_for_front_end($limit, $offset)
	{
	    $current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->order_by("id", "desc");
		$this->db->limit($limit, $offset);
		$query = $this->db->get_where("lb_testimonials_lang", array("language_id"=>$current_lang_id,"status"=>"APPROVED"))->result_array();
		return $query;
	}
	
	//Function to get total active testimonials()
	function get_total_active_testimonials()
	{
	 $current_lang_id=$this->session->userdata("current_lang_id");
	
	
		$this->db->order_by("id", "desc");
		$query=$this->db->get_where("lb_testimonials_lang", array("language_id"=>$current_lang_id,"status"=>"APPROVED"))->result_array();
		return count($query);
	}
	
	
	//###################Function for All Testimonials###########################
	function get_all_testimonials($language_id)
	{
		$this->db->order_by("id", "desc");
		$result=$this->db->get_where("lb_testimonials_lang", array("language_id"=>$language_id))->result_array();
		return $result;
	}

	function delete_testimonials($testimonial_id)
	{
		$result=$this->db->delete("lb_testimonials_lang", array("testimonials_id"=>$testimonial_id));
		$result1=$this->db->delete("lb_testimonials", array("id"=>$testimonial_id));
		
		
		
	}
	
	function testimonial_status_change($test_id, $status)
	{
		$result=$this->db->update("lb_testimonials_lang", array("status"=>$status), array("id"=>$test_id));
		return $result;
	}
	
	
	function add_testimonials()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		//Inserting data in database
		$insert_arr=array(
			"is_active"=>"Y"
		);
		$this->db->insert("lb_testimonials", $insert_arr);
		$last_id=$this->db->insert_id();
		foreach($languages_err as $language)
		{
			$language_id=$language['id'];
			$testimonials_id=$last_id;
			//$bungalow_id=$bungalow_id;
			$name=$this->input->post("test_name".$language['id']);
			$email=$this->input->post("test_email".$language['id']);
			$comment=$this->input->post("test_comment".$language['id']);
			
			$insert_arr_1=array(
				"language_id"=>$language_id,
				"testimonials_id"=>$testimonials_id,
				//"bunglow_id"=>$bungalow_id,
				"user_name"=>$name,
				"user_email"=>$email,
				"content"=>$comment,
				"created"=>date("Y-m-d H:i:s"),
				"status"=>"APPROVED"
			);
			$this->db->insert("lb_testimonials_lang", $insert_arr_1);
		}
		return "add_success";
	}
		
	//function to save testimonials from details page 
	/*function save_testimonials()
	{
		$bungalow_id=$this->input->post("bungalow_id");
		$name=$this->input->post("test_name");
		$email=$this->input->post("test_email");
		$comment=$this->input->post("test_comment");
		$ins_arr=array(
			"bunglow_id"=>$bungalow_id,
			"user_name"=>$name,
			"user_email"=>$email,
			"content"=>$comment,
			"created"=>date("Y-m-d H:i:s"),
			"status"=>"PENDING"
		);
		$result=$this->db->insert("lb_testimonials", $ins_arr);
		return "success";
	}*/
	
	//function to edit testimonials from  
	function testimonials_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_testimonials_id=$this->input->post("testimonials_id");
		$posted_language_id=$this->input->post("language_id");
		//$posted_bunglow_id=$this->input->post("bunglow_id");
		
		
		foreach($languages_err as $language)
		{
			//$bunglow_id=$bunglow_id;
			$name=$this->input->post("test_name".$language['id']);
			$email=$this->input->post("test_email".$language['id']);
			$comment=$this->input->post("test_comment".$language['id']);
			$upd_arr_1=array(
				//"language_id"=>$posted_language_id,
				"testimonials_id"=>$posted_testimonials_id,
				//"bunglow_id"=>$posted_bunglow_id,
				"user_name"=>$name,
				"user_email"=>$email,
				"content"=>$comment
			);
			
			$this->db->update("lb_testimonials_lang", $upd_arr_1, array("language_id"=>$language['id'], "testimonials_id"=>$posted_testimonials_id));
		}
		return "edit_success";
	}
	
	
	//function to get testimonials for a particular bunglaow admin panel
	function get_testimonials_admin($language_id, $testimonials_id)
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);

		$all_testimonials_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$testimonials_arr=$this->db->get_where("lb_testimonials_lang", array("language_id"=>$languages['id'], "testimonials_id"=>$testimonials_id))->result_array();
			/*echo "<pre>";
			print_r($testimonials_arr);
			die;*/
			$all_testimonials_arr[$i]['id']=$languages['id'];
			$all_testimonials_arr[$i]['language_id']=$testimonials_arr[0]['language_id'];
			
			$all_testimonials_arr[$i]['testimonials_id']=$testimonials_arr[0]['testimonials_id'];
			//$all_testimonials_arr[$i]['bunglow_id']=$testimonials_arr[0]['bunglow_id'];
			$all_testimonials_arr[$i]['user_name']=$testimonials_arr[0]['user_name'];
			$all_testimonials_arr[$i]['user_email']=$testimonials_arr[0]['user_email'];
			$all_testimonials_arr[$i]['content']=$testimonials_arr[0]['content'];
			$all_testimonials_arr[$i]['language_name']=$languages['language_name'];
			$all_testimonials_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			
			$i++;
		}
		return $all_testimonials_arr;
		
	}
	
	
	
	
	
	
	
	
	
}
	

?>