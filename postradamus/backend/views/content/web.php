<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use common\models\cList;

$this->params['breadcrumbs'][] = ['label' => 'Content'];
$this->params['breadcrumbs'][] = ['label' => 'Find on Web'];
$this->params['breadcrumbs'][] = ucwords($source);

$extras = '';
if (!isset($_GET['facebook_search_pill']) || (isset($_GET['facebook_search_pill']) && ($_GET['facebook_search_pill'] == '#pill_other_pages' || $_GET['facebook_search_pill'] == '#pill_my_pages' || $_GET['facebook_search_pill'] == '#pill_saved_pages'))) {
    $extras = "$('#extras').show();";
}
$this->beginBlock('viewJs'); ?>
<script type="text/javascript">
    function post_now(param)
    {
        var model_id = param;
        var input_values = [];
        $('#post_now_div_'+model_id).parent().parent().find('.caption input').each(function(){
            var key = $(this).attr('name');
            var values = {};
            values[key] = $(this).val() ;
            input_values.push(values);
        });
        $('#post_now_div_'+model_id).parent().parent().find('.caption textarea').each(function(){
            var key = $(this).attr('name');
            var values = {};
            values[key] = $(this).val() ;
            input_values.push(values);
        });

        console.log(input_values)
        var url = '<?=Yii::$app->urlManager->createUrl('post/save-post-now-data') ?>';
        var jsonString = JSON.stringify(input_values);
        $.post(url,{post_data : jsonString,model_id:model_id,post_from:'<?=$source?>'},function(result){
            window.open('<?=Yii::$app->urlManager->createUrl('post/post-now') ?>', '_blank');
        });

    }
</script>
<?php $this->endBlock(); ?>

<?php
$this->registerJs("




$(function() {

    $('#save-search').on('click', function(e) {
    e.preventDefault();
       if($('#save-icon').hasClass('fa-square-o'))
       {
           $.ajax('" . Yii::$app->urlManager->createUrl('content/save-search') . "', {
               data: {
                    source: '$source',
                    fb_type: '$fb_type',
                    search_value: '".addslashes($save_search_value)."',
                    name: '".addslashes($save_name)."'
               },
               method: 'post',
               dataType: 'json'
            }).done(function(data) {

            });
            $(this).removeClass('btn-default').addClass('btn-success');
            $('#save-icon').removeClass('fa-square-o').addClass('fa-check-square-o');
       }
       else
       {
           $.ajax('" . Yii::$app->urlManager->createUrl('content/forget-search') . "', {
               data: {
                    source: '$source',
                    fb_type: '$fb_type',
                    search_value: '".addslashes($save_search_value)."',
                    name: '".addslashes($save_name)."'
               },
               method: 'post',
               dataType: 'json'
            }).done(function(data) {

            });
            $(this).removeClass('btn-success').addClass('btn-default');
            $('#save-icon').removeClass('fa-check-square-o').addClass('fa-square-o');
       }
    });

    $('#content-form').bind('submit', function(e) {
        $('#submit_button').attr('disabled', 'disabled').html('Please wait. Searching...');
        this.submit();
    });

    $('#add_to_list_form').bind('submit', function(e) {
        $('#repost_button').attr('disabled', 'disabled').val('Please wait. Adding to list...');
        this.submit();
    });

    $(document.body).on('input propertychange paste', '#new_list_name', function(e) {
        num = $('.checkbox_activate').filter(':checked').length;
        if((num > 0) && ($('#content_list_id').val() != '' || $('#new_list_name').val() != ''))
        {
            $('#repost_button').removeAttr('disabled', 'disabled');
        }
        else
        {
            $('#repost_button').attr('disabled', 'disabled');
        }
    });

    jQuery('.switcher-primary').switcher({
        'on_state_content': 'Selected',
        'off_state_content': 'Not Selected'
    });

    jQuery('.hide_post').on('click', function(e) {
        e.preventDefault();
		if($(this).parent().parent().parent().hasClass('post_selected')){
			$(this).parent().parent().parent().find('.select_button').trigger('click');
		}
        $(this).parent().parent().parent().css('opacity','0.1');
		$(this).parent().parent().parent().css('pointer-events','none');
    });

    $(document.body).on('click', '.select_button', function(e) {
        e.preventDefault();
        if($(this).parent().parent().parent().css('opacity') != '0.2')
        {
            $(this).parent().parent().parent().toggleClass('post_selected').toggleClass('post_unselected');
            $(this).children('i').toggleClass('fa-square').toggleClass('fa-check');
            $(this).toggleClass('btn-primary').toggleClass('btn-success');
            checkbox = $(this).prev();
            checkbox.prop('checked', !checkbox.prop('checked'));
            num = $('.checkbox_activate').filter(':checked').length;
            if(num > 0 && $('#content_list_id').val() != '' || $('#new_list_name').val() != '')
            {
                $('#repost_button').removeAttr('disabled', 'disabled');
            }
            else
            {
                $('#repost_button').attr('disabled', 'disabled');
            }
            $('#repost_button').val('Add ' + num + ' to list');
        }
    });

    $(document.body).on('change', '#content_list_id', function(e) {
        num = $('.checkbox_activate').filter(':checked').length;
        if(num > 0 && ($('#content_list_id').val() != '' || $('#new_list_name').val() != ''))
        {
            $('#repost_button').removeAttr('disabled', 'disabled');
        }
        else
        {
            $('#repost_button').attr('disabled', 'disabled');
        }
    });

    jQuery('#facebooksearchform-from_page1').select2({
        allowClear: true,
        placeholder: 'Select a Page'
    });

    jQuery('#facebooksearchform-from_group1').select2({
        allowClear: true,
        placeholder: 'Select a Group'
    });

    jQuery('#facebooksearchform-from_group3').select2({
        allowClear: true,
        placeholder: 'Select a Group'
    });

    jQuery('#facebooksearchform-from_page3').select2({
        allowClear: true,
        placeholder: 'Select a Page'
    });

    $(document.body).on('change', '#facebooksearchform-from_page1', function(){
        $('#page_id').val($(this).val());
    });

    $(document.body).on('change', '#facebooksearchform-from_group1', function(){
        $('#group_id').val($(this).val());
    });

    $(document.body).on('change', '#from_page2', function(){
        $('#page_id').val($(this).val());
    });

    $(document.body).on('change', '#from_group2', function(){
        $('#group_id').val($(this).val());
    });

    $(document.body).on('change', '#feed1', function(){
        $('#feed_url').val($(this).val());
    });

    $(document.body).on('change', '#feed2', function(){
        $('#feed_url').val($(this).val());
    });

    $(document.body).on('change', '#feed3', function(){
        $('#feed_url').val($(this).val());
    });

    createSelect2Page(jQuery('#from_page2'));
    function createSelect2Page(e) {
        e.select2({
            placeholder: 'Search for a Facebook Page',
            minimumInputLength: 3,
            id: function(obj) {
            return obj.id; // use slug field for id
        },
            ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
              quietMillis: 1500,
               url: '" . Yii::$app->urlManager->createUrl('content/facebook-search-pages') . "',
                  dataType: 'json',
                  data: function (term, page) {
                     return {
                         term: term, // search term
                         access_token: '" . (isset($_SESSION['fb_token']) ? $_SESSION['fb_token'] : '') . "'
                     };
                  },
                  results: function (data, page) { // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to alter remote JSON data
                    return {results: data.data};
                  }
               },
               initSelection: function(element, callback) {
               // the input tag has a value attribute preloaded that points to a preselected movie's id
               // this function resolves that id attribute to an object that select2 can render
               // using its formatResult renderer - that way the movie name is shown preselected
               var id=$(element).val();
               if (id!=='') {
                   $.ajax('" . Yii::$app->urlManager->createUrl('content/facebook-lookup-page') . "', {
                       data: {
                            id: id,
                               access_token: '" . (isset($_SESSION['fb_token']) ? $_SESSION['fb_token'] : '') . "'
                       },
                       dataType: 'json'
                       }).done(function(data) {
                           callback(data);
                       });
                }
            },
            formatResult: facebookPageFormatResult, // omitted for brevity, see the source of this page
            formatSelection: facebookPageFormatSelection,  // omitted for brevity, see the source of this page
            dropdownCssClass: 'bigdrop', // apply css that makes the dropdown taller
            allowClear: true,
            escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
        })
    }

    function facebookPageFormatResult(page) {
        var markup = '';

        //if(page.administrator)
        //{
        //   admin_text = ' (Administrator)';
        //}
        //else
        //{
           admin_text = '';
        //}

        markup = '<span class=\"_6i1\">';
        markup += '<img class=\"_20h\" alt=\"\" src=\"' + page.picture.data.url + '\">';
        markup += '<span class=\"_7gk\">';
        markup += '<span class=\"_53ad _55y-\">';
        markup += '<span class=\"fragmentEnt\" style=\"margin-left:10px\"><b>' + page.name + admin_text + '</b></span>';
        markup += '<span class=\"_53a9\">';
        markup += '<span class=\"_53aa\"><span class=\"_53ab\"> · ' + page.likes + ' like this</span></span>';
        markup += '<span class=\"_53aa\"><span class=\"_53ab\"> · ' + page.talking_about_count + ' talking about this</span></span>';
        markup += '</span>';
        markup += '</span>';
        markup += '</span>';

        return markup;
    }

    function facebookPageFormatSelection(page) {
        if(typeof page.data !== 'undefined') {
            return page.data[0].name;
        }
        if(typeof page !== 'undefined') {
            return page.name;
        }
    }

    createSelect2Group(jQuery('#from_group2'));
    function createSelect2Group(e) {
        e.select2({
            placeholder: 'Search for a Facebook Group',
            minimumInputLength: 3,
            id: function(obj) {
            return obj.id; // use slug field for id
        },
            ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: '" . Yii::$app->urlManager->createUrl('content/facebook-search-groups') . "',
              quietMillis: 1500,
                dataType: 'json',
                  data: function (term, page) {
                     return {
                         term: term, // search term
                         access_token: '" . (isset($_SESSION['fb_token']) ? $_SESSION['fb_token'] : '') . "'
                     };
                  },
                results: function (data, group) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data.data};
                }
            },
            initSelection: function(element, callback) {
            // the input tag has a value attribute preloaded that points to a preselected movie's id
            // this function resolves that id attribute to an object that select2 can render
            // using its formatResult renderer - that way the movie name is shown preselected
            var id=$(element).val();
            if (id!=='') {
                   $.ajax('" . Yii::$app->urlManager->createUrl('content/facebook-lookup-group') . "', {
                       data: {
                            id: id,
                               access_token: '" . (isset($_SESSION['fb_token']) ? $_SESSION['fb_token'] : '') . "'
                       },
                        dataType: 'json'
                    }).done(function(data) { callback(data); });
                }
        },
            formatResult: facebookGroupFormatResult, // omitted for brevity, see the source of this page
            formatSelection: facebookGroupFormatSelection,  // omitted for brevity, see the source of this page
            dropdownCssClass: 'bigdrop', // apply css that makes the dropdown taller
            allowClear: true,
            escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
        })
    }

    function facebookGroupFormatResult(group) {
        var markup = '';

        markup = '<span class=\"_6i1\">';

        if(typeof group.cover !== 'undefined')
        markup += '<img class=\"_20h\" alt=\"\" width=\"50\" height=\"50\" src=\"' + group.cover.source + '\">';
        else
        markup += '<img class=\"_20h\" alt=\"\" width=\"50\" height=\"50\" src=\"' + group.picture.data.url + '\">';

        markup += '<span class=\"_7gk\">';
        markup += '<span class=\"_53ad _55y-\">';
        markup += '<span class=\"fragmentEnt\" style=\"margin-left:10px\"><b>' + group.name + '</b></span>';
        markup += '</span>';
        markup += '</span>';
        markup += '</span>';

        return markup;
    }

    function facebookGroupFormatSelection(group) {
        if(typeof group.data !== 'undefined') {
            return group.data[0].name;
        }
        if(typeof group !== 'undefined') {
            return group.name;
        }
    }

    createSelect2Feed(jQuery('#feed2'));
    function createSelect2Feed(e) {
        e.select2
        ({
           placeholder: 'Search for a Feed',
           minimumInputLength: 3,

           id: function(obj) {
               return obj.url; // use slug field for id
           },

           ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
              url: '" . Yii::$app->urlManager->createUrl('content/feed-search') . "',
              dataType: 'json',
              quietMillis: 1500,
              data: function (term, feed) {
                 return {
                     query: term, // search term
                 };
              },
              results: function (data, feed) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data.responseData.entries};
              }
           },

           initSelection: function(element, callback) {
               // the input tag has a value attribute preloaded that points to a preselected movie's id
               // this function resolves that id attribute to an object that select2 can render
               // using its formatResult renderer - that way the movie name is shown preselected
               var id = $(element).val();
               if(typeof(Storage) !== 'undefined') {
                    data = {};
                    data.title = localStorage.getItem('feed_title');
                    data.url = localStorage.getItem('feed_url');
                    callback(data);
                } else {
                    // Sorry! No Web Storage support..
                }
            },

            formatResult: feedFormatResult, // omitted for brevity, see the source of this page
            formatSelection: feedFormatSelection,  // omitted for brevity, see the source of this page
            dropdownCssClass: 'bigdrop', // apply css that makes the dropdown taller
            allowClear: true,
            escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
        })
    }

    jQuery('#feed2').on('change', function(e) {
       localStorage.setItem('feed_title', $(this).select2('data').title);
       localStorage.setItem('feed_url', $(this).select2('data').url);
    });

    function feedFormatResult(feed) {
    console.log(feed);
        var markup = '';

        markup += '<span><b>' + feed.title + '</b></span>';
        markup += '<br /><span>' + feed.contentSnippet + '</span>';
        markup += '<br /><span style=\"font-size:80%\">Site: ' + feed.link + '<br />Feed: ' + feed.url + '</span>';
        return markup;
    }

    function feedFormatSelection(feed) {
        if(typeof feed.data !== 'undefined') {
            return feed.data[0].title;
        }
        if(typeof feed !== 'undefined') {
            return feed.title;
        }
    }

    //subreddits
    createSelect2SubReddit(jQuery('#subreddit'));
    function createSelect2SubReddit(e) {
        e.select2
        ({
           placeholder: 'Search for a Sub Reddit',
           minimumInputLength: 3,

           id: function(obj) {
               return obj.name; // use slug field for id
           },

           ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
              url: '" . Yii::$app->urlManager->createUrl('content/sub-reddit-search') . "',
              dataType: 'json',
              quietMillis: 1500,
              data: function (term, feed) {
                 return {
                     query: term, // search term
                 };
              },
              results: function (data, feed) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
              }
           },

           initSelection: function(element, callback) {
               // the input tag has a value attribute preloaded that points to a preselected movie's id
               // this function resolves that id attribute to an object that select2 can render
               // using its formatResult renderer - that way the movie name is shown preselected
               var id = $(element).val();
               if(typeof(Storage) !== 'undefined') {
                    data = {};
                    data.name = localStorage.getItem('subreddit_name');
                    callback(data);
                } else {
                    // Sorry! No Web Storage support..
                }
            },

            formatResult: subRedditFormatResult, // omitted for brevity, see the source of this page
            formatSelection: subRedditFormatSelection,  // omitted for brevity, see the source of this page
            dropdownCssClass: 'bigdrop', // apply css that makes the dropdown taller
            allowClear: true,
            escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
        })
    }

    jQuery('#subreddit').on('change', function(e) {
       localStorage.setItem('subreddit_name', $(this).select2('data').name);
    });

    function subRedditFormatResult(subreddit) {
        var markup = '';
        markup += '<span><b>' + subreddit.name + '</b></span>';
        return markup;
    }

    function subRedditFormatSelection(subreddit) {
        if(typeof subreddit.data !== 'undefined') {
            return subreddit.data[0].name;
        }
        if(typeof subreddit !== 'undefined') {
            return subreddit.name;
        }
    }

    jQuery('body').on('shown.bs.tab', 'a[data-toggle=\"pill\"]', function (e) {
        url = String(e.target);
        pill = url.substring(url.indexOf('#'));
        $('#facebook_search_pill').val(pill);
        $('#instagram_search_pill').val(pill);
        $('#feedsearchform-feed_search_pill').val(pill);
        if(pill != '#pill_my_groups' && pill != '#pill_other_groups' && pill != '#pill_saved_groups' && pill != '#pill_comments')
        {
           $('#extras').show();
        }
        else
        {
            $('#extras').hide();
        }
    });

    " . ((!strstr(Yii::$app->request->get('facebook_search_pill'), 'page') && !strstr(Yii::$app->request->get('facebook_search_pill'), 'group')) ? "$('#normal').hide();" : "") . "

    $(function () {
      $('[data-toggle=\"tooltip\"]').tooltip()
    });

    jQuery('body').on('click', '.select_all', function() {
        $('.select_button').click();
        return false;
    });
    $extras


});


");


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

$this->title = 'Search ' . ucwords($source);

?>


            <div class="c-schedule-update">

                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">

                        <?=
                        $this->render($source . '/_search_form', [
                            'model' => $model,
                            'source' => $source,
                            'tags' => $tags,
                            'fh' => (isset($fh) ? $fh : []),
                        ]) ?>

                    </div>
                </div>
                <!-- / .tab-content -->

            </div>
        </div>
    </div>

<form method="post" action="<?=Yii::$app->urlManager->createUrl('import/' . $source)?>" id="add_to_list_form">

<?php if (isset($dataProvider->count) && $dataProvider->count > 0) { ?>
    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Search Results</span>

            <div class="panel-heading-controls">
				<div class="btn-group">
					<?=$this->registerCss('
						.hide-by-image-sizes>li>a{cursor:pointer;padding:5px 7px !important;}
						.hide-by-image-sizes > li > a > i{visibility:hidden;}
						.hide-by-image-sizes > li:first-child > a > i{visibility:visible;}
					');?>
					<button type="button" class="btn btn-warning btn-outline dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter"></i>&nbsp;Hide&nbsp;<i class="fa fa-caret-down"></i></button>
					<ul class="dropdown-menu dropdown-menu-right hide-by-image-sizes">
						<li>
							<input type="radio" name="dim-options" id="dim-off" autocomplete="off" class="garlic-auto-save hidden">
							<a><i class="fa fa-check"></i> None</a>
						</li>
						<li>
							<input type="radio" name="dim-options" id="dim-small" autocomplete="off" class="garlic-auto-save hidden">
							<a for="dim-small"><i class="fa fa-check"></i> Images smaller than FB suggested guidelines</a>
						</li>
						<li>
							<input type="radio" name="dim-options" id="dim-tiny" autocomplete="off" class="garlic-auto-save hidden">
							<a for="dim-tiny"><i class="fa fa-check"></i> Images that are really small (thumbnail size)</a>
						</li>
					</ul>
					<?=$this->registerJs('
						$(document).ready(function(){
							$(".hide-by-image-sizes>li>a").on("click",function(){
								$(".hide-by-image-sizes>li>a>i").css("visibility","hidden");
							$(this).closest("li").find(".garlic-auto-save").trigger("click");
								$(this).find("i").css("visibility","visible");
							});
						});
					')?>
				</div>
               
                <?php if(($source == 'facebook' || $source == 'feed') && !$from_post_id) { ?>
                    <?php $res = \common\models\cSavedSearch::find()->andWhere(['origin_type' => \common\models\cListPost::getOriginIdFromName($source), 'search_value' => $save_search_value])->count(); ?>
                    <button class="btn <?php if($res == 0) { ?>btn-default<?php } else { ?>btn-success<?php } ?>" id="save-search"><span class="fa
                    <?php if($res == 0) { ?>
                    fa-square-o
                    <?php } else { ?>
                    fa-check-square-o
                    <?php } ?>" id="save-icon"></span>&nbsp;
                        Save
                    </button>
                <?php } ?>
                <button class="btn btn-warning btn-outline select_all"><span class="fa fa-refresh"></span>&nbsp;&nbsp;Select
                    All
                </button>
            </div>
        </div>

        <div class="panel-body">

            <?=
            $this->render('_search_results_form', [
                'dataProvider' => (isset($dataProvider) ? $dataProvider : []),
                'source' => $source
            ]);
            ?>

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

    <?php echo $this->render('_add_to_list', ['source' => $source, 'keyword' => (isset($model->keywords) ? $model->keywords : '')]); ?>
<?php } ?>
</form>