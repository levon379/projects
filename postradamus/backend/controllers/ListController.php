<?php

namespace backend\controllers;

use Yii;
use common\models\cList;
use common\models\cListSearch;
use common\models\cListPost;
use common\models\cListPostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\components\Scheduler;
use backend\components\SchedulerEnhanced;
use backend\models\ListSchedulerForm;
use backend\models\ListDuplicateForm;
use backend\models\ListSentForm;
use backend\models\ListClearForm;
use \kartik\datecontrol\Module;
use backend\models\ListPostTypeForm;
use backend\models\ListPostDeleteForm;
use backend\models\ListPostClearTextForm;
use backend\models\ListPostDuplicateForm;
use common\models\cListPostDeleted;
/**
 * ListController implements the CRUD actions for cList model.
 */
class ListController extends cController
{

    public function actionRunScheduler()
    {
        if (Yii::$app->request->get()) {
            //make sure the list is theirs (not sure how to do exists yet)
            $list_is_theirs = cList::find()/*->andWhere(['tbl_list.id' => Yii::$app->request->get('list_id')])*/->exists();
            if($list_is_theirs)
            {
                \backend\components\Common::print_p(Yii::$app->request->get());
                die();
                $scheduler = new SchedulerEnhanced(Yii::$app->request->get('schedule_id'), Yii::$app->request->get('list_id'), ['startDate' => Yii::$app->request->get('start_date'), 'unscheduledPostsOnly' => Yii::app()->request->get('unscheduled_posts_only'), 'addRandomization' => Yii::app()->request->get('add_randomization')]);
                $run = $scheduler->run();
                Yii::$app->session->setFlash('success', 'Scheduler ran successfully.');
            }
            else
            {
                Yii::$app->session->setFlash('danger', 'Scheduler could not run.');
            }
        }
        return $this->render('test', ['scheduler' => $scheduler]);
    }

    public function actionPostView($id)
    {
        $model = cListPost::findOne(['id' => $id]);
        echo $this->renderPartial('_post_view', ['model' => $model]);
    }

    public function actionMoveCalendarEvent()
    {
        $lp = cListPost::findOne(['id' => $_POST['id'], 'user_id' => Yii::$app->user->id]);
        $lp->scheduled_time = strtotime($_POST['date']);
        $lp->save(false);
        echo json_encode($_POST);
    }

    public function actionGetPages()
    {
        $fh = Yii::$app->postradamus->setupFacebook([
            'permissions' => ['manage_pages'],
            'redirect_url' => Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('list/get-pages')
        ]);

        return json_encode($fh->get_user_page_list());

    }

    public function actionGetLastScheduledTime($page_id)
    {
        $fh = Yii::$app->postradamus->setupFacebook([
            'permissions' => ['manage_pages'],
            'redirect_url' => Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('list/get-last-scheduled-time')
        ]);

        $fb = new \backend\components\importers\Facebook($fh);
        if($post = $fb->get_last_scheduled_post($page_id))
        {
            $r['status'] = 'success';
            $r['formatted'] = date(Yii::$app->postradamus->get_user_date_time_format(), $post['data'][0]->scheduled_publish_time);
            $r['post_id'] = $post['data'][0]->id;
            $r['formatted_picker'] = date('M d Y', $post['data'][0]->scheduled_publish_time);
            $r['timestamp'] = $post['data'][0]->scheduled_publish_time;
        }
        else
        {
            $r['status'] = 'error';
            $r['formatted'] = "None Found";
            $r['timestamp'] = 0;
        }
        echo json_encode($r);
    }

    public function actionChangePostType()
    {
        $postTypeForm = new ListPostTypeForm;
        if ($postTypeForm->load(Yii::$app->request->post()) && $postTypeForm->validate()) {
            foreach($postTypeForm->posts as $post_id)
            {
                $post = cListPost::findOne(['id' => $post_id, 'user_id' => Yii::$app->user->id]);
                $post->post_type_id = $postTypeForm->post_type_id;
                $post->save(false);
            }
            Yii::$app->session->setFlash('success', 'Selected posts have had their post types updated!');
            $this->redirect(['list/view', 'id' => $postTypeForm->list_id]);
        }
        print_r($postTypeForm->errors);
    }
	/*
	public function actionWipeText(){
		$response = ['success'=>1]; 
		$ids = isset( $_POST['ids'] ) ? $_POST['ids'] : null;
		if(!is_null($ids) && is_array($ids)){
			foreach($ids as $id){
				$post = cListPost::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);
				$post->text = '' ;
				if(!$post->save(false)){
					$response['success'] = 0 ; 
				}
			}	
		}
		exit( json_encode($response) );
	}
	*/
	public function actionClearText(){
        $clearTextForm = new ListPostClearTextForm;
        if ($clearTextForm->load(Yii::$app->request->post()) && $clearTextForm->validate()) {
            foreach($clearTextForm->posts as $post_id){
                $model = cListPost::findOne(['id' => $post_id]);
                if(!empty($model)){
                    $model->text = ''; 
					$model->save(false);
                }
            }
            Yii::$app->session->setFlash('success', 'Text for all selected posts has been cleared!');
            $this->redirect(['list/view', 'id' => $clearTextForm->list_id]);
        }
        else{
			Yii::$app->session->setFlash('error', 'Error! While clearing text for all selected posts!');
            $this->redirect(['list/view', 'id' => $clearTextForm->list_id]);
            print_r($deleteForm->getErrors());
        }
    }

    public function actionDeletePosts()
    {
        $deleteForm = new ListPostDeleteForm;
        if ($deleteForm->load(Yii::$app->request->post()) && $deleteForm->validate()) {
            foreach($deleteForm->posts as $post_id)
            {
                $model = cListPost::findOne(['id' => $post_id]);
                //create a record in the cListPostDeleted model
                if(!empty($model))
                {
                    $del = new cListPostDeleted;
                    $del->user_id = $model->user_id;
                    $del->origin_type = $model->origin_type;
                    $del->origin_id = $model->origin_id;
                    $del->save(false);
                    $model->delete();
                }
            }
            Yii::$app->session->setFlash('success', 'Selected posts have been deleted!');
            $this->redirect(['list/view', 'id' => $deleteForm->list_id]);
        }
        else
        {
            print_r($deleteForm->getErrors());
        }
    }

    public function actionDuplicatePosts()
    {
        $duplicateForm = new ListPostDuplicateForm;
        if ($duplicateForm->load(Yii::$app->request->post()) && $duplicateForm->validate()) {
            foreach($duplicateForm->posts as $post_id)
            {
                $post = cListPost::findOne(['id' => $post_id]);
                $newPost = new cListPost;
                $newPost->user_id = Yii::$app->user->id;
                $newPost->list_id = $post->list_id;
                $newPost->fb_post_type = $post->fb_post_type;
                $newPost->name = $post->name;
                $newPost->text = $post->text;
                $newPost->link = $post->link;
                $newPost->image_filename0_custom = $post->image_filename0_custom;

                if($post->image_filename0 != '')
                {
                    $image = new \backend\components\Image;
                    $originalimagepath = Yii::$app->params['imagePath'] . 'posts/' . $post->user_id . '/' . $duplicateForm->list_id . '/';
                    $newimagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $newPost->list_id . '/';
                    $filename = $image->download_image($originalimagepath . $post->image_filename0, $newimagepath);

                    $filename_parts = pathinfo($filename);
                    $newPost->image_filename0 = $filename_parts['basename'];
                }

                if($post->image_filename1 != '')
                {
                    $image = new \backend\components\Image;
                    $originalimagepath = Yii::$app->params['imagePath'] . 'posts/' . $post->user_id . '/' . $duplicateForm->list_id . '/';
                    $newimagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $newPost->list_id . '/';
                    $filename = $image->download_image($originalimagepath . $post->image_filename1, $newimagepath);

                    $filename_parts = pathinfo($filename);
                    $newPost->image_filename1 = $filename_parts['basename'];
                }

                if($post->image_filename2 != '')
                {
                    $image = new \backend\components\Image;
                    $originalimagepath = Yii::$app->params['imagePath'] . 'posts/' . $post->user_id . '/' . $duplicateForm->list_id . '/';
                    $newimagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $newPost->list_id . '/';
                    $filename = $image->download_image($originalimagepath . $post->image_filename2, $newimagepath);

                    $filename_parts = pathinfo($filename);
                    $newPost->image_filename2 = $filename_parts['basename'];
                }

                if($post->image_filename3 != '')
                {
                    $image = new \backend\components\Image;
                    $originalimagepath = Yii::$app->params['imagePath'] . 'posts/' . $post->user_id . '/' . $duplicateForm->list_id . '/';
                    $newimagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $newPost->list_id . '/';
                    $filename = $image->download_image($originalimagepath . $post->image_filename3, $newimagepath);

                    $filename_parts = pathinfo($filename);
                    $newPost->image_filename3 = $filename_parts['basename'];
                }

                $newPost->post_type_id = $post->post_type_id;
                $newPost->scheduled_time = $post->scheduled_time;
                $newPost->origin_type = $post->origin_type;
                $newPost->origin_id = $post->origin_id;
                $newPost->save(false);
            }
            Yii::$app->session->setFlash('success', 'Selected posts have been duplicated!');
            $this->redirect(['list/view', 'id' => $duplicateForm->list_id]);
        }
        //\backend\components\Common::print_p($duplicateForm->errors);
    }

    /**
     * Lists all cList models.
     * @return mixed
     */
    public function actionNotReady()
    {
        $searchModel = new cListSearch;
        $_GET['cListSearch']['status'] = cListSearch::STATUS_NOT_READY;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Lists all cList models.
     * @return mixed
     */
    public function actionReady()
    {
        $searchModel = new cListSearch;
        $_GET['cListSearch']['status'] = cListSearch::STATUS_READY;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionMarkSent()
    {
        //update list
        $list = cList::find()->where(['tbl_list.id' => Yii::$app->request->get('id')])->one();
        $list->sent_at = time();
        $list->save(false);
        Yii::$app->session->setFlash('success', 'You\'re list has been marked as sent.');
        $this->redirect(['list/view', 'id' => Yii::$app->request->get('id')]);
    }

    /**
     * Lists all cList models.
     * @return mixed
     */
    public function actionSending()
    {
        $searchModel = new cListSearch;
        $_GET['cListSearch']['status'] = cListSearch::STATUS_SENDING;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Lists all cList models.
     * @return mixed
     */
    public function actionSent()
    {
        $searchModel = new cListSearch;
        $_GET['cListSearch']['status'] = cListSearch::STATUS_SENT;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionDuplicate()
    {
        $duplicateModel = new ListDuplicateForm;
        if ($duplicateModel->load(Yii::$app->request->post()) && $duplicateModel->validate()) {
            //create a list
            $list = new cList;
            $list->name = $duplicateModel->to_list_name;
            $list->user_id = Yii::$app->user->id;
            if($list->save())
            {
                //create the posts
                $posts = cListPost::find()->where(['list_id' => $duplicateModel->from_list_id])->all();
                foreach($posts as $post)
                {
                    $newPost = new cListPost;
                    $newPost->user_id = Yii::$app->user->id;
                    $newPost->list_id = $list->id;
                    $newPost->fb_post_type = $post->fb_post_type;
                    $newPost->name = $post->name;
                    $newPost->text = $post->text;
                    $newPost->link = $post->link;
                    $newPost->image_filename0_custom = $post->image_filename0_custom;

                    if($post->image_filename0 != '')
                    {
                        $image = new \backend\components\Image;
                        $originalimagepath = Yii::$app->params['imagePath'] . 'posts/' . $post->user_id . '/' . $duplicateModel->from_list_id . '/';
                        $newimagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $newPost->list_id . '/';
                        $filename = $image->download_image($originalimagepath . $post->image_filename0, $newimagepath);

                        $filename_parts = pathinfo($filename);
                        $newPost->image_filename0 = $filename_parts['basename'];
                    }

                    if($post->image_filename1 != '')
                    {
                        $image = new \backend\components\Image;
                        $originalimagepath = Yii::$app->params['imagePath'] . 'posts/' . $post->user_id . '/' . $duplicateModel->from_list_id . '/';
                        $newimagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $newPost->list_id . '/';
                        $filename = $image->download_image($originalimagepath . $post->image_filename1, $newimagepath);

                        $filename_parts = pathinfo($filename);
                        $newPost->image_filename1 = $filename_parts['basename'];
                    }

                    if($post->image_filename2 != '')
                    {
                        $image = new \backend\components\Image;
                        $originalimagepath = Yii::$app->params['imagePath'] . 'posts/' . $post->user_id . '/' . $duplicateModel->from_list_id . '/';
                        $newimagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $newPost->list_id . '/';
                        $filename = $image->download_image($originalimagepath . $post->image_filename2, $newimagepath);

                        $filename_parts = pathinfo($filename);
                        $newPost->image_filename2 = $filename_parts['basename'];
                    }

                    if($post->image_filename3 != '')
                    {
                        $image = new \backend\components\Image;
                        $originalimagepath = Yii::$app->params['imagePath'] . 'posts/' . $post->user_id . '/' . $duplicateModel->from_list_id . '/';
                        $newimagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $newPost->list_id . '/';
                        $filename = $image->download_image($originalimagepath . $post->image_filename3, $newimagepath);

                        $filename_parts = pathinfo($filename);
                        $newPost->image_filename3 = $filename_parts['basename'];
                    }

                    $newPost->post_type_id = $post->post_type_id;
                    $newPost->scheduled_time = $post->scheduled_time;
                    $newPost->origin_type = $post->origin_type;
                    $newPost->origin_id = $post->origin_id;
                    $newPost->save();
                }
                Yii::$app->session->setFlash('success', 'This list has been duplicated! Go to your <a href="' . Yii::$app->urlManager->createUrl(['list/view', 'id' => $list->id]) . '">new list here</a>.');
            }
            else
            {
                $errors = $list->getFirstErrors();
                Yii::$app->session->setFlash('danger', $errors['user_id']);
            }
        }
        else
        {
            Yii::$app->session->setFlash('success', 'We tried, but there were errors. Sorry.');
        }
        $this->redirect(['list/view', 'id' => $duplicateModel->from_list_id]);
    }
	public function actionClear()
    {
        $posts = cListPost::find()->where(['list_id' => Yii::$app->request->get('id'), 'user_id' => Yii::$app->user->id])->all();

        foreach($posts as $post)
        {
            $post->delete();
            //create a record in the cListPostDeleted model
            $del = new cListPostDeleted;
            $del->user_id = $post->user_id;
            $del->origin_type = $post->origin_type;
            $del->origin_id = $post->origin_id;
            $del->save(false);
        }

        Yii::$app->session->setFlash('success', 'This list has been emptied!');
        $this->redirect(['list/view', 'id' => Yii::$app->request->get('id')]);
    }
	
	/**
     * Displays a single cList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $id = $_GET['id'];
        //search for posts in this list
        $postTypeModel = new ListPostTypeForm;
        $deletePostsModel = new ListPostDeleteForm;
		$clearTextModel = new ListPostClearTextForm;
        $duplicatePostsModel = new ListPostDuplicateForm;
        $searchModel = new cListPostSearch;
        $sentModel = new ListSentForm;
        $sentModel->list_id = $id;
        $schedulerModel = new ListSchedulerForm;
        $duplicateModel = new ListDuplicateForm;
        $duplicateModel->from_list_id = $id;
        $clearModel = new ListClearForm;
        $clearModel->list_id = $id;
        $_GET['cListPostSearch']['list_id'] = $id;
        $postDataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        $list = cList::find()->andWhere(['tbl_list.id' => $id])->one();
		if(empty($list)){
			//Yii::$app->session->setFlash('success', 'Scheduler ran successfully.');
            return $this->redirect(['site/index']);
		}
        Yii::$app->session->set('returnUrl', Yii::$app->request->getUrl());

        if ($schedulerModel->load(Yii::$app->request->post()) && $schedulerModel->validate()) {
            $scheduler = new SchedulerEnhanced($schedulerModel->schedule_id, $schedulerModel->list_id, ['startDate' => $schedulerModel->start_date, 'unscheduledPostsOnly' => $schedulerModel->unscheduled_posts_only, 'randomizeTime' => $schedulerModel->randomize_time, 'randomizePosts' => $schedulerModel->randomize_posts]);
            $scheduler->run();
            Yii::$app->session->setFlash('success', 'Scheduler ran successfully.');
            //return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('view', [
            'list_id' => $id,
            'list' => $list,
            'renameModel' => $this->findModel($id),
            'moveModel' => $this->findModel($id),
            'schedulerModel' => $schedulerModel,
            'postDataProvider' => $postDataProvider,
            'searchModel' => $searchModel,
            'duplicateModel' => $duplicateModel,
            'clearModel' => $clearModel,
            'sentModel' => $sentModel,
            'postTypeModel' => $postTypeModel,
            'deletePostsModel' => $deletePostsModel,
			'clearTextModel' => $clearTextModel,
            'duplicatePostsModel' => $duplicatePostsModel,
        ]);
    }

    /**
     * Creates a new cList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new cList;
        //$model->scenario = 'create';
        $model->user_id = Yii::$app->user->id;
        $model->campaign_id = (int)Yii::$app->session->get('campaign_id');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'List has been created.');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing cList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRename($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->session->setFlash('success', 'List has been renamed.');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionMove($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->session->setFlash('success', 'List has been moved.');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing cList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id){
		$this->_deleteList($id);
		Yii::$app->session->setFlash('success', 'List has been deleted.');
        return $this->redirect(Yii::$app->request->referrer);
    }

	function _deleteList($id){
		$model = $this->findModel($id);
        $model->delete();

        $posts = cListPost::find()->where(['list_id' => $id, 'user_id' => Yii::$app->user->id])->all();

        foreach($posts as $post){
            $post->delete();
            //create a record in the cListPostDeleted model
            $del = new cListPostDeleted;
            $del->user_id = $post->user_id;
            $del->origin_type = $post->origin_type;
            $del->origin_id = $post->origin_id;
            $del->save(false);
        }
		
		return;
	}
	
	public function actionDeleteLists(){
		$ids=$_POST['ids'];
		//echo '<pre>'; print_r($ids); exit;
		
		$response=[];
		$response['success']=0;
		
		if(empty($ids)||!is_array($ids)){exit(json_encode($response));}
		
		foreach($ids as $id){$this->_deleteList($id);}
		
		$response['success']=1;
		exit(json_encode($response));
	}
    /**
     * Finds the cList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return cList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = cList::find()->where(["tbl_list.id" => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
