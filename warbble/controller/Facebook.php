<?php

class Facebook extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->_js = array(
            array(
                'type'      => 'admin',
                'file'      => 'highcharts.js',
                'location'  => 'footer',
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
                'type'      => 'admin',
                'file'      => 'media.js',
                'location'  => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'ofacebook.js',
                'location' => 'footer',
            ),
        );

        $this->_css = array(
            array(
                'type' => 'admin',
                'file' => 'daterangepicker.css',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'media.css',
            ),
        );
        $this->social_type = get_config('social_types')->type_facebook;

        $this->set_filters(array(
            'index'                 => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'tab_activity'          => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'add_post'              => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'remove_post'           => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'edit_post'             => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));
    }

    function fetch_info()
    {
        if ($this->is_ajax() && $current_user = Users_Model::get_current_user()) {
            if (!$token = $this->formToken->is_token_valid()) {
                $this->ajax_response(array('message' => 'Invalid token'), 403);
            }
            $config = get_config('facebook');
            if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
                $date_start = $date_first = $_POST['startDate'];
                $date_end = $_POST['endDate'];
            }
            $posts = Users_Model::get_facebook_posts();
            $likes = Users_Model::get_likes();
            $shares = Users_Model::get_shares();
            $counts = array(
                'post'      => 0,
                'comment'   => 0,
                'like'      => 0,
                'share'     => 0,
            );

            while ($date_start <= $date_end) {
                $index = date('d.m', $date_start);
                $chart['post']['data'][$index] = array(
                    'y' => 0,
                    'users' => array(),
                    'type' => 'post',
                );
                $chart['comment']['data'][$index] = array(
                    'y' => 0,
                    'users' => array(),
                    'type' => 'comment',
                );
                $chart['like']['data'][$index] = array(
                    'y' => 0,
                    'users' => array(),
                    'type' => 'like',
                );
                $chart['share']['data'][$index] = array(
                    'y' => 0,
                    'type' => 'share',
                );

                // likes
                foreach ($likes as $like) {
                    if (date('Y-m-d', $like->date) == date('Y-m-d', $date_start)) {
                        $chart['like']['data'][$index]['y'] ++;
                        $chart['like']['data'][$index]['type'] = 'like';
                        $chart['like']['data'][$index]['users'][$like->source_name] = array(
                            'id'                => $like->object_id,
                            'name'              => $like->source_name,
                            'profile_image_url' => $like->source_profile_image_url,
                            'app_id'            => $config['app_id'],
                            'link'              => base_url('facebook/activity'),
                            'type_img'          => sprintf('%sassets/admin/img/fb_events/like.png', base_url()),
                        );
                        $counts['like'] ++;
                    }
                }

                // share
                foreach ($shares as $share) {
                    if (date('Y-m-d', $share->date) == date('Y-m-d', $date_start)) {
                        $chart['share']['data'][$index]['y'] ++;
                        $chart['like']['data'][$index]['type'] = 'share';
                        $counts['share'] ++;
                    }
                }

                if (!empty($posts)) {
                    foreach ($posts['data'] as $post) {

                        // posts
                        if (date('Y-m-d', strtotime($post->created_time)) == date('Y-m-d', $date_start)) {
                            $chart['post']['data'][$index]['y'] ++;
                            $chart['like']['data'][$index]['type'] = 'post';
                            $chart['post']['data'][$index]['users'][$post->from->id] = array(
                                'id'    => $post->from->id,
                                'name'  => $post->from->name,
                                'app_id'    => $config['app_id'],
                                'link'              => base_url('facebook/activity'),
                                'profile_image_url' => $post->from->picture->data->url,
                                'type_img'          => sprintf('%sassets/admin/img/fb_events/post.png', base_url()),
                            );
                            $counts['post'] ++;
                        }

                        // comments
                        if (isset($post->comments)) {
                            foreach ($post->comments->data as $comment) {
                                if (date('Y-m-d', strtotime($comment->created_time)) == date('Y-m-d', $date_start)) {
                                    $chart['comment']['data'][$index]['y'] ++;
                                    $chart['like']['data'][$index]['type'] = 'comment';
                                    $chart['comment']['data'][$index]['users'][$comment->from->id] = array(
                                        'id'                => $comment->from->id,
                                        'name'              => $comment->from->name,
                                        'comment'           => $comment->message,
                                        'app_id'            => $config['app_id'],
                                        'link'              => base_url('facebook/activity'),
                                        'profile_image_url' => $comment->from->picture->data->url,
                                        'type_img'          => sprintf('%sassets/admin/img/fb_events/comment.png', base_url()),
                                    );
                                    $counts['comment'] ++;
                                }
                            }
                        }
                    }
                }
                $date_start = strtotime('+1 day', $date_start);
            }

            $categories      = array_keys($chart['post']['data']);
            $chart['post']['data'] = array_values($chart['post']['data']);
            $chart['comment']['data'] = array_values($chart['comment']['data']);
            $chart['like']['data'] = array_values($chart['like']['data']);
            $chart['share']['data'] = array_values($chart['share']['data']);

            echo json_encode(array(
                'status'            => true,
                'series'            => array($chart['post'], $chart['comment'], $chart['like'], $chart['share']),
                'categories'        => $categories,
                'posts_count'       => $counts['post'],
                'comments_count'    => $counts['comment'],
                'likes_count'       => $counts['like'],
                'shares_count'      => $counts['share'],
                'formToken'         => $token,
            ), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

        }
        exit;
    }

    function tab_activity()
    {
        $current_user = Users_Model::get_current_user();
        $date_start = $date_first = strtotime('-7 DAYS');
        $date_end = time();
        $chart['post']    = array(
            'name' => 'Posts',
            'data' => array(),
            'color' => '#59c2e6',
            'marker' => array(
                'fillColor' => '#fff',
                'lineColor' => '#59c2e6',
                'lineWidth' => 2,
                'states' => array(
                    'hover' => array(
                        'fillColor' => '#59c2e6',
                    ),
                ),
            ),
        );

        $chart['comment']    = array(
            'name' => 'Comments',
            'data' => array(),
            'color' => '#4bcf99',
            'marker' => array(
                'fillColor' => '#fff',
                'lineColor' => '#4bcf99',
                'lineWidth' => 2,
                'states' => array(
                    'hover' => array(
                        'fillColor' => '#4bcf99',
                    ),
                ),
            ),
        );

        $chart['like']    = array(
            'name' => 'Likes',
            'data' => array(),
            'color' => '#ac8fef',
            'marker' => array(
                'fillColor' => '#fff',
                'lineColor' => '#ac8fef',
                'lineWidth' => 2,
                'states' => array(
                    'hover' => array(
                        'fillColor' => '#ac8fef',
                    ),
                ),
            ),
        );

        $chart['share']    = array(
            'name' => 'Shares',
            'data' => array(),
            'color' => '#0000ff',
            'marker' => array(
                'fillColor' => '#fff',
                'lineColor' => '#0000ff',
                'lineWidth' => 2,
                'states' => array(
                    'hover' => array(
                        'fillColor' => '#0000ff',
                    ),
                ),
            ),
        );

        $counts                     = array(
            'post' => 0,
            'comment' => 0,
            'like' => 0,
            'share' => 0,
        );

        while ($date_start <= $date_end) {
            $index = date('d.m', $date_start);
            $chart['post']['data'][$index] = array(
                'y' => 0,
                'users' => array(),
            );
            $chart['comment']['data'][$index] = array(
                'y' => 0,
                'users' => array(),
            );
            $chart['like']['data'][$index] = array(
                'y' => 0,
                'users' => array(),
            );
            $chart['share']['data'][$index] = array(
                'y' => 0,
                'users' => array(),
            );
            $date_start = strtotime('+1 day', $date_start);
        }
        $categories      = array_keys($chart['post']['data']);
        $chart['post']['data'] = array_values($chart['post']['data']);
        $chart['comment']['data'] = array_values($chart['comment']['data']);
        $chart['like']['data'] = array_values($chart['like']['data']);
        $chart['share']['data'] = array_values($chart['share']['data']);
        $this->layout('admin', 'facebook/facebook', array(
            '_tab'               => 'facebook/_tab_account_activity',
            'tab_data'          => array(
                'current_user'      => $current_user,
                'posts_chart'       => $chart['post'],
                'comments_chart'    => $chart['comment'],
                'likes_chart'       => $chart['like'],
                'shares_chart'      => $chart['share'],
                'chart_categories'  => $categories,
                'startDate'         => date('d/m/y', $date_first),
                'endDate'           => date('d/m/y', $date_end),
                'posts_count'       => $counts['post'],
                'comments_count'    => $counts['comment'],
                'likes_count'       => $counts['like'],
                'shares_count'      => $counts['share'],
                'formToken'         => $this->formToken->renderToken(),
            ),
            'post'=>true,
        ));

    }

    function index()
    {
        $current_user       = Users_Model::get_current_user();
        $gridview = new Gridview(array(
            'table_name'    => 'Posts',
            'model_name'    => 'Post_fb_Model',
            'order'         => 'id desc',
            'conditions'    => array(
                'user_id' => $current_user->user_id,
            ),
            'columns'       => array(
                array(
                    'title'      => 'Action Status',
                    'filter'     => function($model){
                        $html = '';
                        if ($model->status != Post_fb_Model::STATUS_SENDED) {
                            $html .= sprintf('<a href="#" data-id="%s" class="remove-post-fb gridview-btn-remove"></a>', $model->id);
                        } else {
                            $html .= sprintf('<div class="post-fb-ok gridview-btn-ok"></a>');
                        }
                        return $html;
                    },
                ),
                array(
                    'title'      => 'Date',
                    'filter'     => function($model){
                        return date('h:i:s A \o\n d/m/y', $model->date);
                    },
                ),
                array(
                    'title'     => 'Short Text',
                    'filter'     => function($model){
                        return strlen($model->text) > 20? (substr($model->text, 0, 20) . "..."): $model->text;
                    },
                ),
                array(
                    'title'     => 'Status',
                    'filter'     => function($model){
                        return $model->status == Post_fb_Model::STATUS_SENDED? "Posted": "Not Yet";
                    },
                ),
                array(
                    'title'     => 'Actions',
                    'filter'     => function($model){
                        return sprintf('<a href="#" data-id="%s" class="edit-post-fb gridview-btn-edit"></span></a>', $model->id);
                    },
                ),
            ),
            'pagination' => array(
                'per_page' => 5
            ),
        ));

        $this->layout('admin', 'facebook/facebook', array(
            '_tab'              => 'facebook/_tab_posts',
            'tab_data'          => array(
                'current_user'      => $current_user,
                'gridview'          => $gridview,
                'medialibrary'      => $this->medialibrary,
            ),
        ));

    }

    public function add_account()
    {
        $response = Users_Model::add_facebook_account();
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
    }


    public function delete_account()
    {
        if(!empty($_POST['action-delete'])) {
            if ($_POST['action-delete'] === "delete") {
                $response = Users_Model::delete_facebook_account();
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
            } else {
                redirect(base_url('Posts/index'));
            }
        } else {
            $this->layout('admin', 'users/delete_social', array("socialType" => "Facebook",
                "type" => get_config('social_types')->type_facebook));
        }
    }

    public function add_post()
    {
        if ($this->is_ajax() && isset($_POST['date']) && isset($_POST['text']) && isset($_POST['offset']) && isset($_POST['type'])) {
            $errors = array();

            if (empty($_POST['date'])) {
                $errors['date'] = 'Date field can\'t be blank.';
            }
            if (empty($_POST['text'])) {
                $errors['text'] = 'Text field can\'t be blank.';
            }

            if (empty($errors)) {
                $current_user       = Users_Model::get_current_user();
                switch ($_POST['type']) {
                    case Post_fb_Model::TYPE_NOW:
                        $post_fb              = new Post_fb_Model();
                        $post_fb->social_type      = $this->social_type;
                        $post_fb->user_id     = $current_user->user_id;
                        $post_fb->text        = $_POST['text'];
                        $post_fb->date        = time();
                        $post_fb->type        = $_POST['type'];
                        $post_fb->offset      = $_POST['offset'];
                        $post_fb->attachment_id   = $_POST['attachment_id'] !== 'false'? $_POST['attachment_id']: NULL;
                        if ($post_fb->post_to()) {
                            $post_fb->status      = Post_fb_Model::STATUS_SENDED;
                            $status               = $post_fb->save();
                        } else {
                            $post_fb->status      = Post_fb_Model::STATUS_FILED;
                            $post_fb->save();
                            echo json_encode(array('status' => false, 'errors' => array(
                                $post_fb->post_to_error,
                            )));
                            exit;
                        }
                        break;
                    case Post_fb_Model::TYPE_TIME:
                        $post_fb              = new Post_fb_Model();
                        $post_fb->social_type      = $this->social_type;
                        $post_fb->user_id     = $current_user->user_id;
                        $post_fb->text        = $_POST['text'];
                        $post_fb->date        = strtotime($_POST['date']);
                        $post_fb->type        = $_POST['type'];
                        $post_fb->offset      = $_POST['offset'];
                        $post_fb->attachment_id   = $_POST['attachment_id'] !== 'false'? $_POST['attachment_id']: NULL;
                        $post_fb->status      = Post_fb_Model::STATUS_NOT_SENDED;
                        $status               = $post_fb->save();
                        break;
                }
                echo json_encode(array('status' => $status));
            } else {
                echo json_encode(array('status' => false, 'errors' => $errors));
            }
        }
        exit;
    }

    public function remove_post()
    {
        if ($this->is_ajax() && isset($_POST['id'])) {
            $current_user       = Users_Model::get_current_user();
            $post_fb            = Post_fb_Model::first(array('id' => $_POST['id']));

            if ($post_fb && $post_fb->user_id == $current_user->user_id) {
                $post_fb->delete();
                echo json_encode(array('status' => true));
            } else {
                echo json_encode(array('status' => false));
            }
        }
        exit;
    }

    public function stream_connect()
    {
        $current_user = Users_Model::get_current_user();
        if ($current_user && $current_user->check_permission(array(Roles_Model::TYPE_LEVEL_ADMIN))) {
            $this->load->library('FBSream/FBStreamUser');
            $this->_stream = new FBStreamUser(base_url('Facebook/stream_callback'));
            //$this->_stream->fetch(74, 'CAAU9EhVLn3cBAB5DFEklwLilC1yqI3AQygpuyTMgorbGGx3G0xM5Fmzugp7mJD2wPFaH2pmCKtauwGCmIcyItKTalqC5mH0jrwJLzfq9VVHiAyZAbBGSMkdwxTRYbMQudp3d2W2wRys29Du4kefXcTThQcACD4dqPqVvcYCY1KZCqZCDzakZCOvMNElnJDcZD');
            $this->_stream->connect();
            //$this->_stream->disconnect();
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            error_page();
        }
    }

    public function stream_disconnect()
    {
        $current_user = Users_Model::get_current_user();
        if ($current_user && $current_user->check_permission(array(Roles_Model::TYPE_LEVEL_ADMIN))) {
            $this->load->library('FBSream/FBStreamUser');
            $this->_stream = new FBStreamUser(base_url('Facebook/stream_callback'));
            $this->_stream->disconnect();
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            error_page();
        }
    }

    public function stream_callback()
    {
        $config = get_config('facebook');
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET' && $_GET['hub_mode'] == 'subscribe' && $_GET['hub_verify_token'] == $config['stream_verify']) {
            error_log('echo hub_challenge: ' . $_GET['hub_challenge']);
            echo $_GET['hub_challenge'];
            exit;
        } else if ($method == 'POST') {
            $updates = json_decode(file_get_contents("php://input"), true);
            error_log(print_r($updates, TRUE));
            /*if (!$meta = Usermetum::first(array('meta_key' => 'qwertyqjkdb', 'user_id' => 8))) {
                $meta = new Usermetum();
                $meta->user_id = 8;
                $meta->meta_key = 'qwertyqjkdb';
            }
            $meta->meta_value = json_encode($updates);
            $meta->save();*/
            file_put_contents("/var/www/html/dashboard/uploads/qqq.txt", print_r($updates, TRUE), FILE_APPEND);
            if(!empty($updates["entry"][0]["changed_fields"][0]) && $updates["entry"][0]["changed_fields"][0] == "feed"){

                $fbUser = Usermetum::first(array('conditions' => array("meta_value = ? AND meta_key = ?", $updates["entry"][0]["uid"], 'facebook_user_id')));

                if(!empty($fbUser->user_id)) {
                    //create notification
                    $type = Notification_Model::TYPE_FB_DIRECT_MSG;
                    $notif = new Notification_Model();
                    $notif->type = $type;
                    $notif->date = time();
                    $notif->user_id = $fbUser->user_id;
                    $notif->status = Notification_Model::STATE_NOTREAD;
                    $notif->message = Notification_Model::$messages[$type];
                    $notif->uri = Notification_Model::$redirect_url[$type];
                    $result = $notif->save();
                }
            }
        }
    }

    public function edit_post()
    {
        if ($this->is_ajax() && isset($_POST['id'])) {
            $current_user       = Users_Model::get_current_user();
            $post_fb            = Post_fb_Model::first(array('id' => $_POST['id']));
            $html               = $this->load->view('facebook/_view', array('post' => $post_fb), TRUE);

            if ($post_fb && $post_fb->user_id == $current_user->user_id) {
                echo json_encode(array('status' => true, 'post_fb' => $post_fb->attributes(), 'html' => $html));
            } else {
                echo json_encode(array('status' => false));
            }
        }
        exit;
    }

    public function __is_stream_active(){
        $this->load->library('FBSream/FBStreamUser');
        $this->_stream = new FBStreamUser(base_url('Facebook/stream_callback'));
        //$this->_stream->fetch(74, 'CAAU9EhVLn3cBAB5DFEklwLilC1yqI3AQygpuyTMgorbGGx3G0xM5Fmzugp7mJD2wPFaH2pmCKtauwGCmIcyItKTalqC5mH0jrwJLzfq9VVHiAyZAbBGSMkdwxTRYbMQudp3d2W2wRys29Du4kefXcTThQcACD4dqPqVvcYCY1KZCqZCDzakZCOvMNElnJDcZD');
        $responce = $this->_stream->read();
        $bkData = (array)$responce;
        $data = current($bkData);
        if ($data) {
            foreach ($data as $fbStream) {
                if ($fbStream->object == "user" && $fbStream->active == 1) {
                    return true;
                }
            }
        }
        return false;
    }

    static function is_stream_active(){
        $fcbkObj = new Facebook();
        return $fcbkObj->__is_stream_active();
    }

}