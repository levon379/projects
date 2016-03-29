<?php
use kartik\helpers\Html;
use kartik\helpers\Enum;
use kartik\icons\Icon;
use kartik\popover\PopoverX;
use rmrevin\yii\fontawesome\FA;
use kartik\form\ActiveForm;
use kartik\form\ActiveField;
use wbraganca\tagsinput\TagsinputWidget;

?>
<?php
$form = ActiveForm::begin(['action' => '','method'=>'post','fieldConfig'=>['showLabels'=>false]]);
PopoverX::begin([
    'size' => PopoverX::SIZE_LARGE,
    'placement' => PopoverX::ALIGN_TOP,
    'type' => PopoverX::TYPE_SUCCESS,
    'footer' => Html::button('View', ['class'=>'btn btn-primary']),
    'toggleButton' => ['label'=> FA::icon('plus').' Add','type' => 'button','class'=>'btn btn-xs btn-primary'],
    'header' => '<i class="fa fa-task"></i> Add',
    'footer'=>Html::submitButton('Save', ['class'=>'btn btn-xs btn-primary']) .
        Html::button('Close', ['class'=>'btn btn-xs btn-default','data-dismiss' => 'popover-x'])
]);

echo $form->field($model, 'name')->hint('<small>Give this '.$type.' a name, something descriptive - Really try to name is as specific as you can.</small>');
echo $form->field($model, 'description')->textArea(['rows' => '2']);
echo '<p class="help-block"><small>Add some details:(Weakness): My study skills could be improved. - OR - (Strength): Communication at work is going well.</small></p>';
echo '<div class="form-group field-swots-taggedwith required">';
echo '<label class="control-label" for="description">Tags</label>';
echo $form->field($model, 'taggedwith')
    ->textInput(['id' => 'taggedwith', 'placeholder' => 'Enter tags seperate by comma...',])
    ->widget(TagsinputWidget::classname(), ['clientOptions' => ['trimValue' => true, 'allowDuplicates' => false, 'typeahead' => ['source' => $allTags],]])
    ->hint('<small>Enter tags seperate by comma... e.g. Work, Play, Learn etc</small>');
echo '</div>';

PopoverX::end();
ActiveForm::end();
?>
