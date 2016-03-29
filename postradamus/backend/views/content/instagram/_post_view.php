<?php use yii\helpers\Html; ?>
<div class="thumbnail post_unselected">
    <?php if(isset($model['image_url']) && $model['image_url'] != '') { ?>
    <a href="<?php echo $model['post_link']; ?>" target="_blank"><img src="" data-src="<?php echo $model['image_url']; ?>" class="img-rounded img-responsive photo-post lazy" alt="<?//=$model['author_name']?>"></a>
    <?php } ?>
    <div class="caption">
        <p><img src="<?=$model['author_pic']?>" style="float: left; max-width:45px; max-height:45px; padding-right: 5px; padding-bottom; 5px"> <a href="<?php echo $model['author_url']; ?>" target="blank"><?php echo $model['author_name']; ?></a>
        <?php if($model['type'] == 'video') { ?>
        <div class="play"></div>
        <input type="hidden" name="post[<?=$model['id']?>][link]" value="<?=$model['post_link']?>" />
        <input type="hidden" name="post[<?=$model['id']?>][type]" value="video" />
        <?php } else { ?>
        <input type="hidden" name="post[<?=$model['id']?>][type]" value="image" />
        <?php } ?>

        <br />
            <small style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
font-size: 11px; color: #999;">on <?php echo date(Yii::$app->postradamus->get_user_date_time_format(), $model['created']); ?></small></p>
        <p><?php if(isset($model['text'])) { echo $model['text']; } ?></p>
        <p><b>Likes:</b> <?php if(isset($model['likes'])) { echo (int)$model['likes']; } ?> | <b>Comments:</b> <?php if(isset($model['comments'])) { echo (int)$model['comments']; } ?></p>
        <textarea style="display:none" name="post[<?=$model['id']?>][text]"><?php if(isset($model['text'])) { echo $model['text']; } ?></textarea>
        <?php if(isset($model['image_url'])) { ?>
        <input type="hidden" name="post[<?=$model['id']?>][image_url]" value="<?=$model['image_url']?>">
        <?php } ?>
        <input type="hidden" name="post[<?=$model['id']?>][id]" value="<?=$model['id']?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_name]" value="<?php if(isset($model['author_name'])) { echo $model['author_name']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_image_url]" value="<?php if(isset($model['author_pic'])) { echo $model['author_pic']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_profile_url]" value="<?php if(isset($model['author_url'])) { echo $model['author_url']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][like_count]" value="<?php if(isset($model['likes'])) { echo (int)$model['likes']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][share_count]" value="<?php if(isset($model['shares'])) { echo (int)$model['shares']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][comment_count]" value="<?php if(isset($model['comments'])) { echo (int)$model['comments']; } ?>">
    </div>
    <?php echo $this->render('../_select_hide_buttons', ['model' => $model]); ?>
</div>