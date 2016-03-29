<?php use yii\helpers\Html; ?>
<div class="thumbnail post_unselected" class="pull-left">
    <?php if($model['img'] != '') { ?>
    <a href="<?php echo $model['img']; ?>" target="_blank"><img src="" data-src="<?php echo $model['img']; ?>" class="img-rounded img-responsive photo-post lazy"></a>
    <?php } ?>
    <div class="caption">
        <input type="hidden" name="post[<?=$model['id']?>][image_url]" value="<?=$model['img']?>">
        <input type="hidden" name="post[<?=$model['id']?>][id]" value="<?=$model['id']?>">
    </div>
    <?php echo $this->render('../_select_hide_buttons', ['model' => $model]); ?>
</div>