<?php
ob_start();
class testimonials extends CI_Controller
{


   function  __construct() 
	{
        parent::__construct();
        $this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('testimonials_model');
		$this->load->model('language_model');
    }
    //var $data;
    //#################Function For Viewing Testimonials######################
	
	function view_testimonials($language_id)
	{
	
	  $default_language_id=$this->language_model->get_default_language_id();
	
	   
		//$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data = array();
		//$this->data['bunglow_name'] = $this->testimonials_model->get_bunglow_name($language_id);
		$this->data['all_rows'] = $this->testimonials_model->get_all_testimonials($language_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/testimonials_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	
	//function for adding faq
	function add_testimonials()
	{
	    //$bungalow_id=$this->uri->segment(4);
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
	
		if ($this->input->post('save'))
		{
			$result = $this->testimonials_model->add_testimonials();
			if($result == "add_success")
			{
				redirect('admin/testimonials/view_testimonials/'.$default_language_id);
			}
		}

		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/testimonials_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function for editing testimonials
	function edit_testimonials($language_id, $testimonials_id)
	{
	    $default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
			$posted_language_id=$this->input->post("language_id");
			$posted_testimonials_id=$this->input->post("testimonials_id");
			//$posted_bunglow_id=$this->input->post("bunglow_id");
			$result = $this->testimonials_model->testimonials_edit();	
			if($result == "edit_success")
			{
				redirect('admin/testimonials/view_testimonials/'.$default_language_id.'/'.'?updated');
			}
		}
		
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['testimonials_arr']=$this->testimonials_model->get_testimonials_admin($language_id, $testimonials_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/testimonials_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	
	
	}
	
	
	
	function delete_testimonials($language_id, $testimonial_id)
	{
		$this->testimonials_model->delete_testimonials($testimonial_id);
		redirect('admin/testimonials/view_testimonials/'.$language_id.'/'.'?deleted');
	}
	
	function ajax_testomial_status()
	{
		$test_id=$_POST['test_id'];
		$status=$_POST['status'];
		$result=$this->testimonials_model->testimonial_status_change($test_id, $status);
		echo $result;
	}
	
	
}

