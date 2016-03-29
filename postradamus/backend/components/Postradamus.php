<?php

namespace backend\components;

use yii\base\Object;
use common\models\cUser;
use common\models\cLogFbUsername;
use Yii;

class Postradamus extends Object {

    public function __construct(/*$param1, $param2, */$config = [])
    {
        // ... initialization before configuration is applied

        parent::__construct($config);
    }

    public function replace_vars($text, $variables)
    {
        foreach ($variables as $variable_name => $variable_value) {
            $text = preg_replace_callback('/{(' . $variable_name . '):?([0-9]+)?}/i',
                function ($matches) use ($variable_value) {
                    if (isset($matches[2])) {
                        $str = preg_replace('/\s+?(\S+)?$/', '', substr($variable_value, 0, $matches[2]));

                        if (strlen($variable_value) > $matches[2])
                            $str .= "...";

                        return $str;
                    } else {
                        return $variable_value;
                    }
                }, $text);
        }
        return $text;
    }

    function create_canvas_from_image($image_url, $image_json, $additional_javascript, $canvas_name = 'canvas')
    {
        $js = "
                        var $canvas_name = new fabric.Canvas('c');
                        last_width = 0;
                        completed = 0;
                    ";
        //open
        if($image_json != '')
        {
            $js .= "
                    var json = '" . addslashes($image_json) . "';
                    var object = JSON.parse(json); //use default json parser
                    $canvas_name.loadFromJSON(json, function() {
                        //console.log(object);
                        createImageFromJson(object, $canvas_name);
                ";
        }
        else
        {
            $js .= "
                    fabric.Image.fromURL('$image_url', function(img) {
                        createImageFromUrl(img, $canvas_name);
                    ";
        }
        //apply what?
        $js .= $additional_javascript;

        //close
        if($image_json != '')
        {
            $js .= "
                    }.bind($canvas_name).bind(object));
                ";
        }
        else
        {
            $js .= "
                            }.bind($canvas_name));
                        ";
        }
        return $js;
    }

    function spin($string, $seedPageName = true, $openingConstruct = '[', $closingConstruct = ']', $separator = '|')
    {
        # If we have nothing to spin just exit
        if(strpos($string, $openingConstruct) === false)
        {
            return $string;
        }

        # Find all positions of the starting and opening braces
        $startPositions	= $this->strpos_all($string, $openingConstruct);
        $endPositions	= $this->strpos_all($string, $closingConstruct);

        # There must be the same number of opening constructs to closing ones
        if($startPositions === false OR count($startPositions) !== count($endPositions))
        {
            return $string;
        }

        # Optional, always show a particular combination on the page
        if($seedPageName)
        {
            mt_srand(crc32($_SERVER['REQUEST_URI']));
        }

        # Might as well calculate these once
        $openingConstructLength = mb_strlen($openingConstruct);
        $closingConstructLength = mb_strlen($closingConstruct);

        # Organise the starting and opening values into a simple array showing orders
        if(is_array($startPositions))
        {
            foreach($startPositions as $pos)
            {
                $order[$pos] = 'open';
            }
        }
        if(is_array($endPositions))
        {
            foreach($endPositions as $pos)
            {
                $order[$pos] = 'close';
            }
        }
        ksort($order);

        # Go through the positions to get the depths
        $depth = 0;
        $chunk = 0;
        foreach($order as $position => $state)
        {
            if($state == 'open')
            {
                $depth++;
                $history[] = $position;
            }
            else
            {
                $lastPosition	= end($history);
                $lastKey		= key($history);
                unset($history[$lastKey]);

                $store[$depth][] = mb_substr($string, $lastPosition + $openingConstructLength, $position - $lastPosition - $closingConstructLength);
                $depth--;
            }
        }
        krsort($store);

        # Remove the old array and make sure we know what the original state of the top level spin blocks was
        unset($order);
        $original = $store[1];

        # Move through all elements and spin them
        foreach($store as $depth => $values)
        {
            foreach($values as $key => $spin)
            {
                # Get the choices
                $choices = explode($separator, $store[$depth][$key]);
                $replace = $choices[mt_rand(0, count($choices) - 1)];

                # Move down to the lower levels
                $level = $depth;
                while($level > 0)
                {
                    foreach($store[$level] as $k => $v)
                    {
                        $find = $openingConstruct.$store[$depth][$key].$closingConstruct;
                        if($level == 1 AND $depth == 1)
                        {
                            $find = $store[$depth][$key];
                        }
                        $store[$level][$k] = $this->str_replace_first($find, $replace, $store[$level][$k]);
                    }
                    $level--;
                }
            }
        }

        # Put the very lowest level back into the original string
        foreach($original as $key => $value)
        {
            $string = $this->str_replace_first($openingConstruct.$value.$closingConstruct, $store[1][$key], $string);
        }

        return $string;
    }

    # Similar to str_replace, but only replaces the first instance of the needle
    function str_replace_first($find, $replace, $string)
    {
        # Ensure we are dealing with arrays
        if(!is_array($find))
        {
            $find = array($find);
        }

        if(!is_array($replace))
        {
            $replace = array($replace);
        }

        foreach($find as $key => $value)
        {
            if(!empty($value))
            {
                if(($pos = mb_strpos($string, $value)) !== false)
                {
                    # If we have no replacement make it empty
                    if(!isset($replace[$key]))
                    {
                        $replace[$key] = '';
                    }

                    $string = mb_substr($string, 0, $pos).$replace[$key].mb_substr($string, $pos + mb_strlen($value));
                }
            }
        }

        return $string;
    }

# Finds all instances of a needle in the haystack and returns the array
    function strpos_all($haystack, $needle)
    {
        $offset = 0;
        $i		= 0;
        $return = false;

        while(is_integer($i))
        {
            $i = mb_strpos($haystack, $needle, $offset);

            if(is_integer($i))
            {
                $return[]	= $i;
                $offset		= $i + mb_strlen($needle);
            }
        }

        return $return;
    }

    public function setupFacebook($params)
    {
        $fb = Yii::$app->postradamus->get_facebook_details();
        \Facebook\FacebookSession::setDefaultApplication($fb['app_id'], $fb['app_secret']);

        $helper = new \Facebook\FacebookRedirectLoginHelper($params['redirect_url']);

        // login helper with redirect_uri
        $fh = new \backend\components\FacebookHelper;
        try {
            $session = $fh->create_session($helper);
        } catch ( \Facebook\FacebookAuthorizationException $ex ) {
            // catch any exceptions
            $session = null;
            $e = $ex->getMessage();
        } catch( \Facebook\FacebookRequestException $ex ) {
            // When Facebook returns an error
            // handle this better in production code
            $e = $ex->getMessage();
        } catch(Exception $ex) {
            $e = $ex->message();
        }

        // see if we have a session
        if ( isset( $session ) ) {

            // graph api request for user data
            if(!$fh->has_permissions($params['permissions']))
            {
                if($_GET['code'])
                {
                    Yii::$app->session->setFlash('danger', 'You must accept the Facebook permissions.');
                }
                else
                {
                    $fh->login($params['redirect_url'], $params['permissions'], false);
                }
            }

        } elseif(!isset($e) || $e == '') { //not logged in, do so now!

            $fh->login($params['redirect_url'], $params['permissions'], false);

        }

        return $fh;
    }

    public function scheduledPosts($fh, $fb_page_id)
    {
        if(!$userTimezone = Yii::$app->user->identity->getSetting('timezone'))
        {
            $userTimezone = 'America/Los_Angeles';
        }

        $i = 0;
        $posts = [];

        $scheduled_posts = $fh->api_call("/$fb_page_id/promotable_posts", 'GET', ['is_published' => false, 'include_hidden' => false]);
        if(is_array($scheduled_posts['data']))
        {
            foreach($scheduled_posts['data'] as $post)
            {
                if($post->scheduled_publish_time > time() - 86400)
                {
                    $posts[$i]['id'] = $post->id;
                    $posts[$i]['edit_url'] = 'http://fb.com/' . $post->id;
                    $posts[$i]['text'] = $post->message;
                    $posts[$i]['image_url'] = $post->picture;
                    $posts[$i]['link'] = $post->link;
                    $posts[$i]['type'] = $post->type;
                    $posts[$i]['post_type_id'] = '';
                    $posts[$i]['scheduled_time'] = $post->scheduled_publish_time;
                    $posts[$i]['scheduler'] = 'facebook';
                    $i++;
                }
            }
        }
        $sending_lists = \common\models\cList::findSending()->andWhere(['to_page' => $fb_page_id])->all();
        $offset = Yii::$app->postradamus->get_timezone_offset($userTimezone);

        foreach($sending_lists as $list)
        {
            $postss = \common\models\cListPost::find()->andWhere("scheduled_time + $offset > (UNIX_TIMESTAMP() + 60 * 15) AND list_id = {$list->id}")->all();
            foreach($postss as $post)
            {
                $posts[$i]['id'] = $post->id;
                $posts[$i]['edit_url'] = Yii::$app->urlManager->createUrl(['post/update', 'id' => $post->id]);
                $posts[$i]['text'] = $post->text;
                $posts[$i]['image_url'] = $post->image_url;
                $posts[$i]['link'] = $post->link;
                $posts[$i]['type'] = ($post->link != '' ? 'link' : ($post->image_url ? 'photo' : 'status'));
                $posts[$i]['post_type_id'] = $post->post_type_id;
                $posts[$i]['scheduled_time'] = $post->scheduled_time;
                $posts[$i]['scheduler'] = 'postradamus';
                $i++;
            }
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $posts,
            'sort' => [
                'class' => 'common\components\cSort',
                'attributes' => [
                    'text' => [
                        'default' => SORT_DESC,
                    ],
                    'scheduled_time' => [
                        'default' => SORT_DESC,
                    ],
                    'post_type_id' => [
                        'default' => SORT_DESC,
                    ],
                    'type' => [
                        'default' => SORT_DESC,
                    ]
                ],
                'defaultOrder' => [
                    'scheduled_time' => SORT_ASC
                ],
            ],
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        return $dataProvider;
    }

    public function get_timezone_offset($remote_tz, $origin_tz = null) {
        if($origin_tz === null) {
            if(!is_string($origin_tz = date_default_timezone_get())) {
                return false; // A UTC timestamp was returned -- bail out!
            }
        }
        $origin_dtz = new \DateTimeZone($origin_tz);
        $remote_dtz = new \DateTimeZone($remote_tz);
        $origin_dt = new \DateTime("now", $origin_dtz);
        $remote_dt = new \DateTime("now", $remote_dtz);
        $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
        return $offset;
    }

    public function getPlanDetails($plan)
    {
        if($plan == 3 || $plan == 0 || $plan == 4)
        {
            $details['name'] = 'Unlimited';
            $details['users'] = 5;
            $details['campaigns'] = 'unlimited';
        }
        if($plan == 1)
        {
            $details['name'] = 'Basic';
            $details['users'] = 0;
            $details['campaigns'] = '1';
        }
        if($plan == 2)
        {
            $details['name'] = 'Advanced';
            $details['users'] = 1;
            $details['campaigns'] = '5';
        }
        if(Yii::$app->user->id == 113)
        {
            $details['users'] = 7;
        }
        return $details;
    }

    public function updateFBUserName($username)
    {
        if(Yii::$app->user->identity->getField('fb_user_name') == '' && $username != '')
        {
            $u = cUser::find()->where(['id' => Yii::$app->user->id])->one();
            $u->fb_user_name = $username;
            $u->save(false);
        }
        //
        if($username != '')
        {
            $l = cLogFbUsername::find()->where(['user_id' => Yii::$app->user->id, 'fb_user_name' => $username])->one();
            if(empty($l))
            {
                $l = new cLogFbUsername;
                $l->user_id = Yii::$app->user->id;
                $l->fb_user_name = $username;
                $l->save(false);
            }
        }
    }

    public function init()
    {
        parent::init();

        // ... initialization after configuration is applied
    }

    public function get_user_date_time_format()
    {
        $user_id = Yii::$app->user->id;

        $user = cUser::find()->where(['id' => $user_id])->one();
        $format = $user->getSetting('date_format') . ' ' . $user->getSetting('time_format');
        if(trim($user->getSetting('date_format')) == '' || trim($user->getSetting('time_format')) == '')
        {
            $format = 'M d y h:i A';
        }elseif(!$this->checkIsAValidDate($format)){
            $format = 'M d y h:i A';
        }
        return $format;
    }

    public function checkIsAValidDate($format){
        $date = date($format,time());
        return (bool)strtotime($date);
    }

    public function get_user_date_format()
    {
        $user_id = Yii::$app->user->id;

        $user = cUser::find()->where(['id' => $user_id])->one();
        $format = $user->getSetting('date_format');
        if(trim($user->getSetting('date_format')) == '')
        {
            $format = 'M d y';
        }elseif(!$this->checkIsAValidDate($format)){
            $format = 'M d y';
        }
        return $format;
    }

    public function get_user_time_format()
    {
        $user_id = Yii::$app->user->id;

        $user = cUser::find()->where(['id' => $user_id])->one();
        $format = $user->getSetting('time_format');
        if(trim($user->getSetting('time_format')) == '')
        {
            $format = 'h:i A';
        }elseif(!$this->checkIsAValidDate($format)){
            $format = 'h:i A';
        }
        return $format;
    }

    public function get_facebook_details($user_id = '')
    {
        if($user_id == '')
        {
            $user_id = Yii::$app->user->id;
        }
        if($user_id != '')
        {
            $user = cUser::find()->where(['id' => $user_id])->one();
            if($user->getFacebookConnection('facebook_app_id') && $user->getFacebookConnection('facebook_secret'))
            {
                return ['app_id' => $user->getFacebookConnection('facebook_app_id'), 'app_secret' => $user->getFacebookConnection('facebook_secret')];
            }
            return ['app_id' => Yii::$app->params['facebook']['app_id'], 'app_secret' => Yii::$app->params['facebook']['app_secret']];
        }
    }

}

?>