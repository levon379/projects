<?php

namespace backend\controllers;

use Yii;
use common\models\cConnectionWordpress;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConnectionFacebookController implements the CRUD actions for cConnectionFacebook model.
 */
class ConnectionWordpressController extends cController
{
    public function behaviors()
    {
        $behaviors = [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
        return array_merge($behaviors, parent::behaviors());
    }

    /**
     * Updates an existing cConnectionFacebook model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->find();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Wordpress connection settings updated successfully.');
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the cAmazonConnection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return cConnectionFacebook the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function find()
    {
        if (($model = cConnectionWordpress::findConnection()->andWhere(['user_id' => Yii::$app->user->id])->one()) !== null) {
        } else {
            $model = new cConnectionWordpress;
            $model->user_id = Yii::$app->user->id;
            $model->save(false);
        }
        return $model;
    }

}
