<?php

/**
 * Created by PhpStorm.
 * User: HuuHien
 * Date: 5/16/2015
 * Time: 8:38 PM
 */
class Coupon extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('coupon_model');
    }
    
    public function index()
    {
        $dis = array();
        $user['email'] = $this->session->userdata('email');
        $dis['userlogin'] = (object)$this->users_model->getUser($user)[0];
        $dis['menu_reseller'] = "reseller_menu";
        $dis['view'] = "coupon/index";
        $this->view_admin($dis);
    }
    
}