<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function index() {
        return true;
    }

    public function createMenu() {
        $name = $this->uri->segment(1, 1);

        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('');
        $this->db->from('menu');
        $this->db->where('visible', 1);
        $this->db->order_by("sort", "asc");
        $array = $this->db->get();
        $result = $array->result_array();
        $menuString = '';
        foreach ($result as $item) {
            if ($item['link'] == $name || ($name == 1 & $item['link'] == '' )) {
                if ($item['ajax'] == 1) {
                    $menuString = $menuString . '<li class="active"><a href="#" ' . $item['ajax_action'] . '>&nbsp;' . $item['name'] . '</a></li>';
                } else {
                    $menuString = $menuString . '<li class="active"><a href="' . $this->config->item('base_url') . '' . $item['link'] . '">&nbsp;' . $item['name'] . '</a></li>';
                }
            } else {
                if ($item['ajax'] == 1) {
                    $menuString = $menuString . '<li><a href="#" ' . $item['ajax_action'] . '>&nbsp;' . $item['name'] . '</a></li>';
                } else {
                    $menuString = $menuString . '<li><a href="' . $this->config->item('base_url') . '' . $item['link'] . '">&nbsp;' . $item['name'] . '</a></li>';
                }
            }
        }
        return $menuString;
    }
}