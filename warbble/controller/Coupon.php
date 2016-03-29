<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.08.15
 * Time: 10:09
 */
class Coupon extends Controller
{
    public $coupon = array();
    public $coupon_id = "";

    public function __construct()
    {
        parent::__construct();

//        $this->load->library('QrCode');
//        $this->qrcode = new QrCode();
        $this->load->library('Upload');
        $this->load->library('phpqrcode/qrlib');
        $this->load->library('drawcoupon/DrawCoupon');

        $this->_js = array
        (
            array(
                'type'      => 'admin',
                'file'      => 'slick.min.js',
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
                    'file'      => 'bootstrap-paginator.min.js',
                    'location'  => 'footer',
            ),
            array(
                    'type'      => 'admin',
                    'file'      => 'media.js',
                    'location'  => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'coupon.js',
                'location'  => 'footer',
            ),
            );

        $this->_css = array
        (
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
                    'file'      => 'coupon.css',
            ),
            array(
                    'type'      => 'admin',
                    'file'      => 'daterangepicker.css',
            ),
            array(
                    'type'      => 'admin',
                    'file'      => 'media.css',
            ),
            array(
                    'type'      => 'admin',
                    'file'      => 'social.css',
            ),

        );

        $this->set_filters(array(
            'index'                 => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'create'                => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'preview'               => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'getSocialPics'         => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'getSocialViews'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'getSocialHtmls'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'edit'                  => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'share'                 => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'save'                  => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'shedule'               => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'shedulefillCoupon'     => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'getQRCode'             => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));

    }

    public function index()
    {
        $current_user       = Users_Model::get_current_user();
        $favorites_chart    = array('Favorites');
        $retweets_chart     = array('Retweets');
        $favorites_count    = 0;
        $retweets_count     = 0;
        $company_logo = array(
            "id" => "",
            "url" => ""
        );

        if($this->is_ajax())
        {
            $type = $_POST['type'];
            $html_twitter = $this->load->view('', array(), TRUE);
            exit;
        }

        $this->layout('admin', 'coupons/create', array(
            'current_user'      => $current_user,
            'favorites_chart'   => $favorites_chart,
            'retweets_chart'    => $retweets_chart,
            'favorites_count'   => $favorites_count,
            'retweets_count'    => $retweets_count
        ));

    }

    public function create()
    {

        $this->coupon = $this->fillCoupon();
        $current_user       = Users_Model::get_current_user();
        $is_valid_token = false;


        if($this->is_ajax())
        {
            $type = $_POST['type'];
            $html_twitter = $this->load->view('', array(), TRUE);
            exit;
        }
        if (isset($_POST['formToken'])) {
            if ($this->formToken->is_token_valid()) {
                $is_valid_token = true;
                // do something here
            } else {
                // invalid token
                $is_valid_token = false;
            }
        }

        $this->layout('admin', 'coupons/create', array(
            'medialibrary' => $this->medialibrary,
            'coupon' => $this->coupon,
            'is_valid_token' => $is_valid_token,
            'formToken' => $this->formToken->renderToken(),
        ));
    }

    public function preview()
    {
        if($this->is_ajax()) {

            if (!$new_token = $this->formToken->is_token_valid()) {
                // failed
                $this->ajax_response(array('message' => 'Invalid token', 'token'=> $new_token), 403);
            } else {
                $pics = $this->getSocialPics();
                $htmls = $this->getSocialViews($pics);
                if (count($htmls) === 1) {
                    foreach ($htmls as $htmlelement)
                        $htmls["duplicate"] = $htmlelement;
                }

                $html = $this->load->view('coupons/preview', array("htmls" => $htmls), TRUE);

                echo json_encode(array('html' => $html, 'formToken' => $new_token));

                exit;
            }
        }
    }

    private function getSocialPics()
    {
        if($this->is_ajax()) {

            if (!empty($_POST['coupon'])) {
                $this->coupon = $_POST['coupon'];

                $current_user = Users_Model::get_current_user();
                if (!empty($current_user->user_id)) {
                    /**Get attachment url from database*/
                    $media = new Media_Model();
                    $company_logo = $media->first(array('conditions' => array('user_id = ? AND id = ?', $current_user->user_id, $this->coupon['company']['logo'])));
                    if ($company_logo) {
                        $this->coupon['company']['logo-url'] = BASE_URL . $company_logo->uri;
                    }
                    if (!empty($_POST['coupon']['codechoice'])) {
                        switch ($_POST['coupon']['codechoice']) {
                            case "barcode":
                                $barcode_pics = $media->first(array('conditions' => array('user_id = ? AND id = ?', $current_user->user_id, $this->coupon['barcodeattachid'])));
                                if ($barcode_pics) {
                                    $this->coupon['barcodeattachurl'] = BASE_URL . $barcode_pics->uri;
                                }
                                break;
                            case "qrcode":
                                $qrcode = $this->getQRCode("preview");
                                $this->coupon['qrcodetext'] = $qrcode['qrcode'];
                                break;
                            default:
                                break;
                        }
                    }

                    /*create coupon model*/
                    $newCoupon = new Coupon_Model();

                    $newCoupon->user_id                     = $current_user->user_id;
                    $newCoupon->title                       = $this->coupon['title'];
                    $newCoupon->discount                    = $this->coupon['discount'];
                    $newCoupon->text                        = $this->coupon['text'];
                    $newCoupon->company_name                = $this->coupon['company']['name'];
                    $newCoupon->company_url                 = $this->coupon['company']['site'];
                    $newCoupon->company_addr                = $this->coupon['company']['address'];
                    $newCoupon->company_phone               = $this->coupon['company']['phone'];
                    $newCoupon->logo_id                     = $this->coupon['company']['logo'];
                    $newCoupon->barcode_id                  = $this->coupon['barcodeattachid'];
                    $newCoupon->from_date                   = $this->coupon['durationfrom'];
                    $newCoupon->to_date                     = $this->coupon['durationto'];

                    $this->drawcoupon = new DrawCoupon();
                    $pictures = array();
                    if(!empty($_POST['socials'])) {
                        foreach($_POST['socials'] as $social) {
                            if($social == get_config('social_types')->type_facebook){
                                $pictures['facebook'] = $this->drawcoupon->renderFacebook(decode_ecran_form_fields($newCoupon), false);
                            }elseif($social == get_config('social_types')->type_twitter){
                                $pictures['twitter'] = $this->drawcoupon->renderTwitter(decode_ecran_form_fields($newCoupon), false);
                            }elseif($social == get_config('social_types')->type_blogger){
                                $pictures['blogger'] = $this->drawcoupon->renderBlogger(decode_ecran_form_fields($newCoupon), false);
                            }
                            //comment instagram becaus not made functional
                            /*@TODO will need uncomment*/
                            //elseif($social == get_config('social_types')->type_instagram){
                            //  $pictures['instagram'] = $this->drawcoupon->renderInstagram(decode_ecran_form_fields($newCoupon), false);
                            //}
                        }
                    }

                    return $pictures;

                }
            } else {
                return false;
            }
        }
    }

    private function getSocialViews($pics)
    {
        if($this->is_ajax()) {

            $htmls = array();
            if(!empty($_POST['socials'])) {
                foreach ($_POST['socials'] as $social) {
                    if ($social == get_config('social_types')->type_facebook) {
                        $htmls['facebook'] = $this->load->view('coupons/preview_facebook', array("coupon_data" => $pics['facebook']), TRUE);
                    }elseif($social == get_config('social_types')->type_twitter){
                        $htmls['twitter'] = $this->load->view('coupons/preview_twitter', array("coupon_data" => $pics['twitter']), TRUE);
                    }elseif($social == get_config('social_types')->type_blogger){
                        $htmls['blogger'] = $this->load->view('coupons/preview_blogger', array("coupon_data" => $pics['blogger']), TRUE);
                    }//comment instagram becaus not made functional
                    /*@TODO will need uncomment*/
                    //elseif($social == get_config('social_types')->type_instagram){
                    //    $htmls['instagram'] = $this->load->view('coupons/preview_instagram', array("coupon_data" => $pics['instagram']), TRUE);
                    //}
                }

            }

            return $htmls;
        }
    }

    public function getSocialHtmls()
    {
        if($this->is_ajax()) {

            $pics = $this->getSocialPics();
            $htmls = $this->getSocialViews($pics);
            $htmls['socialwrapper'] = $this->load->view('coupons/create_social', array(), TRUE);
            if(!empty($htmls))
            {
                echo json_encode(array('htmls' => $htmls));
                exit;
            }
        }
    }

    public function edit()
    {

    }

    public function share()
    {

    }

    public function save()
    {
        if($this->is_ajax()) {
//            if (!$new_token = $this->formToken->is_token_valid()) {
//                // failed
//                $this->ajax_response(array('message' => 'Invalid token'), 403);
//            } else {
                $errors = array();
                if (!empty($_POST['coupon']) && !empty($_POST['socials'])) {
                    $this->coupon = $this->fillCoupon();
                    $current_user = Users_Model::get_current_user();
                    if (!empty($current_user->user_id)) {

                        /*create coupon model for database*/
                        $newCoupon = new Coupon_Model();

                        $newCoupon->user_id = $current_user->user_id;
                        $newCoupon->title = $this->coupon['title'];
                        $newCoupon->discount = $this->coupon['discount'];
                        $newCoupon->text = $this->coupon['text'];
                        //$newCoupon->attach_id_facebook          = $this->coupon['barcodeattachid'];
                        //$newCoupon->attach_id_twitter           = $this->coupon['barcodeattachid'];
                        //$newCoupon->attach_id_instagram        = $this->coupon['barcodeattachid'];
                        $newCoupon->company_name = $this->coupon['company']['name'];
                        $newCoupon->company_url = $this->coupon['company']['site'];
                        $newCoupon->company_addr = $this->coupon['company']['address'];
                        $newCoupon->company_phone = $this->coupon['company']['phone'];
                        $newCoupon->logo_id = $this->coupon['company']['logo'];
                        $newCoupon->barcode_id = $this->coupon['barcodeattachid'];
                        $newCoupon->from_date = $this->coupon['durationfrom'];
                        $newCoupon->to_date = $this->coupon['durationto'];

                        $this->drawcoupon = new DrawCoupon();


                        foreach ($_POST['socials'] as $social) {

                            if ($social == get_config('social_types')->type_facebook && $current_user->get_fb_token()) {
                                $facebook_coupon = $this->drawcoupon->renderFacebook(decode_ecran_form_fields($newCoupon), false);
                                $media = new Media_Model();
                                $attach_data = $media->saveAttachment($facebook_coupon, 'facebookcoupon', $current_user->user_id);
                                $media->user_id = $current_user->user_id;
                                $media->name = basename($attach_data['result']['uri']);
                                $media->type = "facebookcoupon";
                                $media->mime = $facebook_coupon['filetype'];
                                $media->uri = $attach_data['result']['uri'];
                                $status = $media->save();
                                $newCoupon->attach_id_facebook = $media->id;
                            }

                            if ($social == get_config('social_types')->type_twitter && $current_user->get_twitter_tokens()) {
                                $twitter_coupon = $this->drawcoupon->renderTwitter(decode_ecran_form_fields($newCoupon), false);
                                $media = new Media_Model();
                                $attach_data = $media->saveAttachment($twitter_coupon, 'twittercoupon', $current_user->user_id);
                                $media->user_id = $current_user->user_id;
                                $media->name = basename($attach_data['result']['uri']);
                                $media->type = "twittercoupon";
                                $media->mime = $twitter_coupon['filetype'];
                                $media->uri = $attach_data['result']['uri'];
                                $status = $media->save();
                                $newCoupon->attach_id_twitter = $media->id;
                            }

                            /*
                            if($social == get_config('social_types')->type_instagram && $current_user->if_is_have_instagram_account) {
                                $instagram_coupon = $this->drawcoupon->renderInstagram(decode_ecran_form_fields($newCoupon), false);$media = new Media_Model();
                                $attach_data = $media->saveAttachment($instagram_coupon, 'instagramcoupon', $current_user->user_id);
                                $media->user_id     = $current_user->user_id;
                                $media->name        = basename($attach_data['result']['uri']);
                                $media->type        = "instagramcoupon";
                                $media->mime        = $instagram_coupon['filetype'];
                                $media->uri      = $attach_data['result']['uri'];
                                $status = $media->save();
                                $newCoupon->attach_id_instagram = $media->id;
                            }*/

                            if ($social == get_config('social_types')->type_blogger && $current_user->get_blogger_token()) {
                                $blogger_coupon = $this->drawcoupon->renderBlogger(decode_ecran_form_fields($newCoupon), false);
                                $media = new Media_Model();
                                $attach_data = $media->saveAttachment($blogger_coupon, 'bloggercoupon', $current_user->user_id);
                                $media->user_id = $current_user->user_id;
                                $media->name = basename($attach_data['result']['uri']);
                                $media->type = "bloggercoupon";
                                $media->mime = $blogger_coupon['filetype'];
                                $media->uri = $attach_data['result']['uri'];
                                $status = $media->save();
                                $newCoupon->attach_id_blogger = $media->id;
                            }
                        }


                        /*save coupon into database*/
                        $couponStatus = $newCoupon->save();
                        if (!$couponStatus || $couponStatus == null) {
                            echo json_encode(array('succes' => false, 'errors' => array('Coupon was not saved')));
                            exit;
                        }


                        /*Send social posts*/
                        foreach ($_POST['socials'] as $social) {

                            //send twitter
                            if ($social == get_config('social_types')->type_twitter && $current_user->get_twitter_tokens() && !empty($newCoupon->attach_id_twitter)) {
                                $tweet = new Posts_Model();
                                $tweet->social_type = get_config('social_types')->type_twitter;
                                $tweet->user_id = $current_user->user_id;
                                $tweet->text = $newCoupon->title;
                                $tweet->date = time();
                                $tweet->type = Posts_Model::TYPE_NOW;
                                $tweet->offset = 0;
                                $tweet->status = Posts_Model::STATUS_SENDED;
                                $tweet->attachment_id = $newCoupon->attach_id_twitter !== 'false' ? $newCoupon->attach_id_twitter : NULL;
                                if ($status = $tweet->post_to_twitter()) {
                                    $tweet->remote_id = $status->id;
                                    $twitterStatus = $tweet->save();
                                }
                            }

                            //send facebook
                            if ($social == get_config('social_types')->type_facebook && $current_user->get_fb_token() && !empty($newCoupon->attach_id_facebook)) {
                                $post_fb = new Posts_Model();
                                $post_fb->social_type = get_config('social_types')->type_facebook;
                                $post_fb->user_id = $current_user->user_id;
                                $post_fb->text = $newCoupon->title;
                                $post_fb->date = time();
                                $post_fb->type = Posts_Model::TYPE_NOW;
                                $post_fb->offset = 0;
                                $post_fb->attachment_id = $newCoupon->attach_id_facebook !== 'false' ? $newCoupon->attach_id_facebook : NULL;
                                $status = $post_fb->post_to_facebook();
                            }

                            //send instagram
                            /*@TODO here will need send instagram, blogger, google+, linkedin, pinterest and other posts*/

                            //send blogger
                            if ($social == get_config('social_types')->type_blogger && $current_user->get_blogger_token() && !empty($newCoupon->attach_id_blogger)) {

                                $blogger = new BloggerAPI();
                                $blogs = $blogger->get_blogs();
                                foreach ($blogs->items as $blog) {
                                    $post_bl = new Posts_Model();
                                    $post_bl->user_id = $current_user->user_id;
                                    $post_bl->social_type = get_config('social_types')->type_blogger;
                                    $post_bl->text = $newCoupon->title;
                                    $post_bl->date = time();
                                    $post_bl->type = Posts_Model::TYPE_NOW;
                                    $post_bl->offset = 0;
                                    $post_bl->blog_id = $blog->id;
                                    $post_bl->attachment_id = $newCoupon->attach_id_blogger !== 'false' ? $newCoupon->attach_id_blogger : NULL;
                                    if ($id = $post_bl->post_to_blogger()) {
                                        $post_bl->status = Posts_Model::STATUS_SENDED;
                                        $post_bl->remote_id = $id;
                                        $bloggerStatus = $post_bl->save();
                                    } else {
                                        $post_bl->status = Posts_Model::STATUS_FILED;
                                        $post_bl->save();
                                        echo json_encode(array('status' => false, 'errors' => array("not created coupon into blogger!")));
                                        exit;
                                    }
                                }

                            }
                        }
                        /*End Send socil posts*/

                        echo json_encode(array("succes" => true, 'formToken' => $new_token));
                        exit;
                    }
                } else {
                    echo json_encode(array("errors" => array("data is empty!"), 'formToken' => $new_token));
                    exit;
                }
//            }
        }
    }

    public function shedule()
    {
        if($this->is_ajax()) {
            if (!$new_token = $this->formToken->is_token_valid()) {
                // failed
                $this->ajax_response(array('message' => 'Invalid token'), 403);
            } else {
                $errors = array();
                if (!empty($_POST['coupon']) && !empty($_POST['socials'])) {
                    $this->coupon = $this->fillCoupon();
                    $current_user = Users_Model::get_current_user();
                    if (!empty($current_user->user_id)) {

                        /*create coupon model for database*/
                        $newCoupon = new Coupon_Model();

                        $newCoupon->user_id = $current_user->user_id;
                        $newCoupon->title = $this->coupon['title'];
                        $newCoupon->discount = $this->coupon['discount'];
                        $newCoupon->text = $this->coupon['text'];
                        //$newCoupon->attach_id_facebook          = $this->coupon['barcodeattachid'];
                        //$newCoupon->attach_id_twitter           = $this->coupon['barcodeattachid'];
                        //$newCoupon->attach_id_instagram        = $this->coupon['barcodeattachid'];
                        $newCoupon->company_name = $this->coupon['company']['name'];
                        $newCoupon->company_url = $this->coupon['company']['site'];
                        $newCoupon->company_addr = $this->coupon['company']['address'];
                        $newCoupon->company_phone = $this->coupon['company']['phone'];
                        $newCoupon->logo_id = $this->coupon['company']['logo'];
                        $newCoupon->barcode_id = $this->coupon['barcodeattachid'];
                        $newCoupon->from_date = $this->coupon['durationfrom'];
                        $newCoupon->to_date = $this->coupon['durationto'];

                        $this->drawcoupon = new DrawCoupon();

                        foreach ($_POST['socials'] as $social) {

                            if ($social == get_config('social_types')->type_facebook && $current_user->get_fb_token()) {
                                $facebook_coupon = $this->drawcoupon->renderFacebook(decode_ecran_form_fields($newCoupon), false);
                                $media = new Media_Model();
                                $attach_data = $media->saveAttachment($facebook_coupon, 'facebookcoupon', $current_user->user_id);
                                $media->user_id = $current_user->user_id;
                                $media->name = basename($attach_data['result']['uri']);
                                $media->type = "facebookcoupon";
                                $media->mime = $facebook_coupon['filetype'];
                                $media->uri = $attach_data['result']['uri'];
                                $status = $media->save();
                                $newCoupon->attach_id_facebook = $media->id;
                            }

                            if ($social == get_config('social_types')->type_twitter && $current_user->get_twitter_tokens()) {
                                $twitter_coupon = $this->drawcoupon->renderTwitter(decode_ecran_form_fields($newCoupon), false);
                                $media = new Media_Model();
                                $attach_data = $media->saveAttachment($twitter_coupon, 'twittercoupon', $current_user->user_id);
                                $media->user_id = $current_user->user_id;
                                $media->name = basename($attach_data['result']['uri']);
                                $media->type = "twittercoupon";
                                $media->mime = $twitter_coupon['filetype'];
                                $media->uri = $attach_data['result']['uri'];
                                $status = $media->save();
                                $newCoupon->attach_id_twitter = $media->id;
                            }

                            /*if($social == get_config('social_types')->type_instagram && $current_user->if_is_have_instagramm_account) {
                                $instagram_coupon = $this->drawcoupon->renderInstagram(decode_ecran_form_fields($newCoupon), false);
                                $media = new Media_Model();
                                $attach_data = $media->saveAttachment($instagram_coupon, 'instagramcoupon', $current_user->user_id);
                                $media->user_id = $current_user->user_id;
                                $media->name = basename($attach_data['result']['uri']);
                                $media->type = "instagramcoupon";
                                $media->mime = $instagram_coupon['filetype'];
                                $media->uri = $attach_data['result']['uri'];
                                $status = $media->save();
                                $newCoupon->attach_id_instagram = $media->id;
                            }*/

                            if ($social == get_config('social_types')->type_blogger && $current_user->get_blogger_token()) {
                                $blogger_coupon = $this->drawcoupon->renderBlogger(decode_ecran_form_fields($newCoupon), false);
                                $media = new Media_Model();
                                $attach_data = $media->saveAttachment($blogger_coupon, 'bloggercoupon', $current_user->user_id);
                                $media->user_id = $current_user->user_id;
                                $media->name = basename($attach_data['result']['uri']);
                                $media->type = "bloggercoupon";
                                $media->mime = $blogger_coupon['filetype'];
                                $media->uri = $attach_data['result']['uri'];
                                $status = $media->save();
                                $newCoupon->attach_id_blogger = $media->id;
                            }
                        }

                        /*save coupon into database*/
                        $couponStatus = $newCoupon->save();
                        if (!$couponStatus || $couponStatus == null) {
                            echo json_encode(array('succes' => false, 'errors' => array('Coupon was not saved')));
                            exit;
                        }

                        /*Send social posts*/
                        foreach ($_POST['socials'] as $social) {
                            //send twitter
                            if ($social == get_config('social_types')->type_twitter && $current_user->get_twitter_tokens() && !empty($newCoupon->attach_id_twitter)) {
                                $tweet = new Posts_Model();
                                $tweet->social_type = get_config('social_types')->type_twitter;
                                $tweet->user_id = $current_user->user_id;
                                $tweet->text = $newCoupon->title;
                                $tweet->date = $_POST['scheduledate'];
                                $tweet->type = Posts_Model::TYPE_TIME;
                                $tweet->offset = 0;
                                $tweet->status = Posts_Model::STATUS_NOT_SENDED;
                                $tweet->attachment_id = $newCoupon->attach_id_twitter !== 'false' ? $newCoupon->attach_id_twitter : NULL;
                                $twitterStatus = $tweet->save();
                            }

                            //send facebook
                            if ($social == get_config('social_types')->type_facebook && $current_user->get_fb_token() && !empty($newCoupon->attach_id_facebook)) {
                                $post_fb = new Posts_Model();
                                $post_fb->social_type = get_config('social_types')->type_facebook;
                                $post_fb->user_id = $current_user->user_id;
                                $post_fb->text = $newCoupon->title;
                                $post_fb->date = $_POST['scheduledate'];
                                $post_fb->type = Posts_Model::TYPE_TIME;
                                $post_fb->offset = 0;
                                $post_fb->status = Posts_Model::STATUS_NOT_SENDED;
                                $post_fb->attachment_id = $newCoupon->attach_id_facebook !== 'false' ? $newCoupon->attach_id_facebook : NULL;
                                $facebookStatus = $post_fb->save();
                            }

                            //send instagram
                            /*@TODO here will need send instagram, blogger, google+, linkedin, pinterest and other posts*/

                            //send blogger
                            if ($social == get_config('social_types')->type_blogger && $current_user->get_blogger_token() && !empty($newCoupon->attach_id_blogger)) {
                                $blogger = new BloggerAPI();
                                $blogs = $blogger->get_blogs();
                                foreach ($blogs->items as $blog) {
                                    $post_bl = new Posts_Model();
                                    $post_bl->social_type = get_config('social_types')->type_blogger;
                                    $post_bl->user_id = $current_user->user_id;
                                    $post_bl->text = $newCoupon->title;
                                    $post_bl->date = $_POST['scheduledate'];
                                    $post_bl->type = Posts_Model::TYPE_TIME;
                                    $post_bl->offset = 0;
                                    $post_bl->blog_id = $blog->id;
                                    $post_bl->attachment_id = $newCoupon->attach_id_blogger !== 'false' ? $newCoupon->attach_id_blogger : NULL;
                                    $post_bl->status = Posts_Model::STATUS_NOT_SENDED;
                                    $status = $post_bl->save();
                                }
                            }
                        }
                        /*End Send socil posts*/
                        echo json_encode(array("succes" => true, 'formToken' => $new_token));
                        exit;
                    }
                } else {
                    echo json_encode(array("errors" => array("data is empty!"), 'formToken' => $new_token));
                    exit;
                }
            }
        }
    }

    /**
     * Fill $this->coupon data from $_REQUEST
    */
    private function fillCoupon()
    {
        if(!empty($_REQUEST['coupon']) && !empty($_REQUEST['action'])) {
            $result = $_REQUEST['coupon'];
            ecran_form_fields($result);
            return $result;
        } else {
            return array();
        }
    }

    /**
     * Can create coupon when all fields fill
    */
    private function isCanCreate()
    {

    }

    public function getQRCode($view = false)
    {
        $current_user = Users_Model::get_current_user();
        $currentCoupon = array();

        if($this->is_ajax()) {
            $errors = false;
            if (isset($_REQUEST['coupon'])) {
                $currentCoupon = $this->fillCoupon();
            } else {
                $errors = "Empty coupon!";
            }
            $intoCode = $currentCoupon['company']['site'] . "\n";
            $intoCode .= $current_user->email . "\n";
            //@TODO ask Alexey when he will created this methods
            //Alexey will created this methods
            if($current_user->get_twitter_tokens()) {
              $intoCode .= "http://twitter.com/" . $current_user->get_usermeta('twitter_name')->meta_value . "\n";
            }
            if($current_user->get_fb_token()) {
              $intoCode .= "http://facebook.com/" . $current_user->get_usermeta('facebook_name')->meta_value;
            }
            if($current_user->get_blogger_token()) {
                $intoCode .= "https://www.blogger.com/" . $current_user->get_usermeta('blogger_name')->meta_value;
            }

            $modelCoupon = new Coupon_Model();
            $qrrr = $modelCoupon->getQRCode($intoCode);


            if($view === "preview") {
                if (!empty($errors)) {
                    return array('errors' => $errors);
                } else {
                    return array('qrcode' => base64_encode($qrrr));
                }
            } elseif($view === "qrcode") {
                if (!empty($errors)) {
                    echo json_encode(array('errors' => $errors));
                } else {
                    echo json_encode(array('qrcode' => base64_encode($qrrr)));
                }
            }
            exit();
        }
    }

}