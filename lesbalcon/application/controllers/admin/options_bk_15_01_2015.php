<?php
ob_start();
class options extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('options_model');
		$this->load->model('language_model');
    }

    function list_options($lang_id)
	{ 
        $this->data = array();
		$language_id = $lang_id;
		$this->data['all_rows'] = $this->options_model->get_rows($language_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/options_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	

	function options_add()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_register'] ="";

		if ($this->input->post('save'))
		{
			$result = $this->options_model->options_add();
			if($result == "add_success")
			{
				redirect('admin/options/list_options/'.$default_language_id.'?inserted');
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
		$this->data['content'] = $this->load->view('admin/maincontents/options_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	function options_edit($language_id, $options_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_message'] ="";
		$this->data['error_register'] ="";
		if ($this->input->post('save'))
		{
			$posted_language_id=$this->input->post("language_id");
			$posted_options_id=$this->input->post("options_id");
			$result = $this->options_model->options_edit();	
			if($result == "edit_success")
			{
				redirect('admin/options/list_options/'.$default_language_id.'?updated');
			}
			else
			{
				$this->data['error_register'] = $result;
			}
		}
		
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['options_arr']=$this->options_model->get_options($language_id, $options_id);
        $this->data['options_unique_details']=$this->options_model->get_unique_details($options_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/options_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	function inactive($options_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->options_model->inactive($options_id);
		redirect('admin/options/list_options/'.$default_language_id);
	}
	function active($options_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->options_model->active($options_id);
		redirect('admin/options/list_options/'.$default_language_id);
	}
	
	function delete($options_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->options_model->delete($options_id);
		redirect('admin/options/list_options/'.$default_language_id.'?deleted');
	}
}

