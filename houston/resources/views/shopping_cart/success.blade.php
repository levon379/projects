@extends('layouts.page')

@section('content')
    <div class="success-page container">
        @if( $result == "KO" )
            <div class="success-text">
                <span class="pay-title">Payment Failed!</span>
                <p>Sorry, we could not process your payment. System returned the following details:</p>
                <p><strong>{{ $errorCode }}</strong>: {{ $errorDescription }}</p>
                <p>Please try again later with valid payment credentials. Feel free to contact our support team if problem persists.</p>
                <div class="btn-hold">
                    <a href="/" class="btn btn-info">Return to homepage</a>
                    <a href="#" id="do-contact" class="btn btn-success">Contact us</a>
                </div>
            </div>
        @elseif( $result == "OKButOrderNotFound" )
            <div class="success-text">
                <span class="pay-title">Payment Seems Successful!</span>
                <p>Sorry, your payment seems successful but unfortunately we could not find related order in the database. Please reload the page and if problem persists contact our support.</p>
                <div class="btn-hold">
                    <a href="/" class="btn btn-info">Return to homepage</a>
                    <a href="#" id="do-contact" class="btn btn-success">Contact us</a>
                </div>
            </div>
        @elseif( $result == "OK" or $result == "XX" )
            <div class="success-text">
                <span class="pay-title">Payment successful</span>
                <p>Your booking has been processed and we are sending your booking vouchers to the e-mail address you specified: {{ isset($order->bookings[0]) ? $order->bookings[0]->email : '---' }}</p>
                <p>If this e-mail address is not correct or your vouchers do not arrive, please contact us a and let us know so we can help you out.</p>
                <p>You can also print each individual voucher by clicking the 'Print Voucher' button below for each service you booked.</p>
                <div class="btn-hold">
                    <a href="/" class="btn btn-info">Return to homepage</a>
                    <a href="#" id="do-contact" class="btn btn-success">Contact us</a>
                </div>
            </div>
        @endif

        @if( isset($order) and count($order) > 0 )
        <div class="order-summary">
            <span class="title"> Your Order Summary</span>
            <?php $total = 0; ?>
            @foreach( $order->bookings as $booking )
            <?php 
                $product = $booking->product_option->product; 
                $option = $booking->product_option;
                $total = $total + $booking->total_paid;
            ?>
            <div class="box-top">
                <div class="img">
                    <?php $image = $product->getImage(3); ?>
                    <img src="{{ $product->getImageUrl($image, 'thumb') }}" alt="{{ $image->alt_text or "image" }}" width="78" height="78">
                </div>
                <div class="description">
                    <div class="col">
                        <span class="duration">{{ Carbon::createFromFormat('Y-m-d', $booking->travel_date)->format('d M Y') }}</span>
                        <span class="package-name">{{ $product->name }} - {{ $booking->language->name }} - {{ Carbon::parse($option->start_time)->format('H:i A') }}</span>
                        <ul class="people list-unstyled list-inline">
                            <li>{{ (int)$booking->no_adult }} adults</li>
                            <li>{{ (int)$booking->no_children }} kids</li>
                        </ul>
                    </div>
                    <div class="col">
                        <span class="price">€ {{ $booking->total_paid }}</span>
                        <div class="print-btn">
                            <a target="_blank" href="{{ URL::to('/bookings/'.$booking->id).'/voucher/print' }}">Print voucher</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="bottom-box">
                <span class="total">Grand total</span>
                <span class="total-price">€ {{ number_format($total, 2) }}</span>
            </div>
        </div>
        @endif
    </div>
@stop

@section('script')
@parent
<script>
    $('#do-contact').click(function(e) {
        e.preventDefault();
        $('#contact-slide').click();
    });
</script>
@stop