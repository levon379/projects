<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\cConnectionAmazonSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="c-connection-amazon-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'country') ?>

    <?= $form->field($model, 'aws_api_access_key') ?>

    <?= $form->field($model, 'aws_api_secret_key') ?>

    <?php // echo $form->field($model, 'aws_associate_tag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
