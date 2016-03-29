<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\cListPost;

/* @var $this yii\web\View */
/* @var $model common\models\cPostTemplate */

$this->title = cListPost::getOriginNameFromId($model->origin_type);
$this->params['breadcrumbs'][] = ['label' => 'Post Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel">
    <div class="panel-heading">
        <span class="panel-title"><?= Html::encode($this->title) ?></span>
    </div>

    <div class="panel-body">

        <div class="c-post-template-view">
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
            'template:ntext',
        ],
    ]) ?>

        </div>
    </div></div>