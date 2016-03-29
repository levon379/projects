<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cTransactionNewest */

$this->title = 'Update C Transaction Newest: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'C Transaction Newests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="c-transaction-newest-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
