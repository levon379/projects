<?php

/**

 * Created by PhpStorm.

 * User: HuuHien

 * Date: 5/16/2015

 * Time: 8:38 PM

 */



class Admin extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->set_filters(array(
            'index'                 => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));
    }

    public function index(){

        $dis = array();

        $dis['view'] = 'admin/home';

        $admin_login = $this->session->userdata('login');

        if(sizeof($admin_login) > 0){

            $current_user = Users_Model::find_by_user_id($admin_login['user_id']);

            $dis['current_user'] = $current_user;
            if($current_user->type == 2){

                $dis['mes'] = "Only Administrator / Customer is allowed to this page. Log in as Administrator / Customer";
                
            }

            $this->view_front( $dis );
        } else {
            header("Location: ".BASE_URL."login");
        }
    }

}