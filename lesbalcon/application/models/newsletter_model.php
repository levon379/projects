<?php
class newsletter_model extends CI_Model
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
	

	//Getting All users At Once
	function get_rows($email_id="")//Get all rows for listing page
    {
		if($email_id=="")
		{
			$this->db->order_by("id", "desc");
			$result = $this->db->get("lb_newsletter_email")->result_array();
		}
		else 
		{
			$result = $this->db->get_where("lb_newsletter_email", array("id"=>$email_id))->result_array();
		}
        return $result;
    }
	
	
	//function to inactive email
	function inactive($email_id)
	{
		$this->db->update("lb_newsletter_email", array("is_active"=>"N"), array("id"=>$email_id));
	}
	
	//function to active email
	function active($email_id)
	{
		$this->db->update("lb_newsletter_email", array("is_active"=>"Y"), array("id"=>$email_id));
	}
	
	//function to delete email
	function delete($email_id)
	{
		$this->db->delete("lb_newsletter_email", array("id"=>$email_id));
	}
	
}
?>