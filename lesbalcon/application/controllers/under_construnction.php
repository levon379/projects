<?php
ob_start();
class under_construnction extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('public_init_elements');
		$this->public_init_elements->init_elements();
		$this->load->model('language_model');
    }

    function index()
	{ 
		$this->data = array();
		$this->load->view('maincontents/under_construnction', $this->data);
    }
	
}

