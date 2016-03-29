<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\cConnectionAmazon */

$this->title = 'Amazon Connection';
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = ['label' => 'Amazon Connections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="c-connection-amazon-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
    </div>