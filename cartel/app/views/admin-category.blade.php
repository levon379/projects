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
 Category Administration | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<h1>Category Administration</h1>

@if($view=='index')
	<a href="/admin-category/0/edit"><i class="fa fa-plus fa-lg fa-grey"></i>Add New Category</a>
	<div class="table-responsive">
		<table class="table table-bordered table-striped"> 
			<thead>
				<tr>
					<th>Name</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				@foreach($items as $itemVar)
					<tr bgcolor='{{{ $itemVar->status_color }}}'>
						<td>{{{ $itemVar->name }}}</td>
						<td>{{{ $itemVar->status_name }}}</td>
						<td>
							  <a href="/admin-category/{{ $itemVar->id }}/edit" class="table-link"><i class="fa fa-pencil fa-lg"></i></a>
							  &nbsp;&nbsp; 
							  <script type="text/javascript">$(document).ready(function() {$("#link{{$itemVar->id}}").popConfirm();});</script>
							  <a href="/admin-category/{{ $itemVar->id }}/destroy" class="table-link" id="link{{ $itemVar->id }}"><i class="fa fa-trash-o fa-lg confirmation-callback"></i></a>
						</td>
					</tr>
					
					{{-- Subcategories / Varieties --}}
					@foreach ($itemVar->sub as $subitemVar)

						<tr bgcolor='{{{$subitemVar->status_color}}}'>
							<td> &nbsp; <i class="fa fa-caret-right fa-lg"></i> {{{$subitemVar->name}}}</td>
							<td>{{{$subitemVar->status_name}}}</td>
							<td>
								  <a href="/admin-category/{{ $subitemVar->id }}/edit" class="table-link"><i class="fa fa-pencil fa-lg"></i></a>
								  &nbsp;&nbsp; 
								  <script type="text/javascript">$(document).ready(function() {$("#link{{$subitemVar->id}}").popConfirm();});</script>
								  <a href="/admin-category/{{ $subitemVar->id }}/destroy" class="table-link" id="link{{$subitemVar->id}}"><i class="fa fa-trash-o fa-lg confirmation-callback"></i></a>
							</td>
						</tr>  
					@endforeach

				@endforeach
			</tbody> 
		</table>
	</div>

@elseif($view=='form')

Please enter or modify the details below:
  
{{ Form::open(['role' => 'form', 'url' => '/admin-category/'.$details->id.'/store']) }}
 	<div class="row">
 		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="name">Name</label>
				 <input placeholder="Name" class="form-control" name="name" type="text" value="{{{ $details->name }}}" id="name">
			 </div>
			 <div class='form-group'>
				<label for="parent_id">Parent</label>
				<select name="parent_id" id="parent_id" class="form-control input-lg">
				  <option value="0">- No Parent -</option>
				  @foreach ($parentIDOptions as $qKey => $qVal)
					<option value="{{{ $qVal['id'] }}}" @if($qVal['id'] == $details->parent_id) selected @endif>
					  {{{ $qVal['name'] }}}
					</option>
				  @endforeach
				 </select>
			</div>
			<div class='form-group'>
				<label for="status_id">Status</label>
				<select name="status_id" id="status_id" class="form-control input-lg">
				  <option value="" disabled>Choose One... </option>
				  @foreach ($statusOptions as $qKey => $qVal)
					<option value="{{{ $qVal['id'] }}}" @if($qVal['id'] == $details->status_id) selected @endif>
					  {{{ $qVal['name'] }}}
					</option>
				  @endforeach
				 </select>
			</div>

			<div class='form-group'>
			   <input class="btn btn-primary" type="submit" value="Save &raquo;">
			</div>
	    </div>
    </div>
    {{ Form::close() }}
@endif {{-- end of $view check --}}

@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
    
