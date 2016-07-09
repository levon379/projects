<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_init_elements
{
    var $CI;

    function  __construct()
    {
        $this->CI =& get_instance();
		$this->CI->load->model('language_model');
		$this->CI->load->model('admin_setting_model');
    }

    function init_head()
    {
        //populate default meta values for any controller
		$data=array();
		$data['title'] = "Les Balcons || Admin";
		$data['default_language_id']=$this->CI->language_model->get_default_language_id();
		$data['pagination_limit']=$this->CI->admin_setting_model->get_admin_pagination_limit();
		$data['current_time_zone']=$this->CI->language_model->get_admin_time_zone();
        $this->CI->data['head'] = $this->CI->load->view('admin/elements/head', $data, true);
		$this->CI->data['header_top'] = $this->CI->load->view('admin/elements/header_top', $data, true);
		$this->CI->data['left_side_bar'] = $this->CI->load->view('admin/elements/left_side_bar', $data, true);
		$this->CI->data['footer'] = $this->CI->load->view('admin/elements/footer', $data, true);
    }

    function init_elements()
    {
        //index call to populate all the header / footer / side bar elements
		$this->load_language();
        $this->init_head();
    }
	
	//Check admin is logged in or not
    function is_admin_logged_in()
    {
        $is_admin_logged_in = $this->CI->session->userdata('is_admin_logged_in');

        if(!isset($is_admin_logged_in) || $is_admin_logged_in != TRUE)
        {
            redirect('admin/login');
        }
    }
	
	
	function is_valid_dimension($image_width,$image_height,$name)
	{
		$image_valid_dimensions = $this->CI->config->item('image_valid_dimensions');
		$validate_dimension = $image_valid_dimensions[$name];
		$value = explode("|", $validate_dimension);
		if($value[0] == $image_width and $value[1] == $image_height)
		{
			return TRUE;
		}	
		else
		{
			return FALSE;
		}
	
	}
	
	
	//Check default language id on admin logged in
	function get_default_language_id()
	{
		return $this->CI->language_model->get_default_language_id();
	}
	
	
	//Check default language detail on admin logged in to load default language content
	function load_language()
	{
		$this->CI->load->model('language_model');
		$this->CI->filename=ucwords($this->CI->language_model->get_default_lang_name());
		$this->CI->language=ucwords($this->CI->language_model->get_default_lang_name());

		//echo $this->CI->language; die();
		$aa=$this->CI->lang->load($this->CI->filename,$this->CI->language);
		$this->CI->load->helper('language');
	}

	//Get Pagination limit
	function get_pagination_limit()
	{
		$result=$this->CI->admin_setting_model->get_admin_pagination_limit();
		return $result;
	}
	
	
}

?>