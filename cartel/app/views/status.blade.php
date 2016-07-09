@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/status" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/bid-details.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
Nothing to see here... | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')
<h1>Nothing to see here...</h1>

<p class="bg-info">
  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam, earum, ullam at ducimus tempora unde ratione, perferendis vero fugiat eum nisi. Ipsa ea, sequi laborum, veniam voluptates culpa pariatur excepturi.</p>

<a href="view-a-bid" class="btn btn-primary btn-lg">OK</a>


@stop {{-- content --}}

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
