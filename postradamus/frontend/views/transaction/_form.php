<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\cTransactionNewest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="c-transaction-newest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => 55]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => 55]) ?>

    <?= $form->field($model, 'fee')->textInput(['maxlength' => 55]) ?>

    <?= $form->field($model, 'net')->textInput(['maxlength' => 55]) ?>

    <?= $form->field($model, 'details')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
