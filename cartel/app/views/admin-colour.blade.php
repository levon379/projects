@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/admin-colour" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/admin.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
 Colour Administration | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<h1>Colour Administration</h1>

@if($view=='index')
	<a href="/admin-colour/0/edit"><i class="fa fa-plus fa-lg fa-grey"></i> Add New Colour</a>
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
				<tr bgcolor='{{{$itemVar->status_color}}}'>
					<td>{{{$itemVar->name}}}</td>
					<td>{{{$itemVar->status_name}}}</td>
					<td>
						  @if($itemVar->prev_id!='')
						  		<a href="/admin-colour/{{ $itemVar->id }}/{{ $itemVar->prev_id }}/swap" class="table-link"><i class="fa fa-arrow-up fa-lg"></i></a>
						  @else
						  		<i class="fa fa-minus fa-lg"></i>
						  @endif
						  &nbsp;&nbsp; 
						  @if($itemVar->next_id!='')
							  <a href="/admin-colour/{{ $itemVar->id }}/{{ $itemVar->next_id }}/swap" class="table-link"><i class="fa fa-arrow-down fa-lg"></i></a>
						  @else
						  		<i class="fa fa-minus fa-lg"></i>
						  @endif
						  &nbsp;&nbsp; 
						  <a href="/admin-colour/{{ $itemVar->id }}/edit" class="table-link"><i class="fa fa-pencil fa-lg"></i></a>
						  &nbsp;&nbsp; 
						  <script type="text/javascript">$(document).ready(function() {$("#link{{$itemVar->id}}").popConfirm();});</script>
						  <a href="/admin-colour/{{ $itemVar->id }}/destroy" class="table-link" id="link{{$itemVar->id}}"><i class="fa fa-trash-o fa-lg confirmation-callback"></i></a>
					</td>
				</tr>
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
 
  {{ Form::open(['role' => 'form', 'url' => '/admin-colour/'.$details->id.'/store']) }}
 
 	<div class="row">
 		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="name">Name</label>
				 <input placeholder="Name" class="form-control" name="name" type="text" value="{{{ $details->name }}}" id="name">
			 </div>

			 <div class='form-group'>
				 <label for="ordernum">Order Number</label>
				 <input placeholder="####" class="form-control" name="ordernum" type="number" value="{{{ $details->ordernum }}}" id="ordernum">
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
    
