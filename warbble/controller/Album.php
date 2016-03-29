<?php

class Album extends Controller
{
    public function  __construct()
    {
        parent::__construct();
        $this->load->model('Media_Model');

        $this->_js = array(
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
                'file'      => 'angular/modules/album.module.js',
                'location'  => 'footer',
            ),
            /*array(
                'type'      => 'admin',
                'file'      => 'angular/config/album.config.js',
                'location'  => 'footer',
            ),*/
            array(
                'type'      => 'admin',
                'file'      => 'angular/controllers/album.controller.js',
                'location'  => 'footer',
            ),
        );

        $this->_css = array(
            array(
                'type' => 'admin',
                'file' => 'album.css',
            ),
        );

        $this->set_filters(array(
            'index'         => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'fetch'         => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'delete'        => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));

    }

    public function index()
    {
        $this->layout('admin', 'album/index');
    }

    public function fetch()
    {
        $current_user = Users_Model::get_current_user();
        $user_id = $current_user->id;
        $perPage = 10;
        $offset = isset($_GET['page'])? ($_GET['page'] - 1) * $perPage: 0;
        $models = Media_Model::all(array('limit' => $perPage, 'offset' => $offset, 'conditions' => array('user_id = ?', $user_id)));

        $response['models'] = array_map(function($item){
            return $item->attributes();
        }, $models);
        $response['total'] = Media_Model::count(array('conditions' => array('user_id = ?', $user_id)));
        echo json_encode($response);
    }

    function delete()
    {
        $response['status'] = false;
        if (isset($_GET['id'])) {
            $current_user = Users_Model::get_current_user();
            $user_id = $current_user->id;
            if ($attachment = Media_Model::first(array('id' => $_GET['id']))) {
                if($attachment->user_id == $user_id){
                    $response['status'] = $attachment->delete();
                    $response['total'] = Media_Model::count(array('conditions' => array('user_id = ?', $user_id)));
                }
            }
        }
        $perPage = 10;
        $offset = isset($_GET['page'])? ($_GET['page'] - 1) * $perPage: 0;
        $models = Media_Model::all(array('limit' => $perPage, 'offset' => $offset, 'conditions' => array('user_id = ?', $user_id)));
        $response['models'] = array_map(function($item){
            return $item->attributes();
        }, $models);
        echo json_encode($response);
    }

}