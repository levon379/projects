@extends('layout.default')
@section('content')
<div style="height: 100px;"></div>
@if($errors->has('email'))
    {{$errors->first('email')}}
@endif
<div class="col-lg-5 col-lg-offset-3">
    {{ Form::open(array('url'=> action('PasswordController@postReset'), 'method' => 'post')) }}
     <div class="input-group">
          {{ Form::email('email',Input::old('email'),array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
          <span class="input-group-btn">
          {{ Form::submit('Send Reminder', array('class'=>'btn btn-default'))}}
          </span>
     </div>

    {{ Form::close() }}
</div>
@stop
