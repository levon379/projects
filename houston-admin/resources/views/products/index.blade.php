@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Products<small> view</small></h1></div>
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
        <a href="/admin/products" class="btn btn-default active"><div>Products</div></a>
    </div>
	<div class="col-lg-12">
		<h4><a class="operation-link" href="/admin/products/add">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
	</div>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">Products</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Default Price</th>
                            <th>Start Times</th>
                            <th>Provider</th>
                            <th>City</th>
                            <th>Type</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ App\Libraries\Helpers::formatPrice($product->default_price) }} €</td>
                            <td>{{ $product->start_times }}</td>
                            <td>{{ $product->provider->name }}</td>
                            <td>{{ $product->city->name }}</td>
                            <td>{{ $product->type->name }}</td>
                            <td>
                                <a href="/admin/products/{{ $product->id }}/details" class="btn btn-success btn-xs">View Details ({{ count($product->language_details) }})</a>
                            </td>
                            <td>
                                <a href="/admin/products/{{ $product->id }}/options" class="btn btn-success btn-xs">View Options ({{ count($product->options) }})</a>
                            </td>
                            <td>
                                <form action="/admin/products/{{ $product->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $products->render() !!}
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
    $(document).ready(function(){

        var confirmText = "This product will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop