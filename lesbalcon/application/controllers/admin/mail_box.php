<?php
ob_start();
class mail_box extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('mail_box_model');
		$this->load->model('language_model');
		$this->load->library('pagination');
    }

	//Function for sending emails to users
	function inbox($offset=0)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if($offset=="")
		{
			$offset=0;
		}
		$limit=$this->admin_init_elements->get_pagination_limit();
		$total_records = $this->mail_box_model->get_total_inbox();
		$config['base_url'] = base_url().'admin/mail_box/inbox/';
		$config['total_rows'] = $total_records;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['num_links'] = 1;
		$config['full_tag_open'] 	= '<ul class="paginate">';
		$config['full_tag_close'] 	= '</ul>';
		$config['cur_tag_open'] 	= '<li>';
		$config['cur_tag_close'] 	= '</li>';
		$config['prev_link'] 	 = '< ';
		$config['next_link'] 	 = ' >';
		$config['first_link'] 	 = 'First';
		$config['last_link'] 	 = 'Last';
		$this->pagination->initialize($config); 
		$this->data['pagination_link']=$this->pagination->create_links();
		$this->data['total_records']=$total_records;
		$this->data['total_inbox_email']=$this->mail_box_model->get_total_inbox();;
		$this->data['total_sent_email']=$this->mail_box_model->get_total_sent_mail();
		$this->data['total_contacts']=$this->mail_box_model->get_total_contacts();
		$this->data['all_inbox_email_arr'] = $this->mail_box_model->get_all_inbox_email($limit, $offset);
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/inbox', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	function ajax_mark()
	{
		$result=$this->mail_box_model->ajax_mark($_POST['selected_value'], $_POST['status']);
		echo $result;
	}
	
	function sent_mail($offset=0)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if($offset=="")
		{
			$offset=0;
		}
		$limit=$this->admin_init_elements->get_pagination_limit();
		$total_records = $this->mail_box_model->get_total_sent_mail();
		$config['base_url'] = base_url().'admin/mail_box/sent_mail/';
		$config['total_rows'] = $total_records;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['num_links'] = 1;
		$config['full_tag_open'] 	= '<ul class="paginate">';
		$config['full_tag_close'] 	= '</ul>';
		$config['cur_tag_open'] 	= '<li>';
		$config['cur_tag_close'] 	= '</li>';
		$config['prev_link'] 	 = '< ';
		$config['next_link'] 	 = ' >';
		$config['first_link'] 	 = 'First';
		$config['last_link'] 	 = 'Last';
		$this->pagination->initialize($config); 
		$this->data['pagination_link']=$this->pagination->create_links();
		$this->data['total_records']=$total_records;
		$this->data['total_inbox_email']=$this->mail_box_model->get_total_inbox();;
		$this->data['total_sent_email']=$this->mail_box_model->get_total_sent_mail();
		$this->data['total_contacts']=$this->mail_box_model->get_total_contacts();
		$this->data['all_sent_email_arr'] = $this->mail_box_model->get_all_sent_mail($limit, $offset);
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/sent_mails', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	function ajax_delete_sent_mail()
	{
		$result=$this->mail_box_model->ajax_delete_sent_mail($_POST['selected_value']);
		echo $result;
	}
	//function to set read status to inbox email
	function ajax_set_read()
	{
		$email_id=$_POST['email_id'];
		$status=$_POST['status'];
		$this->mail_box_model->ajax_set_read($email_id, $status);
	}
	
	//function for listing contact details
	function contacts_list($offset=0)
	{
		$this->data = array();
		if($offset=="")
		{
			$offset=0;
		}
		$limit=$this->admin_init_elements->get_pagination_limit();
		$total_records = $this->mail_box_model->get_total_contacts();
		$config['base_url'] = base_url().'admin/mail_box/contacts_list/';
		$config['total_rows'] = $total_records;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['num_links'] = 1;
		$config['full_tag_open'] 	= '<ul class="paginate">';
		$config['full_tag_close'] 	= '</ul>';
		$config['cur_tag_open'] 	= '<li>';
		$config['cur_tag_close'] 	= '</li>';
		$config['prev_link'] 	 = '< ';
		$config['next_link'] 	 = ' >';
		$config['first_link'] 	 = 'First';
		$config['last_link'] 	 = 'Last';
		$this->pagination->initialize($config); 
		$this->data['pagination_link']=$this->pagination->create_links();
		$this->data['total_records']=$total_records;
		$this->data['total_inbox_email']=$this->mail_box_model->get_total_inbox();;
		$this->data['total_sent_email']=$this->mail_box_model->get_total_sent_mail();
		$this->data['total_contacts']=$this->mail_box_model->get_total_contacts();
		$this->data['all_contacts_arr'] = $this->mail_box_model->get_all_contacts($limit, $offset);
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/contacts', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	function ajax_delete_contacts()
	{
		$result=$this->mail_box_model->ajax_delete_contacts($_POST['selected_value']);
		echo $result;
	}
	
}

