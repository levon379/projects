@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/terms-of-use" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/terms-of-use.css" />
	<link rel="stylesheet" href="css/public.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Terms Of Use | Cartel Marketing Inc. | Leamington, Ontario
@stop


{{-- Override guest and nav header   --}}
{{-- ----------------------------------------------------- --}}
@section('header')
  @include('layouts.headerguest')
@stop
@section('nav')
  @include('layouts.nav')
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<h1>@lang('site_content.terms_of_use_Header')</h1>

<section class="terms">
	{{ $termsContent }}
</section>

{{ Form::open(array('method'=>'post', 'url'=>'terms-of-use', 'id'=>'form-terms')) }}
  <div class="form-group check">
    <label class="checklabel">
      {{ Form::checkbox('accept','1');	}}
      @lang('site_content.terms_of_use_I_Accept_Checkbox')
    </label>
  </div>
  <div class="continue">
    <button type="submit" class="btn btn-primary btn-lg btn-continue">
        @lang('site_content.terms_of_use_Submit_Button')
    </button>
  </div>
{{ form::close() }}

@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
	<script src="js/index.js"></script>
@stop
