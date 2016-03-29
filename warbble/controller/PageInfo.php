<?php

class PageInfo extends Controller
{
    public function  __construct()
    {
        parent::__construct();
        $this->load->model('Page_info_Model');

        $this->set_filters(array(
            'add_pageinfo'                 => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));
    }

    public function add_pageinfo()
    {
        if ($this->is_ajax()) {
            if (isset($_POST['PageInfo'])) {
                $pageinfo = new Page_info_Model($_POST['PageInfo']);
                $current_user = Users_Model::get_current_user();

                if (!$current_user) {
                    echo json_encode(array('status' => false, 'errors' => array(
                        'Invalid response (user is no logged in)'
                    )));
                    exit;
                }

                $pageinfo->user_id  = $current_user->id;

                if ($pageinfo->save()) {
                    $this->session->set_userdata('page_info_id',$pageinfo->id);
                    $products = Product_Model::find('all', array(
                        'type' => $_POST['PageInfo']['type']
                    ));
                    $html = $this->load->view('dashboard/index/_designs', array(
                        'products' => $products,
                    ), TRUE);
                    echo json_encode(array('status' => true, 'products_html' => $html, 'page_info_id' => $pageinfo->id));
                } else {
                    $errors = $pageinfo->errors->full_messages();
                    echo json_encode(array('status' => false, 'errors' => $errors));
                }
            }
        }
        exit;
    }
}