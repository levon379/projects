<?php

namespace backend\components;

use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequestException;
use Yii;

class FacebookHelper {

    /**
     * @var bool instance of the Facebook library
     */
    public $_session;
    public $_user_pages;
    public $_user_groups;
    public $_user_has_permissions;

    public static function get_url_info($url)
    {
        if(!$url_info = Yii::$app->cache->get(md5('url_info_' . serialize($url))))
        {
            \Yii::beginProfile('Not cached');
            $url_info = self::impersonateBrowser(
                'https://graph.facebook.com/v2.3/',
                [
                    'id' => $url,
                    'scrape' => 'true',
                    'access_token' => ($_SESSION['fb_token'] ? $_SESSION['fb_token'] : Yii::$app->params['facebook']['app_id'] . '|' . Yii::$app->params['facebook']['app_secret'])
                ]
            );
            Yii::$app->cache->set(md5('url_info_' . serialize($url)), $url_info, 60 * 60 * 24);
            \Yii::endProfile('Not cached');
        }
        $url_info = json_decode($url_info);
        return $url_info;
    }

    public function get_photo_info($page_id, $photo_id)
    {
        //if(!$url_info = Yii::$app->cache->get(md5('photo_url_info_' . serialize($photo_id)))) {
            \Yii::beginProfile('Not cached');
            $url_info1 = file_get_contents('https://graph.facebook.com/v2.3/' . $page_id . '_' . $photo_id . '/attachments?access_token=' . $_SESSION['fb_token']);
            Yii::$app->cache->set(md5('photo_url_info_' . serialize($photo_id)), $url_info1, 60 * 60 * 24);
            \Yii::endProfile('Not cached');
        //}
        $url_info = json_decode($url_info1);

        $debug_info = "";
        //if(!isset($url_info->images[0]->source))
        //{
            $debug_info .= "User Info: " . Yii::$app->user->id . "\n\n";
            $debug_info .= "Session Token: " . $_SESSION['fb_token'] . "\n\n";
            $debug_info .= "URL: " . 'https://graph.facebook.com/v2.3/' . $page_id . '_' . $photo_id . '/attachments?access_token=' . $_SESSION['fb_token'] . "\n\n";
            $debug_info .= "FGC: " . $url_info1 . "\n\n";
            $debug_info .= "Photo ID: " . $photo_id . "\n\n";
            mail("natesanden@gmail.com", "Large photo not found", $debug_info);
        //}

        return $url_info;
    }

    public static function impersonateBrowser($url, $params)
    {
        $ch = curl_init();
        $useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1)".
            " Gecko/20061204 Firefox/2.0.0.1";
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $html = curl_exec($ch);

        curl_close($ch);
        return $html;
    }

    public function create_session($helper)
    {
        if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {

            // create new session from saved access_token
            $session = new FacebookSession( $_SESSION['fb_token'] );

            // validate the access_token to make sure it's still valid

                if ( !$session->validate() ) {
                    $session = $helper->getSessionFromRedirect();
                }

        } else {

            // no session exists
            try {
                $session = $helper->getSessionFromRedirect();
            } catch( FacebookRequestException $ex ) {
                // When Facebook returns an error
                // handle this better in production code
                echo $ex->getMessage();
            } catch( Exception $ex ) {
                // When validation fails or other local issues
                // handle this better in production code
                echo $ex->getMessage();
            }

        }

        // see if we have a session
        if ( isset( $session ) ) {

            // save the session
            $_SESSION['fb_token'] = $session->getToken();
            // create a session using saved token or the new one we generated at login
            $session = new FacebookSession( $session->getToken() );

        }
        $this->_session = $session;
        return $session;
    }

    function get_session()
    {
        if(!$this->_session)
        {
            $this->create_session($helper);
        }
    }

    function get_user_profile()
    {
        if(!$this->_user_profile)
        {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $this->_user_profile = $this->api_call('/me');
            } catch (FacebookApiException $e) {
                return false;
            }
        }
        return $this->_user_profile;
    }

    function is_logged_in()
    {
        if ($this->_facebook->getUser())
        {
            $fbuser = $this->get_user_profile();
        }

        if(isset($fbuser))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function login($redirect_url, $permissions = [], $js_redirect = true, $retry = false)
    {
        $helper = new FacebookRedirectLoginHelper( $redirect_url );
        $url = $helper->getLoginUrl( $permissions );

        if($retry == true) { $url .= '&auth_type=rerequest'; }
        if($js_redirect)
            echo '<script>location.href="' . $url . '";</script>';
        else
            header("Location: $url");

        exit();
    }

    function logout()
    {
        $logoutUrl = $this->_facebook->getLogoutUrl();
        echo "<script>top.location.href='" . $logoutUrl . "'</script>";
        exit;
    }

    function get_page_name($page_id)
    {
        if($page_id != '')
        {
            try {
                $page = $this->api_call('/' . $page_id . '?fields=name');
            } catch (FacebookApiException $e) {
                return $e->getMessage();
            }
            return $page['name'];
        }
        return false;
    }

    function get_page_likes($page_id)
    {
        if($page_id != '')
        {
            try {
                $page = $this->api_call('/' . $page_id . '?fields=likes');
            } catch (FacebookApiException $e) {
                return $e->getMessage();
            }
            return $page['likes'];
        }
        return false;
    }

    function api_call($graph, $method = 'GET', $params = [])
    {


        try {
            //echo "1z<br />";
            $start = time();
            try {
                $this->_session->validate();
            } catch (FacebookRequestException $ex) {
                // Session not valid, Graph API returned an exception with the reason.
                echo $ex->getMessage();
            } catch (\Exception $ex) {
                // Graph API returned info, but it may mismatch the current app or have expired.
                echo $ex->getMessage();
            }
//            echo 'Method: ' . $method . '<br />';
            //echo 'Graph: ' . $graph . '<br />';
            //echo 'Params: ' . json_encode($params) . '<br />';
            $fr = (new FacebookRequest( $this->_session, $method, $graph, $params ));
            //echo "1a<br />";
            $ex = $fr->execute();
            //echo "1b<br />";
            $r = $ex->getGraphObject()->asArray();
            //echo "1c<br />";
            $end = time();
            $time_took = $end - $start;
            $seconds_took = $time_took;
            if($seconds_took > 10)
            {
                //mail("natesanden@gmail.com", "Facebook API call took more than 10 seconds", "Seconds: " . $seconds_took . "\n\n" . $graph);
            }
            //echo "1d<br />";
            return $r;
        } catch( \Facebook\FacebookRequestException $exc ) {
            //echo "2<br />";
            // When Facebook returns an error
            // handle this better in production code
            //mail("natesanden@gmail.com", "Facebook Error #1", $_SESSION['fb_token'] . "\n\n" . $graph . "\n\n" . $exc->getMessage());
            try {
                //echo "2a<br />";
                Yii::trace('Executed Facebook Request Attempt 2: ' . $graph, 'Facebook');
                \Yii::beginProfile('Graph 2' . $graph, 'Facebook');
                return (new FacebookRequest( $this->_session, $method, $graph, $params ))->execute()->getGraphObject()->asArray();
            } catch( \Facebook\FacebookRequestException $exc ) {
                //echo "2b<br />";
                Yii::$app->session->setFlash('danger', 'Facebook says: ' . $exc->getMessage());
                //mail("natesanden@gmail.com", "Facebook Error #2", $_SESSION['fb_token'] . "\n\n" . $graph . "\n\n" . $exc->getMessage());
                return $exc->getMessage();
            }
        } catch( \Exception $exc ) {
            //echo "3<br />";
            // When validation fails or other local issues
            // handle this better in production code
            Yii::$app->session->setFlash('danger', $exc->getMessage());
            //mail("natesanden@gmail.com", "Couldn't run api call", $exc->getMessage());
            return $exc->getMessage();
        }
    }

    function get_user_pages_test()
    {
        \yii\helpers\VarDumper::dump($this->api_call('/me/accounts/?fields=id,name,cover,access_token'), 10, true);
    }

    function get_user_pages()
    {

        if(Yii::$app->session->get('_user_pages'))
        {
            $this->_user_pages = Yii::$app->session->get('_user_pages');
        }

        if(!$this->_user_pages)
        {
            try {
                if($this->has_permissions(['manage_pages']))
                {
                    $my_pages = $this->api_call('/me/accounts/?fields=id,name,cover,access_token&limit=200');
                }
                else
                {
                    $this->login(Yii::$app->params['siteUrl'] . Yii::$app->request->url, ['manage_pages'], true); //reqrequest
                }
            } catch (FacebookApiException $e) {
                throw $e;
            }

            if(isset($my_pages) && is_array($my_pages) && !empty($my_pages))
            {
                foreach($my_pages['data'] as $page)
                {
                    $pages[$page->id] = $page;
                }
                ksort($pages);
                $this->_user_pages = $pages;
                Yii::$app->session->set("_user_pages", $pages);
            }
            else
            {
                $this->_user_pages = [];
            }
        }
        return (array)$this->_user_pages;
    }

    function get_user_groups()
    {
        if(Yii::$app->session->get('_user_groups'))
        {
            $this->_user_groups = Yii::$app->session->get('_user_groups');
        }
        if(!$this->_user_groups)
        {
            try {
                if($this->has_permissions(['user_managed_groups']))
                {
                    $my_groups = $this->api_call('/me/groups?fields=id,name,cover&limit=100'); //todo, use the ['paging']->cursors->after tag to get MORE groups
                }
                else
                {
                    $this->login(Yii::$app->params['siteUrl'] . Yii::$app->request->url, ['user_managed_groups'], true);
                }
            } catch (FacebookApiException $e) {
                throw $e;
            }

            if(isset($my_groups) && is_array($my_groups) && isset($my_groups['data']) && is_array($my_groups['data']))
            {
                foreach($my_groups['data'] as $group)
                {
                    $groups[$group->id] = $group;
                }
                sort($groups);
                $this->_user_groups = $groups;
                Yii::$app->session->set("_user_groups", $groups);
            }
        }
        return (array)$this->_user_groups;
    }

    public function get_user_group_list()
    {
        $groups = $this->get_user_groups();
        $list = [];
        foreach($groups as $group)
        {
            if(isset($group->administrator) && $group->administrator == true)
            {
                $admin = ' (Administrator)';
            }
            else
            {
                $admin = '';
            }
            $list[$group->id] = $group->name . $admin;
        }
        return $list;
    }

    public function get_user_page_list()
    {
        $pages = $this->get_user_pages();
        $list = [];
        foreach($pages as $page)
        {
            $list[$page->id] = $page->name;
        }
        return $list;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    function get_long_lived_token($short_lived_access_token)
    {
        try {
            $token_url = 'https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=' . $this->_appId . '&client_secret=' . $this->_secret . '&fb_exchange_token=' . $short_lived_access_token;
            $token = explode("=", file_get_contents($token_url));
        } catch (Exception $e) {
            throw $e;
        }
        return $token[1];
    }

    function get_permanent_page_access_token($page_id)
    {
        //set access token to long lived token
        $short_lived_access_token = $this->get_page_access_token($page_id);
        return $this->get_long_lived_token($short_lived_access_token);
    }

    function get_page_access_token($page_id)
    {
        Yii::$app->session->remove('_user_pages');
        $pages = $this->get_user_pages();

        foreach($pages as $v)
        {
            if($v->id == $page_id) {
                return $v->access_token;
            }
        }
        return false;
    }

    function has_permissions($permissions)
    {
        if($permissions)
        {
            $user_permissions = false; //Yii::$app->cache->get(md5('user_permissions' . serialize($permissions)));
            if($user_permissions === false)
            {
                \Yii::beginProfile('Facebook: Check Permissions');
                if($this->_session == null)
                {
                    $helper = $fh = Yii::$app->postradamus->setupFacebook([
                        'permissions' => ['manage_pages'],
                        'redirect_url' => Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('site/index')
                    ]);
                    $this->create_session($helper);
                }
                $user_permissions = (new FacebookRequest( $this->_session, 'GET', '/me/permissions' ))->execute()->getGraphObject()->asArray();
                \Yii::endProfile('Facebook: Check Permissions');
                Yii::$app->cache->set(md5('user_permissions' . serialize($permissions)), $user_permissions, 20 * 60);
            }
            //print("<pre>");
            //print_r($user_permissions);
            //die();

            if($user_permissions)
            {
                foreach($user_permissions as $user_permission)
                {
                    if($user_permission->status == 'granted')
                        $user_has_permissions[] = $user_permission->permission;
                }
            }
            foreach($permissions as $permission)
            {
                if(!in_array($permission, $user_has_permissions))
                {
                    return false;
                }
            }
            return true;
        }

        //$session->close();
        return true;
    }


}