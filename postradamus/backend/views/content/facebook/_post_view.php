<?php use yii\helpers\Html; use backend\components\Common; use yii\helpers\StringHelper; ?>
<div class="thumbnail post_unselected">
    <a class="view_item" target="_blank" href="<?php echo $model['post_url']; ?>"><span class="fa fa-external-link"></span></a>
    <?php if(isset($model['image_url']) && $model['image_url'] != '') { ?>
    <a href="<?php echo $model['image_url']; ?>" target="_blank"><img src="" data-src="<?php echo $model['image_url']; ?>" class="<?php if($model['link'] != '') { echo "link-post "; } elseif($model['image_url'] != '') { echo "photo-post "; } ?>img-rounded img-responsive fb-img lazy" data-page-id="<?=$model['page_id']?>" data-object-id="<?php if(isset($model['object_id'])) { echo $model['object_id']; } ?>" alt="<?//=$model['author_name']?>"></a>
    <?php } ?>
    <div class="caption">
        <p><img src="<?=$model['author_pic']?>" style="float: left; max-width:45px; max-height:45px; padding-right: 5px; padding-bottom; 5px">
            <a href="<?php echo $model['author_url']; ?>" target="blank"><?php echo $model['author_name']; ?></a>
            <br />
            <small style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
font-size: 11px; color: #999;">on <?php echo date(Yii::$app->postradamus->get_user_date_time_format(), $model['created']); ?></small></p>
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
        <textarea style="display:none" name="post[<?=$model['id']?>][text]"><?php if(isset($model['text'])) { echo $model['text']; } ?></textarea>
        <span class="label label-pa-purple"><i class="fa fa-thumbs-up"></i> <?php if(isset($model['likes'])) { echo Common::human_number((int)$model['likes']); } ?></span>
        <span class="label label-danger"><i class="fa fa-share"></i> <?php if(isset($model['shares'])) { echo Common::human_number((int)$model['shares']); } ?></span>
        <span class="label label-success"><i class="fa fa-comment"></i> <a data-method="post" style="color:white" href="<?php echo Yii::$app->urlManager->createUrl(['content/facebook', 'facebook_search_pill' => '#pill_comments', 'FacebookSearchForm[from_post_id]' => $model['id']]); ?>"><?php if(isset($model['comments'])) { echo Common::human_number((int)$model['comments']); } ?></a></span>

        <div class="progress" class="tooltips" data-placement="right" title="Engagement: <?=$model['engagement']?>%" style="margin-top:5px; margin-bottom:0">
            <div class="progress-bar progress-bar-warning" style="width: <?=$model['engagement']?>%;"></div>
        </div>

        <?php if(isset($model['image_url'])) { ?>
            <input type="hidden" name="post[<?=$model['id']?>][image_url]" value="<?=$model['image_url']?>">
            <input type="hidden" name="post[<?=$model['id']?>][large_image_id]" value="<?=$model['large_image_id']?>">
        <?php } ?>
        <input type="hidden" name="post[<?=$model['id']?>][id]" value="<?=$model['id']?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][page_id]" value="<?php if(isset($model['page_id'])) { echo $model['page_id']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_name]" value="<?php if(isset($model['author_name'])) { echo $model['author_name']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_image_url]" value="<?php if(isset($model['author_pic'])) { echo $model['author_pic']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_profile_url]" value="<?php if(isset($model['author_url'])) { echo $model['author_url']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][post_url]" value="<?php if(isset($model['post_url'])) { echo $model['post_url']; } ?>">

        <?php if(strstr($model['link'], 'video.php') || strstr($model['link'], 'vimeo.com')) { ?>
            <div class="play"></div>
        <?php } ?>

        <input type="hidden" name="post[<?=$model['id']?>][meta][link]" value="<?php if(isset($model['link'])) { echo $model['link']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][like_count]" value="<?php if(isset($model['likes'])) { echo (int)$model['likes']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][share_count]" value="<?php if(isset($model['shares'])) { echo (int)$model['shares']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][comment_count]" value="<?php if(isset($model['comments'])) { echo (int)$model['comments']; } ?>">
    </div>
    <?php echo $this->render('../_select_hide_buttons', ['model' => $model]); ?>
</div>