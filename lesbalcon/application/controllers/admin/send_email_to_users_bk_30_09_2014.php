<?php
ob_start();
class send_email_to_users extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('send_email_to_users_model');
		$this->load->model('language_model');
    }

	//Function for sending emails to users
	function index()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
			$result = $this->send_email_to_users_model->send_email();	
			if($result == "mailsent")
			{
				redirect('admin/send_email_to_users?mailsent');
			}
		}
		$this->data['all_users_arr'] = $this->send_email_to_users_model->get_all_users();
		$this->data['template_arr']=$this->send_email_to_users_model->get_rows($default_language_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/send_email_to_users', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
}

