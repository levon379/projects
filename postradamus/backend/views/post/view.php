<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\cListPost $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel">
    <div class="panel-heading">
        <span class="panel-title"><?= $this->title ?></span>
    </div>
    <div class="panel-body">
        <div class="c-list-post-view">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'text:ntext',
                    'image_filename0:ntext',
                    [
                        'label' => 'Post Type',
                        'attribute' => 'name',
                        'value' => (!empty($model->poster) ? $model->poster->name : '')
                    ],
                    'scheduled_time:datetime',
                    'updated_at:datetime',
                    'created_at:datetime',
                ],
            ]) ?>

            <?php
            if (is_array($model->postMeta)) {
                foreach ($model->postMeta as $meta) {
                    echo $meta->key . ': ' . $meta->value;
                }
            }
            ?>

        </div>
    </div>
</div>