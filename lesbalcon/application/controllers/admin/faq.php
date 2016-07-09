<?php
ob_start();
class faq extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('faq_model');
		$this->load->model('language_model');
    }

	//Function for list news page
    function list_faq($lang_id)
	{ 
        $this->data = array();
		$language_id = $lang_id;
        $this->data['error_message'] = "";
		$this->data['all_rows'] = $this->faq_model->get_rows($language_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/faq_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	//function for adding faq
	function faq_add()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
	
		if ($this->input->post('save'))
		{
			$result = $this->faq_model->faq_add();
			if($result == "add_success")
			{
				redirect('admin/faq/list_faq/'.$default_language_id.'?inserted');
			}
		}

		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/faq_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function for editing faq
	function faq_edit($language_id, $faq_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
			$posted_language_id=$this->input->post("language_id");
			$posted_faq_id=$this->input->post("faq_id");
			$result = $this->faq_model->faq_edit();	
			if($result == "edit_success")
			{
				redirect('admin/faq/list_faq/'.$default_language_id.'?updated');
			}
		}
		
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['faq_arr']=$this->faq_model->get_faq($language_id, $faq_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/faq_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function to inactivate faq
	function inactive($faq_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->faq_model->inactive($faq_id);
		redirect('admin/faq/list_faq/'.$default_language_id);
	}
	
	//function to activate faq
	function active($faq_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->faq_model->active($faq_id);
		redirect('admin/faq/list_faq/'.$default_language_id);
	}
	
	
	//function to delete faq
	function delete($faq_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->faq_model->delete($faq_id);
		redirect('admin/faq/list_faq/'.$default_language_id.'?deleted');
	}
}

