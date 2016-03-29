<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use common\models\cList;
?>
<?php
	$format = '(D) ' . Yii::$app->postradamus->get_user_date_time_format();
	if(!$userTimezone = Yii::$app->user->identity->getSetting('timezone')){
		$userTimezone = 'America/Los_Angeles';
	}
	$offset = Yii::$app->postradamus->get_timezone_offset($userTimezone);
?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'box'],
        'itemView' => $source  . '/_post_view',
		'viewParams'=>['format'=>$format,'offset'=>$offset,'defaultSourceName'=>$defaultSourceName],
        'layout' => '<div class="row"><div class="col-md-6">{summary}</div><div class="col-md-6" style="text-align: right">{sorter}</div></div><div id="mason-container">{items}</div><div class="row"><div class="col-xs-12">{pager}</div></div>',
    ]) ?>
	
<?php
$this->registerJs("
	$('.see-more-text').on('click',function(){
		var postTextCont=$(this).next();
		if(postTextCont.hasClass('more-text')){
			var postText=postTextCont.html();
			$(this).closest('.post-text').html(postText);
		}
	});
");
?>	