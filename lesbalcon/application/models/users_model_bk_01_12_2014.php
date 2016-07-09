<?php
class users_model extends CI_Model
{
    
	//###############################################################//
	//############### INITIALIZE CONSTRUCTOR CLASS ##################//
	//###############################################################//
	
	function  __construct() 
	{
        parent::__construct();
    }
	
	//###############################################################//
	//############### INITIALIZE CONSTRUCTOR CLASS ##################//
	//###############################################################//
	
	//*******************************************ADMIN PANEL CATEGORY**********************************************************************//
	
	

	//######################ADDING USERS ACCORDING TO LANGUAGE###########################
	
	function users_add()
	{
		$language_id=$this->input->post("user_language");
		if($this->input->post("user_type"))
		{
			$user_type=$this->input->post("user_type");
		}
		else 
		{
			$user_type="N";
		}
		$name=$this->input->post("user_name");
		$email=$this->input->post("user_email");
		$password=$this->input->post("user_password");
		$contact=$this->input->post("user_contact");
		$address=$this->input->post("user_address");
		$notes=$this->input->post("user_notes");
		if(isset($_POST['more_links']))
		{
			$more_links=implode("^", $this->input->post("more_links"));
		}
		else 
		{
			$more_links="";
		}
		$check_user_arr=$this->db->get_where("lb_users", array("email"=>$email))->result_array();
		if(count($check_user_arr)>0)
		{
			return "already_exist";
		}
		else 
		{
			$admin_arr=$this->db->get_where("mast_admin_info", array('id'=>1))->result_array();
			$admin_email=$admin_arr[0]['email'];
			$insert_arr=array(
				"user_language"=>$language_id,
				"name"=>$name,
				"email"=>$email,
				"address"=>$address,
				"password"=>md5($password),
				"reg_type"=>$user_type,
				"contact_number"=>$contact,
				"notes"=>$notes,
				"status"=>"A",
				"more_links"=>$more_links,
				"creation_date"=>date("Y-m-d h:i:s")
			);
			$result=$this->db->insert("lb_users", $insert_arr);
			//Sending email to users
			$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
				
				<tr bgcolor="#222222">
				<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">'.lang('New_Registration_From_Les_Balcons_Company').'</font></b></td>
				</tr>';
			$msg_text2.='
			
			<tr>
					<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
				</tr>
			
				<tr>
				
				
				<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
					<b>'.lang('Dear').' '.$name.',</b><br>
					<b>'.lang('You_have_been_registered_successfully').'.</b><br>
					<b>'.lang('Your_details_are_as_follows').'</b>
				</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Name').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$name.'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Email: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$email.'</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Password').': </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$password.'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Contact_no').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$contact.'</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Address').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$address.'</td>
				</tr>
				<tr>
					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
					<p><b>'.lang('Regards').'</b></p>
					<p><b>La Balcons Company</b></p>
					</td>
				</tr>
				';
			$msg_text2.='</table>';
			$subject2 = lang('Registration_Successful')." (Les Balcons Company)";
			$to2 = $email;
			$this->load->library('email');
			$config['mailtype'] = "html";
			$this->email->initialize($config);	
			$this->email->clear();
			$this->email->from($admin_email, 'LES BALCONS');
			$this->email->to($to2);
			$this->email->subject($subject2);
			$this->email->message($msg_text2); 
			$this->email->send();
			
			//Send email to admin
			$msg_text3='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
				
				<tr bgcolor="#222222">
				<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">'.lang('New_Registration_From_Les_Balcons_Company').'</font></b></td>
				</tr>';
			$msg_text3.='
				<tr>
					<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
				</tr>
				<tr>
					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
						<b>'.lang('Dear').' Admin,</b><br>
						<b>'.lang('New_user_has_been_registered').'</b><br>
						<b>'.lang('His_Details_are_as_follows').'</b>
					</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Name').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$name.'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Email: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$email.'</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Password').': </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$password.'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Contact_no').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$contact.'</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Address').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$address.'</td>
				</tr>
				<tr>
					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
					<p><b>'.lang('Regards').'</b></p>
					<p><b>La Balcons Company</b></p>
					</td>
				</tr>
				';
			$msg_text3.='</table>';
			$subject3= lang('New_Registration')." (Les Balcons Company)";
			$to3 = $admin_email;
			$this->load->library('email');
			$config['mailtype'] = "html";
			$this->email->initialize($config);	
			$this->email->clear();
			$this->email->from($admin_email, 'LES BALCONS');
			$this->email->to($to3);
			$this->email->subject($subject3);
			$this->email->message($msg_text3); 
			$this->email->send();
			
			//If facebook details session which was created during registration exists then it will be unset
			if($this->session->userdata("facebook_reg_details"))
			{
				$this->session->unset_userdata("facebook_reg_details");
			}
			
			return "add_success";
		}
	}
		
	
	//###################################################################################
	
	
	//Getting All users At Once
	function get_rows($user_id="")//Get all rows for listing page
    {
		if($user_id=="")
		{
			$this->db->order_by("id", "asc");
			$result = $this->db->get("lb_users")->result_array();
		}
		else 
		{
			$result = $this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		}
		for($i=0; $i<count($result); $i++)
		{
			$language_id=$result[$i]['user_language'];
			$language_details=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
			$result[$i]['user_language_name']=$language_details[0]['language_name'];
		}
        return $result;
    }
	
	
	//function to close users
	function close($users_id)
	{
		$this->db->update("lb_users", array("status"=>"C"), array("id"=>$users_id));
	}
	//function to activate users
	function active($users_id)
	{
		$this->db->update("lb_users", array("status"=>"A"), array("id"=>$users_id));
	}
	//function to delete users
	function delete($users_id)
	{
		$this->db->delete("lb_users", array("id"=>$users_id));
	}
	
	
	function users_edit()
	{
		$user_id=$this->input->post("user_id");
		$language_id=$this->input->post("user_language");
		$name=$this->input->post("user_name");
		$email=$this->input->post("user_email");
		$contact=$this->input->post("user_contact");
		$address=$this->input->post("user_address");
		$notes=$this->input->post("user_notes");
		if(isset($_POST['more_links']))
		{
			$more_links=implode("^", $this->input->post("more_links"));
		}
		else 
		{
			$more_links="";
		}
		$update_arr=array(
			"user_language"=>$language_id,
			"name"=>$name,
			"email"=>$email,
			"address"=>$address,
			"contact_number"=>$contact,
			"notes"=>$notes,
			"more_links"=>$more_links,
			"modified_date"=>date("Y-m-d h:i:s")
		);
		$result=$this->db->update("lb_users", $update_arr, array("id"=>$user_id));
		return "edit_success";
	}
	
	//Function to change password of users from admin
	function change_password()
	{
		$admin_arr=$this->db->get_where("mast_admin_info", array('id'=>1))->result_array();
		$admin_email=$admin_arr[0]['email'];
		$user_email=$this->input->post("email_address");
		$password=$this->input->post("new_password");
		$user_details=$this->db->get_where("lb_users", array("email"=>$user_email))->result_array();
		if(count($user_details)>0)
		{
			$result=$this->db->update("lb_users", array("password"=>md5($password)), array("email"=>$user_email));
			if($result)
			{
				$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
				<tr bgcolor="#222222">
				<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">Password Change Notification @ Les Balcons</font></b></td>
				</tr>';
				$msg_text2.='
				<tr>
					<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
						<b>Dear'.$user_details[0]['name'].',<br>
						Your password has been changed.<br>
						Your new password is '.$password.'</b>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
					<p><b>Regards</b></p>
					<p><b>La Balcons Company</b></p>
					</td>
				</tr>
				</table>';
				
				$subject2 = "Password Changed Notification @ Les Balcons";
				$to2 = $user_email;
				$this->load->library('email');
				$config['mailtype'] = "html";
				$this->email->initialize($config);	
				$this->email->clear();
				$this->email->from($admin_email, 'LES BALCONS');
				$this->email->to($to2);
				$this->email->subject($subject2);
				$this->email->message($msg_text2); 
				$this->email->send();
				return "edit_success";
			}
		}
		else 
		{
			return "notexist";
		}
	}
	
	//function for get particular user
	function get_user($user_id)
	{
		$result=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		return $result;
	}
	
	//#######################function for front end regisration#####################
	
	//Function for set user data
	function set_register_data()
	{
		$result=$this->users_add();
		return $result;
	}
	
	//Function for front end user login
	function user_login()
	{
		$user_email=$this->input->post("login_email");
		$user_password=$this->input->post("login_password");
		$result=$this->db->get_where("lb_users", array("email"=>$user_email, "password"=>md5($user_password)))->result_array();
		if(count($result)>0)
		{
			if($result[0]['status']=="A")
			{
				$login_user_info = array(
				  'user_id'   			=> $result[0]['id'],
				  'user_type'  			=> 'N',
				  'full_name'  		  	=> $result[0]['name'],
				  'is_user_logged_in' 	=> TRUE
				); 
                $this->session->set_userdata('login_user_info',$login_user_info);	
				$this->session->set_userdata('login_type', 'N');
				return "success";
			}
			if($result[0]['status']=="C")
			{
				return "notactive";
			}
		}
		else 
		{
			return "notexist";
		}
	}
	
	
	//Function to check user existence while facebook login
	function check_facebook_user_existence($email)
	{
		$result=$this->db->get_where("lb_users", array("email"=>$email))->result_array();
		if(count($result)>0)
		{
			$login_user_info = array(
			  'user_id'   			=> $result[0]['id'],
			  'user_type'  			=> 'F',
			  'full_name'  		  	=> $result[0]['name'],
			  'is_user_logged_in' 	=> TRUE
			); 
			$this->session->set_userdata('login_user_info',$login_user_info);	
			$this->session->set_userdata('login_type', 'F');
			return "exist";
		}
		else 
		{
			return "notexist";
		}
	}
	
	
	//function to forgot password from front end
	function forgot_password()
	{
		$admin_arr=$this->db->get_where("mast_admin_info", array('id'=>1))->result_array();
		$admin_email=$admin_arr[0]['email'];
		$user_email=$this->input->post("forgot_email");
		$allowed_chars = 'abcdefghijklmnopqrstuvwxz1234567890';
		$allowed_count = strlen($allowed_chars);
		$password = null;
		$password_length = 8;
		$password = '';
		for($i = 0; $i < $password_length; ++$i) 
		{
			$password .= $allowed_chars{mt_rand(0, $allowed_count - 1)};
		}
		if($this->input->post("mail_submit")=="true")//If conditions for spam checking
		{
			if($this->input->post("middle_name")=="")
			{
				if($this->input->post("check_val")==200)
				{
					$user_details=$this->db->get_where("lb_users", array("email"=>$user_email))->result_array();
					if(count($user_details)>0)
					{
						$result=$this->db->update("lb_users", array("password"=>md5($password)), array("email"=>$user_email));
						if($result)
						{
							$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
							<tr bgcolor="#222222">
							<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">'.lang('Password_Change_Notification').' @ Les Balcons</font></b></td>
							</tr>';
							$msg_text2.='
							<tr>
								<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
							</tr>
							<tr bgcolor="#f5e8c8">
								<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
									<b>'.lang('Dear').' '.$user_details[0]['name'].',<br>
									'.lang('Your_password_has_been_changed').'.<br>
									'.lang('Your_new_password_is').': '.$password.'</b>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
								<p><b>'.lang('Regards').'</b></p>
								<p><b>La Balcons Company</b></p>
								</td>
							</tr>
							</table>';
							$subject2 = lang('Password_Change_Notification')." @ Les Balcons";
							$to2 = $user_email;
							$this->load->library('email');
							$config['mailtype'] = "html";
							$this->email->initialize($config);	
							$this->email->clear();
							$this->email->from($admin_email, 'LES BALCONS');
							$this->email->to($to2);
							$this->email->subject($subject2);
							$this->email->message($msg_text2); 
							$this->email->send();
							return "success";
						}
					}
					else 
					{
						return "notexist";
					}
				}
			}
		}
	}
	
	//function to update user details
	function update_user_data()
	{
		$user_arr=$this->session->userdata("login_user_info");
		$user_id=$user_arr['user_id'];
		$upd_arr=array(
			"user_language"=>$this->input->post("user_language"),
			"name"=>$this->input->post("user_name"),
			"address"=>$this->input->post("user_address"),
			"contact_number"=>$this->input->post("user_contact"),
			"notes"=>$this->input->post("user_notes"),
			"modified_date"=>date("Y-m-d h:i:s")
		);
		$this->db->update("lb_users", $upd_arr, array("id"=>$user_id));
		return "edit_success";
	}
	
	//Function to update password
	function update_password()
	{
		$user_arr=$this->session->userdata("login_user_info");
		$user_id=$user_arr['user_id'];
		$user_details=$this->get_rows($user_id);
		$current_password=$user_details[0]['password'];
		if($current_password==md5($this->input->post("old_password")))
		{
			$this->db->update("lb_users", array("password"=>md5($this->input->post("new_password"))), array("id"=>$user_id));
			return "edit_success";
		}
		else 
		{
			return "notexist";
		}
	}
	
	//Function to get user emails for user dashboard
	function get_user_emails($user_id, $limit, $offset)
	{
		$this->db->order_by("id", "desc");
		$result=$this->db->get_where("lb_sent_mails", array("user_id"=>$user_id), $limit, $offset)->result_array();
		return $result;
	}
	
	//Function to get total user emails for pagination
	function get_total_user_emails($user_id)
	{
		$this->db->order_by("id", "desc");
		$result=$this->db->get_where("lb_sent_mails", array("user_id"=>$user_id))->result_array();
		return count($result);
	}
	
	//Function to delete email from user dashboard
	function delete_mails($email_auto_id)
	{
		$this->db->delete("lb_sent_mails", array("id"=>$email_auto_id));
	}
	
	//Function to get total user booking
	function get_total_user_booking($user_id)
	{
		$this->db->order_by("id", "desc");
		$result=$this->db->get_where("lb_reservation", array("user_id"=>$user_id))->result_array();
		return count($result);
	}
	
	//Function to get all bookings of particular user
	function get_booking($user_id, $limit, $offset)
	{
		$booking_arr=array();
		$current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->order_by("id", "desc");
		$result=$this->db->get_where("lb_reservation", array("user_id"=>$user_id), $limit, $offset)->result_array();
		$i=0;
		foreach($result as $row)
		{
			$bungalow_id=$row['bunglow_id'];
			$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>$current_lang_id))->result_array();
			$booking_arr[$i]['id']=$row['id'];
			$booking_arr[$i]['reservation_date']=$row['reservation_date'];
			$booking_arr[$i]['bunglow_name']=$bungalow_details[0]['bunglow_name'];
			$booking_arr[$i]['arrival_date']=$row['arrival_date'];
			$booking_arr[$i]['leave_date']=$row['leave_date'];
			$booking_arr[$i]['reservation_status']=$row['reservation_status'];
			$booking_arr[$i]['payment_status']=$row['payment_status'];
			$booking_arr[$i]['is_active']=$row['is_active'];
			$i++;
		}
		return $booking_arr;
	}
	
	//Function to get payment details
	function get_payment_details($payment_id)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		
		$default_currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		$default_currency=$default_currency_arr[0]['currency_symbol'];
		
		$payment_details_arr=array();
		$payment_details=$this->db->get_where("lb_reservation", array("id"=>$payment_id))->result_array();
		
		$user_id=$payment_details[0]['user_id'];
		$user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		
		$bungalow_id=$payment_details[0]['bunglow_id'];
		$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>$current_lang_id))->result_array();
		
		
		//Getting bungalow rates
		$accommodation=ceil(abs(strtotime($payment_details[0]['leave_date']) - strtotime($payment_details[0]['arrival_date'])) / 86400);
		$bungalow_rate=$payment_details[0]['bunglow_per_day']*$accommodation;
		
		
		//Getting options rates
		$total_options_rate_arr=array();
		$options_ids=$payment_details[0]['options_id'];
		if($options_ids!="")
		{
			$options_id_arr=explode(",", $options_ids);
			$x=0;
			$options_rate_arr=explode(",", $payment_details[0]['options_rate']);
			foreach($options_id_arr as $options)
			{
				$options_details=$this->db->get_where("lb_bunglow_options_lang", array("options_id"=>$options, "language_id"=>$current_lang_id))->result_array();
				$total_options_rate_arr[$x]['option_name']=$options_details[0]['options_name'];
				$total_options_rate_arr[$x]['option_rate']=$default_currency.$options_rate_arr[$x];
				$x++;
			}
		}
	
		
		//Getting tax rates
		$total_tax_rate_arr=array();
		$tax_ids=$payment_details[0]['tax_id'];
		if($tax_ids!="")
		{
			$tax_id_arr=explode(",", $tax_ids);
			$x=0;
			$tax_rate_arr=explode(",", $payment_details[0]['tax_rate']);
			foreach($tax_id_arr as $tax_id)
			{
				$tax_value=$bungalow_rate*$tax_rate_arr[$x]/100;
				$tax_details=$this->db->get_where("lb_tax_lang", array("tax_id"=>$tax_id, "language_id"=>$current_lang_id))->result_array();
				$total_tax_rate_arr[$x]['tax_name']=$tax_details[0]['tax_name']." (".$tax_rate_arr[$x]."%)";
				$total_tax_rate_arr[$x]['tax_rate']=$default_currency.$tax_value;
				$x++;
			}
		}
		
		
		
		
		$payment_details_arr['reservation_date']=$payment_details[0]['reservation_date'];
		$payment_details_arr['user_name']=$user_details[0]['name'];
		$payment_details_arr['user_email']=$user_details[0]['email'];
		$payment_details_arr['bunglow_under_booking']=$payment_details[0]['name'];
		$payment_details_arr['more_phone']=$payment_details[0]['phone'];
		$payment_details_arr['more_email']=$payment_details[0]['email'];
		$payment_details_arr['arrival_date']=$payment_details[0]['arrival_date'];
		$payment_details_arr['leave_date']=$payment_details[0]['leave_date'];
		$payment_details_arr['accommodation']=ceil(abs(strtotime($payment_details[0]['leave_date']) - strtotime($payment_details[0]['arrival_date'])) / 86400);
		$payment_details_arr['bungalow_name']=$bungalow_details[0]['bunglow_name'];
		$payment_details_arr['bungalow_rate']=$default_currency.$bungalow_rate;
		$payment_details_arr['options_rate']=$total_options_rate_arr;
		$payment_details_arr['discount']=$payment_details[0]['discount'];
		$payment_details_arr['tax_rate']=$total_tax_rate_arr;
		$payment_details_arr['total']=$default_currency.$payment_details[0]['amount_to_be_paid'];
		$payment_details_arr['paid_amount']=$default_currency.$payment_details[0]['paid_amount'];
		$payment_details_arr['due_amount']=$default_currency.$payment_details[0]['due_amount'];
		$payment_details_arr['payment_mode']=$payment_details[0]['payment_mode'];
		$payment_details_arr['invoice_number']=$payment_details[0]['invoice_number'];
		$payment_details_arr['payment_status']=$payment_details[0]['payment_status'];
		$payment_details_arr['reservation_status']=$payment_details[0]['reservation_status'];

		//echo "<pre>";
		//print_r($payment_details_arr);
		//die;
		return $payment_details_arr;
	}
	
}
?>