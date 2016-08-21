@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Product <small>Add</small></h1></div>
<div class="row breadcrumb-row">
    <div class="btn-group btn-breadcrumb col-lg-12">
        <a href="/admin/products" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/products" class="btn btn-default"><div>Products</div></a>
        <a href="/admin/products/add" class="btn btn-default active"><div>Add Product</div></a>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        @if($errors->any())
        <div class="validation-summary-errors alert alert-danger">
            <ul>
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </ul>
        </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">Add Product</div>
            <div class="panel-body">
                <form action="{{ URL::to('/admin/products/add') }}" role="form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Product Images</label>
                        <input type="file" id="product-images" name="product_images[]"  type="file" multiple=true >
                        <p class="help-block">Select multiple images from a folder</p>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="start-times">Start Times</label>
                        <input type="text" class="form-control" name="start_times" id="start-times" placeholder="Start Times" autocomplete="off" value="{{ Input::old('start_times') }}">
                    </div>
                    <div class="form-group">
                        <label for="default-price">Default Price</label>
                        <input type="text" class="form-control inputmask" name="default_price" id="default-price" autocomplete="off"  value="{{ Input::old('default_price') }}">
                    </div>
                    <div class="form-group">
                        <label>Product Categories</label>
                        <input class="form-control" type="text" name="categories" id="categories" placeholder="Choose Category/s" value="{{ Input::old('categories', isset($category_selection) ? $category_selection : null) }}"/>
                    </div>
                    <div class="form-group">
                        <label for="provider">Provider</label>
                        <select class="form-control select2" id="provider" name="provider_id">
                            @foreach ($providers as $provider)
                                <option value="{{$provider->id}}" {{ Input::old('provider_id') == $provider->id ? 'selected' : '' }}>{{$provider->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="departure-city">Departure City</label>
                        <select class="form-control select2" id="departure-city" name="departure_city_id">
                            @foreach ($cityList as $city)
                                <option value="{{$city->id}}" {{ Input::old('departure_city_id') == $city->id ? 'selected' : '' }}>{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product-type">Product Type</label>
                        <select class="form-control select2" id="product-type" name="product_type_id">
                            @foreach ($productTypes as $productType)
                                 <option value="{{$productType->id}}" {{ Input::old('product_type_id') == $productType->id ? 'selected' : '' }}>{{$productType->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Recommended Products</label>
                        <input class="form-control" type="text" name="recommended_products" id="recommended_products" placeholder="Choose Product/s" value="{{ Input::old('recommended_products', isset($recommended_products_selection) ? $recommended_products_selection : null) }}"/>
                    </div>
                    <button type="submit" class="btn btn-purple">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>

@stop


@section('script')
    <script>
        $(document).ready(function(){
            $("#product-images").fileinput({
                alloweFileExtensions : ['jpg', 'png','gif', 'jpeg'],
                overwriteInitial: false,
                maxFileSize: 5000,
                maxFilesNum: 10,
                enableActions: true,
                showUpload: false,
                dropZoneEnabled: false,
                allowedFileTypes: ['image' ]
            });

            $("#default-price").inputmask('decimal',{
                radixPoint : ',',
                autoGroup : false ,
                digits : 2 ,
                digitsOptional : false,
                suffix: ' €',
                placeholder: '0'
            });


            $('#categories').select2({
                multiple: true,
                ajax: {
                    dataType: "json",
                    url: "/admin/services/categories",
                    data: function (term, page) {
                        return {
                            q: term
                        };
                    },
                    results: function (data) {
                        var results = [];
                        $.each(data, function(index, category){
                            results.push({
                                id: category.id,
                                text: category.name
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
                        $.ajax("/admin/services/categories/" + value, {
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

            $('#recommended_products').select2({
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
                        $.each(data, function(index, rProduct){
                            results.push({
                                id: rProduct.id,
                                text: rProduct.text
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