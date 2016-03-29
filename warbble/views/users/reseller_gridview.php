<?php

return new Gridview(array(
    'table_name'    => 'Users',
    'model_name'    => 'Users_Model',
    'conditions'    => array('parent_id' => $current_user->user_id),
    'columns'       => array(
        array(
            'name'      => 'user_id',
            'title'     => 'ID',
        ),
        array(
            'title'     => 'Name',
            'filter'     => function($model){
                return sprintf('<a href="/Users/update/%s">%s</a>', $model->id, $model->get_name());
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
            'title'     => 'Actions',
            'filter'     => function($model){
                return sprintf('
                                <a href="/Users/delete/%s" data-toggle="tooltip" data-placement="top" title="Remove user"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                <a href="/Users/loginAs/%s" data-toggle="tooltip" data-placement="top" title="Sign in as this user"><i class="fa fa-sign-in"></i></a>
                            ',
                        $model->user_id,
                        $model->user_id
                    );
            },
        ),
    ),
    'pagination' => array(
        'per_page' => 10
    ),
));