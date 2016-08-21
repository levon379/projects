@extends('layouts.master')

@section('content')
<div class="page-header"><h1>NET RATES <small>{{ ucwords($mode) }}</small></h1></div>
@if(Session::has('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
@if($errors->any())
<div class="validation-summary-errors alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>
        {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
    </ul>
</div>
@endif

<div class="row">
    <form method="post" action="@if (isset($source)){{ URL::to('/admin/source/' . $source->id . '/edit') }}@endif" role="form" id="source-form" data-id="{{isset($source) ? $source->id : 0}}">
        <div class="col-md-6">
            <!--First Panel Sorce INFO -->
            <div class="panel panel-default booking-panel">
                <div class="panel-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="source-group-id">Source Group</label>
                                <select class="form-control select2" id="source-group-id" name="source_group_id">
                                    <option value=""></option>
                                    @foreach ($sourceGroups as $sourceGroup)
                                    <option value="{{$sourceGroup->id}}" {{ Input::old('source_group_id', isset($source) ? $source->source_name->source_group->id : null ) == $sourceGroup->id ? 'selected' : '' }}>{{$sourceGroup->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="source-name-id">Source Name</label>
                                <select class="form-control select2" id="source-name-id" name="source_name_id">
                                    <option value=""></option>
                                    @foreach ($sourceNames as $sourceName)
                                    <option value="{{$sourceName->id}}" {{ Input::old('source_name_id',  isset($source) ? $source->source_name_id : null) == $sourceName->id ? 'selected' : '' }}>{{$sourceName->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="reference-number">Adults Price</label>
                                <input class="form-control" type="text" id="adult-price" name="adult_price" autocomplete="off" value="{{ Input::old('adult_price', isset($source) ? $source->adult_net_rate : null) }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="product-id">Child Price</label>
                                <input class="form-control" type="text" id="child-price" name="child_price" autocomplete="off" value="{{ Input::old('child_price', isset($source) ? $source->child_net_rate : null) }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="product-id">Product</label>
                                <select class="form-control select2" id="product-id" >
                                    <option value=""></option>
                                    @foreach ($products as $product)
                                    <option value="{{$product->id}}" {{ Input::old('product_id' , isset($booking) ? $booking->product_option->product->id : null ) == $product->id ? 'selected' : '' }}>{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="product-option-id">Product Option</label>
                                <select class="form-control select2" onchange="save_option(this.value)" id="product-option-id" >
                                    <option value=""></option>
                                    @foreach ($productOptions as $productOption)
                                    <option value="{{$productOption->id}}">{{$productOption->getNameWithFromTo()}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12" id="source_product_options">
                                @if($mode == 'edit' && isset($productOptionsEdit['source_option']))
                                <?php $count_product = $count; ?>
                                @for($i = 0; $i<$count_product; $i++)
                                <div class="alert alert-warning alert-dismissible" role='alert' id="productoption_{{ $productOptionsEdit['source_option']['prod_option'][$i]->id  }}" >
                                    <input type='hidden' name=product_options[] value=" {{ $productOptionsEdit['source_option']['prod_option'][$i]->id }} " >
                                    {{ $productOptionsEdit['source_option']['product'][$i]->name }} - {{ $productOptionsEdit['source_option']['prod_option'][$i]->name }} 
                                    <button type='button' class='close' data-dismiss='alert' id='product_option_close' onclick="deleteOption('{{ $source->id }}','{{ $productOptionsEdit['source_option']['prod_option'][$i]->id }}')" aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                </div>
                                @endfor
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="travel-season-start-date-field">Travel Season Start</label>
                                <div class='input-group date' id="travel-start-date" >
                                    <input type='text' class="form-control" id="travel-season-start-date-field" data-date-format="DD/MM/YYYY" name="travel_season_date_start" value="{{ App\Libraries\Helpers::displayDate(Input::old('travel_season_date_start', isset($source) ? $source->trav_season_start : null)) }}" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="travel-season-end-date-field">Travel Season End</label>
                                <div class='input-group date' id="travel-end-date" >
                                    <input type='text' class="form-control" id="travel-season-end-date-field" data-date-format="DD/MM/YYYY" name="travel_season_date_end" value="{{ App\Libraries\Helpers::displayDate(Input::old('travel_season_date_end', isset($source) ? $source->trav_season_end : null)) }}" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="booking-season-start">Booking Season Start</label>
                                <div class='input-group date' id="booking-start-date" >
                                    <input type='text' class="form-control" id="booking-season-start" data-date-format="DD/MM/YYYY" name="booking_season_start" value="{{ App\Libraries\Helpers::displayDate(Input::old('booking_season_start', isset($source) ? $source->book_season_start : null)) }}" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="booking-season-end">Booking Season End</label>
                                <div class='input-group date' id="booking-end-date" >
                                    <input type='text' class="form-control" id="booking-season-end" data-date-format="DD/MM/YYYY" name="booking_season_end" value="{{ App\Libraries\Helpers::displayDate(Input::old('booking_season_end', isset($source) ? $source->book_season_end : null)) }}" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="booking-season-end">Choose as Default</label>
                                    <input  type="checkbox" id="default-flag" name="default_flag" autocomplete="off" @if (Input::old('default_flag',isset($source) ? $source->default_flag : 0)) {{"checked"}} @endif />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 visible-lg hidden-md ">
                    <input type="submit" id="save-source" type="submit" class="btn btn-purple" value="Save">
                </div>
            </div>
        </div>

    </form>
</div>

@stop

@section('script')
<script>
    $(document).ready(function () {

    var confirmText = "This Sorce Commision will be deleted";
    swlConfirm(confirmText);
    // Sorry you won't be able to hack this even if you change these values :P
    var user_id = "{{Auth::user()->id}}";
    var firstname = "{{Auth::user()->firstname}}";
    var lastname = "{{Auth::user()->lastname}}";
    var productId = $("#product-id").val();
    var languageId = $("#language-id").val();
    var mode = "{{$mode}}";
    $("#travel-start-date,#travel-end-date, #booking-start-date, #booking-end-date").datetimepicker({
        format: 'DD/MM/YYYY',
    });
    $('#source-name-id').select2();
    $('#product-option-id').select2();
    $(".booking-panel").on("change", "#source-group-id", function () {
    loadSelectData("#source-name-id", "sources/names/group", {source_group_id: this.value});
    if (this.value == SourceGroup.DISTRIBUTOR.value) {
    $("#payment-method-id").select2("val", PaymentMethod.BANKTRANSFER.value);
    }
    });
    $(".booking-panel").on("change", "#product-id", function () {
    productId = this.value;
    loadProductOption();
    var addonSelect = ".addons-panel #addon-id";
    loadSelectDataArray(addonSelect, "addons", {product_id: productId}, true);
    });
    $(".booking-panel").on("change", "#language-id", function () {
    languageId = this.value;
    resetSelect("#product-option-id");
    loadProducts();
    });
    function loadProductOption() {
    var travelDate = $("#travel-date-field").val();
    var bookingDate = $("#booking-date-field").val();
    loadSelectData("#product-option-id", "products/options/product", {product_id: productId, language_id: languageId, travel_date: travelDate, booking_date: bookingDate});
    }

    function loadProducts() {
    $("#product-option-id").select2("val", '');
    var travelDate = $("#travel-date-field").val();
    var bookingDate = $("#booking-date-field").val();
    loadSelectData("#product-id", "products", {language_id: languageId, travel_date: travelDate, booking_date: bookingDate});
    }

    $('#source-form').on('click', '#cancel-only', function (e) {
    e.preventDefault();
    var control = $(this);
    var id = control.data("id");
    if (id > 0) {
    swal({
    title: "Are you sure?",
            text: "This booking will be cancelled",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d9534f",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            closeOnConfirm: false, closeOnCancel: true},
            function (isConfirm) {
            if (isConfirm) {
            $.post("/admin/services/bookings/" + id + "/cancel", function (data) {
            control.attr("disabled", true);
            control.removeClass("btn-default")
                    .addClass("btn-danger")
                    .text("CANCELED");
            swal("Success!", "The booking has been cancelled.", "success");
            });
            }
            }
    );
    }
    });
    $("#source-form").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var productOptionId = $("#product-option-id").val();
    var form = $("#source-form");
    var id = form.data("id");
    params = {product_option_id: productOptionId, id: id};
    form.unbind('submit').submit();
    });
    $("input#child-price, input#adult-price").inputmask('decimal', {
    radixPoint: ',',
            autoGroup: false,
            digits: 2,
            digitsOptional: false,
            suffix: ' €',
            placeholder: '0',
            rightAlign: false
    });
    });
    function save_option(option_value) {
    console.log(option_value)
            var option_id = option_value;
    var option_value = $("select#product-option-id option:selected").text();
    ;
    var product_id = $('select#product-id').val();
    var product_value = $('select#product-id option:selected').text();
    var str = "<div class='alert alert-warning alert-dismissible' role='alert' id=productoption_" + option_id + "><input type='hidden' name=product_options[] value=" + option_id + " >";
    str += product_value + "-" + option_value + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $('#source_product_options').append(str)
    }

    function deleteOption(source_id, product_option_id){
    var source_id = source_id;
    var product_option_id = product_option_id;
    var param = { source_id: source_id, product_option_id:product_option_id};
    console.log(product_option_id)
            $.post("/admin/source/deleteOption", param, function (data) {

            });
    }
</script>
@stop