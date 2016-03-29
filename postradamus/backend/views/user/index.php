<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\cUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = 'Settings' ;
$this->params['breadcrumbs'][] = $this->title;

$this->params['help']['message'] = "This feature allows you to give up to <b>" . Yii::$app->postradamus->getPlanDetails(Yii::$app->user->identity->getField('plan_id'))['users'] . "</b> other users (such as employees or virtual assistants) access to your Postradamus account. These users will have limited privileges (they will not be able to view/modify users or view/modify <a href='" . Yii::$app->urlManager->createUrl('connection-facebook/update') . "'>connections</a>) but will be able to see and modify any lists, posts, schedules, templates and post types you have created.";
$this->params['help']['modal_body'] = '<iframe id="youtube-video" width="853" height="480" src="//www.youtube.com/embed/aX7urVrtikg" frameborder="0" allowfullscreen></iframe>';

?>

        <div class="c-user-index">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'first_name',
                    'last_name',
                    // 'password_reset_token',
                    'email:email',
                    // 'paypal_email:email',
                    // 'paypal_subscription_id',
                    // 'plan_id',
                    // 'subscription_end_date',
                    // 'role',
                    // 'status',
                    // 'created_at',
                    // 'updated_at',


                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                    ],
                ],
            ]); ?>

        </div>

    </div>

    <div class="panel-footer">

        <?php if(Yii::$app->postradamus->getPlanDetails(Yii::$app->user->identity->getField('plan_id'))['users'] > $dataProvider->count) { ?>
        <?= Html::a('New User', ['create'], ['class' => 'btn btn-success']) ?>
        <?php } else { ?>
            <?= Html::a('New User', ['create'], ['class' => 'btn btn-success disabled']) ?>  (Maximum Number of Users Created)
        <?php } ?>

    </div>

</div>