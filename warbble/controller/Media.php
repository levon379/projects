<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02.09.15
 * Time: 13:12
 */
class Media extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->set_filters(array(
            'index'                 => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'create'                => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'attachments'           => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'read'                  => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'update'                => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'delete'                => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));
    }

    public function index(){
        if($this->is_ajax()) {


            $html = $this->medialibrary->render();
            echo(json_encode(array("html"=>$html)));
            exit;
        } else {
            $media = new Medialibrary();
            $media->showBank();
        }
    }


    public function create(){
        if($this->is_ajax()) {
            $errors = array();
            if(!empty($_POST['user_id']) && !empty($_POST['type_attachments'])) {
                $current_user       = Users_Model::get_current_user();
                if($current_user->user_id === (int)$_POST['user_id'] &&
                    in_array($_POST['type_attachments'], Media_Model::$type_attachments))
                {
                    /**
                     * Save file in filesystem
                     * */
                    $media = new Media_Model();
                    $attach_data = $media->saveAttachment($_POST['files'], $_POST['type_attachments'], $_POST['user_id']);
                    if(isset($attach_data['result']['error']) && !empty($attach_data['result']['error']))
                    {
                        $errors = $attach_data['error'];
                    } else {
                        /**
                         * Save fileinfo into database
                         * */
                        $media->user_id     = $current_user->user_id;
                        $media->name        = basename($attach_data['result']['uri']);
                        $media->type        = $_POST['type_attachments'];
                        $media->mime        = $_POST['files']['filetype'];
                        $media->uri      = $attach_data['result']['uri'];
                        $status = $media->save();
                        if($status){
                            $attach_data['result']['attach_id'] = $media->id;
                            $attach_data['result']['url'] = BASE_URL . $media->uri;
                            $attach_data['result']['uri'] = $media->uri;
                            $attach_data['result']['name'] = $media->name;
                        }
                    }

                }
            } else {
                $errors[] = "Not all arguments!!";
            }

            if(!empty($errors))
            {
                echo json_encode(array("errors" => $errors));
            } else {
                echo json_encode($attach_data);
            }
            exit;
        } else {
            $media = new Medialibrary();
            $media->render();
            echo "OK";
        }
    }

    public function attachments(){
        if($this->is_ajax()) {
            $errors = array();
            $current_user       = Users_Model::get_current_user();
            if($current_user->user_id === (int)$_POST['user_id'] &&
                in_array($_POST['type_attachments'], Media_Model::$type_attachments))
            {
                /**
                 * Get attachments from database
                 * */
                $media = new Media_Model();
                $attachments = $media->getUserAttachments($_POST['user_id'],$_POST['type_attachments']);


            } else {
            $errors = "You dont have premissions!";
            }
            if(!empty($errors))
            {
                echo json_encode(array("errors" => $errors));
            } else {
                echo json_encode(array("attachments" => $attachments, 'status' => true,));
            }
            exit;
        } else {
            echo "OK";
        }
    }
    public function attachments_page()
    {
        if($this->is_ajax()) {
            $errors = array();
            $current_user       = Users_Model::get_current_user();
            $config['pagination']['per_page'] = isset($_POST['perpage'])? $_POST['perpage']: 12;
            $config['pagination']['current_page'] = isset($_POST['page'])? $_POST['page']: 1;

                /**
                 * Get attachments from database
                 * */
                $media = new Media_Model();
                $attachments = $media->getUserAttachments($current_user->id ,$_POST['type_attachments']);
                $countall = count($attachments);
                $config['pagination']['total_pages'] = ceil($countall / $config['pagination']['per_page']);
                $offset = ($config['pagination']['per_page'] * ($config['pagination']['current_page'] - 1));
                $attachments = $media->getUserAttachments($current_user->id ,$_POST['type_attachments'], $offset);


            if(!empty($errors))
            {
                echo json_encode(array("errors" => $errors));
            } else {
                echo json_encode(array("attachments" => $attachments, "pages" => $config['pagination']['total_pages'], 'status' => true,));
            }
            exit;
        } else {
            echo "OK";
        }
    }

    public function attachments_total()
    {
        if($this->is_ajax()) {
            $errors = array();
            $current_user       = Users_Model::get_current_user();
            /**
             * Get attachments from database
             * */
            $media = new Media_Model();
            $attachments = $media->getUserAttachments($current_user->id, $_POST['type_attachments'], 0, 0);


            if(!empty($errors))
            {
                echo json_encode(array("errors" => $errors));
            } else {
                echo json_encode(array("total" => count($attachments), 'status' => true,));
            }
            exit;
        } else {
            echo "OK";
        }
    }

    public function read(){
        if($this->is_ajax()) {
            $errors = array();
            $current_user       = Users_Model::get_current_user();
            if(!empty($current_user->user_id) && !empty($_POST['attach_id']))
            {
                /**Get attachments from database*/
                $media = Media_Model::first(array('conditions' => array('user_id = ? AND id = ?', $current_user->user_id, $_POST['attach_id'])));
                if($media) {
                    $attachment['id'] = $media->id;
                    $attachment['url'] = BASE_URL . $media->uri;
                    $attachment['name'] = $media->name;
                    $attachment['mime'] = $media->mime;
                } else {
                    $errors = "Attachment empty";
                }

            } else {
                $errors = "Not all arguments!!";
            }
            if(!empty($errors))
            {
                echo json_encode(array("errors" => $errors));
            } else {
                echo json_encode(array("attachment" => $attachment));
            }
            exit;
        } else {
            echo "OK";
        }
    }
    public function update(){}
    public function delete(){
        if($this->is_ajax()) {
            $errors = array();
            $current_user       = Users_Model::get_current_user();
            if(!empty($current_user->user_id) && !empty($_POST['attach_id']))
            {
                /**Get attachments from database*/
                $media = Media_Model::first(array('conditions' => array('user_id = ? AND id = ?', $current_user->user_id, $_POST['attach_id'])));
                /**Remove attachments from filesystem and database if exist*/
                if($media) {
                    $result = $media->deleteAttachment();
                } else {
                    $errors = "Attachment empty";
                }

            } else {
                $errors = "Not all arguments!!";
            }
            if(!empty($errors))
            {
                echo json_encode(array("errors" => $errors));
            } else {
                echo json_encode(array("result" => $result, "attachid" => $_POST['attach_id']));
            }
            exit;
        } else {
            echo "OK";
        }
    }
}