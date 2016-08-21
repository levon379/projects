@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Feedback Emails<small> view</small></h1></div>
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
		<h4><a class="operation-link" href="/admin/feedback-emails/add">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
	</div>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">Feedback Emails</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>From Email</th>
                            <th>Subject</th>
                            <th>Provider</th>
                            <th>Language</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($feedbackEmails as $feedbackEmail)
                        <tr>
                            <td>{{ $feedbackEmail->name }}</td>
                            <td>{{ $feedbackEmail->from_email }}</td>
                            <td>{{ $feedbackEmail->subject }}</td>
                            <td>{{ $feedbackEmail->provider->name }}</td>
                            <td>{{ $feedbackEmail->language->name }}</td>
                            <td>
                                <form action="/admin/feedback-emails/{{ $feedbackEmail->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/feedback-emails/{{ $feedbackEmail->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
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

        var confirmText = "This feedback email will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop
