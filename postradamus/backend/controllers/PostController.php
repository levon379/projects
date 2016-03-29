<?php

namespace backend\controllers;

use Facebook\FacebookCanvasLoginHelper;
use Yii;
use common\models\cListPost;
use common\models\cListPostSearch;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\cListPostDeleted;
use common\models\cList;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use backend\components\FacebookHelper;
use backend\components\exporters\FacebookApi;
use  yii\web\Session;
use yii\helpers\Url;
use yii\web\UploadedFile;
use \backend\components\WordpressHelper;
use \backend\components\PinterestHelper;

/**
 * ListPostController implements the CRUD actions for cListPost model.
 */
class PostController extends cController
{
    public $enableCsrfValidation = false;

    public function actionEditImageModal()
    {
        $post = cListPost::find()->where(['id' => Yii::$app->request->get('id')])->one();

        $additional_javascript = "";
        $fabric_image_js = Yii::$app->postradamus->create_canvas_from_image($post->image_url, $post->image_filename0_custom, $additional_javascript);

        return $this->renderPartial('_edit_image_modal', [
            'fabric_image_js' => $fabric_image_js,
            'image_url' => $post->image_url,
            'id' => Yii::$app->request->get('id')
        ]);
    }

    /**
     * Lists all cListPost models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new cListPostSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single cListPost model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new cListPost model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new cListPost;
        $model->user_id = Yii::$app->user->id;
        $model->list_id = $id;

        if ($model->load(Yii::$app->request->post())) {
            if(/*$model->validate()*/1==1) {
                //upload new image to server
                $new_file_name = '';
                $imagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $model->list_id . '/';
                $model->save(false);
                $model->origin_type = $model::ORIGIN_UPLOAD;
                $model->origin_id = $model->id;

                $image = new \backend\components\Image;

                for($i=0; $i<4; $i++)
                {
                    $file = ArrayHelper::toArray(\yii\web\UploadedFile::getInstance($model, 'image[' . $i . ']'));
                    if(isset($file['error'])) { //uploading a new file (or existing)
                        //echo "New or existing file upload<br />";
                        if($file['error'] == 0) //new file, upload it
                        {
                            $new_file_name = $image->move_uploaded_file($file, $imagepath);
                            if($new_file_name && file_exists($imagepath . $new_file_name))
                            {
                                $name = 'image_filename' . $i;
                                //delete existing image from server
                                if($model->$name != '')
                                {
                                    @unlink($imagepath . $model->$name);
                                    @unlink($imagepath . 'thumb-' . $model->$name);
                                }
                                //update image_filename field in database
                                $model->$name = $new_file_name;
                            }
                        }
                        else
                        {
                            echo "Existing file<br />";
                            //user did not change the image, do nothing
                        }
                    }
                }

                $model->save(false);

                Yii::$app->session->setFlash('success', 'Your post has been created successfully.');
                return $this->redirect(['list/view', 'id' => $model->list_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionPostNow()
    {
        $fb = Yii::$app->postradamus->get_facebook_details();
        FacebookSession::setDefaultApplication($fb['app_id'], $fb['app_secret']);

        $helper = new FacebookRedirectLoginHelper(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('post/post-now'));
        // login helper with redirect_uri
        $fh = new FacebookHelper;
        try {
            $session = $fh->create_session($helper);
        }
        catch ( FacebookAuthorizationException $ex ) {
            $session = null;
            $e = $ex->getMessage();
        }
        catch( FacebookRequestException $ex ) {
            $e = $ex->getMessage();
        }
        catch(Exception $ex) {
            $e = $ex->message();
        }

        $fbPermissions=['manage_pages', 'publish_actions', 'publish_pages', 'user_managed_groups'];
        // see if we have a session
        if ( isset( $session ) ) {
            // graph api request for user data
            if(!$fh->has_permissions($fbPermissions))
            {
                if(isset($_GET['code']))
                {
                    if(!$fh->has_permissions(['manage_pages', 'publish_actions', 'publish_pages', 'user_managed_groups']))
                    {
                        Yii::$app->session->setFlash('danger', 'You must accept the Facebook permissions.');
                    }
                    //return $this->render('/content/facebook_error');
                }
                else
                {
                    $fh->login(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('post/post-now'), $fbPermissions);
                }
            }

        }
        else {

            unset($_SESSION['fb_token']);
            $fh->login(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('post/post-now'),$fbPermissions);
            //exit;
        }


        //Wordpress
        $wpUserName = Yii::$app->user->identity->getWordpressConnection('username', Yii::$app->session->get('campaign_id'));
        $wpPassword = Yii::$app->user->identity->getWordpressConnection('password', Yii::$app->session->get('campaign_id'));
        $wpXmlLink = Yii::$app->user->identity->getWordpressConnection('xml_rpc_url', Yii::$app->session->get('campaign_id')).'xmlrpc.php';


        $wordpress = new WordpressHelper( $wpUserName, $wpPassword, $wpXmlLink);

        $domain = parse_url(Yii::$app->user->identity->getWordpressConnection('xml_rpc_url', Yii::$app->session->get('campaign_id')))['host'];
        $wpCategories_list = $wordpress->getCategories();

        //Pinterest
        $email = Yii::$app->user->identity->getPinterestConnection('username', Yii::$app->session->get('campaign_id'));
        $pass = Yii::$app->user->identity->getPinterestConnection('password', Yii::$app->session->get('campaign_id'));

        $pinterst = new PinterestHelper($email, $pass);
        $pinBoards = $pinterst->getBoards();


        $new_post_data = json_decode(\Yii::$app->session->get('new_post_data'));
        $image_url = $new_post_data->image_url;
        $post_from = $new_post_data->post_from;
        if (array_key_exists('large_image_id', $new_post_data) && $post_from == "facebook") {
            $facebook = new \backend\components\importers\Facebook($fh);
            $ids = explode("_", $new_post_data->id);
            $image_url = $facebook->get_post_image_src($ids[0], $ids[1]);
        }
        $new_post_data->large_image = $image_url;
        $image = new \backend\components\Image;
        $postStatus = '';
        $postAlert = '';

        $model = new cListPost;
        //Post On social
        if(Yii::$app->request->post('post_to')) {

            $postMsg = Yii::$app->request->post('cListPost')['text'];

            $post_to = Yii::$app->request->post('post_to');

            $image = UploadedFile::getInstance($model, 'image');

            if($image) {

                $model->image = $image->name;
                $ext = explode(".", $image->name);
                $ext = end($ext);

                $model->image = Yii::$app->security->generateRandomString().".{$ext}";

                $path = Yii::$app->params['upload_path'] . $model->image;

                $image->saveAs($path);
                $image_url = Url::base(true).'/images/uploads/'.$model->image;
            }

            if($post_to == 'facebook') {

                if(Yii::$app->request->post('page_type')) {

                    $fbPage = Yii::$app->request->post('cListPost')['fb_page_id'];
                    $access_token = $_SESSION['fb_token'];


                    if(Yii::$app->request->post('page_type') == 'page') {

                        $access_token = $fh->get_page_access_token($fbPage);

                    }

                    $params = [
                        'access_token' => $access_token,
                        'post_message' => $postMsg,
                        'to_page' => $fbPage
                    ];



                    if(isset( Yii::$app->request->post('cListPost')['link']) && Yii::$app->request->post('cListPost')['link'] != '')
                    {
                        $params['post_link'] = Yii::$app->request->post('cListPost')['link'];
                        $params['post_image_url'] = $image_url;
                    }
                    else if(!Yii::$app->request->post('cListPost')['link']) {

                        if($image) {

                            $params['post_link'] = '';
                            $params['post_image_filename'] = $path;

                        }
                        else {

                            $params['post_link'] = '';
                            $params['post_image_url'] = $image_url;

                        }


                    }


                    // login helper with redirect_uri
                    $fh = new FacebookHelper;
                    $fh->_session = new FacebookSession($_SESSION['fb_token']);
                    $export = new FacebookApi($fh);

                    $responses = $export->post_to_api($params);

                    if($responses['error']) {

                        $postAlert =  $responses['error'];
                        $postStatus =  'danger';
                    }
                    else {

                        $postAlert =  'Your post successfully added';
                        $postStatus =  'success';

                    }

                }

            }
            elseif($post_to == 'pinterest'){

                if(Yii::$app->request->post('cListPost')['board_id']) {

                    $boardId = Yii::$app->request->post('cListPost')['board_id'];
                    $text = Yii::$app->request->post('cListPost')['text'];
                    $link = Yii::$app->request->post('cListPost')['link'];

                    if(isset($path)) {

                        $imgUrl = $path;
                    }
                    else if(Yii::$app->request->post('image_url')) {

                        $imgUrl = Yii::$app->request->post('image_url');
                    }
                    else {

                        $imgUrl = '';
                    }


                    $pinPost = $pinterst->post($text, $imgUrl, $link, $boardId);
                    if($pinPost['error']) {
                        $postAlert =  $pinPost['error'];
                        $postStatus =  'danger';
                    }
                    else {

                        $postAlert =  'Your post successfully added';
                        $postStatus =  'success';
                    }
                }


            }
            elseif($post_to == 'wordpress'){

                if(Yii::$app->request->post('cListPost')['wp_cat_id']) {


                    $wpCat = Yii::$app->request->post('cListPost')['wp_cat_id'];
                    $text = Yii::$app->request->post('cListPost')['text'];
                    $title = Yii::$app->request->post('cListPost')['title'];

                    if(isset($path)) {

                        $imgUrl = $path;
                    }
                    else if(Yii::$app->request->post('image_url')) {

                        $imgUrl = Yii::$app->request->post('image_url');
                    }
                    else {

                        $imgUrl = '';
                    }


                    $wpPost = $wordpress->post($text, $imgUrl, $title, $wpCat);

                    if($wpPost['error']) {

                        $postAlert =  $wpPost['error'];
                        $postStatus =  'danger';
                    }
                    else {

                        $postAlert =  'Your post successfully added';
                        $postStatus =  'success';

                    }


                }

            }

        }


        $model->text = $new_post_data->text;
        $model->link = $new_post_data->metalink;
        $model->title = $new_post_data->metaauthor_name;
        return $this->render('post-now',[
            'new_post_data' => $new_post_data,
            'model' => $model,
            'fh' => $fh,
            'wp_categories' => $wpCategories_list,
            'pinBoards' => $pinBoards,
            'post_alert' => $postAlert,
            'post_status' => $postStatus
        ]);


    }

    public function actionSavePostNowData()
    {
        if(Yii::$app->request->isAjax) {

            $data = json_decode(Yii::$app->request->post('post_data'));
            $model_id = Yii::$app->request->post('model_id');
            $new_post_array = [];
            foreach ($data as $value) {
                $value = get_object_vars($value);
                $key = key($value);
                $array_values = array_values($value);
                $key_arrays = explode($model_id, $key);
                $replace = str_replace(array('[', ']'), '', $key_arrays[1]);
                $new_post_array[$replace] = $array_values[0];

            }
            $new_post_array['post_from'] = Yii::$app->request->post('post_from');
            Yii::$app->session->set('new_post_data', json_encode($new_post_array));
        }

    }

    public function actionUpdateElement()
    {
        $model = $this->findModel(unserialize(base64_decode($_POST['pk'])));
        $name = $_POST['name'];
        $model->$name = $_POST['value'];
        $model->save(false);
    }

    /**
     * Updates an existing cListPost model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //upload new image to server
            $imagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $model->list_id . '/';
            $image = new \backend\components\Image;
            for($i=0; $i<4; $i++)
            {
                $file = ArrayHelper::toArray(\yii\web\UploadedFile::getInstance($model, 'image[' . $i . ']'));
                if(isset($file['error'])) { //uploading a new file (or existing)
                    //echo "New or existing file upload<br />";
                    if($file['error'] == 0) //new file, upload it
                    {
                        $new_file_name = $image->move_uploaded_file($file, $imagepath);
                        if($new_file_name && file_exists($imagepath . $new_file_name))
                        {
                            $name = 'image_filename' . $i;
                            //delete existing image from server
                            if($model->$name != '')
                            {
                                @unlink($imagepath . $model->$name);
                                @unlink($imagepath . 'thumb-' . $model->$name);
                            }
                            //update image_filename field in database
                            $model->origin_type = cListPost::ORIGIN_UPLOAD;
                            $model->$name = $new_file_name;
                            $model->save(false);
                        }
                    }
                    else
                    {
                        echo "Existing file<br />";
                        //user did not change the image, do nothing
                    }
                }
            }

            Yii::$app->session->setFlash('success', 'Your post has been updated successfully.');
            if(Yii::$app->session->get('returnUrl'))
                return $this->redirect(Yii::$app->session->get('returnUrl') . '#' . $id);

            return $this->redirect(['list/view', 'id' => $model->list_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionRemoveImage(){

        if (Yii::$app->request->isAjax) {
            $id = (int)Yii::$app->request->post('id');
            $model = $this->findModel($id);
            for ($i = 0; $i < 4; $i++) {
                $name = 'image_filename' . $i;
                $imagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $model->list_id . '/';
                if ($model->$name != '') {
                    @unlink($imagepath . $model->$name);
                    @unlink($imagepath . 'thumb-' . $model->$name);
                }
                $model->$name = "";
                //update image_filename field in database
                $model->origin_type = cListPost::ORIGIN_UPLOAD;
                $model->save(false);
            }
        }
    }

    public function actionSaveCustomImage()
    {
        //image data URI from Fabric
        $img = Yii::$app->request->post('image_data');
        $img_json = Yii::$app->request->post('image_json_data');
        //get post
        $post = cListPost::find()->andWhere(['id' => Yii::$app->request->post('id')])->one();
        $post->image_filename0_custom = $img_json;
        $post->save(false);
        //get new filename

        $filename = $post->convertImageFilenameToCustom($post->image_filename0);

        $file = $post->getImage_Filename_With_Path();
        //delete current image
        @unlink($file);
        //add new image
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $img = base64_decode($img);
        file_put_contents($file, $img);
        $data = ['img_url' => Yii::$app->params['imageUrl'] . 'posts/' . $post->user_id . '/' . $post->list_id . '/' . $filename];
        echo json_encode($data);
    }

    /**
     * Deletes an existing cListPost model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->delete())
        {
            $postmeta = \common\models\cListPostMeta::find()->where(['list_post_id' => $id])->one();
            if($postmeta) { $postmeta->delete(); }
            //create a record in the cListPostDeleted model
            $del = new cListPostDeleted;
            $del->user_id = $model->user_id;
            $del->origin_type = $model->origin_type;
            $del->origin_id = $model->origin_id;
            $del->save(false);

            Yii::$app->session->setFlash('success', 'Post deleted successfully.');
			/*
            @unlink(Yii::$app->params['imageUrl'] . 'posts/' .Yii::$app->user->id . '/' . $id . '/' . $model->image_filename0);
            @unlink(Yii::$app->params['imageUrl'] . 'posts/' .Yii::$app->user->id . '/' . $id . '/' . $model->image_filename1);
            @unlink(Yii::$app->params['imageUrl'] . 'posts/' .Yii::$app->user->id . '/' . $id . '/' . $model->image_filename2);
            @unlink(Yii::$app->params['imageUrl'] . 'posts/' .Yii::$app->user->id . '/' . $id . '/' . $model->image_filename3);
            //return $this->redirect(['list/view', 'id' => $model->list_id]);
			*/
        }
        else
        {
            Yii::$app->session->setFlash('danger', 'Post could not be deleted.');
        }
    }

    /**
     * Finds the cListPost model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return cListPost the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = cListPost::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
