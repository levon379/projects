<?php
ob_start();
class about_st_martin extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('public_init_elements');
		$this->public_init_elements->init_elements();
		$this->load->model('language_model');
		$this->load->model('static_page_model');
		$this->load->model('home_model');
    }

    function index()
	{ 
		$this->data = array();
		$this->data['property']=$this->home_model->get_property();
		$this->data['bungalow']=$this->home_model->get_bungalow();
		$this->data['page_content']=$this->static_page_model->get_stmartin_content();
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/about_st_martin', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
    }
}

