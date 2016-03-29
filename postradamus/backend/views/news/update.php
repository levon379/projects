<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cNews */

$this->title = 'Update News';
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="c-news-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
    </div>