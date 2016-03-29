<?php
use kartik\helpers\Html;
use kartik\icons\Icon;
use kartik\popover\PopoverX;
use rmrevin\yii\fontawesome\FA;
use kartik\form\ActiveForm;
?>
<?php
$form = ActiveForm::begin(['action' => '/todolists/update?id='.$list->id,'method'=>'post','fieldConfig'=>['showLabels'=>false]]);
PopoverX::begin([
    'size' => PopoverX::SIZE_LARGE,
    'placement' => PopoverX::ALIGN_BOTTOM_RIGHT,
    'type' => PopoverX::TYPE_INFO,
    'footer' => Html::button('View', ['class'=>'btn btn-primary']),
    'toggleButton' => ['label'=> FA::icon('pencil').'','type' => 'button', 'class'=>'btn btn-xs btn-default'],
    'header' => '<i class="fa fa-task"></i> Edit list:'.$list->name,
    'footer'=>Html::submitButton('Submit', ['class'=>'btn btn-xs btn-primary']) .
        Html::button('Cancel', ['class'=>'btn btn-xs btn-default','data-dismiss' => 'popover-x'])
]);
echo $form->field($list, 'name')->textInput(['placeholder'=>'Enter list name...']);
echo $form->field($list, 'description')->textArea(['rows' => '2','placeholder'=>'Enter list description...']);
PopoverX::end();
ActiveForm::end();

