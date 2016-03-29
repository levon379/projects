<?php
/**
 * Created by PhpStorm.
 * User: dev31
 * Date: 05.10.15
 * Time: 14:06
 */
//require class
require_once "WarbbleApiClient.php";
//set warbble URL
$warbbleSiteUrl = "http://gregfurlonglocal.com";

//create object
$auth = new WarbbleApiClient($warbbleSiteUrl);
$result=false;

//save token into database for reseller-user
if ($credentials = $auth->fetchCredentials()) {
    //@TODO remove code below, and insert database save code
    file_put_contents('base.txt', $credentials['token']);
}
//read token from database for current reseller-user
//@TODO remove code below, and insert database read code
$token = file_get_contents('base.txt');

//send responce to warbble site if happen some event, like clock button and send $_POST['login']
if($token && !empty($_POST['login']) && $_POST['login'] == "Login") {
    $result = $auth->warbbleLogin($token);
} elseif(!empty($_POST['login'])) {
    $result = $auth->warbbleLogin();
}
//redirect on site or login/singin page
if(!empty($result['url'])) $auth->redirect($result['url']);
?>
<!-- Some form or button for sample, when happened event login -->
<!Doctype html>
<html>
<head>
<body>
<header>
</header>
<div id="content">
    <form action="" method="post">
        <input type="submit" name="login" value="Login" />
    </form>
</div>
<footer></footer>
</body>
</head></html>
