@extends('layouts.master')

@section('content')
			<div class="banner">
				<ul class="random-images">
					<li>
						<div class="banner-logo hidden-sm hidden-md hidden-lg">
							<a href="#" class="logo-b"><img src="/assets/images/app/logo.png" alt="Eco art travel" width="139" height="75"></a>
							<span class="text">Extraordinary ways to explore Italy.</span>
						</div>
						<div class="bg-stretch">
							<img class="fadeIn" src="/assets/images/app/img01.jpg" alt="image description" width="2198" height="940">
						</div>
					</li>
					<li>
						<div class="banner-logo hidden-sm hidden-md hidden-lg">
							<a href="#" class="logo-b"><img src="/assets/images/app/logo.png" alt="Eco art travel" width="139" height="75"></a>
							<span class="text">Extraordinary ways to explore Italy.</span>
						</div>
						<div class="bg-stretch">
							<img class="fadeIn" src="/assets/images/app/img40.jpg" alt="image description" width="2198" height="940">
						</div>
					</li>
					<li>
						<div class="banner-logo hidden-sm hidden-md hidden-lg">
							<a href="#" class="logo-b"><img src="/assets/images/app/logo.png" alt="Eco art travel" width="139" height="75"></a>
							<span class="text">Extraordinary ways to explore Italy.</span>
						</div>
						<div class="bg-stretch">
							<img class="fadeIn" src="/assets/images/app/img41.jpg" alt="image description" width="2198" height="940">
						</div>
					</li>
				</ul>
				<div class="container">
					<div class="banner-box pull-right">
						<section class="welcome-block">
							<div class="description pull-left">
								<h1 class="line-bar">Welcome to EcoArt</h1>
								<p>EcoArt an Italy-based Tour Operator promoting unique and extraordinary ways to explore the peninsula and beyond.</p>
							</div>
							<div class="video-holder pull-right">
								<img src="/assets/images/app/img02.jpg" alt="image desciption" width="335" height="234">
								<!-- <a href="#" class="btn-play"><span class="icon-play"></span></a> -->
							</div>
						</section>
						<section class="why-block">
							<h2>why us?</h2>
							<div class="three-col">
								<a href='{{ url("en/about-ecoart-travel") }}' class="col dark-green">
									<h3 class="line-bar">
										<span class="hold">
											<span class="icon icon-local"></span>
											<span class="text">We're local</span>
										</span>
									</h3>
									<p>Stop by our office, we’re located right next to the Colosseum.</p>
								</a>
								<a href='{{ url("en/about-ecoart-travel") }}' class="col purple">
									<h3 class="line-bar">
										<span class="hold">
											<span class="icon icon-loved"></span>
											<span class="text">We're loved</span>
										</span>
									</h3>
									<p>It doesn’t get much better than a 5 star rating on TripAdvisor.</p>
								</a>
								<a href='{{ url("en/about-ecoart-travel") }}' class="col green">
									<h3 class="line-bar">
										<span class="hold">
											<span class="icon icon-extraordinary"></span>
											<span class="text">We're extraordinary</span>
										</span>
									</h3>
									<p>Stop by our office, we’re located right next to the Colosseum.</p>
								</a>
							</div>
						</section>
					</div>
				</div>
			</div>
			<div class="container tab-block">
				<div role="tabpanel" id="tabpanel">
					<ul id="myTab" class="nav nav-tabs nav-justified" role="tablist">
						<li role="presentation" class="active"><a href="#tours" aria-controls="tours" role="tab" data-toggle="tab"><span class="hold">Tours</span></a></li>
						<li role="presentation"><a href="#tickets" aria-controls="tickets" role="tab" data-toggle="tab"><span class="hold">Tickets</span></a></li>
						<li role="presentation"><a href="#transfer" aria-controls="transfer" role="tab" data-toggle="tab"><span class="hold">Transfers</span></a></li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="tours">
							<div class="view-bar">
								<a href="/en/things-to-do-in-rome" class="btn btn-success pull-right">View All</a>
							</div>

							<br>

							<div class="product-list-view">

								@if( count($products) == 0 )
								<div class="alert alert-warning" role="alert">
									<strong>COMING SOON!</strong>
								</div>
								@endif

								@foreach($products as $product)
								<article class="list-view-box">
									<div class="row">
										<div class="img-holder col-sm-4">
											@if( $product->getImage( Config::get('constants.PRODUCT_LIST_PAGE_PRODUCT_IMAGE') ) )
												<img alt="{{ $product->getImage( Config::get('constants.PRODUCT_LIST_PAGE_PRODUCT_IMAGE') )->alt_text }}" src="/images/{{ $product->getImage( Config::get('constants.PRODUCT_LIST_PAGE_PRODUCT_IMAGE') )->hash }}/neutral" width="308" />
												@endif
										</div>
										<div class="description col-sm-8">
											<div class="row">
												<div class="col-sm-6">
													<h2><a href="{{ "/".$locale."/".$product->city->languageDetail->slug."/".$product->languageDetail->url }}">{{ $product->languageDetail->name }}</a></h2>
													{!! HTML::decode(str_ireplace('<ul>', '<ul class="list-unstyled detail-list">', $product->languageDetail->minidescription)) !!}
												</div>
												<div class="col-sm-6">
													<ul class="list-inline col-detail">
														<li class="time">
															<div class="icon-holder">
																<span class="icon-clock"></span>
															</div>
															{!! HTML::decode($product->languageDetail->duration) !!}
														</li>
														<li class="based-review">
															<div class="icon-holder">
																<span class="fa fa-star"></span> {{ $product->averageRating }}
															</div>
															Based on {{ $product->reviewsCount }} Reviews
														</li>
														<li class="price-tag">
															<div class="icon-holder">
																<span class="fa fa-tags"></span>
															</div>
															From <span class="price">€ {{ number_format( $product->default_price, 2 ) }}</span>
														</li>
													</ul>
													<div class="btn-holder">
														<a class="btn btn-success" href="{{ "/".$locale."/".$product->city->languageDetail->slug."/".$product->languageDetail->url }}">Discover</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</article>
								@endforeach
							</div>

							<div class="show-box">
								<a href='http://www.ecoarttravel.com/en/things-to-do-in-rome' class="btn btn-success">show all products</a>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="tickets">
							<div class="view-bar">
								<a href="http://www.ecoarttravel.com/en/things-to-do-in-rome" class="btn btn-success pull-right">View All</a>
							</div>

							<br>

							<div class="product-list-view">

								@if( count($tickets) == 0 )
								<div class="alert alert-warning" role="alert">
									<strong>COMING SOON!</strong>
								</div>
								@endif

								@foreach($tickets as $product)
								<article class="list-view-box">
									<div class="row">
										<div class="img-holder col-sm-4">
											@if( $product->getImage( Config::get('constants.PRODUCT_LIST_PAGE_PRODUCT_IMAGE') ) )
												<img alt="{{ $product->getImage( Config::get('constants.PRODUCT_LIST_PAGE_PRODUCT_IMAGE') )->alt_text }}" src="/images/{{ $product->getImage( Config::get('constants.PRODUCT_LIST_PAGE_PRODUCT_IMAGE') )->hash }}/neutral" width="308" />
												@endif
										</div>
										<div class="description col-sm-8">
											<div class="row">
												<div class="col-sm-6">
													<h2><a href="{{ "/".$locale."/".$product->city->languageDetail->slug."/".$product->languageDetail->url }}">{{ $product->languageDetail->name }}</a></h2>
													{!! HTML::decode(str_ireplace('<ul>', '<ul class="list-unstyled detail-list">', $product->languageDetail->minidescription)) !!}
												</div>
												<div class="col-sm-6">
													<ul class="list-inline col-detail">
														<li class="time">
															<div class="icon-holder">
																<span class="icon-clock"></span>
															</div>
															{!! HTML::decode($product->languageDetail->duration) !!}
														</li>
														<li class="based-review">
															<div class="icon-holder">
																<span class="fa fa-star"></span> {{ $product->averageRating }}
															</div>
															Based on {{ $product->reviewsCount }} Reviews
														</li>
														<li class="price-tag">
															<div class="icon-holder">
																<span class="fa fa-tags"></span>
															</div>
															From <span class="price">€ {{ number_format( $product->default_price, 2 ) }}</span>
														</li>
													</ul>
													<div class="btn-holder">
														<a class="btn btn-success" href="{{ "/".$locale."/".$product->city->languageDetail->slug."/".$product->languageDetail->url }}">Discover</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</article>
								@endforeach
							</div>

							<div class="show-box">
								<a href="http://www.ecoarttravel.com/en/things-to-do-in-rome" class="btn btn-success">show all products</a>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="transfer">
							<div class="view-bar">
								<a href="http://www.ecoarttravel.com/en/things-to-do-in-rome" class="btn btn-success pull-right">View All</a>
							</div>

							<br>

							<div class="product-list-view">

								@if( count($transfers) == 0 )
								<div class="alert alert-warning" role="alert">
									<strong>COMING SOON!</strong>
								</div>
								@endif

								@foreach($transfers as $product)
								<article class="list-view-box">
									<div class="row">
										<div class="img-holder col-sm-4">
											@if( $product->getImage( Config::get('constants.PRODUCT_LIST_PAGE_PRODUCT_IMAGE') ) )
												<img alt="{{ $product->getImage( Config::get('constants.PRODUCT_LIST_PAGE_PRODUCT_IMAGE') )->alt_text }}" src="/images/{{ $product->getImage( Config::get('constants.PRODUCT_LIST_PAGE_PRODUCT_IMAGE') )->hash }}/neutral" width="308" />
												@endif
										</div>
										<div class="description col-sm-8">
											<div class="row">
												<div class="col-sm-6">
													<h2><a href="{{ "/".$locale."/".$product->city->languageDetail->slug."/".$product->languageDetail->url }}">{{ $product->languageDetail->name }}</a></h2>
													{!! HTML::decode(str_ireplace('<ul>', '<ul class="list-unstyled detail-list">', $product->languageDetail->minidescription)) !!}
												</div>
												<div class="col-sm-6">
													<ul class="list-inline col-detail">
														<li class="time">
															<div class="icon-holder">
																<span class="icon-clock"></span>
															</div>
															{!! HTML::decode($product->languageDetail->duration) !!}
														</li>
														<li class="based-review">
															<div class="icon-holder">
																<span class="fa fa-star"></span> {{ $product->averageRating }}
															</div>
															Based on {{ $product->reviewsCount }} Reviews
														</li>
														<li class="price-tag">
															<div class="icon-holder">
																<span class="fa fa-tags"></span>
															</div>
															From <span class="price">€ {{ number_format( $product->default_price, 2 ) }}</span>
														</li>
													</ul>
													<div class="btn-holder">
														<a class="btn btn-success" href="{{ "/".$locale."/".$product->city->languageDetail->slug."/".$product->languageDetail->url }}">Discover</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</article>
								@endforeach
							</div>
							
							<div class="show-box">
								<a href="http://www.ecoarttravel.com/en/things-to-do-in-rome" class="btn btn-success">show all products</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<section class="trip-advisor-block container">
				<div class="holder">
					<div class="bg-stretch">
						<img src="/assets/images/app/img07.jpg" alt="image description" width="997" height="442">
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="text-wrap">
								<strong class="title"><a href="#">Trip Advisor</a></strong>
								<h2>SEE REVIEWS OF ECOART TRAVEL</h2>
								<p>EcoArt takes pride in offering extraordinary tours and customer service. Check us out on TripAdvisor to see what those who have experienced the magic of EcoArt firsthand have to say!</p>
								<div class="trip-adviser-logo">
									<a href="http://www.tripadvisor.com/Attraction_Review-g187791-d6908370-Reviews-EcoArt_Travel-Rome_Lazio.html" target="_blank"><img src="/assets/images/app/logo-tripadvisor.png" alt="2014 travellers choice tripadvisior" width="121" height="122"></a>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="review-block">
								<ul class="reviews list-unstyled">
									@foreach( $reviews as $key => $review )
										<li class="{{ $key % 2 == 1 ? 'align-right' : '' }}">
											<div class="img-holder">
												<img src="/assets/images/app/img08.jpg" alt="images description" width="78" height="78">
											</div>
											<div class="blockquote">
												<div class="hold">
													<span class="quote">"{{ $review->title }}"</span>
													<div class="meta">
														<ul class="rating list-inline list-unstyled">
															@for( $i=1; $i<= $review->rating; $i++ )
															<li><img src="/assets/images/app/rating-icon.png" alt="{{ $review->title }}" width="12" height="12"></li>
															@endfor
														</ul>
														<span class="info">Reviewed on <time datetime="{{ $review->created_at }}">{{ Carbon::parse($review->created_at)->format('d M Y') }}</time> <span class="device"><img src="/assets/images/app/mobile.png" alt="" width="8" height="13"></span></span>
													</div>
													<a href="http://www.tripadvisor.com/Attraction_Review-g187791-d6908370-Reviews-EcoArt_Travel-Rome_Lazio.html" target="_blank" class="more">See all reviews of ecoart travel  > </a>
												</div>
											</div>
										</li>
									@endforeach
								</ul>
								<div class="btn-holder">
									<a href="http://www.tripadvisor.com/Attraction_Review-g187791-d6908370-Reviews-EcoArt_Travel-Rome_Lazio.html" target="_blank" class="btn btn-success">DISCOVER all reviews</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- <div class="two-columns container">
				<div class="row">
					<div class="col-sm-6">
						<div class="image-holder">
							<img src="/assets/images/app/img10.jpg" alt="image description" width="482" height="236">
							<strong class="title"><a href="#">Information</a></strong>
						</div>
						<div class="description">
							<h2 class="line-bar"><a href="#">SAVELLI RELIGIOUS</a></h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc orci nulla, malesuada sed nisl eu, ultricies cursus.  Nunc orci nulla, malesuada sed nisl eu, ultricies cursus. </p>
							<div class="btn-holder">
								<a href="#" class="btn btn-success">Discover</a>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="image-holder">
							<img src="/assets/images/app/img11.jpg" alt="image description" width="482" height="236">
							<strong class="title"><a href="#">Information</a></strong>
						</div>
						<div class="description">
							<h2 class="line-bar"><a href="#">SAVELLI RELIGIOUS</a></h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc orci nulla, malesuada sed nisl eu, ultricies cursus.  Nunc orci nulla, malesuada sed nisl eu, ultricies cursus. </p>
							<div class="btn-holder">
								<a href="#" class="btn btn-success">Discover</a>
							</div>
						</div>
					</div>
				</div>
			</div> -->
			<div class="subscribe-block">
				<div class="container">
					<div class="row" id="newsletterFormContainer">
						<div class="col-sm-12 newsletter-status"></div>
						<div class="col-sm-6">
							<span class="text">Would you like to subscribe to our newsletter?</span>
						</div>
						<div class="col-sm-6">
							<form class="form-inline subscribe-form" id="newsletterForm" action="#">
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-addon"><span class="icon-envelope"></span></div>
										<input type="text" name="email" class="form-control">
										<div class="input-group-addon add">
											<button type="submit" class="btn btn-success" data-loading-text="Sending..."><span class="icon-arrow"></span></button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
@endsection

@section("script")
	<script>
	$(document).ready(function(){
		$("#newsletterForm").on({
			submit: function(e){
				e.preventDefault();
				var self = this;
				var _token = "{{ csrf_token() }}";
				var email = $(this).find("input[name='email']").val();
				var url = "/services/newsletter/subscribe";
				var btn = $(this).find(".add button").button("loading");
				$.post(url, {
					email: email,
					_token: _token,
				}, function(response) {
					btn.button('reset');
					if (response.success == true) {
						$(self).parents("#newsletterFormContainer").find(".newsletter-status").html("<div role='alert' class='alert alert-success alert-dismissible'><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>"+ response.message +"</div>");
					} else {
						$(self).parents("#newsletterFormContainer").find(".newsletter-status").html("<div role='alert' class='alert alert-danger alert-dismissible'><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>"+ response.message +"</div>");
					}
				});
				return false;
			}
		});
	});
	</script>
@stop
