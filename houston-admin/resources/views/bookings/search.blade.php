@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Booking Search Tool</h1></div>


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
@if(Session::has('warning'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! Session::get('warning') !!}
</div>
@endif

<div class="main-div">

    <form action="/admin/bookings/search" method="GET">

    <ul class="list-inline list-unstyled switch-button-row text-white">
        <input type="hidden" id="provider-ids" name="pr" value="1,2,3">
        <li>GoSeek Adventures
            <div class="btn-group toggle-button toggle-option" data-id="1">
                <button class="btn btn-success btn-sm" type="button" data-value="1">Yes</button>
                <button class="btn btn-default btn-sm" type="button" data-value="0">No</button>
            </div>
        </li>
        <li>Rome by Segway
            <div class="btn-group toggle-button toggle-option" data-id="2">
                <button class="btn btn-success btn-sm" type="button" data-value="1">Yes</button>
                <button class="btn btn-default btn-sm" type="button" data-value="0">No</button>
            </div>
        </li>
        <li>EcoArt Travel
            <div class="btn-group toggle-button toggle-option" data-id="3">
                <button class="btn btn-success btn-sm" type="button" data-value="1">Yes</button>
                <button class="btn btn-default btn-sm" type="button" data-value="0">No</button>
            </div>
        </li>
        <li>Select All
            <div class="btn-group toggle-button toggle-all" data-id="0">
                <button class="btn btn-success btn-sm" type="button" data-value="1">Yes</button>
                <button class="btn btn-default btn-sm" type="button" data-value="0">No</button>
            </div>
        </li>
    </ul>

    <div class="panel panel-success border-2px">
        <div class="panel-body">
            <div class="panel panel-default booking-search-panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6 form-horizontal">
                            <div class="form-group">
                                <label for="1" class="col-sm-2 control-label">Booking Dates</label>
                                <div class="col-lg-4">
                                    <div  class="input-group date datetimepicker" id="booking-date-from">
                                        <input type="text" class="form-control" name="bf" value="{{ Input::get('bf') }}" autocomplete="off">
                                        <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span>
                                        </span>
                                    </div>
                                </div>
                                <label for="2" class="col-sm-2  text-center"><strong class="lead"><i class="fa fa-long-arrow-right"></i></strong></label>
                                <div class="col-lg-4">
                                    <div  class="input-group date datetimepicker" id="booking-date-to">
                                        <input type="text" class="form-control" name="bt" value="{{ Input::get('bt') }}" autocomplete="off">
                                        <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6 form-horizontal">
                            <div class="form-group">

                                <label for="3" class="col-sm-2 control-label">Booking ID</label>
                                <div class="col-lg-4">
                                    <input class="form-control" name="br" value="{{ Input::get('br') }}" autocomplete="off">
                                </div>
                                <label for="4" class="col-sm-2 control-label">Order ID</label>
                                <div class="col-lg-4">
                                    <input class="form-control" name="or" value="{{ Input::get('or') }}" autocomplete="off">
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-horizontal">
                            <div class="form-group">
                                <label for="1" class="col-sm-2 control-label">Travel Dates</label>
                                <div class="col-lg-4">
                                    <div  class="input-group date datetimepicker" id="travel-date-from">
                                        <input type="text" class="form-control" name="tf" value="{{ Input::get('tf') }}" autocomplete="off">
                                        <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span>
                                        </span>
                                    </div>
                                </div>
                                <label for="2" class="col-sm-2  text-center"><strong class="lead"><i class="fa fa-long-arrow-right"></i></strong></label>
                                <div class="col-lg-4">
                                    <div  class="input-group date datetimepicker" id="travel-date-to">
                                        <input type="text" class="form-control" name="tt" value="{{ Input::get('tt') }}" autocomplete="off">
                                        <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6 form-horizontal">
                            <div class="form-group">

                                <label for="3" class="col-sm-2 control-label">Product</label>
                                <div class="col-lg-4">

                                    <select class="form-control select2-clear" id="product-id" name="pd">
                                        <option value=""></option>
                                        @foreach ($products as $product)
                                            <option value="{{$product->id }}" {{ Input::get('pd') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <label for="4" class="col-sm-2 control-label">Option</label>
                                <div class="col-lg-4">
                                    <select class="form-control select2-clear" id="product-option-id" name="po">
                                        <option value=""></option>
                                    </select>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-horizontal">
                            <div class="form-group">
                                <label for="1" class="col-sm-2 control-label">Source Group</label>
                                <div class="col-lg-4">
                                    <select class="form-control select2-clear" id="source-group-id" name="sg">
                                        <option value=""></option>
                                        @foreach($sourceGroups as $sourceGroup)
                                            <option value="{{$sourceGroup->id }}" {{ Input::get('sg') == $sourceGroup->id ? 'selected' : '' }}>{{ $sourceGroup->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="2" class="col-sm-2 control-label">Source Name</label>
                                <div class="col-lg-4">
                                    <select class="form-control select2-clear" id="source-name-id" name="sn">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 form-horizontal">
                            <div class="form-group">

                                <label for="3" class="col-sm-2 control-label">Payment Method</label>
                                <div class="col-lg-4">

                                    <select class="form-control select2-clear" name="pm">
                                        <option value=""></option>
                                        @foreach($paymentMethods as $paymentMethod)
                                            <option value="{{$paymentMethod->id }}" {{ Input::get('pm') == $paymentMethod->id ? 'selected' : '' }}>{{ $paymentMethod->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <label for="4" class="col-sm-2 control-label">Paid</label>
                                <div class="col-lg-4">

                                    <select class="form-control select2" name="pa">
                                        <option value="" {{ Input::get('pa') == "" ? 'selected' : '' }}>All</option>
                                        <option value="1" {{ Input::get('pa') == "1" ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ Input::get('pa') == "0" ? 'selected' : '' }}>No</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6 form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="query">Contains</label>
                                <div class="col-lg-4 ">
                                    <input type="text" id="query" class="form-control" name="q" value="{{ Input::get('q') }}" autocomplete="off">
                                </div>
                                <div style="padding-left:0px;" class="col-lg-2 form-control-static">
                                    <i data-original-title="Search by First Name, Last Name, E-mail Address etc." data-toggle="tooltip" data-placement="top" class="fa fa-question-circle tooltip-btn"></i>
                                </div>
                                <div class="col-lg-4 form-control-static">Show Refunded Bookings
                                    <div class="switch-button sm">
                                        <input type="hidden" id="show-refunded-booking-value" name="refunded" value="{{Input::get('refunded', 0)}}">
                                        <input type="checkbox" @if (Input::get('refunded', 0)) {{"checked"}} @endif id="show-refunded-booking">
                                        <label for="show-refunded-booking"></label>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-lg-6 form-horizontal">
                            <div class="form-group">
                                <div style="padding-left:0px;" class="col-lg-2 form-control-static">
                                </div>                                
                                <div class="col-lg-4 form-control-static">Show Cancelled Bookings
                                    <div class="switch-button sm">
                                        <input type="hidden" id="show-deleted-booking-value" name="deleted" value="{{Input::get('deleted', 0)}}">
                                        <input type="checkbox" @if (Input::get('deleted', 0)) {{"checked"}} @endif id="show-deleted-booking">
                                        <label for="show-deleted-booking"></label>
                                    </div>
                                </div>
                                
                                <label for="4" class="col-sm-2 control-label">Pending</label>
                                <div class="col-lg-4">
                                    <select class="form-control select2" name="pe">
                                        <option value="" {{ Input::get('pe') == "" ? 'selected' : '' }}>All</option>
                                        <option value="1" {{ Input::get('pe') == "1" ? 'selected' : '' }}>Pending</option>
                                        <option value="0" {{ Input::get('pe') == "0" ? 'selected' : '' }}>Confirmed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <div class="col-lg-8 form-horizontal">
                        <div class="form-group">
                            <label for="4" class="col-sm-2 control-label" style="width:11.666667% !important">Package Show Options</label>
                                <div class="col-lg-4">
                                    <select class="form-control select2" name="pk">
                                        <option value="" {{ Input::get('pk') == "" ? 'selected' : '' }}>All</option>
                                        <option value="pbg" {{ Input::get('pk') == "pbg" ? 'selected' : '' }}>Parent Bookings Only</option>
                                        <option value="chbg" {{ Input::get('pk') == "chbg" ? 'selected' : '' }}>Child Bookings Only</option>
                                        <option value="0" {{ Input::get('pk') == "0" ? 'selected' : '' }}>None</option>
                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
                    <div class="row">
                        <div class="col-lg-6 form-horizontal">
                            <div class="form-group">
                                <div class="col-lg-4 col-lg-offset-2">
                                    <button class="btn btn-purple btn-block">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    </form>

    <div class="panel panel-success border-2px">
        <div class="panel-body">

            <h5><strong>Total for this seach:</strong></h5>

            <div>
                <ul class="list-inline list-unstyled">
                    <li>Adults</li>

                    <li><button class="btn btn-info " type="button">{{ $bookingValues->adults }}</button></li>

                    <li>Kids</li>

                    <li><button class="btn btn-danger " type="button">{{ $bookingValues->kids }}</button></li>

                    <li>Total Pax</li>

                    <li><button class="btn btn-warning " type="button">{{ $bookingValues->total_pax }}</button></li>

                    <li>Total Paid</li>

                    <li><button class="btn btn-success bordered" type="button">{{ App\Libraries\Helpers::formatPrice($bookingValues->total_paid) }} <i class="fa fa-euro"></i></button></li>
                </ul>
            </div>


            <div class="row">
                <div class="col-lg-4">show &nbsp;
                    <div class="btn-group page-size">
                        <a class="btn btn-default active" href="{{ App\Libraries\Helpers::getFilterUrl(['ps'=>25,'page'=>1]) }}" data-value="25">25</a>
                        <a class="btn btn-default" href="{{ App\Libraries\Helpers::getFilterUrl(['ps'=>50,'page'=>1]) }}" data-value="50">50</a>
                        <a class="btn btn-default " href="{{ App\Libraries\Helpers::getFilterUrl(['ps'=>100,'page'=>1]) }}" data-value="100">100</a>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="form-group pull-right">
                        <input type="hidden" name="ids" id="ids-value">
                        <select class="form-control select2 pull-left" style="width: 200px; margin-right: 10px" name="action" id="action-value">
                            <option value="1">Delete Selected</option>
                            <option value="2">Send Feedback Request</option>
                            <option value="3">Mark as Paid</option>
                            <option value="4">Export to Excel</option>
                            <option value="5">Copy Email Addresses</option>
                            <option value="6">Confirm Selected</option>
                        </select>
                        <button class="btn btn-green pull-left" type="button" id="action-apply">Apply</button>
                        <div style="clear:both;"></div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table rounded-custom">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <label class="cr-styled select-all">
                                    <input type="checkbox" ng-model="todo.done">
                                    <i class="fa"></i>
                                </label>
                            </th>
                            <th>Product/Option/Language</th>
                            <th>Book Date</th>
                            <th>Travel Date</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Adults</th>
                            <th>Kids</th>
                            <th>Total</th>
                            <th>Source</th>
                            <th>Price</th>
                            <th>Paid?</th>
                            <th>Confirmed?</th>
                            <th>Review?</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr class="{{ ($booking->deleted ? "canceled" : "") . " ". ($booking->refunded ? 'refunded' : '') ." ". ($booking->paid_flag == 0 ? "not-paid" : "") ." ". ($booking->pending ? "pending" : "")  }}">
                                <td class="text-center">
                                    <label class="cr-styled booking-id">
                                        <input type="checkbox" ng-model="todo.done" data-id="{{$booking->id}}">
                                        <i class="fa"></i>
                                    </label>
                                </td>
                                <td>{{ $booking->getProductOptionLanguage() }}</td>
                                <td>{{ App\Libraries\Helpers::displayDate($booking->created_at->toDateString())  }}</td>
                                <td>{{ App\Libraries\Helpers::displayDate($booking->travel_date) }}</td>
                                <td>{{ $booking->name }}</td>
                                <td>{{ $booking->email }}</td>
                                <td>{{ $booking->no_adult }}</td>
                                <td>{{ $booking->no_children }}</td>
                                <td>{{ $booking->no_adult + $booking->no_children }}</td>
                                <td>{{ $booking->source_name->name }}</td>
                                <td>{{ App\Libraries\Helpers::formatPrice($booking->total_paid) }}</td>
                                <td style="text-align: center">{!! $booking->getPaid() !!}</td>
                                <td style="text-align: center">
                                    @if($booking->pending)
                                    <i class='fa fa-times text-danger'></i>
                                    @else
                                    <i class='fa fa-check text-success'></i>
                                    @endif
                                </td>
                                <td style="text-align: center" id="review-{{$booking->id}}">{!! $booking->getReviewed() !!}</td>
                                <td>
                                    <a href="/admin/bookings/{{ $booking->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-right">
                <!-- paging here -->
                {!! $bookings->render() !!}
            </div>
            <div id="clipboard-container"><textarea id="clipboard"></textarea></div>
        </div>
    </div>
</div>
<style>
    tr.refunded {
        text-decoration: line-through;
    }

    tr.not-paid {
        font-weight: bold;
    }

    tr.pending {
        background-color: #F5DC81!important;
    }

    .canceled > td{
        border: solid 1px #C9302C !important;
        border-left: 0 !important;
    }
    .canceled > td:first-child{
        border-left: solid 1px #C9302C !important;
    }
    .canceled > td:last-child{
        border: solid 1px #C9302C !important;
        border-left: 0 !important;
    }
</style>
@stop

@section('script')
<script>

    $(document).ready(function(){

        var productId = $("#product-id").val();
        var sourceGroupId = $("#source-group-id").val();

        var productOptionId = getParameterByName('po');
        var sourceNameId = getParameterByName('sn');
        var pageSize = getParameterByName('ps');
        var fullUrl = window.document.location.search;
        var rootUrl = window.document.location.origin;

        $(".booking-id input").on("change click",function(){
            var ids = [];
            $(".booking-id input:checked").each(function(){
                var id = $(this).data("id");
                ids.push(id);
            });
            $("#ids-value").val(ids.join());
            //console.log($("#ids-value").val());
        });

        $(".select-all input").on("change click",function(){
            if(this.checked) { // check select status
                $('.booking-id input').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"
                });
            }else{
                $('.booking-id input').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"
                });
            }
			var ids = [];
            $(".booking-id input:checked").each(function(){
                var id = $(this).data("id");
                ids.push(id);
            });
            $("#ids-value").val(ids.join());
        });

        $("#action-apply").click(function(){
            var ids = $("#ids-value").val();
            var idsArray = ids.split(",");
            var idCount = removeEmptyArray(idsArray).length;

            var action = $("#action-value").val();
            var actions = {
                DELETE : "1",
                SENDFEEDBACK : "2",
                MARKASPAID : "3",
                EXPORTTOEXCEL : "4",
                COPYEMAILADDRESS : "5",
                CONFIRM : "6"
            }

            if(idCount<1){
                swal({
                    title: "Warning",
                    text: "Please select a booking",
                    type: "warning"
                });
                return;
            }

            switch(action){
                case actions.DELETE:
                    swal({
                        title: "Are you sure?",
                        text: "The selected bookings will be deleted",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d9534f",
                        confirmButtonText: "Yes, delete them!",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,   closeOnCancel: true },
                        function(isConfirm){
                            if (isConfirm) {
                                swal.disableButtons();
                                var params = { action : action , ids : ids};
                                $.post( "/admin/services/bookings/search/apply", params).done(function(data){
                                    document.location.href = updateQueryStringParameter(fullUrl,"page",1);
                                });
                            }
                        }
                    );
                    break;
                case actions.SENDFEEDBACK:
                    swal({
                        title: "Are you sure?",
                        text: "This will send a feedback request",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d9534f",
                        confirmButtonText: "Yes",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,   closeOnCancel: true },
                        function(isConfirm){
                            if (isConfirm) {
                                swal.disableButtons();
                                var params = { action : action , ids : ids};
                                $.post( "/admin/services/bookings/search/apply", params).done(function(data){
                                    if(data.wcount>0){
                                        swal({
                                            title: "Error",
                                            html: data.w,
                                            type: "error"
                                        });
                                    } else {
                                        $.each(idsArray,function(i,val){
                                            var i = $("#review-"+val+" i");
                                            i.removeClass("fa-times").addClass("fa-check");
                                            i.removeClass("text-danger").addClass("text-success");
                                        });
                                        swal("Success!", "The feedback request has been sent.", "success");
                                    }
                                });
                            }
                        }
                    );
                    break;
                case actions.MARKASPAID:
                    swal({
                        title: "Are you sure?",
                        text: "These bookings will be marked as paid",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d9534f",
                        confirmButtonText: "Yes",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,   closeOnCancel: true },
                        function(isConfirm){
                            if (isConfirm) {
                                swal.disableButtons();
                                var params = { action : action , ids : ids};
                                $.post( "/admin/services/bookings/search/apply", params).done(function(data){
                                    document.location.href = fullUrl;
                                });
                            }
                        }
                    );
                    break;
                case actions.EXPORTTOEXCEL:
                    document.location.href = updateQueryStringParameter(rootUrl + "/admin/services/bookings/download","ids",ids);
                    break;
                case actions.COPYEMAILADDRESS:
                    var params = { action : action , ids : ids};
                    $.post( "/admin/services/bookings/search/apply", params).done(function(data){
                        EcoClipboard.set(data);
                        swal({
                            title: "Copy",
                            html: "Press <b>CTRL+C</b> to copy the selected emails to clipboard. Close this window once you are done hitting <b>CTRL+C</b>",
                            type: "info"
                        });
                    });
                    break;

                case actions.CONFIRM:
                    swal({
                        title: "Are you sure?",
                        text: "The selected bookings will be confirmed",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d9534f",
                        confirmButtonText: "Yes, confirm!",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,   closeOnCancel: true },
                        function(isConfirm){
                            if (isConfirm) {
                                swal.disableButtons();
                                var params = { action : action , ids : ids};
                                $.post( "/admin/services/bookings/search/apply", params).done(function(data){
                                    document.location.href = fullUrl;
                                });
                            }
                        }
                    );
                    break;
            }
        });


        loadProductOptions(true);
        loadSourceNames(true);

        initSwitches();
        initPageSize();

        function initPageSize(){
            var group = $('.page-size');
            $('a', group).each(function (){
                var element = $(this);
                var value = element.data("value");
                if(value == pageSize){
                    element.siblings().removeClass("active");
                    element.addClass("active");
                }
            });
        }
        
        $(".booking-search-panel").on("change","#show-refunded-booking",function(){
            var isChecked  = $(this).is(':checked');
            var checkValue = $(this).closest(".switch-button").find("#show-refunded-booking-value");
            var value = isChecked ? 1 : 0;
            checkValue.val(value);
        });

        $(".booking-search-panel").on("change","#show-deleted-booking",function(){
            var isChecked  = $(this).is(':checked');
            var checkValue = $(this).closest(".switch-button").find("#show-deleted-booking-value");
            var value = isChecked ? 1 : 0;
            checkValue.val(value);
        });


        function initSwitches(){
            var group = $('ul.switch-button-row');
            var input = $('#provider-ids');

            var providerString = getParameterByName('pr');

            if(providerString){
                input.val(providerString);
            }

            var providerIds = input.val().split(",");

            toggleAll(providerIds.length > 2);

            $('.toggle-option', group).each(function () {
                var buttonGroup = $(this);
                var buttonValue = buttonGroup.data("id");
                $('button',buttonGroup).each(function(){
                    var button = $(this);
                    var bool = button.data("value");
                    bool = bool > 0 ? true : false;

                    if($.inArray(buttonValue+"",providerIds) >= 0 ){
                        if(bool){
                            activateButton(button);
                        }
                    } else {
                        if(!bool){
                            activateButton(button);
                        }
                    }

                    button.on('click',function(){
                        activateButton(button);
                        if(bool){
                            providerIds.push(buttonValue+"");
                            providerIds = cleanArray(providerIds);
                            if(providerIds.length > 2){
                                toggleAll(true);
                            }
                        } else {
                            providerIds = removeArrayElement(buttonValue,providerIds);
                            toggleAll(false);
                        }
                        input.val(providerIds.join());
                    })
                });
            });
            $('ul.switch-button-row .toggle-all button').on('click',function(){
                var button = $(this);
                var value = button.data("value");
                value = value > 0 ? true : false;
                if(value){
                    input.val("1,2,3");
                    providerIds = input.val().split(",");
                    toggleOptions(true);
                } else {
                    input.val("");
                    providerIds = [];
                    toggleOptions(false);
                }

                activateButton(button);
            });

        }

        function activateButton(button){
            button.siblings().removeClass("btn-success").addClass("btn-default");
            button.removeClass("btn-default");
            button.addClass("btn-success");
        }

        function toggleOptions(on){
            var group = $('ul.switch-button-row .toggle-option');
            toggleButton(on, group);
        }

        function toggleAll(on){
            var group = $('ul.switch-button-row .toggle-all');
            toggleButton(on, group);
        }

        function toggleButton(on,group){
            $('button', group).each(function () {
                var button = $(this);
                var buttonValue = button.data("value");
                buttonValue = buttonValue > 0 ? true : false;
                if(buttonValue == on){
                    activateButton(button);
                }
            });
        }

        $("#booking-date-from").datetimepicker({format: 'DD/MM/YYYY' });
        $("#booking-date-to").datetimepicker({format: 'DD/MM/YYYY' });

        $("#booking-date-from").on("dp.change",function (e) {
            $('#booking-date-to').data("DateTimePicker").minDate(e.date);
        });
        $("#booking-date-to").on("dp.change",function (e) {
            $('#booking-date-from').data("DateTimePicker").maxDate(e.date);
        });

        $("#travel-date-from").datetimepicker({format: 'DD/MM/YYYY' });
        $("#travel-date-to").datetimepicker({format: 'DD/MM/YYYY' });

        $("#travel-date-from").on("dp.change",function (e) {
            $('#travel-date-to').data("DateTimePicker").minDate(e.date);
        });
        $("#travel-date-to").on("dp.change",function (e) {
            $('#travel-date-from').data("DateTimePicker").maxDate(e.date);
        });

        $(".booking-search-panel").on("change","#source-group-id",function(){
            sourceGroupId = this.value;
            loadSourceNames();
        });


        function loadSourceNames(setvar){
            setvar = typeof setvar !== 'undefined' ? setvar : false;
            if(!setvar){
                loadSelectData("#source-name-id","sources/names/group",{ source_group_id : sourceGroupId });
            } else {
                loadSelectDataSet("#source-name-id","sources/names/group",{ source_group_id : sourceGroupId },sourceNameId);
            }
        }

        $(".booking-search-panel").on("change","#product-id",function(){
            productId = this.value;
            loadProductOptions();
        });


        function loadProductOptions(setvar){
            setvar = typeof setvar !== 'undefined' ? setvar : false;
            if(!setvar){
                loadSelectData("#product-option-id","products/options/product",{ product_id : productId  });
            } else {
                loadSelectDataSet("#product-option-id","products/options/product",{ product_id : productId  },productOptionId);
            }
        }
    });

</script>
@stop