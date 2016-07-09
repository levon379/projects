<?php
class mail_box_model extends CI_Model
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
	
	//Get All inbox email acording to pagination
	function get_all_inbox_email($limit, $offset)
	{
		$this->db->where("status !=", "DELETED");
		$this->db->order_by("time", "DESC");
		$result=$this->db->get("lb_inbox", $limit, $offset)->result_array();
		return $result;
	}
	
	//Get All inbox email
	function get_total_inbox()
	{
		$this->db->where("status !=", "DELETED");
		$this->db->order_by("time", "DESC");
		$result=$this->db->get("lb_inbox")->result_array();
		return count($result);
	}
	
	//Get All contacts
	function get_total_contacts()
	{
		$this->db->order_by("id", "DESC");
		$result=$this->db->get("lb_contact_details")->result_array();
		return count($result);
	}
	
	//function to get all contacts for listing
	function get_all_contacts($limit, $offset)
	{
		$this->db->order_by("id", "DESC");
		$result=$this->db->get("lb_contact_details", $limit, $offset)->result_array();
		return $result;
	}
	
	//function to delete contacts
	function ajax_delete_contacts($selected_values_arr)
	{
		$selected_value=explode("^", $selected_values_arr);
		foreach($selected_value as $email_id)
		{
			$result=$this->db->delete("lb_contact_details", array("id"=>$email_id));
		}
		return $result;
	}
	
	//function to mark as read, unread etc
	function ajax_mark($selected_values_arr, $status)
	{
		$selected_value=explode("^", $selected_values_arr);
		foreach($selected_value as $email_id)
		{
			$result=$this->db->update("lb_inbox", array("status"=>$status), array("id"=>$email_id));
		}
		return $result;
	}
	
	//Get All sent mail
	function get_total_sent_mail()
	{
		$this->db->order_by("time", "DESC");
		$result=$this->db->get("lb_sent_mails")->result_array();
		return count($result);
	}
	
	//Get All sent email acording to pagination
	function get_all_sent_mail($limit, $offset)
	{
		$this->db->order_by("time", "DESC");
		$result=$this->db->get("lb_sent_mails", $limit, $offset)->result_array();
		return $result;
	}
	
	//function to delete all sent mails
	function ajax_delete_sent_mail($selected_values_arr)
	{
		$selected_value=explode("^", $selected_values_arr);
		foreach($selected_value as $email_id)
		{
			$result=$this->db->delete("lb_sent_mails", array("id"=>$email_id));
		}
		return $result;
	}
	
	//function to set read status to inbox email
	function ajax_set_read($email_id, $status)
	{
		$this->db->update("lb_inbox", array("status"=>$status), array("id"=>$email_id));
	}
}
?>