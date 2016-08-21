@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Availability Slots<small></small></h1></div>
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
            <div class="panel-heading">{{ucfirst($mode)}} Availability Slot
                @if($mode=='edit')
                <div class="pull-right delete">
                    <a class="btn btn-success btn-xs" href="/admin/availability/slots">Add Availability Slot</a>
                </div>
                @endif
            </div>
            <div class="panel-body">
                <form action="{{ URL::to($mode == 'add' ? '/admin/availability/slots/add' : '/admin/availability/slots/' . $availabilitySlot->id . '/edit') }}" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($availabilitySlot) ? $availabilitySlot->name : null) }}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="color" id="color" placeholder="Color" autocomplete="off" value="{{ Input::old('color', isset($availabilitySlot) ? $availabilitySlot->color : null) }}">
                    </div>
                    <div class="form-group" id="language-panel">
                        <input class="form-control" type="text" name="tods" id="tods" placeholder="Choose Time of Day/s" value="{{ Input::old('tods', isset($timeOfDays) ? $timeOfDays : null) }}"/>
                    </div>
                    <button type="submit" class="btn btn-purple">Submit</button>
                </form>

            </div>
        </div>
	</div>
    <div class="col-md-8">

        <div class="panel panel-default">
            <div class="panel-heading">Availability Slots</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Color</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($availabilitySlots as $availabilitySlot)
                        <tr>
                            <td>{{ $availabilitySlot->name  }}</td>
                            <td><span class="pull-left event" style="background-color:{{ $availabilitySlot->color ?: '#c3c3c3' }};"></span>&nbsp; {{ $availabilitySlot->color ?: '#c3c3c3' }}</td>
                            <td>
                                <form action="/admin/availability/slots/{{ $availabilitySlot->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/availability/slots/{{ $availabilitySlot->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
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

            var confirmText = "This availability slot will be deleted";

            swlConfirm(confirmText);

            $("#color").minicolors({position: 'bottom right',  theme: 'bootstrap' });

            $('#tods').select2({
                multiple: true,
                ajax: {
                    dataType: "json",
                    url: "/admin/services/tods",
                    results: function (data) {
                        var results = [];
                        $.each(data, function(index, tod){
                            results.push({
                                id: tod.id,
                                text: tod.name
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
                        $.ajax("/admin/services/tods/" + value, {
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

        });
    </script>
@stop