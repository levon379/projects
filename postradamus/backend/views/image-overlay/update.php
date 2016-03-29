<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cImageOverlay */

$this->title = 'Update Image Overlay';
$this->params['breadcrumbs'][] = ['label' => 'Image Overlays', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="c-image-overlay-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


</div>
</div>
</div>