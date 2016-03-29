<?php
use kartik\helpers\Html;
?>
<?= $this->render('_toolbar',['item' => $item,'category'=>$category,'type'=>$type]) ?>
<div class="" style="margin-right:20px;" id="swots_content_<?=$item->id?>" >
    <div>
        <?= Html::a($item->name,['swots/details/'.$item->id],['id' => 'swot_item_'.$item->id,'style' => 'font-size:15px;']); ?>
        <small>
            <p>
                <?php if(!empty($item->description)):?>
                    <span class="text text-muted" style="font-size: 13px;"><?=$item->description?></span>
                <?php else: ?>
                    <span class="text text-muted" style="border-bottom: dotted 1px;">No description</span>
                <?php endif; ?>
            </p>
        </small>
    </div>
    <small>
        <p>
            <?php if(!empty($item->taggedwith)):?>
                <span class="text text-muted" style="border-bottom: dotted 1px;">
                    <i class="fa fa-tags"></i> <?=$item->taggedwith?>
                </span>
            <?php else: ?>
                <span class="text text-muted" style="border-bottom: dotted 1px;"><i class="fa fa-tags"></i> No tags</span>
            <?php endif; ?>
            <span class="text text-muted" style="margin-left:10px; border-bottom: dotted 1px;"><i class="fa fa-list"></i> Lists (<?=\common\models\TodoHelpers::countTodoListsForSwotItem($item->id)?>)</span>
            <span class="text text-muted" style="margin-left:10px; border-bottom: dotted 1px;"><i class="fa fa-comments-o"></i> No comments</span>
        </p>
    </small>
</div>
