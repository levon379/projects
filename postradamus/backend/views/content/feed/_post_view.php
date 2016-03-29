<?php use yii\helpers\Html; use yii\helpers\StringHelper; ?>
<div class="thumbnail post_unselected">
    <?php //\backend\components\Common::print_p($model); ?>
    <?php if($model['image_url'] != '') { ?>
    <a href="<?php echo $model['url']; ?>" target="_blank"><img src="" data-src="<?php echo $model['image_url']; ?>" class="img-rounded img-responsive photo-post lazy" alt="<?=$model['author_name']?>"></a>
    <?php } ?>
    <div class="caption">
        <p><img src="<?=$model['author_image_url']?>" style="float: left; max-width:45px; max-height:45px; padding-right: 5px; padding-bottom; 5px">
            <a href="<?php echo $model['author_url']; ?>" target="blank"><?php echo $model['author_name']; ?></a>
            <br />
            <small style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
font-size: 11px; color: #999;">on <?php if($model['created'] != '') { echo date(Yii::$app->postradamus->get_user_date_time_format(), $model['created']); } ?></small></p>
        <p><b><?php if(isset($model['title'])) { echo $model['title']; } ?></b></p>
        <div style="overflow-y: auto; overflow-x: hidden; text-overflow: ellipsis; max-height:300px">
        <p class="post-text">
			<?php 
			if(isset($model['text'])){
				$postText=$model['text'];
				$tWords=str_word_count($postText);
				if($tWords>25){
					$seeMoreLink=' <a href="javascript:void(0);" class="see-more-text">See More</a><span class="more-text hidden">'.$postText.'</span>';
					$postText=StringHelper::truncateWords($postText,20,' [...]',true);
					$postText.=$seeMoreLink;
				}
				echo $postText;
			}
			?>
		</p>
        </div>
        <?php if(isset($model['comment_count'])) { ?><p style="margin-top:10px"><b>Comments:</b> <?php echo (int)$model['comment_count']; ?></p><?php } ?>
        <?php
        $attributes = array_keys($model);
        foreach($attributes as $k => $attribute) { ?>
            <input type="hidden" name="post[<?=$model['id']?>][<?=$attribute?>]" value="<?=(isset($model[$attribute]) ? @htmlentities(trim($model[$attribute])) : '') ?>">
        <?php } ?>
    </div>
    <?php echo $this->render('../_select_hide_buttons', ['model' => $model]); ?>
</div>