<?php

/**
 * Created by PhpStorm.
 * User: HuuHien
 * Date: 5/16/2015
 * Time: 8:38 PM
 */
class Product extends Controller {
    
    public function __construct() {
        parent::__construct('reseller');
        $this->load->model('product_model');
    }
    
    public function index()
    {
        $dis = array(); 
        $dis['products'] = $this->product_model->getProduct($this->userlogin->user_id);
        $dis['view'] = "product/index";
        $this->view_admin($dis);
    }
    
    public function delete($id)
    {
        $this->product_model->delete($id);
        redirect('/Product');
    }
    
}