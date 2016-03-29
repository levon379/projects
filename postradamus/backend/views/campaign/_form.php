<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\cCampaign */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="c-campaign-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?php
    $image_filename0 = ($model->image_url != '' ? Yii::$app->params['imageUrl'] . 'campaigns/' . $model->user_id . '/' . $model->image_url : 'http://placehold.it/250x250&text=No+Image');

    $preview = "<a href=\"$image_filename0\" target=\"_blank\"><img src=\"" . $image_filename0 . "\" class='file-preview-image' alt='" . $model->name . "' title='" . $model->name . "'></a>";

    use kartik\widgets\FileInput;
    echo $form->field($model, 'image')->widget(FileInput::classname(), [
        'options' => [
            'multiple' => false,
        ],
        'pluginOptions' => [
            'previewFileType' => 'any',
            'showUpload' => false,
            'showRemove' => true,
            'showCaption' => false,
            'browseClass' => "btn btn-primary",
            'mainTemplate' => '{preview} {browse} {remove}',
            'initialPreview' => $preview,
        ]
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
