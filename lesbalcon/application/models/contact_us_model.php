<?php
class contact_us_model extends CI_Model
{
	function  __construct() 
	{
        parent::__construct();
    }

	//Function to save contact details from contact page
	function save_contact_details() //If conditions for spam checking
	{
		if($this->input->post("submit_contact"))
		{
			if($this->input->post("mail_submit")=="true")
			{
				if($this->input->post("middle_name")=="")
				{
                                    
					//if($this->input->post("check_val")==200)
				if(true)	
                                    {
                                            
						$admin_details=$this->db->get_where("mast_admin_info", array("id"=>1))->result_array();
						$admin_email=$admin_details[0]['email']; 
					
						$name=$this->input->post("contact_name");
						$email=$this->input->post("contact_email");
						$contact_no=$this->input->post("contact_phone");
						$comments=$this->input->post("contact_comment");
						
						//Inserting into contact details tables
						$ins_arr=array(
							"name"=>$name,
							"email"=>$email,
							"contact_no"=>$contact_no,
							"message"=>$comments,
							"created_time"=>date("Y-m-d H:i:s")
						);
						//$this->db->insert("lb_contact_details", $ins_arr);
						
						//Inserting into admin inbox table
						$ins_arr1=array(
							"sender_email"=>$email,
							"receiver_email"=>$admin_email,
							"subject"=>lang("Contact_Us"),
							"message"=>$comments,
							"status"=>"UNREAD",
							"time"=>date("Y-m-d H:i:s")
						);
						//$this->db->insert("lb_inbox", $ins_arr1);
						
						//Sending email To user
						/*$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
							<tr bgcolor="#222222">
							<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">'.lang('Thank_you_for_contacting_us').'</font></b></td>
							</tr>';
						$msg_text2.='
							<tr>
								<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
							</tr>
							<tr>
								<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
									<b>'.lang('Dear').' '.$name.',</b><br>
									<b>'.lang('Your_contact_details_has_been_received_by_us').'.</b><br>
									<b>'.lang('Your_details_are_as_follows').'</b>
								</td>
							</tr>
							<tr  bgcolor="#f5e8c8">
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Name').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$name.'</td>
							</tr>
							<tr>
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Email: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$email.'</td>
							</tr>
							<tr bgcolor="#f5e8c8">
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Contact_no').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$contact_no.'</td>
							</tr>
							<tr>
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Comments').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$comments.'</td>
							</tr>
							<tr>
								<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
								<p><b>'.lang('Regards').'</b></p>
								<p><b>La Balcons Company</b></p>
								</td>
							</tr>
						</table>';
						$subject2 = lang('Thank_you_for_contacting_us');
						$to2 = $email;
						$this->load->library('email');
						$config['mailtype'] = "html";
						$this->email->initialize($config);	
						$this->email->clear();
						$this->email->from($admin_email, 'LES BALCONS');
						$this->email->to($to2);
						$this->email->subject($subject2);
						$this->email->message($msg_text2); 
						$this->email->send();*/
						
						//Sending email To Admin
						$msg_text3='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
							<tr bgcolor="#222222">
							<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">'.lang('New_contact_details_received').'</font></b></td>
							</tr>';
						$msg_text3.='
							<tr>
								<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
							</tr>
							<tr>
								<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
									<b>'.lang('Dear').' Admin,</b><br>
									<b>'.lang('New_contact_details_received').'.</b><br>
									<b>'.lang('Details_are_as_follows').'</b>
								</td>
							</tr>
							<tr  bgcolor="#f5e8c8">
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Name').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$name.'</td>
							</tr>
							<tr>
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Email: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$email.'</td>
							</tr>
							<tr bgcolor="#f5e8c8">
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Contact_no').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$contact_no.'</td>
							</tr>
							<tr>
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Comments').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$comments.'</td>
							</tr>
							<tr>
								<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
								<p><b>'.lang('Regards').'</b></p>
								<p><b>La Balcons Company</b></p>
								</td>
							</tr>
						</table>';
						$subject3 = lang('New_contact_details_received');
						$to3 =$admin_email;                                                
						/* $this->load->library('email');
                                                
						$config['smtp_host'] = "lesbalcons.com";
                                                $config['mailtype'] = "html";
						$this->email->initialize($config);	
						$this->email->clear();
						//$this->email->from($admin_email, 'LES BALCONS');
						$this->email->from($email, $name);
						$this->email->to($to3);
						$this->email->subject($subject3);
						$this->email->message($msg_text3);  */
						//$this->email->send();
                                                
                                                
                                                // Always set content-type when sending HTML email
                                            $headers = "MIME-Version: 1.0" . "\r\n";
                                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                                            // More headers
                                            $headers .= 'From: ' .$email. "\r\n";
                                            //$headers .= 'Cc: myboss@example.com' . "\r\n";
                                            
                                            mail($to3,$subject3,$msg_text3,$headers);
                                                
                                                
                                                
					}
				}
			}
		}
	}
}

?>