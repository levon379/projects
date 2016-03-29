<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\cListPost;

/* @var $this yii\web\View */
/* @var $searchModel common\models\cPostTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Templates';
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = $this->title;

$this->params['help']['message'] = 'Post templates allow you to construct the layout of the text in posts you get back from various sources so you don\'t have to do as much editing to posts before sending them to Facebook.';
$this->params['help']['modal_body'] = '<iframe id="youtube-video" width="853" height="480" src="//www.youtube.com/embed/YpIM16v6AlA" frameborder="0" allowfullscreen></iframe>';

?>

        <div class="c-post-template-index">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'origin_type',
                'value' => function ($data) {
                    return cListPost::getOriginNameFromId($data->origin_type);
                }
            ],

            [
                'attribute' => 'name',
                'value' => function ($data) {
                        return ($data->campaign_id == 0 ? '(Master) ' : '') . $data->name;
                    }
            ],
            'template:ntext',
			['class' => 'yii\grid\ActionColumn', 'template'=>'{update} {delete}'],
        ],
    ]); ?>

        </div>

    </div>
    <div class="panel-footer text-left">
        <div class="form-group">
            <?= Html::a('New Post Template', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>