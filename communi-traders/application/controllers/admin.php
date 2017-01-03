<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends MX_Controller {

    public function index() {
        $base_url = $this->config->item('base_url');
        $is_logged = $this->session->userdata('is_logged');
        $user_role = $this->session->userdata('user_role');
        if ($is_logged != 1 and $user_role != 1) {
            redirect($base_url . 'admin/auth');
        } else {
            redirect($base_url . 'admin/dashboard/report/read');
        }
    }

    public function auth() {
        $this->load->model('authmodel');
        $ci_csrf_token = $this->authmodel->getCSRF();
        $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);

        $url = $this->config->item('base_url');
        $this->mysmarty->assign('url', $url);
        if ($_POST) {
            $this->load->library('form_validation');
            $this->load->model('authmodel');
            $username = $this->input->post('login');
            $password = $this->input->post('password');
            $this->form_validation->set_rules('login', 'Login', 'required|trim|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $this->mysmarty->assign('error_string', $this->form_validation->error_string());
                $content = $this->mysmarty->fetch('admin_auth.tpl');
                $this->mysmarty->assign('content', $content);
                $this->mysmarty->view('admin_main');
            } else {
                if ($this->authmodel->getUser($username, $password) == TRUE) {
                    redirect($this->config->item('base_url') . 'admin/dashboard/report/read');
                } else {
                    $this->mysmarty->assign('error_string', 'Wrong user name or password');
                    $content = $this->mysmarty->fetch('admin_auth.tpl');
                    $this->mysmarty->assign('content', $content);
                    $this->mysmarty->view('admin_main');
                }
            }
        } else {
            $this->mysmarty->assign('error_string', '');
            $content = $this->mysmarty->fetch('admin_auth.tpl');
            $this->mysmarty->assign('content', $content);
            $this->mysmarty->view('admin_main');
        }
    }

    public function dashboard() {
        $is_logged = $this->session->userdata('is_logged');
        $user_role = $this->session->userdata('user_role');
        $url = $this->config->item('base_url');
        if ($is_logged != 1 and $user_role != 1) {
            redirect($url . 'admin/auth');
	    return;
	}
        $url = $this->config->item('base_url');
        $this->mysmarty->assign('url', $url);

        $modul = $this->uri->segment(3, FALSE);
        $act = $this->uri->segment(4, FALSE);

        $this->load->model('authmodel');
        $ci_csrf_token = $this->authmodel->getCSRF();
        $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);

        if(!strstr($act, "export_")) {
            $this->mysmarty->view('admin_header');
            $this->mysmarty->view('admin_menu');
        }
        switch ($act) {
            case 'read':  		
                $message = $this->session->flashdata('message');
                $message_content = $this->session->flashdata('message_content');
                $this->session->set_flashdata('inputRows', '');
                $this->mysmarty->assign('message', $message);
                $this->mysmarty->assign('message_content', $message_content);
                $this->load->module('admin_' . $modul)->read($act);
            break;
            case 'create':
                $this->load->module('admin_' . $modul)->createNewElement($act);
            break;
            case 'delete':
                $this->load->module('admin_' . $modul)->delete();
            break;
            case 'update':
                $this->load->module('admin_' . $modul)->update();
            break;
            case 'by_asset':
                $this->load->module('admin_' . $modul)->by_asset();
            break;
            case 'by_strategies':
                $this->load->module('admin_' . $modul)->by_strategies();
            break;
            case 'by_expire':
                $this->load->module('admin_' . $modul)->by_expire();
            break;
            case 'by_asset_expire':
                $this->load->module('admin_' . $modul)->by_asset_expire();
            break;
            case 'export_by_read':
                $this->load->module('admin_' . $modul)->export_by_read();
            break;
            case 'export_by_asset':
                $this->load->module('admin_' . $modul)->export_by_asset();
            break;
            case 'export_by_strategies':
                $this->load->module('admin_' . $modul)->export_by_strategies();
            break;
            case 'export_by_expire':
                $this->load->module('admin_' . $modul)->export_by_expire();
            break;
            case 'export_by_asset_expire':
                $this->load->module('admin_' . $modul)->export_by_asset_expire();
            break;
            case 'real_trade':
                $this->load->module('admin_' . $modul)->set_real_trade_link($act);
            break;
            case 'default':
                $this->load->module('admin_' . $modul)->set_default($act);
            break;
            case 'this_week_registrations':
                $this->load->module('admin_' . $modul)->this_week_registrations($act);
            break;
            case 'this_week_all_users':
                $this->load->module('admin_' . $modul)->this_week_all_users($act);
            break;
            case 'export_this_week_registrations':
                $this->load->module('admin_' . $modul)->export_this_week_registrations($act);
                break;
            case 'export_this_week_all_users':
                $this->load->module('admin_' . $modul)->export_this_week_all_users($act);
                break;
            case 'send_weekly_report':
                $this->load->module('admin_' . $modul)->send_weekly_report();
                break;
            case 'update_metakeywords':
                $this->load->module('admin_' . $modul)->update_metakeywords();
            break;
            default:
                $rows = $this->adminmodel->read($tablename);
                $this->mysmarty->assign('rows', $rows);
                $this->mysmarty->view('admin_' . $tablename);
                $this->mysmarty->view("admin_footer");
            break;
        }
    }

    public function settings() {
        $is_logged = $this->session->userdata('is_logged');
        $user_role = $this->session->userdata('user_role');
        $url = $this->config->item('base_url');
        if ($is_logged != 1 and $user_role != 1) {
            redirect($url . 'admin/auth');
        } else {
            $msg = '';
            $this->load->model('authmodel');
            $ci_csrf_token = $this->authmodel->getCSRF();
            $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);

            $this->load->model('adminmodel');
            $this->mysmarty->assign('base_url', $url);
            $this->mysmarty->assign('msg', $msg);
            $content = '';
            if ($this->uri->segment(3) == 'asset') {
                $action = $this->uri->segment(4);
                switch ($action) {
                    case 'add':
                        if ($this->item->input('post')) {
                            $this->load->library('form_validation');
                            $asset = $this->input->post('asset');
                            $short_name = $this->input->post('short_name');
                            $full_name = $this->input->post('full_name');
                            $this->form_validation->set_rules('asset', 'Asset', 'required|trim|xss_clean');
                            $this->form_validation->set_rules('short_name', 'Short name', 'required|trim|xss_clean');
                            $this->form_validation->set_rules('full_name', 'Full name', 'required|trim|xss_clean');
                            if ($this->form_validation->run() == FALSE) {
                                $this->mysmarty->assign('msg', $this->form_validation->error_string());
                            } else {
                                if ($this->adminmodel->add_new_asset($asset, $short_name, $full_name) == 1) {
                                    $this->mysmarty->assign('msg', 'New asset successfuly added!');
                                } else {
                                    $this->mysmarty->assign('msg', 'This asset already exists!');
                                }
                            }
                        }
                        $content = $this->mysmarty->fetch('add_new_asset.tpl');
                        $this->mysmarty->assign('content', $content);
                        break;
                    case 'list':
                        $assets = $this->adminmodel->get_assets_list();
                        $this->mysmarty->assign('assets', $assets);
                        $content = $this->mysmarty->fetch('admin_assets_list.tpl');
                        $this->mysmarty->assign('content', $content);
                        break;
                    case 'edit':
                        $asset_type = $this->uri->segment(5);
                        $asset_id = $this->uri->segment(6);
                        if ($_POST) {
                            $this->load->library('form_validation');
                            $short_name = $this->input->post('short_name');
                            $full_name = $this->input->post('full_name');
                            $asset_id = $this->input->post('asset_id');
                            $asset_type = $this->input->post('asset_type');
                            $this->form_validation->set_rules('short_name', 'Short name', 'required|trim|xss_clean');
                            $this->form_validation->set_rules('full_name', 'Full name', 'required|trim|xss_clean');
                            if ($this->form_validation->run() == FALSE) {
                                $this->mysmarty->assign('msg', $this->form_validation->error_string());
                            } else {
                                if ($this->adminmodel->add_update_asset($short_name, $full_name, $asset_type, $asset_id) == 1) {
                                    $this->mysmarty->assign('msg', 'Asset successfuly updated!');
                                } else {
                                    $this->mysmarty->assign('msg', 'This asset already exists!');
                                }
                            }
                            $asset_info = $this->adminmodel->get_asset_info($asset_type, $asset_id);
                            $this->mysmarty->assign('asset_info', $asset_info);
                            $this->mysmarty->assign('asset_type', $asset_type);
                            $this->mysmarty->assign('asset_id', $asset_id);
                            $content = $this->mysmarty->fetch('admin_update_asset.tpl');
                            $this->mysmarty->assign('content', $content);
                        } else {
                            $asset_info = $this->adminmodel->get_asset_info($asset_type, $asset_id);
                            $this->mysmarty->assign('asset_info', $asset_info);
                            $this->mysmarty->assign('asset_type', $asset_type);
                            $this->mysmarty->assign('asset_id', $asset_id);
                            $content = $this->mysmarty->fetch('admin_update_asset.tpl');
                            $this->mysmarty->assign('content', $content);
                        }
                        break;
                    case 'del':
                        $asset_type = $this->uri->segment(5);
                        $asset_id = $this->uri->segment(6);
                        $this->adminmodel->delete_asset($asset_type, $asset_id);
                        redirect('admin/settings/asset/list');
                        break;
                    default:
                        $content = $this->mysmarty->fetch('admin_default.tpl');
                        $this->mysmarty->assign('content', $content);
                        break;
                }
            }
            $this->mysmarty->view('admin_settings.tpl');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        $url = $this->config->item('base_url');
        redirect($url . "admin");
    }
}
