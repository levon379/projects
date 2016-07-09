@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/admin-origin" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="{{{ URL::asset('css/admin.css') }}}" />
	<link rel="stylesheet" href="{{{ URL::asset('lib/bootstrap-3-timepicker/css/bootstrap-timepicker.min.css') }}}" />
	<link rel="stylesheet" href="{{{ URL::asset('css/admin/board-settings.css') }}}" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
 Board Settings | Cartel Marketing Inc. | Leamington, Ontario
@stop


{{-- JS head   --}}
{{-- ----------------------------------------------------- --}}
@section('js_head')
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')
  <h1>Board Settings</h1>
  <a href="/admin_menu">Back to Admin Menu</a><br /><br />

  {{ Form::open(array('url'=>'view-the-board/edit', 'method' => 'post')) }} 
    <div class="row">
      <h3 class="col-sm-3">Board open time:</h3>
      <div class="col-sm-9 input-append bootstrap-timepicker">
        <input id="timepicker1" name="boardopens" type="text" />
        <span class="add-on"><i class="icon-time"></i></span>
      </div>
    </div>
    <div class="row">
      <h3 class="col-sm-3">Board close time:</h3>
      <div class="col-sm-9 input-append bootstrap-timepicker">
        <input id="timepicker2" type="text" name="boardcloses" />
        <span class="add-on"><i class="icon-time"></i></span>
      </div>
    </div>
    {{ Form::submit('Submit') }}
  {{ Form::close() }}
  
  
@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
  <script src="{{{ URL::asset('lib/bootstrap-3-timepicker/js/bootstrap-timepicker.js') }}}"></script>
  
  <script type="text/javascript">
  console.log("{{{ $t1 }}}");
  console.log("{{{ $t2 }}}");
    $('#timepicker1').timepicker({
        defaultTime: '{{{ $t1 }}}',
        minuteStep: 1
      });
    $('#timepicker2').timepicker({
      defaultTime: '{{{ $t2 }}}',
      minuteStep: 1
    });
  </script>
@stop
    
