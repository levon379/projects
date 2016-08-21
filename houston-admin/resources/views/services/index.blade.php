@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Services<small> view</small></h1></div>
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
<div class="row">
	<div class="btn-group btn-breadcrumb col-lg-12">
        <a href="/admin/services" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/services" class="btn btn-default active"><div>Services</div></a>
    </div>
	<div class="col-lg-12">
		<h4><a class="operation-link" href="/admin/services/add">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
	</div>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">Services</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact Name</th>
                            <th>Contact Tel</th>
                            <th>Service Type</th>
                            <th>Vat No.</th>
                            <th>Email</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->contact_name }}</td>
                            <td>{{ $service->contact_tel }}</td>
                            <td>{{ $service->type->name }}</td>
                            <td>{{ $service->vat_no }}</td>
                            <td>{{ $service->email }}</td>
                            <td>
                                <a href="/admin/services/{{ $service->id }}/options" class="btn btn-success btn-xs">View Options ({{ count($service->options) }})</a>
                            </td>
                            <td>
                                <form action="/admin/services/{{ $service->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/services/{{ $service->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
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

        var confirmText = "This service will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop