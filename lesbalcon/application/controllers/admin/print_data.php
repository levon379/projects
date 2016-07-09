<?php
ob_start();
class print_data extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('print_data_model');
		$this->load->model('language_model');
    }

	//Function for loading print data page
    function index()
	{ 
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/print_data', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	//function for print process
	function ajax_print_process()
	{
		$report_type=$_POST['report_type'];
		$from_date=$_POST['from_date'];
		$to_date=$_POST['to_date'];
		$result=$this->print_data_model->print_process($report_type, $from_date, $to_date);
		echo $result;
	}
}

