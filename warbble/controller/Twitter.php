<?php
/**
 * Created by PhpStorm.
 * User: HuuHien
 * Date: 5/16/2015
 * Time: 8:38 PM
 */

class Twitter extends Controller{

    public function __construct()
    {
        parent::__construct();
        $keys = get_config('twitter');
        define('TWITTER_CONSUMER_KEY', $keys['key']);
        define('TWITTER_CONSUMER_SECRET', $keys['secret']);

        $this->set_filters(array(
            'tw_fetch_manual'       => array(Roles_Model::TYPE_LEVEL_ADMIN),
        ));

        $this->_js = array(
            array(
                'type'      => 'admin',
                'file'      => 'highcharts.js',
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
                'file'      => 'media.js',
                'location'  => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'bootstrap-toggle.min.js',
                'location' => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'otwitter.js',
                'location'  => 'footer',
            ),
        );

        $this->_css = array(
            array(
                'type'      => 'admin',
                'file'      => 'daterangepicker.css',
            ),
            array(
                'type' => 'admin',
                'file' => 'bootstrap-toggle.min.css',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'media.css',
            ),
        );
        $this->social_type = get_config('social_types')->type_twitter;

        $this->set_filters(array(
            'tw_fetch_manual'       => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'reply'                 => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'tab_activity'          => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'index'                 => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'add_tweet'             => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'remove_tweet'          => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'edit_tweet'            => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));
    }

    public function fetch_event()
    {
        if ($this->is_ajax()) {
            $current_user = Users_Model::get_current_user();
            $html = $this->load->view('twitter/events', array('events' => Events_twitter_Model::last_events($current_user->user_id)), TRUE);
            echo json_encode(array('status' => true, 'html' => $html));
        }
        exit;
    }

    public function fetch_twitter_event($tokens)
    {
        extract(json_decode($tokens, true));
        $this->load->library('TStream/TStreamUser');
        try{
            $sc = new TStreamUser($token, $secret, Phirehose::METHOD_USER);
            $sc->user_id = $user_id;

           $sc->consume();
       }
       catch(Exception $e) {
           error_log($e->getTraceAsString());
           file_put_contents(ABSPATH . '/uploads/qqq.txt', print_r($e->getTraceAsString(), true), FILE_APPEND);
       }

        exit;
    }

    public function launch_all_stream()
    {
        $recipients = array();
        $email_config = get_config('swiftmailer');
        $recipients[] = $email_config['support'];

        $mailer = new Swiftmailer();
        $mailer->mail('Warbble notification', array(
            'email' => $email_config['support'],
            'title' => 'Support',
        ), $recipients, sprintf('[%s] Apache was restarted. Please relaunch the twitter stream.', date('Y-m-d H:i:s')));

        $param = array('is_connect_event' => Users_Model::TW_CONN_STATUS_DISCONNECTED);
        Users_Model::table()->update($param, 'twitter_oauth_token IS NOT NULL AND twitter_oauth_token_secret IS NOT NULL');

        //create notification

        $admins = Users_Model::all(array(
            'select'        => 'u.*',
            'from'          => 'users u',
            'joins'         => 'JOIN roles r ON r.user_id=u.user_id',
            'conditions'    => sprintf('r.level=%s', Roles_Model::TYPE_LEVEL_ADMIN),
        ));

        foreach ($admins as $admin) {
            $notif = new Notification_Model(array(
                'type' => Notification_Model::TYPE_APACHE_RESTART,
                'date' => time(),
                'user_id' => $admin->id,
                'status' => Notification_Model::STATE_NOTREAD,
                'message' => sprintf('[%s] Apache was restarted. Please relaunch the twitter stream.', date('Y-m-d H:i:s')),
                'uri' => '/Twitter/tw_fetch_manual'
            ));
            $notif->save();
        }
    }

    public function tw_fetch_manual()
    {
        if (isset($_POST['Event']['user_ids'])) {
            if (isset($_POST['Event']['connect'])) {
                $users = Users_Model::all(array(
                    'user_id' => $_POST['Event']['user_ids']
                ));
                foreach ($users as $user) {
                    if ($user->is_connect_event == Users_Model::TW_CONN_STATUS_CONNECTED) continue;
                    $user->fetch_twitter_event();
                    $user->is_connect_event = Users_Model::TW_CONN_STATUS_IN_PROCESS;
                    $user->save();
                }
            } else if (isset($_POST['Event']['disconnect'])) {
                $param = array('is_connect_event' => Users_Model::TW_CONN_STATUS_DISCONNECTED);
                Users_Model::table()->update($param,
                    array('user_id' => $_POST['Event']['user_ids'])
                );
            }
        }

        $this->layout('admin', 'twitter/tw_fetch_manual', array('users' => Users_Model::all(array(
            'conditions' => 'twitter_oauth_token IS NOT NULL AND twitter_oauth_token_secret IS NOT NULL'
        ))));
    }

    public function reply()
    {
        if (!$current_user = Users_Model::get_current_user()) exit;

        if ($this->is_ajax() && isset($_POST['Reply'])) {
            switch ($_POST['Reply']['type']) {
                case "dm":
                    $response = $current_user->send_direct_message($_POST['Reply']['user_id'], $_POST['Reply']['screen_name'], $_POST['Reply']['message']);
                    break;
                case "tweet":
                    $message = sprintf("@%s %s", $_POST['Reply']['screen_name'], $_POST['Reply']['message']);
                    $tweet = new Posts_Model(array(
                        'user_id'       => $current_user->user_id,
                        'text'          => $message,
                        'date'          => time(),
                        'type'          => Posts_Model::TYPE_NOW,
                        'status'        => Posts_Model::STATUS_NOT_SENDED,
                        'social_type'   => get_config('social_types')->type_twitter,
                    ));
                    $response = $tweet->post_to_twitter();
                    break;
            }

            if (!isset($response->errors)) {
                echo json_encode(array('status' => true));
            } else {
                echo json_encode(array('status' => false, 'errors' => $response->errors));
            }
        }
        exit;
    }

    function fetch_followers()
    {
        if ($this->is_ajax()) {
            $current_user = Users_Model::get_current_user();
            if (isset($_POST['cursor'])) {
                $followers                  = $current_user->followers_list($_POST['cursor']);
                $followers_count            = $current_user->followers_count();
                echo json_encode(
                    array(
                        'status' => true,
                        'html' => $this->load->view('twitter/followers-list', array(
                            'followers'             => $followers,
                        ), TRUE),
                        'all_followers_count'   => isset($followers_count->followers_count)? $followers_count->followers_count: 0,
                    ));
                exit;
            }
        }
    }

    function follow_friend_user()
    {
        if ($this->is_ajax()) {
            $current_user = Users_Model::get_current_user();
            if ($current_user->get_twitter_tokens() != FALSE) {
                $verifier = $current_user->get_twitter_tokens();
                $twitter_config = get_config('twitter');
                require_once(ABSPATH . "/includes/plugins/twitter/twitteroauth.php");
                $connection = new TwitterOAuth($twitter_config['key'], $twitter_config['secret'], $verifier['twitter_oauth_token'], $verifier['twitter_oauth_token_secret']);
                if (!empty($_POST['follow']['screen_name'])) {
                    $settings = array(
//                        'user_id' => $_POST['follow']['user_id'],
                        'screen_name' => $_POST['follow']['screen_name'],
                    );
                }else {

                }
                $result = $connection->post('friendships/create', $settings);
                echo json_encode(array('status' => true, 'result' => $result));
                exit;
            }
            return false;
        }
        return false;
    }

    function fetch_info()
    {
        if ($this->is_ajax()) {
            if (!$token = $this->formToken->is_token_valid()) {
                $this->ajax_response(array('message' => 'Invalid token'), 403);
            }
            $current_user = Users_Model::get_current_user();
            if ($this->is_ajax() && isset($_POST['startDate']) && isset($_POST['endDate'])) {
                $date_start = $date_first = $_POST['startDate'];
                $date_end = $_POST['endDate'];
            }

            $activity                   = $current_user->get_twitter_activity_data($date_start, $date_end);
            $followers_db               = $current_user->get_all_followers_db();
            $counts                     = array(
                'retweet' => 0,
                'favorite' => 0,
                'new_followers' => 0,
                'all_followers' => count($followers_db),
            );

            while ($date_start <= $date_end) {
                $index = date('d.m', $date_start);
                $chart['retweet']['data'][$index] = array(
                    'y' => 0,
                    'users' => array(),
                    'type' => 'retweet',
                );
                $chart['favorite']['data'][$index] = array(
                    'y' => 0,
                    'users' => array(),
                    'type' => 'favorite',
                );
                $chart['new_followers']['data'][$index] = array(
                    'y' => 0,
                    'users' => array(),
                    'type' => 'new_followers',
                );
                $chart['all_followers']['data'][$index] = array(
                    'y' => 0,
                    'users' => array(),
                    'type' => 'all_followers',
                );

                if (!empty($activity)) {
                    foreach ($activity as $event) {
                        if (date('Y-m-d', $event->date) == date('Y-m-d', $date_start)) {
                            $chart[$event->event]['data'][$index]['y'] ++;
                            $chart[$event->event]['data'][$index]['users'][$event->source_id] = array(
                                'id'                => $event->source_id,
                                'name'              => $event->source_name,
                                'screen_name'       => $event->source_screen_name,
                                'profile_image_url' => $event->source_profile_image_url,
                            );
                            $counts[$event->event] ++;
                        }
                    }
                }

                if (!empty($followers_db)) {
                    foreach ($followers_db as $follower) {
                        if (date('Y-m-d', $follower->date) <= date('Y-m-d', $date_start)) {
                            $chart['all_followers']['data'][$index]['y'] ++;
                            $chart['all_followers']['data'][$index]['type'] = 'all_followers';
                            $chart['all_followers']['data'][$index]['users'][] = array(
                                'id'                => $follower->source_id,
                                'name'              => $follower->source_name,
                                'screen_name'       => $follower->source_screen_name,
                                'profile_image_url' => $follower->source_profile_image_url,
                            );
                        }
                        if (date('Y-m-d', $follower->date) == date('Y-m-d', $date_start)) {
                            $chart['new_followers']['data'][$index]['y'] ++;
                            $chart['new_followers']['data'][$index]['type'] = 'new_followers';
                            $chart['new_followers']['data'][$index]['users'][] = array(
                                'id'                => $follower->source_id,
                                'name'              => $follower->source_name,
                                'screen_name'       => $follower->source_screen_name,
                                'profile_image_url' => $follower->source_profile_image_url,
                            );
                            $counts['new_followers'] ++;
                        }
                    }
                }

                $date_start = strtotime('+1 day', $date_start);
            }

            $categories                     = array_keys($chart['retweet']['data']);
            $chart['favorite']['data']      = array_values($chart['favorite']['data']);
            $chart['retweet']['data']       = array_values($chart['retweet']['data']);
            $chart['new_followers']['data'] = array_values($chart['new_followers']['data']);
            $chart['all_followers']['data'] = array_values($chart['all_followers']['data']);

            echo json_encode(array(
                'status'                => true,
                'series'                => array($chart['favorite'],$chart['retweet'],$chart['all_followers'],$chart['new_followers']),
                'categories'            => $categories,
                'favorites_count'       => $counts['favorite'],
                'retweets_count'        => $counts['retweet'],
                'new_followers_count'   => $counts['new_followers'],
                'all_followers_count'   => $counts['all_followers'],
                'formToken'         => $token,
            ), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
            exit;
        }
        exit;
    }

    function event_show_more()
    {
        if ($this->is_ajax()) {
            $current_user = Users_Model::get_current_user();
            if (!$current_user) {
                echo json_encode(array('status' => false));
                exit;
            }
            echo json_encode(array('status' => true, 'html' => $this->load->view('twitter/events', array('events' => $current_user->twitter_events), TRUE)));
        }
        exit;
    }


    public function tab_activity()
    {
        if (!$current_user       = Users_Model::get_current_user()) redirect(base_url('Twitter/index'));
        $favorites_chart    = array(
            'name' => 'Favorites',
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
        $retweets_chart     = array(
            'name' => 'Retweets',
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
        $all_followers_chart    = array(
            'name' => 'All Followers',
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
        $new_followers_chart     = array(
            'name' => 'New Followers',
            'data' => array(),
            'color' => 'blue',
            'marker' => array(
                'fillColor' => '#fff',
                'lineColor' => 'blue',
                'lineWidth' => 2,
                'states' => array(
                    'hover' => array(
                        'fillColor' => 'blue',
                    ),
                ),
            ),
        );

        $followers                  = array();
        $favorites_count            = 0;
        $retweets_count             = 0;
        $all_followers_count        = 0;
        $new_followers_count        = 0;
        $date_start = $date_first = strtotime('-7 DAYS');
        $date_end = time();

        while ($date_start <= $date_end) {
            $index = date('d.m', $date_start);
            $favorites_chart['data'][$index] = array(
                'y' => 0,
                'users' => array(),
                'type' => 'favourite',
            );
            $retweets_chart['data'][$index] = array(
                'y' => 0,
                'users' => array(),
                'type' => 'retweet',
            );
            $new_followers_chart['data'][$index] = array(
                'y' => 0,
                'users' => array(),
                'type' => 'new_followers',
            );
            $all_followers_chart['data'][$index] = array(
                'y' => 0,
                'users' => array(),
                'type' => 'all_followers',
            );
            $date_start = strtotime('+1 day', $date_start);
        }

        $categories      = array_keys($favorites_chart['data']);
        $favorites_chart['data'] = array_values($favorites_chart['data']);
        $retweets_chart['data']  = array_values($retweets_chart['data']);
        $new_followers_chart['data'] = array_values($new_followers_chart['data']);
        $all_followers_chart['data'] = array_values($all_followers_chart['data']);

        $this->layout('admin', 'twitter/twitter', array(
            '_tab'               => 'twitter/_tab_account_activity',
            'tab_data'          => array(
                'current_user'          => $current_user,
                'favorites_chart'       => $favorites_chart,
                'retweets_chart'        => $retweets_chart,
                'all_followers_chart'   => $all_followers_chart,
                'new_followers_chart'   => $new_followers_chart,
                'chart_categories'      => $categories,
                'startDate'             => date('d/m/y', $date_first),
                'endDate'               => date('d/m/y', $date_end),
                'favorites_count'       => $favorites_count,
                'retweets_count'        => $retweets_count,
                'new_followers_count'   => $new_followers_count,
                'all_followers_count'   => $all_followers_count,
                'followers'             => $followers,
                'formToken'             => $this->formToken->renderToken(),
            ),
            'post'=>true,
        ));

    }

    public function index()
    {
        $current_user       = Users_Model::get_current_user();
        $gridview = new Gridview(array(
            'table_name'    => 'Tweets',
            'model_name'    => 'Tweets_Model',
            'order'         => 'id desc',
            'conditions'    => array(
                'user_id' => $current_user->user_id,
            ),
            'columns'       => array(
                array(
                    'title'      => 'Action Status',
                    'filter'     => function($model){
                        $html = '';
                        if ($model->status != Tweets_Model::STATUS_SENDED) {
                            $html .= sprintf('<a href="#" data-id="%s" class="gridview-btn-remove remove-tweet"></a>', $model->id);
                        } else {
                            $html .= sprintf('<div class="gridview-btn-ok tweet-ok"></a>');
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
                        return $model->status == Tweets_Model::STATUS_SENDED? "Posted": "Not Yet";
                    },
                ),
                array(
                    'title'     => 'Actions',
                    'filter'     => function($model){
                        return sprintf('<a href="#" data-id="%s" class="gridview-btn-edit edit-tweet"></span></a>', $model->id);
                    },
                ),
            ),
            'pagination' => array(
                'per_page' => 5
            ),
        ));

        $this->layout('admin', 'twitter/twitter', array(
            '_tab'              => 'twitter/_tab_tweets',
            'tab_data'          => array(
                'current_user'      => $current_user,
                'gridview'          => $gridview,
                'medialibrary'      => $this->medialibrary,
            ),
        ));
    }
    public function add_tweet()
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
                    case Tweets_Model::TYPE_NOW:
                        $tweet                  = new Tweets_Model();
                        $tweet->social_type      = $this->social_type;
                        $tweet->user_id         = $current_user->user_id;
                        $tweet->text            = $_POST['text'];
                        $tweet->date            = time();
                        $tweet->type            = $_POST['type'];
                        $tweet->offset          = $_POST['offset'];
                        $tweet->status          = Tweets_Model::STATUS_SENDED;
                        $tweet->attachment_id   = $_POST['attachment_id'] !== 'false'? $_POST['attachment_id']: NULL;
                        $status                 = $tweet->save();
                        $tweet->post_to();

                        break;
                    case Tweets_Model::TYPE_TIME:
                        $tweet                  = new Tweets_Model();
                        $tweet->social_type      = $this->social_type;
                        $tweet->user_id         = $current_user->user_id;
                        $tweet->text            = $_POST['text'];
                        $tweet->date            = strtotime($_POST['date']);
                        $tweet->type            = $_POST['type'];
                        $tweet->offset          = $_POST['offset'];
                        $tweet->status          = Tweets_Model::STATUS_NOT_SENDED;
                        $tweet->attachment_id   = $_POST['attachment_id'] !== 'false'? $_POST['attachment_id']: NULL;
                        $status                 = $tweet->save();
                        break;
                }
                echo json_encode(array('status' => $status));
            } else {
                echo json_encode(array('status' => false, 'errors' => $errors));
            }
        }
        exit;
    }

    public function remove_tweet()
    {
        if ($this->is_ajax() && isset($_POST['id'])) {
            $current_user       = Users_Model::get_current_user();
            $tweet              = Tweets_Model::first(array('id' => $_POST['id']));

            if ($tweet && $tweet->user_id == $current_user->user_id) {
                $tweet->delete();
                echo json_encode(array('status' => true));
            } else {
                echo json_encode(array('status' => false));
            }
        }
        exit;
    }

    public function edit_tweet()
    {
        if ($this->is_ajax() && isset($_POST['id'])) {
            $current_user       = Users_Model::get_current_user();
            $tweet              = Tweets_Model::first(array('id' => $_POST['id']));
            $html               = $this->load->view('twitter/_view', array('tweet' => $tweet), TRUE);

            if ($tweet && $tweet->user_id == $current_user->user_id) {
                echo json_encode(array('status' => true, 'tweet' => $tweet->attributes(), 'html' => $html));
            } else {
                echo json_encode(array('status' => false));
            }
        }
        exit;
    }

    public function add_account()
    {
        $response = Users_Model::add_twitter_account();
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
            if ( $_POST['action-delete'] === "delete") {
                $response = Users_Model::delete_twitter_account();
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
            $this->layout('admin', 'users/delete_social', array("socialType" => "Twitter",
                "type" => get_config('social_types')->type_twitter));
        }
    }

}