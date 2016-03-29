<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\cPostType $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = ['label' => 'Post Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel">
    <div class="panel-heading">
        <span class="panel-title"><?= Html::encode($this->title) ?></span>
    </div>

    <div class="panel-body">

<div class="c-post-type-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute' => 'color',
                'value' => "<div style=\"width:25px; height: 25px; background-color: ".$model->color."\"></div>",
                'format' => 'html',
            ],
            'description'
        ],
    ]) ?>

</div>
</div></div>