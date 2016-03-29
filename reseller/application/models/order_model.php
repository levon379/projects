<?php

class Order_model extends CI_Model {
    
    var $warbble_db = '';

    public function __construct() {
        parent::__construct();
        $this->warbble_db = $this->load->database('warbble', true);
    }

    public function getOrder() {
       
    }

    public function delete($id) {
       
    }
    
    
    
}