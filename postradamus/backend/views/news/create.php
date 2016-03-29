<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\cNews */

$this->title = 'Create News';
$this->params['breadcrumbs'][] = ['label' => 'C News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="c-news-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

    </div>

</div>
