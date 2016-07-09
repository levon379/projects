<?php 
class change_username_model extends CI_Model
{
    function  __construct() 
	{
        parent::__construct();
    }

    //callback function for validation rule
    function is_exist($str)
    {
        $this->db->where('username',$str);
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
   
    function validate_form_data()
    {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('old_username', 'Old username', 'required');
            $this->form_validation->set_rules('new_username', 'New username', 'required');

            if ($this->form_validation->run() == TRUE)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
    }

   
    function do_change_username()
    {
        // get the post data into an array for updating
		$result=$this->is_exist($this->input->post('old_username'));
		if($result)
		{
			$postdata = array(
            			'username' => $this->input->post('new_username')
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