<?php use yii\helpers\Html; ?>
<div class="thumbnail post_unselected">
    <?php //\backend\components\Common::print_p($model); ?>
    <?php if($model['image_url'] != '') { ?>
        <a href="<?php echo $model['image_link']; ?>" target="_blank"><img src="" data-src="<?php echo $model['image_url']; ?>" class="img-rounded img-responsive photo-post lazy" alt="<?=$model['author_name']?>"></a>
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
        <p><?php if(isset($model['text'])) { echo $model['text']; } ?></p>
        <p><b>Retweets:</b> <?php if(isset($model['retweet_count'])) { echo (int)$model['retweet_count']; } ?> | <b>Favorites:</b> <?php if(isset($model['favorite_count'])) { echo (int)$model['favorite_count']; } ?></p>
        <textarea style="display:none" name="post[<?=$model['id']?>][text]"><?php if(isset($model['text'])) { echo $model['text']; } ?></textarea>
        <input type="hidden" name="post[<?=$model['id']?>][image_url]" value="<?=$model['image_url']?>">
        <input type="hidden" name="post[<?=$model['id']?>][id]" value="<?=$model['id']?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][retweet_count]" value="<?php if(isset($model['retweet_count'])) { echo (int)$model['retweet_count']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][favorite_count]" value="<?php if(isset($model['favorite_count'])) { echo (int)$model['favorite_count']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_name]" value="<?=$model['author_name']?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_profile_url]" value="<?php if(isset($model['author_url'])) echo $model['author_url']; ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_image_url]" value="<?php if(isset($model['author_image_url'])) echo $model['author_image_url']; ?>">
    </div>
    <?php echo $this->render('../_select_hide_buttons', ['model' => $model]); ?>
</div>