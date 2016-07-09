<?php
ob_start();
class admin_setting extends CI_Controller
{
    var $data;
    function  __construct() 
	{
        parent::__construct();
        $this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
 		$this->load->model('admin_setting_model');
    }

	//function to load admin setting page
    function index()
	{ 
		$this->data = array();
		$this->data['success_message'] = '';
		$this->data['error_message'] = '';
		$msg = '';
		$msg = $this->uri->segment(4);
		if($msg=='update')
		{
			$this->data['success_message'] = "Site settings updated successfully";
		}
		$edit_id = 1;
		$this->data['edit_id'] = $edit_id;
		
		if($this->input->post('save'))
		{
			if ($this->admin_setting_model->validate_data() == TRUE)
			{
				$this->admin_setting_model->update_data($edit_id);
				redirect('admin/admin_setting/index/update');
			}
			 else
			{
				$this->data['error_message'] = validation_errors();
			}
		}
		
		$this->data['row'] = $this->admin_setting_model->get_row(1);
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		//Loading Main Content Page
		$this->data['content'] = $this->load->view('admin/maincontents/admin_setting_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
        $this->load->view('admin/layout_home', $this->data);
		
    }
}
?>
