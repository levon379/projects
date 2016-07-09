@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/admin-category" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/admin.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
 Company Address Administration | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<h1>Company Address Administration</h1>

<b>Company:</b> {{{ $companyInfo->company_name }}}
<br /><br />
	<a href="/admin-company-address/{{ $companyInfo->id }}/0/edit"><i class="fa fa-plus fa-lg fa-grey"></i> Add New Company Address</a>
	<div class="table-responsive">
		<table class="table table-bordered table-striped"> 
			<thead>
				<tr>
					<th>Name</th>
					<th>Type</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($items as $itemVar)
				<tr bgcolor='{{{$itemVar->status_color}}}'>
					<td>{{{$itemVar->company.' - '.$itemVar->address.', '.$itemVar->city}}}</td>
					<td>{{{$itemVar->ship_or_recv}}}</td>
					<td>{{{$itemVar->status_name}}}</td>
					<td>
						  <a href="/admin-company-address/{{ $companyInfo->id}}/{{$itemVar->id }}/edit" class="table-link"><i class="fa fa-pencil fa-lg"></i></a>
						  &nbsp;&nbsp; 
						  <script type="text/javascript">$(document).ready(function() {$("#link{{$itemVar->id}}").popConfirm();});</script>
						  <a href="/admin-company-address/{{ $itemVar->id }}/destroy" class="table-link" id="link{{$itemVar->id}}"><i class="fa fa-trash-o fa-lg confirmation-callback"></i></a>
					</td>
				</tr>
				@endforeach
			</tbody> 
		</table>
	</div>
@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
    
