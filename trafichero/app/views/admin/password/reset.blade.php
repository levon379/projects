@extends('layout.default')
@section('content')
<div class="col-lg-5 col-lg-offset-3">
    {{ Form::open(array('route'=> 'account_settings_post', 'class'=>'form-signin')) }}
        <div class="form-group">
        {{ Form::email('newemail','', array('class'=>'form-control', 'placeholder'=>'New Email Address')) }}
        </div>
        <div class="form-group">
        {{ Form::password('newpassword', array('class'=>'form-control', 'placeholder'=>'New Password')) }}
        </div>
        <div class="form-group">
        {{ Form::password('oldpassword', array('class'=>'form-control', 'placeholder'=>'Old password', 'required')) }}
        </div>
        <div class="form-group">
        {{ Form::submit('Reset admin settings', array('class'=>'btn btn-large btn-warning btn-block'))}}
        </div>
    {{ Form::close() }}
</div>
@stop