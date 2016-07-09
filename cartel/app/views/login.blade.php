@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/login" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/public.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Login | Cartel Marketing Inc. | Leamington, Ontario
@stop

@section('header')
  @include('layouts.headerguest')
@stop

@section('nav')
  @include('layouts.nav')
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')
            
<h1>Login</h1>

<!-- , 'id'=>'form-login'  --- When this ID is inserted into the FORM tag below, the form stops submitting... need to investigate-->

{{ Form::open(array('method'=>'post', 'url'=>'trylogin')) }}
  <div class="col-md-6">

    <!-- Username -->
    <div class="row">
      <div class="form-group">
        <label class="control-label col-md-4" for="username">Username</label>
        <div class="col-md-8">
           <input class="form-control input-lg" name="username" type="text" value="" {{ $disableLoginForm }}>
        </div>
      </div>
    </div><!-- .row -->

    <!-- Password -->
    <div class="row">
      <div class="form-group">
        <label class="control-label col-md-4" for="password">Password</label>
        <div class="col-md-8">
          <input class="form-control input-lg" name="password" type="password" value="" {{ $disableLoginForm }}>
        </div>
      </div>
    </div><!-- .row -->

    <!-- Login Button -->
    <div class="row">
      <div class="form-group">
        <div class="col-md-offset-4 col-md-8">                  
			<input class="btn btn-lg btn-primary" data-loading-text="Logging In..." type="submit" value="Login" {{ $disableLoginForm }}>
        </div><!-- .col-md-offset-4 col-md-8 -->
      </div>
    </div><!-- .row -->

  </div><!-- col-md-6 -->

{{ form::close() }}

<!-- #login -->

@stop {{-- content --}}


{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
	<script src="js/index.js"></script>
@stop
