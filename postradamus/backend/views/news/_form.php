<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\cNews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="c-news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?php
    use kartik\datecontrol\DateControl;
    $settings['type'] = DateControl::FORMAT_DATETIME;
    if(Yii::$app->user->identity->getSetting('date_format') != '' && Yii::$app->user->identity->getSetting('time_format') != '')
    {
        $settings['displayFormat'] = Yii::$app->user->identity->getSetting('date_format') . ' ' . Yii::$app->user->identity->getSetting('time_format');
    }
    // Use a DateTimePicker input with ActiveForm and model validation enabled.
    $settings['type'] = DateControl::FORMAT_DATETIME;
    echo $form->field($model, 'created')->widget(DateControl::classname(), [
        'type'=>DateControl::FORMAT_DATETIME,
        'ajaxConversion' => true,
        'displayFormat' => 'php:' . Yii::$app->postradamus->get_user_date_time_format(),
        'saveFormat' => 'php:U',
        'displayTimezone' => 'America/Los_Angeles',
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
