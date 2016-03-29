<?php
use yii\helpers\Inflector;
?>
<ul class="no-borders list-group connectedSortable" style="margin: 0 1px -13px 1px;" id="<?=$type?>-list-items">
    <?php if(count($swot_items)==0):?>
        <li class="list-group-item">
            There appear to be no <?=Inflector::pluralize($type)?>
        </li>
    <?php endif;?>
    <?php foreach($swot_items as $item):?>
        <li class="list-group-item list-container" data-id="toolbar_swot_item_<?=$item->id?>" data-swot-id="<?=$item->id?>"
            id="edit_swot_item_<?=$item->id?>" data-type="<?=$type?>">
            <div id="list_item_id_<?= $item->id ?>" style="margin-left: 10px; margin-top: -5px;">
                <?= $this->render('_listitem',['item' => $item,'category'=>$category,'type'=>$type]) ?>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
