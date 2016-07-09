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
		$this->load->model("payment_model");
		$this->load->model("home_model");
		$this->load->model('language_model');
		$this->load->model('send_email_to_users_model');
    }

	//Function for list users page
    function list_users($user_type="")
	{ 
		if($user_type=="")
		{
			$this->data['all_rows'] = $this->users_model->get_register_user();
		}
		else 
		{
			$this->data['all_rows'] = $this->users_model->get_unregister_user();
		}
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
	
	
	//Function for listing reservations for a particular user_details 25-11-2014
	function reservation($user_id)
	{
		$this->data = array();
		$this->data['all_rows'] = $this->users_model->get_user_reservation($user_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/users_reservation_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	
	//Function to generate invoice based on reservation id
	function invoice($reservation_id)
	{
		$reservation_payment_details=$this->payment_model->get_payment_details($reservation_id);
		$user_id=$reservation_payment_details['user_id'];
		if(isset($_POST['send_invoice']))
		{
			$this->users_model->save_invoice();
			if($this->input->post('paid_amount'))
			{
				$paid_amount=$this->input->post('paid_amount');
			}
			else 
			{
				$paid_amount='';
			}
			//Setting invoice details to session
			$invoice_session=array(
				"reservation_id" 	=> $this->input->post('reservation_id'),
				"user_id" 			=> $this->input->post('user_id'),
				"invoice_number" 	=> $this->input->post('invoice_code'),
				"customer_name" 	=> $this->input->post('customer_name'),
				"reservation_date" 	=> $this->input->post('reservation_date'),
				"arrival_date" 		=> $this->input->post('arrival_date'),
				"leave_date" 		=> $this->input->post('leave_date'),
				"accommodation" 	=> $this->input->post('accommodation'),
				"bungalow_name" 	=> $this->input->post('bungalow_name'),
				"bungalow_rate" 	=> $this->input->post('bungalow_rate'),
				"options_text_for_mail" => $this->input->post('options_text_for_mail'),
				"discount" 			=> $this->input->post('discount'),
				"tax_text_for_mail" => $this->input->post('tax_text_for_mail'),
				"total" 			=> $this->input->post('total'),
				"paid_amount" 		=> $paid_amount,
				"due_amount" 		=> $this->input->post('due_amount'),
				"payment_status" 	=> $this->input->post('payment_status'),
				"reservation_status"=> $this->input->post('reservation_status'),
				"payment_mode"		=> $this->input->post('reservation_status')
			);
			$this->session->set_userdata('invoice_data', $invoice_session);
			redirect('admin/users/send_invoice');
		}
		elseif(isset($_POST['save']))
		{
			$this->users_model->save_invoice();
			redirect('admin/users/reservation/'.$user_id.'?saved');
		}
		if(isset($_POST['view_invoice']))
		{
			$this->view_invoice();
		}
		else 
		{
			$this->data['reservation_id']=$reservation_id;
			$this->data['user_id']=$user_id;
			$this->data['invoice_details']=$this->users_model->get_invoice_details($reservation_id);
			$this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
			$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
			$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
			$this->data['content'] = $this->load->view('admin/maincontents/invoice', $this->data, true);
			$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
			$this->load->view('admin/layout_home', $this->data);
		}
		
	}
	
	//Function for loading page to select template while sending invoice
	function send_invoice()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$invoice_session=$this->session->userdata("invoice_data");
		$user_id=$invoice_session['user_id'];
		$this->data = array();
		if($this->input->post('send'))
		{
			$result = $this->users_model->send_invoice_email();	
			if($result == "mailsent")
			{
				$this->session->unset_userdata("invoice_data");
				//redirect('admin/users/reservation/'.$user_id.'?mailsent');
				redirect('admin/users/invoice/'.$invoice_session['reservation_id'].'?mailsent');
			}
		}
		$this->data['users_arr'] = $this->users_model->get_user($invoice_session['user_id']);
		$this->data['template_arr']=$this->send_email_to_users_model->get_rows($default_language_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/send_invoice_to_user', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function to view invoice
	function view_invoice()
	{
		if($this->input->post('paid_amount'))
		{
			$paid_amount=$this->input->post('paid_amount');
		}
		else 
		{
			$paid_amount='';
		}
		$invoice_array=array(
			"invoice_number" 	=> $this->input->post('invoice_code'),
			"customer_name" 	=> $this->input->post('customer_name'),
			"reservation_date" 	=> $this->input->post('reservation_date'),
			"arrival_date" 		=> $this->input->post('arrival_date'),
			"leave_date" 		=> $this->input->post('leave_date'),
			"accommodation" 	=> $this->input->post('accommodation'),
			"bungalow_name" 	=> $this->input->post('bungalow_name'),
			"bungalow_rate" 	=> $this->input->post('bungalow_rate'),
			"options_text_for_mail" => $this->input->post('options_text_for_mail'),
			"discount" 			=> $this->input->post('discount'),
			"tax_text_for_mail" => $this->input->post('tax_text_for_mail'),
			"total" 			=> $this->input->post('total'),
			"paid_amount" 		=> $paid_amount,
			"due_amount" 		=> $this->input->post('due_amount'),
			"payment_status" 	=> $this->input->post('payment_status'),
			"reservation_status"=> $this->input->post('reservation_status'),
			"payment_mode"		=> $this->input->post('reservation_status')
		);
		$this->data['invoice_details']=$invoice_array;
		$this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/view_invoice', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function to generate password
	function get_new_password()
	{
		$token = "";
		$capital = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$small= "abcdefghijklmnopqrstuvwxyz";
		$numeric= "0123456789";
		for($i=0;$i<8;$i++)
		{
			$rand1=  rand(0, 8);
			$rand2=  rand(1, 3);
			if($rand2==1)
			{
				$token .= $capital{$rand1};
			}
			if($rand2==2)
			{
				$token .= $small{$rand1};
			}
			if($rand2==3)
			{
				$token .= $numeric{$rand1};
			}
		}
		echo $token;
	}
}

