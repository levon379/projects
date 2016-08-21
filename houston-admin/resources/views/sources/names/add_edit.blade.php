@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Source Names <small>{{ ucwords($mode) }}</small></h1></div>
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
            <div class="panel-heading">{{ ucwords($mode) }} Source Name</div>
            <div class="panel-body">
                <form action="@if (isset($sourcename)){{ URL::to('/admin/sources/names/' . $sourcename->id . '/edit') }}@endif" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($sourcename) ? $sourcename->name : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="sourceGroup">Source Group</label>
                        <select class="form-control select2" id="sourceGroup" name="sourceGroupid">
                            @foreach ($sourceGroups as $sourceGroup)
                                @if($mode == 'add')
                                    <option value="{{$sourceGroup->id}}" {{ Input::old('sourceGroupid') == $sourceGroup->id ? 'selected' : '' }}>{{$sourceGroup->name}}</option>
                                @else
                                    <option value="{{$sourceGroup->id}}" {{ Input::old('sourceGroupid',$sourcename->source_group_id) === $sourceGroup->id ? 'selected' : '' }}>{{$sourceGroup->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-purple">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>

@stop