@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Promos<small></small></h1></div>
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
<div class="row">
    <div class="btn-group btn-breadcrumb col-lg-12">
        <a href="/admin/promos" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/promos" class="btn btn-default active"><div>Promos</div></a>
    </div>
	<div class="col-lg-12">
		<h4><a class="operation-link" href="/admin/promos/add">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
	</div>
</div>
<div class="row">
	
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">Promos</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Promo Type</th>
                            <th>Travel Start Date</th>
                            <th>Travel End Date</th>
                            <th>Book Start Date</th>
                            <th>Book End Date</th>
                            <th>Percent Discount</th>
                            <th>Euro Off Discount</th>
                            <th>Adult Price</th>
                            <th>Child Price</th>
                            <th>Min</th>
                            <th>Max</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($promos as $promo)
                        <tr>
                            <td>{{ $promo->name }}</td>
                            <td>{{ $promo->promo_type->name }}</td>
                            <td>{{ App\Libraries\Helpers::displayDate($promo->travel_start_date) }}</td>
                            <td>{{ App\Libraries\Helpers::displayDate($promo->travel_end_date) }}</td>
                            <td>{{ App\Libraries\Helpers::displayDate($promo->book_start_date) }}</td>
                            <td>{{ App\Libraries\Helpers::displayDate($promo->book_end_date) }}</td>
                            <td>{{ $promo->percent_discount }} %</td>
                            <td>{{ App\Libraries\Helpers::formatPrice($promo->euro_off_discount) }} €</td>
                            <td>{{ App\Libraries\Helpers::formatPrice($promo->adult_price) }} €</td>
                            <td>{{ App\Libraries\Helpers::formatPrice($promo->child_price) }} €</td>
                            <td>{{ $promo->minimum }}</td>
                            <td>{{ $promo->maximum }}</td>
                            <td>
                                <form action="/admin/promos/{{ $promo->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/promos/{{ $promo->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
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

        var confirmText = "This promo will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop