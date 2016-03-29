<?php

namespace backend\controllers;

use Yii;
use common\models\cUser;
use common\models\cUserSearch;
use backend\models\UserForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\Common;

/**
 * UserController implements the CRUD actions for cUser model.
 */
class ProfileController extends cController
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
     * Updates an existing cUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->find();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Your account has been updated successfully.');
            return $this->redirect(['update']);
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
        $model = cUser::find()->where(['id' => Yii::$app->user->id])->one();
        return $model;
    }
}
