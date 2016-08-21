@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Addons <small>{{ ucwords($mode) }}</small></h1></div>
<div class="row">
	<div class="col-md-6">
		@if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        @if($errors->any())
		<div class="form-group">
        <div class="validation-summary-errors alert alert-danger">
            <ul>
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </ul>
        </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">{{ ucwords($mode) }} Addon</div>
            <div class="panel-body">
                <form action="{{ URL::to($mode == 'add' ? '/admin/addons/add' : '/admin/addons/' . $addon->id . '/edit') }}" role="form" method="POST"  enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Photo</label><br>
                        <div class="fileinput-eco fileinput-eco-{{ $newImage ? 'new' : 'exists' }}" data-provides="fileinputeco">
                            <div class="fileinput-eco-preview thumbnail" style="width: 200px; height: 150px;">
                                @if (isset($addon))
                                    @if (!empty($addon->image_extension))
                                        <img data-src="/images/addons/{{ $addon->id }}" src="/images/addons/{{ $addon->id }}" alt="...">
                                    @endif
                                @endif
                            </div>
                            <div>
                                <span class="btn btn-success btn-file-eco"><span class="fileinput-eco-new">Select image</span><span class="fileinput-eco-exists">Change</span><input type="file" name="photo"></span>
                                <a href="#" class="btn btn-default fileinput-eco-exists" data-dismiss="fileinputeco">Remove</a>
                            </div>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="products">Products</label>
                        <input class="form-control" type="text" name="products" id="products" placeholder="Choose Product/s" value="{{ Input::old('products', isset($product_selection) ? $product_selection : null) }}"/>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($addon) ? $addon->name : null) }}">
                    </div>
					<div class="form-group">
                        <label for="adult_price">Adult Price</label>
                        <input type="text" class="form-control" name="adult_price" id="adult-price" placeholder="Adult Price" autocomplete="off" value="{{ App\Libraries\Helpers::formatPrice(Input::old('adult_price', isset($addon) ? $addon->adult_price : null)) }} €">
                    </div>
					
					<div class="form-group">
                        <label for="adult-age">Adult Age</label>
                        <input type="text" class="form-control" name="adult_age" id="adult_age" placeholder="Adult Age" autocomplete="off" value="{{ Input::old('adult_age', isset($addon) ? $addon->adult_age : null) }}">
                    </div>
					<div class="form-group">
                        <label for="child_price">Child Price</label>
                        <input type="text" class="form-control" name="child_price" id="child-price" placeholder="Child Price" autocomplete="off" value="{{ App\Libraries\Helpers::formatPrice(Input::old('child_price', isset($addon) ? $addon->child_price : null)) }} €">
                    </div>
					
					<div class="form-group">
                        <label for="child-age">Child Age</label>
                        <input type="text" class="form-control" name="child_age" id="child_age" placeholder="Child Age" autocomplete="off" value="{{ Input::old('child_age', isset($addon) ? $addon->child_age : null) }}">
                    </div>
					<div class="form-group">
                        <label for="en-description-title">English Description Title</label>
                        <input type="text" class="form-control" name="en_description_title" id="en-description-title" autocomplete="off" value="{{ Input::old('en_description_title', isset($addon) ? $addon->en_description_title : null) }}">
                    </div>
					<div class="form-group">
                        <label for="en-description">English Description</label>
                        <textarea class="form-control" name="en_description" cols="65" rows="2">{!! Input::old('en_description', isset($addon) ? $addon->en_description : null) !!}</textarea>
                    </div>
					<div class="form-group">
                        <label for="fr-description-title">French Description Title</label>
                        <input type="text" class="form-control" name="fr_description_title" id="fr-description-title" autocomplete="off" value="{{ Input::old('fr_description_title', isset($addon) ? $addon->fr_description_title : null) }}">
                    </div>
					<div class="form-group">
                        <label for="fr-description">French Description</label>
                        <textarea class="form-control" name="fr_description" cols="65" rows="2">{!! Input::old('fr_description', isset($addon) ? $addon->fr_description : null) !!}</textarea>
                    </div>
					<div class="form-group">
                        <label for="de-description-title">German Description Title</label>
                        <input type="text" class="form-control" name="de_description_title" id="de-description-title" autocomplete="off" value="{{ Input::old('de_description_title', isset($addon) ? $addon->de_description_title : null) }}">
                    </div>
					<div class="form-group">
                        <label for="de-description">German Description</label>
                        <textarea class="form-control" name="de_description" cols="65" rows="2">{!! Input::old('de_description', isset($addon) ? $addon->de_description : null) !!}</textarea>
                    </div>
					<div class="form-group">
                        <label for="ita-description-title">Italian Description Title</label>
                        <input type="text" class="form-control" name="ita_description_title" id="ita-description-title" autocomplete="off" value="{{ Input::old('ita_description_title', isset($addon) ? $addon->ita_description_title : null) }}">
                    </div>
					<div class="form-group">
                        <label for="ita-description">Italian Description</label>
                        <textarea class="form-control" name="ita_description" cols="65" rows="2">{!! Input::old('ita_description', isset($addon) ? $addon->ita_description : null) !!}</textarea>
                    </div>
					<div class="form-group">
                        <label for="es-description-title">Spanish Description Title</label>
                        <input type="text" class="form-control" name="es_description_title" id="es-description-title" autocomplete="off" value="{{ Input::old('es_description_title', isset($addon) ? $addon->es_description_title : null) }}">
                    </div>
					<div class="form-group">
                        <label for="es-description">Spanish Description</label>
                        <textarea class="form-control" name="es_description" cols="65" rows="2">{!! Input::old('es_description', isset($addon) ? $addon->es_description : null) !!}</textarea>
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
			
			$("#adult-price, #child-price").inputmask('decimal',{
                radixPoint : ',',
                autoGroup : false ,
                digits : 2 ,
                digitsOptional : false,
                suffix: ' €',
                placeholder: '0'
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