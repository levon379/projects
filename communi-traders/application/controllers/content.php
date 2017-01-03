<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends MX_Controller {

	public function index()
	{
            $this->load->model('mainmodel');
            $this->mysmarty->view('content_top');
            $data = $this->mainmodel->_build_sub_blocks("content");
            foreach ($data->result_array() as $row) {
                $this->load->module($row['name']);
                $this->name = new $row['name'];
                $this->name->index();
            }
            $this->mysmarty->view('content_bottom');
            return true;
 	}       
}               
/* End of file main.php */
/* Location: ./application/controllers/main.php */