@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Booking Calendar<small></small></h1></div>
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('success') !!}
    </div>
@endif
@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('error') !!}
    </div>
@endif

<div class="row">

    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-exclamation-circle fa-2x" ></i>&nbsp;&nbsp;Unavailable Days</div>
            <div class="panel-body">

                <div id="unavailability-body" class="nicescroll nicescroll-rails">
                </div>

                @include('partials.unavailability')

                <div id="unavailability-foot">
                    <div class="form-group">
                        <div class="input-group calendar-events-ctrl">
                            <input type="text" id="unavailability-date" class="form-control" placeholder="">
                            <span class="input-group-btn">
                                <button class="btn btn-success add-unavailability-date" type="button">Add</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group noselect">
                        <label class="cr-styled">
                            <input type="checkbox" name="tod-1" checked="" data-index="1" data-val="1">
                            <i class="fa"></i>
                        </label>
                        Morning
                    </div>
                    <div class="form-group noselect">
                        <label class="cr-styled">
                            <input type="checkbox" name="tod-2" checked="" data-index="2" data-val="1">
                            <i class="fa"></i>
                        </label>
                        Afternoon
                    </div>
                    <div class="form-group noselect">
                        <label class="cr-styled">
                            <input type="checkbox" name="tod-3" checked="" data-index="3" data-val="1">
                            <i class="fa"></i>
                        </label>
                        Night
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="panel panel-default">

            <div class="panel-heading">

                @if($showGuide){{$guide." -"}}@endif Tour Assignment Calendar

                <div class="tac-text pull-right">
                    <span id="tours-assigned">0</span> Tours Assigned /
                    <span id="tours-confirmed">0</span> Tours Confirmed
                </div>
            </div>
            <div class="panel-body">

                <div class="panel-heading clean clearfix text-center">
                    <div class="btn-group tac-controls">
                        <button class="btn btn-default btn-sm" data-calendar-nav="prev">&lt;&lt; Prev</button>
                        <button class="btn btn-sm btn-default" data-calendar-nav="today">Today</button>
                        <button class="btn btn-sm btn-default" data-calendar-nav="next">Next &gt;&gt;</button>
                    </div>
                    <b class="calender-title"></b>
                </div>


                <div class="panel-body" id="calendar-container">
                    <div id="calendar" class="cal-context" style="width: 100%;"></div>
                </div>


            </div>
        </div>
    </div>

</div>

@stop

@section('script')
    <script>
        $(document).ready(function(){

            var options = {
                events_source: '/admin/services/guide-tours',
                view: 'month',
                tmpl_path: '/assets/js/plugins/calendar/tmpls/',
                tmpl_cache: false,
                views: {
                    year:  {
                        slide_events: 1,
                        enable:       0
                    },
                    month: {
                        slide_events: 1,
                        enable:       1
                    },
                    week:  {
                        enable: 0
                    },
                    day:   {
                        enable: 0
                    }
                },
                onAfterEventsLoad: function(events, all) {
                    if(!events) {
                        return;
                    }
                    var list = $('#eventlist');
                    list.html('');

                    var toursAssigned = $("#tours-assigned");
                    var toursConfirmed = $("#tours-confirmed");

                    toursAssigned.text(all.tours_assigned);
                    toursConfirmed.text(all.tours_confirmed);


                },
                onAfterViewLoad: function(view) {
                    $('.calender-title').text(this.getTitle());
                    $('.btn-group button').removeClass('active');
                    $('button[data-calendar-view="' + view + '"]').addClass('active');

                },
                classes: {
                    months: {
                        general: 'label'
                    }
                }
            };

            var calendar = $('#calendar').calendar(options);

            var startDate = moment().startOf('month');
            var endDate = moment().endOf('month');

            var dates = [];
            var todVals = [];

            loadUnavailabilityDates(startDate,endDate);

            $("#unavailability-date").datetimepicker({
                format: 'DD/MM/YYYY',
                minDate: startDate,
                maxDate: endDate
            });

            $("#unavailability-date").on("dp.change",function(e) {
                $("#unavailability-date").blur();
            });

            $('.btn-group button[data-calendar-nav]').each(function() {
                var $this = $(this);
                $this.click(function() {
                    calendar.navigate($this.data('calendar-nav'));
                    var input = $("#unavailability-date");
                    var dateTimePicker = input.data("DateTimePicker");
                    startDate = moment(calendar.getStartDate());
                    endDate = moment(calendar.getEndDate());
                    endDate = endDate.subtract(1,'days');
                    dateTimePicker.options({minDate:startDate,maxDate:endDate,defaultDate:startDate.startOf('month')})
                    input.val('');
                    loadUnavailabilityDates(startDate,endDate);

                });
            });

            function loadUnavailabilityDates(sDate,eDate){
                sDate = sDate.format('DD/MM/YYYY');
                eDate = eDate.format('DD/MM/YYYY');
                $('#unavailability-body').html('');
                var saveRow = $("#unavailability-add-row-template").html();
                var template = Handlebars.compile(saveRow);
                $.get("/admin/services/get-availability",{sdate:sDate,edate:eDate}).done(function(data){
                    $.each(data,function(idx,val){
                        var html = template({uv_date: val.date, uv_text: val.tods, id: val.id});
                        var container = $("#unavailability-body");
                        container.append(html);
                        dates.push(val.date);
                    })
                })

            }

            $('.btn-group button[data-calendar-view]').each(function() {
                var $this = $(this);
                dates = [];
                $this.click(function() {
                    calendar.view($this.data('calendar-view'));
                });
            });



            // fill dates?

            $("body").on('click','.ur-control .fa-remove',function(){
                var element = $(this);
                var date = element.data("date");
                var user = element.data("id");
                $.post("/admin/services/remove-availability", {
                    user: user,
                    date: date
                }).done(function (data) {
                    var row = element.parents(".unavailability-row");
                    dates = removeArrayElement(date,dates);
                    row.fadeOut(500,function(){
                        row.remove();
                    });
                });
            });

            $(".add-unavailability-date").click(function(){
                var saveRow = $("#unavailability-add-row-template").html();
                var template = Handlebars.compile(saveRow);
                var date = $("#unavailability-date").val();
                var id = 14;
                $("#unavailability-date").data("DateTimePicker").hide();
                if(date && $.inArray(date,dates) < 0){
                    var text = constructUnavailabilityText();
                    if(todVals) {
                        $.post("/admin/services/add-availability", {
                            user: id,
                            tods: todVals,
                            date: date
                        }).done(function (data) {
                            dates.push(date);
                            var html = template({uv_date: date, uv_text: text, id: id});
                            var container = $("#unavailability-body");
                            container.append(html);
                            var sHeight = $('#unavailability-body')[0].scrollHeight;
                            $('#unavailability-body').scrollTop(sHeight);
                        });
                    }
                } else {
                    $("#unavailability-date").val('');
                    swal(
                        "Warning",
                        "You already added unavailability details for this date. To change your unavailability for this date, remove current details first and submit again"
                    );
                }
            });

            $("input[name^='tod-']").click(function(){
                var check = $(this);
                var val = parseInt(check.data("val"));
                val = val ? 0 : 1;
                check.data("val",val);
            })

            function constructUnavailabilityText(){
                var vals = [];
                todVals = [];
                var map = { '1' : 'Morning' , '2' : 'Afternoon' ,'3' : 'Night' };
                $("input[name^='tod-']").each(function(){
                    var check = $(this);
                    var index = parseInt(check.data("index"));
                    var val = parseInt(check.data("val"));
                    if(val){
                        vals.push(map[index]);
                        todVals.push(index);
                    }
                });
                var text = "Unavailability for " + vals.join(", ");
                return text;
            }

        });
    </script>
@stop
