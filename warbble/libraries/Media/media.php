<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02.09.15
 * Time: 15:24
 */
class Medialibrary
{
    public $type = 'all';

    public function __construct()
    {

    }

    public function render($type = 'all', $args=array("title" => "Media uploader", "dragtext" => "Upload your file here"))
    {
        $current_user       = Users_Model::get_current_user();
        $args['current_user'] =$current_user;
        $args['type'] =$type;
        echo $this->view('media_popup',$args);
    }

    public function showBank($type = 'all', $args=array("title" => "Media uploader", "dragtext" => "Upload your file here"))
    {
        $current_user       = Users_Model::get_current_user();
        $args['current_user'] =$current_user;
        $args['type'] =$type;
        echo $this->view('picture_bank',$args);
    }

    public function view($view='', $dis = array(), $return = false ){
        if ( ! file_exists(ABSPATH."libraries/Media/views/".$view.'.php'))
        {
            return;
        }

        extract($dis);
        ob_start();
        include(ABSPATH."libraries/Media/views/".$view.'.php');
        $html = ob_get_contents();
        ob_end_clean();


        if (!$return) {
            echo $html;
        } else {
            return $html;
        }

    }
}