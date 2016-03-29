<?php

namespace backend\controllers;

use Yii;
use common\models\cSetting;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\tooltips\models\TooltipDisplay;
/**
 * SettingController implements the CRUD actions for cSetting model.
 */
class SettingController extends cController
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
     * Updates an existing cSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->find();


        if($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', 'Settings updated successfully.');
            return $this->redirect(['update']);
        } else {

			return $this->render('update', [
                'model' => $model,
				'isTooltipsOn'=>TooltipDisplay::isTooltipsOnForUser(Yii::$app->user->id)
            ]);
        }
    }

    /**
     * Finds the cSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return cSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function find()
    {
        if (($model = cSetting::find()->where(['user_id' => Yii::$app->user->id])->one()) !== null) {
        } else {
            $model = new cSetting;
            $model->user_id = Yii::$app->user->id;
            $model->save(false);
        }
        return $model;
    }
}
