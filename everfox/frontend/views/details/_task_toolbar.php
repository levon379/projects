<?php
use kartik\helpers\Html;
use kartik\icons\Icon;

use kartik\popover\PopoverX;
use rmrevin\yii\fontawesome\FA;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
?>
<div id="_toolbar_task_item_<?=$task_id?>">
<div class="pull-left">
    <?= $this->render('_list_task_options',['list' => $list,'task' => $task]) ?>
</div>
    
<?= Html::a(FA::icon('trash-o',['style' => 'cursor: pointer;']) .'', ['delete', 'id' => $task_id], [
    'class' => 'btn btn-xs btn-default',
    'data' => [
        'confirm' => Yii::t('app', 'Are you sure to delete this item?'),
        'method' => 'post',
    ],
]) ?>
    
    <div class="pull-right">
        
    <?php
        PopoverX::begin([
            'size' => PopoverX::SIZE_MEDIUM,
            'placement' => PopoverX::ALIGN_LEFT,
            'type' => PopoverX::TYPE_PRIMARY,
            'footer' => Html::button('View', ['class'=>'btn btn-primary']),
            'toggleButton' => ['label'=> FA::icon('sort').'', 'class'=>'btn btn-xs btn-default'],
            'header' => '<i class="fa fa-sort"></i> Move to... ',
            'footer'=>Html::submitButton('Move', ['class'=>'btn btn-xs btn-primary']) .
                Html::button('Cancel', ['class'=>'btn btn-xs btn-default','data-dismiss' => 'popover-x'])
        ]);
        
        $todoLists = common\models\TodoHelpers::getTodoListsForSwotItem($swot_id);
        $dataList = ArrayHelper::map($todoLists, 'id', 'name');
        echo Html::dropDownList('todolists', null,$dataList,['class' => 'form-control','prompt' => 'Select a list...']);
        
        PopoverX::end();
    ?>
    </div>

</div>
