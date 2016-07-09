<?php
ob_start();
class Language extends CI_Controller
{
    function  __construct() 
	{
        parent::__construct();
        $this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('language_model');
    }

    function index()
	{ 
		$this->data = array();
		$this->data['rows'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/language_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	//Set Language To Default
	function set_default($lang_id)
	{
		$result=$this->language_model->set_default($lang_id);
		redirect('admin/language');
	}

	//Set Language To Active
	function active($lang_id)
	{
     	$this->language_model->active($lang_id);
		$data = Array ('success_message'=>'Language activated successfuly');
		$this->session->set_userdata($data);
		redirect('admin/language');
    }
	
	//Set Language To Inactive
	function inactive($lang_id)
	{
		$this->language_model->inactive($lang_id);
		$data = Array ('success_message'=>'Language Inactivated successfuly');
		$this->session->set_userdata($data);
		redirect('admin/language');
    }
}

