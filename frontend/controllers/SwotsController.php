<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Swots;
use frontend\models\Categories;
use yii\helpers\Inflector;
use yii\filters\AccessControl;
use kartik\widgets\ActiveForm;

class SwotsController extends \yii\web\Controller {

    protected $contents = [];

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

    public function actionIndex($id, $type = null) {
        $type = $this->loadSwotContents($id, $type);
        $this->setSwotTags($id);
        $this->contents['type'] = $type == null ? null : Inflector::pluralize($type);
        $this->contents['category'] = Categories::find()->where(['id' => $id])->one();

        return $this->render('index', $this->contents);
    }

    public function renderSwotListFor($categoryId, $swotType,$trashed = 0) {
        $swotHeading = Inflector::pluralize($swotType);
        $swots = Swots::find()->where(['type' => $swotType, 'category_id' => $categoryId,'trashed'=>$trashed])->orderBy('priority')->with('todolists')->all();
        return $this->renderPartial('list', ['swot_items' => $swots, 'type' => $swotType, 'heading' => $swotHeading, 'category' => $categoryId], false, true);
    }

    public function actionSwot($id, $categoryId, $type) {

        if ($id > 0) {
            $model = $this->findModel($id);
        } else {
            $model = new Swots();
        }

        $model->user_id = \Yii::$app->user->identity->id;
        $model->category_id = $categoryId;
        $model->type = $type;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect('/swots/'.$model->category_id);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => $model->save()];
        }
    }

    public function actionValidate() {
        $model = new Swots();
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }
    
    /*Ajax Update Swots
     * Sending parametrs via ajax       
     * And returned partials view from json format     
     */
    public function actionStoreSwots() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if ((int) $data['id'] > 0) {
                $model = $this->findModel((int) $data['id']);
            } else {
                $model = new Swots();
            }

            $model->user_id = \Yii::$app->user->identity->id;
            $model->category_id = (int) $data['categoryId'];
            $model->type = $data['type'];
            $model->name = $data['name'];
            $model->description = $data['description'];
            if ($model->save()) {
                $item = ['id' => (int) $data['id'], 'name' => $data['name'], 'description' => $data['description']];
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => $model->save(), 'view' => $this->renderPartial('/swots/swots-partials/strengths', ['item' => $item])];
            }
        }
    }

     /*Action for move swots types
     * Sending swots details id and type that should be moved      
     * And returned same view for two cases  (I don't know should I show any message or no)     
     */
    public function actionMove($id) {

        if ($id > 0) {
            $model = $this->findModel($id);
        } else {
            $model = new Swots();
        }
        $model->user_id = \Yii::$app->user->identity->id;
        $model->type = Yii::$app->request->post('swot_types');
        if ($model->save()) {
            Yii::$app->session->setFlash('success', "You successfully moved item!");
            return $this->redirect(['swots/' . $model->category_id]);
        } else {
            Yii::$app->session->setFlash('danger', "Sorry you haven't moved any items!");
            return $this->redirect(['swots/' . $model->category_id]);
        }
    }

    public function actionOrder() {

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            \yii\helpers\VarDumper::dump($data);
            $priority = 1;
            foreach ($data['edit_swot_item'] as $rowId) {
                $swot = Swots::findOne($rowId);
                $swot->priority = $priority;
                $swot->update();
                $priority++;
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['status' => 'ordered', 'code' => 200,];
        }
    }

    public function getAllTags($id) {

        $tags = null;
        $userId = \Yii::$app->user->identity->id;
        $params = $id > 0 ? ['category_id' => $id] : ['user_id' => $userId];
        $swots = Swots::find()->where($params)->all();

        foreach ($swots as $swot) {
            $tags = $tags . $swot->taggedwith . ',';
        }

        $itemTags = explode(',', $tags);
        $withCounts = array_count_values($itemTags);

        return [ $this->array_unique_compact($itemTags), $withCounts];
    }

    function array_unique_compact($a) {
        $tmparr = array_unique($a);
        $i = 0;
        foreach ($tmparr as $v) {
            $newarr[$i] = $v;
            $i++;
        }
        return $newarr;
    }

    public function actionItem($id) {
        if (Yii::$app->request->isAjax) {
            $model = $this->findModel($id);
            return $this->renderPartial('_listitem', ['item' => $model, 'category' => $model->category_id, 'type' => $model->type]);
        }
        return null;
    }

    public function actionAddbutton($category, $type) {
        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('_addbutton', ['category' => $category, 'type' => $type]);
        }
        return null;
    }

    /**
     * Deletes an existing Swot model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $category = $model->category_id;
        $model->trashed = 1;
        $model->save();
        return $this->redirect(['swots/' . $category]);
    }
    
    /**
     * Show Trashed itemw 
     * The view same as Swots index but there showing only trashed items
     * @param integer $id (category id)
     * Need to add column on swots tabel name is trashed integer(1)
     */
    public function actionTrashedItems($id) {
        $type = $this->loadSwotContents($id, null,1);
        $this->setSwotTags($id);
        $this->contents['type'] = $type == null ? null : Inflector::pluralize($type);
        $this->contents['category'] = Categories::find()->where(['id' => $id])->one();

        return $this->render('trashed-items', $this->contents);
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
     * @param $id
     * @param $type
     * @return string
     */
    public function loadSwotContents($id, $type,$trashed = 0) {
        if ($type == null) {
            $this->contents['strengths'] = $this->renderSwotListFor($id, 'Strength',$trashed);
            $this->contents['weaknesses'] = $this->renderSwotListFor($id, 'Weakness',$trashed);
            $this->contents['opportunities'] = $this->renderSwotListFor($id, 'Opportunity',$trashed);
            $this->contents['threats'] = $this->renderSwotListFor($id, 'Threat',$trashed);
            return $type;
        } else {
            $type = Inflector::singularize($type);
            $this->contents[Inflector::pluralize(strtolower($type))] = $this->renderSwotListFor($id, $type,$trashed);
            return $type;
        }
    }

    /**
     * @param $id
     */
    public function setSwotTags($id) {
        list($tags, $tagsWithCount) = $this->getAllTags($id);
        $this->contents['tags'] = $tags;
        $this->contents['tagsWithCount'] = $tagsWithCount;
    }

}
