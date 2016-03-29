<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\cScheduleTime $model
 */

$this->title = 'Create C Schedule Time';
$this->params['breadcrumbs'][] = ['label' => 'C Schedule Times', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="c-schedule-time-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
