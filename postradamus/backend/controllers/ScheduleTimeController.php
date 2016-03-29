<?php

namespace backend\controllers;

use Yii;
use common\models\cScheduleTime;
use common\models\cScheduleTimeSearch;
use common\models\cScheduleTimePostType;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ScheduleTimeController implements the CRUD actions for cScheduleTime model.
 */
class ScheduleTimeController extends cController
{

    /**
     * Lists all cScheduleTime models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new cScheduleTimeSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single cScheduleTime model.
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
     * Creates a new cScheduleTime model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $save = false;
        if(Yii::$app->request->post() && is_array(Yii::$app->request->post('cScheduleTime')['weekdays']))
        {
            foreach(Yii::$app->request->post('cScheduleTime')['weekdays'] as $weekday)
            {
                $model = new cScheduleTime;
                $model->user_id = Yii::$app->user->id;
                $model->schedule_id = $_GET['id'];
                $model->weekday = $weekday;
                $model->load(Yii::$app->request->post());

                if ($model->save()) {
                    //create post types
                    if(!empty($model->post_types))
                        foreach($model->post_types as $value)
                        {
                            $model2 = new cScheduleTimePostType;
                            $model2->schedule_id = $model->schedule_id;
                            $model2->user_id = Yii::$app->user->id;
                            $model2->post_type_id = $value;
                            $model2->schedule_time_id = $model->id;
                            $model2->save(false);
                        }

                    $save = true;
                }
                else
                {
                    $save = false;
                }
            }
            if($save != false)
            {
                Yii::$app->session->setFlash('success', 'Scheduler time created successfully.');
                return $this->redirect(['schedule/update', 'id' => $model->schedule_id, 'weekday' => Yii::$app->request->get('weekday')]);
            }
        }
        Yii::$app->session->setFlash('danger', 'There was a problem creating the time.');
    }

    /**
     * Updates an existing cScheduleTime model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //delete existing post types
            cScheduleTimePostType::deleteAll(['schedule_time_id' => $model->id]);
            //create post types
            if(!empty($model->post_types))
            foreach($model->post_types as $value)
            {
                $model2 = new cScheduleTimePostType;
                $model2->schedule_id = $model->schedule_id;
                $model2->user_id = Yii::$app->user->id;
                $model2->post_type_id = $value;
                $model2->schedule_time_id = $model->id;
                $model2->save(false);
            }
            Yii::$app->session->setFlash('success', 'Scheduler time updated successfully.');
            return $this->redirect(['schedule/update', 'id' => $model->schedule_id, 'weekday' => Yii::$app->request->get('weekday')]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing cScheduleTime model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('success', 'Scheduler time deleted successfully.');
        return $this->redirect(['schedule/update', 'id' => $model->schedule_id, 'weekday' => Yii::$app->request->get('weekday')]);
    }

    /**
     * Finds the cScheduleTime model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return cScheduleTime the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = cScheduleTime::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
