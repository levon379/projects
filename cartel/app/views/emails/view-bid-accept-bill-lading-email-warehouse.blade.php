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
	$orderInfo=$viewData['orderInfo'];
	$viewInfo=$viewData['viewInfo'];
	?>
@else
	<?php 
	$pageData=$pageData;
	$orderInfo=$orderInfo;
	$viewInfo=$viewInfo;
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
<table width='560' border='0'>
  <tr>
    <td>
    	Hello {{{ $orderInfo->buyerInfo->companyInfo->name }}} Receiving,
    	<BR>    
		Please find a Bill of Lading attached to this message.
		<BR><BR>				
		If you are unable to view the attached document, please contact us immediately.
    </td>
  </tr>
</table>

<br>
Thank you, <br>
{{{ $pageData['companyName'] }}}<br>
<a href='{{{ $pageData['companyURL'] }}}'>{{{ $pageData['companyURL'] }}}</a><br>

@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@stop
    
