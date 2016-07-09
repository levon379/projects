@extends('layouts.master-email')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/view-bid" />
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
    $pageData=$viewData['pageData'];
    $declineInfo=$viewData['declineInfo'];
	?>
@endif     
            
<style><!--
.Normal
	{font-size:12.0pt;
	font-family:'Times New Roman';}
.MsoTitle
	{text-align:center;
	font-size:20.0pt;
	font-family:'Times New Roman';
	font-weight:bold;}
-->
</style>

<div style='width:730px'>

Hello {{{ $declineInfo['bidderInfo']->name }}},
<BR>    
You were declined on your bid placed with the following details:
<BR><BR>
<B>Bid Details</B><BR>
{{{ $declineInfo['bidInfo']->productType_name }}} &nbsp;
{{{ $declineInfo['bidInfo']->product_name }}} &nbsp;
{{{ $declineInfo['bidInfo']->variety_name }}}<BR>
<BR>
Qty: {{{ $declineInfo['bidInfo']->qty }}}<BR>
Asking Price: ${{{ $declineInfo['bidInfo']->price }}}<BR>
<BR>
If you would like to bid again, please return to the Board:<BR>
<a href='http://{{{ $pageData['companyURL'] }}}/view-the-board'>{{{ $pageData['companyURL'] }}}/view-the-board</a><br>
<br>
Thank you, <br>
{{{ $pageData['companyName'] }}}<br>
<a href='http://{{{ $pageData['companyURL'] }}}'>{{{ $pageData['companyURL'] }}}</a><br>
</div>

@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@stop
    
