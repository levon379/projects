<?php
ob_start();
class gallery extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('gallery_model');
		$this->load->model('language_model');
    }

    function list_gallery($lang_id){ 
		clearstatcache(); 
		
        $this->data = array();
		$language_id = $lang_id;
		$this->data['all_rows'] = $this->gallery_model->get_rows($language_id);
		$this->data['max_order'] = $this->gallery_model->get_max_order();
		$this->data['language_arr'] = $this->language_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/gallery_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	

	function gallery_add()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_message'] ="";
		$this->data['error_register'] ="";

		if ($this->input->post('save'))
		{
			$result = $this->gallery_model->gallery_add();
			if($result == "add_success")
			{
				redirect('admin/gallery/list_gallery/'.$default_language_id.'?inserted');
			}
			elseif($result == "file_size")
			{
				redirect('admin/gallery/gallery_add?size');
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
		$this->data['content'] = $this->load->view('admin/maincontents/gallery_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	function gallery_edit($language_id, $gallery_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_message'] ="";
		$this->data['error_register'] ="";
		if ($this->input->post('save'))
		{
			$posted_language_id=$this->input->post("language_id");
			$posted_gallery_id=$this->input->post("gallery_id");
			$result = $this->gallery_model->gallery_edit();	
			if($result == "edit_success")
			{
				redirect('admin/gallery/list_gallery/'.$default_language_id.'?updated');
			}
			elseif($result == "file_size")
			{
				redirect('admin/gallery/gallery_edit/'.$posted_language_id.'/'.$posted_gallery_id.'?size');
			}
			else
			{
				$this->data['error_register'] = $result;
			}
		}
		
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['gallery_arr']=$this->gallery_model->get_gallery($language_id, $gallery_id);
        $this->data['gallery_unique_details']=$this->gallery_model->get_unique_details($gallery_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/gallery_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	function inactive($gallery_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->gallery_model->inactive($gallery_id);
		redirect('admin/gallery/list_gallery/'.$default_language_id);
	}
	function active($gallery_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->gallery_model->active($gallery_id);
		redirect('admin/gallery/list_gallery/'.$default_language_id);
	}
	
	function delete($gallery_id)
	{
		clearstatcache();
		$default_language_id=$this->language_model->get_default_language_id();
		$this->gallery_model->delete($gallery_id);
		redirect('admin/gallery/list_gallery/'.$default_language_id.'?deleted');
	}
	
	function set_featured($gallery_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->gallery_model->set_featured($gallery_id);
		redirect('admin/gallery/list_gallery/'.$default_language_id);
	}
	
	function change_order()
	{
		$result=$this->gallery_model->change_order($_POST['id'], $_POST['current_order'], $_POST['changed_order']);
	}
}

