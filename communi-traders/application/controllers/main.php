<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MX_Controller {

	public function index()
	{
            ob_start();
			
            $this->session->unset_userdata('game_id');
            $this->session->unset_userdata('symbol');
            $this->load->model('mainmodel');
            $this->mysmarty->assign('url', $this->config->item('base_url'));
            $this->mysmarty->assign('uri', $this->uri->uri_string());
			
            if (preg_match("/edit/", $this->uri->uri_string())) {
                $this->mysmarty->assign('is_draw', 1);
            }
            else {
                $this->mysmarty->assign('is_draw', 0);
            }
            $data = $this->mainmodel->_build_blocks(1);
			
            foreach ($data->result_array() as $row) {
	
                $this->load->module($row['name']);
				
                $this->name = new $row['name'];

                $this->name->index(); //sadfsdf

            }
			
            ob_end_flush();
	}      
}
/* End of file main.php */
/* Location: ./application/controllers/main.php */
