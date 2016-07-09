<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'libraries/facebook/facebook.php';
class public_init_elements
{
    var $CI;
	
	//#####################################################//
	//################# LOAD CONSTRUCTOR ##################//
	//#####################################################//
    
	function  __construct()
    {
        $this->CI =& get_instance();
		$this->CI->load->helper('language');
		$this->CI->load->model('language_model');
		$this->CI->load->library('session');
		$this->CI->config->item('language', false);
		$this->CI->load->model('currency_model');
		$this->CI->load->model('home_model');
		$this->CI->config->load('facebook');
    }
	
	//#####################################################//
	//################# LOAD CONSTRUCTOR ##################//
	//#####################################################//
	
	
	//#####################################################//
	//#################### LOAD HEAD ######################//
	//#####################################################//

    function init_head()
    {
		$current_lang_id = $this->CI->session->userdata('current_lang_id');
		$uri_segment_1=$this->CI->uri->segment(1);
		if($uri_segment_1=="")//If Loading home page without any uri segment
		{
			$seo_details=$this->CI->home_model->get_default_seo();
			$meta_title	=$seo_details['meta_title'].' : Home';
		}
		else //If uri segment will be bungalow or properties
		{
			if($uri_segment_1=="bungalows" || $uri_segment_1=="properties")
			{
				$uri_segment_2=$this->CI->uri->segment(2);
				if($uri_segment_2!="" && !is_numeric($uri_segment_2))
				{
					$default_seo_details=$this->CI->home_model->get_default_seo();
					$meta_title	=$default_seo_details['meta_title'];
					$seo_details=$this->CI->home_model->get_bungalow_seo($uri_segment_2);
				}
				else //if bungalow or property page will be loaded without uri segment 2
				{
					$seo_details=$this->CI->home_model->get_default_seo();
					$meta_title	=$seo_details['meta_title'];
				}
			}
			elseif($uri_segment_1=="trip-advisor" || $uri_segment_1=="contact-us" || $uri_segment_1=="services" || $uri_segment_1=="about-st-martin" || $uri_segment_1=="reservation")
			{
				$default_seo_details=$this->CI->home_model->get_default_seo();
				$meta_title	=$default_seo_details['meta_title'];
				$seo_details=$this->CI->home_model->get_static_page_seo($uri_segment_1);
			}
			else //if other pages will be loaded
			{
				$seo_details=$this->CI->home_model->get_default_seo();
				$meta_title	=$seo_details['meta_title'];
			}
		}
		$meta_description=$seo_details['meta_description'];
		$meta_keywords=$seo_details['meta_keyword'];
		//populate default meta values for any controller
		if($this->CI->uri->segment(2) != '')
		{
        	$data['title'] = $meta_title.' : '.ucfirst(str_replace(array('-','_'), ' ', $this->CI->uri->segment(1))).' : '.ucfirst(str_replace(array('-','_'), ' ', $this->CI->uri->segment(2)));
		}
		elseif($this->CI->uri->segment(1) != '')
		{
        	$data['title'] = $meta_title.' : '.ucfirst(str_replace(array('-','_'), ' ', $this->CI->uri->segment(1)));
		}
		else
		{
			$data['title'] = $meta_title;
		}
		
        $data['meta_keyword'] = $meta_keywords;
        $data['meta_description'] = $meta_description;
		$data['default_language_id']=$this->CI->language_model->get_default_language_id();
		$data['default_currency']=$this->CI->currency_model->get_default_currency();
		$data['all_lang'] = $this->CI->language_model->get_rows();
        $this->CI->data['head'] = $this->CI->load->view('elements/head', $data, true);
		$this->CI->data['header_top'] = $this->CI->load->view('elements/header_top', $data, true);
		$this->CI->data['header_menu'] = $this->CI->load->view('elements/header_menu', $data, true);
		$this->CI->data['footer'] = $this->CI->load->view('elements/footer', $data, true);
    }

	//#####################################################//
	//#################### LOAD HEAD ######################//
	//#####################################################//
	
	
	//##############################################################//
	//#################### LOAD INIT ELEMENTS ######################//
	//##############################################################//
    
    function init_elements()
    {
        $this->load_language();
        $this->init_head();
    }
	
	//##############################################################//
	//#################### LOAD INIT ELEMENTS ######################//
	//##############################################################//
	
	
	//##############################################################//
	//############### GENARATE PASSWORD STRAINGTH ##################//
	//##############################################################//
	
	
	function generatePassword($length=9, $strength=0) 
	{
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}
	 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}
	
	
	//##############################################################//
	//############### GENARATE PASSWORD STRAINGTH ##################//
	//##############################################################//
	
	
	
	
	function is_user_logged_in()
    {
        if(!$this->CI->session->userdata('login_user_info'))
        {
            redirect("user/login");
        }
    }
	
	
	function get_default_language_id()
	{
		return $this->CI->language_model->get_default_language_id();
	}
	
	
	//Function to load languages
	function load_language()
	{
		$language = $this->CI->session->userdata('current_lang_name'); 
		if(!isset($language) || $language== "")
		{
			$this->CI->filename=$this->CI->language_model->get_default_lang_name();
			$this->CI->language=$this->CI->language_model->get_default_lang_name();
			
			$this->CI->session->set_userdata('current_lang_id',$this->CI->language_model->get_default_language_id());
			$this->CI->session->set_userdata('current_lang_name',$this->CI->language_model->get_default_lang_name());
		}
		else
		{
			$this->CI->filename=$this->CI->session->userdata('current_lang_name');
			$this->CI->language=$this->CI->session->userdata('current_lang_name');
		}
		$this->CI->lang->load($this->CI->filename, $this->CI->language);
		$this->CI->config->set_item('language', $this->CI->filename);
	}
	
}

?>