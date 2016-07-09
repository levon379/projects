<?php
//ob_start();
class bunglow extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
        $this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('bunglow_model');
		$this->load->model('language_model');
    }
    
    function phpinfo(){
    	phpinfo();
    }

    function list_bunglow($lang_id, $offset=0)
	{ 
        $this->data = array();
		$this->data['error_message'] = "";
		$this->data['success_message'] = "";
		$language_id = $lang_id;
		$this->data['max_order'] = $this->bunglow_model->get_max_order();
		$this->data['all_rows'] = $this->bunglow_model->get_rows($language_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/bunglow_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	
	
	//Adding Bunglow with multiple images
	function bunglow_add()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_message'] ="";
		$this->data['error_register'] ="";

		if ($this->input->post('save'))
		{
			$result = $this->bunglow_model->bunglow_add();	
			if($result == "add_success")
			{
				redirect('admin/bunglow/list_bunglow/'.$default_language_id.'?inserted');
			}
			elseif($result == "file_size")
			{
				redirect('admin/bunglow/list_bunglow?size');
			}
			else
			{
				$this->data['error_register'] = $result;
			}
		}
		
		//populate view, specific to this function
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['options_arr'] = $this->bunglow_model->get_options($default_language_id);
		$this->data['tax_arr'] = $this->bunglow_model->get_tax($default_language_id);
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/bunglow_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	
	//Edit bunglow
	function bunglow_edit($language_id, $bunglow_id)
	{
		
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		$this->data['error_message'] ="";
		$this->data['error_register'] ="";
		$msg = $this->uri->segment(3);
		$msg1 = $this->uri->segment(4);
		//echo '<pre>';print_r($_POST);exit;
		if(!empty($_POST)){
			///echo '<pre>';print_r($_POST);exit;
		}
		
		if ($this->input->post('save'))
		{
			if(isset($_POST['virtual_tour_code']) and $_POST['virtual_tour_code'] !=''){
				$_POST['virtual_tour_code'] = '<iframe'.$_POST['virtual_tour_code'].'></iframe>';
			}
			//exit;
			
			$posted_language_id=$this->input->post("language_id");
			$posted_bunglow_id=$this->input->post("bunglow_id");
			$result = $this->bunglow_model->bunglow_edit();	
			if($result == "edit_success")
			{
				redirect('admin/bunglow/list_bunglow/'.$default_language_id.'?updated');
			}
			elseif($result == "file_size")
			{
				redirect('admin/bunglow/bunglow_edit/'.$posted_language_id.'/'.$posted_bunglow_id.'?'.'size');
			}
			else
			{
				$this->data['error_register'] = $result;
			}
		}
		
		//populate view, specific to this function
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['options_arr'] = $this->bunglow_model->get_options($default_language_id);
		$this->data['tax_arr'] = $this->bunglow_model->get_tax($default_language_id);
		$this->data['edit_language_id']=$language_id;
		$this->data['bunglow_arr']=$this->bunglow_model->get_bunglow_for_edit($language_id, $bunglow_id);
        $this->data['bunglow_unique_details']=$this->bunglow_model->get_unique_details($bunglow_id);

		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/bunglow_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	
	
	function inactive($bunglow_id){
		$default_language_id=$this->language_model->get_default_language_id();
		$this->bunglow_model->inactive($bunglow_id);
		redirect('admin/bunglow/list_bunglow/'.$default_language_id);
	}
	
	
	function active($bunglow_id){
		$default_language_id=$this->language_model->get_default_language_id();
		$this->bunglow_model->active($bunglow_id);
		redirect('admin/bunglow/list_bunglow/'.$default_language_id);
	}
	
	
	function delete($bunglow_id){
		$default_language_id=$this->language_model->get_default_language_id();
		$this->bunglow_model->delete($bunglow_id);
		redirect('admin/bunglow/list_bunglow/'.$default_language_id.'/deleted');
	}
	
	
	function set_featured($bunglow_id){
		$default_language_id=$this->language_model->get_default_language_id();
		$this->bunglow_model->set_featured($bunglow_id);
		redirect('admin/bunglow/list_bunglow/'.$default_language_id);
	}
	
	
	
	
	function inactive_ajx(){
		$bunglow_id = $_POST['id']; 
		$this->bunglow_model->inactive($bunglow_id); 
	}
	
	
	function active_ajx(){
		$bunglow_id = $_POST['id']; 
		$this->bunglow_model->active($bunglow_id); 
	}
	
	
	function delete_ajx(){
		$bunglow_id = $_POST['id']; 
		$this->bunglow_model->delete($bunglow_id); 
	}
	
	
	function set_featured_ajx(){
		$bunglow_id = $_POST['id']; 
		$this->bunglow_model->set_featured($bunglow_id); 
	}
		
	//#######################Functions For Bunglow Image Management########################//
	
	
	//Getting Bunglow Images row according to selected languages
	function bunglow_image_list($lang_id, $bunglow_id)
	{
		$this->data = array();
		$this->data['error_message'] = "";
		$this->data['success_message'] = "";
		$language_id = $lang_id;
		$this->data['bunglow_name'] = $this->bunglow_model->get_bunglow_name($language_id, $bunglow_id);
		$this->data['all_rows'] = $this->bunglow_model->get_bunglow_images_list($language_id, $bunglow_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/bunglow_image_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	

	//Making Bunglow Image Inactive
	function image_inactive($language_id, $bunglow_id, $bunglow_image_id){
		$result=$this->bunglow_model->image_inactive($bunglow_image_id);
		redirect('admin/bunglow/bunglow_image_list/'.$language_id.'/'.$bunglow_id);
	}
	
	
	
	//Making Bunglow Image active
	function image_active($language_id, $bunglow_id, $bunglow_image_id){
		$result=$this->bunglow_model->image_active($bunglow_image_id);
		redirect('admin/bunglow/bunglow_image_list/'.$language_id.'/'.$bunglow_id);
	}
	
	
	

	//Making Bunglow Image Inactive
	function image_inactive_ajx(){
		$bunglow_image_id = $_POST['id']; 
		$result=$this->bunglow_model->image_inactive($bunglow_image_id); 
	}
	
	
	
	//Making Bunglow Image active
	function image_active_ajx(){
		$bunglow_image_id = $_POST['id']; 
		$result=$this->bunglow_model->image_active($bunglow_image_id); 
	}
	
	
	//Delete Bunglow Image
	function image_delete($language_id, $bunglow_id, $bunglow_image_id){
		$result=$this->bunglow_model->image_delete($bunglow_image_id);
		redirect('admin/bunglow/bunglow_image_list/'.$language_id.'/'.$bunglow_id);
	}
	
	
	//Delete Bunglow Image
	function image_delete_ajx(){
		$bunglow_image_id = $_POST['id']; 
		$result=$this->bunglow_model->image_delete($bunglow_image_id); 
	}
	
	
	//Adding Bunglow Image For a particular bunglow
	function bunglow_image_add($language_id, $bunglow_id){
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
			$result = $this->bunglow_model->bunglow_image_add();
			if($result == "add_success")
			{
				redirect('admin/bunglow/bunglow_image_list/'.$language_id.'/'.$bunglow_id.'?inserted');
			}
			elseif($result == "file_size")
			{
				redirect('admin/bunglow/bunglow_image_add/'.$language_id.'/'.$bunglow_id.'?size');
			}
		}
		$this->data['bunglow_name'] = $this->bunglow_model->get_bunglow_name($language_id, $bunglow_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/bunglow_image_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	
	//Editing Bunglow Image
	function bunglow_image_edit($language_id, $bunglow_id, $image_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
			$result = $this->bunglow_model->bunglow_image_edit();	
			if($result == "edit_success")
			{
				redirect('admin/bunglow/bunglow_image_list/'.$language_id.'/'.$bunglow_id.'?updated');
			}
			elseif($result == "file_size")
			{
				redirect('admin/bunglow/bunglow_image_edit/'.$language_id.'/'.$bunglow_id.'/'.$image_id.'?size');
			}
		}
		$this->data['bunglow_name'] = $this->bunglow_model->get_bunglow_name($language_id, $bunglow_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['image_arr']=$this->bunglow_model->get_images($language_id, $image_id);
        $this->data['image_unique_details']=$this->bunglow_model->get_image_unique_details($image_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/bunglow_image_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	
	
	//#################Function For Viewing Testimonials######################
	
	function view_testimonials($language_id, $bunglow_id)
	{
	    $default_language_id=$this->language_model->get_default_language_id();
		//$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data = array();
		$this->data['bunglow_name'] = $this->bunglow_model->get_bunglow_name($language_id, $bunglow_id);
		$this->data['all_rows'] = $this->bunglow_model->get_bunglow_testimonials($language_id, $bunglow_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/bunglow_testimonials', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	
	//function for adding faq
	function add_testimonials()
	{
	    $bungalow_id=$this->uri->segment(4);
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
	
		if ($this->input->post('save'))
		{
			$result = $this->bunglow_model->add_testimonials($bungalow_id);
			if($result == "add_success")
			{
				redirect('admin/bunglow/view_testimonials/'.$default_language_id.'/'.$bungalow_id);
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
	function edit_testimonials($language_id, $testimonials_id, $bunglow_id)
	{
	    $default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
			$posted_language_id=$this->input->post("language_id");
			$posted_testimonials_id=$this->input->post("testimonials_id");
			$posted_bunglow_id=$this->input->post("bunglow_id");
			$result = $this->bunglow_model->testimonials_edit();	
			if($result == "edit_success")
			{
				redirect('admin/bunglow/view_testimonials/'.$default_language_id.'/'.$posted_bunglow_id.'?updated');
			}
		}
		
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['testimonials_arr']=$this->bunglow_model->get_testimonials_admin($language_id, $testimonials_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/testimonials_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	
	
	}
	
	
	
	function delete_testimonials($language_id, $bunglow_id, $testimonial_id)
	{
		$this->bunglow_model->delete_testimonials($testimonial_id);
		redirect('admin/bunglow/view_testimonials/'.$language_id.'/'.$bunglow_id.'?deleted');
	}
	
	function ajax_testomial_status()
	{
		$test_id=$_POST['test_id'];
		$status=$_POST['status'];
		$result=$this->bunglow_model->testimonial_status_change($test_id, $status);
		echo $result;
	}
	
	function change_order()
	{
		$result=$this->bunglow_model->change_order($_POST['id'], $_POST['current_order'], $_POST['changed_order']);
	}
}

