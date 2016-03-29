<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\cCampaign */

$this->title = 'Campaign';
$this->params['breadcrumbs'][] = 'Settings' ;
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="c-campaign-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
</div>
</div>