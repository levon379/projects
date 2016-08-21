@extends('layouts.print')

@section("content")
    @if(Session::has('success'))
        <div class="alert alert-success">{!! Session::get('success') !!}</div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-danger">{!! Session::get('error') !!}</div>
    @endif
    <div class="page-title" style="margin-bottom: 10px;margin-top:10px;text-align:center">
        <a href="#" class="btn btn-primary" id="printButton"><i class="glyphicon glyphicon-print"></i> Print Voucher</a>
        {{-- <a href='{{ url("admin/bookings/{$booking->id}/voucher/email") }}' class="btn btn-success" id="printButton"><i class="glyphicon glyphicon-envelope"></i> Email Voucher</a> --}}
    </div>
    <div id="wrapper" class="booking-voucher">
        <div class="holder">
            <header id="header">
                <div class="logo">
                    <a href="#"><img src="[[main_logo]]" alt="ecoart tour operator" width="368" height="162"></a>
                </div>
                <div class="logo-b">
                    <a href="#"><img src="[[small_logo]]" width="150" alt="rome by segway"></a>
                </div>
            </header>
            <main id="main" role="main">
                <div class="date-holder">
                    <time>[[created_at]]</time>
                </div>
                <div class="congrats-box">
                    {{--<strong class="title">​CIAO!</strong>--}}
                    <p>[[greeting]]</p>
                    {{--<span class="congrats-text">[Thanks again, we look forward to sharing this adventure with you!]</span>--}}
                </div>
                <div class="booked-detail">
                    <ul class="detail-list">
                        <li>
                            <span class="title">Reference No.: </span>
                            <span class="info">[[reference_number]]</span>
                        </li>
                        <li>
                            <span class="title">Lead Traveler Name: </span>
                            <span class="info">[[name]] (Adult)</span>
                        </li>
                        <li>
                            <span class="title">Additional Passengers: </span>
                            <span class="info">[[passengers]]</span>
                        </li>
                        <li>
                            <span class="title">Adults: </span>
                            <span class="info">[[no_adult]]  <span class="title">Children:</span> [[no_children]] <span class="title">Total Travelers:</span> [[total_pax]]</span>
                        </li>
                        <li>
                            <span class="title">Travel Date: </span>
                            <span class="info">[[travel_date]]</span>
                        </li>
                        <li>
                            <span class="title">Product Booked: </span>
                            <span class="info">[[product_name]]</span>
                        </li>
                        <li>
                            <span class="title">Add-ons Booked: </span>
                            <span class="info">[[addon_names]]</span>
                        </li>
                        <li>
                            <span class="title">Departure Time: </span>
                            <span class="info">[[departure_time]]</span>
                        </li>
                    </ul>
                    <div class="meeting-details">
                        <div class="description">
                            <div><strong>Meeting point instructions:</strong> [[departpoint_instructions]] </div>
                        </div>
                        <div class="bottom-hold">
                            <div class="map-holder">
                                <a href="[[map_url]]" target="_blank"><img src="[[map_image]]" alt="meeting point"></a>
                            </div>
                            <div class="payment-info">
                                <span class="paid">Total Amount Paid: <span class="amount">[[total_paid]]</span></span>
                                <span class="method">Payment Method: <span class="through">[[payment_method]]</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="policy-box">
                    <section class="block-bring">
                        <h2><span class="icons"><img src="{{ asset('assets/images/vouchers/img01.png') }}" alt="image description" width="34" height="34"></span> What to Bring:</h2>
                        [[what_to_bring]]
                    </section>
                    <section class="block-notes">
                        <h2><span class="icons"><img src="{{ asset('assets/images/vouchers/img02.png') }}" alt="image description" width="34" height="34"></span> Important Notes:</h2>
                        [[additionalinfo]]
                    </section>
                    <section class="block-cancel">
                        <h2><span class="icons"><img src="{{ asset('assets/images/vouchers/img03.png') }}" alt="image description" width="33" height="33"></span> Cancellation/Modification Policy</h2>
                        <div class="cancel-text">
                            <p>[[cancelpolicy]]</p>
                        </div>
                    </section>
                </div>
            </main>
            <footer id="footer">
                <strong class="title">Need to get in touch with us?</strong>
                [[provider_contact_details]]
            </footer>
        </div>
    </div>
@stop

@section("script")
    <script>
    $(document).ready(function(){
        // remove empty values
        $(".detail-list").find("li").each(function(index, li){
            if($(li).find(".info").html() == ""){
                $(li).remove();
            }
        });
        $("#printButton").click(function(e){
            e.preventDefault();
            $('#wrapper').printThis();
        });
    });
    </script>
@stop

