<?php
ob_start();
class rates extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('options_model');
		$this->load->model('rates_model');
        $this->load->model('season_model');
    }

	//Function for listing rates 
    function list_rates($lang_id)
	{ 
        $this->data = array();
		$language_id = $lang_id;
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data['all_rows'] = $this->rates_model->get_rows($language_id);
		//$this->data['seasons_rows'] = $this->rates_model->get_all_seasons($default_language_id);
        $this->data['seasons_rows'] = $this->season_model->get_rows($language_id);

		//echo "<pre>";
		//print_r($this->data['all_rows']);
		//die(0);
		$this->data['language_arr'] = $this->language_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/rates_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	//Function for Adding rates 
	function rates_add()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_register'] ="";

		if ($this->input->post('save'))
		{
			$result = $this->rates_model->rates_add();
			if($result == "add_success")
			{
				redirect('admin/rates/list_rates/'.$default_language_id.'?inserted');
			}
			elseif($result == "already_exist")
			{
				redirect('admin/rates/rates_add?exists');
			}
			else
			{
				$this->data['error_register'] = $result;
			}
		}
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['bunglow_arr'] = $this->rates_model->get_all_bunglows($default_language_id);
		$this->data['seasons_arr'] = $this->rates_model->get_all_seasons($default_language_id);
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/rates_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	
	//Function for edit rates
	function rates_edit($bunglow_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
			$result = $this->rates_model->rates_edit();	
			if($result == "edit_success")
			{
				redirect('admin/rates/list_rates/'.$default_language_id.'?updated');
			}
			else
			{
				$this->data['error_register'] = $result;
			}
		}
		
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['bunglow_arr'] = $this->rates_model->get_all_bunglows($default_language_id);
		$this->data['rates_arr'] = $this->rates_model->get_rates($bunglow_id, $default_language_id);

		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/rates_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	/*function inactive($options_id)
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
	}*/
	
	//Function for Deleting rates 
	function delete($bunglow_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->rates_model->delete($bunglow_id);
		redirect('admin/rates/list_rates/'.$default_language_id.'?deleted');
	}
}

