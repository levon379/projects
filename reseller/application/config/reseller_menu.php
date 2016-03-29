<?php

return array(
    array(
        'url'           => '/Reseller',
        'title'         => 'Home',
        'image_class'   => 'glyphicon glyphicon-dashboard'
    ),
    array(
        'url'           => '/Product/index',
        'title'         => 'Products',
        'image_class'   => 'fa fa-shopping-cart'
    ),
    array(
        'url'           => '/Order/index',
        'title'         => 'Orders',
        'image_class'   => 'fa fa-tags',
        
    ),
    array(
        'url'           => '/Users/index',
        'title'         => 'Users',
        'image_class'   => 'fa fa-users',
        'submenu'       => array(
            array(
                'url'     => '/Users/index',
                'title'   => 'All users',
            ),
            array(
                'url'     => '/Users/create',
                'title'   => 'Add user',
            ),
        )
    ),
);