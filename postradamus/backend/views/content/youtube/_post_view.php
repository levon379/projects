<?php use yii\helpers\Html;
use backend\components\Common; ?>
<div class="thumbnail post_unselected" class="pull-left">
    <?php if($model['image_url'] != '') { ?>
    <a href="<?php echo $model['image_link']; ?>" target="_blank"><img src="" data-src="<?php echo $model['image_url']; ?>" class="img-rounded img-responsive lazy"></a>
    <?php } ?>
    <div class="caption">
        <p><b><?php if(isset($model['title'])) { echo $model['title']; } ?></b></p>
        <p><?php if(isset($model['message'])) { echo $model['message']; } ?></p>
        <p><b>Likes:</b> <?php if(isset($model['likes'])) { echo Common::human_number((int)$model['likes']); } ?> | <b>Views:</b> <?php if(isset($model['views'])) { echo Common::human_number((int)$model['views']); } ?> | <b>Comments:</b> <?php if(isset($model['comments'])) { echo Common::human_number((int)$model['comments']); } ?></p>
        <textarea style="display:none" name="post[<?=$model['id']?>][text]"><?php if(isset($model['message'])) { echo $model['message']; } ?></textarea>
        <input type="hidden" name="post[<?=$model['id']?>][image_url]" value="<?=$model['image_url']?>">
        <input type="hidden" name="post[<?=$model['id']?>][url]" value="<?=$model['image_link']?>">
        <input type="hidden" name="post[<?=$model['id']?>][title]" value="<?=$model['title']?>">
        <input type="hidden" name="post[<?=$model['id']?>][id]" value="<?=$model['id']?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][likes]" value="<?php if(isset($model['likes'])) { echo (int)$model['likes']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][views]" value="<?php if(isset($model['views'])) { echo (int)$model['views']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][comments]" value="<?php if(isset($model['comments'])) { echo (int)$model['comments']; } ?>">
    </div>
    <?php echo $this->render('../_select_hide_buttons', ['model' => $model]); ?>
</div>