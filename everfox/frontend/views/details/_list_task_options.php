<?php
use kartik\helpers\Html;
use kartik\helpers\Enum;
use kartik\icons\Icon;
use kartik\popover\PopoverX;
use rmrevin\yii\fontawesome\FA;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
?>
<?php
$form = ActiveForm::begin(['action' => isset($task->id) ? '/todos/update?id='.$task->id : '/todos/create/','method'=>'post','fieldConfig'=>['showLabels'=>false]]);
PopoverX::begin([
    'size' => PopoverX::SIZE_LARGE,
    'placement' => PopoverX::ALIGN_RIGHT,
    'type' => PopoverX::TYPE_PRIMARY,
    'footer' => Html::button('View', ['class'=>'btn btn-primary']),
    'toggleButton' => ['label'=> isset($task->id) ? FA::icon('pencil') : FA::icon('plus').'','type' => 'button', 'class'=>'btn btn-xs btn-default'],
    'header' => isset($task->id) ? '<i class="fa fa-pencil"></i> Edit Task' : '<i class="fa fa-plus"></i> Add Task',
    'footer'=>Html::submitButton('Save', ['class'=>'btn btn-xs btn-primary']) .
        Html::button('Close', ['class'=>'btn btn-xs btn-default','data-dismiss' => 'popover-x'])
]);

echo '<input type="hidden" name="swot_id" id="swot_id" value="'.$list->swot_id.'">';
echo $form->field($task, 'todolist_id')->hiddenInput(['value' => $list->id]);
echo $form->field($task, 'todo')->textInput(['maxlength' => true,'placeholder'=>'Enter task name...']);
echo $form->field($task, 'details')->textArea(['rows' => '2','placeholder'=>'Enter task description...']);
echo $form->field($task, 'due_on')->widget(DatePicker::classname(), [
'options' => ['id' => isset($task->id) ? 'date-picker-'.$task->id : 'date-picker-'.$list->id,'placeholder' => 'Due date ...'],
'type' => DatePicker::TYPE_COMPONENT_APPEND,
'pluginOptions' => [
'orientation' => 'top right',
'format' => 'dd-M-yyyy',
'autoclose' => true,
]]);

PopoverX::end();
ActiveForm::end();