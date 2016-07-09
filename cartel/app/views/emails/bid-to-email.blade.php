@extends('layouts.master-email')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/email-testing" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/view-a-bid.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Email Testing | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

@if(Config::get('mail.pretend'))
	<?php
	$pageData=$emailData['pageData'][0];
	$productOwnerInfo=$emailData['productOwnerInfo'];
	$bidType=$emailData['bidType'][0];
	$bidInfo=$emailData['bidInfo'];
	?>
@else
	<?php 
	$pageData=$pageData[0];
	$productOwnerInfo=$productOwnerInfo;
	$bidType=$bidType[0];
	$bidInfo=$bidInfo;
	?>
@endif     
            
<h1>Bid to {{{ $bidType['word_cap'] }}}</h1>

Attention!!! View offer for your product.
<br><br>
Please visit the web site to Accept or Decline ASAP.<br>
<a href='{{{ Request::url() }}}/create-edit-a-post'>VIEW THE BID</A><br>
<br>
Thank you, <br>
{{{ $pageData['companyName'] }}}<br>
<a href="{{{ $pageData['companyURL'] }}}">{{{ $pageData['companyURL'] }}}</a><br>

@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
    
