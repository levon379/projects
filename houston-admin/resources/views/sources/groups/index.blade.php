@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Source Groups<small></small></h1></div>
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! Session::get('success') !!}
</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! Session::get('error') !!}
</div>
@endif
@if($errors->any())
<div class="validation-summary-errors alert alert-danger">
	<ul>
		{!! implode('', $errors->all('<li class="error">:message</li>')) !!}
	</ul>
</div>
@endif
<div class="row">
    
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">{{ ucwords($mode) }} Source Group</div>
			<div class="panel-body">
				<form action="{{ URL::to($mode == 'add' ? '/admin/sources/groups/add' : '/admin/sources/groups/' . $sourceGroup->id . '/edit') }}" role="form" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($sourceGroup) ? $sourceGroup->name : null) }}">
					</div>
					<button type="submit" class="btn btn-purple">Submit</button>
				</form>

			</div>
		</div>
	</div>
	<div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">Source Groups</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sourceGroups as $sourceGroup)
                        <tr>
                            <td>{{ $sourceGroup->name }}</td>
                            <td>
                                <form action="/admin/sources/groups/{{ $sourceGroup->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/sources/groups/{{ $sourceGroup->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
    $(document).ready(function(){

        var confirmText = "This source group will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop