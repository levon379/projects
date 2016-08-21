@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Availability Rules<small></small></h1></div>
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
@if($errors->any())
<div class="validation-summary-errors alert alert-danger">
	<ul>
		{!! implode('', $errors->all('<li class="error">:message</li>')) !!}
	</ul>
</div>
@endif
<div class="row">
	<div class="col-md-4">
        
        <div class="panel panel-default">
            <div class="panel-heading">{{ ucwords($mode) }} Availability Rule</div>
            <div class="panel-body">
                <form action="{{ URL::to($mode == 'add' ? '/admin/availability/rules/add' : '/admin/availability/rules/' . $availabilityRule->id . '/edit') }}" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="limit">Limit</label>
                        <input type="text" class="form-control" name="limit" id="limit" placeholder="Limit" autocomplete="off" value="{{ Input::old('limit', isset($availabilityRule) ? $availabilityRule->limit : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="start-date">Start Date</label>
                        <div class='input-group date' id="datetimerangepicker1" >
                            <input type='text' class="form-control" data-date-format="DD/MM/YYYY" placeholder="Start Date" name="start_date" value="{{ App\Libraries\Helpers::displayDate(Input::old('start_date', isset($availabilityRule) ? $availabilityRule->start_date : null)) }}"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end-date">End Date</label>
                        <div class='input-group date' id="datetimerangepicker2" >
                            <input type='text' class="form-control" data-date-format="DD/MM/YYYY" placeholder="End Date" name="end_date" value="{{ App\Libraries\Helpers::displayDate(Input::old('end_date', isset($availabilityRule) ? $availabilityRule->end_date : null)) }}"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="availability-slot">Availability Slot</label>
                        <select class="form-control select2" id="availability-slot" name="availability_slot_id">
                            @foreach ($availabilitySlots as $availabilitySlot)
                                @if($mode == 'add')
                                    <option value="{{$availabilitySlot->id}}" {{ Input::old('availability_slot_id') == $availabilitySlot->id ? 'selected' : '' }}>{{$availabilitySlot->name}}</option>
                                @else
                                    <option value="{{$availabilitySlot->id}}" {{ Input::old('availability_slot_id',$availabilityRule->availability_slot_id) === $availabilitySlot->id ? 'selected' : '' }}>{{$availabilitySlot->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-purple">Submit</button>
                </form>

            </div>
        </div>
    </div>
    <div class="col-md-8">

        <div class="panel panel-default">
            <div class="panel-heading">Availability Rules</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Limit</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Availability Slot</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($availabilityRules as $availabilityRule)
                        <tr>
                            <td>{{ $availabilityRule->limit }}</td>
                            <td>{{ App\Libraries\Helpers::displayDate($availabilityRule->start_date) }}</td>
                            <td>{{ App\Libraries\Helpers::displayDate($availabilityRule->end_date) }}</td>
                            <td>{{ $availabilityRule->slot->name }}</td>
                            <td>
                                <form action="/admin/availability/rules/{{ $availabilityRule->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/availability/rules/{{ $availabilityRule->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
    <script>
        $(document).ready(function(){

            $("#datetimerangepicker1").datetimepicker({format: 'DD/MM/YYYY'});
            $("#datetimerangepicker2").datetimepicker({format: 'DD/MM/YYYY'});

            $("#datetimerangepicker1").on("dp.change",function (e) {
                $('#datetimerangepicker2').data("DateTimePicker").minDate(e.date);
            });
            $("#datetimerangepicker2").on("dp.change",function (e) {
                $('#datetimerangepicker1').data("DateTimePicker").maxDate(e.date);
            });

            var confirmText = "This availability rule will be deleted";
            swlConfirm(confirmText);
        });
    </script>
@stop