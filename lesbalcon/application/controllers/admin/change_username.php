<?php
ob_start();
class change_username extends CI_Controller
{
    var $data;
    function  __construct() 
	{
        parent::__construct();
        $this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
 		$this->load->model('change_username_model');
    }

    function index()
	{ 
		$this->data['error_message'] = "";
		$this->data['success_message'] = "";
		if($this->uri->segment(4) == 'updated')
		{
			$this->data['success_message'] = "Username successfully updated.";
		}
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		//Loading Main Content Page
		$this->data['content'] = $this->load->view('admin/maincontents/change_username', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
        $this->load->view('admin/layout_home', $this->data);
    }
	
	
	function change()
	{
        $this->data['error_message'] = "";
		$this->data['success_message'] = "";
        //is form submitted?
        if ($this->input->post('save'))
        {
            //validate form data
			$result=$this->change_username_model->do_change_username();
			if($result==1)
			{
				redirect('admin/change_username?updated');  
			}
			else 
			{
				redirect('admin/change_username?notexist');  
			}
        }
        
       //populate view, specific to this function
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		//Loading Main Content Page
		$this->data['content'] = $this->load->view('admin/maincontents/change_username', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
        $this->load->view('admin/layout_home', $this->data);
    }

}
?>
