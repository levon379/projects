<?php

class Product_model extends CI_Model {

    var $warbble_db = '';

    public function __construct() {
        parent::__construct();
        $this->warbble_db = $this->load->database('warbble', true);
    }

    public function getProduct($reseller_id) {
        $this->warbble_db->select();
        $this->warbble_db->from('products');
        $this->warbble_db->where('reseller_id', $reseller_id);
        $query = $this->warbble_db->get();
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->result_array();
    }

    public function delete($id) {
        $data = array('reseller_id' => 0);
        $this->warbble_db->where('id', $id);
        $this->warbble_db->update('products', $data);
    }

}
