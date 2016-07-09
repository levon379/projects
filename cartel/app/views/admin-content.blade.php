@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/admin-content" />
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

<h1>{{{$adminVars['adminWordCap']}}} Administration - {{{ ucwords($pageData['content_group']) }}}</h1>

@if($view=='index')
	<div class="col-md-4">Choose Language:</div>
	@foreach ($languageOptions as $value)
		<div class="col-md-2"><a href="/{{{ $adminVars['adminURI'].'/'.$pageData['content_group'].'/'.$value->id}}}">{{{ $value->name }}}</a></div>
	@endforeach
	<BR><BR>
	<a href="/{{{$adminVars['adminURI'].'/'.$pageData['content_group'].'/'.$pageData['content_lang']}}}/0/edit"><i class="fa fa-plus fa-lg fa-grey"></i> Add New {{{ ucwords($pageData['content_group']) }}} {{{$adminVars['adminWordCap']}}}</a>
	<div class="table-responsive">
		<table class="table table-bordered table-striped"> 
			<thead>
				<tr>
					<th>Name</th>
					<th>Language</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($items as $itemVar)
				<tr>
					<td>{{{$itemVar['name']}}}</td>
					<td>{{{$itemVar['language_name']}}}</td>
					<td>
						  <a href="/{{{$adminVars['adminURI'].'/'.$pageData['content_group'].'/'.$pageData['content_lang'].'/'.$itemVar['id'] }}}/edit" class="table-link"><i class="fa fa-pencil fa-lg"></i></a>
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
 
    {{ Form::open(['role' => 'form', 'url' => '/'.$adminVars['adminURI'].'/'.$pageData['content_group'].'/'.$pageData['content_lang'].'/'.$details->id.'/store']) }}
 
 	<div class="row">
 		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="name">Name</label>
				 <input placeholder="Name" class="form-control" name="name" type="text" value="{{{ $details->name }}}" @if($details->id!=0) readonly @endif id="name">
			 </div>
			 <div class='form-group'>
				 <label for="name">Content ({{{$details->language_name}}})</label>
				 <textarea cols=100 rows=10 class="form-control" name="content" id="content">{{{ $details->content }}}</textarea>
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
    
