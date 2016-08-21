@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Addons <small>view</small></h1></div>
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
		<h4><a class="operation-link" href="/admin/addons/add">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
	</div>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">Addons</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Adult Price</th>
                            <th>Adult Age</th>
                            <th>Child Price</th>
                            <th>Child Age</th>
                            <th>Photo</th>
                            <th>English Description</th>
                            <th>French Description</th>
                            <th>German Description</th>
                            <th>Italian Description</th>
                            <th>Spanish Description</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($addons as $addon)
                        <tr>
                            <td>{{ $addon->name }}</td>
                            <td>{{ $addon->adult_price }}</td>
                            <td>{{ $addon->adult_age }}</td>
                            <td>{{ $addon->child_price }}</td>
                            <td>{{ $addon->child_age }}</td>
                            <td>{{ $addon->Photo }}</td>
                            <td>{{ $addon->en_description }}</td>
                            <td>{{ $addon->fr_description }}</td>
                            <td>{{ $addon->de_description }}</td>
                            <td>{{ $addon->ita_description }}</td>
                            <td>{{ $addon->es_description }}</td>
                            <td>
                                <form action="/admin/addons/{{ $addon->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/addons/{{ $addon->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $addons->render() !!}
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
    $(document).ready(function(){

        var confirmText = "This addon will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop