@extends('layouts.page')

@section('content')
	
		<div class="checkout-content container">
			<div class="row table-mobile">
				<div class="col-sm-6 table-footer-mobile">
					<form class="checkout-form" action="/shopping-cart/checkout" method="post">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
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
						<section class="contact-box">
							<span class="title">Contact Information</span>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-6">
										<input type="text" name="first_name" class="form-control" placeholder="First name" value="{{\Session::get('cart.first_name', null)}}">
									</div>
									<div class="col-sm-6">
										<input type="text" name="last_name" class="form-control" placeholder="Last name" value="{{\Session::get('cart.last_name', null)}}">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-6">
										<input type="text" name="email" class="form-control" placeholder="Email address" value="{{\Session::get('cart.email', null)}}">
									</div>
									<div class="col-sm-6">
										<input type="text" name="email_confirmation" class="form-control" placeholder="Confirm Email address" value="{{\Session::get('cart.email_confirmation', null)}}">
									</div>
								</div>
							</div>
							<div class="form-group">
								<textarea class="form-control" name="special_requirements" placeholder="Special Requirements" cols="5" rows="5">{{\Session::get('cart.special_requirements', null)}}</textarea>
							</div>
						</section>
						<section class="support-box">
							<h2 class="line-bar">Support while tavelling</h2>
							<div class="form-group">
								<label for="phone">Phone number</label>
								<input id="phone" name="phone_number" type="tel" class="form-control" placeholder="e.g. +1 702 123 4567" value="{{\Session::get('cart.phone_number', null)}}">
							</div>
							<div class="form-group">
								<textarea class="form-control" name="hotel" placeholder="Hotel" cols="5" rows="3">{{\Session::get('cart.hotel', null)}}</textarea>
							</div>
						</section>
						<section class="payment-box">
							<h2 class="line-bar">Payment details</h2>
							<div class="top-box">
								<div class="col">
									<div class="checkbox hidden">
										<label>
											<input type="checkbox"> Same as Contact Above number
										</label>
									</div>
								</div>
							</div>
							<div class="form-group hidden">
								<div class="row">
									<input type="text" id="cc-number" class="form-control" placeholder="Card Number">
								</div>
							</div>
							<div class="form-group hidden">
								<div class="row">
									<input type="text" id="cc-name" class="form-control" placeholder="Card holder name">
								</div>
							</div>
							<div class="form-group hidden">
								<div class="row">
									<div class="col-md-4">
										<label for="cc-exp-month">Expiry Date</label>
									</div>
									<div class="col-md-4">
										<input type="text" id="cc-exp-month" class="form-control" placeholder="MM">
									</div>
									<div class="col-md-4">
										<input type="text" id="cc-exp-year" class="form-control" placeholder="YY">
									</div>
								</div>
							</div>
							<div class="form-group hidden">
								<div class="row">
									<div class="col-md-4">
										<label for="cc-cvv2">Security Code (CVV2/4DBC)</label>
									</div>
									<div class="col-md-8">
										<input type="text" id="cc-cvv2" class="form-control" placeholder="CVV2/4DBC">
									</div>
								</div>
							</div>
							<div class="form-group hidden">
								<div class="row">
									<div class="col-md-4">
										<label for="cc-cvv2">Email</label>
									</div>
									<div class="col-md-8">
										<input type="text" id="cc-email" class="form-control" placeholder="Card Holder's Email">
									</div>
								</div>
							</div>
							<div class="form-group radio-hold">
								<div class="radio">
									<label>
										<input type="radio" name="payment_method" id="payment_method" value="Web-CC" {{ (\Session::get('cart.payment_method', null)==null or \Session::get('cart.payment_method', null) == 'Web-CC') ? 'checked' : '' }} > <img src="/assets/images/app/logo-visa.png" alt="image description" width="100" height="31">
									</label>
								</div>
								<div class="radio hidden">
									<label>
										<input type="radio" name="payment_method" id="optionsRadios2" value="Web-PayPal" {{ (\Session::get('cart.payment_method', null) == 'Web-PayPal') ? 'checked' : '' }} > <img src="/assets/images/app/logo-paypal.png" alt="image description" width="79" height="31">
									</label>
								</div>
							</div>
							<div class="form-holder country-select">
								<label for="country">Country</label>
								<select id="country" name="country" class="form-control">
									@foreach($countries as $country)
										<option value="{{$country->code}}" {{$country->code == \Session::get('cart.country', null) ? 'selected="selected"' : ''}} >{{$country->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" id="terms" name="terms" value="1" {{\Session::get('cart.terms', null) == '1' ? 'checked' : ''}} > I have read and agree to the <a href="https://www.iubenda.com/privacy-policy/540382/cookie-policy?an=no&s_ck=false" target="_blank">Privacy Policy</a>
								</label>
							</div>
                            <div class="shop-note">
                                Note: When you click <strong>Pay Now!</strong> you will be redirected to our bank's secure website.
                            </div>
							<div class="submit-holder">
								<button  type="submit" class="btn btn-success">Pay now!</button>
							</div>
						</section>
					</form>
				</div>
				<div class="col-sm-6">
					<div id="order-summary" class="order-summary">
						{{-- To be populated by refreshOrderSummary ajax request --}}
					</div>
				</div>
			</div>
		</div>

@endsection

@section('script')
<!-- Load the GestPay javascript file -->
@if( !Config::get('app.shopTestEnvironment') )
<!-- Production -->
<script type="text/javascript" src="https://ecomm.sella.it/Pagam/JavaScript/js_GestPay.js"></script>
@else
<!-- TEST --> 
<script type="text/javascript" src="https://testecomm.sella.it/Pagam/JavaScript/js_GestPay.js"></script>
@endif

<!-- Sweet Alert -->
<script src="/assets/js/plugins/sweet-alert/sweetalert2.min.js"></script>

<script>
	$("#phone").intlTelInput();

	function refreshOrderSummary() {
		$.ajax({
			'url' : '/shopping-cart/order-summary',
			'success': function(data) {
				$('#order-summary').html(data);
			}
		});
	}

	$(document).ready(function(){
		refreshOrderSummary();
	})

	$(".order-summary").on("click",'.remove-btn a',function(e){
		e.preventDefault();
		var row = $(this).closest(".box-top");
		var id = row.find(".h-cart-item-id").val();

		swal({
				title: "Are you sure?",
				text: "This product will be removed from your cart.",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "Cancel",
				closeOnConfirm: true,   closeOnCancel: true },
			function(isConfirm){

				if (isConfirm) {
					if(id>=0)
					{
						dataToPost = {
							'_token': '{{csrf_token()}}'
						};

						$.post( "/shopping-cart/remove-item/"+id, dataToPost, function( data ) {
							refreshOrderSummary();
						});
					}
				}
			}
		);
	});

	$(".order-summary").on("click",'#add-promo',function(e){
		
		e.preventDefault();
		$('#promo_code').val('').parent().toggleClass('hidden');

		if( $('#promo_code').parent().hasClass('hidden') ) 
		{
			$('#promo_code').trigger('blur');
		}

	});

	function postPromo(e)
	{

		if( e.keyCode == 13 )
		{
			$('#add-promo').focus();
		} 
		else if( e.type == 'focusout' ) 
		{
			dataToPost = {
				'_token': '{{csrf_token()}}',
				'promo_code' : $('#promo_code').val()
			};

			$.post( "/shopping-cart/add-promo-code", dataToPost, function( data ) {
				refreshOrderSummary();
			});
		}
	}

	$(".order-summary").on("blur",'#promo_code', postPromo);
	$(".order-summary").on("keyup",'#promo_code', postPromo);

</script>
@endsection
