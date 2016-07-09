@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/view-the-board" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/view-the-board-closed.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
View The Board (Closed) | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<h1> View the Board </h1>
<div class="textcontent">
  <p>The Product Board is now <strong>closed</strong>.</p>
  <p>The Board will reopen at {{{ $boardOpeningTime }}} and close at {{{ $boardClosingTime }}}.</p>
  <p>All BIDS IN PROGRESS can and will be processed A.S.A.P</p>
  <p>We appreciate your support and hope you had a great day!!!</p> 
</div>


@stop {{-- content --}}


{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
	<script src="js/view-the-board.js"></script>
@stop
