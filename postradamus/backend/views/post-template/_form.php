<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\cListPost;

/* @var $this yii\web\View */
/* @var $model common\models\cPostTemplate */
/* @var $form yii\widgets\ActiveForm */
$this->registerCss(".showMoreLinkBlock{margin:10px 0 5px;} #showMoreLink{text-decoration:underline;} .field-cposttemplate-description{display:none;} .clear-fix{float:none;clear:both;}");
/*
$this->registerJs("
					init.push(function () {

						$('#cposttemplate-origin_type').on('change', function() {
						    if($(this).val() == ".cListPost::ORIGIN_FACEBOOK.")
						    {
						       $('#facebook_tags').show('slow');
						       $('#pinterest_tags').hide();
						       $('#amazon_tags').hide();
						       $('#youtube_tags').hide();
						       $('#instagram_tags').hide();
						       $('#upload_tags').hide();
						       $('#twitter_tags').hide();
						       $('#list_tags').hide();
						       $('#feed_tags').hide();
						       $('#imgur_tags').hide();
						       $('#tumblr_tags').hide();
						       $('#reddit_tags').hide();
						       $('#webpage_tags').hide();
						    }
						    if($(this).val() == ".cListPost::ORIGIN_PINTEREST.")
						    {
						       $('#pinterest_tags').show('slow');
						       $('#facebook_tags').hide();
						       $('#amazon_tags').hide();
						       $('#youtube_tags').hide();
						       $('#instagram_tags').hide();
						       $('#upload_tags').hide();
						       $('#twitter_tags').hide();
						       $('#list_tags').hide();
						       $('#feed_tags').hide();
						       $('#imgur_tags').hide();
						       $('#tumblr_tags').hide();
						       $('#reddit_tags').hide();
						       $('#webpage_tags').hide();
						    }
						    if($(this).val() == ".cListPost::ORIGIN_AMAZON.")
						    {
						       $('#amazon_tags').show('slow');
						       $('#facebook_tags').hide();
						       $('#pinterest_tags').hide();
						       $('#youtube_tags').hide();
						       $('#instagram_tags').hide();
						       $('#upload_tags').hide();
						       $('#twitter_tags').hide();
						       $('#list_tags').hide();
						       $('#feed_tags').hide();
						       $('#imgur_tags').hide();
						       $('#tumblr_tags').hide();
						       $('#reddit_tags').hide();
						       $('#webpage_tags').hide();
						    }
						    if($(this).val() == ".cListPost::ORIGIN_YOUTUBE.")
						    {
						       $('#youtube_tags').show('slow');
						       $('#amazon_tags').hide();
						       $('#facebook_tags').hide();
						       $('#pinterest_tags').hide();
						       $('#instagram_tags').hide();
						       $('#upload_tags').hide();
						       $('#twitter_tags').hide();
						       $('#list_tags').hide();
						       $('#feed_tags').hide();
						       $('#imgur_tags').hide();
						       $('#tumblr_tags').hide();
						       $('#reddit_tags').hide();
						       $('#webpage_tags').hide();
						    }
						    if($(this).val() == ".cListPost::ORIGIN_INSTAGRAM.")
						    {
						       $('#instagram_tags').show('slow');
						       $('#youtube_tags').hide();
						       $('#amazon_tags').hide();
						       $('#facebook_tags').hide();
						       $('#pinterest_tags').hide();
						       $('#upload_tags').hide();
						       $('#twitter_tags').hide();
						       $('#list_tags').hide();
						       $('#feed_tags').hide();
						       $('#imgur_tags').hide();
						       $('#tumblr_tags').hide();
						       $('#reddit_tags').hide();
						       $('#webpage_tags').hide();
						    }
						    if($(this).val() == ".cListPost::ORIGIN_TWITTER.")
						    {
						       $('#instagram_tags').hide();
						       $('#youtube_tags').hide();
						       $('#amazon_tags').hide();
						       $('#facebook_tags').hide();
						       $('#pinterest_tags').hide();
						       $('#upload_tags').hide();
						       $('#twitter_tags').show('slow');
						       $('#list_tags').hide();
						       $('#feed_tags').hide();
						       $('#imgur_tags').hide();
						       $('#tumblr_tags').hide();
						       $('#reddit_tags').hide();
						       $('#webpage_tags').hide();
						    }
						    if($(this).val() == ".cListPost::ORIGIN_UPLOAD.")
						    {
						       $('#instagram_tags').hide();
						       $('#youtube_tags').hide();
						       $('#amazon_tags').hide();
						       $('#facebook_tags').hide();
						       $('#pinterest_tags').hide();
						       $('#upload_tags').show('slow');
						       $('#twitter_tags').hide();
						       $('#list_tags').hide();
						       $('#feed_tags').hide();
						       $('#imgur_tags').hide();
						       $('#tumblr_tags').hide();
						       $('#reddit_tags').hide();
						       $('#webpage_tags').hide();
						    }
						    if($(this).val() == ".cListPost::ORIGIN_LIST.")
						    {
						       $('#instagram_tags').hide();
						       $('#youtube_tags').hide();
						       $('#amazon_tags').hide();
						       $('#facebook_tags').hide();
						       $('#pinterest_tags').hide();
						       $('#upload_tags').hide();
						       $('#twitter_tags').hide();
						       $('#list_tags').show('slow');
						       $('#feed_tags').hide();
						       $('#imgur_tags').hide();
						       $('#tumblr_tags').hide();
						       $('#reddit_tags').hide();
						       $('#webpage_tags').hide();
						    }
						    if($(this).val() == ".cListPost::ORIGIN_FEED.")
						    {
						       $('#instagram_tags').hide();
						       $('#youtube_tags').hide();
						       $('#amazon_tags').hide();
						       $('#facebook_tags').hide();
						       $('#pinterest_tags').hide();
						       $('#upload_tags').hide();
						       $('#twitter_tags').hide();
						       $('#list_tags').hide();
						       $('#feed_tags').show('slow');
						       $('#reddit_tags').hide();
						       $('#tumblr_tags').hide();
						       $('#imgur_tags').hide();
						       $('#webpage_tags').hide();
						    }
						    if($(this).val() == ".cListPost::ORIGIN_IMGUR.")
						    {
						       $('#instagram_tags').hide();
						       $('#youtube_tags').hide();
						       $('#amazon_tags').hide();
						       $('#facebook_tags').hide();
						       $('#pinterest_tags').hide();
						       $('#upload_tags').hide();
						       $('#twitter_tags').hide();
						       $('#list_tags').hide();
						       $('#feed_tags').hide();
						       $('#webpage_tags').hide();
						       $('#tumblr_tags').hide();
						       $('#reddit_tags').hide();
						       $('#imgur_tags').show('slow');
						    }
						    if($(this).val() == ".cListPost::ORIGIN_WEBPAGE.")
						    {
						       $('#instagram_tags').hide();
						       $('#youtube_tags').hide();
						       $('#amazon_tags').hide();
						       $('#facebook_tags').hide();
						       $('#pinterest_tags').hide();
						       $('#upload_tags').hide();
						       $('#twitter_tags').hide();
						       $('#list_tags').hide();
						       $('#feed_tags').hide();
						       $('#webpage_tags').hide();
						       $('#imgur_tags').hide();
						       $('#tumblr_tags').hide();
						       $('#reddit_tags').hide();
						       $('#webpage_tags').show('slow');
						    }
						    if($(this).val() == ".cListPost::ORIGIN_REDDIT.")
						    {
						       $('#instagram_tags').hide();
						       $('#youtube_tags').hide();
						       $('#amazon_tags').hide();
						       $('#facebook_tags').hide();
						       $('#pinterest_tags').hide();
						       $('#upload_tags').hide();
						       $('#twitter_tags').hide();
						       $('#list_tags').hide();
						       $('#feed_tags').hide();
						       $('#webpage_tags').hide();
						       $('#imgur_tags').hide();
						       $('#tumblr_tags').hide();
						       $('#reddit_tags').show('slow');
						       $('#webpage_tags').hide();
						    }
						    if($(this).val() == ".cListPost::ORIGIN_TUMBLR.")
						    {
						       $('#instagram_tags').hide();
						       $('#youtube_tags').hide();
						       $('#amazon_tags').hide();
						       $('#facebook_tags').hide();
						       $('#pinterest_tags').hide();
						       $('#upload_tags').hide();
						       $('#twitter_tags').hide();
						       $('#list_tags').hide();
						       $('#feed_tags').hide();
						       $('#webpage_tags').hide();
						       $('#imgur_tags').hide();
						       $('#tumblr_tags').show('slow');
						       $('#reddit_tags').hide();
						       $('#webpage_tags').hide();
						    }
						});

					});
");
*/
$this->registerJs("
			init.push(function () {
				$('#cposttemplate-origin_type').on('change', function() {
					$('#facebook_tags').hide();
					$('#pinterest_tags').hide();
					$('#amazon_tags').hide();
					$('#youtube_tags').hide();
					$('#instagram_tags').hide();
					$('#upload_tags').hide();
					$('#twitter_tags').hide();
					$('#list_tags').hide();
					$('#feed_tags').hide();
					$('#imgur_tags').hide();
					$('#tumblr_tags').hide();
					$('#reddit_tags').hide();
					$('#webpage_tags').hide();
					   
					$('.origin_type_tokens_'+$(this).val()).show('slow');   
				});

			});
");

?>

<div class="c-post-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'origin_type')->dropDownList([
        cListPost::ORIGIN_FACEBOOK => 'Facebook',
        cListPost::ORIGIN_PINTEREST => 'Pinterest',
        cListPost::ORIGIN_AMAZON => 'Amazon',
        cListPost::ORIGIN_YOUTUBE => 'YouTube',
        cListPost::ORIGIN_INSTAGRAM => 'Instagram',
        cListPost::ORIGIN_TWITTER => 'Twitter',
        cListPost::ORIGIN_TUMBLR => 'Tumblr',
        cListPost::ORIGIN_UPLOAD => 'Upload',
        cListPost::ORIGIN_FEED => 'Feed',
        cListPost::ORIGIN_WEBPAGE => 'Webpage',
        cListPost::ORIGIN_IMGUR => 'Imgur',
        cListPost::ORIGIN_REDDIT => 'Reddit',
        cListPost::ORIGIN_LIST => 'Existing List'
    ], ['prompt' => '-- Choose One --'])->label( $model->getAttributeLabel('origin_type').' <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="Choose which type of content you want to apply this Post Template to."></i>' ) ?>

    <?= $form->field($model, 'name')->textInput()->label( $model->getAttributeLabel('name').' <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="Add a name that will help you remember what the Post Template does."></i>' ) ?>
	
	<div class="clear-fix"></div>
	<div class="row showMoreLinkBlock">
		<a id="showMoreLink" href="javascript:void(0);">Show More</a>
	</div>	
	<div class="clear-fix"></div>
	
	<?= $form->field($model, 'description')->textarea(['rows' => 6, 'placeholder' => '(Just for your own notes)']) ?>
	
    <?php if(Yii::$app->session->get('campaign_id') != 0) { ?>
    <?= $form->field($model, 'campaigns')->checkbox(['label' => 'Make available to all Campaigns']); ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock('viewJs'); ?>
<script type="text/javascript">
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});
	$(document).ready(function(){
		$('#showMoreLink').on('click',function(){
			$('.field-cposttemplate-description').slideToggle();
			if( $(this).html() == 'Show More' ){
				$(this).html('Show Less');
			}
			else{
				$(this).html('Show More');
			}
		});
	});
</script>
<?php $this->endBlock(); ?>