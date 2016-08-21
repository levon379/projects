@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Product Options<small> view <strong>({{ $product->name }})</strong></small></h1></div>
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
        <a href="/admin/products/{{ $product->id }}/options" class="btn btn-default active"><div>Options</div></a>
    </div>
	<div class="col-lg-12">
		<h4><a class="operation-link" href="/admin/products/{{ $product->id }}/options/add">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
	</div>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">Product Options</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Product</th>
                            <th>Availability Slot</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Adult Price</th>
                            <th>Child Price</th>
                            <th>Travel Season Start</th>
                            <th>Travel Season End</th>
                            <th>Book Season Start</th>
                            <th>Book Season End</th>
                            <th>Shown</th>
                            <th>On Request</th>
                            <th>Fixed Price</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productOptions as $productOption)
                        <tr>
                            <td>{{ $productOption->name }}</td>
                            <td>{{ $productOption->product->name }}</td>
                            <td>{{ $productOption->availslot->name }}</td>
                            <td>
                                @if ($productOption->start_time !== null)
                                    {{ Carbon\Carbon::parse($productOption->start_time)->format('h:i A') }}    
                                @else
                                    Various
                                @endif
                            </td>
                            <td>
                                @if ($productOption->end_time !== null)
                                    {{ Carbon\Carbon::parse($productOption->end_time)->format('h:i A') }}
                                @else
                                    Various
                                @endif
                                    
                            </td>
                            <td>{{ App\Libraries\Helpers::formatPrice($productOption->adult_price) }} €</td>
                            <td>{{ App\Libraries\Helpers::formatPrice($productOption->child_price) }} €</td>
                            <td>{{ App\Libraries\Helpers::displayTableDate($productOption->trav_season_start) }}</td>
                            <td>{{ App\Libraries\Helpers::displayTableDate($productOption->trav_season_end) }}</td>
                            <td>{{ App\Libraries\Helpers::displayTableDate($productOption->book_season_start) }}</td>
                            <td>{{ App\Libraries\Helpers::displayTableDate($productOption->book_season_end) }}</td>
							<td class="text-center">{!! $productOption->getShown() !!}</td>
                            <td class="text-center">{!! $productOption->getOnRequest() !!}</td>
                            <td class="text-center">{!! $productOption->getFixedPrice() !!}</td>
                            <td>
                                <a href="/admin/products/{{ $product->id }}/options/add?id={{ $productOption->id }}" class="btn btn-info btn-xs">Duplicate</a>
                            </td>
							<td>
                                <form action="/admin/products/options/{{ $productOption->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/products/options/{{ $productOption->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
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

        var confirmText = "This product option will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop
