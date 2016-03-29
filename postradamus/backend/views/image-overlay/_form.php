<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\cImageOverlay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="c-image-overlay-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php
    $image_filename = ($model->image_url != '' ? Yii::$app->params['imageUrl'] . 'overlays/' . $model->user_id . '/' . $model->image_url : 'http://placehold.it/250x250&text=No+Image');

    $preview = "<a href=\"$image_filename\" target=\"_blank\"><img src=\"" . $image_filename . "\" class='file-preview-image'></a>";

    use kartik\widgets\FileInput;
    echo $form->field($model, 'image')->widget(FileInput::classname(), [
        'options' => [
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

<?php /* ?>
    <?= $form->field($model, 'position')->radioList([
        $model::POSITION_TOP_LEFT => 'Top Left',
        $model::POSITION_TOP_RIGHT => 'Top Right',
        $model::POSITION_TOP_MIDDLE => 'Top Middle',
        $model::POSITION_BOTTOM_LEFT => 'Bottom Left',
        $model::POSITION_BOTTOM_MIDDLE => 'Bottom Middle',
        $model::POSITION_BOTTOM_RIGHT => 'Bottom Right',
        $model::POSITION_MIDDLE_LEFT => 'Middle Left',
        $model::POSITION_MIDDLE_RIGHT => 'Middle Right',
    ]) ?>

    <div style="width:440px">
        <div class="row">
            <div class="col-md-4" style="text-align:left">
                <input type="radio">
            </div>
            <div class="col-md-4" style="text-align:center">
                <input type="radio">
            </div>
            <div class="col-md-4" style="text-align:right">
                <input type="radio">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="text-align:center">
                <img src="http://www.thebakerymadewithlove.com/wp-content/uploads/2014/08/placeholder.png">
            </div>
        </div>
    </div>
<?php */ ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
