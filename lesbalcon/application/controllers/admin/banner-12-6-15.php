<?php
ob_start();
class banner extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('banner_model');
		$this->load->model('language_model');
    }

	//Function for listing banners
    function list_banner($lang_id)
	{ 
        $this->data = array();
		$this->data['error_message'] = "";
		$this->data['success_message'] = "";
		$language_id = $lang_id;

		$msg = $this->uri->segment(5);
		$msg1 = $this->uri->segment(6);
		if($msg == 'inserted')
		{
			$this->data['success_message'] = "Banner added successfully.";
		}
		else if($msg == 'updated' || $msg1 == 'updated')
		{
			$this->data['success_message'] = "Banner updated successfully.";
		}
		else if($msg == 'deleted' || $msg1 == 'deleted')
		{
			$this->data['success_message'] = "Banner deleted successfully.";
		}
        $this->data['error_message'] = "";
		$this->data['all_rows'] = $this->banner_model->get_rows($language_id);
		$this->data['max_order'] = $this->banner_model->get_max_order();
		$this->data['language_arr'] = $this->language_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/banner_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	

	function banner_add()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_message'] ="";
		$this->data['error_register'] ="";

		if ($this->input->post('save'))
		{
			$result = $this->banner_model->banner_add();
			if($result == "add_success")
			{
				redirect('admin/banner/list_banner/'.$default_language_id.'?inserted');
			}
			elseif($result == "file_size")
			{
				redirect('admin/banner/banner_add?size');
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
		$this->data['content'] = $this->load->view('admin/maincontents/banner_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	function banner_edit($language_id, $banner_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_message'] ="";
		$this->data['error_register'] ="";
		if ($this->input->post('save'))
		{
			$posted_language_id=$this->input->post("language_id");
			$posted_banner_id=$this->input->post("banner_id");
			$result = $this->banner_model->banner_edit();	
			if($result == "edit_success")
			{
				redirect('admin/banner/list_banner/'.$default_language_id.'?updated');
			}
			elseif($result == "file_size")
			{
				redirect('admin/banner/banner_edit/'.$posted_language_id.'/'.$posted_banner_id.'?size');
			}
			else
			{
				$this->data['error_register'] = $result;
			}
		}
		
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['banner_arr']=$this->banner_model->get_banners($language_id, $banner_id);
        $this->data['banner_unique_details']=$this->banner_model->get_unique_details($banner_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/banner_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	function inactive($banner_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->banner_model->inactive($banner_id);
		redirect('admin/banner/list_banner/'.$default_language_id);
	}
	function active($banner_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->banner_model->active($banner_id);
		redirect('admin/banner/list_banner/'.$default_language_id);
	}
	
	function delete($banner_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->banner_model->delete($banner_id);
		redirect('admin/banner/list_banner/'.$default_language_id.'?deleted');
	}
	
	function change_order()
	{
		$result=$this->banner_model->change_order($_POST['id'], $_POST['current_order'], $_POST['changed_order']);
	}
	
}

