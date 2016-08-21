@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Providers<small></small></h1></div>
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
            <div class="panel-heading">{{ ucwords($mode) }} Provider</div>
            <div class="panel-body">
                <form action="{{ URL::to($mode == 'add' ? '/admin/providers/add' : '/admin/providers/' . $provider->id . '/edit') }}" role="form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Photo</label><br>
                        <div class="fileinput-eco fileinput-eco-{{ $newImage ? 'new' : 'exists' }}" data-provides="fileinputeco">
                            <div class="fileinput-eco-preview thumbnail" style="width: 200px; height: 150px;">
                                @if (isset($provider))
                                    @if (!empty($provider->image_extension))
                                        <img data-src="/images/providers/{{ $provider->id }}" src="/images/providers/{{ $provider->id }}" alt="...">
                                    @endif
                                @endif
                            </div>
                            <div>
                                <span class="btn btn-success btn-file-eco"><span class="fileinput-eco-new">Select image</span><span class="fileinput-eco-exists">Change</span><input type="file" name="photo"></span>
                                <a href="#" class="btn btn-default fileinput-eco-exists" data-dismiss="fileinputeco">Remove</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($provider) ? $provider->name : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="contact_details">Contact Details</label>
                        <textarea class="form-control" name="contact_info" cols="65" rows="2">{!! Input::old('contact_info', isset($provider) ? $provider->contact_info : null) !!}</textarea>
                    </div>
                    <button type="submit" class="btn btn-purple">Submit</button>
                </form>

            </div>
        </div>
    </div>
    <div class="col-md-8">

        <div class="panel panel-default">
            <div class="panel-heading">Providers</div>
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
                        @foreach($providers as $provider)
                        <tr>
                            <td>{{ $provider->name }}</td>
                            <td>
                                <form action="/admin/providers/{{ $provider->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/providers/{{ $provider->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    {!! $providers->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
    $(document).ready(function(){

        var confirmText = "This provider will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop