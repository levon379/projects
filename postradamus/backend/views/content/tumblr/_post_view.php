<?php use yii\helpers\Html; ?>
<div class="thumbnail post_unselected">
    <?php //\backend\components\Common::print_p($model); ?>
    <?php if($model['image_url'] != '') { ?>
    <a href="<?php echo $model['post_url']; ?>" target="_blank"><img src="" data-src="<?php echo $model['image_url']; ?>" class="img-rounded img-responsive photo-post lazy" alt="<?=$model['blog_name']?>"></a>
    <?php } ?>
    <div class="caption">
        <p><a href="<?php echo $model['author_link']; ?>" target="blank"><img src="<?=$model['author_image_url']?>" style="float: left; max-width:45px; max-height:45px; padding-right: 5px; padding-bottom; 5px"></a> <a href="<?php echo $model['blog_url']; ?>" target="blank"><?php echo $model['blog_name']; ?></a>
            <br />
            <small style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
font-size: 11px; color: #999;">on <?php echo date(Yii::$app->postradamus->get_user_date_time_format(), $model['created']); ?></small></p>
        <p><?php if(isset($model['text'])) { echo $model['text']; } ?></p>
        <p><b>Notes:</b> <?php if(isset($model['note_count'])) { echo (int)$model['note_count']; } ?></p>
        <input type="hidden" name="post[<?=$model['id']?>][meta][type]" value="<?=$model['type']?>">
        <input type="hidden" name="post[<?=$model['id']?>][id]" value="<?=$model['id']?>">
        <textarea style="display:none" name="post[<?=$model['id']?>][text]"><?php if(isset($model['text'])) { echo $model['text']; } ?></textarea>
        <input type="hidden" name="post[<?=$model['id']?>][image_url]" value="<?=$model['image_url']?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][note_count]" value="<?php if(isset($model['note_count'])) { echo (int)$model['note_count']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][created]" value="<?=$model['created']?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][post_url]" value="<?=$model['post_url']?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][blog_name]" value="<?=$model['blog_name']?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][blog_url]" value="<?=$model['blog_url']?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_name]" value="<?=$model['blog_name']?>">
    </div>
    <?php echo $this->render('../_select_hide_buttons', ['model' => $model]); ?>
</div>