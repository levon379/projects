<?php

namespace backend\controllers;

use Yii;
use common\models\cPostTemplate;
use common\models\cPostTemplateSearch;
use common\models\cPostTemplateImage;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostTemplateController implements the CRUD actions for cPostTemplate model.
 */
class PostTemplateController extends cController
{
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionAjaxList($source)
    {
        $post_templates = cPostTemplate::find()->andWhere(['origin_type' => \common\models\cListPost::getOriginIdFromName($source)])->all();
        $post_template_array = [];
        foreach($post_templates as $post_template) {
            $post_template_array[$post_template->id] = $post_template->name;
        }
        $post_template_json = json_encode($post_template_array);
        return $post_template_json;
    }

    public function actionSaveImageTemplate()
    {
        //image data URI from Fabric
        $img = Yii::$app->request->post('image_data');
        $img_json = Yii::$app->request->post('image_json_data');
        //get post
        $template = cPostTemplate::find()->andWhere(['id' => Yii::$app->request->post('id')])->one();
        $template->image_template = $img_json;
        $template->save(false);
        Yii::$app->session->setFlash('success', "You're image template has been saved successfully.");
        return json_encode([]);
    }

    /**
     * Lists all cPostTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new cPostTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single cPostTemplate model.
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
     * Creates a new cPostTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new cPostTemplate();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Post template created successfully.');
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            foreach($model->errors as $error)
                Yii::$app->session->setFlash('danger', $error[0]);

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing cPostTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Post template updated successfully.');
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
			$default_images=cPostTemplateImage::find()->where(['post_template_id'=>$id])->all();
            return $this->render('update', [
                'model'=>$model,
				'default_images'=>$default_images,
            ]);
        }
    }

    /**
     * Deletes an existing cPostTemplate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the cPostTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return cPostTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = cPostTemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	function actionDefaultImagesUpload(){
		$image = new \backend\components\Image;
		$response=[];
		$response=['success'=>0];
		$post_template_id=$_POST['post_template_id'];
		
		$imagepath=Yii::$app->params['imagePath'].'post-templates/'.Yii::$app->user->id.'/'. $post_template_id.'/';
	    if($new_file_name = $image->move_uploaded_file($_FILES["file"], $imagepath)){
			$postTemplageImage=new cPostTemplateImage();
			$postTemplageImage->post_template_id=$post_template_id;
			$postTemplageImage->file_name=$new_file_name;
			if($postTemplageImage->save()){
				$response['success']=1;
			}
		}
		exit(json_encode($response));
	}
	
	public function actionDeleteDefaultImage(){
		$response=[];
		$response['success']=0;
		$id=$_POST['id'];
		if(!empty($id)){
			$default_image=cPostTemplateImage::findOne($id);
			if($default_image!==null){
				if($default_image->delete()!==false){
					$response['success']=1;
				}
			}
		}
		exit(json_encode($response));
	}
}
