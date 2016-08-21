@extends('layouts.master')

@section('content')
<div class="page-header pg-tourmanager"><h1>Dashboard<small> Tour Manager</small></h1></div>
<div class="main-div">
    <p class="text-white">{{ App\Libraries\Helpers::displayDayDate($date) }}</p>
    <div class="panel panel-success cto-product-panel">
        <div class="panel-heading">{{$totals->name}}
            <ul class="list-unstyled list-inline text-right as-totals pull-right">
                @if($totals->total_package)
                    <li><h3 class="no-margn"><span class="label label-purple limit-remaining"> {{$totals->total_package}} </span></h3></li>
                @endif
                <li><h3 class="no-margn"><span class="label label-info limit-total"> {{$totals->total_bookings}} </span></h3></li>
            </ul>
        </div>
        <div class="panel-body">

            @foreach($options as $option)
            <div class="booking-row" id="booking-row-{{$option->id}}-{{$option->language_id}}" data-date="{{$date}}" data-id="{{$availability}}">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <form role="form" class="form-inline">
                                @if($option->total_package)
                                <button type="button" class="btn btn-purple btn-xs">{{$option->total_package}}</button>
                                @endif
                                <button type="button" class="btn btn-info btn-xs">{{$option->total_bookings}}</button>
                                <span>Bookings for <strong>{{$option->name}} - {{$option->language_name}}</strong></span>
                                @if(Auth::user()->user_type_id != \App\UserType::GUIDE)
                                <div class="switch-button sm">
                                    @if($option->available)
                                        <input id="switch-button-{{$option->proptions_language_id}}" type="checkbox" checked="" data-pol="{{$option->proptions_language_id}}">
                                    @else
                                        <input id="switch-button-{{$option->proptions_language_id}}" type="checkbox" data-pol="{{$option->proptions_language_id}}">
                                    @endif
                                    <label for="switch-button-{{$option->proptions_language_id}}"></label>
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        @if(Auth::user()->user_type_id != \App\UserType::GUIDE)
                        <div class="form-group pull-right">
                            <input type="hidden" name="ids" id="ids-value">
                            <select class="form-control guide-select pull-left" style="width: 200px; margin-right: 10px" name="action" id="action-value">
                                <option></option>
                                @foreach($guides as $guide)
                                    <option value="{{$guide->guide_user_id}}">{{$guide->confirmed}}|{{$guide->firstname_guide}} {{$guide->lastname_guide}}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-green pull-left" type="button" id="action-apply">Assign</button>
                            <div style="clear:both;"></div>
                        </div>
                        @endif
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
                            <th>Book Date</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Adults</th>
                            <th>Kids</th>
                            <th>Total</th>
                            <th>Source</th>
                            <th>Price</th>
                            <th>Paid?</th>
                            <th>Review?</th>
                            <th>Child Booking?</th>
                            @if(Auth::user()->user_type_id != \App\UserType::GUIDE)
                            <th>Edit</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($option->bookings as $booking)
                            <tr>
                                <td class="text-center" style="width:40px;">
                                    <label class="cr-styled booking-id">
                                        <input type="checkbox" ng-model="todo.done" data-id="{{$booking->id}}">
                                        <i class="fa"></i>
                                    </label>
                                </td>
                                <td style="width:96px;">{{ App\Libraries\Helpers::displayDate($booking->created_at->toDateString())  }}</td>
                                <td style="width:20%;">{{ $booking->name }}</td>
                                <td style="width:10%;">{{ $booking->email }}</td>
                                <td style="text-align: center; width: 40px;">{{ $booking->no_adult }}</td>
                                <td style="text-align: center; width: 40px;">{{ $booking->no_children }}</td>
                                <td style="text-align: center; width: 40px;">{{ $booking->no_adult + $booking->no_children }}</td>
                                <td style="width: 150px;">{{ $booking->source_name->name }}</td>
                                <td style="text-align: center; width: 54px;">{{ App\Libraries\Helpers::formatPrice($booking->total_paid) }}</td>
                                <td style="text-align: center; width: 54px;">{!! $booking->getPaid() !!}</td>
                                <td style="text-align: center; width: 74px;" id="review-{{$booking->id}}">{!! $booking->getReviewed() !!}</td>
                                <td style="text-align: center; width: 118px;" >{!! $booking->getChild() !!}</td>
                                @if(Auth::user()->user_type_id != \App\UserType::GUIDE)
                                <td style="text-align: center; width: 54px;">
                                    <a href="/admin/bookings/{{ $booking->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
            @endforeach

        </div>
    </div>
</div>
@stop

@section('script')
<script>
    $(document).ready(function(){

        $(".guide-select").select2({
            formatResult : format,
            formatSelection : format
        });

        function format(o) {
            //o.id o.text
            var text = o.text.split("|");
            var confirmed = text[0];

            if(parseInt(confirmed) > 0){
                return "<i class='fa fa-check text-success'></i> " + text[1];
            } else {
                return "<i class='fa fa-remove text-danger'></i> " + text[1];
            }
        }

        var bookingRows = "[id^='booking-row-']";

        console.log($(bookingRows));

        $(bookingRows).each(function(){
            var bookingRow = $(this);
            var id = bookingRow.attr("id");
            bindBookingRow(id);
        });

        function bindBookingRow(selector){
            selector = "#"+selector;

            var bookingCheck = $(".booking-id input",$(selector));
            var assignButton = $("#action-apply",$(selector));
            var idsValue = $("#ids-value",$(selector));
            var guideValue = $("#action-value",$(selector));
            var switchButton = $(".switch-button input",$(selector));

            bookingCheck.on("change click",function(){
                var ids = [];
                $(".booking-id input:checked",$(selector)).each(function(){
                    var id = $(this).data("id");
                    ids.push(id);
                });
                idsValue.val(ids.join());
            });

            assignButton.click(function(){
                var ids = idsValue.val();
                var idsArray = ids.split(",");
                var idCount = removeEmptyArray(idsArray).length;

                var guide = guideValue.val();

                if(idCount<1){
                    swal({
                        title: "Warning",
                        text: "Please select a booking",
                        type: "warning"
                    });
                    return;
                }

                swal({
                        title: "Are you sure?",
                        text: "This guide would be assigned to the bookings selected",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d9534f",
                        confirmButtonText: "Yes, assign it!",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,   closeOnCancel: true },
                    function(isConfirm){
                        if (isConfirm) {
                            swal.disableButtons();
                            var params = { guide : guide , ids : ids};
                            $.post( "/admin/services/bookings/guide/assign", params).done(function(data){
                                swal("Success!", "The guide has been assigned to the bookings selected.", "success");
                            });
                        }
                    }
                );

            });

            switchButton.on('change',function(){
                var availSlot =  $(selector).data('id')
                var date = $(selector).data('date');
                var pol = $(this).data('pol');
                var dataSelector = "[data-pol='"+pol+"']";

                var check = $(this).is(':checked');
                var block = check ? 0 : 1;

                $(dataSelector,switchButton).each(function(){
                    $(this).prop('checked', check);
                })

                $.ajax({
                    url: '/admin/services/tour-manager/option/update',
                    data: {pol: pol, date: date, block: block},
                    type: 'POST',
                    dataType: 'JSON'
                });

            });
        }



    });
</script>
@stop