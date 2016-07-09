<?php
ob_start();
class cms extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
        $this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('cms_model');
		$this->load->model('language_model');
    }

    function list_cms($lang_id)
	{ 
        $this->data = array();
		$this->data['error_message'] = "";
		$this->data['success_message'] = "";
		$language_id = $lang_id;
		$this->data['all_rows'] = $this->cms_model->get_rows($language_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/cms_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	
	
	
	function cms_add()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_message'] ="";
		$this->data['error_register'] ="";
		if ($this->input->post('save'))
		{
			$result = $this->cms_model->cms_add();	
			if($result == "file_size")
			{
				redirect('admin/cms/cms_add?size');
			}
			if($result == "add_success")
			{
				redirect('admin/cms/list_cms/'.$default_language_id.'?inserted');
			}
			else
			{
				$this->data['error_register'] = $result;
			}
		}

		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/cms_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	function cms_edit($language_id, $pages_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_message'] ="";
		$this->data['error_register'] ="";
		if ($this->input->post('save'))
		{
			$result = $this->cms_model->cms_edit();	
			if($result == "file_size")
			{
				redirect('admin/cms/cms_edit/'.$language_id.'/'.$pages_id.'?size');
			}
			if($result == "edit_success")
			{
				redirect('admin/cms/list_cms/'.$default_language_id.'?updated');
			}
			else
			{
				$this->data['error_register'] = $result;
			}
		}
		
		//populate view, specific to this function
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		//Get Language Specific details
		$this->data['page_arr']=$this->cms_model->get_pages($language_id, $pages_id);
		//Get Language independent details
        $this->data['page_unique_details']=$this->cms_model->get_unique_details($pages_id);

		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/cms_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
}

