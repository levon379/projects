<?php
ob_start();
class news extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model('news_model');
		$this->load->model('language_model');
    }

	//Function for list news page
    function list_news($lang_id)
	{ 
        $this->data = array();
		$language_id = $lang_id;
        $this->data['error_message'] = "";
		$this->data['all_rows'] = $this->news_model->get_rows($language_id);
		$this->data['language_arr'] = $this->language_model->get_rows();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/news_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	//function for adding news
	function news_add()
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
	
		if ($this->input->post('save'))
		{
			$result = $this->news_model->news_add();
			if($result == "add_success")
			{
				redirect('admin/news/list_news/'.$default_language_id.'?inserted');
			}
		}

		$this->data['language_arr'] = $this->language_model->get_rows();
        //Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/news_add', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function for editing news
	function news_edit($language_id, $news_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->data = array();
		if ($this->input->post('save'))
		{
			$posted_language_id=$this->input->post("language_id");
			$posted_banner_id=$this->input->post("news_id");
			$result = $this->news_model->news_edit();	
			if($result == "edit_success")
			{
				redirect('admin/news/list_news/'.$default_language_id.'?updated');
			}
		}
		
		$this->data['language_arr'] = $this->language_model->get_rows();
		$this->data['edit_language_id']=$language_id;
		$this->data['news_arr']=$this->news_model->get_news($language_id, $news_id);
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/news_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//function to inactivate news
	function inactive($news_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->news_model->inactive($news_id);
		redirect('admin/news/list_news/'.$default_language_id);
	}
	
	//function to activate news
	function active($news_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->news_model->active($news_id);
		redirect('admin/news/list_news/'.$default_language_id);
	}
	
	
	//function to set news as featured
	function set_featured($news_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->news_model->set_featured($news_id);
		redirect('admin/news/list_news/'.$default_language_id);
	}
	
	
	//function to delete news
	function delete($news_id)
	{
		$default_language_id=$this->language_model->get_default_language_id();
		$this->news_model->delete($news_id);
		redirect('admin/news/list_news/'.$default_language_id.'?deleted');
	}
}

