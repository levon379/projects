<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\cPostType $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<?php
$this->registerJs("
    init.push(function () {
        $('#cposttype-color').minicolors({
            control: 'wheel',
            position: 'top left',
            theme: 'bootstrap'
        });
    });
");
?>

<div class="c-post-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textArea(['placeholder' => '(Optional)']) ?>

    <?php if(Yii::$app->session->get('campaign_id') != 0) { ?>
        <?= $form->field($model, 'campaigns')->checkbox(['label' => 'Make available to all Campaigns']); ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
