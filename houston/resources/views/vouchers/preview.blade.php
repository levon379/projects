{{--
@extends('layouts.master')

@section("content")
	<h3>Preview {{ $voucher->name }}</h3>
	<div class="preview-window">
		<iframe src='{{ URL::to("admin/vouchers/html/{$voucher->id}") }}' frameborder="0" width="100%" height="500px"></iframe>
	</div>
@stop
--}}


{{ URL::to("admin/vouchers/html/{$voucher->id}") }}