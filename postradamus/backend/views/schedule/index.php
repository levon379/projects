<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\cScheduleSearch $searchModel
 */

$this->title = 'Schedules';
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = $this->title;

$this->params['help']['message'] = "When you create a schedule you are essentially building a template that can be used over and over to give all the posts in your lists times and days to publish to your Facebook page. This saves you time so you don't have to pick individual dates and times for each post. It also can give you a good starting point when using the Calendar feature of Lists.";
$this->params['help']['modal_body'] = '<iframe id="youtube-video" width="853" height="480" src="//www.youtube.com/embed/osImzUepWwU" frameborder="0" allowfullscreen></iframe>';

?>
        <div class="c-schedule-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <div class="form-group">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'value' => function ($data) {
                   return ($data->campaign_id == 0 ? '(Master) ' : '') . $data->name;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'duplicate' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, ['title' => 'Duplicate']);
                    }
                ],
                'template' => '{duplicate} {update} {delete}',
            ],
        ],
    ]); ?>
</div>


</div>

            </div>


<div class="panel-footer text-left">
    <div class="form-group">
        <?= Html::a('New Schedule', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
</div>
</div>