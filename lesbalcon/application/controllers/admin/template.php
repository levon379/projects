<?php
ob_start();
class template extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('template_model');
		$this->load->model('language_model');
    }

	//Function for list template page
    function list_template($lang_id)
	{ 
        $this->data = array();
		$language_id = $lang_id;
        $this->data['error_message'] = "";
		$this->data['all_rows'] = $this->template_model->get_rows($language_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/template_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	//function for adding template
	function template_add()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
	
		if ($this->input->post('save'))
		{
			$result = $this->template_model->template_add();
			if($result == "add_success")
			{
				redirect('admin/template/list_template/'.$default_language_id.'?inserted');
			}
		}

		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['email_type_arr'] = $this->template_model->get_email_type($default_language_id);
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/template_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function for editing template
	function template_edit($language_id, $template_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
			$posted_language_id=$this->input->post("language_id");
			$posted_template_id=$this->input->post("template_id");
			$result = $this->template_model->template_edit();	
			if($result == "edit_success")
			{
				redirect('admin/template/list_template/'.$default_language_id.'?updated');
			}
		}
		
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['email_type_arr'] = $this->template_model->get_email_type($default_language_id);
		$this->data['template_arr']=$this->template_model->get_template($language_id, $template_id);
		$this->data['template_unique_details']=$this->template_model->get_unique_details($template_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/template_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//Function for sending emails to users
	function send_email($language_id, $template_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
			$result = $this->template_model->send_email();	
			if($result == "mailsent")
			{
				redirect('admin/template/list_template/'.$default_language_id.'?mailsent');
			}
		}
		
		$this->data['sent_template_id']=$template_id;
		$this->data['all_users_arr'] = $this->template_model->get_all_users();
		$this->data['current_template'] = $this->template_model->get_template($language_id, $template_id);
		$this->data['template_arr']=$this->template_model->get_rows($language_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/template_send_email', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
}

