<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cCampaign */

$this->title = 'Update Campaign';
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="c-campaign-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

</div>

</div>
