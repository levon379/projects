<?php
ob_start();
class tax extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('tax_model');
		$this->load->model('language_model');
    }

	//Function for listing tax
    function list_tax($lang_id)
	{ 
        $this->data = array();
		$language_id = $lang_id;
		$this->data['all_rows'] = $this->tax_model->get_rows($language_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/tax_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	//Function for adding tax
	function tax_add()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_register'] ="";

		if ($this->input->post('save'))
		{
			$result = $this->tax_model->tax_add();
			if($result == "add_success")
			{
				redirect('admin/tax/list_tax/'.$default_language_id.'?inserted');
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
		$this->data['content'] = $this->load->view('admin/maincontents/tax_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//Function for editing tax
	function tax_edit($language_id, $tax_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_message'] ="";
		$this->data['error_register'] ="";
		if ($this->input->post('save'))
		{
			$posted_language_id=$this->input->post("language_id");
			$posted_tax_id=$this->input->post("tax_id");
			$result = $this->tax_model->tax_edit();	
			if($result == "edit_success")
			{
				redirect('admin/tax/list_tax/'.$default_language_id.'?updated');
			}
			else
			{
				$this->data['error_register'] = $result;
			}
		}
		
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['tax_arr']=$this->tax_model->get_tax($language_id, $tax_id);
        $this->data['tax_unique_details']=$this->tax_model->get_unique_details($tax_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/tax_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	function inactive($tax_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->tax_model->inactive($tax_id);
		redirect('admin/tax/list_tax/'.$default_language_id);
	}
	function active($tax_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->tax_model->active($tax_id);
		redirect('admin/tax/list_tax/'.$default_language_id);
	}
	
	function delete($tax_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->tax_model->delete($tax_id);
		redirect('admin/tax/list_tax/'.$default_language_id.'?deleted');
	}
}

