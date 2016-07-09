<?php
class template_model extends CI_Model
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
	
	

	//######################ADDING TEMPLATE ACCORDING TO LANGUAGE###########################
	
	function template_add()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		//Inserting data in database
		$insert_arr=array(
			"type_id"=>$this->input->post('mail_type'),
			"is_active"=>"Y"
		);
		$this->db->insert("lb_email_template", $insert_arr);
		$last_id=$this->db->insert_id();
		foreach($languages_err as $language)
		{
			$language_id=$language['id'];
			$template_id=$last_id;
			$subject=$this->input->post("email_subject".$language['id']);
			$other=$this->input->post("email_other");
                        $message=$this->input->post("email_message".$language['id']);
			$insert_arr_1=array(
				"language_id"=>$language_id,
				"template_id"=>$template_id,
                                "other"=>$other,
				"subject"=>$subject,
				"message"=>$message
			);
			$this->db->insert("lb_email_template_lang", $insert_arr_1);
		}
		return "add_success";
	}
		
	
	//###################################################################################
	
	//##################################Edit Template#######################################
	
	function get_template($language_id, $template_id) //Get all news according to language for edit
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_template_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("template_id", $template_id);
			$template_arr=$this->db->get("lb_email_template_lang")->result_array();
			$all_template_arr[$i]['id']=$languages['id'];
			$all_template_arr[$i]['language_id']=$template_arr[0]['language_id'];
			$all_template_arr[$i]['template_id']=$template_arr[0]['template_id'];
			$all_template_arr[$i]['other']=$template_arr[0]['other'];
                        $all_template_arr[$i]['subject']=$template_arr[0]['subject'];
			$all_template_arr[$i]['message']=$template_arr[0]['message'];
			$all_template_arr[$i]['language_name']=$languages['language_name'];
			$all_template_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_template_arr;
	}
	
	//Getting Language independent content
	function get_unique_details($template_id)
	{
		$result=$this->db->get_where("lb_email_template", array("id"=>$template_id))->result_array();
		return $result;
	}
	
	
	//Getting All template At Once
	function get_rows($language_id, $id = 0)//Get all rows for listing template
    {
        $result = array();
        if ($id == 0) //all rows requested according to language id
        {
			$this->db->where('language_id', $language_id);
			$this->db->order_by('id');
            $query = $this->db->get('lb_email_template_lang');
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_email_template_lang');
        }
        foreach ($query->result() as $row) 
		{
			$template_id=$row->template_id;
			$template_details_arr=$this->db->get_where("lb_email_template", array("id"=>$template_id))->result_array();
			$email_type_id=$template_details_arr[0]['type_id'];
			$email_type_details=$this->db->get_where("lb_sent_mail_type_lang", array("type_id"=>$email_type_id, "language_id"=>$language_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'template_id' 			=> $row->template_id,
				'language_id' 			=> $row->language_id,
				'type' 					=> $email_type_details[0]['title'],
				'other' 				=> $row->other,
                                'subject' 				=> $row->subject,
				'message' 				=> $row->message,
				'is_active'				=> $template_details_arr[0]['is_active']
			);
        }
        return $result;
    }
	
	
	//function to Editing Template
	function template_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_template_id=$this->input->post("template_id");
		$posted_language_id=$this->input->post("language_id");
		$upd_arr=array(
			"type_id"=>$this->input->post('mail_type')
		);
		$this->db->update("lb_email_template", $upd_arr, array("id"=>$posted_template_id));
		foreach($languages_err as $language)
		{
			$subject=$this->input->post("email_subject".$language['id']);
			$other=$this->input->post("email_other");
                        $message=$this->input->post("email_message".$language['id']);
			$upd_arr_1=array(
				"other"=>$other,
                                "subject"=>$subject,
				"message"=>$message
			);
			
			$this->db->update("lb_email_template_lang", $upd_arr_1, array("language_id"=>$language['id'], "template_id"=>$posted_template_id));
		}
		return "edit_success";
	}
	
	//Function Email Type
	function get_email_type($default_language_id)
	{
		$this->db->select('*');
		$this->db->from('lb_sent_mail_type');
		$this->db->join('lb_sent_mail_type_lang', 'lb_sent_mail_type.id = lb_sent_mail_type_lang.type_id AND lb_sent_mail_type_lang.language_id='.$default_language_id);
		$result=$this->db->get()->result_array();
		return $result;
	}
	
	//Function to get all users
	function get_all_users()
	{
		$this->db->order_by("id", "asc");
		$result=$this->db->get_where("lb_users", array("status"=>"A"))->result_array();
		return $result;
	}
	
	//Function to send Email to users
	function send_email()
	{
		$posted_template_id=$this->input->post("template_id");
		$posted_users_id=$this->input->post("user_id");
		foreach($posted_users_id as $user_id)
		{
			//Getting every users details
			$get_user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
			$user_language_id=$get_user_details[0]['user_language'];
			$user_email=$get_user_details[0]['email'];
			$user_name=$get_user_details[0]['name'];
			$languages_err=$this->db->get("mast_language")->result_array();
			foreach($languages_err as $language_det)
			{
				if($user_language_id==$language_det['id'])
				{
					//getting template details
					$get_template_details=$this->db->get_where("lb_email_template_lang", array("template_id"=>$posted_template_id, "language_id"=>$user_language_id))->result_array();
					$template_message=str_replace("##", $user_name, $this->input->post('message'.$language_det['id']));
					$template_subject=$get_template_details[0]['subject'];

					
					$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
					<tr bgcolor="#222222">
					<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">'.$template_subject.'</font></b></td>
					</tr>';
					$msg_text2.='
					<tr>
						<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
					</tr>
					<tr bgcolor="#f5e8c8">
						<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
							'.$template_message.'
						</td>
					</tr>
					<tr>
						<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
						<p><b>'.lang('Regards').'</b></p>
						<p><b>La Balcons Company</b></p>
						</td>
					</tr>
					</table>';
					
					
					$subject2 = $template_subject;
					$to2 = $user_email;
					
					//Inserting data in sent mails table
					$admin_details=$this->db->get_where("mast_admin_info", array("id"=>1))->result_array();
					$insert_arr=array(
						"user_id"=>$user_id,
						"email_template_id"=>$posted_template_id,
						"sender_email"=>$admin_details[0]['email'],
						"receiver_email"=>$to2,
						"subject"=>$subject2,
						"message"=>$template_message,
						"time"=>date("Y-m-d H:i:s")
					);
					$this->db->insert("lb_sent_mails", $insert_arr);
					
					$this->load->library('email');
					$config['mailtype'] = "html";
					$this->email->initialize($config);	
					$this->email->clear();
					$this->email->from('info@les-balcons.com', 'LES BALCONS');
					$this->email->to($to2);
					$this->email->subject($subject2);
					$this->email->message($msg_text2); 
					$this->email->send();
				}
			}
		}
		return "mailsent";
	}
}
?>