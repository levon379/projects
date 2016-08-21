@extends('layouts.master')

@section("content")
	<div class="page-header"><h1>Vouchers <small>Edit</small></h1></div>
	@if(Session::has('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
	@endif
	@if(Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	@if($errors->any())
	<div class="form-group">
	<div class="validation-summary-errors alert alert-danger alert-dismissable">
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<ul>
			{!! implode('', $errors->all('<li class="error">:message</li>')) !!}
		</ul>
	</div>
	@endif
<div class="row">
	<div class="btn-group btn-breadcrumb col-lg-12">
		<a class="btn btn-default" href="/admin/vouchers" style="z-index: 3;"><i class="fa fa-home"></i></a>
	    <a class="btn btn-default" href="/admin/vouchers" style="z-index: 2;"><div>Vouchers</div></a>
		<a class="btn btn-default active" href="{{ URL::to("/admin/voucher/edit/{$voucher->id}") }}" style="z-index: 2;"><div>Edit Voucher</div></a>
	</div>
	<div class="col-lg-12">
		<br>
		<div class="panel panel-default">
			<div class="panel-heading">Add Voucher</div>
			<div class="panel-body">
				<form action="{{ URL::to('/admin/vouchers/edit/' . $voucher->id) }}" method="post">
					@include("vouchers.partials.add_edit")
					<div class="form-group text-right">
						<input type="submit" class="btn btn-success" value="Update">
					</div>
				</form>
			</div>
		</div>
				
	</div>
</div>
@stop

