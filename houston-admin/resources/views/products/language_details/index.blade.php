@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Product Details<small> view <strong>({{ $product->name }})</strong></small></h1></div>
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
        <a href="/admin/products" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/products" class="btn btn-default"><div>Products</div></a>
        <a href="/admin/products/{{ $product->id }}/details" class="btn btn-default active"><div>Details</div></a>
    </div>
	<div class="col-lg-12">
		<h4><a class="operation-link" href="/admin/products/{{ $product->id }}/details/add">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
	</div>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">Product Details</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Language</th>
                            <th>Mini Description</th>
                            <th>Duration</th>
                            <th>Minimum</th>
                            <th>Max Group</th>
                            <th>Running Days</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productDetails as $productDetail)
                        <tr>
                            <td>{{ $productDetail->name }}</td>
                            <td>{{ $productDetail->language->name }}</td>
                            <td>{{ strip_tags($productDetail->minidescription) }}</td>
                            <td>{{ $productDetail->duration }}</td>
                            <td>{{ $productDetail->minimum }}</td>
                            <td>{{ $productDetail->maxgroup }}</td>
                            <td>{{ strip_tags($productDetail->running_days) }}</td>
                            <td>
                                <form action="/admin/products/details/{{ $productDetail->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/products/details/{{ $productDetail->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
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

        var confirmText = "This product detail will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop
