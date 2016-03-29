<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\cImageOverlay */

$this->title = 'Create Image Overlay';
$this->params['breadcrumbs'][] = ['label' => 'Image Overlays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="c-image-overlay-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


</div>
</div>
</div>