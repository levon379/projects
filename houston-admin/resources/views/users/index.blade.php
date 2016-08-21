@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Users<small> view</small></h1></div>
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
		<h4><a class="operation-link" href="/admin/users/add">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
	</div>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">Users</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Languages</th>
                            <th>Phone Number</th>
                            <th>User Type</th>
                            <th>Enabled</th>
                            <th>Patentino</th>
                            <th>NCC</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->firstname }}</td>
                            <td>{{ $user->lastname }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getLanguages() }}</td>
                            <td>{{ $user->tel_no }}</td>
                            <td>{{ $user->type->name }}</td>
                            <td class="text-center">{!! $user->getEnabled() !!}</td>
                            <td class="text-center">{!! $user->getPatentino() !!}</td>
                            <td class="text-center">{!! $user->getNcc() !!}</td>
                            <td style="width:50px;">
                                <form action="/admin/users/{{ $user->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td style="width:30px;">
                                <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $users->render() !!}
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
    $(document).ready(function(){

        var confirmText = "This user will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop