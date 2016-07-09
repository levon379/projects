<?php
ob_start();
class gallery extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('public_init_elements');
		$this->public_init_elements->init_elements();

		$this->load->model('language_model');
		$this->load->model('gallery_model');
		$this->load->library('pagination');
    }

    function index($offset="")
	{ echo "nnn"; die;
		$this->data = array();
		if($offset=="")
		{
			$offset=0;
		}
		$limit=9;
		$total_records = $this->gallery_model->get_total_active_gallery();
		$config['base_url'] = base_url().'gallery';
		$config['total_rows'] = $total_records;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 2;
		$config['num_links'] = 1;
		$config['full_tag_open'] 	= '<ul class="page">';
		$config['full_tag_close'] 	= '</ul>';
		$config['cur_tag_open'] 	= '<li><a class="active">';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['prev_link'] 	 = '< ';
		$config['next_link'] 	 = ' >';
		$config['first_link'] 	 = 'First';
		$config['last_link'] 	 = 'Last';
		$this->pagination->initialize($config); 
		$this->data['pagination_link']=$this->pagination->create_links();

		//$this->load->view('maincontents/home', $this->data);
		$this->data['gallery']=$this->gallery_model->get_rows_for_front_end($limit, $offset);
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/gallery', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
    }

}

