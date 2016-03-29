<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\cCampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaigns';
$this->params['breadcrumbs'][] = 'Settings' ;
$this->params['breadcrumbs'][] = $this->title;

$this->params['help']['message'] = 'You can create up to <b>'. Yii::$app->postradamus->getPlanDetails(Yii::$app->user->identity->getField('plan_id'))['campaigns'] .'</b> campaigns. Campaigns are great if you manage more than one Facebook page, Pinterest account or Wordpress blog. For example, you might have 2 totally unrelated Facebook pages like a Guns page and a Dogs page. You could create a campaign for each one and then depending on which page you want to work on, switch to that campaign and only the lists, schedules and templates you have previously created for that page will show up in Postradamus.';
$this->params['help']['modal_body'] = '<iframe width="853" height="480" src="//www.youtube.com/embed/OAYVjlMyxNI" id="youtube-video" frameborder="0" allowfullscreen></iframe>';

?>
<div class="c-campaign-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                /*
				'buttons' => [
                    'switch' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => 'Open']);
                    }
                ],*/
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

</div>

</div>
<div class="panel-footer text-left">
    <div class="form-group">
        <?= Html::a('New Campaign', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
</div>
</div>