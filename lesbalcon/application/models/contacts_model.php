<?php
class contacts_model extends CI_Model
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
	
	
	
	//Getting All contacts At Once
	function get_rows()//Get all rows for listing page
    {
		$this->db->order_by('id', 'desc');
		$result = $this->db->get('lb_contact_details')->result_array();
        return $result;
    }
	
	//function to delete contacts
	function delete($contacts_id)
	{
		$this->db->delete("lb_contact_details", array("id"=>$contacts_id));
	}
}
	

?>