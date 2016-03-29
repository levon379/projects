<?php use yii\helpers\Html; ?>
<div class="thumbnail post_unselected">
    <?php //\backend\components\Common::print_p($model); ?>
    <?php if($model->image_filename0 != '') { ?>
    <a href="<?php echo $model->image_url; ?>" target="_blank"><img src="<?php echo $model->image_url; ?>" class="img-rounded img-responsive<?php if($model->link != '') { ?> link-post<?php } else { ?> photo-post<?php } ?>"></a>
    <?php } ?>
    <div class="caption">
        <p><?php if(isset($model->text)) { echo $model->text; } ?></p>
        <textarea style="display:none" name="post[<?=$model->id?>][text]"><?php if(isset($model->text)) { echo $model->text; } ?></textarea>
        <input type="hidden" name="post[<?=$model->id?>][id]" value="<?=$model->id?>">
        <input type="hidden" name="post[<?=$model->id?>][name]" value="<?=htmlentities($model->name)?>">
        <input type="hidden" name="post[<?=$model->id?>][post_type_id]" value="<?=$model->post_type_id?>">
        <input type="hidden" name="post[<?=$model->id?>][scheduled_time]" value="<?=$model->scheduled_time?>">
        <input type="hidden" name="post[<?=$model->id?>][image_url]" value="<?=$model->image_url?>">
        <input type="hidden" name="post[<?=$model->id?>][link]" value="<?=$model->link?>">
    </div>
    <?php echo $this->render('../_select_hide_buttons', ['model' => $model]); ?>
</div>