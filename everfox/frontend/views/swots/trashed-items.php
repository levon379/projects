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
        <a href="/swots/trashed-items" style="padding-right: 10px;"><i class="fa fa-trash"></i></a><i class="fa fa-print"></i> <i class="fa fa-file-excel-o"></i> <i class="fa fa-file-pdf-o"></i>
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
            <?php Pjax::begin(); ?>
            <?=$strengths?>
            <?php Pjax::end(); ?>
        <? endif; ?>
        <? if(isset($weaknesses)): ?>
            <?php Pjax::begin(); ?>
            <?=$weaknesses?>
            <?php Pjax::end(); ?>
        <? endif; ?>
        <? if(isset($opportunities)): ?>
            <?php Pjax::begin(); ?>
            <?=$opportunities?>
            <?php Pjax::end(); ?>
        <? endif; ?>
        <? if(isset($threats)): ?>
            <?php Pjax::begin(); ?>
            <?=$threats?>
            <?php Pjax::end(); ?>
        <? endif; ?>

    </div>