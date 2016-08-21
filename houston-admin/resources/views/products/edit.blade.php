@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Product <small>Edit</small></h1></div>
@if(Session::has('success'))
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{ Session::get('success') }}
</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{ Session::get('error') }}
</div>
@endif
@if($errors->any())
<div class="validation-summary-errors alert alert-danger">
    <ul>
        {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
    </ul>
</div>
@endif
<div class="row breadcrumb-row">
    <div class="btn-group btn-breadcrumb col-lg-12">
        <a href="/admin/products" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/products" class="btn btn-default"><div>Products</div></a>
        <a href="{{ URL::to('/admin/products/' . $product->id . '/edit') }}" class="btn btn-default active"><div>Edit Product</div></a>
    </div>
    <div class="col-lg-12">
        <h4><a class="operation-link" href="/admin/products/{{ $product->id }}/options">View Options <i class="fa fa-eye operation-icon"></i></a></h4>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Edit Product Details</div>
            <div class="panel-body">
                <form action="{{ URL::to('/admin/products/' . $product->id . '/edit') }}" role="form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($product) ? $product->name : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="start-times">Start Times</label>
                        <input type="text" class="form-control" name="start_times" id="start-times" placeholder="Start Times" autocomplete="off" value="{{ Input::old('start_times', isset($product) ? $product->start_times : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="default-price">Default Price</label>
                        <input type="text" class="form-control inputmask" name="default_price" id="default-price" autocomplete="off" value="{{ App\Libraries\Helpers::formatPrice(Input::old('default_price', isset($product) ? $product->default_price : null)) }} €">
                    </div>
                    <div class="form-group">
                        <label>Product Categories</label>
                        <input class="form-control" type="text" name="categories" id="categories" placeholder="Choose Category/s" value="{{ Input::old('categories', isset($category_selection) ? $category_selection : null) }}"/>
                    </div>
                    <div class="form-group">
                        <label for="prodiver">Provider</label>
                        <select class="form-control select2" id="prodiver" name="provider_id">
                            @foreach ($providers as $provider)
                                <option value="{{$provider->id}}" {{ Input::old('provider_id',$product->provider_id) === $provider->id ? 'selected' : '' }}>{{$provider->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="departure-city">Departure City</label>
                        <select class="form-control select2" id="departure-city" name="departure_city_id">
                            @foreach ($cityList as $city)
                                <option value="{{$city->id}}" {{ Input::old('departure_city_id',$product->departure_city_id) === $city->id ? 'selected' : '' }}>{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product-type">Product Type</label>
                        <select class="form-control select2" id="product-type" name="product_type_id">
                            @foreach ($productTypes as $productType)
                                <option value="{{$productType->id}}" {{ Input::old('product_type_id',$product->product_type_id) === $productType->id ? 'selected' : '' }}>{{$productType->name}}</option>
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
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Edit Product Images</div>
            <div class="panel-body">
                <div class='product-image-list'>
                    <table class="table table-striped table-bordered">
                        <tbody>
                        @foreach($images as $image)
                        <tr class="image-row">
                            <td class="image-thumbnail">
                                <div>
                                    <a href="#">
                                        <img class="img-responsive" alt="" src="{{ URL::to('/images/'.$image->hash.'/thumb') }}" data-id="{{$image->id}}" />
                                    </a>
                                </div>
                                <div class="text-center">
                                    <span class="label label-default">{{ $image->name }}</span>
                                </div>
                            </td>
                            <td class="image-body">
                                <div class="pull-right image-control">
                                    <input type="submit" class="btn btn-danger btn-xs pi-delete" value="Delete Image" />
                                </div>
                                <h1 class="image-form-header">Name</h1>
                                <input class="form-control image-name" type="text" name="name" placeholder="Image name" value="{{ Input::old("name", $image->name) }}" data-id="{{$image->id}}"/>
                                <h1 class="image-form-header">Websites</h1>
                                <input class="form-control websites" type="text" name="websites" placeholder="Choose Website/s" value="{{ $image->getWebsiteList() }}" data-id="{{$image->id}}"/>
                                <h1 class="image-form-header">Image Placements</h1>
                                <input class="form-control product_image_placements" type="text" name="product_image_placements" placeholder="Choose Image Type/s" value="{{ $image->getImagePlacementsList() }}" data-id="{{$image->id}}"/>
								<h1 class="image-form-header image-alt-text-label">Alt Text: </h1> <a href="#" id="alt-text" class="image-alt-text" data-type="text" data-pk="{{$image->id}}">{{$image->alt_text}}</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <form action="{{ URL::to('/admin/products/' . $product->id . '/update') }}" role="form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Product Images</label>
                        <input type="file" id="product-images" name="product_images[]"  type="file" multiple=true >
                        <p class="help-block">Select multiple images from a folder</p>
                    </div>
                    <button type="submit" class="btn btn-purple">Upload Images</button>
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Edit Product Videos</div>
            <div class="panel-body">
                <div class='product-video-list'>
                @foreach($videos as $key=>$video)
                    <form action="{{ URL::to('/admin/products/' . $product->id . '/update') }}"  method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" value=" {{ count($videos) }}" id="videos_count">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        <table class="table table-bordered video-list-item" style="margin-bottom:0">
                                            <tr>
                                                <td class="clearfix">
                                                    <div class="pull-left">{{ $video->name }}</div><div class="pull-right"><a href="#" class="btn btn-xs btn-purple edit-product-video">Edit</a> <a href="#" class="btn btn-xs btn-primary show-embed-video">Show Video</a> <a href='{{ url("/admin/products/videos/placements/{$video->id}/delete") }}' class="btn btn-xs btn-danger">delete</a></div>
                                                </td>
                                            </tr>
                                            <tr class="sr-only product-video-preview">
                                                <td>{!! $video->embed_code !!}</td>
                                            </tr>
                                            <tr class="sr-only product-video-edit-form well well-sm">
                                                <td>
                                                    <table class="table table-bordered" id="video_table">     
                                                        <input type="hidden" name="id" class="video_id" value="{{ $video->id }}">
                                                            <tr>
                                                                <td>
                                                                    <label for="">Video Name</label>
                                                                    <input type="text" class="form-control" name="product_video_name" value="{{ $video->name }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label for="">Video Embed Code</label>
                                                                    <textarea name="product_video_embed_code" class="form-control">{{ $video->embed_code }}</textarea>    
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>                                                                
                                                                    <div class="form-group">
                                                                        <label>Product Video Thumb</label>
                                                                        @if ($video->video_thumb)
                                                                        <div class="file-preview" id="file_preview_{{ $key }}">
                                                                            <div class="">
                                                                                <div class="file-preview-thumbnails">
                                                                                    <div class="file-preview-frame" id="preview-1458558773173-0" data-fileindex="0" style="width: 97%;">
                                                                                       <img src="{{ URL::to('/video_thumb/'.$video->id) }}" class="file-preview-image" style="width: 100%; height: 100px;">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="clearfix"></div>    
                                                                            </div>
                                                                        </div>
                                                                        @endif
                                                                        <input type="file" id="product-video-thumb_{{ $key }}" onchange="removepreview('{{ $key }}')" name="product_video_thumb[{{ $video->id }}][]" >
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label for="">Video Placements</label>
                                                                    <input class="form-control product_video_placements" type="text" name="product_video_placements" placeholder="Choose Image Type/s" value="{{ $video->getVideoPlacementsList() }}" data-id="{{$video->id}}"/>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><button type="submit" class="btn btn-xs btn-purple">Update Video</button></td>
                                                            </tr>

                                                    </table>
                                                </td>
                                            </tr>         
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                @endforeach
                       
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Add Video</div>
                    <div class="panel-body">
                        <form action="{{ URL::to('/admin/products/' . $product->id . '/update') }}" role="form" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="product-video-name">Video Name</label>
                                <input type="text" class="form-control" name="product_video_name" placeholder="Video Name">
                            </div>
                            <div class="form-group">
                                <label>Video Embed Code</label>
                                <textarea class="form-control" id="product-embed_code" name="product_video_embed_code" placeholder="Video Embed Code"></textarea>
                                <p class="help-block">Embed Code for Youtube or Vimeo Videos</p>
                            </div>
                            <div class="form-group">
                                <label>Video Thumb</label>
                                <input type="file" id="product-video-thumb" name="product_video_thumb[]" >
                            </div>
                            <button type="submit" class="btn btn-purple">Save Video</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop


@section('script')
    <script>
        $(document).ready(function(){

            $(".show-embed-video").on({
                click: function(e){
                    e.preventDefault();
                    var isShowing = false;
                    if($(this).hasClass("active")){
                        $(this).text("Show Video");
                        isShowing = true;
                    }else{
                        $(this).text("Hide Video");
                        isShowing = false;
                    }
                    $(this).toggleClass('active');
                    $(this).parents(".video-list-item").find(".product-video-preview").toggleClass('sr-only');
                }
            });

            $(".edit-product-video").on({
                click: function(e){
                    e.preventDefault();
                    $(this).toggleClass('active').parents(".video-list-item").find(".product-video-edit-form").toggleClass('sr-only');
                }
            });


            $("#product-images").fileinput({
                allowedFileExtensions : ['jpg', 'png','gif', 'jpeg'],
                overwriteInitial: false,
                maxFileSize: 5000,
                maxFilesNum: 10,
                enableActions: true,
                showUpload: false,
                dropZoneEnabled: false,
                allowedFileTypes: ['image' ],
                previewSettings: {image: {width: "100px", height: "100px"}}
            });
            $("#product-video-thumb").fileinput({
                    allowedFileExtensions : ['jpg', 'png','gif', 'jpeg'],
                    overwriteInitial: false,
                    maxFileSize: 5000,
                    maxFilesNum: 10,
                    enableActions: true,
                    showUpload: false,
                    dropZoneEnabled: false,
                    allowedFileTypes: ['image' ],
                    previewSettings: {image: {width: "100px", height: "100px"}}
                });
            
            var videos_count = $('#videos_count').val();
            for(i=0;i<videos_count;i++){
                
                $("#product-video-thumb_"+i).fileinput({
                    allowedFileExtensions : ['jpg', 'png','gif', 'jpeg'],
                    overwriteInitial: false,
                    maxFileSize: 5000,
                    maxFilesNum: 10,
                    enableActions: true,
                    showUpload: false,
                    dropZoneEnabled: false,
                    allowedFileTypes: ['image' ],
                    previewSettings: {image: {width: "100px", height: "100px"}}
                });
            }

            $('.websites').select2({
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
                        $.each(data, function(index, productImageType){
                            results.push({
                                id: productImageType.id,
                                text: productImageType.name
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


            $('.product_image_placements').select2({
                multiple: true,
                ajax: {
                    dataType: "json",
                    url: "/admin/services/products/images/placements",
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
                        $.ajax("/admin/services/products/images/placements/" + value, {
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

            $('.product_video_placements').select2({
                multiple: true,
                ajax: {
                    dataType: "json",
                    url: "/admin/services/products/videos/placements",
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
                        $.ajax("/admin/services/products/videos/placements/" + value, {
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

            $('.websites').on("change", function (e) {
                var imageContainer = $(this).closest(".image-row");
                var id = $(this).data("id");
                var value = $(this).val();
                $.post( "/admin/products/images/"+id+"/websites", { websites : value }).done(function(data){
                    imageContainer.effect("highlight", {}, 1000);
                });
            });


            $('.product_image_placements').on("change", function (e) {
                var imageContainer = $(this).closest(".image-row");
                var id = $(this).data("id");
                var value = $(this).val();
                $.post( "/admin/products/images/"+id+"/placements", { placements : value }).done(function(data){
                    imageContainer.effect("highlight", {}, 1000);
                });
            });

            $('.product_video_placements').on("change", function (e) {
                var videoContainer = $(this).parents("table");
                var id = $(this).data("id");
                var value = $(this).val();
                $.post( "/admin/products/videos/"+id+"/placements", { placements : value }).done(function(data){
                    videoContainer.effect("highlight", {}, 1000);
                });
            });

            $('.image-name').on("change", function(e){
                var imageContainer = $(this).closest('.image-row');
                var id = $(this).data("id");
                var value = $(this).val();
                $.post("/admin/products/images/"+id+"/name", { name : value }).done(function(data){
                    imageContainer.effect("highlight", {}, 1000);
                });
            });

            $(".pi-delete").click(function(){
                var id = $(this).closest(".image-row").find("img").data("id");
                var imageContainer = $(this).closest(".image-row");
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this image!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d9534f",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false,   closeOnCancel: true },
                    function(isConfirm){
                        if (isConfirm) {
                            $.post( "/admin/products/images/"+id+"/delete", function( data ) {
                                imageContainer.fadeOut(500, function() {
                                    imageContainer.remove();
                                    swal("Deleted!", "The image has been deleted.", "success");
                                });
                            });
                        }
                    }
                );

            });

            $("#default-price").inputmask('decimal',{
                radixPoint : ',',
                autoGroup : false ,
                digits : 2 ,
                digitsOptional : false,
                suffix: ' €',
                placeholder: '0'
            });

            
			$(".image-alt-text").xeditable({
				type: 'text',
				clear: true,
				title: 'Enter alt text',
				mode: 'inline',
				url: function(params){
					$.post( "/admin/products/images/"+params.pk+"/alttext", {alt_text:params.value}).done(function(data){
						
					});
				}
				
			});

        });
        
        
        function removepreview(key){
            $('div#file_preview_'+key).remove();
        }

    </script>
@stop