<?php
ob_start();
class search extends CI_Controller{

    function  __construct(){
        parent::__construct();
		$this->load->library('public_init_elements');
		$this->public_init_elements->init_elements();
		$this->load->model('language_model');
		$this->load->model('bunglow_model');
		$this->load->model('search_model');
    }

	
	
	function search_validation(){
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
		define('MP_DB_DEBUG', true); 


		$posted_arrival_date 	= isset($_REQUEST['arrival_date'])?$_REQUEST['arrival_date']:'';
		$posted_leave_date 	 	= isset($_REQUEST['leave_date'])?$_REQUEST['leave_date']:''; 
		$bungalow_id	 	 	= isset($_REQUEST['bungalow_id'])?$_REQUEST['bungalow_id']:''; 
		
		$arrival_date_arr	 	= explode("/", $posted_arrival_date);
		$arrival_date		 	= $arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0];

		//Getting leave date in php format
		$leave_date_arr 	 	= explode("/", $posted_leave_date);
		$leave_date				= $leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0]; 
		$date_arr			 	= $this->search_model->dateRange($arrival_date, $leave_date);
		$total_days			 	= count($date_arr)-1;
		
		if(in_array($arrival_date_arr[1], array(5,6,7,8,9,10,11,12))){
			$season_date_start	= strtotime($arrival_date_arr[2] ."-12-15");
			$season_date_end	= strtotime($arrival_date_arr[2]+1 ."-04-14");
		}else{ 
			$season_date_start	= strtotime($arrival_date_arr[2]-1 ."-12-15");
			$season_date_end	= strtotime($arrival_date_arr[2] ."-04-14");
		}
		$booking_arrival_date	= strtotime($arrival_date);
		$booking_leave_date		= strtotime($leave_date);
		
		if((in_array($bungalow_id, array(64,66,68,69,71))) and ($total_days < 5)){
			echo 5;
		}/*elseif((($booking_arrival_date >= $season_date_start) and ($booking_arrival_date <= $season_date_end)) || (($booking_arrival_date <= $season_date_start) and ($booking_leave_date >= $season_date_start)) || (($booking_arrival_date >= $season_date_start) and ($booking_arrival_date <= $season_date_end) and ($booking_leave_date >= $season_date_start) and ($booking_leave_date <= $season_date_end)) and ($total_days < 3)){
			echo 3;
		}*/
			elseif((($booking_arrival_date >=$season_date_start )and($booking_leave_date<=$season_date_end))and($total_days<3))
			{
				echo 3;
			}
			
			
		elseif($total_days <2 and (($booking_arrival_date > $season_date_end )or($booking_leave_date<$season_date_start ))){
			echo 2;
		}else{
			echo 1;
		}
	}
	
	
	
	
	//Function for loading listing page for desktop
	function index(){
		$this->data = array(); 

		$this->data['season_result'] = $this->search_model->get_season_rows();
		$this->data['search_result'] = $this->search_model->desktop_search_process();
		$this->data['all_rates'] 	 = $this->search_model->get_rates_rows();

	//echo "<pre>"; print_r($this->data['search_result']); die;

        $search_session=array(
			"arrival_date"	=> $this->input->post('search_arrival_date'),
			"leave_date"	=> $this->input->post('search_leave_date'),
            "person_no"		=> $this->input->post('search_keyword'),
            "total_days"	=> $this->data['search_result'][0]['total_days']
		);

		$this->session->set_userdata("search_details", $search_session);

		$this->data['head'] 		= $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] 	= $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] 	= $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] 		= $this->load->view('maincontents/search_result', $this->data, true);
		$this->data['footer'] 		= $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
    }


	//Function for loading listing page for mobile
    function mobile(){ 
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

