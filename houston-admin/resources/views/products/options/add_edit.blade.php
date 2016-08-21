@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Product Option <small>{{ ucwords($mode) }} <strong>({{ isset($productOption) ? $productOption->product->name : $product->name }})</strong></small></h1></div>
<div class="row breadcrumb-row">
    <div class="btn-group btn-breadcrumb col-lg-12">
        <a href="/admin/products" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/products" class="btn btn-default"><div>Products</div></a>
        <a href="/admin/products/{{ $productId }}/options" class="btn btn-default"><div>Options</div></a>
        <a href="/admin/products/{{ $productId }}/options/add" class="btn btn-default active"><div>{{ ucwords($mode) }} Product Option</div></a>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        @if($errors->any())
        <div class="validation-summary-errors alert alert-danger">
            <ul>
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </ul>
        </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">{{ ucwords($mode) }} Product Option</div>
            <div class="panel-body">
                <form action="@if ($mode=='edit'){{ URL::to('/admin/products/options/' . $productOption->id . '/edit') }}@endif" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="product_id" value="{{ isset($productOption) ? $productOption->product_id : $product->id }}">
                    <div class="form-group">
                        <label for="end-date">Product</label>
                        <input type='text' class="form-control" readonly name="book_season_start" value="{{ isset($productOption) ? $productOption->product->name : $product->name  }}"/>
                    </div>
                    <div class="form-group">
                        <label for="availability-slot">Availability Slot</label>
                        <select class="form-control select2" id="availability-slot" name="availability_slot_id">
                            @foreach ($availabilitySlots as $availabilitySlot)
                                @if($mode == 'add')
                                    <option value="{{$availabilitySlot->id}}" {{ Input::old('availability_slot_id') == $product->id || (@$productOption->availability_slot_id == $availabilitySlot->id)? 'selected' : '' }}>{{$availabilitySlot->name}}</option>
                                @else
                                    <option value="{{$availabilitySlot->id}}" {{ Input::old('availability_slot_id',$productOption->availability_slot_id) === $availabilitySlot->id ? 'selected' : '' }}>{{$availabilitySlot->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Languages</label>
                        <input class="form-control" type="text" name="languages" id="languages" placeholder="Choose Language/s" value="{{ Input::old('languages', isset($language_selection) ? $language_selection : null) }}"/>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($productOption) ? $productOption->name : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="end-date">Start Time</label>
                        <div class='input-group date' id="start-time">
                            <input type='text' class="form-control" placeholder="Start Time" name="start_time" value="{{ Input::old('start_time', isset($productOption) ? $productOption->start_time : null) }}"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end-date">End Time</label>
                        <div class='input-group date' id="end-time">
                            <input type='text' class="form-control" placeholder="End Time" name="end_time" value="{{ Input::old('end_time', isset($productOption) ? $productOption->end_time : null) }}"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="adult-price">Adult Price</label>
                        <input type="text" class="form-control" name="adult_price" id="adult-price" placeholder="Adult Price" autocomplete="off" value="{{ App\Libraries\Helpers::formatPrice(Input::old('adult_price', isset($productOption) ? $productOption->adult_price : null)) }} €">
                    </div>
                    <div class="form-group no-margin-bottom">
                        <label for="adult-ages">Adult Ages</label>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control integer" name="adult_age_from" placeholder="From" autocomplete="off" value="{{ Input::old('adult_age_from', isset($productOption) ? $productOption->adult_age_from : null) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control integer" name="adult_age_to" placeholder="To" autocomplete="off" value="{{ Input::old('adult_age_to', isset($productOption) ? $productOption->adult_age_to : null) }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="child-price">Child Price</label>
                        <input type="text" class="form-control" name="child_price" id="child-price" placeholder="Child Price" autocomplete="off" value="{{ App\Libraries\Helpers::formatPrice(Input::old('child_price', isset($productOption) ? $productOption->child_price : null)) }} €">
                    </div>
                    <div class="form-group no-margin-bottom">
                        <label for="adult-ages">Child Ages</label>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control integer" name="child_age_from" placeholder="From" autocomplete="off" value="{{ Input::old('child_age_from', isset($productOption) ? $productOption->child_age_from : null) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control integer" name="child_age_to" placeholder="To" autocomplete="off" value="{{ Input::old('child_age_to', isset($productOption) ? $productOption->child_age_to : null) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="end-date">Travel Season Start</label>
                        <div class='input-group date' id="travseasonstart" >
                            <input type='text' class="form-control" data-date-format="DD/MM/YYYY" placeholder="Start Date" name="trav_season_start" value="{{ App\Libraries\Helpers::displayDate(Input::old('trav_season_start', isset($productOption) ? $productOption->trav_season_start : null)) }}"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end-date">Travel Season End</label>
                        <div class='input-group date' id="travseasonend" >
                            <input type='text' class="form-control" data-date-format="DD/MM/YYYY" placeholder="End Date" name="trav_season_end" value="{{ App\Libraries\Helpers::displayDate(Input::old('trav_season_end', isset($productOption) ? $productOption->trav_season_end : null)) }}"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end-date">Book Season Start</label>
                        <div class='input-group date' id="bookseasonstart" >
                            <input type='text' class="form-control" data-date-format="DD/MM/YYYY" placeholder="Start Date" name="book_season_start" value="{{ App\Libraries\Helpers::displayDate(Input::old('book_season_start', isset($productOption) ? $productOption->book_season_start : null)) }}"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end-date">Book Season End</label>
                        <div class='input-group date' id="bookseasonend" >
                            <input type='text' class="form-control" data-date-format="DD/MM/YYYY" placeholder="End Date" name="book_season_end" value="{{ App\Libraries\Helpers::displayDate(Input::old('book_season_end', isset($productOption) ? $productOption->book_season_end : null)) }}"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Running Days</label>
                        <select class="form-control" id="running-days" multiple name="running_days[]">
                            @foreach (App\Libraries\Days::$days as $dayId => $day)
                                @if($mode == 'add')
                                    <option value="{{$dayId}}" {{ in_array($dayId,Input::old('running_days[]',array())) ? 'selected' : '' }}>{{$day}}</option>
                                @else
                                    <option value="{{$dayId}}" {{ in_array($dayId,Input::old('running_days[]',$running_days_list))  ? 'selected' : '' }}>{{$day}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Unavailable Days</label>
                        <div class='input-group date' id="unavailable-days">
                            <input type="text" class="form-control" readonly name="unavailable_days" value="{{ Input::old('unavailable_days', isset($unavailableDaysList) ? $unavailableDaysList : null) }}">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end-date">Duration</label>
                        <input type='text' class="form-control" placeholder="Duration" id="duration" name="duration" readonly value="{{ Input::old('duration', App\Libraries\Helpers::displayDuration(isset($productOption) ? $productOption->duration : '0')) }}"/>
                    </div>
                    <div class="form-group">
                        <label for="minimum">Minimum</label>
                        <input type="text" class="form-control integer" name="minimum" id="minimum" placeholder="Minimum" autocomplete="off" value="{{ Input::old('minimum', isset($productOption) ? $productOption->minimum : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="max">Max Group</label>
                        <input type="text" class="form-control integer" name="max_group" id="max" placeholder="Maximum" autocomplete="off" value="{{ Input::old('max_group', isset($productOption) ? $productOption->max_group : null) }}">
                    </div>
                    <div class="form-group">
                        <label class="cr-styled">
							<input type="hidden" class="private-flag-value" name="private_value" value="{{ @$private ? '1' : '0' }}">
                            @if ($mode == 'add')
								@if(isset($productOption))
								<input type="checkbox" class="private-flag" name="private" {{ Input::old('private',$productOption->private) ? 'checked' : '' }}>
								@else
                                <input type="checkbox" class="private-flag" name="private" {{ @$private ? 'checked' : ''}}>
								@endif
                            @else
                                <input type="checkbox" class="private-flag" name="private" {{ Input::old('private',$productOption->private) ? 'checked' : '' }}>
                            @endif
                            <i class="fa"></i>
                        </label>
                        Private
                    </div>
					<div class="form-group">
                        <label class="cr-styled">
							<input type="hidden" class="disabled-flag-value" name="flag_show_value" value="{{ @$shown ? '1' : '0' }}">
                            @if ($mode == 'add')
								@if($productOption)
                                <input type="checkbox" id="show-flag" class="disabled-flag" name="flag_show" {{ Input::old('flag_show',$productOption->flag_show) ? 'checked' : '' }}>
								@else
								<input type="checkbox" id="show-flag" class="disabled-flag" name="flag_show" {{ @$shown ? 'checked' : ''}}>
								@endif
                            @else
                                <input type="checkbox" id="show-flag" class="disabled-flag" name="flag_show" {{ Input::old('flag_show',$productOption->flag_show) ? 'checked' : '' }}>
                            @endif
                            <i class="fa"></i>
                        </label>
                        Show on Website
                    </div>
                    <div class="form-group">
                        <label class="cr-styled">
                            @if ($mode == 'add')
                                <input type="checkbox" id="package-flag" name="package_flag" {{ Input::old('package_flag',false) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="package-flag" name="package_flag" {{ Input::old('package_flag',$productOption->package_flag) ? 'checked' : '' }}>
                            @endif
                            <i class="fa"></i>
                        </label>
                        Package
                    </div>
                    <div class="form-group">
                        <label class="cr-styled">
                            @if ($mode == 'add')
                                <input type="checkbox" id="on-request-flag" name="on_request_flag" {{ Input::old('on_request_flag',false) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="on-request-flag" name="on_request_flag" {{ Input::old('on_request_flag',$productOption->on_request_flag) ? 'checked' : '' }}>
                            @endif
                            <i class="fa"></i>
                        </label>
                        On Request
                    </div>
                    <div class="form-group">
                        <label class="cr-styled">
                            @if ($mode == 'add')
                                <input type="checkbox" id="fixed-price" name="fixed_price_flag" {{ Input::old('fixed_price_flag',false) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="fixed-price" name="fixed_price_flag" {{ Input::old('fixed_price_flag',$productOption->fixed_price_flag) ? 'checked' : '' }}>
                            @endif
                            <i class="fa"></i>
                        </label>
                        Fixed Price
                    </div>
                    <div class="form-group" id="options-panel">
                        <label>Product Options</label>
                        <input class="form-control" type="text" name="options" id="options" placeholder="Choose Product Option/s" value="{{ Input::old('options', isset($option_selection) ? $option_selection : null) }}"/>
                        <p class="help-block">Please choose a language before assigning a product option</p>
                    </div>
                    <button type="submit" class="btn btn-purple">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>

@stop


@section('script')
    <script>
        $(document).ready(function(){



            $("#adult-price, #child-price").inputmask('decimal',{
                radixPoint : ',',
                autoGroup : false ,
                digits : 2 ,
                digitsOptional : false,
                suffix: ' €',
                placeholder: '0',
                rightAlign: false
            });

            var unavailableDays = '#unavailable-days';

            $(unavailableDays).datepicker({
                clearBtn: true,
                multidate: true,
                keyboardNavigation: false,
                forceParse: false,
                format: "dd/mm/yyyy",
                todayHighlight: false,
                orientation: "auto right"
                //daysOfWeekDisabled: $("#running-days").val()
            });

            if(!(extractDates(unavailableDays+" input")[0] == "Invalid Date")){
                $(unavailableDays).datepicker("setDates",extractDates(unavailableDays+" input"));
            }

            $('#package-flag').on('click', function (e) {

                showHideOptions($(this).is(":checked"));

            });

            showHideOptions($('#package-flag').is(":checked"));


            function showHideOptions(checked){
                if(checked){
                    $("#options-panel").show();
                } else {
                    $("#options-panel").hide();
                }
            }

            $('#options').select2({
                multiple: true,
                ajax: {
                    dataType: "json",
                    url: "/admin/services/options/all/" + "{{ isset($productOption) ? $productOption->id : '' }}",
                    data: function (term, page) {
                        return {
                            q: term,
                            languages : $('#languages').val()
                        };
                    },
                    results: function (data) {
                        var results = [];
                        $.each(data, function(index, options){
                            results.push({
                                id: options.id,
                                text: options.name
                            });
                        });
                        return {
                            results: results
                        };
                    }
                },
                initSelection: function(element, callback) {
                    var ids = $(element).val().split(',');
                    var result = [];
                    $.each(ids, function(index, value) {
                        $.ajax("/admin/services/options/info/" + value, {
                            dataType: "json",
                            async: false
                        }).done(function(data) {
                            result.push({
                                id: data.id,
                                text: data.name
                            });
                        });
                    });
                    callback(result);
                }
            });
			
			$('#languages').select2({
                multiple: true,
                ajax: {
                    dataType: "json",
                    url: "/admin/services/languages",
                    data: function (term, page) {
                        return {
                            q: term
                        };
                    },
                    results: function (data) {
                        var results = [];
                        $.each(data, function(index, language){
                            results.push({
                                id: language.id,
                                text: language.name
                            });
                        });
                        return {
                            results: results
                        };
                    }
                },
                initSelection: function(element, callback) {
                    var ids = $(element).val().split(',');
                    var result = [];
                    $.each(ids, function(index, value) {
                        $.ajax("/admin/services/languages/" + value, {
                            dataType: "json",
                            async: false
                        }).done(function(data) {
                            result.push({
                                id: data.id,
                                text: data.name
                            });
                        });
                    });
                    callback(result);
                }
            });

            $('#running-days').multiselect({
                //numberDisplayed: 7,
                buttonText: function(options, select) {
                    if (options.length === 0) {
                        return 'Choose Days';
                    } else {
                        var labels = [];
                        options.each(function() {
                            if ($(this).attr('label') !== undefined) {
                                labels.push($(this).attr('label'));
                            }
                            else {
                                labels.push($(this).html());
                            }
                        });
                        return labels.join(', ') + '';
                    }
                }
            });


            //$('#duration').datetimepicker({ format: 'HH:mm' });

            $("#start-time input,#end-time input").on("change paste keyup keydown blur", function() {
                var diff = timeDiff($("#start-time input").val(),$("#end-time input").val());
                $("#duration").val(diff);
            });

            $('#start-time').datetimepicker({ format: 'LT', useCurrent: 'day' });
            $('#end-time').datetimepicker({ format: 'LT' , useCurrent: 'day' });

            /*
             $('#start-time').on("dp.change",function(e) {
             $('#end-time').data("DateTimePicker").defaultDate(date).minDate(date);
             });
             */

            $("#travseasonstart").datetimepicker({ format: 'DD/MM/YYYY' });
            $("#travseasonend").datetimepicker({ format: 'DD/MM/YYYY' });
            $("#travseasonstart").on("dp.change",function (e) {
                $('#travseasonend').data("DateTimePicker").minDate(e.date);
            });
            $("#travseasonend").on("dp.change",function (e) {
                $('#travseasonstart').data("DateTimePicker").maxDate(e.date);
            });

            $("#bookseasonstart").datetimepicker({format: 'DD/MM/YYYY' });
            $("#bookseasonend").datetimepicker({format: 'DD/MM/YYYY' });

            $("#bookseasonstart").on("dp.change",function (e) {
                $('#bookseasonend').data("DateTimePicker").minDate(e.date);
            });
            $("#bookseasonend").on("dp.change",function (e) {
                $('#bookseasonstart').data("DateTimePicker").maxDate(e.date);
            });
			
			$("form").on("change",".disabled-flag",function(){
				var isChecked  = $(this).is(':checked');
				var checkValue = $(this).closest(".cr-styled").find(".disabled-flag-value");
				var value = isChecked ? 1 : 0;
				checkValue.val(value);
				console.log(checkValue.val());
			});
			
			$("form").on("change",".private-flag",function(){
				var isChecked  = $(this).is(':checked');
				var checkValue = $(this).closest(".cr-styled").find(".private-flag-value");
				var value = isChecked ? 1 : 0;
				checkValue.val(value);
				console.log(checkValue.val());
			});
			
        });



    </script>
@stop