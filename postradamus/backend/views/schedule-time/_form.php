<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\cScheduleTime $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="c-schedule-time-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'weekday')->textInput() ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
