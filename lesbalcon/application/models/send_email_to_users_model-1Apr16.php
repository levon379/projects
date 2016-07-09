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
                                'other' 				=> $row->other,
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
	
	//function to get all documents for attachment
	function get_all_documents($language_id)
	{
		$this->db->select('*');
		$this->db->from('mast_documents');
		$this->db->order_by('mast_documents.id', 'asc');
		$this->db->join('mast_documents_lang', 'mast_documents.id = mast_documents_lang.document_id AND mast_documents.is_active = "Y" AND mast_documents_lang.language_id='.$language_id);
		$document_arr = $this->db->get()->result_array();
		return $document_arr;
	}
	
	function get_content($language_id, $template_id)
	{
	    require('assets/admin/ckeditor/ckeditor.php');
		require('assets/admin/ckfinder/ckfinder.php');
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
			if($template_id==0)//If template is new
			{
				$all_template_arr[$i]['id']=$languages['id'];
				$all_template_arr[$i]['language_id']=$languages['id'];
				$all_template_arr[$i]['template_id']=$template_id;
				$all_template_arr[$i]['subject']='';
				$all_template_arr[$i]['message']='';
				$all_template_arr[$i]['language_name']=$languages['language_name'];
				$all_template_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			}
			else 
			{
				$this->db->where("language_id", $languages['id']);
				$this->db->where("template_id", $template_id);
				$template_arr=$this->db->get("lb_email_template_lang")->result_array();
				$all_template_arr[$i]['id']=$languages['id'];
				$all_template_arr[$i]['language_id']=$template_arr[0]['language_id'];
				$all_template_arr[$i]['template_id']=$template_arr[0]['template_id'];
				$all_template_arr[$i]['subject']=$template_arr[0]['subject'];
				$all_template_arr[$i]['message']=$template_arr[0]['message'];
				$all_template_arr[$i]['language_name']=$languages['language_name'];
				$all_template_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			}
			$i++;
		}
		$language_id_arr=array();
		foreach($all_template_arr as $language)
		{
			array_push($language_id_arr, $language['id']);
			?>
			<div class="horizontal_div">
				<a style="cursor:pointer;" onclick="display_div('div_<?php echo $language['id']; ?>')">
				<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>">
				Edit Content for <?php echo $language['language_name']; ?>
				</a>
			</div>
			<div id="div_<?php echo $language['id']; ?>">
				<input type="hidden" id="hidden_subject<?php echo $language['id']; ?>" name="hidden_subject<?php echo $language['id']; ?>" value="<?php echo $language['subject']; ?>">
				<div class="form-group">
					<label for="exampleInputPassword1">SUBJECT<span style="color:red">*</span></label>
					<input type="text" name="subject<?php echo $language['id'] ?>" id="subject<?php echo $language['id'] ?>" class="form-control" value="<?php echo $language['subject']; ?>">
					<div class="form-group has-error" id="subject_error<?php echo $language['id']; ?>" style="display:none;">
						<label class="control-label" for="inputError">
						<i class="fa fa-times-circle-o"> Subject is required</i>
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">EMAIL MESSAGE<span style="color:red">*</span></label>
					<?php								
						$basePathUrl=base_url()."assets/admin";
						$CKEditor = new CKEditor();
						$CKEditor->basePath = base_url().'assets/admin/ckeditor/';
						$CKEditor->config['height'] = 200;
						$CKEditor->config['width'] = '100%';
						$CKEditor->config['uiColor'] = "#E4ECEF";
							
						$CKEditor->config['filebrowserBrowseUrl'] = $basePathUrl."/ckfinder/ckfinder.html";
						$CKEditor->config['filebrowserImageBrowseUrl'] = $basePathUrl."/ckfinder/ckfinder.html?Type=Images";
						$CKEditor->config['filebrowserFlashBrowseUrl'] = $basePathUrl."/ckfinder/ckfinder.html?Type=Flash";
						$CKEditor->config['filebrowserUploadUrl'] = $basePathUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files";
						$CKEditor->config['filebrowserImageUploadUrl'] = $basePathUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images";
						$CKEditor->config['filebrowserFlashUploadUrl'] = $basePathUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash";
				
						$CKEditor->returnOutput = true;
						$code = $CKEditor->editor("message".$language['id'], $language['message']);
						echo $code;
					?>
					<div class="form-group has-error" id="message_error<?php echo $language['id']; ?>" style="display:none;">
						<label class="control-label" for="inputError">
						<i class="fa fa-times-circle-o"> Email message is required</i>
						</label>
					</div>
				</div>
			</div>
			<?php 
		}
		?>
		<input type="hidden" value="<?php echo implode("^", $language_id_arr); ?>" name="language_id_arr" id="language_id_arr">
		<?php
	}
	
	function send_email()
	{
		$res_id = $this->input->post('txt_res_id');
		$reservation_details=$this->db->get_where("lb_reservation", array("id"=>$res_id))->result_array();

		$posted_template_id=$this->input->post("template_id");
		$posted_users_id=$this->input->post("user_id");
		if($posted_users_id == '') $posted_users_id[0] = $reservation_details[0]['user_id'];

		$msg_text2=$attach_file_name_1="";
                $attach_file_name_2="";
                $attach_file_name_3="";
                $fileAttachments=array();
		if($_FILES["attachment_file_1"]['name']!="")
		{
			$fileAttachments[]=$attach_file_name_1=time()."_".str_replace(" ", "_", $_FILES["attachment_file_1"]['name']);
			$config1['file_name'] =$attach_file_name_1;
			$config1['upload_path'] = "assets/upload/documents/";
			$config1['allowed_types'] = "gif|jpg|jpeg|png|doc|docx|pdf|csv|xls|xlsx";
			$config1['max_size'] = '1000000';
			$this->load->library('upload', $config1);
			$this->upload->initialize($config1);
			if (!$this->upload->do_upload('attachment_file_1'))
			{
				return $this->upload->display_errors();
			}
		}
                if($_FILES["attachment_file_2"]['name']!="")
		{
			$fileAttachments[]=$attach_file_name_2=time()."_".str_replace(" ", "_", $_FILES["attachment_file_2"]['name']);
			$config2['file_name'] =$attach_file_name_2;
			$config2['upload_path'] = "assets/upload/documents/";
			$config2['allowed_types'] = "gif|jpg|jpeg|png|doc|docx|pdf|csv|xls|xlsx";
			$config2['max_size'] = '1000000';
			$this->load->library('upload', $config2);
			$this->upload->initialize($config2);
			if (!$this->upload->do_upload('attachment_file_2'))
			{
				return $this->upload->display_errors();
			}
		}
                if($_FILES["attachment_file_3"]['name']!="")
		{
			$fileAttachments[]=$attach_file_name_3=time()."_".str_replace(" ", "_", $_FILES["attachment_file_3"]['name']);
			$config3['file_name'] =$attach_file_name_3;
			$config3['upload_path'] = "assets/upload/documents/";
			$config3['allowed_types'] = "gif|jpg|jpeg|png|doc|docx|pdf|csv|xls|xlsx";
			$config3['max_size'] = '1000000';
			$this->load->library('upload', $config3);
			$this->upload->initialize($config3);
			if (!$this->upload->do_upload('attachment_file_3'))
			{
				return $this->upload->display_errors();
			}
		}
	
		foreach($posted_users_id as $user_id)
		{
			//Getting every users details
			$get_user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
			$user_language_id=$get_user_details[0]['user_language'];
			$user_email=$get_user_details[0]['email'];
			$user_name=$get_user_details[0]['name'];
			//getting template details
			$languages_err=$this->db->get("mast_language")->result_array();
			foreach($languages_err as $language_det)
			{
				if($user_language_id==$language_det['id'])
				{
					$template_message=str_replace("##", $user_name, $this->input->post('message'.$language_det['id']));
					$template_subject=$this->input->post('subject'.$language_det['id']);
					$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
					<tr bgcolor="#222222">
					<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">'.$template_subject.'</font></b></td>
					</tr>';
					$msg_text2.='
					<tr>
						<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
					</tr>
					<tr>
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
					
					if($this->input->post("attachment_dropdown")!="")
					{
						$this->db->select('*');
						$this->db->from('mast_documents');
						$this->db->order_by('mast_documents.id', 'asc');
						$this->db->join('mast_documents_lang', 'mast_documents.id = mast_documents_lang.document_id AND mast_documents.id='.$this->input->post("attachment_dropdown").' AND mast_documents_lang.language_id='.$user_language_id);
						$document_arr = $this->db->get()->result_array();
						$attach_file_name=$document_arr[0]['document_file'];
						//echo '<pre>';print_r($document_arr);
					}
					
					if($this->input->post("attachment_dropdown2")!="")
					{
						$this->db->select('*');
						$this->db->from('mast_documents');
						$this->db->order_by('mast_documents.id', 'asc');
						$this->db->join('mast_documents_lang', 'mast_documents.id = mast_documents_lang.document_id AND mast_documents.id='.$this->input->post("attachment_dropdown2").' AND mast_documents_lang.language_id='.$user_language_id);
						$document_arr = $this->db->get()->result_array();
						$attach_file_name2=$document_arr[0]['document_file'];
						//echo '<pre>';print_r($document_arr);
					}
					
					if($this->input->post("attachment_dropdown3")!="")
					{
						$this->db->select('*');
						$this->db->from('mast_documents');
						$this->db->order_by('mast_documents.id', 'asc');
						$this->db->join('mast_documents_lang', 'mast_documents.id = mast_documents_lang.document_id AND mast_documents.id='.$this->input->post("attachment_dropdown3").' AND mast_documents_lang.language_id='.$user_language_id);
						$document_arr = $this->db->get()->result_array();
						$attach_file_name3=$document_arr[0]['document_file'];
						//echo '<pre>';print_r($document_arr);
					}
					/*$fileexist =  dirname(dirname(dirname(__FILE__))).'/assets/upload/documents/1456932872_1_A)Credit-Card-procedure-Balcons-2016.doc';
					if (file_exists($fileexist)) {
							echo 'yes';
					}
					exit;*/
					//Inserting data in sent mails table
					$admin_details=$this->db->get_where("mast_admin_info", array("id"=>1))->result_array();
					$insert_arr=array(
						"user_id"=>$user_id,
						"email_template_id"=>$posted_template_id,
						"sender_email"=>$admin_details[0]['email'],
						"receiver_email"=>$to2,
						"subject"=>$subject2,
						"message"=>$template_message,
                                                "attachments"=>  json_encode($fileAttachments),
						"time"=>date("Y-m-d H:i:s")
					);
					$this->db->insert("lb_sent_mails", $insert_arr);

					$this->load->library('email');
					$config['mailtype'] = "html";
					$this->email->initialize($config);	
					$this->email->clear();
					$this->email->from('info@les-balcons.com', 'LES BALCONS');
					$this->email->to($to2); 
					//$this->email->to('ankitakhare0@gmail.com');
                    //$this->email->to('vivekjain197@gmail.com');
					//$this->email->to('j.willemin@caribwebservices.com');
					
					$this->email->subject($subject2);
					$this->email->message($msg_text2); 
					if($attach_file_name!="")
					{
						//$this->email->attach('assets/upload/documents/'.$attach_file_name);
						if (file_exists(dirname(dirname(dirname(__FILE__))).'/assets/upload/documents/'.$attach_file_name)) {
							$this->email->attach(dirname(dirname(dirname(__FILE__))).'/assets/upload/documents/'.$attach_file_name);
						}
						
					}
					if($attach_file_name2!="")
					{
						//$this->email->attach('assets/upload/documents/'.$attach_file_name2);
						if (file_exists(dirname(dirname(dirname(__FILE__))).'/assets/upload/documents/'.$attach_file_name2)) {
							$this->email->attach(dirname(dirname(dirname(__FILE__))).'/assets/upload/documents/'.$attach_file_name2);
						}
					}
					if($attach_file_name3!="")
					{
						//$this->email->attach('assets/upload/documents/'.$attach_file_name3);
						if (file_exists(dirname(dirname(dirname(__FILE__))).'/assets/upload/documents/'.$attach_file_name3)) {
							$this->email->attach(dirname(dirname(dirname(__FILE__))).'/assets/upload/documents/'.$attach_file_name3);
						}
					}
                    if($attach_file_name_1!="")
					{
						$this->email->attach('assets/upload/documents/'.$attach_file_name_1);
					}
                    if($attach_file_name_2!="")
					{
						$this->email->attach('assets/upload/documents/'.$attach_file_name_2);
					}
                    if($attach_file_name_3!="")
					{
						$this->email->attach('assets/upload/documents/'.$attach_file_name_3);
					}
					if($res_id != ''){
						$this->email->attach('assets/upload/Invoice/'.$res_id.'.pdf');
					}

					$this->email->send();
				}
			}	
		}
		return "mailsent";
	}
		//function for getting user details
	function get_user_details($user_id)
	{
		$result=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		return $result;
	}
	
	//function to send invoice from calendar
	function send_invoice($reservation_id)
	{
		$parent_info=$this->db->get_where("lb_reservation", array("parent_id"=>$reservation_id))->result_array();
		if(count($parent_info)>0) //If invoice is not available
		{
			$msg_text2 =  $this->send_invoice_multi($reservation_id);	
		}else{
			$msg_text2 =  $this->send_invoice_single($reservation_id);	
		}	
		return $msg_text2;
	}	

	function get_selected_user($res_id){
		$reservation_details=$this->db->get_where("lb_reservation", array("id"=>$res_id))->result_array();

		$get_user_details=$this->db->get_where("lb_users", array("id"=>$reservation_details[0]['user_id']))->result_array();
		$user_email=$get_user_details[0]['email'];
		$user_name=$get_user_details[0]['name'];
		
		$val = $user_name." < ".$user_email." >";
		return $val;
	}

	function send_invoice_single($reservation_id){
		$reservation_details=$this->db->get_where("lb_reservation", array("id"=>$reservation_id))->result_array();

		$user_id=$reservation_details[0]['user_id'];
		$user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		$default_language_id=$user_details[0]['user_language'];//user belongs to which language

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
		$invoice_comments_arr = str_split($reservation_details[0]['invoice_comments'], 100);
		$invoice_comments = implode("<br/>", $invoice_comments_arr);

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
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Night:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$accommodation.'Night(s)</td>
				</tr>
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Bungalow Rate:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.$bungalow_rate.'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of Adults: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_adult'].'</td>
				</tr>';

				if($reservation_details[0]['no_of_extra_real_adult'] > 0){
					$msg_text2.='<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of extra person from 12yo: </b></td>
						<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_extra_real_adult'].'</td>
					</tr>';
				} if($reservation_details[0]['no_of_extra_adult'] > 0){ 
					$msg_text2.='<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of extra person from 6yo: </b></td>
						<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_extra_adult'].'</td>
					</tr>';
				} if($reservation_details[0]['no_of_extra_kid'] > 0){ 
					$msg_text2.='<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of extra person from 2 to 5yo: </b></td>
						<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_extra_kid'].'</td>
					</tr>';
				} if($reservation_details[0]['no_of_folding_bed_kid'] > 0){ 
					$msg_text2.='<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of folding bed from 2 to 5yo: </b></td>
						<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_folding_bed_kid'].'</td>
					</tr>';
				} if($reservation_details[0]['no_of_folding_bed_adult'] > 0){ 
					$msg_text2.='<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of folding bed from 6 to 12 yo: </b></td>
						<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_folding_bed_adult'].'</td>
					</tr>';
				} if($reservation_details[0]['no_of_baby_bed'] > 0){ 
					$msg_text2.='<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of Babies less than 2yo: </b></td>
						<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_details[0]['no_of_baby_bed'].'</td>
					</tr>';
				}

				$msg_text2.='
				<tr  bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Discount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">4%</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax Rate: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.number_format($reservation_details[0]["amount_to_be_paid"] * 4/100, 2, '.', ',').'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Amount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.$reservation_details[0]["amount_to_be_paid"].'</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Paid Amount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.$reservation_details[0]["paid_amount"].'</td>
				</tr>								
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Due Amount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.$reservation_details[0]["due_amount"].'</td>
				</tr>								
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Comments:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_comments.'</td>
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
			<tr><td width="200"></td><td width="450"></td></tr>
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
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nom du client: </b></td><td style="width:450px; border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$user_details[0]['name'].'</td>
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
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total du taxe: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.number_format($reservation_details[0]["amount_to_be_paid"] * 4/100, 2, '.', ',').'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total du séjour:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.$reservation_details[0]["amount_to_be_paid"].'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Acompte payé:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.$reservation_details[0]["paid_amount"].'</td>
			</tr>								
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant dû:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$default_currency.$reservation_details[0]["due_amount"].'</td>
			</tr>								
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Commentaires:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$invoice_comments.'</td>
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
		return $msg_text2;
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

		$bungalow_rate=ceil($reservation_details[0]['amount_to_be_paid'] - ($reservation_details[0]['amount_to_be_paid'] * 4/100));		
		$accommodation=ceil(abs(strtotime($reservation_details[0]['leave_date']) - strtotime($reservation_details[0]['arrival_date'])) / 86400);

		$discount = ($reservation_details[0]['discount'] != "")?$reservation_details[0]['discount']:"0";		
		
		$default_currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		$default_currency=$default_currency_arr[0]['currency_symbol'];


		//Sending email to users
		$amount_to_be_paid = $reservation_details[0]["amount_to_be_paid"];
		$paid_amount = $reservation_details[0]["paid_amount"];
		$due_amount = $reservation_details[0]["due_amount"];
		$invoice_comments = $reservation_details[0]["invoice_comments"];
		
		if($default_language_id==1)//If user language is french
		{
			$msg_text2='<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
				<tr bgcolor="#222222">
				<td colspan="6" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">INVOICE</font></b></td>
				</tr>';
			$msg_text2.='
				<tr>
					<td colspan="6" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
				</tr>
				<tr>
					<td colspan="6" style="border-top:1px solid #C9AD64; padding:5px;">
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
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb.<br/>Child(ren)</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb.<br/>Baby</td>
				</tr>';
				$msg_text2.='
				<tr>
					<td colspan="6"><b>'.$bunglow_name.'</b></td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b, %A %d, %Y", strtotime($reservation_details[0]['arrival_date'])).'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b, %A %d, %Y", strtotime($reservation_details[0]['leave_date'])).'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.$default_currency.$bungalow_rate.'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_adult'].'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">0</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">0</td>
				</tr>
				<tr>
					<td colspan="6"><b>Total Amount: </b>'.$default_currency.$reservation_details[0]['amount_to_be_paid'].', <b>Paid Amount: </b>'.$default_currency.$reservation_details[0]['paid_amount'].', <b>Due Amount: </b>'.$default_currency.$reservation_details[0]['due_amount'].'</td>
				</tr>';
			$parent_info=$this->db->get_where("lb_reservation", array("parent_id"=>$reservation_id))->result_array();
			//print_r($parent_info);
			if(count($parent_info)>0) //If invoice is not available
			{
				foreach ($parent_info as $parent_details) {
					$parent_bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$parent_details["bunglow_id"], "language_id"=>"2"))->result_array();
					$parent_bungalow_rate=ceil($parent_details['amount_to_be_paid'] - ($parent_details['amount_to_be_paid'] * 4/100));			
					
					$amount_to_be_paid = (double)($parent_details['amount_to_be_paid'] + $amount_to_be_paid);
					$paid_amount = (double)($parent_details['paid_amount'] + $paid_amount);
					$due_amount = (double)($parent_details['due_amount'] + $due_amount);
					$invoice_comments .= "<br/>".$parent_details['invoice_comments'];

					$parent_bungalow_name_part = explode("<span>", $parent_bungalow_details[0]['bunglow_name']);
					$parent_bunglow_name = $parent_bungalow_name_part[0];

					$msg_text2.='<tr>
						<td colspan="6">&nbsp;</td>
					</tr>				
					<tr>
						<td colspan="6"><b>'.$parent_bunglow_name.'</b></td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b, %A %d, %Y", strtotime($parent_details['arrival_date'])).'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b, %A %d, %Y", strtotime($parent_details['leave_date'])).'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$default_currency.$parent_bungalow_rate.'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">0</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">0</td>
					</tr>
					<tr>
						<td colspan="6"><b>Total Amount: </b>'.$default_currency.$parent_details['amount_to_be_paid'].', <b>Paid Amount: </b>'.$default_currency.$parent_details['paid_amount'].', <b>Due Amount: </b>'.$default_currency.$parent_details['due_amount'].'</td>
					</tr>';
				}
			}
			$msg_text2.='<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6" align="center">
						<b>Tax: </b>4%<br/>
						<b>Tax Rate: </b>'.$default_currency.number_format($amount_to_be_paid * 4/100, 2, '.', ',').'<br/>
						<b>Total Amount: </b>'.$default_currency.$amount_to_be_paid.'<br/>
						<b>Paid Amount: </b>'.$default_currency.$paid_amount.'<br/>
						<b>Due Amount: </b>'.$default_currency.$due_amount.'<br/>
					</td>
				</tr>
				';
			if($amount_to_be_paid == $due_amount){
				$msg_text2.='
				<tr><td colspan="6" align="center"><b>*Your booking will be confirmed once payment has been completed.</b></td></tr>';
			}
			$msg_text2.='
				<tr><td colspan="6">
				<span style="border:1px solid; padding:3px;"><b>'.lang("User_Comments")."</b><br/>".$invoice_comments.'</span>
				</td></tr>
				';
				
			
			if($amount_to_be_paid == $paid_amount){
				$msg_text2.='
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;" colspan="6"><b>
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
				<td colspan="6" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">FACTURE</font></b></td>
				</tr>';
			$msg_text2.='
				<tr>
					<td colspan="6" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
				</tr>
				<tr>
					<td colspan="6" style="border-top:1px solid #C9AD64; padding:5px;">
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
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb.<br/>Enfant(s)</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">Nb.<br/>Baby</td>
				</tr>';
				$msg_text2.='
				<tr>
					<td colspan="6"><b>'.$bunglow_name.'</b></td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b, %A %d, %Y", strtotime($reservation_details[0]['arrival_date'])).'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b, %A %d, %Y", strtotime($reservation_details[0]['leave_date'])).'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.$default_currency.$bungalow_rate.'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">'.$reservation_details[0]['no_of_adult'].'</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">0</td>
					<td style="border-top:1px solid #C9AD64; padding:5px;">0</td>
				</tr>
				<tr>
					<td colspan="6"><b>Total du sejour: </b>'.$default_currency.$reservation_details[0]['amount_to_be_paid'].', <b>Acompte paye: </b>'.$default_currency.$reservation_details[0]['paid_amount'].', <b>Montant du: </b>'.$default_currency.$reservation_details[0]['due_amount'].'</td>
				</tr>';
			$parent_info=$this->db->get_where("lb_reservation", array("parent_id"=>$reservation_id))->result_array();
			//print_r($parent_info);
			if(count($parent_info)>0) //If invoice is not available
			{
				foreach ($parent_info as $parent_details) {
					$parent_bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$parent_details["bunglow_id"], "language_id"=>"2"))->result_array();
					$parent_bungalow_rate=ceil($parent_details['amount_to_be_paid'] - ($parent_details['amount_to_be_paid'] * 4/100));			
					
					$amount_to_be_paid = (double)($parent_details['amount_to_be_paid'] + $amount_to_be_paid);
					$paid_amount = (double)($parent_details['paid_amount'] + $paid_amount);
					$due_amount = (double)($parent_details['due_amount'] + $due_amount);
					$invoice_comments .= "<br/>".$parent_details['invoice_comments'];

					$parent_bungalow_name_part = explode("<span>", $parent_bungalow_details[0]['bunglow_name']);
					$parent_bunglow_name = $parent_bungalow_name_part[0];

					$msg_text2.='<tr>
						<td colspan="6">&nbsp;</td>
					</tr>				
					<tr>
						<td colspan="6"><b>'.$parent_bunglow_name.'</b></td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b, %A %d, %Y", strtotime($parent_details['arrival_date'])).'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.strftime ("%b, %A %d, %Y", strtotime($parent_details['leave_date'])).'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$default_currency.$parent_bungalow_rate.'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">'.$parent_details['no_of_adult'].'</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">0</td>
						<td style="border-top:1px solid #C9AD64; padding:5px;">0</td>
					</tr>
					<tr>
						<td colspan="6"><b>Total du sejour: </b>'.$default_currency.$parent_details['amount_to_be_paid'].', <b>Acompte paye: </b>'.$default_currency.$parent_details['paid_amount'].', <b>Montant du: </b>'.$default_currency.$parent_details['due_amount'].'</td>
					</tr>';
				}
			}
			$msg_text2.='<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6" align="center">
						<b>Taxe: </b>4%<br/>
						<b>Total du taxe: </b>'.$default_currency.number_format($amount_to_be_paid * 4/100, 2, '.', ',').'<br/>
						<b>Total du sejour: </b>'.$default_currency.$amount_to_be_paid.'<br/>
						<b>Acompte paye: </b>'.$default_currency.$paid_amount.'<br/>
						<b>Montant du: </b>'.$default_currency.$due_amount.'<br/>
					</td>
				</tr>
				';
			if($amount_to_be_paid == $due_amount){
				$msg_text2.='
				<tr><td colspan="6" align="center"><b>*Votre reservation ne sera confirme qu`un fois le payement de l`acompte.</b></td></tr>';
			}
			$msg_text2.='
				<tr><td colspan="6">
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
		return $msg_text2; 
	}	
}
