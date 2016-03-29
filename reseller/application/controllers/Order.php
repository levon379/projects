<?php

/**
 * Created by PhpStorm.
 * User: HuuHien
 * Date: 5/16/2015
 * Time: 8:38 PM
 */
class Order extends Controller {
    
    public function __construct() {
        parent::__construct('reseller');
        $this->load->model('order_model');
    }
    
    public function index()
    {
        $dis = array();
        $user['email'] = $this->session->userdata('email');
        $dis['orders'] = (object)$this->order_model->getOrder();
        $dis['view'] = "order/index";
        $this->view_admin($dis);
    }
    
}