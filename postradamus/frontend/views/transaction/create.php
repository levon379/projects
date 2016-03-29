<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\cTransactionNewest */

$this->title = 'Create C Transaction Newest';
$this->params['breadcrumbs'][] = ['label' => 'C Transaction Newests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="c-transaction-newest-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
