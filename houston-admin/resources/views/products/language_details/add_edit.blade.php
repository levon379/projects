@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Product Detail <small>{{ ucwords($mode) }} <strong>({{ isset($productDetail) ? $productDetail->product->name : $product->name }})</strong></small></h1></div>
<div class="row breadcrumb-row">
    <div class="btn-group btn-breadcrumb col-lg-12">
        <a href="/admin/products" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/products" class="btn btn-default"><div>Products</div></a>
        <a href="/admin/products/{{ $productId }}/details" class="btn btn-default"><div>Product Details</div></a>
        <a href="/admin/products/{{ $productId }}/details/add" class="btn btn-default active"><div>{{ ucwords($mode) }} Product Detail</div></a>
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
            <div class="panel-heading">{{ ucwords($mode) }} Product Detail</div>
            <div class="panel-body">
                <form action="@if (isset($productType)){{ URL::to('/admin/products/details/' . $productDetail->id . '/edit') }}@endif" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="product_id" value="{{ isset($productDetail) ? $productDetail->product_id : $product->id }}">
                    <div class="form-group">
                        <label for="end-date">Product</label>
                        <input type='text' class="form-control" readonly name="book_season_start" value="{{ isset($productDetail) ? $productDetail->product->name : $product->name  }}"/>
                    </div>
                    <div class="form-group">
                        <label for="promo">Language</label>
                        <select class="form-control select2" id="language" name="language_id">
                            @foreach ($languages as $language)
                                @if($mode == 'add')
                                    <option value="{{$language->id}}" {{ Input::old('language_id') == $language->id ? 'selected' : '' }}>{{$language->name}}</option>
                                @else
                                    <option value="{{$language->id}}" {{ Input::old('language_id',$productDetail->language_id) === $language->id ? 'selected' : '' }}>{{$language->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($productDetail) ? $productDetail->name : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="subtitle">Subtitle</label>
                        <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Subtitle" autocomplete="off" value="{{ Input::old('subtitle', isset($productDetail) ? $productDetail->subtitle : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="mini-description">Mini Description</label>
                        <textarea class="form-control" name="mini_description" id="mini-description" cols="65" rows="2">{!! Input::old('mini_description', isset($productDetail) ? $productDetail->minidescription : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" cols="65" rows="2">{!! Input::old('description', isset($productDetail) ? $productDetail->description : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="inclusions">Inclusions</label>
                        <textarea class="form-control" name="inclusions" id="inclusions" cols="65" rows="2">{!! Input::old('inclusions', isset($productDetail) ? $productDetail->inclusions : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exclusions">Exclusions</label>
                        <textarea class="form-control" name="exclusions" id="exclusions" cols="65" rows="2">{!! Input::old('exclusions', isset($productDetail) ? $productDetail->exclusions : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="highlights">Highlights</label>
                        <textarea class="form-control" name="highlights" id="highlights" cols="65" rows="2">{!! Input::old('highlights', isset($productDetail) ? $productDetail->highlights : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="itinerary">Itinerary</label>
                        <textarea class="form-control" name="itinerary" id="itinerary" cols="65" rows="2">{!! Input::old('itinerary', isset($productDetail) ? $productDetail->itinerary : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="cancel-policy">Cancel Policy</label>
                        <textarea class="form-control" name="cancelpolicy" id="cancel-policy" cols="65" rows="2">{!! Input::old('cancelpolicy', isset($productDetail) ? $productDetail->cancelpolicy : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="depart-point">Depart Point</label>
                        <textarea class="form-control" name="departpoint" id="depart-point" cols="65" rows="2">{!! Input::old('departpoint', isset($productDetail) ? $productDetail->departpoint : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="end-point">End Point</label>
                        <textarea class="form-control" name="endpoint" id="end-point" cols="65" rows="2">{!! Input::old('endpoint', isset($productDetail) ? $productDetail->endpoint : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="additional-info">Additional Info</label>
                        <textarea class="form-control" name="additionalinfo" id="additional-info" cols="65" rows="2">{!! Input::old('additionalinfo', isset($productDetail) ? $productDetail->additionalinfo : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="what-to-bring">What To Bring</label>
                        <textarea class="form-control" name="what_to_bring" id="what-to-bring" cols="65" rows="2">{!! Input::old('what_to_bring', isset($productDetail) ? $productDetail->what_to_bring : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="runningdays">Running Days</label>
                        <textarea class="form-control" name="running_days" id="runningdays" cols="65" rows="2">{!! Input::old('running_days', isset($productDetail) ? $productDetail->running_days : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Unavailable Days</label>
                        <div class='input-group date' id="unavailable-days">
                            <input type="text" class="form-control" readonly name="unavailable_days" value="{{ Input::old('unavailable_days', isset($unavailableDaysList) ? $unavailableDaysList : null) }}">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end-date">Duration</label>
                        <input type='text' class="form-control" placeholder="Duration" id="duration" name="duration" value="{{ Input::old('duration', isset($productDetail) ? $productDetail->duration : null) }}"/>
                    </div>
                    <div class="form-group">
                        <label for="minimum">Minimum</label>
                        <input type="text" class="form-control integer" name="minimum" id="minimum" placeholder="Minimum" autocomplete="off" value="{{ Input::old('minimum', isset($productDetail) ? $productDetail->minimum : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="max">Max Group</label>
                        <input type="text" class="form-control integer" name="max_group" id="max" placeholder="Maximum" autocomplete="off" value="{{ Input::old('max_group', isset($productDetail) ? $productDetail->maxgroup : null) }}">
                    </div>
                    <div class="form-group" id="options-panel">
                        <label>Websites</label>
                        <input class="form-control" type="text" name="websites" id="websites" placeholder="Choose Website/s" value="{{ Input::old('websites', isset($website_selection) ? $website_selection : null) }}"/>
                    </div>
					<div class="form-group">
                        <label for="itinerary-map">Itinerary Map</label>
                        <input type="text" class="form-control" name="itinerary_map" id="itinerary-map" placeholder="Itinerary Map" autocomplete="off" value="{{ Input::old('itinerary_map', isset($productDetail) ? $productDetail->itinerary_map : null) }}">
					</div>
					<div class="form-group">
						<iframe id="itinerary-map-iframe" style="border: 1px solid #ccc; border-radius: 4px;" src="{{ Input::old('itinerary_map', isset($productDetail) ? $productDetail->itinerary_map : '') }}" height="350" width="100%"frameborder="0" marginwidth="0" marginheight="0" scrolling="no" ></iframe>
					</div>
					<div class="form-group">
                        <label for="departure-point-map">Departure Point Map</label>
                        <input type="text" class="form-control" name="departure_point_map" id="departure-point-map" placeholder="Departure Point Map" autocomplete="off" value="{{ Input::old('departure_point_map', isset($productDetail) ? $productDetail->departure_point_map : null) }}">
                    </div>
					<div class="form-group">
						<iframe id="departure-point-map-iframe" style="border: 1px solid #ccc; border-radius: 4px;" src="{{ Input::old('departure_point_map', isset($productDetail) ? $productDetail->departure_point_map : '') }}" height="350" width="100%" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"></iframe>
					</div>
					<div class="form-group">
                        <label for="meta-title">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" id="meta-title" placeholder="Meta Title" autocomplete="off" maxlength="160" value="{{ Input::old('meta_title', isset($productDetail) ? $productDetail->meta_title : null) }}">
                    </div>
					<div class="form-group">
                        <label for="meta-description">Meta Description</label>
                        <textarea class="form-control" name="meta_description" cols="65" rows="2" maxlength="160">{!! Input::old('meta_description', isset($productDetail) ? $productDetail->meta_description : null) !!}</textarea>
                    </div>
					<div class="form-group">
                        <label for="meta-tags">Meta Tags</label>
                        <input type="text" class="form-control" name="meta_tags" id="meta-tags" placeholder="Meta Tags" autocomplete="off" value="{{ Input::old('meta_tags', isset($productDetail) ? $productDetail->meta_tags : null) }}">
                    </div>
					<div class="form-group">
                        <label for="url">URL</label>
                        <input type="text" class="form-control" name="url" id="url" placeholder="URL" autocomplete="off" value="{{ Input::old('url', isset($productDetail) ? $productDetail->url : null) }}">
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

            var unavailableDays = '#unavailable-days';

            $(unavailableDays).datepicker({
                clearBtn: true,
                multidate: true,
                keyboardNavigation: false,
                forceParse: false,
                format: "dd/mm/yyyy",
                todayHighlight: false,
                orientation: "auto right"
                //daysOfWeekDisabled: $("#running-days").val()
            });

            if(!(extractDates(unavailableDays+" input")[0] == "Invalid Date")){
                $(unavailableDays).datepicker("setDates",extractDates(unavailableDays+" input"));
            }


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

            $('#running-days').multiselect({
                //numberDisplayed: 7,
                buttonText: function(options, select) {
                    if (options.length === 0) {
                        return 'Choose Days';
                    } else {
                        var labels = [];
                        options.each(function() {
                            if ($(this).attr('label') !== undefined) {
                                labels.push($(this).attr('label'));
                            }
                            else {
                                labels.push($(this).html());
                            }
                        });
                        return labels.join(', ') + '';
                    }
                }
            });

        });

		$(function(){
			$('#mini-description, #description, #inclusions, #exclusions, #highlights, #itinerary, #cancel-policy, #depart-point, #end-point, #additional-info, #what-to-bring, #runningdays').editable({inlineMode: false, height: 200,
				  // Set custom buttons with separator between them.
				buttons: ["bold", "italic", "underline", "sep", "strikeThrough", "subscript", "superscript", "sep", "align", "insertOrderedList", "insertUnorderedList", "sep", "fontFamily", "fontSize", "color", "sep",  "outdent", "indent", "undo", "removeFormat", "redo", "sep", "table", "createLink", "insertImage", "insertVideo",   "insertHorizontalRule",  "uploadFile", "html"]
			})
			$(".froala-wrapper").next("div").hide();
		  });
		  
		 $("form").on("change", "#itinerary-map", function(){
			$("#itinerary-map-iframe").attr("src",$(this).val());
		 });
		 
		 $("form").on("change", "#departure-point-map", function(){
			$("#departure-point-map-iframe").attr("src",$(this).val());
		 });

    </script>
@stop