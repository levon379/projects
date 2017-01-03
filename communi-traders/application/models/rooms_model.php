<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rooms_model extends CI_Model {

    public function index() {
        return true;
    }

    /**
     * @desc Function  get_rooms_list
     * @return array
     */
    public function get_rooms_list() {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('forum_rooms');
        $result = $this->db->get();
        $rowsOption = $result->result_array();
        $i = 0;
        $data = array();
        foreach ($rowsOption as $value) {
	    if (!isset($value['default_room'])) $value['default_room'] = 0;
            $data[$i] = $value['forumid'];
            $i++;
        }
        $this->db = $this->load->database('offpista', TRUE, TRUE);
//        $this->db->select('forumid,title');
//        $this->db->from('forum');
         $this->db->select('forumid,title,metakeywords')->from('forum');
       if (count($data) > 0) {
            foreach ($data as $value)
                $this->db->where('forumid !=', $value);
        }

        $result = $this->db->get();
        $rowsOffpista = $result->result_array();
        $rows = array_merge($rowsOption, $rowsOffpista);
//        var_dump($rows);
        return $rows;
    }

    /**
     * @desc Function  get_rooms_list
     * @return true
     */
    public function delete_room() {
        
    }

    /**
     * @desc Function  get_rooms_list
     * @return true
     */
    public function update_room() {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('forum_rooms');
        $result = $this->db->get();
        $rowsOption = $result->result_array();
        $i = 0;
        $data = array();
        foreach ($data as $value) {
            $data[$i] = $value['room_id'];
        }
    }

    /**
     * @desc Function  get_rooms_list
     * @return true or false
     */
    public function allow_tool() {
        
    }

    /**
     * @desc Function  refresh_status
     * @return true or false
     */
    public function refresh_status($act, $forumid) {
        if ($act == 'allow') {
            $statusRoom = 1;
        } else {
            $statusRoom = 0;
        }
        // Check exist forumroom or not
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('forum_rooms');
        $this->db->where('forumid', $forumid);
        $result = $this->db->get();
        $rows = $result->result_array();

        if (count($rows) == 0) {
            //Create
            $this->db = $this->load->database('offpista', TRUE, TRUE);
            $this->db->select();
            $this->db->from('forum');
            $this->db->where('forumid', $forumid);
            $result = $this->db->get();
            $rows = $result->result_array();

            $this->db = $this->load->database('default', TRUE, TRUE);
            $data = array('forumid' => $forumid, 'title' => $rows[0]['title'], 'status' => $statusRoom);
            $this->db->insert('forum_rooms', $data);
        } else {
            // Update 
            $this->db = $this->load->database('default', TRUE, TRUE);
            $data = array(
                'status' => $statusRoom);
            $this->db->where('forumid', $forumid);
            $this->db->update('forum_rooms', $data);
        }
//        redirect($url . 'admin/dashboard/rooms/read');
    }
    
    public function set_default_asset($room_id, $asset_name)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $data = array('def_asset' => $asset_name);
        $this->db->where('id', $room_id);
        $this->db->update('forum_rooms', $data);
    }
    
    public function set_real_trade_link($link)
    {
        if (!preg_match("/http\:\/\//", $link)) {
            $link = 'http://' . $link;
        }
        $this->db = $this->load->database('default', TRUE, TRUE);
        $data = array('link' => $link);
        $this->db->update('real_trade_link', $data);
    }
    public function get_real_trade_link()
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('real_trade_link');
        $this->db->limit(1);
        $res  = $this->db->get();
        $data = $res->result_array(); 
        
        return $data[0]['link'];
    }
    
    public function add_default_room($room_id)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $data = array('default_room' => 0);
        $this->db->update('forum_rooms', $data);
        $data = array('default_room' => 1);
        $this->db->where('forumid', $room_id);
        $this->db->update('forum_rooms', $data);
    }
    
    public function get_default_room()
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('forumid');
        $this->db->from('forum_rooms');
        $this->db->where('default_room', 1);
        $res  = $this->db->get();
        $data = $res->result_array();
        return $data[0]['forumid'];
    }


    public function get_room_status_by_forum_id($forumid)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('status')->from('forum_rooms')->where('forumid', $forumid);
        $res  = $this->db->get();
        $data = $res->result_array();
        $result = false;
        if (count($data)) $result = $data[0]['status']; 

        return $result;
    }

    public function refresh_metakeywords($metakeywords, $forumid) {
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $data = array('metakeywords' => $metakeywords);
        $this->db->where('forumid', $forumid)->update('forum', $data);
    }

}
