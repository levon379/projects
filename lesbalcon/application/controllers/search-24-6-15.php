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
		//$year = date("Y");		
		
		//$date1=date_create($year."-03-15");

		//$date2=date_create($year."-03-18");

		//$insert_date1 = date_create($year."-03-15");

		//$insert_date2 = date_create($year."-03-18");

		//$diff=date_diff($date1,$date2);

		//$insert_date=date_diff($insert_date1,$insert_date2);

		//echo $diff->format("%R%a days");

	//	die;


      
		
		
		//$total_days=$this->data['search_result'][0]['total_days'];
       
		$this->data = array();
		
		
		//$search_session=$this->session->userdata('search_details');
		
		
		$this->data['season_result'] = $this->search_model->get_season_rows();
		$this->data['search_result'] = $this->search_model->desktop_search_process();
		$this->data['all_rates'] = $this->search_model->get_rates_rows();

        $search_session=array(
			"arrival_date"=>$this->input->post('search_arrival_date'),
			"leave_date"=>$this->input->post('search_leave_date'),
            "person_no"=>$this->input->post('search_keyword'),
            "total_days"=>$this->data['search_result'][0]['total_days']
		                      );
				
		$this->session->set_userdata("search_details", $search_session);


        //print_r($this->data['search_result']);die;
		//$max_person=$this->data['search_result'][0]['max_person'];
		//$person_no=$this->session->set_userdata($max_person);
		//print_r($this->session->set_userdata($max_person));die;
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

