@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/admin-permission" />
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
						  <a href="/{{$adminVars['adminURI'].'/'.$itemVar->id }}/edit" class="table-link"><i class="fa fa-pencil fa-lg"></i></a>
						  &nbsp;&nbsp; 
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
 
    {{ Form::open(['role' => 'form', 'url' => '/'.$adminVars['adminURI'].'/'.$details->id.'/store']) }}
 
 	<div class="row">
 		<div class="col-md-8">
			 <div class='form-group'>
				 <label for="name">Permission Group Name:</label>
				 {{{ $details->name }}}
			 </div>
		 </div>
	</div>
 	<div class="row">
 		<div class="col-md-5">
			 <div class='form-group'>
				<label for="moduleperms">Site Modules</label>
			</div>
			 <div class='form-group'>
				  @foreach ($permModuleOptions as $qKey => $qVal)
					<div class="checkbox">
					<label><input name="moduleperms[]" type="checkbox" value="{{{ $qVal['id'] }}}" id="moduleperms" @if((int)$qVal['id'] & (int)$details->moduleperms) checked @endif>{{{ $qVal['showname'] }}}</label>
					</div>
				  @endforeach
			</div>
		</div>
 		<div class="col-md-5">
			 <div class='form-group'>
				<label for="moduleperms">Admin Modules</label>
			</div>
			 <div class='form-group'>
				  @foreach ($permModuleAdminOptions as $qKey => $qVal)
					<div class="checkbox">
					<label><input name="moduleperms[]" type="checkbox" value="{{{ $qVal['id'] }}}" id="moduleperms" @if((int)$qVal['id'] & (int)$details->moduleperms) checked @endif>{{{ $qVal['showname'] }}}</label>
					</div>
				  @endforeach
			</div>
		</div>
	</div>
	<div class="row">
 		<div class="col-md-6">
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
    
