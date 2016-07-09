<?php
ob_start();
class users extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('users_model');
		$this->load->model('language_model');
    }

	//Function for list users page
    function list_users()
	{ 
		$this->data['all_rows'] = $this->users_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/users_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	//function for adding users
	function users_add()
	{
		$this->data = array();
		if ($this->input->post('save'))
		{
			$result = $this->users_model->users_add();
			if($result == "add_success")
			{
				redirect('admin/users/list_users?inserted');
			}
			if($result == "already_exist")
			{
				redirect('admin/users/users_add?exists');
			}
		}

		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/users_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function for editing users
	function users_edit($user_id)
	{
		$this->data = array();
		if ($this->input->post('save'))
		{
			$result = $this->users_model->users_edit();
			if($result == "edit_success")
			{
				redirect('admin/users/list_users?inserted');
			}
			if($result == "already_exist")
			{
				redirect('admin/users/users_edit/'.$user_id.'?exists');
			}
		}

		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['users_arr'] = $this->users_model->get_rows($user_id);
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/users_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function to close users
	function close($users_id)
	{
		$this->users_model->close($users_id);
		redirect('admin/users/list_users');
	}
	
	//function to activate users
	function active($users_id)
	{
		$this->users_model->active($users_id);
		redirect('admin/users/list_users');
	}
	
	//function to delete users
	function delete($users_id)
	{
		$this->users_model->delete($users_id);
		redirect('admin/users/list_users?deleted');
	}
	
	//function to view users details
	function users_details($users_id)
	{
		$this->data['users_details_arr'] = $this->users_model->get_rows($users_id);
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/users_details', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function to change password
	function change_password($user_id="")
	{
		if ($this->input->post('save'))
		{
			$result = $this->users_model->change_password();
			if($result == "edit_success")
			{
				redirect('admin/users/list_users?updated');
			}
		}
		//Loading All Pages Part Sequentially
		$this->data['user_details']=$this->users_model->get_user($user_id);
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/change_password_user', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
}

