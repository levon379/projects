<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var \common\models\LoginForm $model
 * @var \backend\controllers\ExportController $lists
 */
$this->title = 'Import from CSV';
$this->params['breadcrumbs'][] = 'Content';
$this->params['breadcrumbs'][] = $this->title;

$this->params['help']['message'] = 'Import posts from a CSV file.<br/><b>Header Fields: </b>text*, image_url*, scheduled_time, link, name (* = required)';

?>
<?php ob_start(); ?>
<?php $this->context->before_panel = ob_get_clean(); ?>
<?php
        $this->registerJs('
                init.push(function () {
                    var myDropzone = new Dropzone("#dropzonejs-example", {
                        url: "'. Yii::$app->urlManager->createUrl('content/csv') .'",
                        paramName: "file", // The name that will be used to transfer the file
                        maxFiles: 1,
                        maxfilesexceeded: function(file) {
                            this.removeAllFiles();
                            this.addFile(file);
                        },
                        addRemoveLinks : true,
                        dictResponseError: "Can\'t upload file!",
                        autoProcessQueue: true,
                        acceptedFiles: ".csv",
                        thumbnailWidth: 138,
                        thumbnailHeight: 120,
                        previewTemplate: \'<div class="dz-preview dz-file-preview"><div class="dz-details"><div class="dz-filename"><span data-dz-name></span></div><div class="dz-size">File size: <span data-dz-size></span></div><div class="dz-thumbnail-wrapper"><div class="dz-thumbnail"><img data-dz-thumbnail><span class="dz-nopreview">No preview</span><div class="dz-success-mark"><i class="fa fa-check-circle-o"></i></div><div class="dz-error-mark"><i class="fa fa-times-circle-o"></i></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div></div></div><div class="progress progress-striped active"><div class="progress-bar progress-bar-success" data-dz-uploadprogress></div></div></div>\',
                    });

                    myDropzone.on("addedfile", function (e) {
                        
                    });
                    
                    myDropzone.on("removedfile", function (e) {
                        $("#repost_button").attr("disabled", "disabled").val("Add to list");
                        $("#results-container").html("");
                        $("#add_to_list_form").css("display", "none");
                    });
                    
                    myDropzone.on("error", function (e) {
                        
                    });
                    
                    myDropzone.on("queuecomplete", function (e) {
                        
                    });
                    
                    myDropzone.on("success", function (o, e) {
                        myDropzone.processQueue.bind(myDropzone);
                        $("#results-container").html(e);
                        $("#add_to_list_form").css("display", "block");
                        $("#mason-container").masonry();
                        $("#results-container img.photo-post").load(function() {
                            $("#mason-container").masonry();
                        });
                        $("#results-container img.photo-post").error(function() {
                            $("#mason-container").masonry();
                        });
                    });
                    
                    myDropzone.on("sending", function(file, xhr, formData) {
                        $("#repost_button").attr("disabled", "disabled");
                        $("#results-container").html("");
                        $("#add_to_list_form").css("display", "none");
                    });
                
                    $(document.body).on("change", "#content_list_id", function(e) {
                        num = $(".checkbox_activate").filter(":checked").length;
                        if(num > 0 && ($("#content_list_id").val() != "" || $("#new_list_name").val() != ""))
                        {
                            $("#repost_button").removeAttr("disabled", "disabled");
                        }
                        else
                        {
                            $("#repost_button").attr("disabled", "disabled");
                        }
                    });
                
                    $(document.body).on("input propertychange paste", "#new_list_name", function(e) {
                            num = $(".checkbox_activate").filter(":checked").length;
                            if((num > 0) && ($("#content_list_id").val() != "" || $("#new_list_name").val() != ""))
                            {
                                $("#repost_button").removeAttr("disabled", "disabled");
                            }
                            else
                            {
                                $("#repost_button").attr("disabled", "disabled");
                            }
                    });
                    
                    jQuery("body").on("click", ".select_all", function() {
                        $(".select_button").click();
                        return false;
                    });
                
                    $(function () {
                      $("[data-toggle=\"tooltip\"]").tooltip()
                    });
                    
                    $(document.body).on("click", ".select_button", function(e) {
                        e.preventDefault();
                        $(this).parent().parent().parent().toggleClass("post_selected").toggleClass("post_unselected");
                        $(this).children("i").toggleClass("fa-square").toggleClass("fa-check");
                        $(this).toggleClass("btn-primary").toggleClass("btn-success");
                        checkbox = $(this).prev();
                        checkbox.prop("checked", !checkbox.prop("checked"));
                        num = $(".checkbox_activate").filter(":checked").length;
                        if(num > 0 && $("#content_list_id").val() != "" || $("#new_list_name").val() != "")
                        {
                            $("#repost_button").removeAttr("disabled", "disabled");
                        }
                        else
                        {
                            $("#repost_button").attr("disabled", "disabled");
                        }
                        $("#repost_button").val("Add " + num + " to list");
                    });
                    
                    $(document.body).on("click", ".hide_post", function(e) {
                        e.preventDefault();
                        $(this).parent().parent().parent().hide();
                    });
                    
                    $("#add_to_list_form").bind("submit", function(e) {
                        $("#repost_button").attr("disabled", "disabled").val("Please wait. Adding to list...");
                        this.submit();
                    });

                    jQuery(".switcher-primary").switcher({
                        "on_state_content": "Selected",
                        "off_state_content": "Not Selected"
                    });
                    
                });
                
            ');
        
        $this->registerCss('
            .switcher {
                height: 24px;
                width: 100px;
            }

            .post_selected {
                background-color: #E3FFD9;
            }

            .post_unselected {
                background-color: #ffffff;
            }
        ');
?>
            <form id="dropzonejs-example" class="dropzone-box dz-clickable">
                <div class="dz-default dz-message">
                    <i class="fa fa-upload"></i>
                    Drop file in here<br><span class="dz-text-small">or click to pick manually</span>
                </div>
            </form>
        </div>
    </div>

    <form method="post" action="<?=Yii::$app->urlManager->createUrl('import/csv')?>" id="add_to_list_form" style="display:none;">

            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Parsed Posts</span>
	
                    <div class="panel-heading-controls">
						<!--
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary active">
                                <input type="radio" name="dim-options" id="dim-off" autocomplete="off" class="garlic-auto-save"> Off
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="dim-options" id="dim-tiny" autocomplete="off" class="garlic-auto-save"> Tiny
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="dim-options" id="dim-small" autocomplete="off" class="garlic-auto-save"> Small
                            </label>
                        </div>
						-->
                        <button class="btn btn-warning btn-outline select_all"><span class="fa fa-refresh"></span>&nbsp;&nbsp;Select
                            All
                        </button>
                    </div>
                </div>

                <div class="panel-body" id="results-container">

                </div>

                <div class="panel-footer">
                    <div class="panel-footer-controls">
                        <button class="btn btn-warning btn-outline select_all"><span class="fa fa-refresh"></span>&nbsp;&nbsp;Select
                            All
                        </button>
                    </div>
                    <div style="clear: both"></div>
                </div>
            </div>

            <?php echo $this->render('_add_to_list', ['source' => 'csv']); ?>
    </form>