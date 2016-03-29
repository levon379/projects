<?php
use kartik\helpers\Html;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FA;
?>
<div class="pull-left" style="margin-right: 10px;">
    <?= Html::button(FA::icon('plus-circle').' ', ['value' => Url::to(['swots/swot', 'id' => 0,'categoryId' => $category, 'type' => $type]), 'title' => 'Adding a new '.$type,
        'class' => 'showModalButton btn btn-xs btn-primary', 'data-modal' => '#swot-modal']); ?>
</div>

