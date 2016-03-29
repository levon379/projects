<p><a href="<?=$model['edit_url']?>" target="_blank"><?=date('(D) ' . Yii::$app->postradamus->get_user_date_time_format(), $model['scheduled_time'])?></a> -
<i>(<?=ucwords($model['scheduler'])?> Scheduler)</i></p>
<p><?php if($model['image_url'] != '') { ?><a href="" target="_blank"><img src="<?=$model['image_url']?>" style="margin-right:10px; max-width:100px; max-height: 100px; float: left"></a><?php } ?><?=$model['text']?></p>
<div style="clear:both"></div><hr />