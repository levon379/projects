@extends('layouts.master')

@section('content')
<div class="page-header"><h1>FAQs <small>{{ ucwords($mode) }}</small></h1></div>
<div class="row breadcrumb-row">
    <div class="btn-group btn-breadcrumb col-lg-12">
        <a href="/admin/faqs" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/faqs" class="btn btn-default"><div>FAQs</div></a>
		@if($mode == 'add')
			<a href="{{ URL::to('/admin/faqs/add') }}" class="btn btn-default active"><div>{{ ucwords($mode) }} FAQ</div></a>
		@else
			<a href="{{ URL::to('/admin/faqs/' . $faq->id . '/edit') }}" class="btn btn-default active"><div>{{ ucwords($mode) }} FAQ</div></a>
		@endif
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
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
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </ul>
        </div>
        @endif
    </div>
    <form action="{{ URL::to($mode == 'add' ? '/admin/faqs/add' : '/admin/faqs/' . $faq->id . '/edit') }}" role="form" method="POST">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">{{ ucwords($mode) }} FAQ</div>
                <div class="panel-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="question">Question</label>
                            <input type="text" class="form-control" name="question" id="question" placeholder="Question" autocomplete="off" value="{{ Input::old('question', isset($faq) ? $faq->question : null) }}">
                        </div>
                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <input type="text" class="form-control" name="answer" id="answer" placeholder="Answer" autocomplete="off" value="{{ Input::old('answer', isset($faq) ? $faq->answer : null) }}">
                        </div>
                        <div class="form-group">
                            <label for="language_id">Language</label>
                            <select class="form-control select2" id="faq-type" name="language_id">
                                @foreach ($languages as $language)
                                    @if($mode == 'add')
                                        <option value="{{$language->id}}" {{ Input::old('language_id') == $language->id ? 'selected' : '' }}>{{$language->name}}</option>
                                    @else
                                        <option value="{{$language->id}}" {{ Input::old('language_id',$faq->language_id) === $language->id ? 'selected' : '' }}>{{$language->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="websites-panel">
                            <label>Websites</label>
                            <input class="form-control" type="text" name="websites" id="websites" placeholder="Choose Website/s" value="{{ Input::old('websites', isset($website_selection) ? $website_selection : null) }}"/>
                        </div>
                        <div class="form-group" id="products-panel">
                            <label>Products</label>
                            <input class="form-control" type="text" name="products" id="products" placeholder="Choose Product/s" value="{{ Input::old('products', isset($product_selection) ? $product_selection : null) }}"/>
                        </div>
                        <button type="submit" class="btn btn-purple">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

@stop

@section('script')
    <script>
        $(document).ready(function(){

            $('#websites').select2({
                multiple: true,
                ajax: {
                    dataType: "json",
                    url: "/admin/services/websites",
                    data: function (term, page) {
                        return {
                            q: term
                        };
                    },
                    results: function (data) {
                        var results = [];
                        $.each(data, function(index, website){
                            results.push({
                                id: website.id,
                                text: website.name
                            });
                        });
                        return {
                            results: results
                        };
                    }
                },
                initSelection: function(element, callback) {
                    var ids = $(element).val().split(',');
                    var result = [];
                    $.each(ids, function(index, value) {
                        $.ajax("/admin/services/websites/" + value, {
                            dataType: "json",
                            async: false
                        }).done(function(data) {
                            result.push({
                                id: data.id,
                                text: data.name
                            });
                        });
                    });
                    callback(result);
                }
            });

            $('#products').select2({
                multiple: true,
                ajax: {
                    dataType: "json",
                    url: "/admin/services/products",
                    data: function (term, page) {
                        return {
                            q: term
                        };
                    },
                    results: function (data) {
                        var results = [];
                        $.each(data, function(index, product){
                            results.push({
                                id: product.id,
                                text: product.text
                            });
                        });
                        return {
                            results: results
                        };
                    }
                },
                initSelection: function(element, callback) {
                    var ids = $(element).val().split(',');
                    var result = [];
                    $.each(ids, function(index, value) {
                        $.ajax("/admin/services/products/" + value, {
                            dataType: "json",
                            async: false
                        }).done(function(data) {
                            result.push({
                                id: data.id,
                                text: data.text
                            });
                        });
                    });
                    callback(result);
                }
            });
        });
    </script>
@stop