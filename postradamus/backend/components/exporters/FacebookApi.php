<?php

namespace backend\components\exporters;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use backend\components\exporters\Facebook;

class FacebookApi extends Facebook {

    public $_fh;
    public $args;

    public function __construct($fh)
    {
        $this->_fh = $fh;
    }

    public function add_image($message, $image_file)
    {
        $this->args['message'] = $message;
        $this->args['source'] = new \CURLFile($image_file);
//        $this->args['source'] = '@' . $image_file;
    }

    public function add_schedule($schedule_time)
    {
        $this->args['scheduled_publish_time'] = $schedule_time;
        $this->args['published'] = false;
    }

    public function add_text($message)
    {
        $this->args['message'] = ltrim($message, '@');
    }

    public function add_link($link, $image_url)
    {
        $this->args['link'] = $link;
        if($image_url != '')
        $this->args['picture'] = $image_url;
    }

    public function post_to_api($parameters)
    {
        $this->args = [];
        $errors = '';

        //access token
        $this->args['access_token'] = $parameters['access_token'];

        //setup image or text post
        if(isset($parameters['post_link']) && trim($parameters['post_link']) != '' || (!isset($parameters['post_image_filename']) || $parameters['post_image_filename'] == '')) {
            $this->add_text($parameters['post_message']);
            if(isset($parameters['post_link']))
            {
                $this->add_link($parameters['post_link'], $parameters['post_image_url']);
            }
            $post_to = 'feed';
        } else {
            if(!isset($parameters['post_link']) || $parameters['post_link'] == '')
            {
                $this->add_image($parameters['post_message'], $parameters['post_image_filename']);
                $post_to = 'photos';
            }
        }

        //schedule it?
        if(isset($parameters['post_schedule_time'])) {
            $this->add_schedule($parameters['post_schedule_time']);
        }

        //try to push this to facebook
        try {
            $post = $this->_fh->api_call("/{$parameters['to_page']}/$post_to", "post", $this->args);
        } catch ( FacebookAuthorizationException $e ) {
            // catch any exceptions
            $errors = $e->getMessage();
        } catch (FacebookRequestException $e) {
            $errors = $e->getMessage();
        }

        if(is_array($post))
        {
            return array(
                'errors' => $errors,
                'post' => $post,
            );
        }
        elseif(is_string($post))
        {
            return array(
                'errors' => $post,
                'post' => [],
            );
        }
    }

}
