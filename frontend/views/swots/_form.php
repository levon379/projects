<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use wbraganca\tagsinput\TagsinputWidget;

/* @var $this yii\web\View */
/* @var $model frontend\models\Swots */
/* @var $form ActiveForm */
?>
<div class="swots-form">

    <?php $form = ActiveForm::begin(['options' => [
        'id' => 'create-swot-form'
    ]]); 
    ?>

        <?= $form->field($model, 'name')->hint('<small>Give this '.$type.' a name, something descriptive - Really try to name is as specific as you can.</small>'); ?>
        <?= $form->field($model, 'description')->textArea(['rows' => '2']); ?>
        <p class="help-block"><small>Add some details:(Weakness): My study skills could be improved. - OR - (Strength): Communication at work is going well.</small></p>

        <div class="form-group field-swots-taggedwith required">
            <label class="control-label" for="description">Tags</label>
            <?= $form->field($model, 'taggedwith')->textInput(['id' => 'taggedwith',
                'placeholder' => 'Enter tags seperate by comma...',])->widget(TagsinputWidget::classname(),
                [
                    'clientOptions' => [
                        'trimValue' => true,
                        'allowDuplicates' => false,
                        'typeahead' => [
                            'source' => $allTags
                        ],
                    ]
                ])->hint('<small>Enter tags seperate by comma... e.g. Work, Play, Learn etc</small>'); ?>
        </div>

    <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-sm btn-primary']) ?> or <a href="#" data-dismiss="modal">Cancel</a>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- swots-form -->
