<?php
ob_start();
class documents extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('documents_model');
		$this->load->model('language_model');
    }

    function list_documents($lang_id)
	{ 
        $this->data = array();
		$language_id = $lang_id;
        $this->data['error_message'] = "";
		$this->data['all_rows'] = $this->documents_model->get_rows($language_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/documents_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	

	function documents_add()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();

		if ($this->input->post('save'))
		{
			$result = $this->documents_model->documents_add();
			if($result == "add_success")
			{
				redirect('admin/documents/list_documents/'.$default_language_id.'?inserted');
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
		$this->data['content'] = $this->load->view('admin/maincontents/documents_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	function documents_edit($language_id, $document_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
			$posted_language_id=$this->input->post("language_id");
			$posted_document_id=$this->input->post("document_id");
			$result = $this->documents_model->documents_edit();	
			if($result == "edit_success")
			{
				redirect('admin/documents/list_documents/'.$default_language_id.'?updated');
			}
			else
			{
				$this->data['error_register'] = $result;
			}
		}
		
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['documents_arr']=$this->documents_model->get_documents($language_id, $document_id);
        $this->data['documents_unique_details']=$this->documents_model->get_unique_details($document_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/documents_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//Function for inactivate documents
	function inactive($document_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->documents_model->inactive($document_id);
		redirect('admin/documents/list_documents/'.$default_language_id);
	}
	
	//Function for activate documents
	function active($document_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->documents_model->active($document_id);
		redirect('admin/documents/list_documents/'.$default_language_id);
	}
	
	//Function for Deleting documents
	function delete($document_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->documents_model->delete($document_id);
		redirect('admin/documents/list_documents/'.$default_language_id.'?deleted');
	}
	
	//Function for downloading documents
	function download($file_name)
	{
		$this->load->helper('download');
		$data = file_get_contents("assets/upload/documents/".$file_name);
		$name = $file_name;
		force_download($name, $data);
	}
}

