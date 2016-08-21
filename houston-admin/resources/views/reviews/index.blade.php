@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Reviews<small></small></h1></div>
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
	<div class="col-lg-12">
		<h4><a class="operation-link" href="/admin/reviews/add">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
	</div>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">Reviews</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Language</th>
                            <th>Review Source</th>
                            <th>Product</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Rating</th>
							<th>Shown</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reviews as $review)
                        <tr>
                            <td>{{ $review->title }}</td>
                            <td>{{ $review->language->name }}</td>
                            <td>{{ $review->source->name }}</td>
                            <td>{{ @$review->product->name ?: "" }}</td>
							<td>{{ $review->name }}</td>
                            <td>{{ $review->email }}</td>
                            <td><div style="display:inline;color:#ffd119">{!! $review->showRating() !!}</div></td>
							<td class="text-center">{!! $review->getShown() !!}</td>
                            <td>
                                <form action="/admin/reviews/{{ $review->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/reviews/{{ $review->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $reviews->render() !!}
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
    $(document).ready(function(){

        var confirmText = "This review will be deleted";

        swlConfirm(confirmText);
		
		$('table').on('click', '.starrr', function(e, value){
		  return false;
		});

    });
</script>
@stop
