<?php
require_once "Pinterest.php";

$email = 'natesanden@gmail.com';
$pass = 'hsdjsvhsd1';
$msg = 'Post this to Pinterest!';
$imgURL = 'http://media-cache-ak0.pinimg.com/236x/3f/a1/2e/3fa12efb2b51ef7d7244';
$link = 'http://www.savingadvice.com';
$boardID = '462533892918850852';
$nt = new Pinterest();
$loginError = $nt->connect($email, $pass);
if (!$loginError) {
    //$result = $nt -> post($msg, $imgURL, $link, $boardID);
} else echo $loginError;

$nt->getBoards();

print("<pre>");
print_r($nt->boards);
print("</pre>");

if (!empty($result) && is_array($result) && !empty($result['post_url']))
    echo '<a target="_blank" href="' . $result['post_url'] . '">New Post</a>';
else
    echo "<pre>" . print_r($result, true) . "</pre>";
?>