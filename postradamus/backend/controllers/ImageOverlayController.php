<?php

namespace backend\controllers;

use Yii;
use common\models\cImageOverlay;
use common\models\cImageOverlaySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ImageOverlayController implements the CRUD actions for cImageOverlay model.
 */
class ImageOverlayController extends cController
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
     * Lists all cImageOverlay models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new cImageOverlaySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single cImageOverlay model.
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
     * Creates a new cImageOverlay model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new cImageOverlay();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $imagepath = Yii::$app->params['imagePath'] . 'overlays/' . Yii::$app->user->id . '/';
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
                        $model->image_filename = $new_file_name;
                        $model->save(false);
                    }
                }
                else
                {
                    echo("Existing file");
                    //user did not change the image, do nothing
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing cImageOverlay model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $imagepath = Yii::$app->params['imagePath'] . 'overlays/' . Yii::$app->user->id . '/';
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
                        $model->image_filename = $new_file_name;
                        $model->save(false);
                    }
                }
                else
                {
                    echo("Existing file");
                    //user did not change the image, do nothing
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing cImageOverlay model.
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
     * Finds the cImageOverlay model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return cImageOverlay the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = cImageOverlay::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
