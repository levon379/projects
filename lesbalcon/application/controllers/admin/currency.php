<?php
ob_start();
class currency extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('currency_model');
		$this->load->model('language_model');
    }
    function list_currency($lang_id)
	{ 
        $this->data = array();
		$language_id = $lang_id;
		$this->data['all_rows'] = $this->currency_model->get_rows($language_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/currency_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	//Set Base Currency
	function set_base_currency($currency_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->currency_model->set_base_currency($currency_id);
		redirect("admin/currency/list_currency/".$default_language_id);
	}
	
	//Set Default Currency
	function set_default($currency_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->currency_model->set_default($currency_id);
		redirect("admin/currency/list_currency/".$default_language_id);
	}
	
	//Edit Currency Details
	function currency_edit($language_id, $currency_auto_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_message'] ="";
		$this->data['error_register'] ="";
		if ($this->input->post('save'))
		{
			$result = $this->currency_model->currency_edit();	
			if($result == "edit_success")
			{
				redirect('admin/currency/list_currency/'.$default_language_id.'?updated');
			}
			else
			{
				$this->data['error_register'] = $result;
			}
		}
		
		//populate view, specific to this function
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['currency_arr']=$this->currency_model->get_currency($language_id, $currency_auto_id);
        $this->data['currency_unique_details']=$this->currency_model->get_unique_details($currency_auto_id);
		//Loading All Pages Part Sequentially
		$this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/currency_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
}

