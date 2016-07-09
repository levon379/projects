<?php
ob_start();

require_once('html2pdf/html2pdf.class.php');
class send_email_to_users extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('send_email_to_users_model');
		$this->load->model('language_model');
    }

	//Function for sending emails to users
	function index()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
					
			$msg_text2 =  $this->send_email_to_users_model->send_invoice($this->input->post('txt_res_id'));	
			
			$html2pdf = new HTML2PDF('P','A4','En');
		    $html2pdf->WriteHTML($msg_text2);
		    $html2pdf->Output('assets/upload/Invoice/'.$this->input->post('txt_res_id').'.pdf', 'F');

			$result = $this->send_email_to_users_model->send_email();
			
			//$response_result = 
                        //print_r($result);
			if($result)//$result == "mailsent"
			{
				redirect('admin/send_email_to_users?mailsent=true');
			}
		}

		/* if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != 'mailsent'){
			$this->data['selected_user'] = $this->send_email_to_users_model->get_selected_user($_SERVER['QUERY_STRING']);
		} */
		
		if(isset($_GET['mailsent']) && !$_GET['mailsent'] != "true"){
			$this->data['selected_user'] = $this->send_email_to_users_model->get_selected_user($_SERVER['QUERY_STRING']);
		}

		$this->data['all_users_arr'] = $this->send_email_to_users_model->get_all_users();
		$this->data['template_arr']=$this->send_email_to_users_model->get_rows($default_language_id);
		$this->data['documents_arr']=$this->send_email_to_users_model->get_all_documents($default_language_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/send_email_to_users', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function to get content with ckeditor
	function get_content()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$template_id=$_POST['template_id'];
		$content=$this->send_email_to_users_model->get_content($default_language_id, $template_id);
		echo $content;
		 
	}
	
}

