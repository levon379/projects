<?php


$types = new stdClass();
$notif = new Notification_Model();
$types->type_comment_blogger    = Notification_Model::TYPE_BL_COMMENT;
$types->type_mention_twitter   	= Notification_Model::TYPE_TW_MENTION;
$types->type_directmsg_facebook = Notification_Model::TYPE_FB_DIRECT_MSG;
$types->type_suggested_post 	= Notification_Model::TYPE_SUGGESTED_POST;
$types->type_order_complete 	= Notification_Model::TYPE_ORDER_COMPLETE;

return $types;
