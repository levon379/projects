						<span class="title"> Your Order Summary</span>

						@foreach($cart['products'] as $product)
						
						<div class="box-top">
							<input type="hidden" class="h-cart-item-id" value="{{$product->cartItemId}}" />
							<div class="img">
								<?php $image = $product->details->getImage(3); ?>
								<img src="{{ $product->details->getImageUrl($image, 'thumb') }}" alt="{{ $image->alt_text or "image" }}" width="78" height="78">
							</div>
							<div class="description">
								<div class="col">
									<span class="duration">{{$product->bookingDate}}{{--$product->details->start_times--}}</span>
									<span class="package-name">{{$product->details->name}} - {{ $product->language->name }} - {{ Carbon::parse($product->details->options->where('id', $product->product_option_id)->first()->start_time)->format("H:i A") }}</span>
									<ul class="people list-unstyled list-inline">
										<li>{{ (int)$product->adult_no }} adults</li>
										<li>{{ (int)$product->child_no }} kids</li>
									</ul>
								</div>
								<div class="col">
									<span class="price">€ {{number_format($product->price, 2)}}</span>
									<div class="remove-btn">
										<a href="#">Remove</a>
									</div>
								</div>
							</div>
						</div>
						@endforeach
						<div class="bottom-box">
							<span class="total">Total</span>
							<span class="total-price">€ {{ number_format($cart['totalCartValue'], 2) }}</span>
						</div>
						<a href="#" id="add-promo" class="add-promo col-md-6">Add a promo code</a>
						<div class="col-md-6 {{ \Session::get('cart.promo_code', null) ? '' : 'hidden' }} ">
							<input id="promo_code" type="text" class="form-control" value="{{ \Session::get('cart.promo_code', null) }}" />
						</div>
						<div class="clearfix"></div>