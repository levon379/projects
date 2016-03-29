<?php
use yii\helpers\Html; 
?>
<div class="thumbnail post_unselected">
    <?php //\backend\components\Common::print_p($model); ?>
	<div>
		<?php
		$tempDate= strtotime(str_replace('/', '-', $model['scheduled_time']));
		?>
		<span <?php if(!empty($tempDate) && ($tempDate + $offset) > (time() + 60 * 15)) { echo " style='font-family: tahoma; font-size:80%; color:green;'"; } else { echo " style='font-family: tahoma; font-size:80%; color:red;'"; } ?>><?php echo (!empty($tempDate)) ? date($format,$tempDate) : 'Not yet scheduled' ; ?></span>
		 <input type="hidden" name="post[<?php echo $index ?>][scheduled_time]" value="<?=$model['scheduled_time']?>">
	</div>
    <?php if($model['image_url'] != '') { ?>
    <a href="<?php echo $model['image_url']; ?>" target="_blank"><img src="<?php echo $model['image_url']; ?>" class="img-rounded img-responsive photo-post"></a>
    <?php } ?>
	<div style="text-align: center;font-size:10px">
		<?php
		$tempName=(!empty($model['name']))?$model['name']:$defaultSourceName;
		?>
		<?=$tempName?>
		<input type="hidden" name="post[<?php echo $index ?>][name]" value="<?=$tempName?>">
		<input type="hidden" name="post[<?php echo $index ?>][link]" value="<?=$model['link']?>">
	</div>
    <div class="caption">
        <p><?php if(isset($model['text'])) { echo $model['text']; } ?></p>
        <textarea style="display:none" name="post[<?php echo $index ?>][text]"><?php if(isset($model['text'])) { echo $model['text']; } ?></textarea>
        <input type="hidden" name="post[<?php echo $index ?>][image_url]" value="<?=$model['image_url']?>">
    </div>
    <?php 
        $model['id'] = $index;
        echo $this->render('../_select_hide_buttons', ['model' => $model]); 
    ?>
</div>