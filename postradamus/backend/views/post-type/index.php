<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\cPostTypeSearch $searchModel
 */

$this->title = 'Post Types';
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = $this->title;

$this->params['help']['message'] = "Post types are a way to categorize your posts. For example, you might create a post type called 'Money', then any affiliate link posts that you create (for example an amazon book link) you would assign with the 'Money' post type. You then can setup your scheduler to assign the 'Money' post type at certain times of the day or certain weekdays only.";
$this->params['help']['modal_body'] = '<iframe id="youtube-video" width="853" height="480" src="//www.youtube.com/embed/WtnSIt29Low" frameborder="0" allowfullscreen></iframe>';

?>

        <div class="c-post-type-index">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'name',
                        'value' => function ($data) {
                            return "<div style=\"width:25px; height: 25px; background-color: ".$data->color."\" class=\"pull-left\"></div><div class=\"pull-left\" style=\"margin-left: 10px; margin-top:3px\">" . ($data->campaign_id == 0 ? '(Master) ' : '') . $data->name . "</div>";
                        },
                        'format' => 'html',
                    ],
                    'description',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>

    </div>
    <div class="panel-footer text-left">
        <div class="form-group">
            <?= Html::a('New Post Type', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>