<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\cScheduleTimeSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="c-schedule-time-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'schedule_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'weekday') ?>

    <?= $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'vary_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
