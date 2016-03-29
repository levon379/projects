<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Todolists */

$this->title = 'Create Todolists';
$this->params['breadcrumbs'][] = ['label' => 'Todolists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="todolists-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
