<?php 
use yii\helpers\Html; 
use backend\components\UnicodeHelper;
?>
<div class="thumbnail post_unselected">
    <?php //\backend\components\Common::print_p($model); ?>
    <?php if($model['image_url'] != '') { ?>
    <a href="<?php echo $model['image_link']; ?>" target="_blank"><img src="" data-src="<?php echo $model['image_url']; ?>" class="img-rounded img-responsive photo-post lazy" alt="<?=$model['author_name']?>"></a>
    <?php } ?>
    <div class="caption">
        <p><a href="<?php echo $model['author_link']; ?>" target="blank"><img src="<?=$model['author_image_url']?>" style="float: left; max-width:45px; max-height:45px; padding-right: 5px; padding-bottom; 5px"></a> <a href="<?php echo $model['author_link']; ?>" target="blank"><?php echo $model['author_name']; ?></a></p>
        <p><?php if(isset($model['description'])) { echo UnicodeHelper::CleanupText($model['description']); } ?></p>
        <p><b>Likes:</b> <?php if(isset($model['like_count'])) { echo (int)$model['like_count']; } ?> | <b>Repins:</b> <?php if(isset($model['repin_count'])) { echo (int)$model['repin_count']; } ?> | <b>Comments:</b> <?php if(isset($model['comment_count'])) { echo (int)$model['comment_count']; } ?></p>
        <textarea style="display:none" name="post[<?=$model['id']?>][text]"><?php if(isset($model['description'])) { echo UnicodeHelper::CleanupText($model['description']); } ?></textarea>
        <input type="hidden" name="post[<?=$model['id']?>][image_url]" value="<?=$model['image_url']?>">
        <input type="hidden" name="post[<?=$model['id']?>][image_link]" value="<?=$model['image_link']?>">
        <input type="hidden" name="post[<?=$model['id']?>][id]" value="<?=$model['id']?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][like_count]" value="<?php if(isset($model['like_count'])) { echo (int)$model['like_count']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][repin_count]" value="<?php if(isset($model['repin_count'])) { echo (int)$model['repin_count']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][comment_count]" value="<?php if(isset($model['comment_count'])) { echo (int)$model['comment_count']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_name]" value="<?=$model['author_name']?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_profile_url]" value="<?php if(isset($model['author_link'])) echo $model['author_link']; ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_image_url]" value="<?=$model['author_image_url']?>">
    </div>
    <?php echo $this->render('../_select_hide_buttons', ['model' => $model]); ?>
</div>