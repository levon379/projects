<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\cUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="c-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php // $form->field($model, 'email') ?>
	<div class="form-group field-cuser-email">
		<label class="control-label" for="cuser-email"><?=$model->getAttributeLabel('email')?></label>
		<div>
			<span class="label label-primary"><?=$model->email?></span>
		</div>	
	</div>
	
    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
