<?php

namespace frontend\controllers;
use Yii;
use frontend\models\Categories;
use yii\filters\AccessControl;

class DashboardController extends \yii\web\Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

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

    /**
     * 
     * @return type
     */
    public function actionIndex()
    {
        $user = \Yii::$app->user->identity;
        $userId = \Yii::$app->user->identity->id;
        $categories = Categories::find()->where(['user_id' => $userId])->with('swots')->all();
        //echo "<br><br><br><br><br><br><br>";
        //VarDumper::dump($categories);
        //$categories = Categories::findAll(['user_id' => $userId]);
        return $this->render('index',['categories' => $categories]);
    }

    /**
     * [actionCategory description]
     * @param  int $id [description]
     * @return mixed     [description]
     */
    public function actionCategory($id) {

        if($id>0) {
            $model = $this->findModel($id);
        } else {
            $model = new Categories();
        }

        $model->user_id = \Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $categories = Categories::findAll(['user_id' => \Yii::$app->user->identity->id]);
            return $this->redirect('index',['categories' => $categories]);
        }
            return $this->render('_category', [
                'model' => $model
            ]);

    }

    /**
     * Deletes an existing Categories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $categories = Categories::findAll(['user_id' => \Yii::$app->user->identity->id]);
        return $this->redirect('index',['categories' => $categories]);
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
