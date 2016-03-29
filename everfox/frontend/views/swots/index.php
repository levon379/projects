<?php
/* @var $this yii\web\View */
?>
<?php

/* @var $this yii\web\View */

use yii\widgets\Pjax;
use kartik\helpers\Html;
use kartik\icons\Icon;
use yii\bootstrap\Modal;
use yii\helpers\Url;

Icon::map($this);

$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['dashboard/index']];
if($type==null){
    $this->params['breadcrumbs'][] = $category->name;
} else
{
    $this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['swots/'.$category->id]];
    $this->params['breadcrumbs'][] = $type;
}
?>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'swot-modal',
    'size' => Modal::SIZE_LARGE,
    'clientOptions' => []
]);
echo "<div id='modalContent'></div>";
yii\bootstrap\Modal::end();
?>

<div class="page-header">
    <h3><?= Html::a($category->name, ['dashboard/category', 'id' => $category->id], ['class' => '','data' => [],]) ?></h3>
    <div class="pull-right" style="margin-top:-25px;font-size:18px;">
        <a href="/swots/trashed-items?id=<?=$category->id?>" style="padding-right: 10px;"><i class="fa fa-trash"></i></a><i class="fa fa-print"></i> <i class="fa fa-file-excel-o"></i> <i class="fa fa-file-pdf-o"></i>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if(!empty($category->description)):?>
            <span class="text text-muted" style=""><?= $category->description;?></span>
        <?php else: ?>
            <span class="text text-muted" style="border-bottom: dotted 1px;">No description</span>
        <?php endif; ?>
    </div>
    
</div>
<hr />

<div class="row">

    <div class="col-md-9">

        <? if(isset($strengths)): ?>
            <?php Pjax::begin(['id' => 'strengths_box']); ?>
            <?=$strengths?>
            <?php Pjax::end(); ?>
        <? endif; ?>
        <? if(isset($weaknesses)): ?>
            <?php Pjax::begin(['id' => 'weaknesses_box']); ?>
            <?=$weaknesses?>
            <?php Pjax::end(); ?>
        <? endif; ?>
        <? if(isset($opportunities)): ?>
            <?php Pjax::begin(['id' => 'opportunities_box']); ?>
            <?=$opportunities?>
            <?php Pjax::end(); ?>
        <? endif; ?>
        <? if(isset($threats)): ?>
            <?php Pjax::begin(['id' => 'threats_box']); ?>
            <?=$threats?>
            <?php Pjax::end(); ?>
        <? endif; ?>

    </div>
    
    <div class="col-md-3">
        <div class="panel-group">
            
            <?php if($type==null):?>
            
            <div class="panel panel-info">
                <div class="panel-heading"><i class="fa fa-th-large"></i> View </div>
                <div class="panel-body">
                    <span class="" style="cursor: pointer;" onclick="$(this).find('i').toggleClass('fa-check-square-o fa-square-o');" id="strengths_check"><i class="fa fa-check-square-o"></i> Strengths (0)</span>
                    <span class="" style="cursor: pointer;" onclick="$(this).find('i').toggleClass('fa-check-square-o fa-square-o');" id="weaknesses_check"><i class="fa fa-check-square-o"></i> Weaknesses (0)</span> <br>
                    <span class="" style="cursor: pointer;" onclick="$(this).find('i').toggleClass('fa-check-square-o fa-square-o');" id="opportunties_check"><i class="fa fa-check-square-o"></i> Opportunties (0)</span>
                    <span class="" style="cursor: pointer;" onclick="$(this).find('i').toggleClass('fa-check-square-o fa-square-o');" id="threats_check"><i class="fa fa-check-square-o"></i> Threats (0)</span>
                </div>
            </div>
            
            <?php endif;?>
            
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-tags"></i> Tags</div>
                    <div class="panel-body">
                        <?php foreach ($tagsWithCount as $key => $value): ?>
                            <?php if( $key != '' ):?>
                                <span class="label label-primary" style="cursor: pointer;"
                                onclick="$(this).find('i').toggleClass('fa-check-square-o fa-square-o');"><i class="fa fa-check-square-o"></i> <?=$key?> (<?=$value;?>)</span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
            </div>
            
        </div>
    </div>

</div>

<?php
$script = <<< JS

function sortableList(name)
{
    $( "#"+name+"-list-items" ).sortable({
        /*connectWith: ".connectedSortable",*/
        handle: '.drag_handle',
        stop: function(event, ui) {

        },
        update: function(event, ui) {
            var data = $(this).sortable("serialize");
            $.ajax({
                url: '/swots/order',
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
}
        
    $(document).on('ready pjax:success', function(){
        
        sortableList('Strength');
        sortableList('Weakness');
        sortableList('Opportunity');
        sortableList('Threat');

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

JS;

$this->registerJs($script);
$this->registerJs("
    $('#strengths_check').click(function(){
        if(!$('#strengths_box').hasClass('strengths_hide_box')){
            $('#strengths_box').hide();
            $('#strengths_box').addClass('strengths_hide_box');
        }else{
            $('#strengths_box').show();
            $('#strengths_box').removeClass('strengths_hide_box');
        }
    });
    $('#weaknesses_check').click(function(){
        if(!$('#weaknesses_box').hasClass('weaknesses_hide_box')){
            $('#weaknesses_box').hide();
            $('#weaknesses_box').addClass('weaknesses_hide_box');
        }else{
            $('#weaknesses_box').show();
            $('#weaknesses_box').removeClass('weaknesses_hide_box');
        }
    });
    $('#opportunties_check').click(function(){
        if(!$('#opportunities_box').hasClass('opportunties_hide_box')){
            $('#opportunities_box').hide();
            $('#opportunities_box').addClass('opportunties_hide_box');
        }else{
            $('#opportunities_box').show();
            $('#opportunities_box').removeClass('opportunties_hide_box');
        }
    });
    $('#threats_check').click(function(){
        if(!$('#threats_box').hasClass('threats_hide_box')){
            $('#threats_box').hide();
            $('#threats_box').addClass('threats_hide_box');
        }else{
            $('#threats_box').show();
            $('#threats_box').removeClass('threats_hide_box');
        }
    });
");

?>

<script>

</script>
