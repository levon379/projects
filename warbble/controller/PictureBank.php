<?php

/**
 * Created by PhpStorm.
 * User: dev31
 * Date: 27.10.15
 * Time: 11:30
 */
class PictureBank extends Controller
{
    public function __construct()
    {
        parent::__construct();


        $this->_js = array
        (
            array(
                'type'      => 'admin',
                'file'      => 'slick.min.js',
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
                'file'      => 'picturebank.js',
                'location'  => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'coupon.js',
                'location'  => 'footer',
            ),
        );

        $this->_css = array
        (
            array(
                'type'      => 'admin',
                'file'      => 'slick.css',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'slick-theme.css',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'coupon.css',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'daterangepicker.css',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'media.css',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'social.css',
            ),

        );

        $this->set_filters(array(
            'index'                 => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'create'                => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'attachments'           => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'read'                  => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'update'                => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'delete'                => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));

    }

    public function index()
    {
        if($this->is_ajax()) {
            exit;
        } else {
            $current_user       = Users_Model::get_current_user();
            $type               = "all";
            $this->layout('admin', 'pictureBank/index', array(
                'medialibrary' => $this->medialibrary,
                'current_user'  => $current_user,
                'type'  => $type,
            ));
        }
    }
    public function create()
    {

    }

}