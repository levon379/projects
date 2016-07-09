<?php
ob_start();
class search extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('public_init_elements');
		$this->public_init_elements->init_elements();
		$this->load->model('language_model');
		$this->load->model('bunglow_model');
		$this->load->model('search_model');
    }

	//Function for loading listing page for desktop
	function index()
	{ 
		$this->data = array();
		$this->data['search_result'] = $this->search_model->desktop_search_process();
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/search_result', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
    }
	//Function for loading listing page for mobile
    function mobile()
	{ 
		$this->data = array();
		$this->data['search_result'] = $this->search_model->mobile_search_process();
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/search_result', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
    }
	
	
	
	
}

