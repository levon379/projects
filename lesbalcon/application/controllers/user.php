<?php
ob_start();
class user extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('public_init_elements');
		$this->public_init_elements->init_elements();
		$this->load->model('language_model');
		$this->load->model("users_model");
		$this->load->library('pagination');
    }
	
	
	//function for user normal login
    function login()
	{ 
		//If user is already logged in then it will automatically redirect to my profile page
		if($this->session->userdata('login_user_info'))
		{
			redirect("user/my_profile");
		}
		$this->data = array();
		if(isset($_POST['login']))
		{
			$result=$this->users_model->user_login();
			if($result=="notexist")
			{
				$this->data['error_message']=lang("Email_or_password_is_incorrect");
			}
			elseif($result=="notactive") 
			{
				$this->data['error_message']=lang("Your_account_is_not_active");
			}
			elseif($result=="success")
			{
				//If user has fulfilled reservation form and he is not logged in the after login 
				//he will be redirected to payment page
				if($this->session->userdata("reservation"))
				{
					//redirect('reservation/payment');
					
				$reservation_session=$this->session->userdata('reservation');
			    $bungalow_id=$reservation_session['bungalow_id'];	
					
					
				$selected_bungalow_person=$this->users_model->get_bungalow_max_person1($bungalow_id);
				
				 $slug=$selected_bungalow_person['slug'];
			    //print_r($selected_bungalow_person['slug']);die;
					
					//redirect('reservation/'.$slug);
					redirect('reservation/payment');
				}
				else
				{
					redirect('user/my_profile');
				}
			}
		}
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/login', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
    }
	
	//function for facebook login
	function facebook_login()
	{
		//get the Facebook appId and app secret from facebook.php which located in config directory for the creating the object for Facebook class
    	$facebook = new Facebook(array(
		'appId'		=>  $this->config->item('appID'), 
		'secret'	=> $this->config->item('appSecret'),
		));
		$user = $facebook->getUser();
		if($user)
		{
			try
			{
				$user_profile = $facebook->api('/me');  //Get the facebook user profile data
				$ses_user=array('User'=>$user_profile);
				$facebook_name=$ses_user['User']['first_name'].' '.$ses_user['User']['last_name'];
				$facebook_email=$ses_user['User']['email'];
				//Check if user exists or not if does not exist then user name and email will be go to registration page
				$check_user_existence=$this->users_model->check_facebook_user_existence($facebook_email);
				if($check_user_existence=="notexist")
				{
					$facebook_reg_details=array(
						"facebook_reg_name"=>$facebook_name,
						"facebook_reg_email"=>$facebook_email
					);
					$this->session->set_userdata("facebook_reg_details", $facebook_reg_details);
					redirect('user/registration');
				}
				elseif($check_user_existence=="exist")
				{
					redirect('user/my_profile');
				}
			}
			catch(FacebookApiException $e)
			{
				error_log($e);
				$user = NULL;
			}		
		}	
	}
	
	//function for user registration
	function registration()
	{ 
		//If user is already logged in then it will automatically redirect to user profile page
		if($this->session->userdata('login_user_info'))
		{
			redirect("user/my_profile");
		}
		$this->data = array();
		if(isset($_POST['register']))
		{
			$result=$this->users_model->set_register_data();
			if($result=="already_exist")
			{
				$this->data['error_message']="User_already_exist";
			}
			if($result=="add_success")
			{
			$result1=$this->users_model->registration_user_login();
			if($result1)
			{
			
			$reservation_session=$this->session->userdata('reservation');
			
			$bungalow_id=$reservation_session['bungalow_id'];
				
		    $selected_bungalow_person=$this->users_model->get_bungalow_max_person1($bungalow_id);
			
			$slug=$selected_bungalow_person['slug'];
			
			   $this->session->userdata('login_user_info');
				//$this->data['error_message']="You_have_been_registered_successfully";
			
				//redirect('reservation/'.$slug);
				redirect('reservation/payment');
				}
				
			}
		}
		$this->data['languages']=$this->language_model->get_rows();
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/registration', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
    }
	
	//function for forgot password
	function forgot_password()
	{ 
		//If user is already logged in then it will automatically redirect to user profile page
		if($this->session->userdata('login_user_info'))
		{
			redirect("user/my_profile");
		}
		$this->data = array();
		if($this->input->post("forgot_button"))
		{
			$result=$this->users_model->forgot_password();
			if($result=="success")
			{
				$this->data['success_message']=lang('Password_changed_successfully').' '.lang('Please_check_your_email');
			}
			if($result=="notexist")
			{
				$this->data['success_message']=lang('Email_does_not_exist');
			}
		}
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/forgot_password', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
    }
	
	
	//Function for user logout
	function logout()
	{
		$this->session->unset_userdata('login_user_info');
		$this->session->unset_userdata('login_type');
		redirect('user/login');
	}
	
	
	//#####################		Functions for User dashboard		##########################
	
	//function for my profile
	function my_profile()
	{
		$this->public_init_elements->is_user_logged_in();
		$this->data = array();
		$user_arr=$this->session->userdata("login_user_info");
		$user_id=$user_arr['user_id'];
		
		if(isset($_POST['update']))
		{
			$result=$this->users_model->update_user_data();
			if($result=="edit_success")
			{
				$this->data['error_message']="Your_profile_updated_successfully";
			}
		}

		$this->data['languages']=$this->language_model->get_rows();
		$this->data['user_details']=$this->users_model->get_rows($user_id);
		
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/my_profile', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
	}
	
	//function to change password
	function change_password()
	{
		$this->public_init_elements->is_user_logged_in();
		$this->data = array();
		if(isset($_POST['update']))
		{
			$result=$this->users_model->update_password();
			if($result=="edit_success")
			{
				$this->data['error_message']="Password_changed_successfully";
			}
			if($result=="notexist")
			{
				$this->data['error_message']="Old_Password_does_not_exist";
			}
		}
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/change_password', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
	}
	
	//Function for listing my booking
	function my_booking($offset="")
	{
		$this->public_init_elements->is_user_logged_in();
		$user_session=$this->session->userdata('login_user_info');
		$user_id=$user_session['user_id'];
		$this->data = array();
		if($offset=="")
		{
			$offset=0;
		}
		$limit=6;
		$total_records = $this->users_model->get_total_user_booking($user_id);
		$config['base_url'] = base_url().'user/my_booking';
		$config['total_rows'] = $total_records;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 3;
		$config['num_links'] = 1;
		$config['full_tag_open'] 	= '<ul class="page">';
		$config['full_tag_close'] 	= '</ul>';
		$config['cur_tag_open'] 	= '<li><a class="active">';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['prev_link'] 	 = '< ';
		$config['next_link'] 	 = ' >';
		$config['first_link'] 	 = 'First';
		$config['last_link'] 	 = 'Last';
		$this->pagination->initialize($config); 
		$this->data['pagination_link']=$this->pagination->create_links();
		$this->data['all_rows'] = $this->users_model->get_booking($user_id, $limit, $offset);
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/my_bookings', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
	}
	
	//Function to view details of booking
	function booking_details($payment_id)
	{
		$this->data = array();
		$this->data['payment_details'] = $this->users_model->get_payment_details($payment_id);
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/booking_details', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
	}
	
	
	
	//Function for listing my mails
	function my_mails($offset="")
	{ 
		$this->public_init_elements->is_user_logged_in();
		$user_session=$this->session->userdata('login_user_info');
		$user_id=$user_session['user_id'];
		$this->data = array();
		if($offset=="")
		{
			$offset=0;
		}
		$limit=6;
		$total_records = $this->users_model->get_total_user_emails($user_id);
		$config['base_url'] = base_url().'user/my_mails';
		$config['total_rows'] = $total_records;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 3;
		$config['num_links'] = 1;
		$config['full_tag_open'] 	= '<ul class="page">';
		$config['full_tag_close'] 	= '</ul>';
		$config['cur_tag_open'] 	= '<li><a class="active">';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['prev_link'] 	 = '< ';
		$config['next_link'] 	 = ' >';
		$config['first_link'] 	 = 'First';
		$config['last_link'] 	 = 'Last';
		$this->pagination->initialize($config); 
		$this->data['pagination_link']=$this->pagination->create_links();

		$this->data['my_emails']=$this->users_model->get_user_emails($user_id, $limit, $offset);
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/my_mails', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
    }
	
	
	//Function to delete email from user dashboard
	function delete_mails($email_auto_id)
	{
		$this->users_model->delete_mails($email_auto_id);
		redirect(base_url()."user/my_mails?deleted");
	}
	
}

