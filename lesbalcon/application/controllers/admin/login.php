<?php
ob_start();
class Login extends CI_Controller
{
	function  __construct() 
	{
		parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->load->model('login_model');
	}
	function index()
	{
		$is_admin_logged_in = $this->session->userdata('is_admin_logged_in');
        if($is_admin_logged_in == TRUE)
        {
            redirect('admin/home');
        }
		$this->load->view('admin/maincontents/login');
	}
	
	//Validate Admin Login
	function validate_admin_login()
	{
		$query = $this->login_model->validate_admin_login();
		if($query)
        {
        	$record=$query->result();
			$admin_id=$record[0]->id; 
			$remember_me=$this->input->post("remember_me");
			if($remember_me==1)
			{
				$this->input->set_cookie('username_cookie', $this->input->post("user_name"), 36000);
				$this->input->set_cookie('password_cookie', $this->input->post("password"), 36000);
			}
			else
			{
				delete_cookie("username_cookie");
				delete_cookie("password_cookie");
			}
			
            // prepare session variables
            $data = Array (
                'is_admin_logged_in' => true,
                'user_name' => $this->input->post('user_name'),
                'success_message1'=>'Logged in Successfully',
                'user_id' => $admin_id
            );
            // set session variables
            $this->session->set_userdata($data);
            //send to the login page

            redirect('admin/home');
        }
        else
        {
            $this->data['error_message'] = 'Invalid login';
            $this->load->view('admin/maincontents/login', $this->data);
        }
	}
	//Function to logout user
	function logout()
	{
		//destroy user_id and user_name and user email from session array
		$this->login_model->update_logout();
		foreach (array_keys($this->session->userdata) as $key)
		{
			if($key=="admin_id" || $key=="user_type" || $key=="username" || $key=="is_admin_logged_in")
			{
				$this->session->unset_userdata($key);
			}
		}
		redirect('admin/login');
	}
	
	
	//Forgot Password
	function forgot()
	{
		$this->data = array();
		if($this->input->post('save'))
		{
			$query = $this->login_model->validate_forgot_password_form();

			if($query)
			{
				$this->data = Array ('success_message_fp'=>'New password sent to your email address');
				$this->session->set_userdata($this->data);
			}
			else
			{
				$data = Array('error_message'=>'Invalid email address');
				$this->session->set_userdata($data);
			}
		}
		$this->load->view('admin/maincontents/forgot-password', $this->data);
	}
}
?>