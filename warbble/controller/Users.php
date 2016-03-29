<?php

/**

 * Created by PhpStorm.

 * User: HuuHien

 * Date: 5/14/2015

 * Time: 6:28 AM

 */

class Users extends Controller{

    public $hybridauth;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_Package_Model');
        $this->set_filters(array(
            'create'                => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_RESELLER, Roles_Model::TYPE_LEVEL_COMPANY_ADMIN, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'index'                 => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_RESELLER, Roles_Model::TYPE_LEVEL_COMPANY_ADMIN, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'delete'                => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_RESELLER, Roles_Model::TYPE_LEVEL_COMPANY_ADMIN, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'update'                => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_RESELLER, Roles_Model::TYPE_LEVEL_COMPANY_ADMIN, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'loginAs'               => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_RESELLER, Roles_Model::TYPE_LEVEL_COMPANY_ADMIN, Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));
        
    }

    public function create()
    {
        $data = array(
            'errors'    => array(),
            'status'    => false,
        );

        if (isset($_POST['User'])) {

            $user = new Users_Model($_POST['User']);
            $user->registration_date = date("Y-m-d H:i:s");
            $current_user = Users_Model::get_current_user();
            if ($user->pass !== $_POST['pass_confirm']) {
                $data['errors'][] = "Please confirm password.";
            }
            if (!isset($_POST['Role']['level']) || empty($_POST['Role']['level'])) {
                $data['errors'][] = "Role can\'t be empty.";
            }
            if ($user->is_valid() && empty($data['errors'])) {
                $user->pass = md5($user->pass);
                $user->parent_id = $current_user->user_id;
                if ($user->save()) {
                    if (isset($_POST['Role'])) {
                        $user->update_roles($_POST['Role']['level']);
                    }
                    redirect(base_url('Users/index'));
                }
            } else {
                $data['errors'] = array_merge($data['errors'], $user->errors->full_messages());
            }
        }
        $this->layout('admin', 'users/create', $data);

    }

    public function update($id)
    {
        if (!$id) redirect(base_url('Users/index'));

        $data = array(
            'errors'    => array(),
            'status'    => false,
            'user'      => Users_Model::first(array('user_id' => $id)),
        );

        if (!$data['user']) redirect(base_url('Users/index'));
        if (isset($_POST['User'])) {
            $data['user']->first_name = $_POST['User']['first_name'];
            $data['user']->last_name = $_POST['User']['last_name'];

            if (isset($_POST['Role'])) {
                $data['user']->update_roles($_POST['Role']['level']);
            }

            if (!isset($_POST['Role']['level']) || empty($_POST['Role']['level'])) {
                $data['errors'][] = "Role can't be empty.";
            }

            if ($data['user']->save() && empty($data['errors'])) {
                redirect(base_url('Users/index'));
            } else {
                $data['errors'] = array_merge($data['errors'], $data['user']->errors->full_messages());
            }
        }

        $this->layout('admin', 'users/update', $data);
    }

    public function index()
    {
        $current_user = Users_Model::get_current_user();
        if ($current_user->check_permission(array(Roles_Model::TYPE_LEVEL_RESELLER))) {
            $data['gridview'] = include_once (ABSPATH . '/views/users/reseller_gridview.php');
        } else if ($current_user->check_permission(array(Roles_Model::TYPE_LEVEL_ADMIN))) {
            $data['gridview'] = include_once (ABSPATH . '/views/users/admin_gridview.php');
        } else if ($current_user->check_permission(array(Roles_Model::TYPE_LEVEL_COMPANY_ADMIN))) {
            $data['gridview'] = include_once (ABSPATH . '/views/users/company_admin_gridview.php');
        } else {
            redirect(base_url('Dashboard'));
        }
        $this->layout('admin', 'users/index', $data);
    }

    public function loginAs($id)
    {
        $this->access_iframe(Controller::IFRAME_ACCESS_SELF_DOMAIN);
        $user = Users_Model::find($id);
        if ($user) {
            $current_user = Users_Model::get_current_user();
            if ($current_user->check_permission(array(Roles_Model::TYPE_LEVEL_RESELLER)) && $user->parent_id !== $current_user->user_id) {
                redirect($_SERVER['HTTP_REFERER']);
            }
            $this->session->set_userdata('login', array(
                'user_id'       => $user->user_id,
                'email'         => $user->email,
                'user_level'    => $user->user_level,
                'first_name'    => $user->first_name,
                'last_name'     => $user->last_name,
                'parent_id'     => $current_user->user_id,
            ));
            redirect(base_url('Dashboard'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function payment()
    {
        $dis = array();

        $dis['view'] = 'users/payment';

        $this->view_front( $dis );
        
    }

    public function login( $social = NULL ){
        $this->access_iframe(Controller::IFRAME_ACCESS_SELF_DOMAIN);
        $dis = array();

        if( $social != NULL ){

            switch( $social ){

                case "facebook":
                    $response = Users_Model::create_facebook_account();
                    switch ($response['status']) {
                        case "redirect":
                        case "redirect_error":
                        case "success":
                            redirect($response['url']);
                            break;
                        case "error":
                            $dis['message'] = '<p class="error">'.$response['message'].'</p>';
                            break;
                    }
                    break;

                case "twitter":
                    $response = Users_Model::create_twitter_account(base_url('login/twitter'));
                    switch ($response['status']) {
                        case "redirect":
                        case "redirect_error":
                        case "success":
                            redirect($response['url']);
                            break;
                        case "error":
                            $dis['message'] = '<p class="error">'.$response['message'].'</p>';
                            break;
                    }
                    break;
            }

        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (Users_Model::login()) {
                redirect(base_url('Posts/index'));
            } else {
                $dis['message'] = '<p class="error">The email or password do not match those on file. Or you have not activated your account.</p>';
            }
        }

        $dis['login'] = true;
        $dis['view'] = 'users/login';

        $this->view_front( $dis );

    }

    public function api_register()
    {
        if (!isset($_GET['domain'])) {
            die('Domain is empty.');
        }
        if (!in_array($_GET['domain'], Api_model::$allow_domains)) {
            die('Domain isn\'t allowed.');
        }

        $errors = array();

        if (isset($_POST['Register'])) {
            if ($_POST['Register']['pass'] === $_POST['Register']['conf_pass']) {
                unset ($_POST['Register']['conf_pass']);
                $_POST['Register']['pass'] = md5($_POST['Register']['pass']);
                $user = new Users_Model($_POST['Register']);
                $user->type = Users_Model::USER_TYPE_RESELLER;
                if ($user->save()) {
                    $token = md5($user->user_id . $_GET['domain'] . time());
                    // api model
                    if (!$api = Api_model::first(array('domain' => $_GET['domain'], 'token' => $token))) {
                        $api = new Api_model();
                    }
                    $api->set_attributes(array(
                        'user_id'       => $user->user_id,
                        'domain'        => $_GET['domain'],
                        'token'         => $token,
                        'created_time'  => time(),
                    ));
                    $api->save();
                    // role model
                    $role = new Roles_Model(array(
                        'user_id'   => $user->user_id,
                        'level'     => Roles_Model::TYPE_LEVEL_RESELLER,
                    ));
                    $role->save();
                    $this->session->set_userdata('login', array(
                        'user_id'       => $user->user_id,
                        'email'         => $user->email,
                        'user_level'    => $user->user_level,
                        'first_name'    => $user->first_name,
                        'last_name'     => $user->last_name,
                    ));

                    Api_model::send_response("http://{$_GET['domain']}", array(
                        'warbble_api_response' => array(
                            'user_id'   => $user->user_id,
                            'token'     => $token
                        )
                    ));
                    redirect(base_url('Dashboard'));

                } else {
                    $errors = $user->errors->full_messages();
                }
            } else {
                $errors[] = "Confirm your password please!";
            }

        }

        $this->load->view('api/header', array());
        $this->load->view('api/register', array('domain' => $_GET['domain'], 'errors' => $errors));
        $this->load->view('api/footer', array());
    }

    public function api_login()
    {
        if (!isset($_GET['domain'])) {
            die('Domain is empty.');
        }
        if (!in_array($_GET['domain'], Api_model::$allow_domains)) {
            die('Domain isn\'t allowed.');
        }

        $users = Users_Model::find_by_sql(sprintf("
            SELECT users.*
            FROM users
            JOIN api ON api.user_id = users.user_id
            WHERE api.domain = '%s' AND api.token = '%s' AND api.token <> '' AND api.token IS NOT NULL
            LIMIT 1
        ", $_GET['domain'], $_GET['token']));

        if (!empty($users)) {
            $this->session->set_userdata('login', array(
                'user_id'       => $users[0]->user_id,
                'email'         => $users[0]->email,
                'user_level'    => $users[0]->user_level,
                'first_name'    => $users[0]->first_name,
                'last_name'     => $users[0]->last_name,
            ));
            redirect(base_url('Dashboard'));
            exit;
        } else {
            $errors = array();
            if (isset($_POST['Login'])) {
                $users = Users_Model::find_by_sql(sprintf("
                    SELECT users.*
                    FROM users
                    JOIN roles ON roles.user_id = users.user_id
                    WHERE users.email = '%s' AND users.pass = '%s' AND roles.level = %s
                    LIMIT 1
                ",
                    $_POST['Login']['email'],
                    md5($_POST['Login']['pass']),
                    Roles_Model::TYPE_LEVEL_RESELLER
                ));

                if (!empty($users)) {
                    $this->session->set_userdata('login', array(
                        'user_id'       => $users[0]->user_id,
                        'email'         => $users[0]->email,
                        'user_level'    => $users[0]->user_level,
                        'first_name'    => $users[0]->first_name,
                        'last_name'     => $users[0]->last_name,
                    ));
                    $token = md5($users[0]->user_id . $_GET['domain'] . time());
                    $users[0]->api->token = $token;
                    $users[0]->api->save();
                    Api_model::send_response("http://{$_GET['domain']}", array(
                        'warbble_api_response' => array(
                            'user_id'   => $users[0]->user_id,
                            'token'     => $token
                        )
                    ));
                    redirect(base_url('Dashboard'));
                    exit;
                } else {
                    $errors[] = 'Invalid user name or login.';
                }
            }
            $this->load->view('api/header', array());
            $this->load->view('api/login', array('domain' => $_GET['domain'], 'errors' => $errors));
            $this->load->view('api/footer', array());
        }
    }

    public function singup(){

        $dis = array();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            //recapcha

            $recaptcha=$_POST['g-recaptcha-response'];
            if(!empty($recaptcha))
            {
                function getCurlData($url)
                {
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
                    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
                    $curlData = curl_exec($curl);
                    curl_close($curl);
                    return $curlData;
                }

                $google_url="https://www.google.com/recaptcha/api/siteverify";
                $secret='6LegEA0TAAAAAGI6x6iCtjyILmUEy9nt6X2nB7pY';
                $ip=$_SERVER['REMOTE_ADDR'];
                $url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
                $res=getCurlData($url);
                $res= json_decode($res, true);
                //reCaptcha введена
                if($res['success'])
                {
                    $success = 1;
                }
                else
                {
                    $message='<p class="error">Please re-enter your reCAPTCHA.</p>';
                }

            }
            else
            {
                $message='<p class="error">Please re-enter your reCAPTCHA.</p>';
            }
//if captcha good
 if($success) {

    $user = Users_Model::find_by_email($_POST['email']);

    if (sizeof($user) > 0) {

        $message = '<p class="error">The email was already used previously. Please use another email address.</p>';

    } else {

        $active = MD5(time());

        $user = new Users_Model();

        $account_type = $_POST['account_type'];

        $user->first_name = $_POST['first_name'];

        $user->last_name = $_POST['last_name'];

        $user->email = $_POST['email'];

        $user->pass = MD5($_POST['password1']);

        $user->active = $active;

        $user->registration_date = date("Y-m-d H:i:s");

        if ($account_type == "customer") {

            $user->type = 1;

        } else {

            $user->type = 2;
            $user->company = $_POST['company_name'];

        }

        if ($user->save()) {
            $role = new Roles_Model(array(
                'user_id'   => $user->user_id,
                'level'     => Roles_Model::TYPE_LEVEL_USER,
            ));
            $role->save();
        }
        $currency = Users_Package_Model::GetCurrencyGeoIp();
        Users_Package_Model::NewPackage($user, $currency["currency_code"]);

        $body = "Thank you for registering izCMS page. An activation email has been sent to the email address you provided. Session you click the link to activate your account \n\n ";

        $body .= BASE_URL . "users/active/" . str_replace("'", "", $active);


        $mailer = new Swiftmailer();
        $response = $mailer->mail('Activate account at izCMS', array(
            'email' => 'support@warbble.com',
            'title' => 'Support',
        ), array($_POST['email']), $body);

        if ($response['status']) {

            $message = "<p class='success'>Your account has been successfully registered. Email has been sent to your address. You must click the link to activate your account before using it.</p>";

        } else {

            $message = "<p class='error'>Can not send an email to you. We apologize for this inconvenience.</p>";

        }

                }
            }
        }

        $dis['mes'] = $message;

        $dis['view'] = 'users/singup';
        $dis['signup'] = true;

        $this->view_front( $dis );

    }

    function delete($id)
    {
        Users_Model::table()->delete(array('user_id' => $id));
        redirect($_SERVER['HTTP_REFERER']);
    }

    function logout(){

        $this->session->unset_userdata( 'login' );
        $this->session->unset_userdata( 'tokens' );

        redirect( BASE_URL );

    }

    function forgot(){

        $dis = array();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $user = Users_Model::find_by_email($_POST['email']);

            if( sizeof($user) > 0 ) {

                $key = md5($_POST['email'] . time());
                $user->user_key = $key;

                $subject = 'Please reset your password';

                $to = $_POST['email'];
                $body = sprintf("<p>We heard that you lost your password. Sorry about that!</p>
                                <p>But don't worry! You can use the following link within the next day to reset your password:</p>
                                <p><a href='%s'>Reset</a></p>
                                <p>If you don't use this link within 24 hours, it will expire. To get a new password reset link, visit <a href='%s'>Forgot</a></p>
                                <p>Thanks,<br />
                                Your friends</p>
                                ", base_url('change-password/' . $key), base_url('forgot'));
                $email_config = get_config('swiftmailer');
                $mailer = new Swiftmailer();
                $response = $mailer->mail($subject, array(
                    'email' => 'support@warbble.com',
                    'title' => 'Support',
                ), array($to), $body);

                if ($response['status'] && $user->save()) {
                    $dis['message'] = '<p class="success">We\'ve sent you an email containing a link that will allow you to reset your password for the next 24 hours.<br ><br >Please check your spam folder if the email doesn\'t appear within a few minutes.</p>';
                } else {
                    $dis['message'] = '<p class="error">The email was not sent</p>';
                }
            }else{

                $dis['message'] = '<p class="error">Can\'t find that email, sorry.</p>';

            }

        }

        $dis['view'] = 'users/forgot';

        $this->view_front( $dis );

    }

    function active( $active){

        $dis = array();

        $user = Users_Model::find_by_active($active);

        $user->active = NULL;

        $user->save();

        // $message = '<p class="success">Your acccount has been activated successfully. You may <a href="'.base_url().'login">login </a> now.</p>';
        $message = '<p class="success">Your acccount has been activated successfully. You may <a href="'.BASE_URL.'login">login </a> now.</p>';

        $dis['message'] = $message;

        $dis['view'] = 'users/active';

        $this->view_front( $dis );

    }

    function close( $close){

        $dis = array();

        $users = Users_Model::find('all',array('active' => $close));

        foreach ($users as $user) {

            $user->delete();

        }

        $message = '<p class="success">Your acccount has been deleted successfully.You may <a href="'.BASE_URL.'singup">Sign Up </a> now.</p>';

        $dis['message'] = $message;

        $dis['view'] = 'users/close';

        $this->view_front( $dis );

    }

    function change_password($key){

        $dis = array();

        $user = Users_Model::first(array(
            'user_key' => $key,
        ));

       // if (!$user) redirect(base_url());

        if (isset($_POST['Reset'])) {
            $user->pass = md5($_POST['Reset']['pass2']);
            $user->user_key = NULL;
            if ($user->save()) {
                $dis['message'] = sprintf('<p class="success">The password has been changed. Now you can <a href="%s">login</a></p>', base_url('login'));
            } else {
                $dis['message'] = sprintf('<p class="error">The password hasn\'t been changed</p>');
            }
        }

        $dis['view'] = 'users/change-password';
        $this->view_front($dis);
    }

    function myaccount(){

        $this->load->library('Upload');

        $dis = array();

        $admin_login = $this->session->userdata('login');

        if( !empty( $admin_login ) ) {

            $user = Users_Model::find_by_user_id($admin_login['user_id']);
            $user_package = Users_Package_Model::find_by_user_id($admin_login['user_id']);
            $dis['user_package'] = $user_package;
            $dis['user'] = $user;

        }else{

            redirect(BASE_URL."login");

        }

        if($_SERVER['REQUEST_METHOD'] == 'POST' AND !empty($_POST['first_name']) AND $_POST["cancel"] != "cancel" AND $_POST["update"] == "update") {

            if( $_FILES['avatar']['size'] > 0) {
                $time = time();

                @move_uploaded_file( $_FILES['avatar']['tmp_name'],'uploads/avatars/'.$time);

                $user->avatar = 'uploads/avatars/'.$time;

            }
           
            $user->first_name = $_POST['first_name'];

            $user->last_name = $_POST['last_name'];

            if(isset($_POST['email'])){ $user->email = $_POST['email']; }

            $user->website = $_POST['website'];

            $user->bio = $_POST['bio'];

            $user->save();
            $user_package->vat_number = empty($_POST['vat_number']) ? NULL: $_POST['vat_number'];
            $user_package->save();
            Users_Package_Model::UpdateStripeUserVat($user_package, $user_package->vat_number);

            $dis['mes'] = '<p class="success">Update success!</p>';
            $dis['userlogin'] = $user;
         }
/*
        $dis['view'] = 'users/profile';

        $this->view_front($dis);
*/
      //new layout for update prof
        $this->load->view('/front/users/profile_upd', $dis);


    }

    function upgrade(){

        $dis = array();

        if($_REQUEST['delaccount'] == 'delaccount') {

            $active = MD5(time());

            $admin_login = $this->session->userdata('login');
            $user = Users_Model::find_by_user_id($admin_login['user_id']);
            $user_package = Users_Package_Model::find_by_user_id($admin_login['user_id']);

            if ($user->type == 1) {

                $user->active = $active;

                $user->save();

                $users_in_company = Users_Model::find('all',array('company' => $user->email));

                foreach ($users_in_company as $customer) {

                    $customer->active = $active;

                    $customer->save();

                }

                $admin_user = Users_Model::find_by_type(0);

                $body = "You are about to close your account. An activation email has been sent to the email address you provided. Session you click the link to Close your account \n\n ";

                $body .= BASE_URL . "users/close/".str_replace("'", "", $active);

               $mailer = new Swiftmailer();
               $response = $mailer->mail('Close account at izCMS', array(
                   'email' => 'support@warbble.com',
                   'title' => 'Support',
               ), array($_POST['email']), $body);


                if($response['status']) {

                    $message = "<p class='success'>Email has been sent to your address. You must click the link to close your account.</p>";

                } else {

                    $message = "<p class='error'>Can not send an email to you. We apologize for this inconvenience.</p>";

                }

                $dis['mes'] = $message;
                redirect( BASE_URL );

            } else {
                $user->delete();
                $user_package->delete();

                $message = "<p class='success'>Your account was successfully closed.</p>";
                $dis['mes'] = $message;
                redirect( BASE_URL );
               
            }

        }
        
        $stripe_user = Users_Package_Model::GetStripeUserData();
        $currency = Users_Package_Model::GetCurrency();
        $dis['current_user'] = Users_Model::get_current_user();
        $dis['stripe_user'] = $stripe_user;
        $dis['currency'] = $currency;
        $dis['config'] = get_config('stripe');
        $dis['view'] = 'users/upgrade';

        $this->view_front($dis);

    }

}