@extends('layouts.master-email')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/contact-us" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/contact.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Email Testing | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<?php 
$headline=$Headline[0];
$pageData=$pageData[0];
?>
            
<h1>Contact Us</h1>

{{{ $userInfo->name }}} submitted the following details via the Contact Us form:

	<div class="well">
	  <table class="table contact-table">
		<tr>
		  <td>Company:</td>
		  <td>{{{ $userInfo->companyInfo->name }}}</td>
		</tr>
		<tr>
		  <td>Name:</td>
		  <td>{{{ $userInfo->name }}}</td>
		</tr>
		<tr>
		  <td>Phone:</td>
		  <td>{{{ $userInfo->office_phone }}}</td>
		</tr>
		<tr>
		  <td>Mobile:</td>
		  <td>{{{ $userInfo->cell_phone }}}</td>
		</tr>
		<tr>
		  <td>Email:</td>
		  <td>{{{ $userInfo->email }}}</td>
		</tr>
		<tr>
		  <td>Comments:</td>
		  <td>{{ $pageData['comment'] }}</td>
		</tr>
	  </table>
	</div>

@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
    
