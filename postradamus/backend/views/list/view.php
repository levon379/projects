<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use common\models\cListPost;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 */
 
$listType = 'not-ready' ;
$retStatus = $list->getStatus();
$listTypes = [ 1 =>'not-ready', 2 => 'ready' , 3 => 'sending' , 4 => 'sent' ];
if( $retStatus && array_key_exists($retStatus,$listTypes) ){
	$listType = $listTypes[$retStatus];
}
$this->title = ($list->name ? $list->name : 'Blank');
$this->params['breadcrumbs'][] = ['label' => 'Lists', 'url' => [$listType]];
$this->params['breadcrumbs'][] = ['label' => $this->title];
$this->registerCss('
    .thumbnail.has-error {
        background-color: #FFD9D9;
    }
    .thumbnail.has-success {
        background-color: #E3FFD9;
    }
    .edited_post {
        background-color: #FFFCD9;
    }
	
	.fc-event-inner > .fc-event-time, .fc-event-inner > .fc-event-title{display:block;}
');

$this->registerJs('
if(window.location.hash) {
  // Fragment exists
  $("#item-" + window.location.hash.substring(1)).addClass("edited_post").removeClass("has-success").removeClass("has-error");
} else {
  // Fragment doesn
}

    $(".checkall").on("click", function () {
        $(this).closest("fieldset").find(":checkbox").prop("checked", this.checked);
    });

');


$this->registerJs("
init.push(function () {

    $('.delete-post').on('click', function(e) {
        e.preventDefault();
        if(confirm('Are you sure?')){
            box = $(this).closest('.box');
            $.ajax($(this).data('href'),{
				method: 'get',
			}).done(function(data) {
				box.css('opacity', '.1');
				if(box.find('.thumbnail').hasClass('post_selected')){
					box.find('.select_button').trigger('click');
				}
				box.css('pointer-events','none');
			});
        }
    });

    $(document.body).on('click', '.select_all', function() {
		if($(this).data('selected') == 'yes' ){
			// unselect all 
			$('.select_button').each(function(){
				checkbox = $(this).prev();
				if(checkbox.prop('checked')){
					$(this).trigger('click');	
				}
			});	
			$('.select_all').data('selected', 'no' );	
		}
		else{
			// select all 
			$('.select_button').each(function(){
				checkbox = $(this).prev();
				if(!checkbox.prop('checked')){
					$(this).trigger('click');	
				}
			});	
			$('.select_all').data('selected', 'yes' );
		}
		
    });

    $(document.body).on('click', '#calendar_view_button', function() {
        $('#calendar_view').show();
        $('#calendar').fullCalendar('render');
        $('#list_view').hide();
    });

    $(document.body).on('click', '#list_view_button', function() {
        $('#calendar_view').hide();
        $('#list_view').show();
    });

    $(document.body).on('click', '.select_button', function(e) {
        e.preventDefault();
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

		toggleManageSelections(num);
		
        if(checkbox.prop('checked'))
        {
            //add
            $('<input>').attr({
                type: 'hidden',
                name: 'ListPostTypeForm[posts][]',
                value: checkbox.attr('id'),
            }).appendTo('#post-type-form');
			$('<input>').attr({
                type: 'hidden',
                name: 'ListPostClearTextForm[posts][]',
                value: checkbox.attr('id'),
            }).appendTo('#clear-text-form');
            //add
            $('<input>').attr({
                type: 'hidden',
                name: 'ListPostDeleteForm[posts][]',
                value: checkbox.attr('id'),
            }).appendTo('#delete-form');
            $('<input>').attr({
                type: 'hidden',
                name: 'ListPostDuplicateForm[posts][]',
                value: checkbox.attr('id'),
            }).appendTo('#duplicate-form');
        }
        else
        {
            //remove
            $('.selection_form input[value=\"' + checkbox.attr('id') + '\"]').remove();
        }
    });

	function toggleManageSelections(num){
		var selectionsPanelObj = $('.manage-seletions-panel');
		if( num > 0 ){
			if( selectionsPanelObj.data('hidden') == 'yes' ){
				selectionsPanelObj.slideToggle();	
				selectionsPanelObj.data('hidden','no');
			}
		}
		else{
			if( selectionsPanelObj.data('hidden') == 'no' ){
				selectionsPanelObj.slideToggle();	
				selectionsPanelObj.data('hidden','yes');
			}
		}
		
		if( num < $('.select_button').length){
			$('.select_all').data('selected', 'no' );
		}
	}	
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

    $('body').on('hidden.bs.modal', '.modal', function () {
      $(this).removeData('bs.modal');
    });
});
");

//$this->registerJsFile('http://cdnjs.cloudflare.com/ajax/libs/masonry/3.1.2/masonry.pkgd.min.js', [], ['position' => \Yii\Web\View::POS_END]);

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

.caption a:hover {
    background-color:#ddd
}

.caption {
word-wrap: break-word;
}

	#external-events {
		padding: 0 10px;
		border: 1px solid #ccc;
		background: #eee;
		text-align: left;
		overflow-y: scroll;
        overflow-x: scroll;
		height:180px;
		white-space: nowrap
	}

	.external-event { /* try to mimick the look of a real event */
		margin: 5px;
		padding: 2px 4px;
		background: #3366CC;
		color: #fff;
		font-size: .85em;
		cursor: pointer;
		display:inline-block;
	}

	.fc-event {
	    height: inherit !important;
	}

.cal-image { max-height: 300px; }
.manage-seletions-panel{display:none;}
.hide-by-image-sizes > li > a{cursor:pointer;padding:5px 7px !important;}
.hide-by-image-sizes > li > a > i{visibility:hidden;}
.hide-by-image-sizes > li:first-child > a > i{visibility:visible;}
');

$this->registerJsFile('@web' . '/js/fabric.js');

?>

<div id="imageModal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>

<div id="renameModal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Rename</h4>
            </div>
            <div class="modal-body">
                <div class="note note-info padding-xs-vr"><h4>What is this?</h4> Give your list a different name.</div>
                <?= $this->render('_rename_form', [
                    'model' => $renameModel,
                ]) ?>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>

<div id="moveModal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Move</h4>
            </div>
            <div class="modal-body">
                <div class="note note-info padding-xs-vr"><h4>What is this?</h4> Move your list to a different campaign.</div>
                <?= $this->render('_move_form', [
                    'model' => $moveModel,
                ]) ?>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>

<div id="clearModal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Clear</h4>
            </div>
            <div class="modal-body">
                <div class="note note-info padding-xs-vr"><h4>What is this?</h4> Delete all posts from your list.</div>
                <?= $this->render('_clear_form', [
                    'model' => $clearModel,
                ]) ?>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>

<div id="duplicateModal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Duplicate</h4>
            </div>
            <div class="modal-body">
                <div class="note note-info padding-xs-vr"><h4>What is this?</h4> Duplicate the entire list.</div>
                <?= $this->render('_duplicate_form', [
                    'model' => $duplicateModel,
                ]) ?>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>
<style>
    .video-js {padding-top: 56.25%}
    .vjs-fullscreen {padding-top: 0px}
</style>
<div id="markAsSentModal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Mark as Sent</h4>
            </div>
            <div class="modal-body">
                <div class="note note-info padding-xs-vr"><h4>What is this?</h4> You can mark this list as "SENT" so it shows up in the sent tab.</div>
                <?= $this->render('_sent_form', [
                    'model' => $sentModel,
                ]) ?>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>

<div id="schedulerModal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Scheduler</h4>
            </div>
            <div class="modal-body">
                <div class="note note-info padding-xs-vr"><h4>What is this?</h4> Using a <a href="<?=Yii::$app->urlManager->createUrl('schedule/index')?>">Schedule</a> you can assign each post in your list a date and time for Facebook to publish your posts.</div>
                <?= $this->render('_scheduler_form', [
                    'model' => $schedulerModel,
                    'id' => $renameModel->id
                ]) ?>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>

<div id="searchModal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Search</h4>
            </div>
            <div class="modal-body">
                <div class="note note-info padding-xs-vr"><h4>What is this?</h4> Search your list for specific posts.</div>
                <?= $this->render('_search_form', [
                    'model' => $searchModel,
                ]) ?>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>


<?php ob_start(); ?>
        <div class="panel-heading-controls">
			<!--
            <button class="btn btn-sm btn-warning btn-outline" id="list_view_button"><span class="fa fa-list" onclick="window.location.reload()"></span>&nbsp;&nbsp;List View</button>-->
			<?=Html::a( '<span class="fa fa-list" onclick="window.location.reload()"></span>&nbsp;&nbsp;List View' , [ 'list/view' , 'id' => $list->id ] , ['class'=>'btn btn-sm btn-warning btn-outline'] );?>
            <button class="btn btn-sm btn-warning btn-outline" id="calendar_view_button"><span class="fa fa-calendar"></span>&nbsp;&nbsp;Calendar View</button>

            <button class="btn btn-sm btn-warning btn-outline" data-toggle="modal" data-target="#searchModal"><span class="fa fa-search"></span>&nbsp;&nbsp;Search</button>

			<div class="btn-group" style="margin-top:-1px">
				<button type="button" class="btn btn-warning btn-outline btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter"></i>&nbsp;Hide&nbsp;<i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu hide-by-image-sizes">
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
				<!--
                <label class="btn btn-primary btn-sm active">
                    <input type="radio" name="dim-options" id="dim-off" autocomplete="off" class="garlic-auto-save"> Off
                </label>
                <label class="btn btn-primary btn-sm">
                    <input type="radio" name="dim-options" id="dim-tiny" autocomplete="off" class="garlic-auto-save"> Tiny
                </label>
                <label class="btn btn-primary btn-sm">
                    <input type="radio" name="dim-options" id="dim-small" autocomplete="off" class="garlic-auto-save"> Small
                </label>
				-->
            </div>
			
            <div class="btn-group" style="margin-top:-1px">
                <button type="button" class="btn btn-warning btn-outline btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog"></i>&nbsp;Modify List&nbsp;<i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu">
                    <li><a href="#" data-toggle="modal" data-target="#renameModal">Rename</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#moveModal">Move</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#clearModal">Clear</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#duplicateModal">Duplicate</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#markAsSentModal">Mark as Sent</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#schedulerModal">Scheduler <?php
                            //see if there are any unscheduled posts
                            $count = cListPost::find()->where(['list_id' => $renameModel->id, 'scheduled_time' => null])->count();
                            if($count > 0) {
                                ?><i class="fa fa-warning" style="color:red" data-toggle="tooltip" data-placement="right" title="There are some posts that are unscheduled. You should run the scheduler before you export."></i>
                            <?php } ?></a></li>
					<!--<li><a href="#" id="massWipeText">Clear Text</a></li>-->
                </ul>
            </div>
			
            <div class="btn-group" style="margin-top:-1px">
                <button type="button" class="btn btn-warning btn-outline btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sort"></i>&nbsp;Sort&nbsp;<i class="fa fa-caret-down"></i></button>
                <?= \yii\widgets\LinkSorter::widget([
                    'sort' => $postDataProvider->sort,
                    'options' => ['class' => 'dropdown-menu']
                ]) ?>
            </div>
            
            <button class="btn btn-sm btn-warning btn-outline select_all" data-selected="no"><span class="fa fa-check"></span>&nbsp;Select All</button>
        </div>
<?php $this->context->panel_heading_controls = ob_get_clean(); ?>

        <?php /* ?>
        <div class="c-list-view">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'deleted',
                    'updated_at',
                    'created_at',
                ],
            ]) ?>

        </div>
            <?php */ ?>

        <div id="list_view">
        <?= ListView::widget([
            'dataProvider' => $postDataProvider,
            'itemOptions' => ['class' => 'box'],
            'itemView' => '_post_view',
            //'layout' => '<div class="row"><div class="col-xs-12">{summary}</div></div><div class="row">{items}</div><div class="row"><div class="col-xs-12">{pager}</div></div>',
            'layout' => '<div class="row"><div class="col-md-12">{summary}</div></div><div id="mason-container">{items}</div><div class="row"><div class="col-xs-12">{pager}</div></div>',
        ]) ?>
        </div>

        <div id="calendar_view" style="display:none">
        <?php
            use backend\assets\CalendarAsset;
            CalendarAsset::register($this);
        ?>
        <?php

        $events = [];
        $i=0;
        $posts = cListPost::find()->where(['list_id' => $list_id])->all();
        foreach($posts as $model){
            if($model->scheduled_time){
				//$eventTitle = (strlen($model->text)>45) ? substr($model->text,0,43).'...' : $model->text; 
				$eventTitle = $model->text; 
                $events[$i]['id'] = $model->id;
				$events[$i]['title'] = $eventTitle;
                $events[$i]['description'] = $model->text;
                $events[$i]['post_type'] = $model->postType->id;
                $events[$i]['post_type_color'] = $model->postType->color;

                $events[$i]['image'] = $model->image_url;
                $events[$i]['start'] = date("Y-m-d H:i:s", $model->scheduled_time);
                $i++;
            }
        }
        $events = json_encode($events);

        $this->registerJs("

init.push(function () {
			var updatePostUrl = '".Yii::$app->urlManager->createUrl(['post/update','id'=> 'did'])."';  
            $(document).ready(function() {

                $('#show-hide-cal-post-details').on('click', function() {
                   $('.cal-description').toggle($(this).checked);
                   $('.cal-image').toggle($(this).checked);
                });

                $('#external-events div.external-event').each(function() {

                    // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                    // it doesn't need to have a start or end

                    var eventObject = {
                        id: $(this).data('event-id'),
                        title: '', // use the element's text as the event title
                        image: $(this).find('.event_image img').attr('src'),
                        description: $(this).find('.event_description').text(),
                    };

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject);

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 999,
                        revert: true,      // will cause the event to go back to its
                        revertDuration: 0  //  original position after the drag
                    });

                });

                function eventHtml(event){
					var html = '';
                    if(event.post_type_id !== null)
                    {
                        html += '<div style=\"background-color:' + event.post_type_color + '; height:4px\"></div>';
                    }
                    if(event.image !== null)
                    {
                        html += '<img class=\"img-responsive cal-image\" src=\"' + event.image + '\" />'
                    }
                    //html += '<p class=\"cal-description\">' + event.description + '</p>';
					return html;
                }
				
				function eventUpdateIcon(event){
					var updateUrl = updatePostUrl ; 
					return '<a href=\"'+updateUrl.replace('did',event.id)+'\" class=\"\" data-toggle=\"tooltip\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a>';
				}

                function updateEventTimes(event, delta, revertFunc)
                { console.log(event);
                  $.ajax({
                    url: '" . Yii::$app->urlManager->createUrl('list/move-calendar-event') . "',
                    type: 'POST',
                    dataType: 'json',
                    data: ({
                      id: event.id,
                      date: event.start.format()
                    }),
                    success: function(data, textStatus) {
                      if (!data)
                      {
                        revertFunc();
                        return;
                      }
                      $('#calendar').fullCalendar('updateEvent', event);
                    },
                    error: function() {
                      revertFunc();
                    }
                  });
                };

                $('#calendar').fullCalendar({
        			defaultDate: '" . date("Y-m-d") . "',
        			defaultView: 'agendaWeek',
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    editable: true,
                    allDaySlot: false,
                    events: $events,
                    eventRender: function(event, element, calEvent) {
						//alert(element.html());
						/*
						element.find('.fc-event-time').after($('<span class=\"fc-event-icons\"></span>').html(eventHtml(event)));
						*/
						element.find('.fc-event-inner').append($('<span class=\"fc-event-icons\"></span>').html(eventHtml(event)));
						element.append( $('<div style=\"text-align:right;padding-right:5px;\"></div>').html(eventUpdateIcon(event)) );
			        },
                    eventDrop: updateEventTimes,
                    eventAfterRender: function (event, element, view) {
                        $('.cal-description').toggle($('#show-hide-cal-post-details').prop('checked'));
                        $('.cal-image').toggle($('#show-hide-cal-post-details').prop('checked'));
                    },
           			droppable: true, // this allows things to be dropped onto the calendar !!!
                    drop: function(date) { // this function is called when something is dropped
						//alert(date);
						// retrieve the dropped element's stored Event Object
                        var originalEventObject = $(this).data('eventObject');
						// we need to copy it, so that multiple events don't have a reference to the same object
                        var copiedEventObject = $.extend({}, originalEventObject);
						copiedEventObject.title = copiedEventObject.description;
						/*
						for(var i in copiedEventObject){
							alert( i + ' - ' + copiedEventObject[i] );
						}
						return false; 
						*/
                        // assign it the date that was reported
                        copiedEventObject.start = date;
						
                        // render the event on the calendar
                        // the last true argument determines if the event sticks (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                        // if so, remove the element from the Draggable Events list
                        $(this).remove();

                        $.ajax({
                            url: '" . Yii::$app->urlManager->createUrl('list/move-calendar-event') . "',
                            type: 'POST',
                            dataType: 'json',
                            data: ({
                              id: copiedEventObject.id,
                              date: copiedEventObject.start.format()
                            }),
                            success: function(data, textStatus) {
                              if (!data)
                              {
                                //revertFunc();
                                return;
                              }
                              //$('#calendar').fullCalendar('updateEvent', copiedEventObject);
                            },
                            error: function() {
                              //revertFunc();
                            }
                          });
                    }

                });

            });
            });
        ");

        ?>


            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Unscheduled Posts</span>
                </div>
                <div class="panel-body">

                    <div id='external-events'>
                        <?php
                        $posts = cListPost::find()->where(['list_id' => $list_id])->all();
                        foreach($posts as $model)
                        {
                            if(!$model->scheduled_time)
                            {
                                ?>
                                <div class='external-event' data-event-id='<?=$model->id?>' data-event-title='<?=$model->text?>'  data-event-description='<?=$model->text?>' style='max-width:130px; width:130px'>
                                    <?php if($model->image_url) { ?>
                                        <div class="event_image">
                                            <img src="<?=$model->image_url?>" class="img-responsive" />
                                        </div>
                                    <?php } ?>
                                    <div class="event_description" style="text-overflow:hidden"><?php echo $model->text; ?></div>
                                </div>
                            <?php
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>

            <input type="checkbox" id="show-hide-cal-post-details" value="1" checked="checked"> Show Photos/Text
            <div id='calendar' style='width:100%'></div>
        </div>

    </div>

    <div class="panel-footer">

            <a href="<?php echo Yii::$app->urlManager->createUrl(['post/create', 'id' => $renameModel->id]); ?>" class="btn btn-primary btn-sm">New Post</a>

        <div class="panel-footer-controls">
            <button class="btn btn-sm btn-warning btn-outline select_all" data-selected="no"><span class="fa fa-check"></span>&nbsp;Select All</button>
        </div>
        <div style="clear: both"></div>
    </div>

</div>

<div class="panel manage-seletions-panel" data-hidden="yes">
    <div class="panel-heading">
        <span class="panel-title">Manage Selections</span>
        <ul class="nav nav-tabs nav-tabs-xs">
            <li class="active">
                <a href="#ftab1" data-toggle="tab"><span class="fa fa-money"></span>&nbsp;&nbsp;Change Post Type</a>
            </li>
			<li>
                <a href="#ftab4" data-toggle="tab"><span class="fa fa-eraser"></span>&nbsp;&nbsp;Clear Text</a>
            </li>
            <li>
                <a href="#ftab2" data-toggle="tab"><span class="fa fa-trash-o"></span>&nbsp;&nbsp;Delete</a>
            </li>
            <li>
                <a href="#ftab3" data-toggle="tab"><span class="fa fa-copy"></span>&nbsp;&nbsp;Duplicate</a>
            </li>
            <?php /* ?>
            <li>
                <a href="#ftab5" data-toggle="tab"><span class="fa fa-text-height"></span>&nbsp;&nbsp;Apply Post Templates</a>
            </li>
 <?php */ ?>
            <?php /* ?>
            <li>
                <a href="#ftab3" data-toggle="tab">Link</a>
            </li>
            <?php */ ?>
         </ul>
    </div>

    <div class="panel-body">

        <div class="tab-content"> <!-- / .tab-pane -->
            <div class="tab-pane active" id="ftab1">
                <div class="note note-info padding-xs-vr"><h4>What is this?</h4> This option allows you to change the post type for all of your selected posts.</div>
                <?= $this->render('_post_type_form', [
                    'model' => $postTypeModel,
                ]) ?>
            </div>
			<div class="tab-pane" id="ftab4">
                <div class="note note-info padding-xs-vr"><h4>What is this?</h4> This will clear text for all of your <b>selected</b> posts.</div>
                <?= $this->render('_clear_text_form', [
                    'model' => $clearTextModel,
                ]) ?>
            </div>
            <div class="tab-pane" id="ftab2">
                <div class="note note-info padding-xs-vr"><h4>What is this?</h4> This will delete all of your <b>selected</b> posts.</div>
                <?= $this->render('_delete_posts_form', [
                    'model' => $deletePostsModel,
                ]) ?>
            </div>
            <div class="tab-pane" id="ftab3">
                <div class="note note-info padding-xs-vr"><h4>What is this?</h4> This will duplicate all of your <b>selected</b> posts.</div>
                <?= $this->render('_duplicate_posts_form', [
                    'model' => $duplicatePostsModel,
                ]) ?>
            </div>
            <div class="tab-pane" id="ftab5">
                <div class="note note-info padding-xs-vr"><h4>What is this?</h4> This will allow you to apply <a href="<?=Yii::$app->urlManager->createUrl('post-template/index')?>">Post Templates</a> to all of your <b>selected</b> posts.</div>
                <?= $this->render('_post_template_form', [
                    'model' => $postTypeModel,
                ]) ?>
            </div>
        </div> <!-- / .tab-content -->

        <a name="ftab2"></a>
    </div>

</div>
<?php $this->beginBlock('viewJs'); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.hide-by-image-sizes>li>a').on('click',function(){
			$('.hide-by-image-sizes>li>a>i').css('visibility','hidden');
			$(this).closest('li').find('.garlic-auto-save').trigger('click');
			$(this).find('i').css('visibility','visible');
		});
	});
</script>
<?php $this->endBlock(); ?>