<?php

class SuggestedPosts extends Controller
{
    public function  __construct()
    {
        parent::__construct();
        $this->load->model('Suggested_posts_Model');
        $this->load->model('Suggested_posts_user_Model');

        $this->_js = array(
            array(
                'type' => 'admin',
                'file' => 'media.js',
                'location' => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'suggested_posts.js',
                'location'  => 'footer',
            ),
        );

        $this->_css = array(
            array(
                'type' => 'admin',
                'file' => 'media.css',
            ),
        );

        $this->set_filters(array(
            'index'         => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_CONTENT_DEVELOPER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'create'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_CONTENT_DEVELOPER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'update'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_CONTENT_DEVELOPER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'delete'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_CONTENT_DEVELOPER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'actions'       => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_CONTENT_DEVELOPER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'action'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_CONTENT_DEVELOPER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));

    }

    public function action($id)
    {
        $model = Suggested_posts_user_Model::find($id);
        $this->layout('admin', 'suggestedPosts/action', array('model' => $model));
    }

    public function actions()
    {
        $data = array();
        if (!$current_user = Users_Model::get_current_user()) return;

        if ($current_user->check_permission(array(Roles_Model::TYPE_LEVEL_ADMIN))) {
            $conditions = array();
        } else {
            $conditions = 'suggested_posts.user_id = ' . $current_user->user_id;
        }

        $data['gridview'] = new Gridview(array(
            'table_name'    => 'User Actions',
            'model_name'    => 'Suggested_posts_user_Model',
            'select'        => 'suggested_posts_user.*',
            'joins'         => 'JOIN suggested_posts ON(suggested_posts.id = suggested_posts_user.post_id)',
            'conditions'    => $conditions,
            'order'         => 'suggested_posts_user.date desc',
            'columns'       => array(
                array(
                    'title'     => 'Status',
                    'filter'     => function($model){
                        $status = $model->status == Suggested_posts_user_Model::STATUS_REJECTED? 'rejected': 'accepted';
                        return sprintf('<a href="%s">%s %s your post </a><a href="%s">#%s.</a>', base_url('SuggestedPosts/action/' . $model->id), $model->action_user->get_name(), $status, base_url('SuggestedPosts/update/' . $model->suggested_post->id) , $model->suggested_post->id);
                    },
                )
            ),
            'pagination' => array(
                'per_page' => 10
            ),
        ));
        $this->layout('admin', 'suggestedPosts/index', $data);
    }

    public function index()
    {
        $data = array();
        if (!$current_user = Users_Model::get_current_user()) return;

        if ($current_user->check_permission(array(Roles_Model::TYPE_LEVEL_ADMIN))) {
            $conditions = array();
        } else {
            $conditions = array(
                'user_id' => $current_user->user_id
            );
        }

        $data['gridview'] = new Gridview(array(
            'table_name'    => 'Suggested Posts',
            'model_name'    => 'Suggested_posts_Model',
            'conditions'    => $conditions,
            'columns'       => array(
                array(
                    'name'      => 'id',
                    'title'     => 'ID',
                ),
                array(
                    'title'     => 'Post',
                    'filter'     => function($model){
                        return strlen($model->message) > 30 ? substr($model->message, 0, 30) . '...': $model->message;
                    },
                ),
                array(
                    'title'     => 'Channels',
                    'filter'     => function($model){
                        return $model->channels_str();
                    },
                ),
                array(
                    'title'     => 'Actions',
                    'filter'     => function($model){
                        return sprintf('<a href="/SuggestedPosts/update/%s"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>', $model->id) .
                               sprintf('<a href="/SuggestedPosts/delete/%s"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>', $model->id);
                    },
                ),
            ),
            'pagination' => array(
                'per_page' => 10
            ),
        ));
        $this->layout('admin', 'suggestedPosts/index', $data);
    }

    public function create()
    {
        $data = array(
            'errors'        => array(),
            'status'        => false,
            'medialibrary'  => $this->medialibrary,
            'users' => Users_Model::find_by_sql(sprintf("
                SELECT users.*
                FROM users
                JOIN roles ON roles.user_id = users.user_id
                WHERE roles.level IN (%s, %s)
                ORDER BY first_name ASC, last_name ASC
            ", Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_USER)),
        );

        if (isset($_POST['SuggestedPosts'])) {
            if (!$current_user = Users_Model::get_current_user()) return;
            if (isset($_POST['SuggestedPosts']['channels'])) {
                $_POST['SuggestedPosts']['channels'] = json_encode($_POST['SuggestedPosts']['channels']);
            }
            $post = new Suggested_posts_Model($_POST['SuggestedPosts']);
            $post->date = time();
            $post->user_id = $current_user->user_id;
            if (!$post->is_valid()) {
                $data['errors'] = array_merge($data['errors'], $post->errors->full_messages());
            } else if (!isset($_POST['SuggestedPostsTo']['user_id'])) {
                $data['errors'][] = 'Please, select user(s).';
            } else {
                $post->save();
                foreach ($_POST['SuggestedPostsTo']['user_id'] as $user_id) {
                    $post_to = new Suggested_posts_to_Model(array(
                        'user_id' => $user_id,
                        'post_id' => $post->id,
                    ));
                    $post_to->save();

                    //create notification
                    $type = Notification_Model::TYPE_SUGGESTED_POST;
                    $notif = new Notification_Model();
                    $notif->type = $type;
                    $notif->date = time();
                    $notif->user_id = $user_id;
                    $notif->status = Notification_Model::STATE_NOTREAD;
                    $notif->message = Notification_Model::$messages[$type];
                    $notif->uri = Notification_Model::$redirect_url[$type];
                    $result = $notif->save();
                }
                redirect(base_url('suggestedPosts/index'));
            }
        }

        $this->layout('admin', 'suggestedPosts/create', $data);
    }

    public function update($id)
    {
        if (!$id) redirect(base_url('suggestedPosts/index'));

        $data = array(
            'errors'            => array(),
            'status'            => false,
            'post'              => Suggested_posts_Model::find($id),
            'medialibrary'      => $this->medialibrary,
            'users' => Users_Model::find_by_sql(sprintf("
                SELECT users.*
                FROM users
                JOIN roles ON roles.user_id = users.user_id
                WHERE roles.level IN (%s, %s)
                ORDER BY first_name ASC, last_name ASC
            ", Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_USER)),
            'selected_users'    => array(),
        );
        foreach($data['post']->users_to as $user_to) {
            $data['selected_users'][] = $user_to->user_id;
        }
        if (!$data['post']) redirect(base_url('suggestedPosts/index'));
        $data['selected_channels'] = json_decode($data['post']->channels, true);
        if (isset($_POST['SuggestedPosts'])) {
            if (isset($_POST['SuggestedPosts']['channels'])) {
                $_POST['SuggestedPosts']['channels'] = json_encode($_POST['SuggestedPosts']['channels']);
            }
            $data['post']->set_attributes($_POST['SuggestedPosts']);
            if (isset($_POST['SuggestedPostsTo']['user_id'])) {
                if ($data['selected_users'] != $_POST['SuggestedPostsTo']['user_id']) {
                    Suggested_posts_to_Model::table()->delete(array('post_id' => $id));
                    foreach ($_POST['SuggestedPostsTo']['user_id'] as $user_id) {
                        $post_to = new Suggested_posts_to_Model(array(
                            'user_id' => $user_id,
                            'post_id' => $id,
                        ));
                        $post_to->save();
                        //create notification
                        $type = Notification_Model::TYPE_SUGGESTED_POST;
                        $notif = new Notification_Model();
                        $notif->type = $type;
                        $notif->date = time();
                        $notif->user_id = $user_id;
                        $notif->status = Notification_Model::STATE_NOTREAD;
                        $notif->message = Notification_Model::$messages[$type];
                        $notif->uri = Notification_Model::$redirect_url[$type];
                        $result = $notif->save();
                    }
                }
            } else {
                $data['errors'][] = 'Please, select user(s).';
            }

            if (!$data['post']->is_valid() || !empty($data['errors'])) {
                $data['errors'] = array_merge($data['errors'], $data['post']->errors->full_messages());

            } else {
                $data['post']->save();
                redirect(base_url('SuggestedPosts/index'));
            }
        }

        $this->layout('admin', 'suggestedPosts/update', $data);
    }

    function delete($id)
    {
        if ($product = Suggested_posts_Model::first(array('id' => $id))) {
            $product->delete();
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}