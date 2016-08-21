@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Orders<small></small></h1></div>
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
<div class="row breadcrumb-row">
    <div class="btn-group btn-breadcrumb col-lg-12">
        <a href="/admin/orders" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/orders" class="btn btn-default active"><div>Orders</div></a>
    </div>
</div>
<div class="row">
	<div class="col-md-4">
        
        <div class="panel panel-default">
            <div class="panel-heading">Edit Order {{ $mode == 'edit' ? "No. $order->id" : ""}}</div>
            <div class="panel-body">
                <form action="{{ URL::to($mode == 'add' ? '/admin/orders/add' : '/admin/orders/' . $order->id . '/edit') }}" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="reference-no">Reference No.</label>
                        <input type="text" class="form-control" name="reference_no" id="reference_no" placeholder="Reference No." autocomplete="off" value="{{ Input::old('reference_no', isset($order) ? $order->reference_no : null) }}" {{ $mode == 'edit' ? '' : 'readOnly'}}>
                    </div>
                    <button type="submit" class="btn btn-purple" {{ $mode == 'edit' ? '' : 'disabled'}}>Save Changes</button>
                    <a href="/admin/orders" class="btn btn-warning" {{ $mode == 'edit' ? '' : 'disabled'}}>Cancel</a>
                </form>

            </div>
        </div>
    </div>
    <div class="col-md-8">

        <div class="panel panel-default">
            <div class="panel-heading">Orders</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Order No.</th>
                            <th>Reference No.</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->reference_no }}</td>
                            <td style="width:110px;">
                                <a class="btn btn-success btn-xs" href="/admin/orders/{{$order->id}}/bookings">View Bookings ({{$order->getBookingCount()}})</a>
                            </td>
                            <td style="width:50px;">
                                <form action="/admin/orders/{{ $order->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td style="width:30px;">
                                <a href="/admin/orders/{{ $order->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $orders->render() !!}
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
    $(document).ready(function(){

        var confirmText = "This order and the linked bookings will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop