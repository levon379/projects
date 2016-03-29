<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Controller {

    public function __construct() {
        parent::__construct('reseller');
    }

    public function index() {
        $dis = array();
        $dis['users'] = $this->users_model->getAllUser();
        $dis['view'] = "users/index";
        $this->view_admin($dis);
    }

    public function create() {
       
        if ($this->input->post()) {
            
            $this->form_validation->set_rules('first_name', 'Last Name', 'required');
            $this->form_validation->set_rules('last_name', 'Firts Name', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|max_length[12]');
            $this->form_validation->set_rules('password1', 'Password Confirmation', 'required|matches[password]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            if ($this->form_validation->run() != FALSE) {
                $registration_data = $this->input->post();
                $active = md5(now());
                $registration_data['account_type'] = 1;
                $registration_data['active'] = $active;
                $user_id = $this->users_model->signUp($registration_data, true);
                redirect('/Users/index');
            }
           
        }
        $dis['view'] = "users/create";
        $this->view_admin($dis);
    }
    
    public function delete($user_id)
    {
        if($this->users_model->delete($user_id))
        {
            redirect('/Users/index');
        }
    }

}
