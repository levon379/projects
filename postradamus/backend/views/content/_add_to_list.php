<?php
use yii\helpers\Html;
use common\models\cList;
use yii\helpers\ArrayHelper;
use common\models\cPostType;
use common\models\cPostTemplate;
use common\models\cListPost;

$this->registerJs("
    $('#existing_list_radio').on('click', function () {
        $('#existing_list_div').show();
        $('#new_list_div').hide();
    });
    $('#new_list_radio').on('click', function () {
        $('#existing_list_div').hide();
        $('#new_list_div').show();
    });

    jQuery('#content_list_id').select2({
        allowClear: true,
        placeholder: '(Choose an existing list)'
    });
");
?>
<div class="panel">
    <div class="panel-heading">
        <span class="panel-title">Save to List</span>
    </div>
    <div class="panel-body">
        <!-- /14. $DROPZONEJS_FILE_UPLOADS -->

        <input type="hidden" name="keyword" value="<?=$keyword?>" />

        <div class="row">
            <div class="col-xs-12">
            <p style="margin-bottom:0"><input type="radio" id="existing_list_radio" name="list" value="1" checked="checked"> <label for="existing_list_radio">Existing List</label>&nbsp; <input type="radio" id="new_list_radio" name="list" value="2"> <label for="new_list_radio">New List</label> </p>
            <div id="existing_list_div">
                <?php
                $lists['Not Ready'] = yii\helpers\ArrayHelper::map(cList::findNotReady()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
                $lists['Ready'] = yii\helpers\ArrayHelper::map(cList::findReady()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
                $lists['Sending'] = yii\helpers\ArrayHelper::map(cList::findSending()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
                $lists['Sent'] = yii\helpers\ArrayHelper::map(cList::findSent()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
                ?>
                <?php echo Html::dropDownList('list_id', Yii::$app->session->get('last_used_list_id'), $lists, ['id' => 'content_list_id', 'prompt' => '', 'class' => 'form-control']); ?>
            </div>
            <div id="new_list_div" style="display:none">
                <input type="text" class="form-control" id="new_list_name" name="new_list_name" value="<?=htmlentities(Yii::$app->request->post('new_list_name'))?>" placeholder="(Your List Name Here)" />
            </div>
                <p><a href="#" class="show_more_link scroll_bottom" id="show_more_<?=str_replace(' ', '', strtolower($source))?>">More Options</a></p>
                <div class="more well well-sm" style="display:none;">
                    <div style="margin-bottom:8px">

                        <div id="post_link">
                            <label class="control-label" for="save-links"><?= Html::checkbox('save_links', Yii::$app->request->post('save_links'), ['id' => 'save-links']) ?> Save links <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="If the post has a link associated with it, Postradamus will save it as a Link Post"></span>
                        </div>

                    </div>

                    <div class="form-group field-facebooksearchform-posted_by">
                        <label class="control-label" for="facebooksearchform-assign_post_type">Assign a Post Type <a href="<?php echo Yii::$app->urlManager->createUrl('post-type/index'); ?>" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a></label>
                        <div style="margin-bottom:8px">
                            <?php $post_types = cPostType::find()->all();
                            if(count($post_types) == 0) {
                                ?>
                                <small style="color:gray">You don't have any Post Types.</small>
                            <?php } else { ?>
                                <?= Html::dropDownList('post_type_id', Yii::$app->request->post('post_type_id'), ArrayHelper::map($post_types, 'id', 'name'), ['id' => 'post_type_id', 'prompt' => '-- No Post Type --', 'class' => 'form-control']) ?>
                            <?php } ?>

                        </div>

                        <label class="control-label" for="facebooksearchform-template">Apply a Post Template <a href="<?php echo Yii::$app->urlManager->createUrl('post-template/index'); ?>" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a> <a href="#" id="refresh_post_templates"><span class="glyphicon glyphicon-refresh"></span></a></label>
                        <div style="margin-bottom:8px">

                            <div id="post_template_id">
                            </div>

                            <?php ob_start(); ?>
                            <script>
                                function getPostTemplateCheckboxes()
                                {
                                    $.get( "<?=Yii::$app->urlManager->createUrl(['post-template/ajax-list', 'source' => $source])?>", function( data ) {

                                        data = $.parseJSON(data);
                                        var $el = $("#post_template_id");
                                        $.each(data, function(value,key) {
                                            console.log(value, key);
                                            $el.append('<label>&nbsp;&nbsp;<input type="checkbox" name="post_template_id[]" value="' + value + '"> ' + key + '</label>');
                                        });

                                        //<small style="color:gray">You don't have any Post Templates for <?=ucwords($source)?>.</small>

                                    });
                                }
                                getPostTemplateCheckboxes();
                                $('#refresh_post_templates').on('click', function(e) {
                                    e.preventDefault();
                                    var $el = $("#post_template_id");
                                    $el.html('');
                                    getPostTemplateCheckboxes();
                                });
                            </script>
                            <?php
                            $script = ob_get_clean();
                            $this->registerJs(str_replace(["<script>", "</script>"], "", $script));
                            ?>
                        </div>

                        <input type="hidden" name="include_text" value="1" />
                        <input type="hidden" name="include_photos" value="1" />

                    </div>

                </div>
                <input type="submit" name="action" value="Add to list" disabled="disabled" id="repost_button" class="btn btn-primary btn-large" />
               </div>
            </div>
        </div>
    </div>