@extends('layouts.master')

@section('content')
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
<div class="page-header"><h1>Product Image Placements<small></small></h1></div>
<div class="row">
	<div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">{{ ucwords($mode) }} Product Image Placement</div>
            <div class="panel-body">
                <form action="{{ URL::to($mode == 'add' ? '/admin/products/images/placements/add' : '/admin/products/images/placements/' . $productImagePlacement->id . '/edit') }}" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($productImagePlacement) ? $productImagePlacement->name : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" name="description" id="description" placeholder="Description" autocomplete="off" value="{{ Input::old('description', isset($productImagePlacement) ? $productImagePlacement->description : null) }}">
                    </div>
                    <button type="submit" class="btn btn-purple">Submit</button>
                </form>

            </div>
        </div>
    </div>
    <div class="col-md-8">

        <div class="panel panel-default">
            <div class="panel-heading">Product Image Placements</div>
            <div class="panel-body table-responsive">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productImagePlacements as $productImagePlacement)
                        <tr>
                            <td>{{ $productImagePlacement->name }}</td>
                            <td>{{ $productImagePlacement->description }}</td>
                            <td>
                                <form action="/admin/products/images/placements/{{ $productImagePlacement->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/products/images/placements/{{ $productImagePlacement->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
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

        var confirmText = "This Image type will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop