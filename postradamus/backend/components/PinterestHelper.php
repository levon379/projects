<?php

namespace backend\components;

use Yii;

if(YII_ENV == 'dev')
{
    require_once "../lib/nxs/nxs-api/nxs-api.php";
}
else
{
    require_once "/home/allblogs/botpostfb3/backend/lib/nxs/nxs-api/nxs-api.php";
}


class PinterestHelper extends \nxsAPI_PN {

    public $connected = false;
    public $username, $password, $check;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getBoards()
    {
        Yii::$app->session->remove($this->username . '_pinterest_boards');
        if(!$boards = Yii::$app->session->get($this->username . '_pinterest_boards')) {
            \Yii::beginProfile('Get User Boards');
            //connect
            $this->connect($this->username, $this->password);
            parent::getBoards(); //populates the $this->boards
            //format $this->boards in a good way
            if(is_array($this->boards))
            {
                foreach($this->boards as $board_info) {
                    $boards[$board_info['id']] = $board_info['n'];
                }
            }
            Yii::$app->session->set($this->username . '_pinterest_boards', $boards, 120); //10 min caching
            \Yii::endProfile('Get User Boards');
        }
        if(empty($boards))
        {
            $boards = [];
        }
        return $boards;
    }

    public function connect($u = '', $p = '')
    {
        \Yii::beginProfile('Connect User');
        if($u == '')
        {
            $u = $this->username;
        }
        if($p == '')
        {
            $p = $this->password;
        }
        $used_old = false;
        //try to load previous cookies
        if($ck = Yii::$app->cache->get(md5($u . $p . 'ck')))
        {
            $this->ck = $ck;
            $used_old = true;
        }

        //connect
        $connect = parent::connect($u, $p);
        if($connect == '')
        {
            //successful connection, save the cookies to use next time (24 hrs)
            Yii::info('Successful connection. Used cookies? ' . ($used_old ? 'true' : 'false'));
            Yii::$app->cache->set(md5($u . $p . 'ck'), $this->ck, 60 * 60 * 24);
        }
        elseif($used_old == true)
        {
            //unsuccessful, try again using no cookies
            Yii::$app->cache->delete(md5($u . $p . 'ck'));
            $this->ck = null;
            $this->check = null;
            $connect = parent::connect($u, $p);
            if($connect == '')
            {
                Yii::info('Successful connection on 2nd attempt. Used cookies? ' . ($used_old ? 'true' : 'false'));
                Yii::$app->cache->set(md5($u . $p . 'ck'), $this->ck, 60 * 60 * 24);
            }
        }
        else
        {
            Yii::info('Connection failed. ' . $connect);
        }
        \Yii::endProfile('Connect User');
        return $connect;
    }

    public function check($u = '')
    {
        \Yii::beginProfile('Check User');
        if(!$this->check)
        {
            $check = parent::check($u);
            $this->check = $check;
        }
        \Yii::endProfile('Check User');
        return $this->check;
    }

    public function post($msg, $imgURL, $lnk, $boardID, $title = '', $price = '', $via = '')
    {
        \Yii::beginProfile('Post');
        $post = parent::post($msg, $imgURL, $lnk, $boardID, $title = '', $price = '', $via = '');
        $post = $this->decodePostResponse($post);
        \Yii::endProfile('Post');
        return $post;
    }

    public function decodePostResponse($post)
    {
        //either we got an error or it posted correctly and we now have a postID
        if(is_string($post))
        {
            if(preg_match('~\[message\] => (.+)~im', $post, $matches))
            {
                //error
                return ['success' => 0, 'error' => $matches[1], 'post_id' => ''];
            }
        }
        elseif(is_array($post))
        {
            return ['success' => 1, 'post_id' => $post['postID'], 'error' => ''];
        }
        return ['success' => 0, 'error' => serialize($post), 'post_id' => ''];
    }

}