@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Service Options<small> view <strong>({{ $service->name }})</strong></small></h1></div>
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
        <a href="/admin/services" class="btn btn-default"><div>Services</div></a>
		<a href="/admin/services/{{ $service->id }}/options" class="btn btn-default active"><div>Options</div></a>
    </div>
	<div class="col-lg-12">
		<h4><a class="operation-link" href="/admin/services/{{ $service->id }}/options/add">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
	</div>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">Service Options</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Service</th>
                            <th>Unit Price</th>
                            <th>IVA</th>
                            <th>Unit Price + IVA</th>
                            <th>Description</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($serviceOptions as $serviceOption)
                        <tr>
                            <td>{{ $serviceOption->name }}</td>
                            <td>{{ $serviceOption->service->name }}</td>
                            <td>{{ $serviceOption->unit_price }} €</td>
                            <td>{{ $serviceOption->iva }} €</td>
                            <td>{{ $serviceOption->unit_price_plus_iva }} €</td>
                            <td>{{ $serviceOption->description }}</td>
                            <td>
                                <form action="/admin/services/options/{{ $serviceOption->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/services/options/{{ $serviceOption->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
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

        var confirmText = "This service option will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop
