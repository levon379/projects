@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Bookings<small> view</small></h1></div>
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
	<div class="col-md-5">
		<h4><a class="operation-link" href="/admin/bookings/add">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
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
                            <td>{{ App\Libraries\Helpers::displayDate($booking->created_at->toDateString()) }}</td>
                            <td>{{ App\Libraries\Helpers::displayDate($booking->travel_date) }}</td>
                            <td>{{ $booking->getProductName() }}</td>
                            <td>{{ $booking->getLanguage() }}</td>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->source_name->name }}</td>
                            <td>{{ $booking->total_pax }}</td>
                            <td>{{ $booking->total_paid }}  €</td>
                            <td>{{ $booking->reference_number }}</td>
                            <td>
                                <a href="/admin/bookings/{{ $booking->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
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