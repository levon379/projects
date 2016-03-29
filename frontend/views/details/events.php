<?php
use kartik\helpers\Html;
use kartik\helpers\Enum;
use kartik\icons\Icon;
use yii\helpers\Url;
use frontend\assets\CalendarAsset;  // Calendar Assets

// Initialize framework as per <code>icon-framework</code> param in Yii config
Icon::map($this);

$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['swots/' . $category->id]];
$this->params['breadcrumbs'][] = ['label' => $model->type, 'url' => ['swots/details/' . $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Events'];
/* Call fullCalendar function for built Calendar */
$this->registerJs("
    
    $('#calendar_view').fullCalendar({
            header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
            },
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
                    $('#eventModal').modal();
                    var title = '';
                    var description = '';
                    var eventData = {};
                    $('#calendar-modal-send').click(function(){
                        title = $('#recipient-name').val();
                        description = $('#message-text').val();
                        var url  = '/details/save-events';
                        var json_data = {
                            'title'    : title,
                            'data'     : description,
                            'time'     : start,
                        };
//                        $.post(url, json_data, function(data) {
//                            console.log(data)
//                        });
                        eventData = {
                                title: title,
                                start: start,
                                end: end
                        };
                        $('#calendar_view').fullCalendar('renderEvent', eventData, true);
                        
                        $('#eventModal').modal('hide');
                    });

                    $('#calendar_view').fullCalendar('unselect');
            },
            editable: true,
            eventLimit: true, 
            events: []
    }); 
    
");
?>

<div class="row">
    <div class="col-md-12">
        <h4><?= $model->name ?></h4>
        <?php if (!empty($model->description)): ?>
            <small><?= $model->description ?></small>
        <?php else: ?>
            <span class="text text-muted" style="border-bottom: dotted 1px;">No description</span>
        <?php endif; ?>
        <hr>
    </div>

    <!-- Calendar-->
    <div id="calendar_view">
        <?php CalendarAsset::register($this); ?>
    </div>

    <!-- Events Modal Window  -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Even Title:</label>
                            <input type="text" name="eventTitle" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Even Description:</label>
                            <textarea class="form-control" name="eventDescription" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="calendar-modal-send" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>