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
  User Administration | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

@if($view=='index')
<div class="row SectionHeader"><h1>Upload a File</h1></div>
 <a href="/admin-company/">Back to Company Administration</a><br />
 <a href="/admin-company/{{{$company_id}}}/edit">Back to Company Edit</a><br />
{{ Form::open(['role' => 'form', 'url' => '/admin-company/'.$company_id.'/uploads/', 'method' => 'post', 'files' => true]) }}
<div class="row">	
		<div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-10">
                    <label for="file" >Choose File</label>
                      {{ Form::file('file') }}
                    </div>
                  </div>
                </div>
                  <div class="col-md-4">
                    <div class='form-group'>
                        <label for="file_name">File Name</label><span class="req">*</span>
                        <input placeholder="File Name" class="form-control" name="file_name" type="text" value="" id="file_name">
                    </div>
                  </div>
  <div class="col-md-4">
                    <div class='form-group'>
                        <label for="file_desc">File Description</label><span class="req">*</span>
                        <textarea placeholder="File Description" class="form-control" name="file_desc" type="text" id="file_desc"></textarea>
                    </div>
                  </div>
</div>
 <div class="row" >
    <div class="form-group col-sm-3">
      {{ Form::submit('Submit') }}
    </div>
  </div>

 	{{ Form::close() }}
	
	<div class="table-responsive">

    <!-- Companies  -->
		<table class="table table-bordered table-striped"> 
			<thead>
				<tr>
					<th>File Name</th>
					<th>Description</th>
					<th>File</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($items as $itemVar)
					<tr>
						<td>{{{ $itemVar->name }}}</td>
						<td>{{{ $itemVar->description }}}</td>
                                                <td><a href="">{{{ $itemVar->filename }}}</td>
						<td>
                                                  <a href="/admin-company/{{{$company_id}}}/uploads/{{{$itemVar->id}}}/"><i class="fa fa-pencil fa-lg"></i></a>
                                                  <a href="/admin-company/{{{$company_id}}}/uploads/{{{$itemVar->id}}}/destroy"><i class="fa fa-trash-o fa-lg confirmation-callback"></i></a>
                                                </td>
					</tr>
				@endforeach
			</tbody> 
		</table>
	</div>
@elseif($view=='edit')

{{ Form::open(['role' => 'form', 'url' => "/admin-company/".$company_id."/uploads/".$item->id."/edit", 'method' => 'post', 'files' => true]) }}
<div class="row">	
		<div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-10">
                    <label for="file" >Choose File</label>
                      {{ Form::file('file') }}
                    </div>
                  </div>
                </div>
                  <div class="col-md-4">
                    <div class='form-group'>
                        <label for="file_name">File Name</label><span class="req">*</span>
                        <input placeholder="File Name" class="form-control" name="file_name" type="text" value="{{{$item->name}}}" id="file_name">
                    </div>
                  </div>
  <div class="col-md-4">
                    <div class='form-group'>
                        <label for="file_desc">File Description</label><span class="req">*</span>
                        <textarea placeholder="File Description" class="form-control" name="file_desc" type="text" id="file_desc">{{{$item->description}}}</textarea>
                    </div>
                  </div>
</div>
 <div class="row" >
    <div class="form-group col-sm-3">
      {{ Form::submit('Submit') }}
    </div>
  </div>

 	{{ Form::close() }}


@endif
@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
