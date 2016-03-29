<?php

namespace frontend\controllers;

use frontend\models\Todolists;
use Yii;
use frontend\models\Swots;
use frontend\models\Todos;
use frontend\models\Categories;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class DetailsController extends \yii\web\Controller {

    protected $category_id = 0;

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id) {
        $model = $this->findModel($id);
        $listModel = new Todolists();
        $this->category_id = $model->category_id;
        $category = Categories::find()->where(['id' => $model->category_id])->one();
        $lists = Todolists::find()->where(['swot_id' => $id])->with('todos')->all();

        return $this->render('index', [
                    'model' => $model,
                    'category' => $category,
                    'lists' => $lists,
                    'listmodel' => $listModel,
        ]);
    }

    public function actionEvents($id) {
        $model = $this->findModel($id);
        $category = Categories::find()->where(['id' => $model->category_id])->one();
        return $this->render('events', ['model' => $model, 'category' => $category,]);
    }
    
    public function actionSaveEvents()
    {
        if (Yii::$app->request->isAjax) {
            print_r(Yii::$app->request->post());die;
             
        }
    }


    public function actionOrdertasks() {
        
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $priority = 1;
            foreach ($data['row_task_item'] as $rowId) {
                $swot = Todos::findOne($rowId);
                $swot->priority = $priority;
                $swot->update();
                $priority++;
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['status' => 'ordered', 'code' => 200,];
        }
        
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Swots::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Todolists model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateList() {

        $model = new Todolists();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->swot_id]);
        }
    }

}
