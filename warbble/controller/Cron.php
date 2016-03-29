<?php
/**
 * Created by PhpStorm.
 * User: HuuHien
 * Date: 5/16/2015
 * Time: 8:38 PM
 */
error_reporting(E_ERROR);

class Cron extends Controller
{
    public function post_tweets()
    {
        $tweets = Tweets_Model::find('all', array(
            'status' => Tweets_Model::STATUS_NOT_SENDED,
            'type'   => Tweets_Model::TYPE_TIME,
        ));
        foreach ($tweets as $tweet) {
            if (time() + $tweet->offset * 60 > $tweet->date && $tweet->status == Tweets_Model::STATUS_NOT_SENDED) {

                $status = $tweet->post_to();
                if (isset($status->id) && $status->id > 0) {
                    $tweet->status = Tweets_Model::STATUS_SENDED;
                    $tweet->save();
                } else {
                    $current_user = $tweet->user;

                    if ($current_user) {
                        $recipients = array();
                        $email_config = get_config('swiftmailer');

                        if (filter_var($current_user->email, FILTER_VALIDATE_EMAIL) !== FALSE) {
                            $recipients[] = $current_user->email;
                        }
                        $recipients[] = $email_config['support'];

                        $mailer = new Swiftmailer();
                        $mailer->mail('Warbble notification', array(
                            'email' => 'support@warbble.com',
                            'title' => 'Support',
                        ), $recipients, $mailer->get_html_tweet_message($tweet, $this->path));
                        $tweet->status = Tweets_Model::STATUS_FILED;
                        $tweet->save();
                    }
                }
            }
        }
    }

    public function post_fb()
    {
        $posts = Post_fb_Model::find('all', array(
            'status' => Post_fb_Model::STATUS_NOT_SENDED,
            'type'   => Post_fb_Model::TYPE_TIME,
        ));
        foreach ($posts as $post) {
            if (time() + $post->offset * 60 > $post->date && $post->status == Post_fb_Model::STATUS_NOT_SENDED) {

                $status = $post->post_to();
                if (isset($status['id'])) {
                    $post->status = Post_fb_Model::STATUS_SENDED;
                    $post->save();
                }
            }
        }
    }

    public function send_post()
    {
        $posts = Posts_Model::find('all', array(
            'status' => Posts_Model::STATUS_NOT_SENDED,
            'type'   => Posts_Model::TYPE_TIME,
        ));

        foreach ($posts as $post) {
            if (time() + $post->offset * 60 > $post->date && $post->status == Posts_Model::STATUS_NOT_SENDED) {

                switch ($post->social_type) {
                    case get_config('social_types')->type_twitter:
                        if (!$post->post_to_twitter()) {
                            $post->post_fail_notification();
                        }
                        break;
                    case get_config('social_types')->type_facebook:
                        if (!$status = $post->post_to_facebook()) {
                            $post->post_fail_notification();
                        }
                        break;
                    case get_config('social_types')->type_blogger:
                        $status = $post->post_to_blogger();
                        if ($status !== false) {
                            $post->status = Posts_Model::STATUS_SENDED;
                            $post->remote_id = $status->id;
                            $post->save();
                        } else {
                            $post->post_fail_notification();
                        }
                        break;
                }
            }
        }
    }

    # 0 0 * * * /usr/bin/php /home/g560072/public_html/w/dev/dashboard/index.php -c Cron -m clear_twitter_event
    public function clear_twitter_event()
    {
        Events_twitter_Model::connection()->query('TRUNCATE TABLE events_twitter');
    }

    public function update_api()
    {
        $models = Api_model::all(array('conditions' => "token IS NOT NULL"));
        foreach ($models as $model) {
            if (($model->created_time + 86400) < time()) {
                $model->token = NULL;
                $model->save();
            }
        }
    }
    # */15 * * * * /usr/bin/php /home/g560072/public_html/w/dev/dashboard/index.php -c Cron -m facebook_fetch_likes
    public function facebook_fetch_likes()
    {
        $this->load->library('FBSream/FBStreamUser');
        $this->_stream = new FBStreamUser(base_url('Facebook/stream_callback'));

        $users = Users_Model::find_by_sql("
            SELECT users.*, user_meta.meta_value facebook_user_token
            FROM users
            JOIN user_meta ON user_meta.user_id = users.user_id
            WHERE user_meta.meta_key = 'facebook_user_token' AND (user_meta.meta_value IS NOT NULL AND user_meta.meta_value <> '')
        ");

        foreach ($users as $user) {
            $this->_stream->fetch($user->user_id, $user->facebook_user_token);
        }
    }
}
