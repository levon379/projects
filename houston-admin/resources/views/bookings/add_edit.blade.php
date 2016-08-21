@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Booking <small>{{ ucwords($mode) }}</small></h1></div>
@if(Session::has('success'))
	<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if(Session::has('error'))
	<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
<div class="alert alert-danger" style="display: none;" id="net_rate_error">Multiple Net Rates Available. Please adjust in Net Rates form before continuing</div>
@if($errors->any())
<div class="validation-summary-errors alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<ul>
		{!! implode('', $errors->all('<li class="error">:message</li>')) !!}
	</ul>
</div>
@endif
@if(!empty($orderId))
<div class="row breadcrumb-row">
    <div class="btn-group btn-breadcrumb col-lg-12">
        <a href="/admin/orders" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/orders" class="btn btn-default"><div>Orders</div></a>
        <a href="/admin/orders/{{$orderId}}/bookings" class="btn btn-default"><div>Bookings</div></a>
        @if($mode=="edit")
            <a href="/admin/bookings/{{$booking->id}}/edit?order={{$orderId}}" class="btn btn-default active"><div>{{ucwords($mode)}} Booking</div></a>
        @else
            <a href="/admin/bookings/add?order={{$orderId}}" class="btn btn-default active"><div>{{ucwords($mode)}} Booking</div></a>
        @endif
    </div>
</div>
@endif
<div class="row">
    <form method="post" action="@if (isset($booking)){{ URL::to('/admin/bookings/' . $booking->id . '/edit') }}@endif" role="form" id="booking-form" data-id="{{isset($booking) ? $booking->id : 0}}">
        <div class="col-md-6">
            <!--First Panel BOOKING INFO -->
            <div class="panel panel-default booking-panel">
                <div class="panel-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="order_id" value="{{ isset($orderId) ? $orderId : '' }}">
                    <input type="hidden" id="kid-disabled-value" name="booking_kid_disabled" value="{{Input::old('booking_kid_disabled',0)}}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="booking-date">Booking Date</label>
                                <div class='input-group date' id="booking-date" >
                                    <input type='text' class="form-control" id="booking-date-field" data-date-format="DD/MM/YYYY" name="booking_date" value="{{ App\Libraries\Helpers::displayDate(Input::old('booking_date', isset($booking) ? $booking->created_at->toDateString() : null)) }}" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="travel-date">Travel Date</label>
                                <div class='input-group date' id="travel-date" >
                                    <input type='text' class="form-control" id="travel-date-field" data-date-format="DD/MM/YYYY" placeholder="Travel Date" name="travel_date" value="{{ App\Libraries\Helpers::displayDate(Input::old('travel_date', isset($booking) ? $booking->travel_date : null)) }}"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                     </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="source-group-id">Source Group</label>
                                <select class="form-control select2" id="source-group-id" name="source_group_id">
                                    <option value=""></option>
                                    @foreach ($sourceGroups as $sourceGroup)
                                        <option value="{{$sourceGroup->id}}" {{ Input::old('source_group_id', isset($booking) ? $booking->source_name->source_group->id : null ) == $sourceGroup->id ? 'selected' : '' }}>{{$sourceGroup->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="source-name-id">Source Name</label>
                                <select class="form-control select2" id="source-name-id" name="source_name_id">
                                    <option value=""></option>
                                    @foreach ($sourceNames as $sourceName)
                                        <option value="{{$sourceName->id}}" {{ Input::old('source_name_id',  isset($booking) ? $booking->source_name_id : null) == $sourceName->id ? 'selected' : '' }}>{{$sourceName->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="reference-number">Reference Number</label>
                                <input class="form-control" type="text" id="reference-number" name="reference_number" autocomplete="off" value="{{ Input::old('reference_number', isset($booking) ? $booking->reference_number : null) }}"/>
                            </div>
                            <div class="col-lg-6">
                                <label for="product-id">Language</label>
                                <select class="form-control select2-clear" id="language-id" name="language_id">
                                    <option value=""></option>
                                    @foreach ($languages as $language)
                                        <option value="{{$language->id}}" {{ Input::old('language_id' , isset($booking) ? $booking->language_id : 1 ) == $language->id ? 'selected' : '' }}>{{$language->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="product-id">Product</label>
                                <select class="form-control select2" id="product-id" name="product_id">
                                    <option value=""></option>
                                    @foreach ($products as $product)
                                        <option value="{{$product->id}}" {{ Input::old('product_id' , isset($booking) ? $booking->product_option->product->id : null ) == $product->id ? 'selected' : '' }}>{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="product-option-id">Product Option</label>
                                <select class="form-control select2" id="product-option-id" name="product_option_id">
                                    <option value=""></option>
                                    @foreach ($productOptions as $productOption)
                                        <option value="{{$productOption->id}}" {{ Input::old('product_option_id' , isset($booking) ? $booking->product_option_id : null) == $productOption->id ? 'selected' : '' }}>{{$productOption->getNameWithFromTo()}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="payment-method-id">Payment Method</label>
                                <select class="form-control select2" id="payment-method-id" name="payment_method_id">
                                    @foreach ($paymentMethods as $paymentMethod)
                                        <option value="{{$paymentMethod->id}}" {{ Input::old('payment_method_id' , isset($booking) ? $booking->payment_method_id : null) == $paymentMethod->id ? 'selected' : '' }}>{{$paymentMethod->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 no-padd">
                                <div class="col-md-6 col-lg-4">
                                    <label for="adults">Adults</label>
                                    <div class="input-group spinner">
                                        <input type="text" autocomplete="off" id="no-adult" name="no_adult" class="form-control integer" value="{{ Input::old('no_adult', isset($booking) ? $booking->no_adult : 0) }}">
                                        <div class="input-group-btn-vertical">
                                            <a class="btn btn-default"><i class="fa fa-caret-up"></i></a>
                                            <a class="btn btn-default"><i class="fa fa-caret-down"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <label for="kids">Kids</label>
                                    <div class="input-group spinner">
                                        <input type="text"  autocomplete="off" id="no-children" name="no_children" class="form-control integer" value="{{ Input::old('no_children', isset($booking) ? $booking->no_children : 0) }}">
                                        <div class="input-group-btn-vertical">
                                            <a class="btn btn-default"><i class="fa fa-caret-up"></i></a>
                                            <a class="btn btn-default"><i class="fa fa-caret-down"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <label for="total-pax">Total</label>
                                    <input type="text" id="total-pax" name="total_pax" class="form-control" readOnly value="{{ Input::old('total_pax', isset($booking) ? $booking->total_pax : 0) }}">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="promo-id">Promo</label>
                                <select class="form-control select2" id="promo-id" name="promo_id">
                                    <option value=""></option>
                                    @foreach ($promos as $promo)
                                        <option value="{{$promo->id}}" {{ Input::old('promo_id',  isset($booking) ? $booking->promo_id : null) == $promo->id ? 'selected' : '' }}>{{$promo->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-sm-8 col-xs-12 no-padd">
                                <div class="col-lg-12">
                                    <label for="tour-price">Tour Price</label>
                                    <div class='col-sm-12 input-group input-group-total' id="tour-price" >
                                        <input type='text' class="form-control" name="tour_price" autocomplete="off" value="{{ Input::old('tour_price', isset($booking) ? $booking->tour_paid : 0) }}"/>
                                        <span class="input-group-addon" id="compute-tour-price">
                                            <span class="fa glyphicon fa-calculator"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!--END: First Panel BOOKING INFO -->
            <style type="text/css">
                #statuses .btn { width:130px; }
            </style>
            <!-- Booking Status -->
            <div class="row" id="statuses">
                <div class="col-md-6">
                     <div class="panel panel-default">
                        <div class="panel-heading">Payment Status</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn @if (Input::old('paid_flag',isset($booking) ? $booking->getPaidValue() : 1)) {{"btn-success active"}} @else {{"btn-danger"}} @endif">

                                        <span>
                                            @if (Input::old('paid_flag',isset($booking) ? $booking->getPaidValue() : 1)) {{"PAID"}} @else {{"UNPAID"}} @endif
                                        </span>

                                        <input id="paid-value" name="paid_flag" value="1" autocomplete="off" @if (Input::old('paid_flag',isset($booking) ? $booking->getPaidValue() : 1)) {{"checked"}} @endif type="checkbox">
                                    </label>
                                </div>
                            </div>
                            @if($mode == "edit")
                            <div class="form-group">
                                <a id="cancel-refund" class="btn {{ ($refunded and $deleted) ? "btn-danger" : "btn-default"}}" data-id="{{isset($booking) ? $booking->id : 0}}" @if ($deleted && $refunded) {{"disabled"}} @endif>
                                    {{ ($refunded and $deleted) ? "REFUNDED" : "Refund"}}
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                     <div class="panel panel-default">
                        <div class="panel-heading">Booking Status</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn @if (Input::old('pending',isset($booking) ? $booking->getPendingValue() : 0)) {{"btn-danger active"}} @else {{"btn-success"}} @endif">

                                        <span>
                                            @if (Input::old('pending',isset($booking) ? $booking->getPendingValue() : 0)) {{"PENDING"}} @else {{"CONFIRMED"}} @endif
                                        </span>

                                        <input id="pending" name="pending" value="1" autocomplete="off" @if (Input::old('pending',isset($booking) ? $booking->getPendingValue() : 0)) {{"checked"}} @endif type="checkbox">
                                    </label>
                                </div>
                            </div>
                            @if($mode == "edit")
                            <div class="form-group">
                                <a id="cancel-only" class="btn {{ $deleted ? "btn-danger" : "btn-default"}}" data-id="{{isset($booking) ? $booking->id : 0}}" @if ($deleted) {{"disabled"}} @endif>
                                    {{ $deleted ? "CANCELED" : "Cancel" }}
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
                <!--END: Guide -->


            <!-- Other Passengers -->
            <div class="panel panel-default passenger-panel">
                <div class="panel-heading">
                    Other Passengers
                    <div class="pull-right delete">
                        <input type="button" class="btn btn-success btn-xs passenger-add-row" value="Add Passenger">
                    </div>
                </div>
                <div class="panel-body" style="display:none;">
                      <div class="form-group" id="passenger-list">
                            @foreach ($passengersOld as $passengerOld)
                                <div class="row passenger-row">
                                    <input type="hidden" id="booking-passenger-id-value" name="booking_passenger_id[]" value="{{$passengerOld->client_id}}">
                                    <div class="col-lg-10">
                                        <label for="last-name-companion">Name</label>
                                        <input type="text" name="client_name[]" class="form-control" autocomplete="off" value="{{ $passengerOld->name }}">
                                    </div>
                                    <div class="col-lg-2 form-control-srow">
                                        <label class="cr-styled">
                                            <input type="hidden" class="adult-flag-value" name="adult_flag[]" value="{{ $passengerOld->adult_flag ? '1' : '0' }}">
                                            <input type="checkbox" class="adult-flag" autocomplete="off" {{ $passengerOld->adult_flag ? 'checked' : '' }}>
                                            <i class="fa"></i>
                                        </label>
                                        Adult
                                    </div>
                                    <div class="pull-right delete">
                                        <input type="button" class="btn btn-danger btn-xs passenger-delete" value="Delete">
                                    </div>
                                </div>
                            @endforeach
                            @include('partials.passenger')
                      </div>
                </div>
            </div>
            <!--END: Other Passengers -->

            <!-- Booking Addons -->
            <div class="panel panel-default addons-panel">
                <div class="panel-heading">
                    Booking Addons
                    <div class="pull-right delete">
                        <input type="button" class="btn btn-success btn-xs addon-add-row" value="Add Addons">
                    </div>
                </div>
                <div class="panel-body addon-panel" style="display:none;">
                      <div id="addon-list">
                          @foreach ($addonsOld as $key => $addonOld)
                              <div class="col-lg-6 addon-row">
                                  <input type="hidden" id="booking-addon-id-value" name="booking_addon_id[]" value="{{$addonOld->addon_id}}">
                                  <input type="hidden" id="addon-kid-disabled-value" name="kid_disabled[]" value="{{$addonOld->kid_disabled ? 1 : 0}}">
                                  <div class="pull-right delete">
                                      <input type="button" class="btn btn-danger btn-xs addon-delete" value="Delete">
                                  </div>
                                  <div class="form-group">
                                      <label for="addons">Addon</label>
                                      <select class="form-control select2 addon-id" id="addon-id" name="addon_id[]" value="{{ $addonOld->id }}">
                                          <option value=""></option>
                                          @foreach ($addons as $addon)
                                                <option value="{{$addon->addon_id}}" {{ $addonOld->id == $addon->addon_id ? 'selected' : '' }}>{{$addon->addon->name}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <div class="row">
                                          <div class="col-md-6 col-lg-4">
                                              <label for="adults">Adults</label>
                                              <div class="input-group spinner">
                                                  <input type="text" autocomplete="off" id="no-adult-addons" name="no_adult_addons[]" class="form-control integer" value="{{ $addonOld->no_adult ?: 0}}">
                                                  <div class="input-group-btn-vertical">
                                                      <a class="btn btn-default"><i class="fa fa-caret-up"></i></a>
                                                      <a class="btn btn-default"><i class="fa fa-caret-down"></i></a>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-6 col-lg-4">
                                              <label for="kids">Kids</label>
                                              <div class="input-group spinner">
                                                  <input type="text"  autocomplete="off" id="no-children-addons" name="no_children_addons[]" class="form-control integer" value="{{ $addonOld->no_children ?: 0}}">
                                                  <div class="input-group-btn-vertical">
                                                      <a class="btn btn-default"><i class="fa fa-caret-up"></i></a>
                                                      <a class="btn btn-default"><i class="fa fa-caret-down"></i></a>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-12 col-lg-4">
                                              <label for="total">Total</label>
                                              <input type="text" id="total-pax-addons" class="form-control" readonly value="{{ $addonOld->total }}">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="payment-method-id">Payment Method</label>
                                      <select class="form-control select2" id="payment-method-id" name="payment_method_id_addons[]" value="{{ $addonOld->payment_method_id }}">
                                          <option value=""></option>
                                          @foreach ($paymentMethods as $paymentMethod)
                                                <option value="{{$paymentMethod->id}}" {{ $addonOld->payment_method_id == $paymentMethod->id ? 'selected' : '' }}>{{$paymentMethod->name}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <div class="row">
                                          <div class="col-lg-8 col-md-7">
                                              <label for="price">Price</label>
                                              <div class='input-group input-group-total' id="price" >
                                                  <input type='text' class="form-control booking-addon-total-price" name="total_paid_addons[]" autocomplete="off" value="{{ $addonOld->paid }}" />
                                                  <span class="input-group-addon total-addon-price">
                                                      <span class="fa glyphicon fa-calculator"></span>
                                                  </span>
                                              </div>
                                          </div>
                                          <div class="col-lg-4 col-md-5 form-control-srow">
                                              <label for="bookingaddon-paid-{{$key}}">Paid?</label>
                                              <div class="switch-button sm showcase-switch-button">
                                                  <input type="hidden" id="paid_addons" name="paid_addons[]" value="0">
                                                  <input id="bookingaddon-paid-{{$key}}" type="checkbox"  {{ $addonOld->paid_flag ? 'checked' : '' }}>
                                                  <label for="bookingaddon-paid-{{$key}}"></label>
                                              </div>
                                          </div>
                                      </div>
                                 </div>
                             </div>
                         @endforeach
                         @include('partials.addon')
                     </div>
                </div>
            </div>
            <!--END: Booking Addons -->

            <!-- Guide -->
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Guide</div>
                        <div class="panel-body">
                             <div class="form-group">
                                <label for="payment-method-id">Guide</label>
                                <select class="form-control select2-clear" id="guide-user-id" name="guide_user_id">
                                    <option value=""></option>
                                    @foreach ($guides as $guide)
                                        <option value="{{$guide->id}}" {{ Input::old('guide_user_id', isset($booking) ? $booking->guide_user_id : null ) == $guide->id ? 'selected' : '' }}>{{$guide->getName()}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--END: Guide -->

                <!-- Total Price -->
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Total Price</div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="tour-price">Total Price</label>
                                <div class='col-sm-12 input-group input-group-total' id="total-price" >
                                    <input type='text' class="form-control" name="total_price" readonly value="{{ Input::old('total_price', isset($booking) ? $booking->total_paid : null) }}"/>
                                    <span class="input-group-addon" id="compute-total-price">
                                        <span class="fa glyphicon fa-calculator"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--END: Total Price -->
            </div>

            @if($mode == "edit")
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Feedback Request</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <a class="btn btn-purple" data-id="{{isset($booking) ? $booking->id : 0}}" id="send-feedback-button" @if ($feedbacksent) {{"disabled"}} @endif>Send Feedback Request</a>
                                        <span class="send-feedback-text">@if ($feedbacksent) {{"Feedback Request Sent on $feedbackDate by $feedbackSentBy"}} @endif</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-md-12 visible-lg hidden-md {{$mode}}-operation-button-tp">
                    <input type="submit" id="save-booking" type="submit" class="btn btn-purple" value="Save">
                    <a class="btn btn-purple" disabled>Print Voucher</a>
                    @if($mode == "edit")
                    <a id="delete-booking" class="btn btn-danger">Permanent Delete</a>
                    @endif
                </div>

            </div>

        </div>
        <div class="col-md-6">
            <!-- Lead Traveler Info -->
            <div class="panel panel-default">
                <div class="panel-heading">Lead Traveler Info</div>
                <div class="panel-body">
                  <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="last-name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($booking) ? $booking->name : null) }}">
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="local-contact">Local Contact</label>
                                    <input type="text" class="form-control" name="local_contact" id="local-contact" placeholder="Local Contact" autocomplete="off" value="{{ Input::old('local_contact', isset($booking) ? $booking->local_contact : null) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" autocomplete="off" value="{{ Input::old('email', isset($booking) ? $booking->email : null) }}">
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="hotel">Hotel</label>
                                    <textarea class="form-control" name="hotel" cols="65" rows="2">{!! Input::old('hotel', isset($booking) ? $booking->hotel : null) !!}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="special_reqs">Special Requirements</label>
                                    <textarea class="form-control" name="special_reqs" cols="65" rows="2">{!! Input::old('special_reqs', isset($booking) ? $booking->special_reqs : null) !!}</textarea>
                                </div>
                            </div>
                        </div>
                      </div>
                </div>
            </div>
            <!--END: Lead Traveler Info -->

            <!-- Billing Address -->
            <div class="panel panel-default billing-address-panel">
                <div class="panel-heading">
                    Billing Address
                    <div class="pull-right">
                        <input type="button" class="btn btn-success btn-xs toggle-panel" value="Show">
                    </div>
                </div>
                <div class="panel-body" style="display:none;">
                      <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="address-line1">Address Line 1</label>
                                <input type="text" placeholder="Address Line 1" name="address_line1" class="form-control" value="{{ Input::old('address_line1', isset($booking) ? $booking->address_line_1 : null) }}">
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="address-line2">Address Line 2</label>
                                <input type="text" placeholder="Address Line 2" name="address_line2" class="form-control" value="{{ Input::old('address_line2', isset($booking) ? $booking->address_line_2 : null) }}">
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="country">Country</label>
                                <input type="text" name="country" class="form-control" value="{{ Input::old('country', isset($booking) ? $booking->country : null) }}">
                            </div>
                            <div class="col-lg-6">
                                <label for="city">City</label>
                                <input type="text" name="city" class="form-control" value="{{ Input::old('city', isset($booking) ? $booking->city : null) }}">
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="state-province">State/Province</label>
                                <input type="text" name="state_province" class="form-control" value="{{ Input::old('state_province', isset($booking) ? $booking->state_province : null) }}">
                            </div>
                            <div class="col-lg-6">
                                <label for="zip">ZIP/CAP</label>
                                <input type="text" name="zip" class="form-control" value="{{ Input::old('zip', isset($booking) ? $booking->zip : null) }}">
                            </div>
                        </div>
                      </div>
                </div>
            </div>
            <!--END: Billing Address -->

            <!-- Booking Notes -->
            <div class="panel panel-default">
                <div class="panel-heading">Booking Notes</div>
                <div class="panel-body">
                    <div class="comment-list">
                        <input type="hidden" name="comment_user_id" value="{{Auth::user()->id}}">
                        @foreach ($commentsOld as $key => $commentOld)
                        <div class="comment">
                            <p class="pull-right"><small>{{$commentOld->date}}</small></p>
                            <input type="hidden" id="booking-comment-id-value" name="booking_comment_id[]" value="{{$commentOld->comment_id}}">
                            <input type="hidden"  id="comment-date-value"  name="comment_date[]" value="{{$commentOld->date}}">
                            <input type="hidden"  id="comment-firstname-value"  name="comment_firstname[]" value="{{$commentOld->firstname}}">
                            <input type="hidden"  id="comment-lastname-value"  name="comment_lastname[]" value="{{$commentOld->lastname}}">
                            <input type="hidden"  id="comment-user-value" name="comment_user[]" value="{{$commentOld->user_id}}">
                            <input type="hidden" id="comment-text-value" name="comment_text[]" value="{{{$commentOld->comment}}}">
                            <div class="comment-body">
                                <h4 class="comment-heading user-name">{{$commentOld->firstname}}</h4>
                                <div class="comment-text">{!! nl2br($commentOld->comment) !!}</div>
                                <p><small>@if ($commentOld->user_id == Auth::user()->id) <a href="#" class="comment-es">Edit</a> @else <span class="muted">Edit</span> @endif - <a href="#" class="comment-delete">Delete</a></small></p>
                            </div>
                        </div>
                        @endforeach
                        @include('partials.comment')
                    </div>
                    <div class="notes-row">
                        <div class="form-group">
                            <label for="addComment">Note</label>
                            <textarea class="form-control" name="addComment" id="addComment" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <a class="btn btn-success" type="submit" id="submitComment"><span class="glyphicon glyphicon-comment"></span> Submit Note</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--END: Booking Notes-->
        </div>

        <div class="col-md-12 visible-md visible-xs visible-sm {{$mode}}-operation-button-bt">
            <input type="submit" id="save-booking" type="submit" class="btn btn-purple" value="Save">
            @if($mode == "edit")
            <a class="btn btn-purple" href='{{ URL::to("admin/bookings/{$booking->id}/voucher/print") }}'>Print Voucher</a>
            <a id="delete-booking" class="btn btn-danger" data-id="{{isset($booking) ? $booking->id : 0}}">Permanent Delete</a>
            @endif
        </div>

    </form>
    @include('partials.bookingswarning')
</div>

@stop

@section('script')
<script>
    $(document).ready(function(){

        var confirmText = "This booking will be deleted";
        swlConfirm(confirmText);

        // Sorry you won't be able to hack this even if you change these values :P
        var user_id = "{{Auth::user()->id}}";
        var firstname = "{{Auth::user()->firstname}}";
        var lastname = "{{Auth::user()->lastname}}";
        var productId = $("#product-id").val();
        var languageId = $("#language-id").val();
        var mode = "{{$mode}}";
        var bookingKidDisabled = $("#kid-disabled-value").val() == 1 ? true : false;

        $("#no-children").prop('readonly', bookingKidDisabled);
        $("#no-children").closest(".spinner").find("a").prop("disabled",bookingKidDisabled);


        $("#addon-kid-disabled-value").each(function(index){
            var thisObj = $(this).closest(".addon-row");
            var addonKidDisabled = thisObj.find("#addon-kid-disabled-value").val() == 1 ? true : false;
            var addonKid = thisObj.find("#no-children-addons");
            addonKid.prop('readonly', addonKidDisabled);
            addonKid.closest(".spinner").find("a").prop("disabled",addonKidDisabled);
        });

		$("#booking-date").datetimepicker({
			format: 'DD/MM/YYYY',
			defaultDate: 'now'
		});
		$("#travel-date").datetimepicker({
			format: 'DD/MM/YYYY'
		});

        $('#source-name-id').select2();
        $('#product-option-id').select2();


		$(".booking-panel").on("change","#source-group-id",function(){
            loadSelectData("#source-name-id","sources/names/group",{ source_group_id : this.value });
            if(this.value == SourceGroup.DISTRIBUTOR.value){
                $("#payment-method-id").select2("val",PaymentMethod.BANKTRANSFER.value);
            }
		});

        $(".booking-panel").on("dp.change","#travel-date",function(){
            resetSelect("#product-option-id");
            loadProducts();
        });
        $(".booking-panel").on("dp.change","#booking-date",function(){
            resetSelect("#product-option-id");
            loadProducts();
        });

		$(".booking-panel").on("change","#product-id",function(){
            productId = this.value;
            loadProductOption();
            loadPromos();

            var addonSelect = ".addons-panel #addon-id";
            loadSelectDataArray(addonSelect,"addons", { product_id : productId },true);
		});

        $(".booking-panel").on("change","#language-id", function() {
            languageId = this.value;
            resetSelect("#product-option-id");
            loadProducts();
        });

        hideShowPanels();

        function hideShowPanels(){
            var passengerCount = $(".passenger-row").length;
            var addonsCount = $(".addon-row").length;

            if(passengerCount>0){
                $(".passenger-panel .panel-body").show("slow");
            } else {
                $(".passenger-panel .panel-body").hide("slow");
            }

            if(addonsCount>0){
                $(".addons-panel .panel-body").show("slow");
            } else {
                $(".addons-panel .panel-body").hide("slow");
            }
        }

        function loadProductOption(){
            var travelDate = $("#travel-date-field").val();
            var bookingDate = $("#booking-date-field").val();
            loadSelectData("#product-option-id","products/options/product",{ product_id : productId , language_id : languageId  , travel_date : travelDate , booking_date : bookingDate });
        }

        function loadPromos(sendProductOptionId){
            var sendProductOptionId = sendProductOptionId || false;
            var data = {};
            data.product_id = $("#product-id").val();
            if(sendProductOptionId){
                data.product_option_id = $("#product-option-id").val();
            }
            data.travel_date = $("#travel-date-field").val();
            data.booking_date = $("#booking-date-field").val();
            loadSelectData("#promo-id","promos", data);
        }

        function loadProducts(){
            $("#product-option-id").select2("val",'');
            var travelDate = $("#travel-date-field").val();
            var bookingDate = $("#booking-date-field").val();
            loadSelectData("#product-id","products",{ language_id : languageId  , travel_date : travelDate , booking_date : bookingDate });
        }
		
		$(".booking-panel").on("change","#product-option-id", function() {
            var prodoptId = $(this).val();
			$.get( "/admin/services/products/options/childprice", {product_option_id : prodoptId}).done(function(data){
                var readonly = (data === "true");
                 if(readonly){
                    $("#no-children").val(0);
                    $("#no-children").trigger("change");
                }
                $("#no-children").prop('readonly', readonly);
                $("#no-children").closest(".spinner").find("a").prop("disabled",readonly);
                $("#kid-disabled-value").val(readonly ? 1 : 0);
			});
            loadPromos(true);
        });
		
		$("#no-adult, #no-children").on("change paste keyup keydown", function() {
           var value1 = parseInt($("#no-adult").val());
           value1 = isNaN(value1) ? 0 : value1;
           var value2 = parseInt($("#no-children").val());
           value2 = isNaN(value2) ? 0 : value2;
		   var total =  value1 + value2;
		   $("#total-pax").val(total);
		});
        $(".addons-panel").on("change paste keyup keydown", "#no-adult-addons, #no-children-addons", function() {
            var adult = $(this).closest(".addon-row").find("#no-adult-addons");
            var value1 = parseInt(adult.val());
            value1 = isNaN(value1) ? 0 : value1;
            var children = $(this).closest(".addon-row").find("#no-children-addons");
            var value2 = parseInt(children.val());
            value2 = isNaN(value2) ? 0 : value2;
            var total =  value1 + value2;
            $(this).closest(".addon-row").find("#total-pax-addons").val(total);
        });
		$("#promo-id").select2({'allowClear':true});
		
		$(".addons-panel").on("change",".addon-id", function() {
            var addonId = $(this).val();
			var thisObj = $(this).closest(".addon-row");
			$.get( "/admin/services/addons/childprice", {addon_id : addonId}).done(function(data){
                var readonly = (data === "true");
                if(readonly){
                    thisObj.find("#no-children-addons").val(0);
                    thisObj.find("#no-children-addons").trigger("change");
                }
			    thisObj.find("#no-children-addons").prop('readonly', readonly);
				thisObj.find("#no-children-addons").closest(".spinner").find("a").prop("disabled",readonly);
                thisObj.find("#addon-kid-disabled-value").val(readonly ? 1 : 0);
			});
			
        });


        $(".passenger-panel").on("change",".adult-flag",function(){
            var isChecked  = $(this).is(':checked');
            var checkValue = $(this).closest(".cr-styled").find(".adult-flag-value");
            var value = isChecked ? 1 : 0;
            checkValue.val(value);
            console.log(checkValue.val());
        });


        $("#paid-value").on("change",function(){
            var isChecked  = $(this).is(':checked');

            if(isChecked)
            {
                str = "PAID";
            }
            else
            {
                str = "UNPAID";
            }

            $(this).closest(".btn")
                    .toggleClass("btn-success")
                    .toggleClass("btn-danger")
                    .find("span").text(str);


        });

        $("#pending").on("change",function(){
            var isChecked  = $(this).is(':checked');

            if(isChecked)
            {
                str = "PENDING";
            }
            else
            {
                str = "CONFIRMED";
            }

            $(this).closest(".btn")
                    .toggleClass("btn-success")
                    .toggleClass("btn-danger")
                    .find("span").text(str);


        });

        $(".addon-panel").on("change","input[id^='bookingaddon-paid']",function(){
            var isChecked  = $(this).is(':checked');
            var checkValue = $(this).closest(".switch-button").find("#paid_addons");
            var value = isChecked ? 1 : 0;
            checkValue.val(value);
            console.log(checkValue.val());
        });

        $('.comment-list').on('click', '.comment-es', function(e){
            e.preventDefault();
            if (!$(this).attr('data-toggled') || $(this).attr('data-toggled') == 'off'){
                // Edit
                $(this).attr('data-toggled','on');
                $(this).text('Save');
                var div = $(this).closest(".comment-body").find('div');
                var commentText = div.html();
                var comment = $("#comment-edit-row-template").html();
                var template = Handlebars.compile(comment);
                console.log(commentText.replace(/<br>/g,"\r\n"));
                console.log(commentText);
                var html = template({ comment : commentText.replace(/<br>/g,"\r\n")});
                div.replaceWith(html);
            }
            else if ($(this).attr('data-toggled') == 'on'){
                // Save
                $(this).attr('data-toggled','off');
                $(this).text('Edit');
                var commentContainer = $(this).closest(".comment");
                var commentTextValue = commentContainer.find("#comment-text-value");
                var textarea = $(this).closest(".comment-body").find('textarea');
                var commentText = textarea.val().replace(/\r?\n/g, '<br>');
                var comment = $("#comment-save-row-template").html();
                var template = Handlebars.compile(comment);
                var html = template({ comment : commentText});
                textarea.replaceWith(html);
                commentTextValue.val(commentText);
                commentContainer.effect("highlight", {}, 1000);
            }
        });

        $("#submitComment").click(function(e){
            e.preventDefault();
            var commentText = $("#addComment").val();
            if(commentText){
                var commentRow = $("#comment-row-template").html();
                var template = Handlebars.compile(commentRow);
                var dateString = moment().format("YYYY-MM-DD HH:mm:ss");
                var time = moment(dateString);
                var data = {
                    comment : commentText.replace(/\r?\n/g, '<br>'),
                    name : firstname ,
                    comment_firstname : firstname ,
                    comment_lastname : lastname ,
                    comment_user_id : user_id,
                    comment_date: time.fromNow()
                }
                var html = template(data);
                $(".comment-list").append(html);
                $("#addComment").val("");
            }
        })

        $("#passenger-list").on("click",'.passenger-delete',function(){
            var row = $(this).closest(".passenger-row");
            var id = row.find("#booking-passenger-id-value").val();
            swal({
                    title: "Are you sure?",
                    text: "This passenger will be deleted",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d9534f",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,   closeOnCancel: true },
                function(isConfirm){
                    if (isConfirm) {
                        if(id>0){
                            $.post( "/admin/services/bookings/clients/"+id+"/delete", function( data ) {
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

        $('.comment-list').on('click', '.comment-delete', function(e){
            e.preventDefault();
            var comment = $(this).closest(".comment");
            var id = comment.find("#booking-comment-id-value").val();
            swal({
                    title: "Are you sure?",
                    text: "This comment will be deleted",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d9534f",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,   closeOnCancel: true },
                function(isConfirm){
                    if (isConfirm) {
                        if(id>0){
                            $.post( "/admin/services/bookings/comments/"+id+"/delete", function( data ) {
                                comment.fadeOut(500, function() {
                                    comment.remove();
                                });
                            });
                        } else {
                            comment.fadeOut(500, function() {
                                comment.remove();
                            });
                        }
                    }
                }
            );
        });

        $('#booking-form').on('click', '#delete-booking', function(e){
            e.preventDefault();
            var control = $(this);
            var id = control.data("id");
            swal({
                    title: "Are you sure?",
                    text: "This booking will be deleted",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d9534f",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,   closeOnCancel: true },
                function(isConfirm){
                    if (isConfirm) {
                        if(id>0){
                            $.post( "/admin/bookings/"+id+"/delete", function( data ) {
                                document.location.href = '/admin/bookings';
                            });
                        }
                    }
                }
            );
        });

        $("#addon-list").on("click",'.addon-delete',function(){
            var row = $(this).closest(".addon-row");
            var id = row.find("#booking-addon-id-value").val();
            swal({
                    title: "Are you sure?",
                    text: "This addon will be deleted",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d9534f",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,   closeOnCancel: true },
                function(isConfirm){
                    if (isConfirm) {
                        if(id>0){
                            $.post( "/admin/services/bookings/addons/"+id+"/delete", function( data ) {
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

        $('#booking-form').on('click', '#send-feedback-button', function(e){
            e.preventDefault();
            var control = $(this);
            var id = control.data("id");
            if(id > 0){
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
                            $.post( "/admin/services/bookings/"+id+"/sendfeedback", function( data ) {
                                if(data.wcount>0){
                                    var warning = $("#bookings-warning").html();
                                    var template = Handlebars.compile(warning);
                                    var confirmText = template({ errors : data.w});
                                    swal({
                                        title: "Error",
                                        html: confirmText,
                                        type: "error"
                                    });
                                } else {
                                    $(".send-feedback-text").html(data.s);
                                    control.attr("disabled",true);
                                    swal("Success!", "The feedback request has been sent.", "success");
                                }
                            });
                        }
                    }
                );
            }
        });

        $('#booking-form').on('click', '#cancel-only', function(e){
            e.preventDefault();
            var control = $(this);
            var id = control.data("id");
            if(id > 0){
                swal({
                        title: "Are you sure?",
                        text: "This booking will be cancelled",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d9534f",
                        confirmButtonText: "Yes",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,   closeOnCancel: true },
                    function(isConfirm){
                        if (isConfirm) {
                            $.post( "/admin/services/bookings/"+id+"/cancel", function( data ) {
                                 control.attr("disabled",true);
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

        $('#booking-form').on('click', '#cancel-refund', function(e){
            e.preventDefault();
            var control = $(this);
            var id = control.data("id");
            if(id > 0){
                swal({
                        title: "Are you sure?",
                        text: "This booking will be cancelled and refunded",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d9534f",
                        confirmButtonText: "Yes",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,   closeOnCancel: true },
                    function(isConfirm){
                        if (isConfirm) {
                            $.post( "/admin/services/bookings/"+id+"/refund", function( data ) {
                                control.attr("disabled",true);

                                control.removeClass("btn-default")
                                        .addClass("btn-danger")
                                        .text("REFUNDED");

                                $('#cancel-only').attr("disabled",true);

                                $('#cancel-only').removeClass("btn-default")
                                        .addClass("btn-danger")
                                        .text("CANCELED");

                                $("#total-price").find("input[name='total_price']").val("0.00");
                                $("#tour-price").find("input[name='tour_price']").val("0.00");
                                $("#paid-value").closest('.btn').click();
                                swal("Success!", "The booking has been cancelled and refunded", "success");
                            });
                        }
                    }
                );
            }
        });


        $("#booking-form").submit(function(e){
            e.preventDefault();
            var form = $(this);
            var dateValue = $("#travel-date-field").val();
            var productOptionId = $("#product-option-id").val();
            var totalPerson = $("#total-pax").val();
            var language = $("#language-id").val();
            var referenceNo = mode == "add" ? $("#reference-number").val() : null;
            var form = $("#booking-form");
            var id = form.data("id");

            params = { date: dateValue, product_option_id: productOptionId , total : totalPerson, reference_no : referenceNo , language : language, id : id};

            if(productOptionId && dateValue){
                $.get( "/admin/services/bookings/validate-date", params).done(function(data){
                    if(data.wcount>0){
                        var warning = $("#bookings-warning").html();
                        var template = Handlebars.compile(warning);
                        var confirmText = template({ errors : data.w});
                        swal({
                                title: "Save Anyway?",
                                html: confirmText,
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#d9534f",
                                confirmButtonText: "Yes",
                                cancelButtonText: "Cancel",
                                closeOnConfirm: true,   closeOnsCancel: true },
                            function(isConfirm){
                                if (isConfirm) {
                                    form.unbind('submit').submit();
                                }
                            }
                        );
                    } else {
                        form.unbind('submit').submit();
                    }
                });
            } else {
                form.unbind('submit').submit();
            }
        });

        $(".toggle-panel").click(function(){
            $(".billing-address-panel .panel-body").fadeToggle();
            if ($.trim($(".toggle-panel").val()) === 'Show') {
                $(".toggle-panel").val('Hide');
            } else {
                $(".toggle-panel").val('Show');
            }
        });


        hideShowBilling();

        function hideShowBilling(){
            var notEmpty = 0;
            $(".billing-address-panel .panel-body :input").map(function(){
                if( $(this).val() ) {
                    notEmpty++;
                }
            });

            if(notEmpty>0){
                $(".billing-address-panel .panel-body").show();
            }
        }

        $(".passenger-add-row").click(function(){
            var row   = $("#passenger-row-template").html();
            $("#passenger-list").append(row);
            hideShowPanels();
        })

        $(".addon-add-row").click(function(){
            var count = $("#addon-list .addon-row").length;
            var row   = $("#addon-row-template").html();
            var template = Handlebars.compile(row);
            var html = template({ count : count});
            $("#addon-list").append(html);
            console.log(count);
            var addonSelect = ".addon-row-"+count+" #addon-id";
            loadSelectData(addonSelect,"addons", { product_id : productId },true);
            var addonSelect2 = ".addon-row-"+count+" #payment-method-id";
            loadSelectData(addonSelect2,"payment-methods", null ,true);


            $(".addon-row-"+count+" .integer").inputmask('integer',{ rightAlign: false});
			
			$(".addon-row-"+count+" .booking-addon-total-price").inputmask('decimal',{
                radixPoint : ',',
                autoGroup : false ,
                digits : 2 ,
                digitsOptional : false,
                suffix: ' €',
                placeholder: '0',
                rightAlign: false
            });
            
			hideShowPanels();
        });
		
		$("#booking-form").on("click", ".total-addon-price", function(){
			var row = $(this).closest(".addon-row");
            var addonId = row.find("#addon-id").val();
			var adultNo = row.find("#no-adult-addons").val();
			var childrenNo = row.find("#no-children-addons").val();
			var addonPrice = row.find('#price > input');
            var productId = $("#product-id").val();
            var productOptionId = $("#product-option-id").val();
            var promoId = $("#promo-id").val();
			function computeClicked(){}
			
			$(".total-addon-price").off( "click" , computeClicked);
			$.get( "/admin/services/bookings/compute/addonprice", { 
                addon_id : addonId,
                adult_no : adultNo,
                child_no : childrenNo,
                product_id: productId,
                product_option_id: productOptionId,
                promo_id: promoId
            }).done(function( data ) {
				addonPrice.val(data); 
				$(".total-addon-price").on( "click" , computeClicked);
                computeTotalPrice();
			});
		});

        $("#booking-form").on("change blur", "#price, #tour-price", function() {
            computeTotalPrice();
        });
		
		$("#compute-tour-price").click(function(){
            computeTourPrice();
		});

        $(".booking-panel").on("change","#promo-id",function(){
            computeTourPrice();
        });

        function computeTourPrice(){
            var productOptionId = $("#product-option-id").val();
            var source_name_id = $("#source-name-id option:selected").val();
            var booking_date = $("#booking-date-field").val();
            var travel_date = $("#travel-date-field").val();
            var adultNo = $("#no-adult").val();
            var childrenNo = $("#no-children").val();
            var promoId = $("#promo-id").val();
            function computeClicked(){}

            $("#compute-tour-price").off( "click" , computeClicked);
            if(source_name_id != ''){
                $.get( "/admin/services/bookings/compute/tourprice", 
                            { 
                                product_option_id : productOptionId ,source_name_id:source_name_id,
                                booking_date:booking_date,travel_date:travel_date, adult_no : adultNo, 
                                child_no : childrenNo , promo_id : promoId
                            }
                    ).done(function( data ) {
                        var obj = $.parseJSON(data)
                        console.log(obj);
                        console.log(obj.net_rate_error);
                        if(obj.net_rate_error != undefined){
                            $("#tour-price > input").val(obj.tourPrice);  
                            if(obj.net_rate_error == true){
                                $("#net_rate_error").show();    
                            }else{
                                $("#net_rate_error").hide(); 
                            }
                        }else{
                            $("#tour-price > input").val(obj);
                            $("#net_rate_error").hide(); 
                        }
                        $("#compute-tour-price").on( "click" , computeClicked);
                        computeTotalPrice();
                });
            }
        }

		$("#compute-total-price").click(function(){
            computeTotalPrice();
		});

        function computeTotalPrice(){
            var productPrice = $("input[name=tour_price]").val();
            var promoId = $("#promo-id").val();
            var adultNo = $("#no-adult").val();
            var childrenNo = $("#no-children").val();
            var bookingAddonsTotal = 0;
            $(".booking-addon-total-price").each(function(){
                bookingAddonsTotal = parseFloat(bookingAddonsTotal) + cleanPrice($(this).val());
            });

            function computeClicked(){}

            $("#compute-total-price").off( "click" , computeClicked);
            $.get( "/admin/services/bookings/compute/totalprice", { product_price : productPrice , booking_addons_total : bookingAddonsTotal}).done(function( data ) {
                $("#total-price > input").val(data);
                $("#compute-total-price").on( "click" , computeClicked);
            });
        }
		
		$("#tour-price > input, #total-price > input, .booking-addon-total-price").inputmask('decimal',{
                radixPoint : ',',
                autoGroup : false ,
                digits : 2 ,
                digitsOptional : false,
                suffix: ' €',
                placeholder: '0',
                rightAlign: false
            });
    });
</script>
@stop