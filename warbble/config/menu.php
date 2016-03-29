<?php

return array(
    array(
        'url'           => '/Posts/index',
        'title'         => 'Dashboard',
        'image_class'   => 'fa fa-tachometer',
        'access'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER),
    ),
    array(
        'url'           => '/SuggestedPosts/index',
        'title'         => 'Suggested Posts',
        'image_class'   => 'fa fa-wechat',
        'access'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_CONTENT_DEVELOPER),
        'submenu'       => array(
            array(
                'url'     => '/SuggestedPosts/index',
                'title'   => 'All Suggested Posts',
            ),
            array(
                'url'     => '/SuggestedPosts/create',
                'title'   => 'New Suggested Post',
            ),
            array(
                'url'     => '/SuggestedPosts/actions',
                'title'   => 'User Actions',
            ),
        )
    ),
    array(
        'url'           => '/coupon',
        'title'         => 'Coupons',
        'access'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER),
        'image_class'   => 'fa fa-fw fa-table'
    ),
    array(
        'url'           => '/company',
        'title'         => 'Companies',
        'image_class'   => 'fa fa-university'
    ),
    array(
        'url'           => '/Product/index',
        'title'         => 'Products',
        'image_class'   => 'fa fa-shopping-cart',
        'access'        => array(Roles_Model::TYPE_LEVEL_ADMIN),
        'submenu'       => array(
            array(
                'url'     => '/Product/index',
                'title'   => 'Products',
            ),
            array(
                'url'     => '/Product/create',
                'title'   => 'New Product',
            ),
        )
    ),
    array(
        'url'           => '/Orders/my_orders',
        'title'         => 'Orders',
        'image_class'   => 'fa fa-tags',
        'access'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER),
        'submenu'       => array(
            array(
                'url'     => '/Orders/view_all',
                'title'   => 'All Orders',
                'access'  => array(Roles_Model::TYPE_LEVEL_ADMIN),
            ),
            array(
                'url'     => '/Orders/my_orders',
                'title'   => 'My Orders',
            ),
        )
    ),

    array(
        'url'           => '/Users/index',
        'title'         => 'Users',
        'image_class'   => 'fa fa-users',
        'access'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_RESELLER, Roles_Model::TYPE_LEVEL_COMPANY_ADMIN),
        'submenu'       => array(
            array(
                'url'     => '/Users/index',
                'title'   => 'All users',
            ),
            array(
                'url'     => '/Users/create',
                'title'   => 'Add user',
            ),
            array(
                'url'     => '/Twitter/tw_fetch_manual',
                'title'   => 'Twitter Socket Manager',
                'access'  => array(Roles_Model::TYPE_LEVEL_ADMIN)
            ),
            array(
                'url'     => '/Facebook/stream_connect',
                'title'   => ' Facebook Start Stream',
                'image_class'   => 'fa fa-play',
                'access'  => array(Roles_Model::TYPE_LEVEL_ADMIN),
                'show'    => Post_fb_Model::is_stream_active(),
            ),
            array(
                'url'     => '/Facebook/stream_disconnect',
                'title'   => ' Facebook Stop Stream',
                'image_class'   => 'fa fa-stop',
                'access'  => array(Roles_Model::TYPE_LEVEL_ADMIN),
                'show'    => !Post_fb_Model::is_stream_active(),
            ),
        )
    ),
    array(
        'title'         => 'Manage social accounts',
        // 'url'           => '/Dashboard',
        'image_class'   => 'fa fa-plus',
        'access'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER),
        'submenu'       => array(
            array(
                'url'           => '/Dashboard',
                'title'         => 'Setup Account',
                'image_class'   => 'fa fa-fw fa-gear',
                'access'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER),
            ),
            array(
                'url'           => '/Dashboard/design',
                'title'         => 'Design order',
                'image_class'   => 'glyphicon glyphicon-dashboard',
                'access'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER),
            ),
            array(
                'url'     => '/twitter/add_account',
                'title'   => ' add account twitter',
                'image_class'   => 'fa fa-twitter',
                'noaccess'  => array(Roles_Model::TYPE_LEVEL_HAVE_TWITTER),
            ),
            array(
                'url'     => '/twitter/delete_account',
                'title'   => ' delete account twitter',
                'image_class'   => 'glyphicon glyphicon-remove-circle',
                'access'  => array(Roles_Model::TYPE_LEVEL_HAVE_TWITTER),
            ),
            array(
                'url'     => '/facebook/add_account',
                'title'   => ' add account facebook',
                'image_class'   => 'fa fa-facebook',
                'noaccess'  => array(Roles_Model::TYPE_LEVEL_HAVE_FACEBOOK),
            ),
            array(
                'url'     => '/facebook/delete_account',
                'title'   => ' delete account facebook',
                'image_class'   => 'glyphicon glyphicon-remove-circle',
                'access'  => array(Roles_Model::TYPE_LEVEL_HAVE_FACEBOOK),
            ),
            array(
                'url'     => '/blogger/login',
                'title'   => ' add account blogger',
                'image_class'   => 'glyphicon glyphicon-bold',
                'noaccess'  => array(Roles_Model::TYPE_LEVEL_HAVE_BLOGGER),
            ),
            array(
                'url'     => '/blogger/delete_account',
                'title'   => ' delete account blogger',
                'image_class'   => 'glyphicon glyphicon-remove-circle',
                'access'  => array(Roles_Model::TYPE_LEVEL_HAVE_BLOGGER),
            ),
        )
    ),
    array(
        'url'     => '/Album/index',
        'title'         => 'Picture Bank',
        'image_class'   => 'fa fa-file-image-o',
        'access'        => array(Roles_Model::TYPE_LEVEL_ADMIN,
                                    Roles_Model::TYPE_LEVEL_DESIGNER,
                                    Roles_Model::TYPE_LEVEL_USER,
                                    Roles_Model::TYPE_LEVEL_CUSTOMER)),

);