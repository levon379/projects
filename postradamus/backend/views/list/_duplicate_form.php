<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="c-list-form">

    <?php $form = ActiveForm::begin(['action' => Yii::$app->urlManager->createUrl(['list/duplicate'])]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= Html::activeHiddenInput($model, 'from_list_id', ['value' => $model->from_list_id]); ?>

    <?= $form->field($model, 'to_list_name')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton('Duplicate List', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
