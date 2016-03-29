<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\cConnectionFacebook $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="c-connection-facebook-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'facebook_app_id')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'facebook_secret')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
