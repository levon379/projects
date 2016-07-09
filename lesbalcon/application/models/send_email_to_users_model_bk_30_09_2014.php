<?php
class send_email_to_users_model extends CI_Model
{
    
	//###############################################################//
	//############### INITIALIZE CONSTRUCTOR CLASS ##################//
	//###############################################################//
	
	function  __construct() 
	{
        parent::__construct();
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
				'subject' 				=> $row->subject,
				'message' 				=> $row->message,
				'is_active'				=> $template_details_arr[0]['is_active']
			);
        }
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
			//getting template details
			$get_template_details=$this->db->get_where("lb_email_template_lang", array("template_id"=>$posted_template_id, "language_id"=>$user_language_id))->result_array();
			$template_message=str_replace("##", $user_name, $get_template_details[0]['message']);
			$template_subject=$get_template_details[0]['subject'];
			$msg_text2='<table width="90%" border="0" cellspacing="3" cellpadding="3" bgcolor="#FFFFFF">
				<tr bgcolor="#999999">
				<td colspan="2" align="center" ><b><font color="#FFFFFF">'.$template_subject.'</font></b></td>
				</tr>';
			$msg_text2.='
				<tr bgcolor="#CCCCCC">
				<td colspan="2">
					'.$template_message.
					'
				</td>
				</tr>
				<tr bgcolor="#999999">
					<td colspan="2">
					<p><b>Regards</b></p>
					<p><b>La Balcons Company</b></p>
					</td>
				</tr>';
			$msg_text2.='</table>';
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
				"time"=>date("Y-m-d h:i:s")
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
		return "mailsent";
	}
}
?>