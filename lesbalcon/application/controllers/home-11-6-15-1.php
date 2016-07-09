<?php
ob_start();
class home extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('public_init_elements');
		$this->public_init_elements->init_elements();
		$this->load->model('language_model');
		$this->load->model('bunglow_model');
		$this->load->model('home_model');
    }

	//Function to load home page
    function index()
	{ 
	// echo $this->session->userdata('current_lang_id');
	 
		$this->data = array();
		
		$this->data['banners_arr']=$this->home_model->get_banners();
		$this->data['welcome_text']=$this->home_model->get_welcome_text();
		$this->data['property']=$this->home_model->get_property();
		$this->data['bungalow']=$this->home_model->get_bungalow();
	   //$this->data['testimonial']=$this->home_model->get_latest_testimonial();
        $this->data['testimonial']= $this->bunglow_model->get_testimonials();
		$this->data['galleries']=$this->home_model->get_gallery();
		//$this->data['person_rows']=$this->home_model->get_persons();
		$this->data['news']=$this->home_model->get_news();
		
		
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/home', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
    }

	
	//Function to set language for front end
	function set_language($lan_id=1)
	{
		 $langval = $lan_id;
	 
	 /*	if($lan_id ==2 ){
			$this->lang->load('French', 'French') ;
			$this->session->set_userdata('current_lang_id',2);
			$this->session->set_userdata('current_lang_name','French');
		
		}else{
			$this->lang->load('English', 'English') ;
			$this->session->set_userdata('current_lang_id',1);
			$this->session->set_userdata('current_lang_name','English');
		}
	 
	 */
	 
		  $result=$this->language_model->get_lang_details($langval);
	//	 echo $this->session->userdata('current_lang_id'); die;			 
		if(isset($_SERVER['HTTP_REFERER'])){
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect(base_url());
		}
		
		
	 die;
		
	}

	//Function to save newsletter email
	function save_email()
	{
		$email=$_POST['email'];
		echo $result=$this->home_model->save_email($email);
	}
}

