<?php
/**
 * Created by PhpStorm.
 * User: HuuHien
 * Date: 5/16/2015
 * Time: 10:21 AM
 */

class Home extends Controller
{

    public function index()
    {
        $dis = array('errors' => false);
        $user = Users_Model::get_current_user();
        $this->load->library('captcha/Captcha');
        $dis['captcha'] = new Captcha();

        if ($this->is_ajax() && isset($_POST['Contact'])) {
            $recipients = array();
            $email_config = get_config('swiftmailer');

            if (empty($_POST['Contact']['your_name'])) {
                $dis['errors']['your_name'] = "Your name field can't be blank";
            }

            if (empty($_POST['Contact']['email']) || filter_var($_POST['Contact']['email'], FILTER_VALIDATE_EMAIL) == FALSE) {
                $dis['errors']['email'] = "Email field can't be blank";
            }

            if (empty($_POST['Contact']['message'])) {
                $dis['errors']['message'] = "Message field can't be blank";
            }

//            if (!$dis['captcha']->check($_POST['Contact']['captcha'])) {
//                $dis['errors']['captcha'] = "Invalid captcha";
//            }
            if(!$dis['errors'] && empty($dis['errors']))
            {
                $recaptcha=$_POST['g-recaptcha-response'];
                $google_url="https://www.google.com/recaptcha/api/siteverify";
                $secret='6LegEA0TAAAAAGI6x6iCtjyILmUEy9nt6X2nB7pY';
                $ip=$_SERVER['REMOTE_ADDR'];
                $url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
                $res=$this->getCurlData($url);
                $res= json_decode($res, true);
                if(!$res['success'])
                {
                    $dis['errors']['captcha'] = "Invalid captcha";
                }
            }
            //reCaptcha введена
            
            
           $captcha = $dis['captcha']->getbase64src();

            if (!$dis['errors']) {
                $mailer = new Swiftmailer();
                $response = $mailer->mail('Contact us', array(
                    'email' => $_POST['Contact']['email'],
                    'title' => $_POST['Contact']['your_name'],
                ), array(
                    'email' => 'support@warbble.com',
                    'title' => 'Support',
                ), $_POST['Contact']['message']);
                echo json_encode(array('status' => true, 'captcha' => $captcha));
            } else {
                echo json_encode(array('status' => false, 'captcha' => $captcha, 'errors' => implode('<br/>', $dis['errors'])));
            }

            exit;
        }
        if ($user){
            $config = get_config('stripe');
            $user_package = Users_Package_Model::GetPackage();
            if (!$user_package){
                Users_Package_Model::NewPackage($user);
                $user_package = Users_Package_Model::GetPackage();
            }
            $stripe_user = Users_Package_Model::GetStripeUser($user_package);
            $cards = Users_Package_Model::GetStripeUserCards($stripe_user);
            $addcard = ($cards ? true : false);
            if ($stripe_user->subscriptions->data[0]->status == "trialing" or $stripe_user->subscriptions->data[0]->plan->id == 1){
                $addcard = false;
            }
            $dis['addcard'] = $addcard;
            $dis['p_key'] = $config["publishable_key"];
            $currency = Users_Package_Model::GetCurrency();

        } else {
            $currency = Users_Package_Model::GetCurrencyGeoIp();
        }
        $packs = Users_Package_Model::GetAllPrices($currency);
        $dis['packs'] = $packs;
        $dis['currency'] = $currency;
        $dis['view'] = 'init/home';
        $this->view_front( $dis );
    }
    
    private function  getCurlData($url)
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

    public function privacy()
    {
        $dis['privacy_policy'] = true;
        $this->layout('front', 'home/privacy_policy',$dis);
    }

    public function contact()
    {
        $this->layout('contact', 'home/contact_us');
    }
    public function our_blog()
    {
        $dis['our_blog'] = true;
        $this->layout('front', 'home/our_blog',$dis);
    }
    public function help()
    {
        $dis['help'] = true;
        $this->layout('front', 'home/help',$dis);
    }
    public function termsofservice()
    {
        $dis['termsofservice'] = true;
        $this->layout('front', 'home/termsofservice',$dis);
    }
    public function cookies()
    {
        $dis['termsofservice'] = true;
        $this->layout('front', 'home/cookieusing',$dis);
    }
    public function careers()
    {
        $dis['careers'] = true;
        $this->layout('front', 'home/careers',$dis);
    }
    public function aboutus()
    {
        $dis['aboutus'] = true;
        $this->layout('front', 'home/about_us',$dis);
    }
}