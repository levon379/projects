<?php
ob_start();
class bungalows extends CI_Controller{
    //var $data;
    function  __construct() {
        parent::__construct();
		$this->load->library('public_init_elements');
		$this->public_init_elements->init_elements();
		$this->load->model('language_model');
		$this->load->model('bunglow_model');
		$this->load->library('pagination');
    }

	//Function for loading properties page
    function index($offset=""){  
		
		$this->data = array();
		
		//Check if 2nd uri segment id numeric or not. If not then details page will be loaded
		//If offset will be numeric then listing page will be loaded with pagination
		//if no offset the  listing page will be loaded
		
		if(is_numeric($offset) || $offset==""){ 
			if($offset==""){
				$offset=0;
			}
		
			$limit								= 6;
			$total_records 						= $this->bunglow_model->get_total_bungalows();
			$config['base_url'] 				= base_url().'bungalows';
			$config['total_rows'] 				= $total_records;
			$config['per_page'] 				= $limit;
			$config['uri_segment'] 				= 2;
			$config['num_links'] 				= 1;
			$config['full_tag_open'] 			= '<ul class="page">';
			$config['full_tag_close'] 			= '</ul>';
			$config['cur_tag_open'] 			= '<li><a class="active">';
			$config['cur_tag_close'] 			= '</a></li>';
			$config['prev_link'] 	 			= '< ';
			$config['next_link'] 	 			= ' >';
			$config['first_link'] 	 			= 'First';
			$config['last_link'] 				= 'Last';
			$this->pagination->initialize($config); 
			$this->data['pagination_link']		=$this->pagination->create_links();
			$this->data['bungalows'] 			= $this->bunglow_model->get_bungalows($limit, $offset);
			$this->data['head'] 				= $this->load->view('elements/head', $this->data, true);
			$this->data['header_top'] 			= $this->load->view('elements/header_top', $this->data, true);
			$this->data['header_menu'] 			= $this->load->view('elements/header_menu', $this->data, true); // echo "333121212555"; die; 
			$this->data['content'] 				= $this->load->view('maincontents/bungalows', $this->data, true);  
			$this->data['footer'] 				= $this->load->view('elements/footer', $this->data, true);
			$this->load->view('layout', $this->data);
		}else{
			$slug=$offset;
			$this->data = array(); 
			//Get Property Details
			$this->data['all_seasons']=$this->bunglow_model->get_seasons_for_front_end();
			$this->data['properties_details'] = $this->bunglow_model->get_properties_details($slug);
			$this->data['properties_images'] = $this->bunglow_model->get_properties_images($slug);
			$this->data['properties_rates']= $this->bunglow_model->get_properties_rates($slug);

			$this->data['testimonials']= $this->bunglow_model->get_testimonials();
			//loading parts of the page
			$this->data['head'] = $this->load->view('elements/head', $this->data, true);
			$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
			$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
			$this->data['content'] = $this->load->view('maincontents/details', $this->data, true);
			$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
			$this->load->view('layout', $this->data);
		}
	
    }
	
}

