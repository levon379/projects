<?php
ob_start();
class change_password extends CI_Controller
{
    var $data;
    function  __construct() 
	{
        parent::__construct();
        $this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
 		$this->load->model('change_password_model');
    }

    function index()
	{ 
		$this->data['error_message'] = "";
		$this->data['success_message'] = "";
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		//Loading Main Content Page
		$this->data['content'] = $this->load->view('admin/maincontents/change_password', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
        $this->load->view('admin/layout_home', $this->data);
    }
	
	
	function change_pass()
	{
        $this->data['error_message'] = "";
		$this->data['success_message'] = "";
        //is form submitted?
        if ($this->input->post('save'))
        {
			$result=$this->change_password_model->do_change_pass();
			if($result==1)
			{
				redirect('admin/change_password?updated');    
			}
			else
			{
				redirect('admin/change_password?notexist');
			}
        }
       //populate view, specific to this function
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		//Loading Main Content Page
		$this->data['content'] = $this->load->view('admin/maincontents/change_password', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
        $this->load->view('admin/layout_home', $this->data);
    }

}
?>
