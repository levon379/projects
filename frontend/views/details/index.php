<?php
use kartik\helpers\Html;
use kartik\helpers\Enum;
use kartik\icons\Icon;
use yii\helpers\Url;
use kartik\popover\PopoverX;
use rmrevin\yii\fontawesome\FA;
use kartik\form\ActiveForm;
use kartik\form\ActiveField;
use yii\helpers\Inflector;

Icon::map($this);

$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['swots/'.$category->id]];
$this->params['breadcrumbs'][] = ['label' => Inflector::pluralize($model->type), 'url' => ['swots/'.$category->id.'/'.Inflector::pluralize($model->type)]];
$this->params['breadcrumbs'][] = ['label' => $model->type.' Details & Activities'];
?>

<div class="row">
    <div class="col-md-12">
        <h4><?= $model->name ?></h4>
        <?php if(!empty($model->description)):?>
            <span class="text text-muted" style=""><?=$model->description?></span>
        <?php else: ?>
            <span class="text text-muted" style="border-bottom: dotted 1px;">No description</span>
        <?php endif; ?>
        <hr>
    </div>
</div>

<div class="row">

    <div class="col-md-8">
        
    <div id="add_list_button" class="well well-sm">
        <span class="pull-left" style="margin-right: 5px;">
        <?php
        $form = ActiveForm::begin(['action'=>'/todolists/create','method'=>'post','fieldConfig'=>['showLabels'=>false]]);
        PopoverX::begin([
            'size' => PopoverX::SIZE_LARGE,
            'placement' => PopoverX::ALIGN_BOTTOM_LEFT,
            'type' => PopoverX::TYPE_PRIMARY,
            'footer' => Html::button('View', ['class'=>'btn btn-primary']),
            'toggleButton' => ['label'=> FA::icon('plus-circle').' New Todo List', 'class'=>'btn btn-xs btn-primary'],
            'header' => '<i class="fa fa-task"></i> Adding a new Todo list',
            'footer'=>Html::submitButton('Submit', ['class'=>'btn btn-xs btn-primary']) .
                Html::button('Cancel', ['class'=>'btn btn-xs btn-default','data-dismiss' => 'popover-x'])
        ]);

        echo $form->field($listmodel,'swot_id',['inputOptions' => ['value' => $model->id]])->hiddenInput();
        echo $form->field($listmodel, 'name')->textInput(['placeholder'=>'Enter list name...']);
        echo $form->field($listmodel, 'description')->textArea(['rows' => '3','placeholder'=>'Enter list description...']);

        PopoverX::end();
        ActiveForm::end();
        ?>
        </span>

        <a href="/swots/details/events/<?=$model->id?>" class="btn btn-xs btn-primary">
            <i class="fa fa-reorder"></i> Re-order Lists
        </a>
        
        <a href="/swots/details/events/<?=$model->id?>" class="btn btn-xs btn-primary">
            <i class="fa fa-calendar"></i> Events
        </a>
        
        <div class="btn-group pull-right" style="margin-left: 5px;">
            <button type="button" data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle"><i class="fa fa-gear"></i>
                <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li>
                    <a href="#">
                        <small><i class="fa fa-compass"></i> Move to...</small>
                    </a>
                </li>
                <li><a href="#">
                        <small><i class="fa fa-download"></i> Download</small>
                    </a></li>
                <li><a href="#">
                        <small><i class="fa fa-archive"></i> Archived (0)</small>
                    </a></li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <small><i class="fa fa-trash-o"></i> Trash (0)</small>
                    </a>
                </li>
            </ul>
        </div>
    </div>
        
        
        <?php foreach($lists as $list):?>

            <div class="panel panel-default">
                
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class="pull-left" style="margin-right:5px;">
                            <?= $this->render('_list_task_options',['list' => $list,'task' => new \frontend\models\Todos()]) ?>
                        </div>
                        <?= $list->name ?></h3>
                    <div id="toolbar_todo_item_<?=$list->id?>" class="">
                        
                        <div class="pull-right" style="margin-top: -20px;">
                            <?= $this->render('_list_item_options',['list'=>$list]) ?>
                        </div>
                    </div>
                </div>
                
                <div class="panel-body">
                
                    <p style="font-size:15px;">
                    <?php if(!empty($list->description)):?>
                        <span class="text text-muted" style=""><?=$list->description?></span>
                    <?php else: ?>
                        <span class="text text-muted" style="border-bottom: dotted 1px;">No description</span>
                    <?php endif; ?>
                    </p>
                    <?php if(count($list->todos)==0):?>
                    <hr>
                    <?endif;?>

                    <?= $this->render('_task_list',['tasks' => $list->getTodos()->orderBy('priority')->all(),'swot_id' => $list->swot_id, 'list_id' => $list->id, 'list' => $list]) ?>

                </div>
               
            </div>

        <?endforeach;?>
        
    </div>
    <div class="col-md-4">
         <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-calendar"></i> Events</div>
                <div class="panel-body">Panel Content</div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading"><i class="fa fa-comments-o"></i> General Comments</div>
                <div class="panel-body">Panel Content</div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading"><i class="fa fa-files-o"></i> Files</div>
                <div class="panel-body">Panel Content</div>
            </div>
        </div>
    </div>
</div>


<?php

$script = <<< JS

JS;

$this->registerJs($script);

?>

<script>

    $(document).ready(function(){
        
    $( ".sortable_list" ).sortable({
        handle: '.drag_handle',
        stop: function(event, ui) {

        },
        update: function(event, ui) {
            var data = $(this).sortable("serialize");
            $.ajax({
                url: '/details/ordertasks',
                data: data,
                type: 'post'
            });
        },
        receive: function(event, ui) {
            var sourceList = ui.sender;
            var targetList = $(this);
            console.log(sourceList);
            console.log(targetList);
            event.preventDefault();
        }
    }).disableSelection();
        
    $(".list-container").bind({
        mouseenter:
            function()
            {
                $('#'+$(this).data('id')).show();
            },
        mouseleave:
            function()
            {
                $('#'+$(this).data('id')).hide("fast");
            }
        }
    );
    });

</script>
