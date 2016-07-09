<?php
ob_start();
class sent_mail_type extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('sent_mail_type_model');
		$this->load->model('language_model');
    }

	//Function for list Sent Mail Type
    function list_sent_mail_type($lang_id)
	{ 
        $this->data = array();
		$language_id = $lang_id;
        $this->data['error_message'] = "";
		$this->data['all_rows'] = $this->sent_mail_type_model->get_rows($language_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/sent_mail_type_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	//function for adding sent mail type
	function sent_mail_type_add()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
	
		if ($this->input->post('save'))
		{
			$result = $this->sent_mail_type_model->sent_mail_type_add();
			if($result == "add_success")
			{
				redirect('admin/sent_mail_type/list_sent_mail_type/'.$default_language_id.'?inserted');
			}
		}

		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/sent_mail_type_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function for editing Sent mail type
	function sent_mail_type_edit($language_id, $news_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
			$posted_language_id=$this->input->post("language_id");
			$posted_type_id=$this->input->post("type_id");
			$result = $this->sent_mail_type_model->sent_mail_type_edit();	
			if($result == "edit_success")
			{
				redirect('admin/sent_mail_type/list_sent_mail_type/'.$default_language_id.'?updated');
			}
		}
		
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['sent_mail_type_arr']=$this->sent_mail_type_model->get_sent_mail_type($language_id, $news_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/sent_mail_type_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function to inactivate Sent Mail Type
	function inactive($type_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->sent_mail_type_model->inactive($type_id);
		redirect('admin/sent_mail_type/list_sent_mail_type/'.$default_language_id);
	}
	
	//function to activate Sent Mail Type
	function active($type_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->sent_mail_type_model->active($type_id);
		redirect('admin/sent_mail_type/list_sent_mail_type/'.$default_language_id);
	}
	
	//function to delete Sent Mail Type
	function delete($type_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->sent_mail_type_model->delete($type_id);
		redirect('admin/sent_mail_type/list_sent_mail_type/'.$default_language_id.'?deleted');
	}
}

