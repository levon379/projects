<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\cConnectionAmazon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="c-connection-amazon-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'country')->dropDownList([
        'ca' => 'Canada',
        'cn'=> 'China',
        'de' => 'Germany',
        'fr' => 'France',
        'it'=>'Italy',
        'in'=> 'India',
        'co.jp'=> 'Japan',
        'es'=>'Spain',
        'com' => 'USA',
        'co.uk' => 'United Kingdom',
    ]); ?>

    <?= $form->field($model, 'aws_associate_tag')->textInput(['maxlength' => 255]) ?>

    <?php if(Yii::$app->session->get('campaign_id') != 0) { ?>
        <?= $form->field($model, 'campaigns')->checkbox(['label' => 'Make available to all Campaigns']); ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
