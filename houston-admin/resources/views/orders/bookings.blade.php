@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Bookings<small>  view <strong>({{ $order->getOrderName() }})</strong></small></h1></div>
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
        <a href="/admin/orders" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/orders" class="btn btn-default"><div>Orders</div></a>
        <a href="/admin/orders/{{$orderId}}/bookings" class="btn btn-default active"><div>Bookings</div></a>
    </div>
	<div class="col-md-5">
		<h4><a class="operation-link" href="/admin/bookings/add?order={{$orderId}}">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
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
                            <th>Booking Date</th>
                            <th>Travel Date</th>
                            <th>Product & Product Option</th>
                            <th>Language</th>
                            <th>First & Last Name</th>
                            <th>Source Name</th>
                            <th>Total Pax</th>
                            <th>Total Paid</th>
                            <th>Booking Reference</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->created_at->toDateString() }}</td>
                            <td>{{ $booking->travel_date }}</td>
                            <td>{{ $booking->getProductName() }}</td>
                            <td>{{ $booking->getLanguage() }}</td>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->source_name->name }}</td>
                            <td>{{ $booking->total_pax }}</td>
                            <td>{{ $booking->total_paid }}  €</td>
                            <td>{{ $booking->reference_number }}</td>
                            <td>
                                <a href="/admin/bookings/{{ $booking->id }}/edit?order={{$orderId}}" class="btn btn-warning btn-xs">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $bookings->render() !!}
            </div>
        </div>
    </div>
</div>

@stop