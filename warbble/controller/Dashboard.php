<?php
ini_set('display_errors', 'On');
/**
 * Created by PhpStorm.
 * User: HuuHien
 * Date: 5/16/2015
 * Time: 8:38 PM
 */

class Dashboard extends Controller{
    
    public function __construct()
    {
        parent::__construct();
        $current_user = Users_Model::get_current_user();
        if (!$current_user){
            redirect(BASE_URL);
        }
        if ($current_user->check_permission(array(Roles_Model::TYPE_LEVEL_RESELLER))) {
            redirect(base_url('Users/index'));
        } else if ($current_user->check_permission(array(Roles_Model::TYPE_LEVEL_CONTENT_DEVELOPER))) {
            redirect(base_url('SuggestedPosts/index'));
        }

        $this->_js = array(
            array(
                'type'      => 'admin',
                'url'       => 'https://js.stripe.com/v2/',
                'location'  => 'outside',
            ),
            array(
                'type'      => 'admin',
                'url'       => 'https://checkout.stripe.com/checkout.js',
                'location'  => 'outside',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'jquery.steps.min.js',
                'location'  => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'jquery.cookie.js',
                'location'  => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'moment.min.js',
                'location'  => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'daterangepicker.js',
                'location'  => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'slick.min.js',
                'location'  => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'dashboard.js',
                'location'  => 'footer',
            ),
        );

        $this->_css = array(
            array(
                'type'      => 'admin',
                'file'      => 'jquery.steps.min.css',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'slick.css',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'slick-theme.css',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'daterangepicker.css',
            ),
//            array(
//                'type'      => 'admin',
//                'file'      => 'dashboard.css',
//            ),
        );

        $this->set_filters(array(
            'index'                 => array(
                Roles_Model::TYPE_LEVEL_ADMIN,
                Roles_Model::TYPE_LEVEL_DESIGNER,
                Roles_Model::TYPE_LEVEL_USER,
                Roles_Model::TYPE_LEVEL_CUSTOMER,
                Roles_Model::TYPE_LEVEL_LOGGED_IN
            ),
        ));
    }

    public function index()
    {
        $dis = array();
        $dis['current_user'] = Users_Model::get_current_user();
        if ($this->is_ajax()) {
            if (isset($_POST['type'])) {
                $dis['business_categories'] = get_config('business_categories');
                if ($_POST['type'] == Product_Model::TYPE_FACEBOOK) {
                    $view = 'Facebook';
                } else if ($_POST['type'] == Product_Model::TYPE_TWITTER) {
                    $view = 'Twitter';
                }
                echo json_encode(array('status' => true, 'html' => $this->load->view("dashboard/index/business_categories/{$view}", $dis, TRUE)));
                exit;
            }
            if (isset($_POST['action']) && $_POST['action'] == 'check_status' && isset($_POST['product_id']) && isset($_POST['page_info_id'])) {
                $data = Users_Package_Model::GetStripeUserData();
                if ($data['status'] == 'trialing') {
                    $order = new Orders_Model(array(
                        'product_id'        => $_POST['product_id'],
                        'date'              => time(),
                        'status'            => Orders_Model::STATUS_TRIAL,
                        'token'             => 0,
                        'page_info_id'      => $this->session->userdata('page_info_id'),
                        'user_id'           => $dis['current_user']->user_id,
                        'total'             => 0,
                    ));
                    $order->save();
                    $html = $this->load->view('dashboard/index/_complete', array(
                        'order'     => $order,
                    ), TRUE);
                }
                echo json_encode(array('status' => $data['status'], 'html' => $html, 'order_id' => $order->id));
                exit;
            }
        }

        $config = get_config('stripe');
        $user_package = Users_Package_Model::GetPackage();
        if ($user_package == NULL){
            Users_Package_Model::NewPackage(Users_Model::get_current_user());
            $user_package = Users_Package_Model::GetPackage();
        }
        $stripe_user = Users_Package_Model::GetStripeUser($user_package);
        $card = Users_Package_Model::GetStripeDefaultCard($stripe_user);
        $dis['card'] = $card;
        $dis['config'] = $config;
        $dis['payment_config'] = get_config('payment');
        $dis['fb_avatar'] = $dis['current_user']->get_usermeta('fb_avatar');
        $dis['tw_avatar'] = $dis['current_user']->get_usermeta('tw_avatar');
        $this->layout('admin', 'dashboard/index/home', $dis);
    }
    
    public function socialinfo()
    {
        $dis = array();
        $dis['current_user'] = Users_Model::get_current_user();
        $config = get_config('stripe');
        $user_package = Users_Package_Model::GetPackage();
        if ($user_package == NULL){
            Users_Package_Model::NewPackage(Users_Model::get_current_user());
            $user_package = Users_Package_Model::GetPackage();
        }
        $stripe_user = Users_Package_Model::GetStripeUser($user_package);
        $card = Users_Package_Model::GetStripeDefaultCard($stripe_user);
        $dis['card'] = $card;
        $dis['config'] = $config;
        $dis['payment_config'] = get_config('payment');
        $dis['fb_avatar'] = $dis['current_user']->get_usermeta('fb_avatar');
        $dis['tw_avatar'] = $dis['current_user']->get_usermeta('tw_avatar');
        $this->layout('admin', 'dashboard/index/social', $dis);
    }
    
    public function design()
    {
        $dis = array();
        $dis['current_user'] = Users_Model::get_current_user();
        $config = get_config('stripe');
        $user_package = Users_Package_Model::GetPackage();
        if ($user_package == NULL){
            Users_Package_Model::NewPackage(Users_Model::get_current_user());
            $user_package = Users_Package_Model::GetPackage();
        }
        
        if ($this->is_ajax()) {
            if (isset($_POST['type'])) {
                $dis['business_categories'] = get_config('business_categories');
                if ($_POST['type'] == Product_Model::TYPE_FACEBOOK) {
                    $view = 'Facebook';
                } else if ($_POST['type'] == Product_Model::TYPE_TWITTER) {
                    $view = 'Twitter';
                }
                echo json_encode(array('status' => true, 'html' => $this->load->view("dashboard/index/business_categories/{$view}", $dis, TRUE)));
                exit;
            }
            if (isset($_POST['action']) && $_POST['action'] == 'check_status' && isset($_POST['product_id']) /*&& isset($_POST['page_info_id'])*/ ) {
                $data = Users_Package_Model::GetStripeUserData();
                if ($data['status'] == 'trialing') {
                    $order = new Orders_Model(array(
                        'product_id'        => $_POST['product_id'],
                        'date'              => time(),
                        'status'            => Orders_Model::STATUS_TRIAL,
                        'token'             => 0,
                        'page_info_id'      => $this->session->userdata('page_info_id'),
                        'user_id'           => $dis['current_user']->user_id,
                        'total'             => 0,
                    ));
                    $order->save();
                    $html = $this->load->view('dashboard/index/_complete', array(
                        'order'     => $order,
                    ), TRUE);
                }
                echo json_encode(array('status' => $data['status'], 'html' => $html, 'order_id' => $order->id));
                exit;
            }
        }
        
        $stripe_user = Users_Package_Model::GetStripeUser($user_package);
        $card = Users_Package_Model::GetStripeDefaultCard($stripe_user);
        $dis['card'] = $card;
        $dis['config'] = $config;
        $dis['payment_config'] = get_config('payment');
        $dis['fb_avatar'] = $dis['current_user']->get_usermeta('fb_avatar');
        $dis['tw_avatar'] = $dis['current_user']->get_usermeta('tw_avatar');
        $this->layout('admin', 'dashboard/index/design', $dis);
    }
    
    public function designComplate()
    {
        $dis = array();
        $dis['current_user'] = Users_Model::get_current_user();
        $config = get_config('stripe');
        $user_package = Users_Package_Model::GetPackage();
        if ($user_package == NULL){
            Users_Package_Model::NewPackage(Users_Model::get_current_user());
            $user_package = Users_Package_Model::GetPackage();
        }
        $stripe_user = Users_Package_Model::GetStripeUser($user_package);
        $card = Users_Package_Model::GetStripeDefaultCard($stripe_user);
        $dis['card'] = $card;
        $dis['config'] = $config;
        $dis['payment_config'] = get_config('payment');
        $dis['fb_avatar'] = $dis['current_user']->get_usermeta('fb_avatar');
        $dis['tw_avatar'] = $dis['current_user']->get_usermeta('tw_avatar');
        $this->layout('admin', 'dashboard/index/design_order_complate', $dis);
    }
    
    public function complateOrder()
    {
        $dis = array();
        $dis['current_user'] = Users_Model::get_current_user();
        $config = get_config('stripe');
        $user_package = Users_Package_Model::GetPackage();
        if ($user_package == NULL){
            Users_Package_Model::NewPackage(Users_Model::get_current_user());
            $user_package = Users_Package_Model::GetPackage();
        }
        $stripe_user = Users_Package_Model::GetStripeUser($user_package);
        $card = Users_Package_Model::GetStripeDefaultCard($stripe_user);
        $dis['card'] = $card;
        $dis['config'] = $config;
        $dis['payment_config'] = get_config('payment');
        $dis['fb_avatar'] = $dis['current_user']->get_usermeta('fb_avatar');
        $dis['tw_avatar'] = $dis['current_user']->get_usermeta('tw_avatar');
        $this->layout('admin', 'dashboard/index/complateOrder', $dis);
    }
    
    public function success_complated()
    {
        $dis = array();
        $dis['current_user'] = Users_Model::get_current_user();
        $config = get_config('stripe');
        $user_package = Users_Package_Model::GetPackage();
        if ($user_package == NULL){
            Users_Package_Model::NewPackage(Users_Model::get_current_user());
            $user_package = Users_Package_Model::GetPackage();
        }
        $stripe_user = Users_Package_Model::GetStripeUser($user_package);
        $card = Users_Package_Model::GetStripeDefaultCard($stripe_user);
        $dis['card'] = $card;
        $dis['config'] = $config;
        $dis['payment_config'] = get_config('payment');
        $dis['fb_avatar'] = $dis['current_user']->get_usermeta('fb_avatar');
        $dis['tw_avatar'] = $dis['current_user']->get_usermeta('tw_avatar');
        $this->layout('admin', 'dashboard/index/success_complated', $dis);
    }
}