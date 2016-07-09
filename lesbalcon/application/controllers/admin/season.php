<?php
ob_start();
class season extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('season_model');
		$this->load->model('language_model');
    }

	//Function for list news page
    function list_season($lang_id)
	{ 
        $this->data = array();
		$language_id = $lang_id;
        $this->data['error_message'] = "";
		$this->data['all_rows'] = $this->season_model->get_rows($language_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/season_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	//function for adding faq
	function season_add()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
	
		if ($this->input->post('save'))
		{
			$result = $this->season_model->season_add();
			if($result == "add_success")
			{
				redirect('admin/season/list_season/'.$default_language_id.'?inserted');
			}
		}

		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/season_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	
	
	//function for editing season
	function season_edit($language_id, $season_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
			$posted_language_id=$this->input->post("language_id");
			$posted_season_id=$this->input->post("season_id");
			$result = $this->season_model->season_edit();	
			if($result == "edit_success")
			{
				redirect('admin/season/list_season/'.$default_language_id.'?updated');
			}
		}
		
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['season_arr']=$this->season_model->get_season($language_id, $season_id);
		$this->data['unique_details']=$this->season_model->get_unique_details($season_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/season_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function to inactivate season
	function inactive($season_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->season_model->inactive($season_id);
		redirect('admin/season/list_season/'.$default_language_id);
	}
	
	//function to activate season
	function active($season_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->season_model->active($season_id);
		redirect('admin/season/list_season/'.$default_language_id);
	}
	
	
	//function to delete season
	function delete($season_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->season_model->delete($season_id);
		redirect('admin/season/list_season/'.$default_language_id.'?deleted');
	}
}

