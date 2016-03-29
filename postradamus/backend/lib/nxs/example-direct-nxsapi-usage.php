<?php
/*#############################################################################
Project Name: NextScripts Social Networks AutoPoster
Project URL: http://www.nextscripts.com/snap-api/
Description: Automatically posts to all your Social Networks
Author: NextScripts, Inc
Author URL: http://www.nextscripts.com
Copyright 2012-2014  NextScripts, Inc
#############################################################################*/

if (!function_exists('prr')) {
    function prr($str)
    {
        echo "<pre>";
        print_r($str);
        echo "</pre>\r\n";
    }
}

error_reporting(E_ALL);

require_once "nxs-api/nxs-api.php";

$email = 'YourEmail@gmail.com';
$pass = 'YourPassword';
$msg = 'Post this to Google Plus!';
$pageID = '109888164682746252347';
$lnk = 'http://www.nextscripts.com/social-networks-auto-poster-for-wp-multiple-accounts';

// ############################## 1. Simple Message

$nt = new nxsAPI_GP();
$loginError = $nt->connect($email, $pass);
if (!$loginError) {
    $result = $nt->postGP($msg);
} else echo $loginError;

if (!empty($result) && is_array($result) && !empty($result['post_url']))
    echo '<a target="_blank" href="' . $result['post_url'] . '">New Post</a>'; else echo "<pre>" . print_r($result, true) . "</pre>";


// ############################## 2. Message to business page

$nt = new nxsAPI_GP();
$loginError = $nt->connect($email, $pass);
if (!$loginError) {
    $result = $nt->postGP($msg, '', $pageID);
} else echo $loginError;

if (!empty($result) && is_array($result) && !empty($result['post_url']))
    echo '<a target="_blank" href="' . $result['post_url'] . '">New Post</a>'; else echo "<pre>" . print_r($result, true) . "</pre>";

// ############################## 3. Message with link

$nt = new nxsAPI_GP();
$loginError = $nt->connect($email, $pass);
if (!$loginError) {
    $result = $nt->postGP($msg, $lnk, $pageID);

    if (!empty($result) && is_array($result) && !empty($result['post_url']))
        echo '<a target="_blank" href="' . $result['post_url'] . '">New Post</a>'; else echo "<pre>" . print_r($result, true) . "</pre>";
} else echo $loginError;

// ############################## 3. Message with image

$nt = new nxsAPI_GP();
$loginError = $nt->connect($email, $pass);
if (!$loginError) {
    $lnk = array('img' => 'http://www.nextscripts.com/imgs/nextscripts.png');
    $result = $nt->postGP($msg, $lnk, $pageID);

    if (!empty($result) && is_array($result) && !empty($result['post_url']))
        echo '<a target="_blank" href="' . $result['post_url'] . '">New Post Link</a>'; else echo "<pre>" . print_r($result, true) . "</pre>";
} else echo $loginError;

?>