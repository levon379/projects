@extends('layouts.page')

@section('content')
    <div class="success-page container">
        <div class="success-text">
            <span class="pay-title">Payment successful</span>
            <p>Your booking has been processed and we are sending your booking vouchers to the e-mail address you specified: [[EMAIL ADDRESS OF CUSTOMER]]</p>
            <p>If this e-mail address is not correct or your vouchers do not arrive, please contact us a and let us know so we can help you out.</p>
            <p>You can also print each individual voucher by clicking the 'Print Voucher' button below for each service you booked.</p>
            <div class="btn-hold">
                <a href="#" class="btn btn-info">Return to homepage</a>
                <a href="#" class="btn btn-success">Contact us</a>
            </div>
        </div>
        <div class="order-summary">
            <span class="title"> Your Order Summary</span>
            <div class="box-top">
                <div class="img">
                    <img src="/assets/images/app/img47.jpg" alt="image description" width="78" height="78">
                </div>
                <div class="description">
                    <div class="col">
                        <span class="duration">30 April 2015 at 08:30 AM</span>
                        <span class="package-name">Rome by Segway</span>
                        <ul class="people list-unstyled list-inline">
                            <li>1 adults</li>
                            <li>0 kids</li>
                        </ul>
                    </div>
                    <div class="col">
                        <span class="price">€ 95.00</span>
                        <div class="print-btn">
                            <a href="#">Print voucher</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-box">
                <span class="total">Grand total</span>
                <span class="total-price">€ 95.00</span>
            </div>
        </div>
    </div>
@stop