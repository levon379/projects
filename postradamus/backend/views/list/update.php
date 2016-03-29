<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 */

$this->title = 'Update List: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel">
    <div class="panel-heading">
        <span class="panel-title"><?=$this->title?></span>
    </div>

    <div class="panel-body">
        <div class="c-list-update">

            <?= $this->render('_create_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>