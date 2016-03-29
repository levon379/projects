<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cConnectionAmazon */

$this->title = 'Amazon Connection';
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = ['label' => 'Amazon Connections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="c-connection-amazon-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
    </div>