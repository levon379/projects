<?php
ob_start();
class activity extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('public_init_elements');
		$this->public_init_elements->init_elements();
		$this->load->model('home_model');
		$this->load->model('static_page_model');
    }

    function index($slug="")
	{ 
		$this->data = array();
		if($slug!="")
		{
			$this->data['activity_details']=$this->home_model->get_news_details($slug);
			$this->data['head'] = $this->load->view('elements/head', $this->data, true);
			$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
			$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
			$this->data['content'] = $this->load->view('maincontents/activity_details', $this->data, true);
			$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
			$this->load->view('layout', $this->data);
		}
		else 
		{
			$this->data['page_content']=$this->static_page_model->get_activities_content();
			$this->data['head'] = $this->load->view('elements/head', $this->data, true);
			$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
			$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
			$this->data['content'] = $this->load->view('maincontents/activities', $this->data, true);
			$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
			$this->load->view('layout', $this->data);
		}
    }

}

