<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends MX_Controller {

    public function index() {
        $this->load->model('authmodel');
        $this->authmodel->chekauth();
        return true;
    }

    public function getCSRF() {
        $str = '<input type="hidden" name="' . $this->security->get_csrf_token_name() . '" value="' . $this->security->get_csrf_hash() . '" />';
        return $str;
    }
    
}