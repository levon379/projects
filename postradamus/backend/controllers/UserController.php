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
class UserController extends cController
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
     * Lists all cUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new cUserSearch();
        $searchModel->parent_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single cUser model.
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
     * Creates a new cUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserForm();
        $model->parent_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->password = Common::generatePassword(); //paypal generated
            $newuser = $model->signup();

            if($newuser)
            {
                //email customer his account details
                $subject = 'An account has been setup for you.';
                $to = $model->email;
                $body = $this->renderPartial('_new_user_email', ['model' => $model]);
                mail($to, $subject, $body, "FROM: Postradamus <info@1s0s.com>");

                Yii::$app->session->setFlash('success', 'User created and emailed successfully.');
                return $this->redirect(['index']);
            }
            else
            {
                Yii::$app->session->setFlash('danger', 'Could not create the user.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing cUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing cUser model.
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
     * Finds the cUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return cUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = cUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}