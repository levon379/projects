@extends('layouts.master')

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
  Contact Us | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<h1>Contact Us</h1>

@if($view == 'index')
	<p class="msg">
	  Your comments and suggestions are important to us. Please use the space
	  provided below, or call us at <strong>519-325-0111</strong>.</p>
        <pre>

        </pre>
	<div class="well">
	  <table class="table contact-table">
		<tr>
		  <td>Company:</td>
		  <td>{{{ $user->companyInfo->name or "" }}}</td>
		</tr>
		<tr>
		  <td>Name:</td>
		  <td>{{{ $user->name or "" }}}</td>
		</tr>
		<tr>
		  <td>Phone:</td>
		  <td>{{{ $user->office_phone or "" }}}</td>
		</tr>
		<tr>
		  <td>Mobile:</td>
		  <td>{{{ $user->cell_phone or ""}}}</td>
		</tr>
		<tr>
		  <td>Email:</td>
		  <td>{{{ $user->email or ""}}}</td>
		</tr>
	  </table>

	  <form action="contact-us" method="post" class="contact-form">
		<div class="form-group">
		  <label for="comment">Comments:</label>
		  <textarea name="comment" id="comment" cols="30" rows="10" class="form-control"></textarea>
		</div>
		<button class="btn btn-lg btn-primary" type="submit">Send Message</button>
	  </form>
	</div>

@elseif($view=='thanks')

	<p class="msg">
	  </p>

	<div class="well">
	  <table class="table contact-table">
		<tr>
		  <td>Company:</td>
		  <td>{{{ $user->companyInfo->name }}}</td>
		</tr>
		<tr>
		  <td>Name:</td>
		  <td>{{{ $user->name }}}</td>
		</tr>
		<tr>
		  <td>Phone:</td>
		  <td>{{{ $user->office_phone }}}</td>
		</tr>
		<tr>
		  <td>Mobile:</td>
		  <td>{{{ $user->cell_phone }}}</td>
		</tr>
		<tr>
		  <td>Email:</td>
		  <td>{{{ $user->email }}}</td>
		</tr>
		<tr>
		  <td>Comments:</td>
		  <td>{{ $pageData['comment'] }}</td>
		</tr>
	  </table>
	</div>

@endif

@stop
    
{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
  <script src="js/contact.js"></script>
@stop

