@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/admin-origin" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/admin.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
 {{{$adminVars['adminWordCap']}}} Administration | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<h1>{{{$adminVars['adminWordCap']}}} Administration</h1>

@if($view=='index')
	<a href="/{{{$adminVars['adminURI']}}}/0/edit"><i class="fa fa-plus fa-lg fa-grey"></i> Add New {{{$adminVars['adminWordCap']}}}</a>
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
	<a href="/admin-province/origin/0/edit"><i class="fa fa-plus fa-lg fa-grey"></i> Add New Origin-Province</a>
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
				@foreach ($items as $itemVar)
					<tr bgcolor='{{{ $itemVar->status_color }}}'>
						<td>{{{ $itemVar->name }}}</td>
						<td>{{{ $itemVar->status_name }}}</td>
						<td>
							  <a href="/{{ $adminVars['adminURI'].'/'.$itemVar->id }}/edit" class="table-link"><i class="fa fa-pencil fa-lg"></i></a>
							  &nbsp;&nbsp; 
							  <script type="text/javascript">$(document).ready(function() {$("#link{{ $itemVar->id }}").popConfirm();});</script>
							  <a href="/{{ $adminVars['adminURI'].'/'.$itemVar->id }}/destroy" class="table-link" id="link{{ $itemVar->id }}"><i class="fa fa-trash-o fa-lg confirmation-callback"></i></a>
						</td>
					</tr>
					
					{{-- Subcategories / Provinces --}}
					@foreach ($itemVar->sub as $subitemVar)

						<tr bgcolor='{{{ $subitemVar->status_color }}}'>
							<td> &nbsp; <i class="fa fa-caret-right fa-lg"></i> {{{ $subitemVar->name }}}</td>
							<td>{{{ $subitemVar->status_name }}}</td>
							<td>
								  <a href="/admin-province/origin/{{ $subitemVar->id }}/edit" class="table-link"><i class="fa fa-pencil fa-lg"></i></a>
								  &nbsp;&nbsp; 
								  <script type="text/javascript">$(document).ready(function() {$("#plink{{ $subitemVar->id }}").popConfirm();});</script>
								  <a href="/admin-province/origin/{{ $subitemVar->id }}/destroy" class="table-link" id="plink{{ $subitemVar->id }}"><i class="fa fa-trash-o fa-lg confirmation-callback"></i></a>
							</td>
						</tr>  
					@endforeach

				@endforeach
			</tbody> 
		</table>
	</div>

@elseif($view=='form')

	Please enter or modify the details below:

    @if ($errors->has())
        @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
        @endforeach
    @endif
 
    {{ Form::open(['role' => 'form', 'url' => '/'.$adminVars['adminURI'].'/'.$details->id.'/store', 'ENCTYPE' => 'multipart/form-data']) }}
 
 	<div class="row">
 		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="name">Name</label>
				 <input placeholder="Name" class="form-control" name="name" type="text" value="{{{ $details->name }}}" id="name">
			 </div>
			 <div class='form-group'>
				 <label for="image">Short Image</label><BR> <img src="{{ URL::asset('images/labels/'.$details->image) }}" height="50">{{ $details->image }}
				 <input placeholder="Image" class="form-control" name="image" type="file" value="{{{ $details->image }}}" id="image">
				 <h6>(Leave image as-is if not changing)</h6>
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
    
