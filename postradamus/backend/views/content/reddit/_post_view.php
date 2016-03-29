<?php use yii\helpers\Html; ?>
<div class="thumbnail post_unselected">
    <?php //\backend\components\Common::print_p($model); ?>
    <?php if(isset($model['image_url']) && $model['image_url'] != '') { ?>
        <a href="<?php echo $model['post_url']; ?>" target="_blank"><img src="<?php echo $model['image_url']; ?>" class="lazy img-rounded img-responsive<?php if($model['post_url'] != '') { ?> link-post<?php } else { ?> photo-post<?php } ?>" alt="<?=$model['author_name']?>"></a>
    <?php } else { ?>
        <div style="text-align:center"><a href="<?php echo $model['post_url']; ?>" target="_blank">No Image</a></div>
    <?php } ?>
    <div class="caption">
        <p><?php if($model['author_url'] != '') { ?><a href="<?php echo $model['author_url']; ?>" target="blank"><?php } ?>
                <img src="<?=$model['author_image_url']?>" style="float: left; max-width:45px; max-height:45px; padding-right: 5px; padding-bottom; 5px">
           <?php if($model['author_url'] != '') { ?></a><?php } ?>

           <?php if($model['author_url'] != '') { ?><a href="<?php echo $model['author_url']; ?>" target="blank"><?php } ?>
               <?php echo $model['author_name']; ?>
           <?php if($model['author_url'] != '') { ?></a><?php } ?>
        <br />
        <small style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
font-size: 11px; color: #999;">on <?php echo date(Yii::$app->postradamus->get_user_date_time_format(), $model['created']); ?></small></p>
        <p class="text"><b><?php echo $model['title']; ?></b><br /><?php if(isset($model['text'])) { echo substr($model['text'], 0, 600); } ?></p>

        <p><b>Ups:</b> <?php if(isset($model['up_count'])) { echo (int)$model['up_count']; } ?> | <b>Comments:</b> <?php if(isset($model['comment_count'])) { echo (int)$model['comment_count']; } ?></p>
        <textarea style="display:none" name="post[<?=$model['id']?>][text]"><?php if(isset($model['text'])) { echo $model['text']; } ?></textarea>
        <input type="hidden" name="post[<?=$model['id']?>][image_url]" value="<?=$model['image_url']?>">
        <input type="hidden" name="post[<?=$model['id']?>][url]" value="<?=$model['post_url']?>">
        <input type="hidden" name="post[<?=$model['id']?>][created]" value="<?=$model['created']?>">
        <input type="hidden" name="post[<?=$model['id']?>][id]" value="<?=$model['id']?>">
        <input type="hidden" name="post[<?=$model['id']?>][title]" value="<?php if(isset($model['title'])) { echo addslashes($model['title']); } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][up_count]" value="<?php if(isset($model['ups'])) { echo (int)$model['ups']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][comment_count]" value="<?php if(isset($model['comments'])) { echo (int)$model['comments']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][author_name]" value="<?=$model['author_name']?>">
        <input type="hidden" name="post[<?=$model['id']?>][author_url]" value="<?php if(isset($model['author_url'])) echo $model['author_profile_url']; ?>">
    </div>
    <?php echo $this->render('../_select_hide_buttons', ['model' => $model]); ?>
</div>