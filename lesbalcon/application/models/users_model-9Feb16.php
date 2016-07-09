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
		$check_user_arr=$this->db->get_where("lb_users", array("email"=>$email, "user_type"=>"R"))->result_array();
		if(count($check_user_arr)>0)
		{
			return "already_exist";
		}
		else 
		{
			$admin_arr=$this->db->get_where("mast_admin_info", array('id'=>1))->result_array();
			$admin_email=$admin_arr[0]['email'];
			$check_user_arr1=$this->db->get_where("lb_users", array("email"=>$email, "user_type"=>"U"))->result_array();
			if(count($check_user_arr1)>0)
			{
				$update_arr=array(
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
					"user_type"=>"R"
				);
				$result=$this->db->update("lb_users", $update_arr, array("email"=>$email));
			}
			else 
			{
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
					"creation_date"=>date("Y-m-d H:i:s"),
					"user_type"=>"R"
				);
				$result=$this->db->insert("lb_users", $insert_arr);
			}
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
			$to3 = $admin_email.",j.willemin@caribwebservices.com";
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
	//Getting registered user
	function get_register_user()
	{
		$this->db->order_by("id", "asc");
		$result = $this->db->get_where("lb_users", array("user_type"=>"R"))->result_array();
		for($i=0; $i<count($result); $i++)
		{
			$language_id=$result[$i]['user_language'];
			$language_details=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
			$result[$i]['user_language_name']=$language_details[0]['language_name'];
		}
		return $result;
	}
	//Getting unregistered user
	function get_unregister_user()
	{
		$this->db->order_by("id", "asc");
		$result = $this->db->get_where("lb_users", array("user_type"=>"U"))->result_array();
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
			"modified_date"=>date("Y-m-d H:i:s")
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
	
	
	//function for getting reservation list for particular user 25-11-2014
	function get_user_reservation($user_id)
	{
		$this->db->order_by('id', 'desc');
		$result=$this->db->get_where("lb_reservation", array("user_id"=>$user_id))->result_array();
		$default_language=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		$default_language_id=$default_language[0]['id'];
		$payment_arr=array();
		$i=0;
		foreach($result as $row)
		{
			$bungalow_id=$row['bunglow_id'];
			$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>$default_language_id))->result_array();
			$payment_arr[$i]['id']=$row['id'];
			$payment_arr[$i]['reservation_date']=$row['reservation_date'];
			$payment_arr[$i]['bunglow_name']=$bungalow_details[0]['bunglow_name'];
			$payment_arr[$i]['arrival_date']=$row['arrival_date'];
			$payment_arr[$i]['leave_date']=$row['leave_date'];
			$payment_arr[$i]['reservation_status']=$row['reservation_status'];
			$payment_arr[$i]['payment_status']=$row['payment_status'];
			$payment_arr[$i]['is_active']=$row['is_active'];
			$i++;
		}
		return $payment_arr;
	}
	

	//Function to get invoice details 
	function get_invoice_details($reservation_id)
	{
		$invoice_arr=array();//array for storing euro invoice array and dollar invoice array
		$details_in_euro=array(); //array for storing invoice details for sending invoice in euro
		$details_in_dollar=array(); //array for storing invoice details for sending invoice in dollar
		$invoice_details=$this->db->get_where("lb_invoice", array("reservation_id"=>$reservation_id))->result_array();
		$payment_details=$this->db->get_where("lb_reservation", array("id"=>$reservation_id))->result_array();
		if(count($invoice_details)==0) //If invoice is not available
		{
			//Storing details for euro currency			

			$user_id=$payment_details[0]['user_id'];
			$user_details=$this->get_user($user_id);
			$default_language_id=$user_details[0]['user_language'];//user belongs to which language
			$bungalow_id=$payment_details[0]['bunglow_id'];
			$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>$default_language_id))->result_array();
			
			$euro_currency_arr=$this->db->get_where("lb_currency_master", array("currency_id"=>"2"))->result_array();
			$euro_currency=$euro_currency_arr[0]['currency_symbol'];
			
			//Getting bungalow rates
			$accommodation=ceil(abs(strtotime($payment_details[0]['leave_date']) - strtotime($payment_details[0]['arrival_date'])) / 86400);
			//$bungalow_rate=ceil($payment_details[0]['amount_to_be_paid'] - ($payment_details[0]['amount_to_be_paid'] * 4/100));		
			
			$q_val = explode("-",$payment_details[0]['arrival_date']);		 
			$season_id = $this->getSeasons($q_val[2],$q_val[1],$q_val[0]);

			$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>$season_id))->result_array();
			if( $accommodation > 6 ){
				$stay_euro = $bungalow_rate = $accommodation * $rate_details_arr[0]['extranight_perday_europrice'];
			}else {
				$stay_euro = $bungalow_rate = $rate_details_arr[0]['rate_per_day_euro'] * $accommodation;
			}
			$tot =0;
			$val2 = $payment_details[0]['no_of_extra_real_adult'];
			$val3 = $payment_details[0]['no_of_extra_adult'];
			$val6 = $payment_details[0]['no_of_folding_bed_adult'];
			if($val2 > 0) $tot = ($val2 * 15 * $accommodation);
			if($val3 > 0) $tot += ($val3 * 15 * $accommodation);
			if($val6 > 0) $tot += ($val6 * 15 * $accommodation);
			$extra_person = $tot;
			$tot = ($bungalow_rate + $tot);
			$total_tax_value = ($tot * 4/100);

			$amount_without_tax = ($bungalow_rate + $extra_person);


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
					$options_details=$this->db->get_where("lb_bunglow_options_lang", array("options_id"=>$options, "language_id"=>$default_language_id))->result_array();
					$total_options_rate_arr[$x]['option_name']=$options_details[0]['options_name'];
					$total_options_rate_arr[$x]['options_rate']=$euro_currency.$options_rate_arr[$x];
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
					$tax_details=$this->db->get_where("lb_tax_lang", array("tax_id"=>$tax_id, "language_id"=>$default_language_id))->result_array();
					$total_tax_rate_arr[$x]['tax_name']=$tax_details[0]['tax_name']." (".$tax_rate_arr[$x]."%)";
					$total_tax_rate_arr[$x]['tax_rate']=$euro_currency.$tax_value;
					$x++;
				}
			}
			$reservation_date	=date("d/m/Y H:i:s", strtotime($payment_details[0]['reservation_date']));
			$user_name			=$user_details[0]['name'];
			$user_email			=$user_details[0]['email'];
			$bunglow_under_booking=$payment_details[0]['name'];
			$more_phone			=$payment_details[0]['phone'];
			$more_email			=$payment_details[0]['email'];
			$arrival_date_arr	=explode("-",$payment_details[0]['arrival_date']);
			$arrival_date		=$arrival_date_arr[2]."/".$arrival_date_arr[1]."/".$arrival_date_arr[0];
			$leave_date_arr		=explode("-",$payment_details[0]['leave_date']);
			$leave_date			=$leave_date_arr[2]."/".$leave_date_arr[1]."/".$leave_date_arr[0];
			$accommodation		=ceil(abs(strtotime($payment_details[0]['leave_date']) - strtotime($payment_details[0]['arrival_date'])) / 86400);
			$bungalow_name		=$bungalow_details[0]['bunglow_name'];
			$bungalow_rate		=$euro_currency.$bungalow_rate;
			$options_rate		=$total_options_rate_arr;
			$discount			=$payment_details[0]['discount'];
			$tax_rate			=$total_tax_rate_arr;
			$total				=$euro_currency.$payment_details[0]['amount_to_be_paid'];
			$paid_amount		=$euro_currency.$payment_details[0]['paid_amount'];
			$due_amount			=$euro_currency.$payment_details[0]['due_amount'];
			$payment_mode		=$payment_details[0]['payment_mode'];
			$date_payment_mode	=$payment_details[0]['date_payment_mode'];
			$invoice_number		=$payment_details[0]['invoice_number'];
			$payment_status		=$payment_details[0]['payment_status'];
			$reservation_status	=$payment_details[0]['reservation_status'];
			$comments     		=$payment_details[0]['comments'];
			$no_of_adult 		=$payment_details[0]['no_of_adult'];
			$no_of_extra_real_adult=$payment_details[0]['no_of_extra_real_adult'];
			$no_of_extra_adult  =$payment_details[0]['no_of_extra_adult'];
			$no_of_extra_kid    =$payment_details[0]['no_of_extra_kid'];
			$no_of_folding_bed_kid=$payment_details[0]['no_of_folding_bed_kid'];
			$no_of_folding_bed_adult=$payment_details[0]['no_of_folding_bed_adult'];
			$no_of_baby_bed    =$payment_details[0]['no_of_baby_bed'];


			$options_text_for_mail="";
			if(count($options_rate)>0)
			{
				foreach($options_rate as $options) 
				{
					$options_text_for_mail .=$options['option_name'].": ".$options['options_rate']."&nbsp;&nbsp;";
				}
			}
			else 
			{
				$options_text_for_mail="N/A";
			}
			
			$tax_text_for_mail="";
			if(count($tax_rate)>0)
			{
				foreach($tax_rate as $tax) 
				{
					$tax_text_for_mail .=$tax['tax_name'].": ".$tax['tax_rate']."&nbsp;&nbsp;";
				}
			}
			else 
			{
				$tax_text_for_mail="N/A";
			}
			
			$details_in_euro=array(
				'reservation_date'	=>$invoice_details[0]['reservation_date'],
				'bunglow_under_booking'=>$invoice_details[0]['customer_name'],
				'arrival_date'		=>$payment_details[0]['arrival_date'],
				'leave_date'		=>$payment_details[0]['leave_date'],
				'accommodation'		=>$invoice_details[0]['accommodation'],
				'bungalow_name'		=>$invoice_details[0]['bungalow_name'],
				'bungalow_rate'		=>$invoice_details[0]['total_bungalow_rate_dollar'],
				'options_text_for_mail'=>$invoice_details[0]['options_dollar'],
				'discount'			=>$payment_details[0]['discount'],
				'tax_text_for_mail' =>$invoice_details[0]['tax_dollar'],
				'total'				=>$payment_details[0]['amount_to_be_paid'],
				'due_amount'		=>$payment_details[0]['payment_details'],
				'payment_mode'		=>$invoice_details[0]['payment_mode'],
				'date_payment_mode'		=>$invoice_details[0]['date_payment_mode'],
				'invoice_number'	=>$invoice_details[0]['invoice_code'],
				'payment_status'	=>$payment_details[0]['payment_status'],
				'reservation_status'=>$payment_details[0]['reservation_status'],
				'send_status'		=>$invoice_details[0]['send_status'],
				'comments'			=>$payment_details[0]['comments'],
				"no_of_adult" => $payment_details[0]['no_of_adult'],
				"no_of_extra_adult" => $payment_details[0]['no_of_extra_adult'],
				"no_of_extra_real_adult" => $payment_details[0]['no_of_extra_real_adult'],
				"no_of_extra_kid" => $payment_details[0]['no_of_extra_kid'],
				"no_of_folding_bed_kid" => $payment_details[0]['no_of_folding_bed_kid'],
				"no_of_folding_bed_adult" => $payment_details[0]['no_of_folding_bed_adult'],
				"no_of_baby_bed" => $payment_details[0]['no_of_baby_bed']
			);
			
			
			//##################################//
			//Storing details for dollar currency
			$dollar_currency_arr=$this->db->get_where("lb_currency_master", array("currency_id"=>"1"))->result_array();
			$dollar_currency=$dollar_currency_arr[0]['currency_symbol'];
			//Getting bungalow rates
			$accommodation=ceil(abs(strtotime($payment_details[0]['leave_date']) - strtotime($payment_details[0]['arrival_date'])) / 86400);
			$bungalow_rate=$payment_details[0]['bunglow_per_day_dollar']*$accommodation;
			
			//Getting options rates
			$total_options_rate=0;
			$total_options_rate_arr=array();
			$options_ids=$payment_details[0]['options_id'];
			if($options_ids!="")
			{
				$options_id_arr=explode(",", $options_ids);
				$x=0;
				$options_rate_arr=explode(",", $payment_details[0]['options_rate_dollar']);
				foreach($options_id_arr as $options)
				{
					$options_details=$this->db->get_where("lb_bunglow_options_lang", array("options_id"=>$options, "language_id"=>$default_language_id))->result_array();
					$total_options_rate_arr[$x]['option_name']=$options_details[0]['options_name'];
					$total_options_rate_arr[$x]['options_rate_dollar']=$dollar_currency.$options_rate_arr[$x];
					$total_options_rate=$total_options_rate+$options_rate_arr[$x];
					$x++;
				}
			}
			

			//Getting tax rates
			$total_tax_rate=0;
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
					$tax_details=$this->db->get_where("lb_tax_lang", array("tax_id"=>$tax_id, "language_id"=>$default_language_id))->result_array();
					$total_tax_rate_arr[$x]['tax_name']=$tax_details[0]['tax_name']." (".$tax_rate_arr[$x]."%)";
					$total_tax_rate_arr[$x]['tax_rate']=$dollar_currency.$tax_value;
					$total_tax_rate=$total_tax_rate+$tax_value;
					$x++;
				}
			}
			
			$total_with_options=$bungalow_rate+$total_options_rate;
			$total_with_discount=$total_with_options-($total_with_options*$payment_details[0]['discount']/100);
			$final_amount_with_tax=$total_with_discount+$total_tax_rate;
			
			$reservation_date	=date("d/m/Y H:i:s", strtotime($payment_details[0]['reservation_date']));
			$user_name			=$user_details[0]['name'];
			$user_email			=$user_details[0]['email'];
			$bunglow_under_booking=$payment_details[0]['name'];
			$more_phone			=$payment_details[0]['phone'];
			$more_email			=$payment_details[0]['email'];
			$arrival_date_arr	=explode("-",$payment_details[0]['arrival_date']);
			$arrival_date		=$arrival_date_arr[2]."/".$arrival_date_arr[1]."/".$arrival_date_arr[0];
			$leave_date_arr		=explode("-",$payment_details[0]['leave_date']);
			$leave_date			=$leave_date_arr[2]."/".$leave_date_arr[1]."/".$leave_date_arr[0];
			$accommodation		=ceil(abs(strtotime($payment_details[0]['leave_date']) - strtotime($payment_details[0]['arrival_date'])) / 86400);
			$bungalow_name		=$bungalow_details[0]['bunglow_name'];
			$bungalow_rate		=$dollar_currency.$bungalow_rate;
			$options_rate		=$total_options_rate_arr;
			$discount			=$payment_details[0]['discount'];
			$tax_rate			=$total_tax_rate_arr;
			$total				=$dollar_currency.$final_amount_with_tax;
			$due_amount			=$dollar_currency.$final_amount_with_tax;
			$payment_mode		=$payment_details[0]['payment_mode'];			
			$date_payment_mode		=$payment_details[0]['date_payment_mode'];
			$invoice_number		=$payment_details[0]['invoice_number'];
			$payment_status		=$payment_details[0]['payment_status'];
			$reservation_status	=$payment_details[0]['reservation_status'];

			$no_of_adult 		=$payment_details[0]['no_of_adult'];
			$no_of_extra_real_adult=$payment_details[0]['no_of_extra_real_adult'];
			$no_of_extra_adult  =$payment_details[0]['no_of_extra_adult'];
			$no_of_extra_kid    =$payment_details[0]['no_of_extra_kid'];
			$no_of_folding_bed_kid=$payment_details[0]['no_of_folding_bed_kid'];
			$no_of_folding_bed_adult=$payment_details[0]['no_of_folding_bed_adult'];
			$no_of_baby_bed    =$payment_details[0]['no_of_baby_bed'];
			
			$options_text_for_mail="";
			if(count($options_rate)>0)
			{
				foreach($options_rate as $options) 
				{
					$options_text_for_mail .=$options['option_name'].": ".$options['options_rate_dollar']." ";
				}
			}
			else 
			{
				$options_text_for_mail="N/A";
			}
			
			$tax_text_for_mail="";
			if(count($tax_rate)>0)
			{
				foreach($tax_rate as $tax) 
				{
					$tax_text_for_mail .=$tax['tax_name'].": ".$tax['tax_rate']." ";
				}
			}
			else 
			{
				$tax_text_for_mail="N/A";
			}
			
			$details_in_dollar=array(
				'reservation_date'	=>$reservation_date,
				'user_name'			=>$user_name,
				'user_email'		=>$user_email,
				'bunglow_under_booking'=>$bunglow_under_booking,
				'more_phone'		=>$more_phone,
				'more_email'		=>$more_email,
				'arrival_date'		=>$arrival_date,
				'leave_date'		=>$leave_date,
				'accommodation'		=>$accommodation,
				'bungalow_name'		=>$bungalow_name,
				'bungalow_rate'		=>$bungalow_rate,
				'options_text_for_mail'=>$options_text_for_mail,
				'discount'			=>$discount,
				'tax_text_for_mail' =>$tax_text_for_mail,
				'total'				=>$total,
				'due_amount'		=>$due_amount,
				'payment_mode'		=>$payment_mode,
				'date_payment_mode'		=>$date_payment_mode,
				'invoice_number'	=>$invoice_number,
				'payment_status'	=>$payment_status,
				'reservation_status'=>$reservation_status,
				'send_status'		=>"N",
				'comments'			=>$comments
			);
		}
		else 
		{
			$details_in_euro=array(
				'reservation_date'	=>$invoice_details[0]['reservation_date'],
				'bunglow_under_booking'=>$invoice_details[0]['customer_name'],
				'arrival_date'		=>$payment_details[0]['arrival_date'],
				'leave_date'		=>$payment_details[0]['leave_date'],
				'accommodation'		=>$invoice_details[0]['accommodation'],
				'bungalow_name'		=>$invoice_details[0]['bungalow_name'],
				'bungalow_rate'		=>$invoice_details[0]['total_bungalow_rate_dollar'],
				'options_text_for_mail'=>$invoice_details[0]['options_dollar'],
				'discount'			=>$payment_details[0]['discount'],
				'tax_text_for_mail' =>$invoice_details[0]['tax_dollar'],
				'total'				=>$payment_details[0]['amount_to_be_paid'],
				'due_amount'		=>$payment_details[0]['payment_details'],
				'payment_mode'		=>$invoice_details[0]['payment_mode'],
				'date_payment_mode'		=>$invoice_details[0]['date_payment_mode'],
				'invoice_number'	=>$invoice_details[0]['invoice_code'],
				'payment_status'	=>$payment_details[0]['payment_status'],
				'reservation_status'=>$payment_details[0]['reservation_status'],
				'send_status'		=>$invoice_details[0]['send_status'],
				'comments'			=>$payment_details[0]['comments'],
				"no_of_adult" => $payment_details[0]['no_of_adult'],
				"no_of_extra_adult" => $payment_details[0]['no_of_extra_adult'],
				"no_of_extra_real_adult" => $payment_details[0]['no_of_extra_real_adult'],
				"no_of_extra_kid" => $payment_details[0]['no_of_extra_kid'],
				"no_of_folding_bed_kid" => $payment_details[0]['no_of_folding_bed_kid'],
				"no_of_folding_bed_adult" => $payment_details[0]['no_of_folding_bed_adult'],
				"no_of_baby_bed" => $payment_details[0]['no_of_baby_bed']
				
			);
			
			$details_in_dollar=array(
				'reservation_date'	=>$invoice_details[0]['reservation_date'],
				'bunglow_under_booking'=>$invoice_details[0]['customer_name'],
				'arrival_date'		=>$payment_details[0]['arrival_date'],
				'leave_date'		=>$payment_details[0]['leave_date'],
				'accommodation'		=>$invoice_details[0]['accommodation'],
				'bungalow_name'		=>$invoice_details[0]['bungalow_name'],
				'bungalow_rate'		=>$invoice_details[0]['total_bungalow_rate_dollar'],
				'options_text_for_mail'=>$invoice_details[0]['options_dollar'],
				'discount'			=>$payment_details[0]['discount'],
				'tax_text_for_mail' =>$invoice_details[0]['tax_dollar'],
				'total'				=>$payment_details[0]['amount_to_be_paid'],
				'due_amount'		=>$payment_details[0]['payment_details'],
				'payment_mode'		=>$invoice_details[0]['payment_mode'],
				'date_payment_mode'		=>$invoice_details[0]['date_payment_mode'],
				'invoice_number'	=>$invoice_details[0]['invoice_code'],
				'payment_status'	=>$payment_details[0]['payment_status'],
				'reservation_status'=>$payment_details[0]['reservation_status'],
				'send_status'		=>$invoice_details[0]['send_status'],
				'comments'			=>$payment_details[0]['comments'],
				"no_of_adult" => $payment_details[0]['no_of_adult'],
				"no_of_extra_adult" => $payment_details[0]['no_of_extra_adult'],
				"no_of_extra_real_adult" => $payment_details[0]['no_of_extra_real_adult'],
				"no_of_extra_kid" => $payment_details[0]['no_of_extra_kid'],
				"no_of_folding_bed_kid" => $payment_details[0]['no_of_folding_bed_kid'],
				"no_of_folding_bed_adult" => $payment_details[0]['no_of_folding_bed_adult'],
				"no_of_baby_bed" => $payment_details[0]['no_of_baby_bed']
			);
		}

		$user_id=$payment_details[0]['user_id'];
		$user_details=$this->get_user($user_id);
		$default_language_id=$user_details[0]['user_language'];//user belongs to which language
		$bungalow_id=$payment_details[0]['bunglow_id'];
		$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>$default_language_id))->result_array();
		
		$euro_currency_arr=$this->db->get_where("lb_currency_master", array("currency_id"=>"2"))->result_array();
		$euro_currency=$euro_currency_arr[0]['currency_symbol'];

		$bungalow_rate=ceil($payment_details[0]['amount_to_be_paid'] - ($payment_details[0]['amount_to_be_paid'] * 4/100));	
		$accommodation=ceil(abs(strtotime($payment_details[0]['leave_date']) - strtotime($payment_details[0]['arrival_date'])) / 86400);	

		$invoice_arr[]=array(
				'reservation_date'	=>$payment_details[0]['reservation_date'],
				'reservation_id'	=>$reservation_id,
				'bunglow_under_booking'=>$payment_details[0]['name'],
				'arrival_date'		=>$payment_details[0]['arrival_date'],
				'leave_date'		=>$payment_details[0]['leave_date'],
				'accommodation'		=>$accommodation,
				'bungalow_name'		=>$bungalow_details[0]['bunglow_name'],
				'bungalow_rate'		=>$euro_currency.$stay_euro,
				'options_text_for_mail'=>$invoice_details[0]['options_dollar'],
				'discount'			=>$payment_details[0]['discount'],
				'tax_text_for_mail' =>$invoice_details[0]['tax_dollar'],
				'total'				=>$euro_currency.$payment_details[0]['amount_to_be_paid'],
				'due_amount'		=>$euro_currency.$payment_details[0]['due_amount'],
				"paid_amount"		=>$euro_currency.$payment_details[0]['paid_amount'],
				'payment_mode'		=>$payment_details[0]['payment_mode'],
				'date_payment_mode'		=>$payment_details[0]['date_payment_mode'],
				'invoice_number'	=>$payment_details[0]['invoice_number'],
				'payment_status'	=>$payment_details[0]['payment_status'],
				'reservation_status'=>$payment_details[0]['reservation_status'],
				'send_status'		=>$invoice_details[0]['send_status'],
				'comments'			=>$payment_details[0]['comments'],
				"no_of_adult" => $payment_details[0]['no_of_adult'],
				"no_of_extra_adult" => $payment_details[0]['no_of_extra_adult'],
				"no_of_extra_real_adult" => $payment_details[0]['no_of_extra_real_adult'],
				"no_of_extra_kid" => $payment_details[0]['no_of_extra_kid'],
				"no_of_folding_bed_kid" => $payment_details[0]['no_of_folding_bed_kid'],
				"no_of_folding_bed_adult" => $payment_details[0]['no_of_folding_bed_adult'],
				"no_of_baby_bed" => $payment_details[0]['no_of_baby_bed'],
				"reservation_amount" => $amount_without_tax,
				"extra_person" => $extra_person,
				"tax" => $total_tax_value
			);
	//echo $reservation_id;
		$parent_info=$this->db->get_where("lb_reservation", array("parent_id"=>$reservation_id))->result_array();
		if(count($parent_info)>0) //If invoice is not available
		{
			foreach ($parent_info as $parent_details) {
				$pextra_person = $pstay_euro = $parent_bungalow_rate = $ptot = $ptotal_tax_value = $pval2 =  $pval3 =  $pval6 = $pamount_without_tax = 0;
				$parent_bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$parent_details["bunglow_id"], "language_id"=>$default_language_id))->result_array();
				//$parent_bungalow_rate=ceil($parent_details['amount_to_be_paid'] - ($parent_details['amount_to_be_paid'] * 4/100));			
				$parent_accommodation=ceil(abs(strtotime($parent_details['leave_date']) - strtotime($parent_details['arrival_date'])) / 86400);	


				$pq_val = explode("-",$parent_details['arrival_date']);		 
				$pseason_id = $this->getSeasons($pq_val[2],$pq_val[1],$pq_val[0]);

				$prate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$parent_details["bunglow_id"], "season_id"=>$pseason_id))->result_array();
				if( $parent_accommodation > 6 ){
					$pstay_euro = $parent_bungalow_rate = $parent_accommodation * $prate_details_arr[0]['extranight_perday_europrice'];
				}else {
					$pstay_euro = $parent_bungalow_rate = $prate_details_arr[0]['rate_per_day_euro'] * $parent_accommodation;
				}
				$pval2 = $parent_details['no_of_extra_real_adult'];
				$pval3 = $parent_details['no_of_extra_adult'];
				$pval6 = $parent_details['no_of_folding_bed_adult'];
				if($pval2 > 0) $ptot = ($pval2 * 15 * $parent_accommodation);
				if($pval3 > 0) $ptot += ($pval3 * 15 * $parent_accommodation);
				if($pval6 > 0) $ptot += ($pval6 * 15 * $parent_accommodation);
				$pextra_person = $ptot;
				$ptot = ($parent_bungalow_rate + $ptot);
				$ptotal_tax_value = ($ptot * 4/100);

				$pamount_without_tax = ($parent_bungalow_rate + $pextra_person);

			//	echo $parent_details['id'];


				$invoice_arr[]=array(
					'reservation_date'	=>$parent_details['reservation_date'],
					'reservation_id'	=>$parent_details["id"],
					'bunglow_under_booking'=>$parent_details['name'],
					'arrival_date'		=>$parent_details['arrival_date'],
					'leave_date'		=>$parent_details['leave_date'],
					'accommodation'		=>$parent_accommodation,
					'bungalow_name'		=>$parent_bungalow_details[0]['bunglow_name'],
					'bungalow_rate'		=>$euro_currency.$parent_bungalow_rate,
					'options_text_for_mail'=>"",
					'discount'			=>$parent_details['discount'],
					'tax_text_for_mail' =>"",
					'total'				=>$euro_currency.$parent_details['amount_to_be_paid'],
					'due_amount'		=>$euro_currency.$parent_details['due_amount'],
					"paid_amount"		=>$euro_currency.$parent_details['paid_amount'],
					'payment_mode'		=>$parent_details['payment_mode'],
					'date_payment_mode'		=>$parent_details['date_payment_mode'],
					'invoice_number'	=>$parent_details['invoice_number'],
					'payment_status'	=>$parent_details['payment_status'],
					'reservation_status'=>$parent_details['reservation_status'],
					'send_status'		=>$parent_details['send_status'],
					'comments'			=>$parent_details['comments'],
					"no_of_adult" => $parent_details['no_of_adult'],
					"no_of_extra_adult" => $parent_details['no_of_extra_adult'],
					"no_of_extra_real_adult" => $parent_details['no_of_extra_real_adult'],
					"no_of_extra_kid" => $parent_details['no_of_extra_kid'],
					"no_of_folding_bed_kid" => $parent_details['no_of_folding_bed_kid'],
					"no_of_folding_bed_adult" => $parent_details['no_of_folding_bed_adult'],
					"no_of_baby_bed" => $parent_details['no_of_baby_bed'],
					"reservation_amount" => $pamount_without_tax,
					"extra_person" => $pextra_person,
					"tax" => $ptotal_tax_value
				);
			}
		}
		//die;
		//array_push($invoice_arr, $details_in_euro, $details_in_dollar);
		//print_r($invoice_arr); die;
		return $invoice_arr;
	}
	
	//Function to save invoice 
	function save_invoice()
	{
		$reservation_id=$this->input->post("reservation_id");
		$user_id=$this->input->post("user_id");
		$currency_type=$this->input->post("currency_type");
		$get_invoice=$this->db->get_where("lb_invoice", array("reservation_id"=>$reservation_id))->result_array();
		if(count($get_invoice)>0)//If invoice in not available then insert
		{
			$send_invoice_status=$get_invoice[0]['send_status'];
		}
		else //If invoice in available then update
		{
			$send_invoice_status="N";
		}
		if($currency_type=="EUR")
		{
			$input_arr=array(
				"reservation_id"	=>$reservation_id,
				"user_id"			=>$user_id,
				"invoice_code"		=>$this->input->post('invoice_code'),
				"customer_name"		=>$this->input->post('customer_name'),
				"reservation_date"	=>$this->input->post('reservation_date'),
				"arrival_date"		=>$this->input->post('arrival_date'),
				"leave_date"		=>$this->input->post('leave_date'),
				"accommodation"		=>$this->input->post('accommodation'),
				"bungalow_name"		=>$this->input->post('bungalow_name'),
				"payment_mode"		=>$this->input->post('payment_mode'),
				"discount"			=>$this->input->post('discount'),
				"total_bungalow_rate"=>$this->input->post('bungalow_rate'),
				"options"			=>$this->input->post('options_text_for_mail'),
				"tax"				=>$this->input->post('tax_text_for_mail'),
				"total_amount"		=>$this->input->post('total'),
				"paid_amount"		=>$this->input->post('paid_amount'),
				"due_amount"		=>$this->input->post('due_amount'),
				"total_bungalow_rate_dollar"=>$this->input->post('bungalow_rate_dollar'),
				"options_dollar"			=>$this->input->post('options_text_for_mail_dollar'),
				"tax_dollar"				=>$this->input->post('tax_text_for_mail_dollar'),
				"total_amount_dollar"		=>$this->input->post('total_dollar'),
				"paid_amount_dollar"		=>$this->input->post('paid_amount_dollar'),
				"due_amount_dollar"			=>$this->input->post('due_amount_dollar'),
				"payment_status"	=>$this->input->post('payment_status'),
				"reservation_status"=>$this->input->post('reservation_status'),
				"send_status"		=>$send_invoice_status,				
				"comments" =>nl2br($this->input->post('txt_comments'))
			);
		}
		elseif($currency_type=="USD")
		{
			$input_arr=array(
				"reservation_id"	=>$reservation_id,
				"user_id"			=>$user_id,
				"invoice_code"		=>$this->input->post('invoice_code'),
				"customer_name"		=>$this->input->post('customer_name'),
				"reservation_date"	=>$this->input->post('reservation_date'),
				"arrival_date"		=>$this->input->post('arrival_date'),
				"leave_date"		=>$this->input->post('leave_date'),
				"accommodation"		=>$this->input->post('accommodation'),
				"bungalow_name"		=>$this->input->post('bungalow_name'),
				"payment_mode"		=>$this->input->post('payment_mode'),
				"discount"			=>$this->input->post('discount'),
				"total_bungalow_rate"=>$this->input->post('bungalow_rate_euro'),
				"options"			=>$this->input->post('options_text_for_mail_euro'),
				"tax"				=>$this->input->post('tax_text_for_mail_euro'),
				"total_amount"		=>$this->input->post('total_euro'),
				"paid_amount"		=>$this->input->post('paid_amount_euro'),
				"due_amount"		=>$this->input->post('due_amount_euro'),
				"total_bungalow_rate_dollar"=>$this->input->post('bungalow_rate'),
				"options_dollar"			=>$this->input->post('options_text_for_mail'),
				"tax_dollar"				=>$this->input->post('tax_text_for_mail'),
				"total_amount_dollar"		=>$this->input->post('total'),
				"paid_amount_dollar"		=>0,
				"due_amount_dollar"	=>$this->input->post('due_amount'),
				"payment_status"	=>$this->input->post('payment_status'),
				"reservation_status"=>$this->input->post('reservation_status'),
				"send_status"		=>$send_invoice_status
			);
		}
		
		if(count($get_invoice)>0)//If invoice in available then update
		{
			$this->db->update("lb_invoice", $input_arr, array("reservation_id"=>$reservation_id));
		}
		else //If invoice in available then insert
		{
			$this->db->insert("lb_invoice", $input_arr);
		}
	}
	
	//function to send invoice from calendar
	/*function send_invoice($reservation_id)
	{
		$reservation_details=$this->db->get_where("lb_reservation", array("id"=>$reservation_id))->result_array();

		$user_id=$reservation_details[0]['user_id'];
		$user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		
		$bungalow_id=$reservation_details[0]['bunglow_id'];
		$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>"2"))->result_array();
		
		$bungalow_name_part = explode("<span>", $bungalow_details[0]['bunglow_name']);
		$bunglow_name = $bungalow_name_part[0];

		$bungalow_rate=ceil($reservation_details[0]['amount_to_be_paid'] - ($reservation_details[0]['amount_to_be_paid'] * 4/100));		
		$accommodation=ceil(abs(strtotime($reservation_details[0]['leave_date']) - strtotime($reservation_details[0]['arrival_date'])) / 86400);

		$discount = ($reservation_details[0]['discount'] != "")?$reservation_details[0]['discount']:"0";		
		
		$default_currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		$default_currency=$default_currency_arr[0]['currency_symbol'];

		//Sending email to users
		$additional_payment_text ="";
		
		$msg_text2='<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
			<tr bgcolor="#222222">
			<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">FACTURE</font></b></td>
			</tr>';
		$msg_text2.='
			<tr>
				<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
			</tr>
			<tr>
				<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
					<b>Dear '.$user_details[0]['name'].',</b><br>
					<b>Your invoice number is: '.$reservation_details[0]['invoice_number'].'</b><br>
					<b>Payment Mode: '.$reservation_details[0]['payment_mode'].'</b><br>
				</td>
			</tr>
			<tr  bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nom du client: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$user_details[0]['name'].'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bunglow_name.'</td>
			</tr>
			<tr  bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date de réservation: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.date("d/m/Y H:i:s", strtotime($reservation_details[0]['reservation_date'])).'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date d\'arrivée: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.date("d/m/Y", strtotime($reservation_details[0]['arrival_date'])).'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date de départ: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.date("d/m/Y", strtotime($reservation_details[0]['leave_date'])).'</td>
			</tr>
			<tr >
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nuitée:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$accommodation." ".lang('NIGHT').'</td>
			</tr>
			<tr  bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Prix des Bungalows:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.$bungalow_rate.'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre d’adultes: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_adult'].'</td>
			</tr>';

			if($reservation_details[0]['no_of_extra_real_adult'] > 0){
				$msg_text2.='<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre de personnes supplémentaires de plus de 12 ans: </b></td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_extra_real_adult'].'</td>
				</tr>';
			} if($reservation_details[0]['no_of_extra_adult'] > 0){ 
				$msg_text2.='<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre de personnes supplémentaires de plus de 6 ans: </b></td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_extra_adult'].'</td>
				</tr>';
			} if($reservation_details[0]['no_of_extra_kid'] > 0){ 
				$msg_text2.='<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre de personnes supplémentaires de 2 à 5 ans: </b></td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_extra_kid'].'</td>
				</tr>';
			} if($reservation_details[0]['no_of_folding_bed_kid'] > 0){ 
				$msg_text2.='<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre de lit pliant de 2 à 5 ans: </b></td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_folding_bed_kid'].'</td>
				</tr>';
			} if($reservation_details[0]['no_of_folding_bed_adult'] > 0){ 
				$msg_text2.='<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre de lit pliant de plus de 6 ans à 12 ans: </b></td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_folding_bed_adult'].'</td>
				</tr>';
			} if($reservation_details[0]['no_of_baby_bed'] > 0){ 
				$msg_text2.='<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre de Bébé de moins de 2 ans: </b></td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_baby_bed'].'</td>
				</tr>';
			}

			$msg_text2.='
			<tr  bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Réduction:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Taxe: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">4%</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total du séjour:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.$reservation_details[0]["amount_to_be_paid"].'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Acompte payé:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.$reservation_details[0]["paid_amount"].'</td>
			</tr>								
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant dû:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.$reservation_details[0]["due_amount"].'</td>
			</tr>								
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Commentaires:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]["invoice_comments"].'</td>
			</tr>';
			
		if($reservation_details[0]["amount_to_be_paid"] == $reservation_details[0]["due_amount"]){
			$msg_text2.='
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;" colspan="2"><b>
					*Votre reservation ne sera confirme qu`un fois le payement de l`acompte.
				</b></td>
			</tr>';
		}
		if($reservation_details[0]["amount_to_be_paid"] == $reservation_details[0]["paid_amount"]){
			$msg_text2.='
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;" colspan="2"><b>
					*Rules:-<br/><br/>
					Dear Guest, we are here to help you with any inconvenience during your stay. Immediately communicate defects to us<br/>
					- On day for departure, unless otherwise agreed, you are kindly requested to leave your bungalow before 11:00am<br/>
					- Please wash your dishes and your fridge before your departure<br/>
					- Please dispose of your waste in designated container outside on the top parking lot or the recycle container at each entrance of<br/>
					- Please no smoking inside of bungalow, thank you<br/>
					- Please switch off air-conditionning and lights before your departure<br/>
					- The remote control of the alarm system is not waterproof, please be careful with it<br/>
					- If we are out of the office at your departure, please drop your keys on our « drop off » keys box in our door office<br/><br/>
					If these rules are not respected, you authorize us to charge your credit card the amount of 100euros<br/><br/>
					Please sign :<br/><br/>
				</b></td>
			</tr>';
		}

		$msg_text2.=$additional_payment_text;
		$msg_text2.='</table>';
		return $msg_text2;
	}*/	


	function send_invoice($reservation_id)
	{
		$reservation_details=$this->db->get_where("lb_reservation", array("id"=>$reservation_id))->result_array();

		$user_id=$reservation_details[0]['user_id'];
		$user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		$default_language_id=$user_details[0]['user_language'];//user belongs to which language

		$bungalow_id=$reservation_details[0]['bunglow_id'];
		$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>"2"))->result_array();
		
		$bungalow_name_part = explode("<span>", $bungalow_details[0]['bunglow_name']);
		$bunglow_name = $bungalow_name_part[0];

		/*$bungalow_rate=ceil($reservation_details[0]['amount_to_be_paid'] - ($reservation_details[0]['amount_to_be_paid'] * 4/100));		
		$accommodation=ceil(abs(strtotime($reservation_details[0]['leave_date']) - strtotime($reservation_details[0]['arrival_date'])) / 86400);

*/
		$accommodation=ceil(abs(strtotime($reservation_details[0]['leave_date']) - strtotime($reservation_details[0]['arrival_date'])) / 86400);

		//yrcode
		//$q_val = explode("-",$reservation_details[0]['arrival_date']);		 
		//$season_id = $this->getSeasons($q_val[2],$q_val[1],$q_val[0]);
		
		$arrival_date_arr=explode("-",$reservation_details[0]['arrival_date']);
		$arrival_date = mktime(0,0,0, $arrival_date_arr[1], $arrival_date_arr[2], $arrival_date_arr[0]);
		$leave_date_arr=explode("-", $reservation_details[0]['leave_date']);
		$leave_date=mktime(0,0,0, $leave_date_arr[1], $leave_date_arr[2], $leave_date_arr[0]);
		$date_arr=$this->home_model->dateRanges($arrival_date, $leave_date);
		$days_count=count($date_arr) - 1;
		$accommodation = $days_count;
		
		$total_bungalow_rate=0;
		$total_bungalow_rate_dollar=0;
		$discount=0;
		
		
		
		$CI = &get_instance();
		$CI->load->model('reservation_model');

		$result_resa=$CI->reservation_model->get_bungalows_price($bungalow_id,date('d/m/Y',$arrival_date), date('d/m/Y',$leave_date));
		$stay_euro = $result_resa['stay_euro'];

		$bungalow_rate = $stay_euro;
		//echo $rate_details_arr[0]['extranight_perday_europrice']."test";
		$val2 = $reservation_details[0]['no_of_extra_real_adult'];
		$val3 = $reservation_details[0]['no_of_extra_adult'];
		$val6 = $reservation_details[0]['no_of_folding_bed_adult'];
		if($val2 > 0) $tot = ($val2 * 15 * $accommodation);
		if($val3 > 0) $tot += ($val3 * 15 * $accommodation);
		if($val6 > 0) $tot += ($val6 * 15 * $accommodation);
		$extra_person = $tot;
		$tot = ($bungalow_rate + $tot);
		
		$discount = ($reservation_details[0]['discount'] != "")?$reservation_details[0]['discount']:"0";
		
		if($discount!=0 && $discount!='')
		$discount1 = ($tot * $discount/100);
		else
		$discount1=0;
		
		$tot = $tot-$discount1;
		
		$tax = ($tot * 4/100);

		$amount_without_tax = ($bungalow_rate + $extra_person);
		
		$totalAmt = $tot+$tax;
		$paidAmt = str_replace("€","",$reservation_details[0]["paid_amount"]);
		$dueAmt = $totalAmt-$paidAmt;

		$default_currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		$default_currency=$default_currency_arr[0]['currency_symbol'];

		//Sending email to users
		$additional_payment_text ="";
		

		if($default_language_id==1)//If user language is english
		{
			$msg_text2='<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
				<tr bgcolor="#222222">
				<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">INVOICE</font></b></td>
				</tr>';
			$msg_text2.='
				<tr>
					<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
				</tr>
				<tr>
					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
						<b>Dear '.$user_details[0]['name'].',</b><br>
						<b>Your invoice number is: '.$reservation_details[0]['invoice_number'].'</b><br>
						<b>Payment Mode: '.$reservation_details[0]['payment_mode'].'</b><br>
					</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Customer Name: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$user_details[0]['name'].'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bunglow_name.'</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Date: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.date("d/m/Y H:i:s", strtotime($reservation_details[0]['reservation_date'])).'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Arrival Date: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.date("d/m/Y", strtotime($reservation_details[0]['arrival_date'])).'</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Leave Date: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.date("d/m/Y", strtotime($reservation_details[0]['leave_date'])).'</td>
				</tr>
				<tr >
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Night:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$accommodation.' Night(s)</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of Adults: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_adult'].'</td>
				</tr>';

				if($reservation_details[0]['no_of_extra_real_adult'] > 0){
					$msg_text2.='<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of extra person from 12yo: </b></td>
						<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_extra_real_adult'].'</td>
					</tr>';
				} if($reservation_details[0]['no_of_extra_adult'] > 0){ 
					$msg_text2.='<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of extra person from 6yo: </b></td>
						<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_extra_adult'].'</td>
					</tr>';
				} if($reservation_details[0]['no_of_extra_kid'] > 0){ 
					$msg_text2.='<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of extra person from 2 to 5yo: </b></td>
						<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_extra_kid'].'</td>
					</tr>';
				} if($reservation_details[0]['no_of_folding_bed_kid'] > 0){ 
					$msg_text2.='<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of folding bed from 2 to 5yo: </b></td>
						<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_folding_bed_kid'].'</td>
					</tr>';
				} if($reservation_details[0]['no_of_folding_bed_adult'] > 0){ 
					$msg_text2.='<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of folding bed from 6 to 12 yo: </b></td>
						<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_folding_bed_adult'].'</td>
					</tr>';
				} if($reservation_details[0]['no_of_baby_bed'] > 0){ 
					$msg_text2.='<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of Babies less than 2yo: </b></td>
						<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_baby_bed'].'</td>
					</tr>';
				}

				$msg_text2.='				
				<tr >
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Bungalow Rate:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.$bungalow_rate.'</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Extra Person Rate:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.$extra_person.'</td>
				</tr>';
				if($discount > 0){ 
				$msg_text2.='	
					<tr >
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Discount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
					</tr>';
				}	
				$msg_text2.='	
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax Rate(4%): </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.number_format($tax, 2, '.', ',').'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Amount: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.number_format($amount_without_tax, 2, '.', ',').'</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Amount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.number_format($totalAmt, 2, '.', ',').'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Paid Amount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.number_format($paidAmt, 2, '.', ',').'</td>
				</tr>								
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Due Amount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.number_format($dueAmt, 2, '.', ',').'</td>
				</tr>								
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Comments:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]["invoice_comments"].'</td>
				</tr>';
				
			if($reservation_details[0]["amount_to_be_paid"] == $reservation_details[0]["due_amount"]){
				$msg_text2.='
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;" colspan="2"><b>
						*Your booking will be confirmed once payment has been completed.
					</b></td>
				</tr>';
			}
			if($reservation_details[0]["amount_to_be_paid"] == $reservation_details[0]["paid_amount"]){
				$msg_text2.='
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;" colspan="2"><b>
						*Rules:-<br/><br/>
						Dear Guest, we are here to help you with any inconvenience during your stay. Immediately communicate defects to us<br/>
						- On day for departure, unless otherwise agreed, you are kindly requested to leave your bungalow before 11:00am<br/>
						- Please wash your dishes and your fridge before your departure<br/>
						- Please dispose of your waste in designated container outside on the top parking lot or the recycle container at each entrance of<br/>
						- Please no smoking inside of bungalow, thank you<br/>
						- Please switch off air-conditionning and lights before your departure<br/>
						- The remote control of the alarm system is not waterproof, please be careful with it<br/>
						- If we are out of the office at your departure, please drop your keys on our « drop off » keys box in our door office<br/><br/>
						If these rules are not respected, you authorize us to charge your credit card the amount of 100euros<br/><br/>
						Please sign :<br/><br/>
					</b></td>
				</tr>';
			}

			$msg_text2.=$additional_payment_text;
			$msg_text2.='</table>';
		}
		elseif($default_language_id==2)
		{
		$msg_text2='<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
			<tr bgcolor="#222222">
			<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">FACTURE</font></b></td>
			</tr>';
		$msg_text2.='
			<tr>
				<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
			</tr>
			<tr>
				<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
					<b>Cher(e) '.$user_details[0]['name'].',</b><br>
					<b>Votre numéro de facture est: '.$reservation_details[0]['invoice_number'].'</b><br>
					<b>Mode de paiement: '.$reservation_details[0]['payment_mode'].'</b><br>
				</td>
			</tr>
			<tr  bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nom du client: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$user_details[0]['name'].'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bunglow_name.'</td>
			</tr>
			<tr  bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date de réservation: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.date("d/m/Y H:i:s", strtotime($reservation_details[0]['reservation_date'])).'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date d\'arrivée: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.date("d/m/Y", strtotime($reservation_details[0]['arrival_date'])).'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date de départ: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.date("d/m/Y", strtotime($reservation_details[0]['leave_date'])).'</td>
			</tr>
			<tr >
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nuitée:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$accommodation." ".lang('NIGHT').'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre d’adultes: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_adult'].'</td>
			</tr>';

			if($reservation_details[0]['no_of_extra_real_adult'] > 0){
				$msg_text2.='<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre de personnes supplémentaires de plus de 12 ans: </b></td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_extra_real_adult'].'</td>
				</tr>';
			} if($reservation_details[0]['no_of_extra_adult'] > 0){ 
				$msg_text2.='<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre de personnes supplémentaires de plus de 6 ans: </b></td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_extra_adult'].'</td>
				</tr>';
			} if($reservation_details[0]['no_of_extra_kid'] > 0){ 
				$msg_text2.='<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre de personnes supplémentaires de 2 à 5 ans: </b></td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_extra_kid'].'</td>
				</tr>';
			} if($reservation_details[0]['no_of_folding_bed_kid'] > 0){ 
				$msg_text2.='<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre de lit pliant de 2 à 5 ans: </b></td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_folding_bed_kid'].'</td>
				</tr>';
			} if($reservation_details[0]['no_of_folding_bed_adult'] > 0){ 
				$msg_text2.='<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre de lit pliant de plus de 6 ans à 12 ans: </b></td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_folding_bed_adult'].'</td>
				</tr>';
			} if($reservation_details[0]['no_of_baby_bed'] > 0){ 
				$msg_text2.='<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nombre de Bébé de moins de 2 ans: </b></td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_baby_bed'].'</td>
				</tr>';
			}

			$msg_text2.='			
			<tr >
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Prix des Bungalows:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.$bungalow_rate.'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Prix des personnes supplémentaires:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.$extra_person.'</td>
			</tr>';
			if($discount > 0){ 
			$msg_text2.='				
				<tr >
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Réduction:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
				</tr>';
			}
			$msg_text2 .='
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total du taxe: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.number_format($tax , 2, '.', ',').'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant de la réservation: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.number_format($amount_without_tax , 2, '.', ',').'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total du séjour:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.number_format($totalAmt, 2, '.', ',').'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Acompte payé:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.number_format($paidAmt, 2, '.', ',').'</td>
			</tr>								
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant dû:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.' '.number_format($dueAmt, 2, '.', ',').'</td>
			</tr>								
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Commentaires:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]["invoice_comments"].'</td>
			</tr>';
			
		if($reservation_details[0]["amount_to_be_paid"] == $reservation_details[0]["due_amount"]){
			$msg_text2.='
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;" colspan="2"><b>
					*Votre reservation ne sera confirme qu`un fois le payement de l`acompte.
				</b></td>
			</tr>';
		}
		if($reservation_details[0]["amount_to_be_paid"] == $reservation_details[0]["paid_amount"]){
			$msg_text2.="
			<tr>
				<td style='border-top:1px solid #C9AD64; padding:5px;' colspan='2'><b>
					*Des règles:-<br/><br/>
					Cher(e) client , nous sommes ici pour vous aider avec tout inconvénient pendant votre séjour . Communiquent immédiatement les défauts de nous<br/>
					- Le jour du départ, sauf accord contraire , vous êtes priés de quitter votre bungalow avant 11h00<br/>
					- S'il vous plaît laver votre vaisselle et votre réfrigérateur avant votre départ<br/>
					- S'il vous plaît jeter vos déchets dans un conteneur désigné à l'extérieur sur le parking du haut ou le conteneur de recyclage à chaque entrée de
<br/>
					- Merci de ne pas fumer à l'intérieur du bungalow , merci<br/>
					- S'il vous plaît éteindre l'air conditionné et les lumières avant votre départ<br/>
					- La télécommande du système d'alarme est pas étanche , s'il vous plaît soyez prudent avec elle<br/>
					- Si nous sommes hors du bureau lors de votre départ , s'il vous plaît déposer vos clés sur notre boîte de « déposer » clés dans notre bureau de porte<br/><br/>
					Si ces règles ne sont pas respectées , vous nous autorisez à débiter votre carte de crédit le montant de € 100<br/><br/>
					Signez s'il-vous-plaît :<br/><br/>
				</b></td>
			</tr>";
		}

		$msg_text2.=$additional_payment_text;
		$msg_text2.='</table>';
		}
		//echo $msg_text2; die;
		return $msg_text2;
	}	
	//Function to send invoice
	function send_invoice_email()
	{
		$admin_details=$this->db->get_where("mast_admin_info", array("id"=>1))->result_array();
		$invoice_session=$this->session->userdata("invoice_data");//This session in getting created in users->invoice function
		$user_id=$invoice_session['user_id'];
		$user_details=$this->get_user($user_id);
		$update_mail_sent_status=$this->db->update("lb_invoice", array("send_status"=>'Y'), array("reservation_id"=>$invoice_session['reservation_id']));
		if($user_details[0]['user_language']==1)//If user language is english then invoice will be in english
		{
			$additional_payment_text ="";
			if($invoice_session['paid_amount']!='')
			{
				$additional_payment_text .='
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Paid Amount: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['paid_amount'].'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Due Amount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['due_amount'].'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Status:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['payment_status'].'</td>
					</tr>
					<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Status: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['reservation_status'].'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Mode:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['payment_mode'].'</td>
					</tr>
					<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date of Payment:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['date_payment_mode'].'</td>
					</tr>';
			}
			else 
			{
				$additional_payment_text .='
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Due Amount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['due_amount'].'</td>
					</tr>
					<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Status:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['payment_status'].'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Status: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['reservation_status'].'</td>
					</tr>
					<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Mode:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['payment_mode'].'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date of Payment:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['date_payment_mode'].'</td>
					</tr>';
			}
			$message=str_replace("##", $user_details[0]['name'], $this->input->post('message1'));//message in english
			$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
				<tr bgcolor="#222222">
				<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">INVOICE</font></b></td>
				</tr>';
			$msg_text2.='
				<tr>
					<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
				</tr>
				<tr>

				<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
					'.$message.'
				</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Customer Name: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['customer_name'].'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Date: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['reservation_date'].'</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Arrival Date: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['arrival_date'].'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Leave Date: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['leave_date'].'</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Accommodation(days):</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['accommodation'].'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['bungalow_name'].'</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Bungalow Rate:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['bungalow_rate'].'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Options: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['options_text_for_mail'].'</td>
				</tr>';
				if($invoice_session['discount'] > 0){ 
				$msg_text2.='	
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Discount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['discount'].'%</td>
					</tr>';
				}
				$msg_text2 .= '
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['tax_text_for_mail'].'</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Amount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['total'].'</td>
				</tr>';
				
			$msg_text2.=$additional_payment_text;
				
			$msg_text2.='
				<tr>
					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
					<p><b>Regards,</b></p>
					<p><b>La Balcons Company</b></p>
					</td>
				</tr>
				';
			$msg_text2.='</table>';
			
			$subject2 ="INVOICE @ LES BALCONS";
			$to2 = $user_details[0]['email'];
			$this->load->library('email');
			$config['mailtype'] = "html";
			$this->email->initialize($config);	
			$this->email->clear();
			$this->email->from($admin_details[0]['email'], 'LES BALCONS');
			$this->email->to($to2);
			$this->email->subject($subject2);
			$this->email->message($msg_text2); 
			$this->email->send();
		}
		elseif($user_details[0]['user_language']==2)//If user language is french then invoice will be in french
		{
			$message=str_replace("##", $user_details[0]['name'], $this->input->post('message2'));//message in french
			$additional_payment_text ="";
			if($invoice_session['paid_amount']!='')
			{
				$additional_payment_text .='
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant payé: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['paid_amount'].'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant dû:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['due_amount'].'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Statut de paiement:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['payment_status'].'</td>
					</tr>
					<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Statut de la réservation: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['reservation_status'].'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Mode de paiement:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['payment_mode'].'</td>
					</tr>
					<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date du payement:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['date_payment_mode'].'</td>
					</tr>';
			}
			else 
			{
				$additional_payment_text .='
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant dû:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['due_amount'].'</td>
					</tr>
					<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Statut de paiement:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['payment_status'].'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Statut de la réservation: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['reservation_status'].'</td>
					</tr>
					<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Mode de paiement:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['payment_mode'].'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date du payement:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['date_payment_mode'].'</td>
					</tr>';
			}
			$message=str_replace("##", $user_details[0]['name'], $this->input->post('message1'));//message in english
			$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
				<tr bgcolor="#222222">
				<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">FACTURE</font></b></td>
				</tr>';
			$msg_text2.='
				<tr>
					<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
				</tr>
				<tr>

				<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
					'.$message.'
				</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nom du client: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['customer_name'].'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date de réservation: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['reservation_date'].'</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date d\'arrivée: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['arrival_date'].'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date de départ: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['leave_date'].'</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Logement(journées):</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['accommodation'].'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['bungalow_name'].'</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Taux Total Bungalow:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['bungalow_rate'].'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Options: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['options_text_for_mail'].'</td>
				</tr>
				';
				if($invoice_session['discount'] > 0){ 
					$msg_text2.='
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Réduction:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['discount'].'%</td>
					</tr>';
				}
				$msg_text2.='
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Impôt: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['tax_text_for_mail'].'</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant Total:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_session['total'].'</td>
				</tr>';
				
			$msg_text2.=$additional_payment_text;
				
			$msg_text2.='
				<tr>
					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
					<p><b>Cordialement,</b></p>
					<p><b>La Balcons Company</b></p>
					</td>
				</tr>
				';
			$msg_text2.='</table>';
			
			$subject2 ="FACTURE @ LES BALCONS";
			$to2 = $user_details[0]['email'];
			$this->load->library('email');
			$config['mailtype'] = "html";
			$this->email->initialize($config);	
			$this->email->clear();
			$this->email->from($admin_details[0]['email'], 'LES BALCONS');
			$this->email->to($to2);
			$this->email->subject($subject2);
			$this->email->message($msg_text2); 
			$this->email->send();
		}
		return "mailsent";
	}
	
	
	
	
	//#######################function for front end regisration#####################
	
	//Function for set user data
	function set_register_data()
	{
		$result=$this->users_add();
		$this->session->unset_userdata("registration");
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
				  'is_user_logged_in' 	=> TRUE,
				  'address'				=> $result[0]['address'],
				  'contact_number'		=> $result[0]['contact_number'],
				  'email'				=> $result[0]['email']
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
	
	
	//Function for front end register user login
	function registration_user_login()
	{
		$user_email=$this->input->post("user_email");
		$user_password=$this->input->post("user_password");
		$result=$this->db->get_where("lb_users", array("email"=>$user_email, "password"=>md5($user_password)))->result_array();
		if(count($result)>0)
		{
			if($result[0]['status']=="A")
			{
				$login_user_info = array(				  
				  'user_id'   			=> $result[0]['id'],
				  'user_type'  			=> 'N',
				  'full_name'  		  	=> $result[0]['name'],
				  'is_user_logged_in' 	=> TRUE,
				  'address'				=> $result[0]['address'],
				  'contact_number'		=> $result[0]['contact_number'],
				  'email'				=> $result[0]['email']
				); 
                $this->session->set_userdata('login_user_info',$login_user_info);	
				$this->session->set_userdata('login_type', 'N');
				//return "success";
			}
			/*if($result[0]['status']=="C")
			{
				return "notactive";
			}*/
		}
		/*else 
		{
			return "notexist";
		}*/
		return $result;
	}
	
	
	
	
	
	//Function to check user existence while facebook login
	function check_facebook_user_existence($email)
	{
		$result=$this->db->get_where("lb_users", array("email"=>$email))->result_array();
		if(count($result)>0)
		{
			$login_user_info = array(
				  'user_id'   			=> $result[0]['id'],
				  'user_type'  			=> 'N',
				  'full_name'  		  	=> $result[0]['name'],
				  'is_user_logged_in' 	=> TRUE,
				  'address'				=> $result[0]['address'],
				  'contact_number'		=> $result[0]['contact_number'],
				  'email'				=> $result[0]['email']
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
			"modified_date"=>date("Y-m-d H:i:s")
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
		$bungalow_rate=$payment_details[0]['bunglow_per_day']*($accommodation+1);
		
		
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
		$payment_details_arr['options_rate']=$payment_details[0]['options_rate'];
		$payment_details_arr['discount']=$payment_details[0]['discount'];
		$payment_details_arr['tax_rate']="4";
		$payment_details_arr['total']=$default_currency.$payment_details[0]['amount_to_be_paid'];
		$payment_details_arr['paid_amount']=$default_currency.$payment_details[0]['paid_amount'];
		$payment_details_arr['due_amount']=$default_currency.$payment_details[0]['due_amount'];
		$payment_details_arr['payment_mode']=$payment_details[0]['payment_mode'];
		$payment_details_arr['invoice_number']=$payment_details[0]['invoice_number'];
		$payment_details_arr['payment_status']=$payment_details[0]['payment_status'];
		$payment_details_arr['reservation_status']=$payment_details[0]['reservation_status'];
		$payment_details_arr['comments']=$payment_details[0]['comments'];

		//echo "<pre>";
		//print_r($payment_details_arr);
		//die;
		return $payment_details_arr;
	}
	
	//Function to get bungalow_details by id
	function get_bungalow_max_person1($bungalow_id)
	{
		/*$bungalow_person=$this->db->get_where("lb_bunglow", array("id"=>$bungalow_id))->result_array();
		return $bungalow_person[0]['slug'];*/
		
		
		$this->db->where('id', $bungalow_id);
		$this->db->order_by('id', "desc");
		$query = $this->db->get('lb_bunglow');
		$result=array();
        foreach ($query->result() as $row) 
		{
			$result = array(
				'slug' => $row->slug
			);
        }
        return $result;
  
		
		
		
	}
	
	function download_invoice($res_id){
		$filename = $res_id.".pdf";
		$filepath = base_url()."assets/upload/Invoice/";
		require_once('html2pdf/html2pdf.class.php');

		$parent_info=$this->db->get_where("lb_reservation", array("parent_id"=>$res_id))->result_array();
		if(count($parent_info)>0) //If invoice is not available
		{
			$msg_text2 =  $this->send_invoice_multi($res_id);	
		}else{
			$results_array2=$this->db->get_where("lb_reservation", array("id"=>$res_id))->result_array();
			$results_array1=$this->db->get_where("lb_reservation", array("id"=>$results_array2[0]["parent_id"]))->result_array();
			if(count($results_array1) > 0){
				$msg_text2 =  $this->send_invoice_multi($results_array1[0]["id"]);	
			}
			else{
				$msg_text2 =  $this->send_invoice($res_id);	
			}
		}	
		
		$html2pdf = new HTML2PDF('P','A4','En');
	    $html2pdf->WriteHTML($msg_text2);
	    $html2pdf->Output('assets/upload/Invoice/'.$filename, 'F');


		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-type: application/pdf");// application/excel had also been used
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=$filename");
		header("Content-Transfer-Encoding: binary ");
		readfile($filepath.$filename);	
		exit();
	}
	
	//function to send invoice from calendar
	function send_invoice_multi($reservation_id)
	{
		//setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
		$reservation_details=$this->db->get_where("lb_reservation", array("id"=>$reservation_id))->result_array();

		$user_id=$reservation_details[0]['user_id'];
		$user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		$default_language_id=$user_details[0]['user_language'];//user belongs to which language
		
		$bungalow_id=$reservation_details[0]['bunglow_id'];
		$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>"2"))->result_array();
		
		$bungalow_name_part = explode("<span>", $bungalow_details[0]['bunglow_name']);
		$bunglow_name = $bungalow_name_part[0];

		$accommodation=ceil(abs(strtotime($reservation_details[0]['leave_date']) - strtotime($reservation_details[0]['arrival_date'])) / 86400);

		//yrcode
		//$q_val = explode("-",$reservation_details[0]['arrival_date']);		 
		//$season_id = $this->getSeasons($q_val[2],$q_val[1],$q_val[0]);
		$arrival_date_arr=explode("-",$reservation_details[0]['arrival_date']);
		$arrival_date = mktime(0,0,0, $arrival_date_arr[1], $arrival_date_arr[2], $arrival_date_arr[0]);
		$leave_date_arr=explode("-", $reservation_details[0]['leave_date']);
		$leave_date=mktime(0,0,0, $leave_date_arr[1], $leave_date_arr[2], $leave_date_arr[0]);
		$date_arr=$this->home_model->dateRanges($arrival_date, $leave_date);
		$days_count=count($date_arr) - 1;
		$accommodation = $days_count;
		
		$total_bungalow_rate=0;
		$total_bungalow_rate_dollar=0;
		$discount=0;
		$CI = &get_instance();
		$CI->load->model('reservation_model');

		$result_resa=$CI->reservation_model->get_bungalows_price($bungalow_id,date('d/m/Y',$arrival_date), date('d/m/Y',$leave_date));
		$bungalow_rate = $result_resa['stay_euro'];			
		

		$discount = ($reservation_details[0]['discount'] != "")?$reservation_details[0]['discount']:"0";		
		
		$default_currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		$default_currency=$default_currency_arr[0]['currency_symbol'];

		/*** 


		***/
		$val2 = $reservation_details[0]['no_of_extra_real_adult'];
		$val3 = $reservation_details[0]['no_of_extra_adult'];
		$val6 = $reservation_details[0]['no_of_folding_bed_adult'];
		if($val2 > 0) $tot = ($val2 * 15 * $accommodation);
		if($val3 > 0) $tot += ($val3 * 15 * $accommodation);
		if($val6 > 0) $tot += ($val6 * 15 * $accommodation);
		$extra_person = $tot;
		$tot = ($bungalow_rate + $tot);
		
		if($discount!=0 && $discount!='')
		$discount1 = ($tot * $discount/100);
		else
		$discount1=0;
		
		$tot = $tot-$discount1;
		
		$tax = ($tot * 4/100);
		
		
		
		$totalAmt = $tot+$tax;
		$paidAmt = str_replace("€","",$reservation_details[0]["paid_amount"]);
		$dueAmt = $totalAmt-$paidAmt;

		$amount_without_tax = ($bungalow_rate + $extra_person);
		
		/*$amount_to_be_paid = $reservation_details[0]["amount_to_be_paid"];
		$paid_amount = $reservation_details[0]["paid_amount"];
		$due_amount = $reservation_details[0]["due_amount"];*/
		$amount_to_be_paid = $totalAmt;
		$paid_amount = $paidAmt;
		$due_amount = $dueAmt;
		
		$invoice_comments = $reservation_details[0]["invoice_comments"]."<br/>";
		
		$totalDiscount=0;
		$discountStr='';
		if($reservation_details[0]['discount']>0)
		{
			$discountStr = '<b>Discount: </b>% '.$reservation_details[0]['discount'].', ';
			$totalDiscount = $totalDiscount+$reservation_details[0]['discount'];
		}
		
		if($default_language_id==1)//If user language is french
		{
			$msg_text2='<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
				<tr bgcolor="#222222">
				<td colspan="10" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">INVOICE</font></b></td>
				</tr>';
			$msg_text2.='
				<tr>
					<td colspan="10" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
				</tr>
				<tr>
					<td colspan="10" style="border-top:1px solid #C9AD64; padding:5px;">
						<b>Your invoice number is: '.$reservation_details[0]['invoice_number'].'</b><br>
						<b>Name</b>: '.$user_details[0]['name'].'<br>
						<b>Email</b>: '.$user_details[0]['email'].'<br>
						<b>Address</b>: '.$user_details[0]['address'].'<br>
					</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;">Date<br/>Arrival</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Date<br/>Departure</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Rate<br/>per Room</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb.<br/>Adults</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb. Extra<br/>Person(12)</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb. Extra<br/>Person(6)</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb. Extra<br/>Person(2-5)</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb. FB<br/>Person(2-5)</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb. FB<br/>Person(6-12)</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb.<br/>Baby</td>
				</tr>';
				if($reservation_details[0]["reservation_status"]!="Annulée")
				{
					$msg_text2.='
					<tr>
						<td colspan="10"><b>'.$bunglow_name.'</b></td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b", strtotime($reservation_details[0]['arrival_date']))."<br/>".strftime ("%a %d, %Y", strtotime($reservation_details[0]['arrival_date'])).'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b", strtotime($reservation_details[0]['leave_date']))."<br/>".strftime ("%a %d, %Y", strtotime($reservation_details[0]['leave_date'])).'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$default_currency.' '.$bungalow_rate.'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_extra_real_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_extra_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_extra_kid'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_folding_bed_kid'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_folding_bed_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_baby_bed'].'</td>
					</tr>
					<tr>
						<td colspan="10"><b>Extra Person Amount: </b>'.$default_currency.' '.$extra_person.', <b>Tax Amount: </b>'.$default_currency.' '.($tax).', <b>Total Amount: </b>'.$default_currency.' '.number_format($totalAmt, 2, '.', ',').','.$discountStr.' <b>Paid Amount: </b>'.$default_currency.' '.number_format($reservation_details[0]['paid_amount'], 2, '.', ',').', <b>Due Amount: </b>'.$default_currency.' '.number_format($dueAmt, 2, '.', ',').'</td>
					</tr>';
				}
				else
				{
					$amount_without_tax = 0;
					$amount_to_be_paid = 0;
					$paid_amount = 0;
					$due_amount = 0;
					$tax = 0;
					$totalDiscount = 0;
					$invoice_comments = '';
					$extra_person = 0;
				}
			$parent_info=$this->db->get_where("lb_reservation", array("parent_id"=>$reservation_id))->result_array();
			//print_r($parent_info);die();
			if(count($parent_info)>0) //If invoice is not available
			{
				foreach ($parent_info as $parent_details) 
				{
					if($parent_details["reservation_status"]!="Annulée")
					{
						
					$ptot=0;
					$parent_bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$parent_details["bunglow_id"], "language_id"=>"2"))->result_array();
					

					//$parent_bungalow_rate=ceil($parent_details['amount_to_be_paid'] - ($parent_details['amount_to_be_paid'] * 4/100));			
					$paccommodation=ceil(abs(strtotime($parent_details['leave_date']) - strtotime($parent_details['arrival_date'])) / 86400);
					
					//yrcode
					//$pq_val = explode("-",$parent_details['arrival_date']);		 
					//$pseason_id = $this->getSeasons($pq_val[2],$pq_val[1],$pq_val[0]);
					$arrival_date_arr=explode("-",$parent_details['arrival_date']);
					$arrival_date = mktime(0,0,0, $arrival_date_arr[1], $arrival_date_arr[2], $arrival_date_arr[0]);
					$leave_date_arr=explode("-",$parent_details['leave_date']);
					$leave_date=mktime(0,0,0, $leave_date_arr[1], $leave_date_arr[2], $leave_date_arr[0]);
					$date_arr=$this->home_model->dateRanges($arrival_date, $leave_date);
					$days_count=count($date_arr) - 1;
					$paccommodation = $days_count;
					
					$total_bungalow_rate=0;
					$total_bungalow_rate_dollar=0;
					$discount=0;
					$result_resa=$CI->reservation_model->get_bungalows_price($parent_details["bunglow_id"],date('d/m/Y',$arrival_date), date('d/m/Y',$leave_date));
					$parent_bungalow_rate = $result_resa['stay_euro'];			


					/*$pval2 = $reservation_details[0]['no_of_extra_real_adult'];
					$pval3 = $reservation_details[0]['no_of_extra_adult'];
					$pval6 = $reservation_details[0]['no_of_folding_bed_adult'];*/
					
					//yrcode
					$pval2 = $parent_details['no_of_extra_real_adult'];
					$pval3 = $parent_details['no_of_extra_adult'];
					$pval6 = $parent_details['no_of_folding_bed_adult'];
					//end yrcode
					
					if($pval2 > 0) $ptot = ($pval2 * 15 * $paccommodation);
					if($pval3 > 0) $ptot += ($pval3 * 15 * $paccommodation);
					if($pval6 > 0) $ptot += ($pval6 * 15 * $paccommodation);
					
					$pextra_person = $ptot;
					
					$ptot = ($parent_bungalow_rate + $ptot);
					
					if($parent_details['discount']!=0 && $parent_details['discount']!='')
					$discount1 = ($ptot * $parent_details['discount']/100);
					else
					$discount1=0;
					
					$ptot = $ptot-$discount1;
					
					$tax = (double)(($ptot * 4/100) + $tax);
					
					$tax1 = ($ptot * 4/100);
					
					
					
					$totalAmt = $ptot+$tax1;
					$paidAmt = str_replace("€","",$parent_details["paid_amount"]);
					$dueAmt = $totalAmt-$paidAmt;

					$amount_without_tax += ($parent_bungalow_rate + $pextra_person);

					/*$amount_to_be_paid = (double)($parent_details['amount_to_be_paid'] + $amount_to_be_paid);
					$paid_amount = (double)($parent_details['paid_amount'] + $paid_amount);
					$due_amount = (double)($parent_details['due_amount'] + $due_amount);*/
					$amount_to_be_paid = (double)($totalAmt + $amount_to_be_paid);
					$paid_amount = (double)($paidAmt + $paid_amount);
					$due_amount = (double)($dueAmt + $due_amount);
					
					$invoice_comments .= $parent_details['invoice_comments']."<br/>";

					$parent_bungalow_name_part = explode("<span>", $parent_bungalow_details[0]['bunglow_name']);
					$parent_bunglow_name = $parent_bungalow_name_part[0];
					$discountStr='';
					if($parent_details['discount']>0)
					{
						$discountStr = '<b>Discount: </b>% '.$parent_details['discount'].', ';
						$totalDiscount = $totalDiscount+$parent_details['discount'];
					}

					$msg_text2.='<tr>
						<td colspan="10">&nbsp;</td>
					</tr>				
					<tr>
						<td colspan="10"><b>'.$parent_bunglow_name.'</b></td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b", strtotime($parent_details['arrival_date']))."<br/>".strftime ("%a %d, %Y", strtotime($parent_details['arrival_date'])).'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b", strtotime($parent_details['leave_date']))."<br/>".strftime ("%a %d, %Y", strtotime($parent_details['leave_date'])).'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$default_currency.' '.$parent_bungalow_rate.'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_extra_real_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_extra_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_extra_kid'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_folding_bed_kid'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_folding_bed_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_baby_bed'].'</td>
					</tr>
					<tr>
						<td colspan="10"><b>Extra Person Amount: </b>'.$default_currency.' '.$pextra_person.', <b>Tax Amount: </b>'.$default_currency.' '.($ptot * 4/100).', <b>Total Amount: </b>'.$default_currency.' '.number_format($totalAmt, 2, '.', ',').','.$discountStr.' <b>Paid Amount: </b>'.$default_currency.' '.number_format($parent_details['paid_amount'], 2, '.', ',').', <b>Due Amount: </b>'.$default_currency.' '.number_format($dueAmt, 2, '.', ',').'</td>
					</tr>';
				
					}
				}
			}
			$totalDiscountStr='';
			if($totalDiscount>0)
			{
				$totalDiscountStr = '<b>Total Amount with Discount: </b>% '.$totalDiscount.'<br/>';
			}
			$msg_text2.='<tr>
					<td colspan="10">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="10" align="center">
						<b>Reservation Amount: </b>'.$default_currency.' '.number_format(($amount_without_tax) , 2, '.', ',').'<br/>
						<b>Tax Rate(4%): </b>'.$default_currency.' '.number_format($tax , 2, '.', ',').'<br/>
						<b>Total Amount: </b>'.$default_currency.' '.$amount_to_be_paid.'<br/>
						'.$totalDiscountStr.'
						<b>Paid Amount: </b>'.$default_currency.' '.$paid_amount.'<br/>
						<b>Due Amount: </b>'.$default_currency.' '.$due_amount.'<br/>
						
					</td>
				</tr>
				';
			if($amount_to_be_paid == $due_amount){
				$msg_text2.='
				<tr><td colspan="10" align="center"><b>*Your booking will be confirmed once payment has been completed.</b></td></tr>';
			}
			$msg_text2.='
				<tr><td colspan="10">
				<span style="border:1px solid; padding:3px;"><b>Comments</b><br/>'.$invoice_comments.'</span>
				</td></tr>
				';
				
			
			if($amount_to_be_paid == $paid_amount){
				$msg_text2.='
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;" colspan="10"><b>
						*Rules:-<br/><br/>
						Dear Guest, we are here to help you with any inconvenience during your stay. Immediately communicate defects to us<br/>
						- On day for departure, unless otherwise agreed, you are kindly requested to leave your bungalow before 11:00am<br/>
						- Please wash your dishes and your fridge before your departure<br/>
						- Please dispose of your waste in designated container outside on the top parking lot or the recycle container at each entrance of<br/>
						- Please no smoking inside of bungalow, thank you<br/>
						- Please switch off air-conditionning and lights before your departure<br/>
						- The remote control of the alarm system is not waterproof, please be careful with it<br/>
						- If we are out of the office at your departure, please drop your keys on our « drop off » keys box in our door office<br/><br/>
						If these rules are not respected, you authorize us to charge your credit card the amount of 100euros<br/><br/>
						Please sign :<br/><br/>
					</b></td>
				</tr>';
			}
			$msg_text2 .= "</table>";
		}else if($default_language_id==2){
			setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
			$msg_text2='<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
				<tr bgcolor="#222222">
				<td colspan="10" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">FACTURE</font></b></td>
				</tr>';
			$msg_text2.='
				<tr>
					<td colspan="10" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
				</tr>
				<tr>
					<td colspan="10" style="border-top:1px solid #C9AD64; padding:5px;">
						<b>Votre numéro de facture est: '.$reservation_details[0]['invoice_number'].'</b><br>
						<b>'.lang("Name").'</b>: '.$user_details[0]['name'].'<br>
						<b>'.lang("Email").'</b>: '.$user_details[0]['email'].'<br>
						<b>'.lang("Address").'</b>: '.$user_details[0]['address'].'<br>
					</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;">Date<br/>d\'arrivée</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Date<br/>de départ</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Tarif de<br/>la chambre</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb.<br/>Adultes</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb. Personne<br/>sup((12)</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb. Personne<br/>sup(6)</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb. Personne<br/>sup(2-5)</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb. Lit<br/>pliant(2-5)</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb. Lit<br/>pliant(6-12)</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb.<br/>Bébé</td>
				</tr>';
				
				if($reservation_details[0]["reservation_status"]!="Annulée")
				{
				
				$msg_text2.='
				<tr>
					<td colspan="10"><b>'.$bunglow_name.'</b></td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b", strtotime($reservation_details[0]['arrival_date']))."<br/>".strftime ("%a %d, %Y", strtotime($reservation_details[0]['arrival_date'])).'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b", strtotime($reservation_details[0]['leave_date']))."<br/>".strftime ("%a %d, %Y", strtotime($reservation_details[0]['leave_date'])).'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.$default_currency.' '.$bungalow_rate.'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_adult'].'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_extra_real_adult'].'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_extra_adult'].'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_extra_kid'].'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_folding_bed_kid'].'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_folding_bed_adult'].'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_baby_bed'].'</td>
				</tr>
				<tr>
					<td colspan="10"><b>Prix personnes sup: </b>'.$default_currency.' '.$extra_person.', <b>Taxe: </b>'.$default_currency.' '.($tax).', <b>Total du séjour: </b>'.$default_currency.' '.$totalAmt.','.$discountStr.' <b>Acompte payé: </b>'.$default_currency.' '.$reservation_details[0]['paid_amount'].', <b>Montant dû: </b>'.$default_currency.' '.$reservation_details[0]['due_amount'].'</td>
				</tr>';
				}
				else
				{
					$amount_without_tax = 0;
					$amount_to_be_paid = 0;
					$paid_amount = 0;
					$due_amount = 0;
					$tax = 0;
					$totalDiscount = 0;
					$invoice_comments = '';
					$extra_person = 0;
					$discount = 0;
					$discount1 = 0;
				}
			$parent_info=$this->db->get_where("lb_reservation", array("parent_id"=>$reservation_id))->result_array();
			//print_r($parent_info);
			if(count($parent_info)>0) //If invoice is not available
			{
				foreach ($parent_info as $parent_details) {
					$ptot=0;
					if($parent_details["reservation_status"]!="Annulée")
					{
					$parent_bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$parent_details["bunglow_id"], "language_id"=>"2"))->result_array();
					//$parent_bungalow_rate=ceil($parent_details['amount_to_be_paid'] - ($parent_details['amount_to_be_paid'] * 4/100));			
					$paccommodation=ceil(abs(strtotime($parent_details['leave_date']) - strtotime($parent_details['arrival_date'])) / 86400);
					$pq_val = explode("-",$parent_details['arrival_date']);		 
					$pseason_id = $this->getSeasons($pq_val[2],$pq_val[1],$pq_val[0]);

					$prate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$parent_details["bunglow_id"], "season_id"=>$pseason_id))->result_array();
					
					
					$result_resa=$CI->reservation_model->get_bungalows_price($parent_details["bunglow_id"],date('d/m/Y',strtotime($parent_details['arrival_date'])), date('d/m/Y',strtotime($parent_details['leave_date'])));
					$parent_bungalow_rate = $result_resa['stay_euro'];
					/*$pval2 = $reservation_details[0]['no_of_extra_real_adult'];
					$pval3 = $reservation_details[0]['no_of_extra_adult'];
					$pval6 = $reservation_details[0]['no_of_folding_bed_adult'];*/
					
					//yrcode
					$pval2 = $parent_details['no_of_extra_real_adult'];
					$pval3 = $parent_details['no_of_extra_adult'];
					$pval6 = $parent_details['no_of_folding_bed_adult'];
					//end yrcode
					
					if($pval2 > 0) $ptot = ($pval2 * 15 * $paccommodation);
					if($pval3 > 0) $ptot += ($pval3 * 15 * $paccommodation);
					if($pval6 > 0) $ptot += ($pval6 * 15 * $paccommodation);
					
					$pextra_person = $ptot;
					
					$ptot = ($parent_bungalow_rate + $ptot);
					
					if($parent_details['discount']!=0 && $parent_details['discount']!='')
					$discount1 = ($ptot * $parent_details['discount']/100);
					else
					$discount1=0;
					
					$ptot = $ptot-$discount1;
					
					$tax = (double)(($ptot * 4/100) + $tax);
					
					$tax1 = ($ptot * 4/100);
					
					
					
					$totalAmt = $ptot+$tax1;
					$paidAmt = str_replace("€","",$parent_details["paid_amount"]);
					$dueAmt = $totalAmt-$paidAmt;

					$amount_without_tax += ($parent_bungalow_rate + $pextra_person);

					/*$amount_to_be_paid = (double)($parent_details['amount_to_be_paid'] + $amount_to_be_paid);
					$paid_amount = (double)($parent_details['paid_amount'] + $paid_amount);
					$due_amount = (double)($parent_details['due_amount'] + $due_amount);*/
					$amount_to_be_paid = (double)($totalAmt + $amount_to_be_paid);
					$paid_amount = (double)($paidAmt + $paid_amount);
					$due_amount = (double)($dueAmt + $due_amount);
					
					$invoice_comments .= $parent_details['invoice_comments']."<br/>";

					$parent_bungalow_name_part = explode("<span>", $parent_bungalow_details[0]['bunglow_name']);
					$parent_bunglow_name = $parent_bungalow_name_part[0];
					$discountStr='';
					if($parent_details['discount']>0)
					{
						$discountStr = '<b>Discount: </b>% '.$parent_details['discount'].', ';
						$totalDiscount = $totalDiscount+$parent_details['discount'];
					}

					$msg_text2.='<tr>
						<td colspan="10">&nbsp;</td>
					</tr>				
					<tr>
						<td colspan="10"><b>'.$parent_bunglow_name.'</b></td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b", strtotime($parent_details['arrival_date']))."<br/>".strftime ("%a %d, %Y", strtotime($parent_details['arrival_date'])).'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b", strtotime($parent_details['leave_date']))."<br/>".strftime ("%a %d, %Y", strtotime($parent_details['leave_date'])).'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$default_currency.' '.$parent_bungalow_rate.'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_extra_real_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_extra_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_extra_kid'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_folding_bed_kid'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_folding_bed_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_baby_bed'].'</td>
					</tr>
					<tr>
						<td colspan="10"><b>Prix personnes sup: </b>'.$default_currency.' '.$pextra_person.', <b>Taxe: </b>'.$default_currency.' '.($ptot * 4/100).', <b>Total du séjour: </b>'.$default_currency.' '.number_format($totalAmt, 2, '.', ',').','.$discountStr.' <b>Acompte payé: </b>'.$default_currency.' '.number_format($parent_details['paid_amount'], 2, '.', ',').', <b>Montant dû: </b>'.$default_currency.' '.number_format($dueAmt, 2, '.', ',').'</td>
					</tr>';
					}
				}
			}
			$totalDiscountStr='';
			if($totalDiscount>0)
			{
				$totalDiscountStr = '<b>Total Amount with Discount: </b>% '.$totalDiscount.'<br/>';
			}
			$msg_text2.='<tr>
					<td colspan="10">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="10" align="center">
						<b>Montant de la réservation: </b>'.$default_currency.' '.number_format(($amount_without_tax) , 2, '.', ',').'<br/>
						<b>Taxe(4%): </b>'.$default_currency.' '.number_format($tax, 2, '.', ',').'<br/>
						<b>Total du séjour: </b>'.$default_currency.' '.$amount_to_be_paid.'<br/>
						'.$totalDiscountStr.'
						<b>Acompte payé: </b>'.$default_currency.' '.$paid_amount.'<br/>
						<b>Montant dû: </b>'.$default_currency.' '.$due_amount.'<br/>
					</td>
				</tr>
				';
			if($amount_to_be_paid == $due_amount){
				$msg_text2.='
				<tr><td colspan="10" align="center"><b>*Votre reservation ne sera confirme qu`un fois le payement de l`acompte.</b></td></tr>';
			}
			$msg_text2.='
				<tr><td colspan="10">
				<span style="border:1px solid; padding:3px;"><b>'.lang("User_Comments")."</b><br/>".$invoice_comments.'</span>
				</td></tr>
				';
				
			
			if($amount_to_be_paid == $paid_amount){
				$msg_text2.="
				<tr>
					<td style='border-top:1px solid #C9AD64; padding:5px;'' colspan='6'><b>
						*Des règles:-<br/><br/>
						Cher(e) client , nous sommes ici pour vous aider avec tout inconvénient pendant votre séjour . Communiquent immédiatement les défauts de nous<br/>
						- Le jour du départ, sauf accord contraire , vous êtes priés de quitter votre bungalow avant 11h00<br/>
						- S'il vous plaît laver votre vaisselle et votre réfrigérateur avant votre départ<br/>
						- S'il vous plaît jeter vos déchets dans un conteneur désigné à l'extérieur sur le parking du haut ou le conteneur de recyclage à chaque entrée de
			<br/>
						- Merci de ne pas fumer à l'intérieur du bungalow , merci<br/>
						- S'il vous plaît éteindre l'air conditionné et les lumières avant votre départ<br/>
						- La télécommande du système d'alarme est pas étanche , s'il vous plaît soyez prudent avec elle<br/>
						- Si nous sommes hors du bureau lors de votre départ , s'il vous plaît déposer vos clés sur notre boîte de « déposer » clés dans notre bureau de porte<br/><br/>
						Si ces règles ne sont pas respectées , vous nous autorisez à débiter votre carte de crédit le montant de € 100<br/><br/>
						Signez s'il-vous-plaît :<br/><br/>
					</b></td>
				</tr>";
			}
			$msg_text2 .= "</table>";
		}
		//echo $msg_text2; die;
		return $msg_text2; 
	}	

	function getSeasons($day,$month,$year){
		$cur_date = date('Y-m-d', mktime(0,0,0,$month,$day,$year));
		$high_start_date = date('Y-m-d', mktime(0,0,0,12,15,$year));
		$high_end_date = date('Y-m-d', mktime(0,0,0,4,14,($year+1)));

		$low_start_date = date('Y-m-d', mktime(0,0,0,4,15,$year));
		$low_end_date = date('Y-m-d', mktime(0,0,0,12,14,$year));
		$season_id = 0;
		if($cur_date >= $low_start_date && $cur_date <= $low_end_date) $season_id = "2";
		else $season_id = "1";

	//echo $cur_date."*".$high_start_date."*".$high_end_date."*".$low_start_date."*".$low_end_date."---".$season_id;
		return $season_id;
	}
}
?>