@extends('layouts.master')

@section("content")
    <div class="page-header"><h1>Voucher<small></small></h1></div>
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
    @if(!$hasBookings)
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        No bookings found. Please add new bookings
    </div>
    @endif
	<div class="row">
		<div class="btn-group btn-breadcrumb col-lg-12">
		    <a class="btn btn-default" href="/admin/vouchers" style="z-index: 3;"><i class="fa fa-home"></i></a>
		    <a class="btn btn-default active" href="/admin/vouchers" style="z-index: 2;"><div>Vouchers</div></a>
		</div>
		<div class="col-lg-12">
			<h4><a href="/admin/vouchers/add" class="operation-link">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Vouchers</div>	
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<tr>
								<th>Id</th>
								<th>Name</th>
								<th>Provider</th>
								<th>Language</th>
								<th>Websites</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
							</tr>
							@foreach ($vouchers as $voucher)
								<tr>
									<td>{{ $voucher->id }}</td>
									<td>{{ $voucher->name }}</td>
									<td>{{ $voucher->provider->name or "" }}</td>
									<td>{{ $voucher->language->name }}</td>
									<td>
									@foreach ($voucher->websites as $website)
										<p>{{ $website->name }}</p>
									@endforeach
									</td>
									<td><a class="btn btn-primary btn-xs" href='{{ URL::to("/admin/vouchers/preview/{$voucher->id}") }}' target="_blank" {{ ($hasBookings) ? "" : "disabled" }} >Preview</a></td>
									<td><a class="btn btn-warning btn-xs" href='{{ URL::to("/admin/vouchers/edit/{$voucher->id}") }}'>Edit</a></td>
									<td><a class="btn btn-danger btn-xs" href='{{ URL::to("/admin/vouchers/delete/{$voucher->id}") }}'>Delete</a></td>
								</tr>
							@endforeach
						</table>
					</div>
					<div class="text-right">
						{!! $vouchers->render() !!}
					</div>
				</div>
			</div>
		</div>
	</div>	
@stop