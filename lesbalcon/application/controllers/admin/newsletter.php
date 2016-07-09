<?php
ob_start();
class newsletter extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('newsletter_model');
		$this->load->model('language_model');
    }

	//Function for list email
    function list_email()
	{ 
		$this->data['all_rows'] = $this->newsletter_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/newsletter_email_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	
	//function to activate users
	function active($email_id)
	{
		$this->newsletter_model->active($email_id);
		redirect('admin/newsletter/list_email');
	}
	
	//function to activate users
	function inactive($email_id)
	{
		$this->newsletter_model->inactive($email_id);
		redirect('admin/newsletter/list_email');
	}
	
	//function to delete users
	function delete($email_id)
	{
		$this->newsletter_model->delete($email_id);
		redirect('admin/newsletter/list_email?deleted');
	}
	
	
}

