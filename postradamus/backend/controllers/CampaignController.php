<?php

namespace backend\controllers;

use Yii;
use common\models\cCampaign;
use common\models\cCampaignSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CampaignController implements the CRUD actions for cCampaign model.
 */
class CampaignController extends cController
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

    /**
     * Lists all cCampaign models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new cCampaignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSwitch($id)
    {
        $exists = cCampaign::find()->where(['id' => $id])->exists();
        if($exists || $id == 0)
        {
            Yii::$app->session->set('campaign_id', $id);
            Yii::$app->session->setFlash('success', 'Switched campaigns.');
            $this->redirect(['site/index']);
        }
    }

    /**
     * Displays a single cCampaign model.
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
     * Creates a new cCampaign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new cCampaign();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $imagepath = Yii::$app->params['imagePath'] . 'campaigns/' . Yii::$app->user->id . '/';
            $file = \yii\helpers\ArrayHelper::toArray(\yii\web\UploadedFile::getInstance($model, 'image'));
            if(isset($file['error'])) { //uploading a new file (or existing)
                //echo "New or existing file upload<br />";
                if($file['error'] == 0) //new file, upload it
                {
                    $image = new \backend\components\Image;
                    $new_file_name = $image->move_uploaded_file($file, $imagepath);
                    if($new_file_name && file_exists($imagepath . $new_file_name))
                    {
                        //delete existing image from server
                        if($model->image_url != '')
                        {
                            @unlink($imagepath . $model->image_url);
                        }
                        //update image_filename field in database
                        $model->image_url = $new_file_name;
                        $model->save(false);
                    }
                }
                else
                {
                    echo("Existing file");
                    //user did not change the image, do nothing
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing cCampaign model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $imagepath = Yii::$app->params['imagePath'] . 'campaigns/' . Yii::$app->user->id . '/';
            $file = \yii\helpers\ArrayHelper::toArray(\yii\web\UploadedFile::getInstance($model, 'image'));
            if(isset($file['error'])) { //uploading a new file (or existing)
                //echo "New or existing file upload<br />";
                if($file['error'] == 0) //new file, upload it
                {
                    $image = new \backend\components\Image;
                    $new_file_name = $image->move_uploaded_file($file, $imagepath);
                    if($new_file_name && file_exists($imagepath . $new_file_name))
                    {
                        //delete existing image from server
                        if($model->image_url != '')
                        {
                            @unlink($imagepath . $model->image_url);
                        }
                        //update image_filename field in database
                        $model->image_url = $new_file_name;
                        $model->save(false);
                    }
                }
                else
                {
                    echo("Existing file");
                    //user did not change the image, do nothing
                }
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing cCampaign model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $lists = \common\models\cList::find()->where(['campaign_id' => $id])->all();
        foreach($lists as $list)
        {
            $list->campaign_id = 0;
            $list->save(false);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the cCampaign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return cCampaign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = cCampaign::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
