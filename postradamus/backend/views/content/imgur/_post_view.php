<?php use yii\helpers\Html; ?>
<div class="thumbnail post_unselected">
    <?php if(isset($model['image_url']) && $model['image_url'] != '') { ?>
    <a href="<?php echo $model['image_url']; ?>" target="_blank"><img src="" data-src="<?php echo $model['image_url']; ?>" class="img-rounded img-responsive photo-post lazy" alt="content image"></a>
    <?php } ?>
    <div class="caption">
        <p><?php if(isset($model['text'])) { echo $model['text']; } ?></p>
        <textarea style="display:none" name="post[<?=$model['id']?>][text]"><?php if(isset($model['text'])) { echo $model['text']; } ?></textarea>
        <?php if(isset($model['image_url'])) { ?>
        <input type="hidden" name="post[<?=$model['id']?>][image_url]" value="<?=$model['image_url']?>">
        <?php } ?>
        <input type="hidden" name="post[<?=$model['id']?>][id]" value="<?=$model['id']?>">
    </div>
    <?php echo $this->render('../_select_hide_buttons', ['model' => $model]); ?>
</div>