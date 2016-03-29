<?php
use yii\helpers\Html;
use common\models\cList;
use yii\helpers\ArrayHelper;
$this->params['breadcrumbs'][] = ['label' => 'Content'];
$this->params['breadcrumbs'][] = ['label' => 'Find on Computer'];
?>
<?php ob_start(); ?>
    <div style="background-color:#04AEDA; margin-bottom:15px; padding-left:20px; padding-top:12px; padding-bottom: 12px; border-radius: 4px;">
        <img src="<?=Yii::$app->params['imageUrl']?>Computer_Logo.png" style="max-height:30px" />
    </div>
<?php $this->context->before_panel = ob_get_clean(); ?>
        <?php

$this->title = 'Upload Images';
$this->params['help']['message'] = "Drag and drop images from your computer into Postradamus for a quick and easy mass upload!";
$this->params['help']['modal_body'] = '<iframe width="853" id="youtube-video" height="480" src="//www.youtube.com/embed/gZhj7-b5ThI" frameborder="0" allowfullscreen></iframe>';

            $this->registerJs('
                init.push(function () {
                    var myDropzone = new Dropzone("#dropzonejs-example", {
                        url: "'. Yii::$app->urlManager->createUrl('import/image-upload') .'",
                        paramName: "file", // The name that will be used to transfer the file
                        maxFilesize:6, // MB
                        addRemoveLinks : true,
                        dictResponseError: "Can\'t upload file!",
                        autoProcessQueue: false,
                        acceptedFiles: ".csv,.jpg,.gif,.jpeg,.png,.JPG,.GIF,.JPEG,.PNG,.mp4,.mkv,.flv,.vob,.ogg,.avi,.mov,.wmv,.mpeg,.3gp,.MP4,.MKV,.FLV,.VOB,.0GG,.AVI,.MOV,.WMV,.MPEG,.3GP",
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

                    $(document.body).on("change", "#content_list_id", function(e) {
                        if(myDropzone.getQueuedFiles().length > 0 && $("#content_list_id").val() != "")
                        {
                            $("#repost_button").removeAttr("disabled", "disabled");
                        }
                        else
                        {
                            $("#repost_button").attr("disabled", "disabled");
                        }
                    });
                    myDropzone.on("addedfile", function (e) {
                        if($("#content_list_id").val() != "" || $("#new_list_name").val() != "")
                            $("#repost_button").removeAttr("disabled", "disabled");
                    });
                    myDropzone.on("removedfile", function (e) {
                        if($("#content_list_id").val() != "" || $("#new_list_name").val() != "")
                            $("#repost_button").removeAttr("disabled", "disabled");

                        if(myDropzone.getQueuedFiles().length == 0)
                        {
                            $("#repost_button").attr("disabled", "disabled");
                        }
                    });
                    myDropzone.on("error", function (e) {
						errors = true;
                        if($("#content_list_id").val() == "")
                            $("#repost_button").attr("disabled", "disabled");

                        if(myDropzone.getQueuedFiles().length == 0)
                        {
                            $("#repost_button").attr("disabled", "disabled");
                        }
				    });
                    myDropzone.on("queuecomplete", function (e) {
						acceptedFilesCnt = 	this.getAcceptedFiles().length; 
						if( acceptedFilesCnt > 0 ){
							location.href="' . Yii::$app->urlManager->createUrl(['content/upload', 'done' => 1]) . '";
						}
				    });
                    $("#repost_button").on("click",function(e){
						$(this).attr( "disabled" , "disabled" );
						//myDropzone.processQueue.bind(myDropzone);	
						myDropzone.processQueue();	
						$("html, body").animate({
							scrollTop: parseInt($("#dropzonejs-example").offset().top)
						}, 600);
					});
                    myDropzone.on("success", myDropzone.processQueue.bind(myDropzone));
                    myDropzone.on("sending", function(file, xhr, formData) {
                        formData.append("list", $("input[name=list]:checked").val()); // Will send the filesize along with the file as POST data.
                        formData.append("content_list_id", $("#content_list_id").val()); // Will send the filesize along with the file as POST data.
                        formData.append("new_list_name", $("#new_list_name").val()); // Will send the filesize along with the file as POST data.
                        formData.append("post_type_id", $("#post_type_id").val()); // Will send the filesize along with the file as POST data.

                        $("input[name=\'post_template_id[]\']").each( function () {
                            if($(this).is(":checked"))
                            formData.append("post_template_id[]", $(this).val()); // Will send the filesize along with the file as POST data.
                        });

                        formData.append("include_text", 1); // Will send the filesize along with the file as POST data.
                        formData.append("include_photos", 1); // Will send the filesize along with the file as POST data.
                    });

                    $(document.body).on("input propertychange paste", "#new_list_name", function(e) {
                        num = myDropzone.getQueuedFiles().length;
                        if((num > 0) && ($("#content_list_id").val() != "" || $("#new_list_name").val() != ""))
                        {
                            $("#repost_button").removeAttr("disabled", "disabled");
                        }
                        else
                        {
                            $("#repost_button").attr("disabled", "disabled");
                        }
                    });
                });
            ');
        ?>
        <!-- / Javascript -->


                <form id="dropzonejs-example" class="dropzone-box dz-clickable">
                    <div class="dz-default dz-message">
                        <i class="fa fa-upload"></i>
                        Drop files in here<br><span class="dz-text-small">or click to pick manually</span>
                    </div>
                </form>
            </div>
        </div>

        <?php echo $this->render('_add_to_list', ['source' => 'upload']); ?>