<?php

namespace backend\components;

use Yii;

if(YII_ENV == 'dev')
{
    require_once "../lib/nxs/nxs-snap-class.php";
}
else
{
    require_once "/home/allblogs/botpostfb3/backend/lib/nxs/nxs-snap-class.php";
}

class WordpressHelper
{

    public $connected = false;
    public $username, $password, $xml_rpc_url;

    public function __construct($username, $password, $xml_rpc_url)
    {
        $this->username = $username;
        $this->password = $password;
        $this->xml_rpc_url = $xml_rpc_url;
    }

    public function getCategories()
    {

        if(YII_ENV == 'dev')
        {
            require_once('..\lib\nxs\inc-cl\apis\xmlrpc-client.php');
        }
        else
        {
            require_once('/home/allblogs/botpostfb3/backend/lib/nxs/inc-cl/apis/xmlrpc-client.php');
        }
        $nxsToWPclient = new \NXS_XMLRPC_Client($this->xml_rpc_url);

        $nxsToWPclient->debug = false;

        $nxsToWPclient->query('metaWeblog.getCategories', 0, $this->username, $this->password);

        $categories = $nxsToWPclient->getResponse();

        $categories_list = [];

        if(!empty($categories))
        {
            foreach($categories as $category)
            {
                if(isset($category['categoryName']))
                    $categories_list[$category['categoryName']] = $category['categoryName'];
            }
        }

        return $categories_list;
    }

    public function post($msg, $imgURL, $title = '', $category_name = '', $custom_fields = [])
    {
        \Yii::beginProfile('Post');
        $options = [
            'wp' => [
                [
                    'wpURL' => $this->xml_rpc_url,
                    'nName' => '',
                    'wpUName' => $this->username,
                    'wpPass' => $this->password,
                    'custom_fields' => $custom_fields,
                    'wpMsgFormat' => '%RAWTEXT%',
                    'wpMsgTFormat' => '%TITLE%',
                    'catSel' => '0',
                    'catSelEd' => '',
                    'doWP' => '1'
                ]
            ]
        ];

        $nxs_snapAPINts[] = array('code' => 'WP', 'lcode' => 'wp', 'name' => 'WP Based Blog');

        $nxsAutoPostToSN = new \cl_nxsAutoPostToSN($nxs_snapAPINts, $options);
        $message = array(
            'title' => $title,
            'text' => $msg,
            'cats' => array($category_name),
            'imageURL' => array('large' => $imgURL),
            'siteName' => 'Postradamus'
        );

        //## Set Message
        $nxsAutoPostToSN->setMessage($message);
        //## Post Message
        $post = $nxsAutoPostToSN->autoPost();

        $post = $this->decodePostResponse($post);
        \Yii::endProfile('Post');
        return $post;
    }

    public function decodePostResponse($post)
    {
        $ret = $post;
        $success = ''; $error = ''; $post_id = '';
        if (!empty($ret) && is_array($ret) && !empty($ret['wp'][0])) {
            if (!empty($ret['wp'][0]['isPosted'])) {
                $success = 1;
                $error = '';
                $post_id = $ret['wp'][0]['postID'];
            }
            if (!empty($ret['wp'][0]['Error'])) {
                $success = 0;
                $error = $ret['wp'][0]['Error'];
                $post_id = '';
            }
        }
        return ['success' => $success, 'error' => $error, 'post_id' => $post_id];
    }

}