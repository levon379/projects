<?php
use kartik\helpers\Html;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FA;
?>
<div id="toolbar_todo_item_<?=$item->id?>" style="display: none;" class="pull-right btn-group btn-group-xs">

    <?= Html::a(FA::icon('trash',['style' => 'cursor: pointer; font-size:14px;']) .'', ['delete', 'id' => 0], [
        'class' => '',
        'data' => [
            'confirm' => Yii::t('app', 'Are you sure to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>

    <?= Html::a(FA::icon('pencil',['style' => 'cursor: pointer; font-size:14px;']) .'', FALSE, ['value' => '', 'title' => 'Item Editor', 'class' => 'btn btn-xs']); ?>

</div>

<div class="pull-left drag_handle" style="cursor: pointer;"><img src="/images/drag_icon.png" style="margin-left: -20px;"></div>
