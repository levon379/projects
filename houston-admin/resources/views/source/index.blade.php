@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Net Rate<small> view</small></h1></div>
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
        <h4><a class="operation-link" href="/admin/source/add">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
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
                                <th>Source Name</th>
                                <th>Adult Net Price</th>
                                <th>Child Net Price</th>
                                <th>Source Date</th>
                                <th>Travel Start Date</th>
                                <th>Travel End Date</th>
                                <th>Booking Start Date</th>
                                <th>Booking End Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sources as $source)
                            <?php print_r($source->adult_net_rate)?>
                            <tr>
                                <td>{{ $source->source_name->name }} </td>
                                <td>{{ App\Libraries\Helpers::formatPrice($source->adult_net_rate) }}  €</td>
                                <td>{{ App\Libraries\Helpers::formatPrice($source->child_net_rate) }}  €</td>
                                <td>{{ App\Libraries\Helpers::displayDate($source->created_at->toDateString()) }}</td>
                                <td>{{ App\Libraries\Helpers::displayDate($source->trav_season_start) }}</td>
                                <td>{{ App\Libraries\Helpers::displayDate($source->trav_season_end) }}</td>
                                <td>{{ App\Libraries\Helpers::displayDate($source->book_season_start) }}</td>
                                <td>{{ App\Libraries\Helpers::displayDate($source->book_season_end) }}</td>
                                <td>
                                    <a href="/admin/source/{{ $source->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
                                    <a href="javacript:void(0)" onclick="delete_source('{{ $source->id }}')" class="btn btn-danger btn-xs">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $sources->render() !!}
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
function delete_source(source_id){
            swal({
                title: "Are you sure?",
                text: "This booking will be deleted",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d9534f",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                closeOnConfirm: true, closeOnCancel: true},
                    function (isConfirm) {
                        if (isConfirm) {
                            if (source_id > 0) {
                                $.post("/admin/source/" + source_id + "/delete", function (data) {
                                    document.location.href = '/admin/source/list';
                                });
                            }
                        }
                    }
            );
        }


</script>
@stop