<?php

use yii\helpers\Html;
use common\models\cListPost;
use yii\widgets\ActiveForm;


/**
 * @var yii\web\View $this
 * @var common\models\cPostType $model
 */

$this->title = 'Update Post Template Basics';
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = ['label' => 'Post Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';

$this->registerCss('
.potemp-basic-update{display:none;}
.dropzone-block{display:none;}
.dz-upload-error{margin-left:13px;}
');
?>
		<div class="row col-md-12 showBasicUpdate">
			<?=$model->name?> (<?=cListPost::getOriginNameFromId($model->origin_type)?>) &nbsp;  <a id="showBasicUpdateLink" href="javascript:void(0);"><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="bottom" title="Click to edit Name, Content Source & Description"></i></a>
		</div>	
		<?php
			$this->registerJs("$(document).ready(function(){
				$('#showBasicUpdateLink').on('click',function(){
					$('.potemp-basic-update').slideToggle();
					$(this).closest('.showBasicUpdate').hide();
				});
			});");
		?>
		
        <div class="potemp-basic-update c-post-template-update">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>

    </div></div>

<div class="panel modify-template-panel">
    <div class="panel-heading">
        <span class="panel-title">Modify Template</span>
		<?php
		$tempTxtCls='active';
		$tempDefImgCls='';
		$footerPanelCls=' hidden';
		if(!isset($_GET['template_pill']) || $_GET['template_pill'] == '#pill_text'){
			$tempTxtCls='active';
			$tempDefImgCls='';
		}
		
		if(isset($_GET['tab'])&&$_GET['tab']=='default_images'){
			$tempTxtCls='';
			$tempDefImgCls='active';	
			$footerPanelCls='';
		}
		
		?>
        <ul class="nav nav-tabs nav-tabs-xs">
            <li class="<?=$tempTxtCls?>">
                <a href="#pill_text" data-toggle="tab">Text</a>
            </li>
            <li class="">
                <a href="#pill_image" data-toggle="tab">Image</a>
            </li>
			<li class="<?=$tempDefImgCls?>">
                <a href="#pill_default_images" data-toggle="tab">Default Images</a>
            </li>
        </ul>
    </div>

    <div class="panel-body">
        <div class="tab-content" style="margin-top:10px">

            <div class="tab-pane <?=$tempTxtCls?>" id="pill_text">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'template')->textarea(['rows' => 6]) ?>
				<div class="small text-primary"><i class="glyphicon glyphicon-info-sign"></i> You can have variations of texts to display alternatively. For e.g. [[Alternate Text 1|Alternate Text 2|Alternate Text 3]] will use one of the 3 variations of text alternatively.</div>
				
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

            <div class="tab-pane<?php if(isset($_GET['template_pill']) && $_GET['template_pill'] == '#pill_image') { ?> active<?php } ?>" id="pill_image">

                <?php
                $this->registerJsFile('@web' . '/js/fabric.js');

                $additional_javascript = "
                   lockMovement(canvas);
                ";
                $js = Yii::$app->postradamus->create_canvas_from_image(Yii::$app->params['imageUrl'] . 'fruit.jpg', $model->image_template, $additional_javascript);
                $this->registerJs($js);

                echo Yii::$app->controller->renderPartial('/post/_edit_image', ['redirect_url' => Yii::$app->urlManager->createUrl(['post-template/update', 'id' => $model->id]), 'save_url' => Yii::$app->urlManager->createUrl('post-template/save-image-template'), 'id' => $model->id]);
                ?>
                <div class="form-group">
                    <input type="submit" name="save" id="save" value="Update" class="btn btn-primary">
                </div>


            </div>
        
			<div class="tab-pane <?=$tempDefImgCls?>" id="pill_default_images">
				<div class="row">
					<div class="col-md-12">
						<div class="currentDefaultImages">
							<div id="mason-container">
								<?php
								$displayedImages=0;
								if(isset($default_images)&&is_array($default_images)){
									foreach($default_images as $default_image){
										$tempImagePath=Yii::$app->params['imagePath'].'post-templates/'.Yii::$app->user->id.'/'. $model->id.'/'.$default_image->file_name;
										$tempImageUrl=Yii::$app->params['imageUrl'].'post-templates/'.Yii::$app->user->id.'/'. $model->id.'/'.$default_image->file_name;
										if(is_file($tempImagePath)){
											echo '<div class="box" data-rec-id="'.$default_image->id.'">';
												echo '<div class="thumbnail post_unselected">';
													echo '<div>';
														echo '<img src="'.$tempImageUrl.'" style="width:100%;border-radius:4px;"/>';
													echo '</div>';	
													echo '<div style="text-align: center; color: gray !important; font-size:10px">';
														echo '<a href="javascript:void(0);">'.$default_image->file_name.'</a>' ;
													echo '</div>';
													echo '<div class="row">' ;
														echo '<div class="col-md-12" style="text-align: right">';
															echo '<a href="javascript:void(0);" data-id="'.$default_image->id.'" 
															data-delete-url="'.Yii::$app->urlManager->createUrl(['post-template/delete-default-image']).'" class="btn btn-sm btn-danger delete-default-image" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>';
														echo '</div>';
													echo '</div>';
												echo '</div>';	
											echo '</div>';	
											$displayedImages++;
										}
									}
								}
								?>
							</div>
							<div class="row col-md-12">
								<?php
								if(empty($displayedImages)){
									echo '<span class="text-danger">No images to display.</span>' ;
								}
								?>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="dropzone-block">
							<br/>
							<?=Html::beginForm( '' , 'post' , ['enctype'=>"multipart/form-data",'id'=>"dropzonejs-example",'class'=>"dropzone-box dz-clickable"] )?>
								<input type="hidden" id="dz_post_template_id" name="post_template_id" value="<?=$model->id?>" />
								<div class="dz-default dz-message">
									<i class="fa fa-upload"></i>
									Drop files in here<br><span class="dz-text-small">or click to pick manually</span>
								</div>
							<?=Html::endForm()?>
							<br/>
							<div class="">
								<input type="button" class="btn btn-primary" id="uploadDefaultImages" value="Upload Image(s)"/>
							</div>
						</div>	
					</div>
				</div>	
			</div>
		</div>
	</div>
	
	<div class="panel-footer<?=$footerPanelCls?>">
        <a id="showAddDefaultImagesLink" class="btn btn-primary btn-sm" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Click to add default images">Add Default Image(s)</a>
    </div>
</div>

<b>Tokens <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="Mouse over the token for more info."></i></b>
<div style="color:gray;" class="well">
	<div id="facebook_tags"<?php if($model->origin_type != cListPost::ORIGIN_FACEBOOK) { ?> style="display:none"<?php } ?> class="origin_type_tokens_<?=cListPost::ORIGIN_FACEBOOK?>">
		<?php 
			$fbTokens=[];
			$fbTokens['id'] = 'Unique ID of the post (assigned by Facebook)';
			$fbTokens['name'] = 'Coming soon';			
			$fbTokens['text'] = 'The user written text for the post';			
			$fbTokens['page_url'] = 'The URL to the Facebook page the post came from';			
			$fbTokens['image_url'] = 'The URL of the image (if there is one) for the Facebook post';			
			$fbTokens['author_name'] = 'The name of the person who created the post';			
			$fbTokens['post_url'] = 'The URL to the Facebook post itself';			
			$fbTokens['link'] = 'The clean and shortened URL to the Facebook post itself';$fbTokens['author_profile_url'] = 'The URL to the personal profile page who authored the post';			
			$fbTokens['author_image_url'] = 'The URL of the image of the person who authored the post';
			$fbTokens['like_count'] = 'The number of likes the post has received';			
			$fbTokens['share_count'] = 'The number of shares the post has received';
			$fbTokens['comment_count'] = 'The number of comments the post has received';			
			if(is_array($fbTokens)){
				foreach($fbTokens as $tempToken => $tempDesc ){
					echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$tempDesc.'">{'.$tempToken.'}</span> ';
				}
			}
		?>
        
    </div>
    <div id="pinterest_tags"<?php if($model->origin_type != cListPost::ORIGIN_PINTEREST) { ?> style="display:none"<?php } ?> class="origin_type_tokens_<?=cListPost::ORIGIN_PINTEREST?>">
		<?php 
			$pintTokens=[];
			$pintTokens['id'] = 'Unique ID of the post (assigned by Pinterest)';
			$pintTokens['name'] = 'Coming soon';			
			$pintTokens['text'] = 'The user written text for the post';			
			$pintTokens['keyword'] = 'The keywords used to find the post';	
			$pintTokens['post_url'] = 'The URL to the Pinterest post itself';	
			$pintTokens['image_url'] = 'The URL of the image for the Pinterest post';			
			$pintTokens['author_name'] = 'The name of the person who created the post';			
			$pintTokens['author_profile_url'] = 'The URL to the personal profile page who authored the post';			
			$pintTokens['author_image_url'] = 'The URL of the image of the person who authored the post';
			$pintTokens['like_count'] = 'The number of likes the post has received';			
			$pintTokens['repin_count'] = 'The number of repins the post has received';
			$pintTokens['comment_count'] = 'The number of comments the post has received';			
			if(is_array($pintTokens)){
				foreach($pintTokens as $tempToken => $tempDesc ){
					echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$tempDesc.'">{'.$tempToken.'}</span> ';
				}
			}
		?>
	</div>
    <div id="amazon_tags"<?php if($model->origin_type != cListPost::ORIGIN_AMAZON) { ?> style="display:none"<?php } ?> class="origin_type_tokens_<?=cListPost::ORIGIN_AMAZON?>">
		<?php 
			$amzTokens=[];
			$amzTokens['id'] = 'Unique ID of the post (assigned by Amazon)';
			$amzTokens['name'] = 'Coming soon';			
			$amzTokens['title'] = 'The title of the book or product';			
			$amzTokens['text'] = 'A snippet of the summary of the book or product';			
			$amzTokens['url'] = 'The URL to the book or product';			
			$amzTokens['image_url'] = 'The URL of the image for the book or product' ;
			$amzTokens['author_name'] = 'The name of the author or creator of the book or product';			
			$amzTokens['sales_rank'] = 'How popular the book or product is in terms of sales';if(is_array($amzTokens)){
				foreach($amzTokens as $tempToken => $tempDesc ){
					echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$tempDesc.'">{'.$tempToken.'}</span> ';
				}
			}
		?>
    </div>
    <div id="youtube_tags"<?php if($model->origin_type != cListPost::ORIGIN_YOUTUBE) { ?> style="display:none"<?php } ?> class="origin_type_tokens_<?=cListPost::ORIGIN_YOUTUBE?>">
        <?php 
			$ytTokens=[];
			$ytTokens['id'] = 'Unique ID of the post (assigned by YouTube)';
			$ytTokens['name'] = 'Coming soon';			
			$ytTokens['title'] = 'The title of the video';			
			$ytTokens['text'] = 'The user written description for the video';			
			$ytTokens['url'] = 'The URL to the video';			
			$ytTokens['image_url'] = 'The URL of the thumbnail image of the video' ;
			$ytTokens['likes'] = 'The number of likes the video has received';			
			$ytTokens['views'] = 'The number of views the video has received';
			$ytTokens['comments'] = 'The number of comments the video has received';
			$ytTokens['embed_code'] = 'The YouTube video embed code';
			if(is_array($ytTokens)){
				foreach($ytTokens as $tempToken => $tempDesc ){
					echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$tempDesc.'">{'.$tempToken.'}</span> ';
				}
			}
		?>
    </div>
    <div id="instagram_tags"<?php if($model->origin_type != cListPost::ORIGIN_INSTAGRAM) { ?> style="display:none"<?php } ?> class="origin_type_tokens_<?=cListPost::ORIGIN_INSTAGRAM?>">
        <?php 
			$instTokens=[];
			$instTokens['id'] = 'Unique ID of the post (assigned by Instagram)';
			$instTokens['name'] = 'Coming soon';			
			$instTokens['text'] = 'The user written text for the photo or video';			
			$instTokens['image_url'] = 'The URL of the photo or screenshot of the video';$instTokens['author_name'] = 'The name of the person who uploaded the photo or video';			
			$instTokens['author_profile_url'] = 'The URL to the personal profile page who uploaded the photo or video';			
			$instTokens['author_image_url'] = 'The URL of the image of the person who uploaded the photo or video';
			$instTokens['like_count'] = 'The number of likes the photo or video has received';$instTokens['comment_count'] = 'The number of comments the photo or video has received';			
			if(is_array($instTokens)){
				foreach($instTokens as $tempToken => $tempDesc ){
					echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$tempDesc.'">{'.$tempToken.'}</span> ';
				}
			}
		?>
    </div>
    <div id="twitter_tags"<?php if($model->origin_type != cListPost::ORIGIN_TWITTER) { ?> style="display:none"<?php } ?> class="origin_type_tokens_<?=cListPost::ORIGIN_TWITTER?>">
        <?php 
			$twtTokens=[];
			$twtTokens['id'] = 'Unique ID of the post (assigned by Twitter)';
			$twtTokens['name'] = 'Coming soon';			
			$twtTokens['text'] = 'The Tweet text';			
			$twtTokens['image_url'] = 'The URL of the image (if there is one)' ;
			$twtTokens['author_name'] = 'The name of the person who Tweeted the Tweet';			
			$twtTokens['author_profile_url'] = 'The URL to the personal profile page who Tweeted the Tweet';			
			$twtTokens['author_image_url'] = 'The URL of the image of the person who Tweeted the Tweet';
			$twtTokens['retweet_count'] = 'The number of Re-tweets the tweet has received';$twtTokens['favorite_count'] = 'The number of favorites the tweet has received';
			if(is_array($twtTokens)){
				foreach($twtTokens as $tempToken => $tempDesc ){
					echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$tempDesc.'">{'.$tempToken.'}</span> ';
				}
			}
		?>
    </div>
    <div id="upload_tags"<?php if($model->origin_type != cListPost::ORIGIN_UPLOAD) { ?> style="display:none"<?php } ?> class="origin_type_tokens_<?=cListPost::ORIGIN_UPLOAD?>">
        <?php 
			$upTokens=[];
			$upTokens['id'] = 'Unique ID of the image post (assigned by Postradamus)';
			$upTokens['name'] = 'Coming soon';			
			if(is_array($upTokens)){
				foreach($upTokens as $tempToken => $tempDesc ){
					echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$tempDesc.'">{'.$tempToken.'}</span> ';
				}
			}
		?>
    </div>
    <div id="list_tags"<?php if($model->origin_type != cListPost::ORIGIN_LIST) { ?> style="display:none"<?php } ?> class="origin_type_tokens_<?=cListPost::ORIGIN_LIST?>">
        <?php 
			$lstTokens=[];
			$lstTokens['id'] = 'Unique ID of the post (assigned by the Existing Post)';
			$lstTokens['name'] = 'Coming soon';
			$lstTokens['text'] = 'The text from the existing post';
			$lstTokens['link'] = 'The link from the existing post';
			$lstTokens['image_url'] = 'The image URL from the existing post';
			$lstTokens['scheduled_time'] = 'The scheduled time of the existing post';
			if(is_array($lstTokens)){
				foreach($lstTokens as $tempToken => $tempDesc ){
					echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$tempDesc.'">{'.$tempToken.'}</span> ';
				}
			}
		?>
    </div>
    <div id="feed_tags"<?php if($model->origin_type != cListPost::ORIGIN_FEED) { ?> style="display:none"<?php } ?> class="origin_type_tokens_<?=cListPost::ORIGIN_FEED?>">
        <?php 
			$feedTokens=[];
			$feedTokens['id'] = 'Unique ID of the feed article (assigned by the Feed)';
			$feedTokens['feed_title'] = 'The name of the feed';
			$feedTokens['feed_url'] = 'The URL of the feed itself (not the URL of the feed entry)';
			$feedTokens['feed_website_url'] = 'The URL of the website the feed came from';
			$feedTokens['name'] = 'Coming soon';			
			$feedTokens['title'] = 'The title of the article';			
			$feedTokens['text'] = 'A short snippet or summary of the article';			
			$feedTokens['text_raw'] = 'A short snippet or summary of the article without any HTML removed';			
			$feedTokens['created'] = 'The date when the article was created';			
			$feedTokens['modified'] = 'The date when the article was last modified';			
			$feedTokens['author_name'] = 'The name of the person who wrote the article';$feedTokens['author_url'] = 'The URL to the author\'s web site';			
			$feedTokens['author_image_url'] = 'The URL of the image of the author';
			$feedTokens['link'] = 'The URL of the feed article';
			$feedTokens['image_url'] = 'The URL of the main image of the article (if there is one)';			
			$feedTokens['url'] = 'Same as {link}';
			$feedTokens['comment_count'] = 'The number of comments the article has received';if(is_array($feedTokens)){
				foreach($feedTokens as $tempToken => $tempDesc ){
					echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$tempDesc.'">{'.$tempToken.'}</span> ';
				}
			}
		?>
    </div>
    <div id="reddit_tags"<?php if($model->origin_type != cListPost::ORIGIN_REDDIT) { ?> style="display:none"<?php } ?> class="origin_type_tokens_<?=cListPost::ORIGIN_REDDIT?>">
        <?php 
			$rdTokens=[];
			$rdTokens['id'] = 'Unique ID of the article (assigned by the Reddit)';
			$rdTokens['title'] = 'The title of the article';			
			$rdTokens['name'] = 'Coming soon';			
			$rdTokens['text'] = 'A short snippet or summary of the article';			
			$rdTokens['created'] = 'The date when the article was created';			
			$rdTokens['author_name'] = 'The name of the person who wrote the article';
			$rdTokens['image_url'] = 'The URL of the image of the article (if there is one)';$rdTokens['url'] = 'The URL of the feed article';
			$rdTokens['comment_count'] = 'The number of comments the article has received';
			$rdTokens['up_count'] = 'The number of up votes the article has received';
			if(is_array($rdTokens)){
				foreach($rdTokens as $tempToken => $tempDesc ){
					echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$tempDesc.'">{'.$tempToken.'}</span> ';
				}
			}
		?>
    </div>
    <div id="tumblr_tags"<?php if($model->origin_type != cListPost::ORIGIN_TUMBLR) { ?> style="display:none"<?php } ?> class="origin_type_tokens_<?=cListPost::ORIGIN_TUMBLR?>">
		<?php 
			$tmbTokens=[];
			$tmbTokens['id'] = 'Unique ID of the post (assigned by the Tumblr)';
			$tmbTokens['name'] = 'Coming soon';			
			$tmbTokens['text'] = 'A summary of the blog entry text';			
			$tmbTokens['image_url'] = 'The URL of the image associated with the blog entry (if there is one)';
			$tmbTokens['note_count'] = 'The number of notes the blog entry has received';
			$tmbTokens['created'] = 'The date when the blog entry was created';			
			$tmbTokens['post_url'] = 'The URL to the blog entry itself';
			$tmbTokens['blog_name'] = 'The name of the blog';
			$tmbTokens['blog_url'] = 'The URL to the blog';
			
			if(is_array($tmbTokens)){
				foreach($tmbTokens as $tempToken => $tempDesc ){
					echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$tempDesc.'">{'.$tempToken.'}</span> ';
				}
			}
		?>
    </div>

    <br />
    <small>Note: You can also limit the length of variables like this: {text:50} (this would only show the first 50 characters of the text).</small>

</div>

<?php ob_start(); ?>
<?php $this->context->before_panel = ob_get_clean(); ?>
<?php
$this->registerJs('
	$(document).ready(function(){
		$(".modify-template-panel").find(".nav-tabs").find("a[data-toggle=\"tab\"]").on("shown.bs.tab",function(e){
			if($(this).attr("href")=="#pill_default_images"){
				$(".modify-template-panel>.panel-footer").removeClass("hidden");
				$("#mason-container").find(".box").first().trigger("click");
			}
			else{
				$(".modify-template-panel>.panel-footer").addClass("hidden");
			}
		});
		
		$("#showAddDefaultImagesLink").on("click",function(){
			$(".dropzone-block").slideToggle();
			$(this).attr("disabled",true);
		});
		
		$(".delete-default-image").on("click",function(e){
			e.preventDefault();
			if(!confirm("Are you sure?")){
				return false;
			}
			var defaultImageId=$(this).data("id");
			var box=$(this).closest(".box");
			box.css("opacity",".1");
			var deleteUrl=$(this).data("delete-url");
			$.ajax({
				"url":deleteUrl, 
				"type":"POST",
				"dataType":"JSON", 
				"data":{id:defaultImageId}, 
				"success":function(result){
					if(result.success=="1"){
						box.fadeOut(300,function(){
							box.remove();
							if($("#mason-container").find(".box").length>0){
								$("#mason-container").find(".box").first().trigger("click");	
							}
							else{
								$("#mason-container").unbind();
								$("#mason-container").html("<span class=\"text-danger\">No images to display.</span>").css("height","auto");
							}
						});
					}
					else{
						alert("Error! While deleting default image.");
						box.css("opacity","1");
					}
				},
				"error":function(){alert("Error! While deleting default image.");box.css("opacity","1");},
			});
		});
	});
				
	init.push(function () {
		var myDropzone = new Dropzone("#dropzonejs-example", {
			url: "'. Yii::$app->urlManager->createUrl('post-template/default-images-upload') .'",
			paramName: "file", // The name that will be used to transfer the file
			maxFilesize:6, // MB
			addRemoveLinks : true,
			dictResponseError: "Can\'t upload file!",
			autoProcessQueue: false,
			acceptedFiles: ".jpg,.gif,.jpeg,.png,.JPG,.GIF,.JPEG,.PNG,.mp4,.mkv,.flv,.vob,.ogg,.avi,.mov,.wmv,.mpeg,.3gp,.MP4,.MKV,.FLV,.VOB,.0GG,.AVI,.MOV,.WMV,.MPEG,.3GP",
			thumbnailWidth: 138,
			thumbnailHeight: 120,
			previewTemplate: \'<div class="dz-preview dz-file-preview"><div class="dz-details"><div class="dz-filename"><span data-dz-name></span></div><div class="dz-size">File size: <span data-dz-size></span></div><div class="dz-thumbnail-wrapper"><div class="dz-thumbnail"><img data-dz-thumbnail><span class="dz-nopreview">No preview</span><div class="dz-success-mark"><i class="fa fa-check-circle-o"></i></div><div class="dz-error-mark"><i class="fa fa-times-circle-o"></i></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div></div></div><div class="progress progress-striped active"><div class="progress-bar progress-bar-success" data-dz-uploadprogress></div></div></div>\',
			resize: function(file) {
				var info = { srcX: 0, srcY: 0, srcWidth: file.width, srcHeight: file.height },
				srcRatio = file.width / file.height;
				if (file.height > this.options.thumbnailHeight || file.width > this.options.thumbnailWidth) {
					info.trgHeight = this.options.thumbnailHeight;
					info.trgWidth = info.trgHeight * srcRatio;
					if (info.trgWidth > this.options.thumbnailWidth) {
						info.trgWidth = this.options.thumbnailWidth;
						info.trgHeight = info.trgWidth / srcRatio;
					}
				} else {
					info.trgHeight = file.height;
					info.trgWidth = file.width;
				}
				return info;
			}
		});
		myDropzone.on("addedfile",function(e){
			var uploadButton=$("#uploadDefaultImages");
			uploadButton.attr("disabled",false);
		});
		myDropzone.on("removedfile", function (e){
			//alert("Remove File");
		});
		myDropzone.on("error", function (e) {
			var uploadButton=$("#uploadDefaultImages");
			$(".dz-upload-error").remove();
			$("<span class=\"text-danger dz-upload-error\">Error!</span>").insertAfter(uploadButton);
			uploadButton.attr("disabled",false);
			uploadButton.val("Try Again");
		});
		myDropzone.on("queuecomplete", function (e) {
			var uploadButton=$("#uploadDefaultImages");
			acceptedFilesCnt = 	this.getAcceptedFiles().length; 
			if(acceptedFilesCnt>0){
				uploadButton.replaceWith("<div class=\"alert alert-success\">Image(s) uploaded successfully. Please wait while the page is refreshing ...</div>");
				var queryStr=window.location.search;
				if(queryStr.indexOf("tab=default_images")>-1){
					window.location.reload(true);	
				}
				else{
					window.location.search=queryStr+"&tab=default_images";	
				}
			}
			else{
				uploadButton.attr("disabled",false);
				uploadButton.val("Try Again");
			}
		});
		myDropzone.on("success", myDropzone.processQueue.bind(myDropzone));
		myDropzone.on("sending", function(file, xhr, formData) {
			formData.append("post_template_id", $("#dz_post_template_id").val() );
		});
		
		$("#uploadDefaultImages").on("click",function(e){
			$(this).attr("disabled",true);
			$(this).val("Uploading ...");
			$(".dz-upload-error").remove();
			myDropzone.processQueue();	
		});
		
		$("#uploadDefaultImages").attr("disabled",true);
	});
');
?>