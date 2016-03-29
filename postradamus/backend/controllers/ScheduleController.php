<?php

namespace backend\controllers;

use Yii;
use common\models\cSchedule;
use common\models\cScheduleTime;
use common\models\cScheduleTimePostType;
use common\models\cScheduleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ScheduleController implements the CRUD actions for cSchedule model.
 */
class ScheduleController extends cController
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
     * Lists all cSchedule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new cScheduleSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single cSchedule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDuplicate($id)
    {
        $model = $this->findModel($id);
        if($model)
        {
            $s = new cSchedule;
            $s->user_id = Yii::$app->user->id;
            $s->campaign_id = $model->campaign_id;
            $s->name = $model->name . ' (copy)';
            $s->save(false);
        }
        //
        $cst = cScheduleTime::find()->where(['schedule_id' => $id])->all();
        foreach($cst as $t)
        {
            $c = new cScheduleTime;
            $c->schedule_id = $s->id;
            $c->user_id = Yii::$app->user->id;
            $c->campaign_id = $t->campaign_id;
            $c->weekday = $t->weekday;
            $c->time = $t->time;
            $c->save(false);
            $schedule_time_id = $c->id;

            //
            $cstpt = cScheduleTimePostType::find()->where(['schedule_time_id' => $t->id])->all();
            foreach($cstpt as $t)
            {
                $c = new cScheduleTimePostType;
                $c->schedule_id = $s->id;
                $c->user_id = Yii::$app->user->id;
                $c->campaign_id = $t->campaign_id;
                $c->schedule_time_id = $schedule_time_id;
                $c->post_type_id = $t->post_type_id;
                $c->save(false);
            }
        }
        Yii::$app->session->setFlash('success', 'Schedule duplicated successfully.');
        $this->redirect(['index']);
    }

    /**
     * Creates a new cSchedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new cSchedule;
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Schedule created successfully.');
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing cSchedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id){
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Schedule updated successfully.');
			if( $model->campaign_id == (int)Yii::$app->session->get('campaign_id') ){
				return $this->redirect(['update', 'id' => $model->id, 'weekday' => Yii::$app->request->get('weekday')]);	
			}
			else{
				return $this->redirect(['index']);
			}
	    } else {
            return $this->render('update', [
                'model' => $model,
                'weekday' => Yii::$app->request->get('weekday')
            ]);
        }
    }

    /**
     * Deletes an existing cSchedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete())
        {
            cScheduleTime::deleteAll(['schedule_id' => $id]);
            cScheduleTimePostType::deleteAll(['schedule_id' => $id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the cSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return cSchedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = cSchedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');        }
    }
}
