<?php
ob_start();
class contacts extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('contacts_model');
		$this->load->model('language_model');
    }

	//Function for list contacts page
    function list_contacts()
	{ 
        $this->data = array();
        $this->data['error_message'] = "";
		$this->data['all_rows'] = $this->contacts_model->get_rows();
		$this->data['language_arr'] = $this->language_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/contacts_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	
	//function to delete news
	function delete($contacts_id)
	{
		$this->contacts_model->delete($contacts_id);
		redirect('admin/contacts/list_contacts?deleted');
	}
}

