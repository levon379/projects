<?php

class Notification extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->_js = array
        (
            array(
                'type' => 'admin',
                'file' => 'angular/core/angular.min.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'angular/core/ui-bootstrap-tpls-0.14.3.min.js',
                'location' => 'footer',
            ),
            /*array(
                'type' => 'admin',
                'file' => 'angular/core/angular-route.min.js',
                'location' => 'footer',
            ),*/
            array(
                'type'      => 'admin',
                'file'      => 'angular/modules/notification.module.js',
                'location'  => 'footer',
            ),
            /*array(
                'type'      => 'admin',
                'file'      => 'angular/config/notification.config.js',
                'location'  => 'footer',
            ),*/
            array(
                'type'      => 'admin',
                'file'      => 'angular/controllers/notification.controller.js',
                'location'  => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'moment.min.js',
                'location'  => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'daterangepicker.js',
                'location'  => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'bootstrap-paginator.min.js',
                'location'  => 'footer',
            ),
        );

        $this->_css = array
        (
            array(
                'type'      => 'admin',
                'file'      => 'daterangepicker.css',
            ),
            array(
                'type' => 'admin',
                'file' => 'notification.css',
            ),

        );

        $this->set_filters(array(
            'index'                 => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'create'                => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'viewed'                => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'read'                  => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'update'                => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'fetch'                => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'delete'                => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));
    }


    public function index()
    {
        $this->layout('admin', 'notification/index');
    }

    public function create($type)
    {
        $result = false;
        $current_user = Users_Model::get_current_user();
        if($current_user) {
            $notif = new Notification_Model();
            $notif->type = $type;
            $notif->date = time();
            $notif->user_id = $current_user->id;
            $notif->status = self::SATE_NOTREAD;
            $notif->message = self::$messages[$type];
            $result = $notif->save();
            unset($notif);
        }
        var_dump($result);
    }

    public function fetch()
    {
        $current_user = Users_Model::get_current_user();
        $user_id = $current_user->id;
        $perPage = 10;
        $offset = isset($_GET['page'])? ($_GET['page'] - 1) * $perPage: 0;
        $models = Notification_Model::all(array('limit' => $perPage, 'offset' => $offset, 'conditions' => array('user_id = ? AND status = ?', $user_id, 0)));

        $response['models'] = array_map(function($item){
            return $item->attributes();
        }, $models);
        $response['total'] = Notification_Model::count(array('conditions' => array('user_id = ? AND status = ?', $user_id, 0)));
        echo json_encode($response);
        exit;
    }

    public function fetchLastFour()
    {
        $current_user = Users_Model::get_current_user();
        $user_id = $current_user->id;
        $perPage = 4;
        $offset = isset($_GET['page'])? ($_GET['page'] - 1) * $perPage: 0;
        $models = Notification_Model::all(array( 'order' => 'date desc', 'limit' => $perPage, 'conditions' => array('user_id = ? AND status = ?', $user_id, 0)));

        $response['models'] = array_map(function($item){
            return $item->attributes();
        }, $models);
        $response['total'] = Notification_Model::count(array('conditions' => array('user_id = ? AND status = ?', $user_id, 0)));
        $response['base_url'] = base_url();
        echo json_encode($response);
        exit;
    }

    function delete()
    {
        $response['status'] = false;
        if (isset($_GET['id'])) {
            $current_user = Users_Model::get_current_user();
            $user_id = $current_user->id;
            if ($notification = Notification_Model::first(array('id' => $_GET['id']))) {
                if($notification->user_id == $user_id){
                    $response['status'] = $notification->delete();
                }
            }
        }
        echo json_encode($response);
        exit;
    }

}