<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\cListPostSearch $searchModel
 */

$this->title = 'List Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="c-list-post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php /* ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php */ ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
        },
    ]) ?>

    <p>
        <?= Html::a('New Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
