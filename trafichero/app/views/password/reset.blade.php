@extends('layout.reset')
@section('content')
@if (Session::has('error'))
    {{ trans(Session::get('reason')) }}
@endif

{{ Form::open(array('route' => array('password_update', $token),'class'=>'form-signin')) }}
    <div class="form-group">
        {{ Form::password('password', array('class' => 'form-control', 'placeholder'=>'Password', 'required' => '')) }}
    </div>

    <div class="form-group">
        {{ Form::password('password_confirmation',  array('class' => 'form-control', 'placeholder'=>'Confirm password', 'required' => '')) }}
    </div>

{{ Form::hidden('token', $token) }}

<p>{{ Form::submit('Submit', array('class' => 'btn btn-warning')) }}</p>

{{ Form::close() }}

@stop