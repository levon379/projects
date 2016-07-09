<?php
ob_start();
class welcome extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
        $this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('welcome_text_model');
		$this->load->model('language_model');
    }

    function welcome_text($lang_id)
	{ 
        $this->data = array();
		$this->data['error_message'] = "";
		$this->data['success_message'] = "";
		$language_id = $lang_id;
		$this->data['all_rows'] = $this->welcome_text_model->get_rows($language_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/welcome_text', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	
	function text_edit($language_id, $text_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_message'] ="";
		$this->data['error_register'] ="";
		if ($this->input->post('save'))
		{
			$posted_language_id=$this->input->post("language_id");
			$posted_text_id=$this->input->post("text_id");
			$result = $this->welcome_text_model->welcome_text_edit();	
			if($result == "edit_success")
			{
				redirect('admin/welcome/welcome_text/'.$default_language_id.'?updated');
			}
		}
		
		//populate view, specific to this function
		$this->data['language_arr'] = $this->language_model->get_rows();
		//$this->data['pages_arr'] = $this->cms_model->get_banners($language_id, $text_id);
		$this->data['edit_language_id']=$language_id;
		$this->data['text_arr']=$this->welcome_text_model->get_welcome_text($language_id, $text_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/welcome_text_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
}

