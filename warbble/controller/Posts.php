<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24.09.15
 * Time: 11:00
 */
class Posts extends Controller {

    public $blogger = false;

    public function __construct() {
        parent::__construct();

        $keys = get_config('twitter');
        define('TWITTER_CONSUMER_KEY', $keys['key']);
        define('TWITTER_CONSUMER_SECRET', $keys['secret']);

        $this->blogger = new BloggerAPI();

        $this->set_filters(array(
            'tw_fetch_manual' => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'add_post' => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'add_post_facebook' => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'add_tweet' => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'add_post_blogger' => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'edit_post' => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'remove_post' => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'index' => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));

        $this->_js = array(
            array(
                'type' => 'admin',
                'file' => 'highcharts.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'moment.min.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'daterangepicker.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'media.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'osocial.js',
                'location' => 'footer',
            ),
        );

        $this->_css = array(
            array(
                'type' => 'admin',
                'file' => 'daterangepicker.css',
            ),
            array(
                'type' => 'admin',
                'file' => 'media.css',
            ),
            array(
                'type' => 'admin',
                'file' => 'social.css',
            ),
        );
    }

    public function add_account($type) {
        switch ($type) {
            case get_config('social_types')->type_twitter:
                $response = Users_Model::add_twitter_account();
                break;
            case get_config('social_types')->type_facebook:
                $response = Users_Model::add_facebook_account();
                break;
            case get_config('social_types')->type_blogger:
                /*                 * @TODO will need uncomment */
                //$response = Users_Model::add_blogger_account();
                break;
            default:
                return false;
                break;
        }

        switch ($response['status']) {
            case "redirect":
            case "redirect_error":
            case "success":
                redirect($response['url']);
                break;
            case "error":
                $dis['message'] = '<p class="error">' . $response['message'] . '</p>';
                break;
        }
    }

    /*     * add posts functions */

    public function add_post() {
        if ($this->is_ajax() && isset($_POST['socials'])) {
            $response = array(
                'Twitter' => null,
                'Facebook' => null,
                'Blogger' => null,
            );
            $current_user = Users_Model::get_current_user();
            foreach ($_POST['socials'] as $social) {
                switch ($social) {
                    case get_config('social_types')->type_twitter:
                        if ($current_user->get_twitter_tokens()) {
                            $response['Twitter'] = $this->add_tweet();
                        }
                        break;
                    case get_config('social_types')->type_facebook:
                        if ($current_user->get_fb_token()) {
                            $response['Facebook'] = $this->add_post_facebook();
                        }
                        break;
                    case get_config('social_types')->type_blogger:
                        if ($current_user->get_blogger_token()) {
                            $response['Blogger'] = $this->add_post_blogger();
                        }
                        break;
                }
            }
            echo json_encode($response);
        } else {
            echo json_encode(array('status' => false, 'errors' => array(
                    'Social type isn\'t selected.'
            )));
            exit;
        }
    }

    public function add_post_facebook() {
        if ($this->is_ajax() && isset($_POST['date']) && isset($_POST['text']) && isset($_POST['offset']) && isset($_POST['type'])) {
            $errors = array();

            if (empty($_POST['date'])) {
                $errors['date'] = 'Date field can\'t be blank.';
            }
            if (empty($_POST['text'])) {
                $errors['text'] = 'Text field can\'t be blank.';
            }

            if (empty($errors)) {
                $current_user = Users_Model::get_current_user();
                $suggested_post = isset($_POST['suggested_post_id']) && $_POST['suggested_post_id'] !== 'false' ? Suggested_posts_Model::find($_POST['suggested_post_id']) : false;
                switch ($_POST['type']) {
                    case Posts_Model::TYPE_NOW:
                        $post_fb = new Posts_Model();
                        $post_fb->social_type = get_config('social_types')->type_facebook;
                        $post_fb->user_id = $current_user->user_id;
                        $post_fb->text = $_POST['text'];
                        $post_fb->date = time();
                        $post_fb->type = $_POST['type'];
                        $post_fb->offset = $_POST['offset'];
                        $post_fb->attachment_id = $_POST['attachment_id'] !== 'false' ? $_POST['attachment_id'] : NULL;
                        $post_fb->parent_id = $suggested_post ? $suggested_post->post_id : NULL;
                        $status = $post_fb->post_to_facebook();
                        break;
                    case Posts_Model::TYPE_TIME:
                        $post_fb = new Posts_Model();
                        $post_fb->social_type = get_config('social_types')->type_facebook;
                        $post_fb->user_id = $current_user->user_id;
                        $post_fb->text = $_POST['text'];
                        $post_fb->date = strtotime($_POST['date']);
                        $post_fb->type = $_POST['type'];
                        $post_fb->offset = $_POST['offset'];
                        $post_fb->attachment_id = $_POST['attachment_id'] !== 'false' ? $_POST['attachment_id'] : NULL;
                        $post_fb->status = Posts_Model::STATUS_NOT_SENDED;
                        $post_fb->parent_id = $suggested_post ? $suggested_post->post_id : NULL;
                        $status = $post_fb->save();
                        break;
                }
                return array(
                    'status' => $status,
                    'errors' => false
                );
            } else {
                return array(
                    'status' => false,
                    'errors' => $errors
                );
            }
        }
        exit;
    }

    public function add_tweet() {
        if ($this->is_ajax() && isset($_POST['date']) && isset($_POST['text']) && isset($_POST['offset']) && isset($_POST['type'])) {
            $errors = array();

            if (empty($_POST['date'])) {
                $errors['date'] = 'Date field can\'t be blank.';
            }
            if (empty($_POST['text'])) {
                $errors['text'] = 'Text field can\'t be blank.';
            }

            if (empty($errors)) {
                $current_user = Users_Model::get_current_user();
                $suggested_post = isset($_POST['suggested_post_id']) && $_POST['suggested_post_id'] !== 'false' ? Suggested_posts_Model::find($_POST['suggested_post_id']) : false;
                switch ($_POST['type']) {
                    case Posts_Model::TYPE_NOW:
                        $tweet = new Posts_Model();
                        $tweet->social_type = get_config('social_types')->type_twitter;
                        $tweet->user_id = $current_user->user_id;
                        $tweet->text = $_POST['text'];
                        $tweet->date = time();
                        $tweet->type = $_POST['type'];
                        $tweet->offset = $_POST['offset'];
                        $tweet->status = Posts_Model::STATUS_SENDED;
                        $tweet->attachment_id = $_POST['attachment_id'] !== 'false' ? $_POST['attachment_id'] : NULL;
                        $tweet->parent_id = $suggested_post ? $suggested_post->post_id : NULL;
                        $status = $tweet->post_to_twitter();
                        break;
                    case Posts_Model::TYPE_TIME:
                        $tweet = new Posts_Model();
                        $tweet->social_type = get_config('social_types')->type_twitter;
                        $tweet->user_id = $current_user->user_id;
                        $tweet->text = $_POST['text'];
                        $tweet->date = strtotime($_POST['date']);
                        $tweet->type = $_POST['type'];
                        $tweet->offset = $_POST['offset'];
                        $tweet->status = Posts_Model::STATUS_NOT_SENDED;
                        $tweet->attachment_id = $_POST['attachment_id'] !== 'false' ? $_POST['attachment_id'] : NULL;
                        $tweet->parent_id = $suggested_post ? $suggested_post->post_id : NULL;
                        $status = $tweet->save();
                        break;
                }
                return array(
                    'status' => $status,
                    'errors' => false
                );
            } else {
                return array(
                    'status' => false,
                    'errors' => $errors
                );
            }
        }
        exit;
    }

    public function add_post_blogger() {
        if ($this->is_ajax() && isset($_POST['date']) && isset($_POST['text']) && isset($_POST['offset']) && isset($_POST['type'])) {
            $errors = array();

            if (empty($_POST['date'])) {
                $errors['date'] = 'Date field can\'t be blank.';
            }
            if (empty($_POST['text'])) {
                $errors['text'] = 'Text field can\'t be blank.';
            }

            if (empty($errors)) {
                $current_user = Users_Model::get_current_user();
                $blogs = $this->blogger->get_blogs();
                switch ($_POST['type']) {
                    case Posts_Model::TYPE_NOW:
                        foreach ($blogs->items as $blog) {
                            $post_bl = new Posts_Model();
                            $post_bl->social_type = get_config('social_types')->type_blogger;
                            $post_bl->user_id = $current_user->user_id;
                            $post_bl->text = $_POST['text'];
                            $post_bl->date = time();
                            $post_bl->type = $_POST['type'];
                            $post_bl->offset = $_POST['offset'];
                            $post_bl->blog_id = $blog->id;
                            $post_bl->attachment_id = $_POST['attachment_id'] !== 'false' ? $_POST['attachment_id'] : NULL;
                            if ($id = $post_bl->post_to_blogger()) {
                                $post_bl->status = Posts_Model::STATUS_SENDED;
                                $post_bl->remote_id = $id;
                                $status = $post_bl->save();
                            } else {
                                $post_bl->status = Posts_Model::STATUS_FILED;
                                $post_bl->save();
                                echo json_encode(array('status' => false, 'errors' => array(
                                        $post_bl->post_to_error,
                                )));
                                exit;
                            }
                        }
                        break;
                    case Posts_Model::TYPE_TIME:
                        foreach ($blogs->items as $blog) {
                            $post_bl = new Posts_Model();
                            $post_bl->social_type = get_config('social_types')->type_blogger;
                            $post_bl->user_id = $current_user->user_id;
                            $post_bl->text = $_POST['text'];
                            $post_bl->date = strtotime($_POST['date']);
                            $post_bl->type = $_POST['type'];
                            $post_bl->offset = $_POST['offset'];
                            $post_bl->blog_id = $blog->id;
                            $post_bl->attachment_id = $_POST['attachment_id'] !== 'false' ? $_POST['attachment_id'] : NULL;
                            $post_bl->status = Posts_Model::STATUS_NOT_SENDED;
                            $status = $post_bl->save();
                        }
                        break;
                }
                return array(
                    'status' => $status,
                    'errors' => false
                );
            } else {
                return array(
                    'status' => false,
                    'errors' => $errors
                );
            }
        }
        exit;
    }

    /*     * end add postss functions */

    public function edit_post() {
        if ($this->is_ajax() && isset($_POST['id'])) {
            $current_user = Users_Model::get_current_user();
            $post = Posts_Model::first(array('id' => $_POST['id']));

            switch ($post->social_type) {
                case get_config('social_types')->type_twitter:
                    $html = $this->load->view('twitter/_view', array('post' => $post), TRUE);
                    break;
                case get_config('social_types')->type_facebook:
                    $html = $this->load->view('facebook/_view', array('post' => $post), TRUE);
                    break;
                case get_config('social_types')->type_blogger:
                    $html = $this->load->view('blogger/_view', array('post' => $post), TRUE);
                    break;
                default:
                    $html = $this->load->view('twitter/_view', array('tweet' => $post), TRUE);
                    break;
            }

            if ($post && $post->user_id == $current_user->user_id) {
                echo json_encode(array('status' => true, 'post' => $post->attributes(), 'html' => $html));
            } else {
                echo json_encode(array('status' => false));
            }
        }
        exit;
    }

    function view_suggested() {
        if ($this->is_ajax() && isset($_POST['post_id'])) {
            $model = Suggested_posts_Model::find($_POST['post_id']);
            if ($model) {
                $attributes = $model->attributes();
                $attributes['channels'] = json_decode($attributes['channels'], true);
                $attributes['image'] = $model->attachment ? BASE_URL . $model->attachment->uri : FALSE;
                echo json_encode(array(
                    'status' => true,
                    'model' => $attributes,
                ));
            } else {
                echo json_encode(array(
                    'status' => false,
                ));
            }
        }
        exit;
    }

    function attach_post() {
        if ($this->is_ajax() && isset($_POST['post_id'])) {
            $current_user = Users_Model::get_current_user();
            $model = Suggested_posts_Model::find($_POST['post_id']);
            if ($model) {
                $attributes = $model->attributes();
                $attributes['channels'] = json_decode($attributes['channels'], true);
                $post = new Suggested_posts_user_Model(array(
                    'post_id' => $model->id,
                    'user_id' => $current_user->user_id,
                    'date' => time(),
                    'feedback' => NULL,
                    'status' => Suggested_posts_user_Model::STATUS_APPROVED,
                ));

                if ($post->save()) {
                    echo json_encode(array(
                        'status' => true,
                        'model' => $attributes,
                        'suggested_post_id' => $_POST['post_id'],
                    ));
                }
            } else {
                echo json_encode(array(
                    'status' => false,
                ));
            }
        }
        exit;
    }

    function detach_post() {
        if ($this->is_ajax() && isset($_POST['post_id']) && isset($_POST['feedback'])) {
            $current_user = Users_Model::get_current_user();
            $model = Suggested_posts_Model::find($_POST['post_id']);
            if ($model) {
                $attributes = $model->attributes();
                $attributes['channels'] = json_decode($attributes['channels'], true);
                $post = new Suggested_posts_user_Model(array(
                    'post_id' => $model->id,
                    'user_id' => $current_user->user_id,
                    'date' => time(),
                    'feedback' => $_POST['feedback'],
                    'status' => Suggested_posts_user_Model::STATUS_REJECTED,
                ));

                if ($post->save()) {
                    echo json_encode(array(
                        'status' => true,
                        'model' => $attributes,
                    ));
                }
            } else {
                echo json_encode(array(
                    'status' => false,
                ));
            }
        }
        exit;
    }

    public function remove_post() {
        if ($this->is_ajax() && isset($_POST['id'])) {
            $current_user = Users_Model::get_current_user();
            $post = Posts_Model::first(array('id' => $_POST['id']));
            if ($post && $post->user_id == $current_user->user_id) {
                switch ($post->social_type) {
                    case get_config('social_types')->type_twitter:
                        $status = $post->remove_tweet_post();
                        break;
                    case get_config('social_types')->type_facebook:
                        $status = $post->remove_fb_post();
                        break;
                    case get_config('social_types')->type_blogger:
                        $status = $post->remove_blogger_post();
                        break;
                }
                echo json_encode(array('status' => $status));
            } else {
                echo json_encode(array('status' => false));
            }
        }
        exit;
    }

    function index() {
        $this->access_iframe(Controller::IFRAME_ACCESS_SELF_DOMAIN);
        $current_user = Users_Model::get_current_user();

        $gridview_sheduled = new Gridview(array(
            'table_name' => 'Scheduled Posts',
            'model_name' => 'Posts_Model',
            'order' => 'date desc',
            'conditions' => sprintf('user_id = %d AND status != %s', $current_user->user_id,Posts_Model::STATUS_SENDED),
            'columns' => array(
                array(
                    'name'=>'date'
                ),
                array(
                    'name'=>'text'
                ),
                array(
                    'name' => 'social_type'                    
                ),
            ),
            'pagination' => array(
                'per_page' => 5
            ),
        ));
        
        $gridview_history = new Gridview(array(
            'table_name' => 'History',
            'model_name' => 'Posts_Model',
            'order' => 'date desc',
            'conditions' => sprintf('user_id = %d AND status = %s', $current_user->user_id,Posts_Model::STATUS_SENDED),
            
            'pagination' => array(
                'per_page' => 5
            ),
        ));

        $gridview_suggested_posts = new Gridview(array(
            'table_name' => 'Suggested Posts',
            'model_name' => 'Suggested_posts_Model',
            'select' => 'sp2.*',
            'from' => '( SELECT DISTINCT sp1.* FROM suggested_posts sp1 LEFT JOIN suggested_posts_user spu1 ON sp1.id = spu1.post_id WHERE spu1.id IS NULL ) sp2',
            'joins' => 'LEFT JOIN suggested_posts_to spt2 ON sp2.id = spt2.post_id',
            'conditions' => sprintf('spt2.id IS NULL OR (spt2.id IS NOT NULL AND spt2.user_id = %d)', $current_user->user_id),
            'order' => 'sp2.id desc',
            'columns' => array(
                array(
                    'title' => 'Message',
                    'filter' => function($model) {
                        return strlen($model->message) > 30 ? (substr($model->message, 0, 30) . "...") : $model->message;
                    },
                ),
                array(
                    'title' => 'Channels',
                    'filter' => function($model) {
                        return $model->channels_images();
                    },
                ),
                array(
                    'title' => 'Actions',
                    'filter' => function($model) {
                        return sprintf('<div class="pull-right">
                                            <a href="#" data-id="%s" class="add_suggested_post gridview-btn-ok"></span></a>
                                            <a href="#" data-id="%s" class="view_suggested_posts gridview-btn-edit"></a>
                                            <a href="#" data-id="%s" class="remove_suggested_post gridview-btn-remove"></span></a>
                                        </div>', $model->id, $model->id, $model->id);
                    },
                ),
            ),
            'pagination' => array(
                'per_page' => 3
            ),
        ));

        $this->layout('admin', 'posts/posts', array(
            '_tab' => 'posts/_tab_posts',
            'tab_data' => array(
                'current_user' => $current_user,
                //'gridview' => $gridview,
                'gridview_sheduled'=>$gridview_sheduled,
                'gridview_history'=>$gridview_history,
                'gridview_suggested_posts' => $gridview_suggested_posts,
                'medialibrary' => $this->medialibrary,
            ),
            'post' => true,
        ));
    }

    public static function get_socialclases($social_type) {
        return Posts_Model::get_socialclases($social_type);
    }

    public static function get_socialclasesNew($social_type) {
        return Posts_Model::get_socialclasesNew($social_type);
    }
    
    public static function get_socialclasesView($social_type) {
        return Posts_Model::get_socialclasesView($social_type);
    }

}
