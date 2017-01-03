<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Newpost extends MX_Controller {

    public function _this() {
        $this->index();
    }

    public function index() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'trim|required||max_length[500]|xss_clean');
        $this->form_validation->set_rules('comment_field', 'Analysis description', 'trim|required|max_length[5000]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('msg', $errors);
            $this->session->set_flashdata('inputRows', $this->input->post());
            redirect($this->config->item('base_url'));
            } else {
                $data = $_POST;
                $this->load->model('newpostmodel');
                $this->newpostmodel->insertNewThread($data);             
            }
        }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */