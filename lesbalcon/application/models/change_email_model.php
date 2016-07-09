<?php 
class change_email_model extends CI_Model
{
    function  __construct() 
	{
        parent::__construct();
    }

    //callback function for validation rule
    function is_exist($str)
    {
        $this->db->where('email',$str);
        $query = $this->db->get('mast_admin_info');
        if($query->num_rows == 1)
        {
             return TRUE;
        }
        else
        {
             return FALSE;
        }    
    }

    function do_change_email()
    {
        // get the post data into an array for updating
		$result=$this->is_exist($this->input->post('old_email'));
		if($result)
		{
			$postdata = array(
            			'email' => $this->input->post('new_email')
        				);
			$this->db->where('id',$this->session->userdata('user_id'));
			$this->db->update('mast_admin_info',$postdata);
			return 1;
		}
        else 
		{
			return 0;
		}
    }
}

?>