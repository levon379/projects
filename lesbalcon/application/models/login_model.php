<?php 
class login_model extends CI_Model
{
    function  __construct() 
	{
        parent::__construct();
        //load the model since it is used in almost all the functions
        $this->load->database();
    }

   // Admin authentication ----------
	function validate_admin_login()
    {
        $this->db->where('username',$this->input->post('user_name'));
        $this->db->where('password',md5($this->input->post('password')));
		//$this->db->where('id',1);
		$query = $this->db->get('mast_admin_info');
		//echo $this->db->last_query(); die();
        if($query->num_rows == 1)
        {
			$record=$query->result();
			$admin_id=$record[0]->id;  
			$user_type="admin";
			$username=$record[0]->username;
			$login_status="Y";
			$date=date("Y-m-d");
			$time=date("H:i:s");
			$ip=$_SERVER['REMOTE_ADDR']; 
			$data = Array (
							'admin_id'  =>$admin_id,
							'user_type' =>$user_type,
							'username' => $username,
							'login_status' => $login_status,
							'date' => $date,
							'time' => $time,
							'ip'=>$ip
						);
            $this->session->set_userdata($data);
			$upd_arr=array(
				"login_status"=>"Y",
				"last_login_date"=> $date." ".$time
			);
			$this->db->update("mast_admin_info", $upd_arr, array("id"=>$admin_id));
        	return $query;
        }
    }
	
	function validate_forgot_password_form()
	{
		$this->db->where('email',$this->input->post('email'));
		$query = $this->db->get('mast_admin_info');
		if($query->num_rows() > 0)
		{
			$this->SendNewPass();
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function SendNewPass()
	{
		$admin_arr=$this->db->get_where("mast_admin_info", array('id'=>1))->result_array();
		$admin_email=$admin_arr[0]['email'];
		$eml = $this->input->post('email');
		$from = 'LA BALCONS';
		$new_pass = substr(md5(date('Y-m-d H:i:s')),0,7);
		$encrypt_pass = md5($new_pass);
		$postdata = array('password' => $encrypt_pass);
		$this->db->where('email', $this->input->post('email'));
		$query = $this->db->update('mast_admin_info',$postdata);
		
		$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">	
			<tr bgcolor="#222222">
			<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">New Password From La Balcons Company</font></b></td>
			</tr>';
		$msg_text2.='
			<tr>
				<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
					<b>Dear Admin,<b><br><br>
					<b>Your New Password: </b>&nbsp;'.$new_pass.'<br><br>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
				<p><b>'.lang('Regards').'</b></p>
				<p><b>La Balcons Company</b></p>
				</td>
			</tr>
		</table>';

		$subject2 = "New Password (Les Balcons Company)";
		$to2 = $this->input->post('email');

		$this->load->library('email');
		$config['mailtype'] = "html";
		$this->email->initialize($config);	
		$this->email->clear();
		$this->email->from($admin_email, 'LA BALCONS');
		$this->email->to($to2);
		$this->email->subject($subject2);
		$this->email->message($msg_text2); 
		$this->email->send();

		return $query;
	}
	
	 //callback function for validation rule
    function is_username_valid($str)
    {
		$this->db->where('admin_user_name', $str);
		$this->db->select('admin_id');
		$query = $this->db->get('admin_login');

        if($query->num_rows()==0)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
	
	 //callback function for validation rule
    function is_email_exsist($str)
    {
		$this->db->where('contact_email', $str);
		$this->db->select('admin_id');
		$query = $this->db->get('admin_login');

        if($query->num_rows()==0)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
	
	function validate_password_recovery_form_data()
    {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_name', 'username', 'required|callback_is_username_valid');
		 $this->form_validation->set_rules('email', 'Email Id', 'required|valid_email|callback_is_email_exsist');
		if ($this->form_validation->run() == TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
    }
	
	function get_new_password()
	{
		$char = 'abcdefghijklmnopqrstABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
		$QC = strlen($char);
		$QC--;
		
		$Hash="";
		for($x=1;$x<=8;$x++)
		{
			$Posicao = rand(0,$QC);
			$Hash .= substr($char,$Posicao,1);
		}
		
		$body = '';
		$user_name = $this->input->post('user_name'); 
		$email = $this->input->post('email'); 
		$new_password = $Hash;
		
		/* ======================== fetching record ===================== */
		$this->db->where('admin_user_name',$user_name);
        $query = $this->db->get('admin_login');
		$rec = $query->row();
		$id = $rec->id;
		/* ======================== fetching record ===================== */
		
		
		/* ========================== UPDATE ============================ */
		// get the post data into an array for updating
        $postdata = array(
            			'admin_password ' => md5($new_password)
        				);
        $this->db->where('admin_id',$id);
        $this->db->update('admin_login',$postdata);
		/* ========================== UPDATE ============================ */
		
		
		
		/* ======================== mailing  record ===================== */
		$body = '
				<div style="background:url(http://projectsindev.com/projects/Anita_ezyoga/assets/images/mid-main-bg.png) repeat-y center; min-height:400px; background-color:#ABC9D5">
		<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="padding-top:20px; padding-bottom:20px;">
		  <tr>
			<td align="center" valign="top">
			
			<img src="http://projectsindev.com/projects/Anita_ezyoga/assets/images/logo.png" border="0" alt="ILEX" title="ILEX" />
			
			</td>
		  </tr>
		  
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;">
			Dear Admin,<br />
		   <strong> Admin Panel Login credentials are as follows:</strong></td>
		  </tr>
		  
		  <tr>
			<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;">&nbsp;	</td>
		  </tr>
		  
			<tr>
			<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;">
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#61B0F3">
		  <tr>
			<td>
			
			<table width="100%" border="0" cellspacing="1" cellpadding="4">
		  <tr>
			<td width="25%" align="left" valign="top" bgcolor="#F98007" style="color:#FFFFFF;"><strong>Username :</strong></td>
			<td align="left" valign="top" bgcolor="#FFFFFF">'.$user_name.'</td>
		  </tr>
		  <tr>
			<td width="25%" align="left" valign="top" bgcolor="#F98007" style="color:#FFFFFF;"><strong>Password :</strong></td>
			<td align="left" valign="top" bgcolor="#FFFFFF">'.$new_password.'</td>
		  </tr>
		  <tr>
			<td width="25%" align="left" valign="top" bgcolor="#F98007">&nbsp;</td>
			<td align="left" valign="top" bgcolor="#FFFFFF"><a href="http://projectsindev.com/projects/Anita_ezyoga/admin" target="_blank" style="color:#4191D3; text-decoration:none;">http://projectsindev.com/projects/Anita_ezyoga/admin</a></td>
		  </tr>
		</table>	</td>
		  </tr>
		</table>   </td>
		  </tr>
		  
		  
			<tr>
			  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;">&nbsp;</td>
			</tr>
			<tr>
			<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;">With kind regards :<br />
		<strong>Your ILEX Team	</strong></td>
		  </tr>
		</table>
		</div>
		';
		
		
		$this->load->library('email');
		// Admin mail
		$this->email->from('info@admin.com', 'Generate new password');
		$this->email->to($email);
		$this->email->subject('Password recovery .');
		$this->email->message($body);
		//$this->email->send();
		//echo $this->email->print_debugger();
		/* ======================== mailing  record ===================== */
		return 'OK';
	}
	
	function update_logout()
	{
		$date=date("Y-m-d");
		$time=date("H:i:s");
		$upd_arr=array(
			"last_logout_date"=>$date." ".$time,
			"login_status"=>"N"
		);
		$this->db->update("mast_admin_info", $upd_arr, array("id"=>$this->session->userdata('user_id')));
	}
}
?>