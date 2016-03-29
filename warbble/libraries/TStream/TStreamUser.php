<?php
require_once('lib/OauthPhirehose.php');

/**
 * Barebones example of using UserstreamPhirehose.
 */
class TStreamUser extends OauthPhirehose
{
    protected $connectFailuresMax = 4;
    public $user_id = false;

    /**
     * First response looks like this:
     *    $data=array('friends'=>array(123,2334,9876));
     *
     * Each tweet of your friends looks like:
     *   [id] => 1011234124121
     *   [text] =>  (the tweet)
     *   [user] => array( the user who tweeted )
     *   [entities] => array ( urls, etc. )
     *
     * Every 30 seconds we get the keep-alive message, where $status is empty.
     *
     * When the user adds a friend we get one of these:
     *    [event] => follow
     *    [source] => Array(   my user   )
     *    [created_at] => Tue May 24 13:02:25 +0000 2011
     *    [target] => Array  (the user now being followed)
     *
     * @param string $status
     */
    public function enqueueStatus($status)
    {
        //file_put_contents(ABSPATH . 'uploads/qqq.json', $status);
        /*
         * In this simple example, we will just display to STDOUT rather than enqueue.
         * NOTE: You should NOT be processing tweets at this point in a real application, instead they
         *  should be being enqueued and processed asyncronously from the collection process.
         */
        $data = json_decode($status, true);

        // close socket if there user is not exist
        $user = Users_Model::find($this->user_id);
        if (!$user) {
            $this->disconnect();
            return;
        }
        if (array_key_exists('friends', $data)) {
            $user->is_connect_event = Users_Model::TW_CONN_STATUS_CONNECTED;
            $user->save();
        }

        // close socket if status false
        if ($user->is_connect_event == Users_Model::TW_CONN_STATUS_DISCONNECTED) {
            $this->disconnect();
            return;
        }

        // close socket if user has no twitter
        if (!$user->twitter_oauth_token || !$user->twitter_oauth_token_secret) {
            $user->is_connect_event = Users_Model::TW_CONN_STATUS_DISCONNECTED;
            $user->save();
            $this->disconnect();
            return;
        }
        // fetching
        if ($data) {

            if (array_key_exists('event', $data)) {
                // some other events
                if ($user->get_twitter_account_id() == $data['target']['id_str']) {
                    $event = new Events_twitter_Model();
                    $event->user_id = $this->user_id;
                    $event->event = $data['event'];
                    $event->date = strtotime($data['created_at']);
                    $event->source_id = $data['source']['id_str'];
                    $event->source_name = $data['source']['name'];
                    $event->source_screen_name = $data['source']['screen_name'];
                    $event->source_profile_image_url = $data['source']['profile_image_url'];
                    $event->target = $data['target']['id_str'];
                    $event->object = isset($data['target_object'])? json_encode($data['target_object']): NULL;
                    $event->object_id = isset($data['target_object']['id'])? $data['target_object']['id']: NULL;
                    $event->save();
                }
            } else if (array_key_exists('in_reply_to_user_id', $data) && $data['in_reply_to_user_id']) {
                // reply
                if ($user->get_twitter_account_id() == $data['in_reply_to_user_id']) {
                    $event = new Events_twitter_Model();
                    $event->user_id = $this->user_id;
                    $event->event = Events_twitter_Model::TYPE_REPLY;
                    $event->date = strtotime($data['created_at']);
                    $event->source_id = $data['user']['id_str'];
                    $event->source_name = $data['user']['name'];
                    $event->source_screen_name = $data['user']['screen_name'];
                    $event->source_profile_image_url = $data['user']['profile_image_url'];

                    $event->target = $data['in_reply_to_user_id'];
                    $event->object = $data['text'];
                    $event->save();

                    $cond =array('conditions'=>array('user_id = ? AND meta_key = ?', $user->id, "twitter_account_id"));
                     $my_twitter_id = Usermetum::last($cond);
                    //if mention

                    if($data['in_reply_to_user_id_str'] == $my_twitter_id->meta_value){
                        //create notification
                        $type = Notification_Model::TYPE_TW_MENTION;
                        $notif = new Notification_Model();
                        $notif->type = $type;
                        $notif->date = time();
                        $notif->user_id = $user->id;
                        $notif->status = Notification_Model::STATE_NOTREAD;
                        $notif->message = Notification_Model::$messages[$type];
                        $notif->uri = Notification_Model::$redirect_url[$type];
                        $result = $notif->save();
                    }
                }
            } else if (array_key_exists('retweeted_status', $data)) {
                // RETWEETS
                if ($user->get_twitter_account_id() == $data['retweeted_status']['user']['id']) {
                    $event = new Events_twitter_Model();
                    $event->user_id = $this->user_id;
                    $event->event = Events_twitter_Model::TYPE_RETWEET;
                    $event->date = strtotime($data['created_at']);
                    $event->source_id = $data['user']['id_str'];
                    $event->source_name = $data['user']['name'];
                    $event->source_screen_name = $data['user']['screen_name'];
                    $event->source_profile_image_url = $data['user']['profile_image_url'];
                    $event->target = $data['retweeted_status']['user']['id_str'];
                    $event->object = json_encode(array(
                        'id'    => $data['retweeted_status']['id_str'],
                        'text'  => $data['retweeted_status']['text'],
                    ));
                    $event->object_id = isset($data['retweeted_status']['id'])? $data['retweeted_status']['id']: NULL;
                    $event->save();
                }

            }

        }

    }

}