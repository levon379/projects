<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TodosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="todos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'priority') ?>

    <?= $form->field($model, 'todolist_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'todo') ?>

    <?php // echo $form->field($model, 'details') ?>

    <?php // echo $form->field($model, 'due_on') ?>

    <?php // echo $form->field($model, 'complete') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
