@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Promos <small>{{ ucwords($mode) }}</small></h1></div>
<div class="row breadcrumb-row">
    <div class="btn-group btn-breadcrumb col-lg-12">
        <a href="/admin/promos" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/promos" class="btn btn-default"><div>Promos</div></a>
		@if($mode == 'add')
			<a href="{{ URL::to('/admin/promos/add') }}" class="btn btn-default active"><div>{{ ucwords($mode) }} Promo</div></a>
		@else
			<a href="{{ URL::to('/admin/promos/' . $promo->id . '/edit') }}" class="btn btn-default active"><div>{{ ucwords($mode) }} Promo</div></a>
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
    <form action="{{ URL::to($mode == 'add' ? '/admin/promos/add' : '/admin/promos/' . $promo->id . '/edit') }}" role="form" method="POST">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">{{ ucwords($mode) }} Promo</div>
                <div class="panel-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($promo) ? $promo->name : null) }}">
                        </div>
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" class="form-control" name="code" id="code" placeholder="Code" autocomplete="off" value="{{ Input::old('code', isset($promo) ? $promo->code : null) }}">
                        </div>
                        <div class="form-group">
                            <label for="promo-type">Promo Type</label>
                            <select class="form-control select2" id="promo-type" name="promo_type_id">
                                @foreach ($promoTypes as $promoType)
                                    @if($mode == 'add')
                                        <option value="{{$promoType->id}}" {{ Input::old('promo_type_id') == $promoType->id ? 'selected' : '' }}>{{$promoType->name}}</option>
                                    @else
                                        <option value="{{$promoType->id}}" {{ Input::old('promo_type_id',$promo->promo_type_id) === $promoType->id ? 'selected' : '' }}>{{$promoType->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="start-date">Travel Start Date</label>
                            <div class='input-group date' id="datetimerangepicker1" >
                                <input type='text' name='travel_start_date' class="form-control" data-date-format="DD/MM/YYYY" placeholder="Start Date" name="start_date" value="{{ App\Libraries\Helpers::displayDate(Input::old('travel_start_date', isset($promo) ? $promo->travel_start_date : null)) }}"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end-date">Travel End Date</label>
                            <div class='input-group date' id="datetimerangepicker2" >
                                <input type='text' name='travel_end_date' class="form-control" data-date-format="DD/MM/YYYY" placeholder="End Date" name="end_date" value="{{ App\Libraries\Helpers::displayDate(Input::old('travel_end_date', isset($promo) ? $promo->travel_end_date : null)) }}"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start-date">Book Start Date</label>
                            <div class='input-group date' id="datetimerangepicker3" >
                                <input type='text' name='book_start_date' class="form-control" data-date-format="DD/MM/YYYY" placeholder="Start Date" name="start_date" value="{{ App\Libraries\Helpers::displayDate(Input::old('book_start_date', isset($promo) ? $promo->book_start_date : null)) }}"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end-date">Book End Date</label>
                            <div class='input-group date' id="datetimerangepicker4" >
                                <input type='text' name='book_end_date' class="form-control" data-date-format="DD/MM/YYYY" placeholder="End Date" name="end_date" value="{{ App\Libraries\Helpers::displayDate(Input::old('book_end_date', isset($promo) ? $promo->book_end_date : null)) }}"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="adult_price">Percent Discount</label>
                            <input type="text" name="percent_discount" id="percent-discount" class="form-control inputmask" autocomplete="off" value="{{ Input::old('percent_discount', isset($promo) ? $promo->percent_discount : null) }} %">
                        </div>
                        <div class="form-group">
                            <label for="adult_price">Euro Off Discount</label>
                            <input type="text" name="euro_off_discount" id="euro-off-discount" class="form-control inputmask" autocomplete="off" value="{{ App\Libraries\Helpers::formatPrice(Input::old('euro_off_discount', isset($promo) ? $promo->euro_off_discount : null)) }} €">
                        </div>
                        <div class="form-group">
                            <label for="adult_price">Adult Price</label>
                            <input type="text" class="form-control" name="adult_price" id="adult-price" placeholder="Adult Price" autocomplete="off" value="{{ App\Libraries\Helpers::formatPrice(Input::old('adult_price', isset($promo) ? $promo->adult_price : null)) }} €">
                        </div>
                        <div class="form-group">
                            <label for="adult_price">Child Price</label>
                            <input type="text" class="form-control" name="child_price" id="child-price" placeholder="Child Price" autocomplete="off" value="{{ App\Libraries\Helpers::formatPrice(Input::old('child_price', isset($promo) ? $promo->child_price : null)) }} €">
                        </div>
                        <div class="form-group">
                            <label for="new_default_price">New Default Price</label>
                            <input type="text" class="form-control" name="new_default_price" id="new-default-price" placeholder="New Default" autocomplete="off" value="{{ App\Libraries\Helpers::formatPrice(Input::old('new_default_price', isset($promo) ? $promo->new_default_price : null)) }} €">
                        </div>
                        <div class="form-group">
                            <label for="minimum">Minimum Pax</label>
                            <input type="text" class="form-control integer" name="minimum" id="minimum" placeholder="Minimum" autocomplete="off" value="{{ Input::old('minimum', isset($promo) ? $promo->minimum : null) }}">
                        </div>
                        <div class="form-group">
                            <label for="max">Maximum Pax</label>
                            <input type="text" class="form-control integer" name="maximum" id="max" placeholder="Maximum" autocomplete="off" value="{{ Input::old('maximum', isset($promo) ? $promo->maximum : null) }}">
                        </div>
                        <div class="form-group" id="options-panel">
                            <label>Websites</label>
                            <input class="form-control" type="text" name="websites" id="websites" placeholder="Choose Website/s" value="{{ Input::old('websites', isset($website_selection) ? $website_selection : null) }}"/>
                        </div>
                        <button type="submit" class="btn btn-purple">Submit</button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Products -->
            <div class="panel panel-default promos-products-panel">
                <div class="panel-heading">
                    Assign Products
                    <div class="pull-right delete">
                           <input type="button" class="btn btn-success btn-xs promos-product-add-row" value="Add Product">
                    </div>
                </div>
                <div class="panel-body">
                    <div id="promos-product-list">
                    @foreach ($promosProductsOld as $promosProductOld)
                          <div class="row promos-product-row">
                              <input type="hidden" id="promos-product-id-value" name="promos_product_id[]" value="{{$promosProductOld->id}}">
                              <div class="pull-right delete">
                                  <input type="button" class="btn btn-danger btn-xs product-delete" value="Delete">
                              </div>
                              <div class="form-group">
                                    <div class="col-lg-5">
                                        <label for="product-id">Product</label>
                                        <select class="form-control select2" id="product-id" name="product_id[]">
                                            <option value=""></option>
                                            @foreach ($products as $product)
                                                <option value="{{$product->id}}" {{ $promosProductOld->product_id == $product->id ? 'selected' : '' }}>{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-7">
                                        <label for="product-option-id">Product Options</label>
                                        <input class="form-control product-option" type="text" name="product_option_ids[]" id="product-option" placeholder="Choose Product Option/s" value="{{ $promosProductOld->product_option_id }}"/>
                                    </div>
                                    <div style="clear:both;"></div>
                             </div>
                             <div class="form-group">
                                    <div class="col-lg-12">
                                        <label for="product-option-id">Addons</label>
                                        <input class="form-control addon" type="text" name="addon_ids[]" id="addon" placeholder="Choose Addon/s" value="{{ $promosProductOld->addon_id }}" />
                                    </div>
                             </div>
                        </div>
                    @endforeach
                    @include('partials.promo_products')
                    </div>
                </div>
            </div>
            <!-- END: Products -->
        </div>
    </form>
</div>

@stop

@section('script')
    <script>
        $(document).ready(function(){

            $("#datetimerangepicker1").datetimepicker({format: 'DD/MM/YYYY'});
            $("#datetimerangepicker2").datetimepicker({format: 'DD/MM/YYYY'});
            $("#datetimerangepicker3").datetimepicker({format: 'DD/MM/YYYY'});
            $("#datetimerangepicker4").datetimepicker({format: 'DD/MM/YYYY'});

            $("#datetimerangepicker1").on("dp.change",function (e) {
                $('#datetimerangepicker2').data("DateTimePicker").minDate(e.date);
            });
            $("#datetimerangepicker2").on("dp.change",function (e) {
                $('#datetimerangepicker1').data("DateTimePicker").maxDate(e.date);
            });
			$("#datetimerangepicker3").on("dp.change",function (e) {
                $('#datetimerangepicker4').data("DateTimePicker").minDate(e.date);
            });
            $("#datetimerangepicker4").on("dp.change",function (e) {
                $('#datetimerangepicker3').data("DateTimePicker").maxDate(e.date);
            });


			// TODO: Use PromoType.FREEADDON.value

			$("#percent-discount").inputmask('decimal',{
                autoGroup : false ,
                digitsOptional : false,
                suffix: ' %',
                digits : 2 ,
                placeholder: '0'
            });
			
			$("#euro-off-discount, #adult-price, #child-price, #new-default-price").inputmask('decimal',{
                radixPoint : ',',
                autoGroup : false ,
                digits : 2 ,
                digitsOptional : false,
                suffix: ' €',
                placeholder: '0'
            });

            var confirmText = "This promo will be deleted";
            swlConfirm(confirmText);
			
			$("#minimum").inputmask('integer',{
                placeholder: '1',
                rightAlign: false
            });


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


            $('.product-option').select2({
                multiple: true,
                ajax: {
                    dataType: "json",
                    url: "/admin/services/products/options/product?name=1",
                    data: function (term, page) {
                        return {
                            product_id: $(this).closest(".promos-product-row").find("#product-id").val()
                        };
                    },
                    results: function (data) {
                        var results = [];
                        $.each(data, function(index, product_option){
                            results.push({
                                id: product_option.id,
                                text: product_option.text
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
                        $.ajax("/admin/services/options/all/" + value , {
                            dataType: "json",
                            async: false,
                            data: { name: 1 }
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
			
			$('.addon').select2({
                multiple: true,
                ajax: {
                    dataType: "json",
                    url: "/admin/services/addons",
                    data: function (term, page) {
                        return {
                            product_id: $(this).closest(".promos-product-row").find("#product-id").val()
                        };
                    },
                    results: function (data) {
                        var results = [];
                        $.each(data, function(index, addon){
                            results.push({
                                id: addon.id,
                                text: addon.text
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
                        $.ajax("/admin/services/addons/" + value, {
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
			 
			hideShowPanels();
			
			function hideShowPanels(){
				var productCount = $(".promos-product-row").length;
                disableAddon();
				if(productCount>0){
					$(".promos-products-panel .panel-body").show();
				} else {
					$(".promos-products-panel .panel-body").hide();
				}

			}
			
			$(".promos-product-add-row").click(function(){
				var count = $("#promos-product-list .promos-product-row").length;
				var row   = $("#promos-product-row-template").html();
				var template = Handlebars.compile(row);
				var html = template({ count : count});
				$("#promos-product-list").append(html);
				console.log(count);
				var productSelect = ".promos-product-row-"+count+" #product-id";
				loadSelectData(productSelect,"products", {},true);
				$(productSelect).closest(".promos-product-row").find('#product-option').select2({data: function() { return {results: []}; }});
				var addonSelect = $(productSelect).closest(".promos-product-row").find('#addon').select2({data: function() { return {results: []}; }});
				if(parseInt($("#promo-type").val()) != PromoType.FREEADDON.value){
					addonSelect.select2("readonly",true);
				}
				hideShowPanels();
			})
			
			$("form").on("change","#promo-type",function(){
                disableAddon();
			});

            function disableAddon(){
                var read = parseInt($("#promo-type").val()) == PromoType.FREEADDON.value ? false : true;
                $(".addon").select2("readonly",read);
                if(read){
                    $(".addon").select2("val",null,true);
                    $(".addon").val("");
                }
            }
			
			$("#promos-product-list").on("change", "#product-id", function(e){
				var prodId = $(this).val();
				loadMultipleSelectData($(this).closest(".promos-product-row").find("#product-option"),"products/options/product?name=1",{product_id : prodId});
				loadMultipleSelectData($(this).closest(".promos-product-row").find("#addon"),"addons",{product_id : prodId});
			});
			
			$("#promos-product-list").on("click",'.product-delete',function(){
				var row = $(this).closest(".promos-product-row");
				var id = row.find("#promos-product-id-value").val();
				swal({
						title: "Are you sure?",
						text: "This product promo will be deleted",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#d9534f",
						confirmButtonText: "Yes, delete it!",
						cancelButtonText: "Cancel",
						closeOnConfirm: true,   closeOnCancel: true },
					function(isConfirm){
						if (isConfirm) {
							if(id>0){
								$.post( "/admin/services/promos/products/"+id+"/delete", function( data ) {
									row.fadeOut(500, function() {
										row.remove();
										hideShowPanels();
									});
								});
							} else {
								row.fadeOut(500, function() {
									row.remove();
									hideShowPanels();
								});
							}
						}
					}
				);
			});

        });
    </script>
@stop