<?php

class Admin_rooms extends MX_Controller {

    public function _this() {
        $this->index();
    }

    public function read($act) {
        $this->load->model('rooms_model');
        $rows = $this->rooms_model->get_rooms_list();
        $this->mysmarty->assign('rows', $rows);
        $this->mysmarty->assign('act', $act);
        $this->mysmarty->view("admin_rooms");
    }

    public function create() {
        
    }

/*
    public function update() {
        $act = $this->uri->segment(5, FALSE);
        $forumid = $this->uri->segment(6, FALSE);
        $this->load->model('rooms_model');
        $rows = $this->rooms_model->refresh_status($act,$forumid);
    }
*/
    public function update() {
        $this->load->helper('url');
        $act = $this->uri->segment(5, FALSE);
        $forumid = $this->uri->segment(6, FALSE);
        $this->load->model('rooms_model');
        $this->rooms_model->refresh_status($act,$forumid);
        redirect(site_url('admin/dashboard/rooms/read'));
    }

    public function update_metakeywors() {
        $this->load->helper('url');
        $metakeywords = $this->input->post('metakeywords', TRUE);
        $forumid = $this->uri->segment(5, FALSE);
        $this->load->model('rooms_model');
        $this->rooms_model->refresh_metakeywords($metakeywords,$forumid);
        redirect(site_url('admin/dashboard/rooms/read'));
    }

    
    public function set_real_trade_link()
    {
        $act = 'real_trade';
        $this->load->model('rooms_model');
        $link = $this->rooms_model->get_real_trade_link();
        $this->mysmarty->assign('link', $link);
        $this->mysmarty->assign('act', $act);
        $this->mysmarty->view("admin_rooms");
    }

}
