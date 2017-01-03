<?php

class Admin_dashboard extends MX_Controller {

    public function _this() {
        $this->index();
    }

    public function read($act) {
        $this->load->model('assets_model'); 
        $assets = $this->assets_model->get_assets_list();
		$config['date_from'] = date('%F:%j %Y');
		$config['date_to'] = date("F j, Y", strtotime('-30 day'));
		$this->mysmarty->assign('config',$config);
        $this->mysmarty->assign('assets', $assets);
        $this->mysmarty->assign('act', $act);
        $this->mysmarty->view("admin_dashboard");
    }

   
    public function update() {
        $url = $this->config->item('base_url');
        $this->load->model('authmodel');
        $ci_csrf_token = $this->authmodel->getCSRF();
        $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);

        $act = $this->uri->segment(5, FALSE);
        $asset_type = $this->uri->segment(6, FALSE);
        $id = $this->uri->segment(7, FALSE);
        switch ($act) {
            case 'edit':
                $this->load->model('assets_model');
                $asset = $this->assets_model->get_asset_info($asset_type, $id);
                $this->mysmarty->assign('asset', $asset);
                $this->mysmarty->assign('asset_type', $asset_type);
                $this->mysmarty->assign('act', $act);
                $this->mysmarty->view("admin_assets");
                exit;
            case 'update':
                $this->load->model('assets_model');
                $this->assets_model->add_update_asset($asset_type, $id);
                redirect($url . 'admin/dashboard/assets/read');
                exit;
            default:
                return false;
                exit;
        }
    }

    public function createNewElement() 
    {
        $url = $this->config->item('base_url');
        $this->load->model('authmodel');
        $ci_csrf_token = $this->authmodel->getCSRF();
        $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);
        $act = $this->uri->segment(5, FALSE);
        switch ($act) {
            case 'new':
                $this->mysmarty->assign('act', $act);
                $this->mysmarty->view("admin_assets");
            break;
            case 'add':
                $this->load->model('assets_model');
                $this->assets_model->add_new_asset();
                redirect($url . 'admin/dashboard/assets/read');
            break;
            default:
                return false;
            break;
        }
    }

    public function delete() {
        $asset_type = $this->uri->segment(5, FALSE);
        $id = $this->uri->segment(6, FALSE);
        $this->load->model('assets_model');
        $this->assets_model->delete_asset($asset_type,$id);
        redirect($url . 'admin/dashboard/assets/read');
    }
    
    public function set_default()
    {
        $act = $this->uri->segment(5);
        $this->load->model('rooms_model');
        $rooms = $this->rooms_model->get_rooms_list();
        $this->load->model('assets_model');
        $assets = $this->assets_model->get_assets_list();
        /*echo '<pre>';
        print_r($assets);
        echo '</pre>';
        exit;*/
        $this->mysmarty->assign('assets', $assets);
        $this->mysmarty->assign('rooms', $rooms);
        $this->mysmarty->assign('act', $act);
        $this->mysmarty->view("admin_assets");
    }
	

}
