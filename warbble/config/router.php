<?php
/**
 * route
 */
$route = array();
$route['^(login.*)$']                   = 'Users/login';
$route['^(singup.*)$']                  = 'Users/singup';
$route['^(logout.*)$']                  = 'Users/logout';
$route['^(forgot.*)$']                  = 'Users/forgot';
$route['^(change\-password.*)$']        = 'Users/change_password';
$route['^(myaccount)$']                 = 'Users/myaccount';
$route['^(upgrade)$']			= 'Users/upgrade';
$route['^(Dashboard)$']                 = 'Dashboard/index';
$route['^(Admin)$']			            = 'Admin/index';
$route['^(Facebook)$']                  = 'Dashboard/facebook';
$route['^(Posts)$']                     = 'Posts/index';
$route['^(company)$']                   = 'Company/index';
// <twitter>
$route['^(twitter\/tweets)$']           = 'Twitter/index';
$route['^(twitter\/activity)$']         = 'Twitter/tab_activity';
$route['^(twitter\/followers)$']        = 'Twitter/tab_followers';
// </twitter>
// <facebook>
$route['^(facebook\/posts)$']           = 'Facebook/index';
$route['^(facebook\/activity)$']        = 'Facebook/tab_activity';
// </facebook>
// <blogger>
$route['^(blogger)$']                   = 'Blogger/index';
$route['^(blogger\/login)$']            = 'Blogger/login';
$route['^(blogger\/activity)$']         = 'Blogger/tab_activity';
// </blogger>
$route['^(webhook)$']                   = 'Webhook/webhook';
$route['^(payment)$']                   = 'Users/payment';
$route['^(confirm)$']                   = 'Payment/PaymentConfirmation';
$route['^(coupon)$']                    = 'Coupon/create';
$route['^(coupon\/qrcode)$']            = 'Coupon/getQRCode';
$route['^(coupon\/socialhtmls)$']       = 'Coupon/getSocialHtmls';
$route['^(coupon\/save)$']              = 'Coupon/save';
$route['^(coupon\/shedule)$']           = 'Coupon/shedule';
$route['^(media)$']                     = 'Media/index';
$route['^(media\/attachments)$']        = 'Media/attachments';
$route['^(media\/create)$']             = 'Media/create';
$route['^(media\/read)$']               = 'Media/read';
$route['^(media\/delete)$']             = 'Media/delete';
$route['^(stats.*)$']                   = 'Stats/index';
// api
$route['^(api\/register.*)$']           = 'Users/api_register';
$route['^(api\/login.*)$']              = 'Users/api_login';

$route['^(home\/blog)$']                = 'Home/our_blog';
$route['^(home\/termservices)$']        = 'Home/termsofservice';

return $route;