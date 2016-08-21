@extends('layouts.master')

@section('content')
<div class="page-header"><h1>FAQs<small></small></h1></div>
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
        <a href="/admin/faqs" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/faqs" class="btn btn-default active"><div>FAQs</div></a>
    </div>
	<div class="col-lg-12">
		<h4><a class="operation-link" href="/admin/faqs/add">Add <i class="glyphicon glyphicon-plus-sign operation-icon"></i></a></h4>
	</div>
</div>
<div class="row">
	
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">FAQs</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Question</th>
                            <th>Language</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($faqs as $faq)
                        <tr>
                            <td>{{ $faq->question }}</td>
                            <td>{{ $faq->language->name }}</td>
                            <td>
                                <form action="/admin/faqs/{{ $faq->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/faqs/{{ $faq->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
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

        var confirmText = "This FAQ will be deleted";

        swlConfirm(confirmText);

    });
</script>
@stop