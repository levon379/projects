<?php 

class change_password_model extends CI_Model
{
    function  __construct() {
        parent::__construct();

        //load the model since it is used in almost all the functions
        //$this->load->database();
    }

    //callback function for validation rule
    function is_pass_exist($str)
    {
        $this->db->where('password',md5($str));
		$this->db->where('id', $this->session->userdata('user_id'));
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

    function do_change_pass()
    {
		$result=$this->is_pass_exist($this->input->post('old_password'));
		if($result)
		{
			// get the post data into an array for updating
			$postdata = array(
				'password' => md5($this->input->post('new_password'))
			);
			$this->db->where('id', $this->session->userdata('user_id'));
			$query = $this->db->update('mast_admin_info',$postdata);
			return 1;
		}
        else 
		{
			return 0;
		}
        
    }
    
}

?>