<?php
ob_start();
class rates extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('public_init_elements');
		$this->public_init_elements->init_elements();
		$this->load->model('language_model');
		$this->load->model('rates_model');
		$this->load->model('reservation_model');
    }

    function index()
	{ 
		$this->data = array();
		//Getting rates and seasons for rate page
		$this->data['all_rates']=$this->rates_model->get_all_rates();
		$this->data['reservation_content']=$this->reservation_model->get_reservation_content();
		$this->data['all_seasons']=$this->rates_model->get_seasons_for_front_end();
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/rates', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
    }

}

