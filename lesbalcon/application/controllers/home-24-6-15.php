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
	function set_language(){
		/*
		$langval = $_POST['lang_id'];
		$result=$this->language_model->get_lang_details($langval); 
		*/
		$lang_id = $_POST['lang_id'];
		if($lang_id==1) { 
			$this->session->set_userdata('current_lang_id',$lang_id);
			$this->session->set_userdata('current_lang_name','English');
		}else{
			$this->session->set_userdata('current_lang_id',$lang_id);
			$this->session->set_userdata('current_lang_name','French'); 
		}
		exit;
	}
	
	function set_language_new(){ 
		$lang_id = $this->uri->segment(3); 
		if($lang_id==1) { 
			$this->session->set_userdata('current_lang_id',$lang_id);
			$this->session->set_userdata('current_lang_name','English');
		}else{
			$this->session->set_userdata('current_lang_id',$lang_id);
			$this->session->set_userdata('current_lang_name','French'); 
		}
		exit;
		$redirect = (isset($_SERVER['HTTP_REFERER']) and $_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']: base_url();
		//redirect($from); 
		//echo "<pre>"; print_r(get_cookie()); echo $redirect; die;
		
		header('Location: ' . $redirect);
		exit;
	}
	

	//Function to save newsletter email
	function save_email()
	{
		$email=$_POST['email'];
		echo $result=$this->home_model->save_email($email);
	}
}

