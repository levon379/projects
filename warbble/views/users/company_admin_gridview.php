<?php

$response = $current_user->get_company_data();
$custom_data = $response['users'];

return new Gridview(array(
    'table_name'    => 'Users',
    'model_name'    => 'Users_Model',
    'conditions'    => array(),
    'custom_data'   => $custom_data,
    'columns'       => array(
        array(
            'name'      => 'user_id',
            'title'     => 'ID',
        ),
        array(
            'title'     => 'Name',
            'filter'     => function($model){
                return $model->get_name();
            },
        ),
        array(
            'title'     => 'Email',
            'name'      => 'email',
        ),
        array(
            'title'     => 'Role',
            'filter'     => function($model){
                return $model->get_roles_str();
            },
        ),
        array(
            'title'     => 'Company',
            'filter'     => function($model){
                return $model->belongs_to_company()->name;
            },
        ),
        array(
            'title'     => 'Actions',
            'filter'     => function($model){
                return sprintf('<a href="/Users/loginAs/%s" data-toggle="tooltip" data-placement="top" title="Sign in as this user"><i class="fa fa-sign-in"></i></a>',$model->user_id);
            },
        ),
    ),
    'pagination' => array(
        'per_page' => 10
    ),
));