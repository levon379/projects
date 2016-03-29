<?php

use Facebook\FacebookSession;

use Facebook\FacebookRedirectLoginHelper;

use Facebook\FacebookRequest;

use Facebook\FacebookResponse;

use Facebook\FacebookSDKException;

use Facebook\FacebookRequestException;

use Facebook\FacebookAuthorizationException;

use Facebook\GraphObject;

use Facebook\Entities\AccessToken;

use Facebook\HttpClients\FacebookCurlHttpClient;

use Facebook\HttpClients\FacebookHttpable;

class FBStreamUser
{
    private $config         = false;
    private $instance       = false;
    private $current_user   = false;
    private $callback_url   = false;
    private $verify_token   = false;

    function __construct($callback_url)
    {
        $this->instance = Controller::get_instance();
        $this->config = get_config('facebook');
        $this->callback_url = $callback_url;
        $this->verify_token = $this->config['stream_verify'];
    }

    function connect()
    {
        FacebookSession::enableAppSecretProof(false);
        $session = new FacebookSession("{$this->config['app_id']}|{$this->config['app_secret']}");
        $request = new FacebookRequest(
            $session,
            'POST',
            "/{$this->config['app_id']}/subscriptions",
            array(
                'object'       => 'user',
                'callback_url' => $this->callback_url,
                'fields'       => 'feed',
                'verify_token' => $this->verify_token,
            )
        );
        try {
            $request->execute();
        } catch (Exception $e) {
            echo '<pre>';
            print_r($e->getTrace());
            echo '</pre>';
            exit;
        }
    }

    function read()
    {
        FacebookSession::enableAppSecretProof(false);
        $session = new FacebookSession("{$this->config['app_id']}|{$this->config['app_secret']}");
        $request = new FacebookRequest(
            $session,
            'GET',
            "/{$this->config['app_id']}/subscriptions"

        );
        try {
            $response = $request->execute();
            $graphObject = $response->getGraphObject();
            /*echo '<pre>';
            print_r($graphObject);
            echo '</pre>';*/
            return $graphObject;
        } catch (Exception $e) {
            //echo '<pre>';
//            return print_r($e->getTrace());
            //echo '</pre>';
            //exit;
        }
    }

    function fetch($user_id, $token = false)
    {
        if ($token) {
            FacebookSession::enableAppSecretProof(false);
            $longLivedAccessToken = new AccessToken($token);
            $session = new FacebookSession($longLivedAccessToken);
            $request = new FacebookRequest(
                $session,
                'GET',
                "/me/feed",
                array(
                    'fields' => 'likes.limit(99999){id,name,picture},comments.summary(true),shares',
                )
            );
            try {
                $response = $request->execute()->getGraphObject()->asArray();
            } catch (Exception $e) {}

            $time = time();
            error_log(sprintf('Fetching facebook ... USER_ID#%s', $user_id));
            if (!$count = Events_facebook_Model::all(array(
                'user_id'   => $user_id,
                'event'     => Events_facebook_Model::TYPE_LIKE,
            ))) {
                $is_first_like = true;
            } else {
                $is_first_like = false;
            }
            $first_share = Events_facebook_Model::first(array(
                'select'        => 'COUNT(*) shares_qty',
                'conditions'    => array(
                    'user_id'   => $user_id,
                    'event'     => Events_facebook_Model::TYPE_SHARE,
                ),
            ));
            foreach ($response['data'] as $feed) {
                // Fetching likes
                if (isset($feed->likes)) {
                    foreach ($feed->likes->data as $like) {

                        $event_facebook = new Events_facebook_Model(array(
                            'user_id'                   => $user_id,
                            'event'                     => Events_facebook_Model::TYPE_LIKE,
                            'date'                      => $time,
                            'source_id'                 => NULL,
                            'source_name'               => $like->name,
                            'source_profile_image_url'  => isset($like->picture->data->url)? $like->picture->data->url: NULL,
                            'target'                    => NULL,
                            'feed_id'                   => $feed->id,
                            'object_id'                 => $like->id,
                            'is_first'                  => $is_first_like,
                        ));

                        try{
                            $event_facebook->save();
                        } catch (\ActiveRecord\DatabaseException $e) {
                        }

                    }
                }
                // Fetching shares
                if (isset($feed->shares)) {

                    $stored_shares= Events_facebook_Model::first(array(
                        'select'        => 'COUNT(*) shares_qty',
                        'conditions'    => array(
                            'user_id'   => $user_id,
                            'feed_id'   => $feed->id,
                            'event'     => Events_facebook_Model::TYPE_SHARE,
                        ),
                    ));

                    $is_first_share = $first_share->shares_qty == 0;
                    if ($feed->shares->count > $stored_shares->shares_qty) {
                        for ($i = 0; $i < $feed->shares->count; $i++) {
                            $event_facebook = new Events_facebook_Model(array(
                                'user_id'                   => $user_id,
                                'event'                     => Events_facebook_Model::TYPE_SHARE,
                                'date'                      => $time,
                                'source_id'                 => NULL,
                                'source_name'               => NULL,
                                'source_profile_image_url'  => NULL,
                                'target'                    => NULL,
                                'feed_id'                   => $feed->id,
                                'object_id'                 => sprintf('fake_%s', substr(md5(time() . $user_id), 0, 17)),
                                'is_first'                  => $is_first_share,
                            ));
                        }
                    }

                    try{
                        $event_facebook->save();
                    } catch (\ActiveRecord\DatabaseException $e) {
                    }
                }

            }

        }
    }

    function disconnect()
    {
        FacebookSession::enableAppSecretProof(false);
        $session = new FacebookSession("{$this->config['app_id']}|{$this->config['app_secret']}");
        $request = new FacebookRequest(
            $session,
            'DELETE',
            "/{$this->config['app_id']}/subscriptions",
            array(
                'object'       => 'user',
            )
        );
        $response = $request->execute();
    }
}