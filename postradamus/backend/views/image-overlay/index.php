<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\cImageOverlaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Image Overlays';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="c-image-overlay-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'image_url:url',
            'position',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
<div class="panel-footer text-left">
    <div class="form-group">
        <?= Html::a('New Image Overlay', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
</div>
</div>
