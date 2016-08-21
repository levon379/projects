@extends('layouts.master')

@section('content')
			<div class="banner">
				<div class="bg-stretch">
					<img src="/assets/images/app/img27.jpg" alt="image description" width="2200" height="940">
				</div>
				<div class="container">
					<section class="gallery-box">
						<div class="heading-wrap">
							<h1>{{ $product->languageDetail->name }}</h1>
							{{--dd($product->languageDetail->subtitle)--}}
							@if( !empty($product->languageDetail->subtitle) )
							<span class="sub-text">{{ $product->languageDetail->subtitle }}</span>
							@endif
						</div>
						<div class="col-wrap">
							<div id="video-box" class="video-box hidden-xs">
								{{-- <img src="/assets/images/app/img28.jpg" alt="image description" width="580" height="400"> --}}
								<div id="video-player" style="max-width:580; overflow:hidden;">
								</div>
							</div>
							<div class="slider-box">
								<div id="carousel-generic" class="carousel slide" data-ride="carousel" data-interval="false" >
									<!-- Wrapper for slides -->
									<div class="carousel-inner" role="listbox">
										@foreach( $imageChunks as $key1 => $chunk)
										<div class="item {{ $key1 == 0 ? 'active' : '' }}">
											<div class="gallery-img">
												@foreach( $chunk as $key2 => $imgCols )
												<div class="col">
													@foreach( $imgCols as $key3 => $image )
													<div class="img-hold">
														@if( isset($image['itemType']) and $image['itemType'] == 'video' )
														<a href="#" class="g-video g-item">
                                                                                                                    <i class="fa fa-4x"></i>
                                                                                                                    <input type="hidden" class="embed-code" value="{{ $image['embed_code'] }}" alt="{{ $image['name'] }}">
                                                                                                                    @if(isset($image['video_thumb']) && !is_null($image['video_thumb']))
                                                                                                                        <img src="{{ URL::to('/video_thumb/'.$image['id']) }}" alt="{{ $image['name'] }}" style="max-width:168px; max-height:118px;">
                                                                                                                    @endif
                                                                                                                </a>
														@else
														<a href="#" class="g-image g-item"><img src="{{ URL::to('/images/'.$image['hash'].'/thumb') }}" alt="{{ $image['alt_text'] }}" data-fullsize="{{ URL::to('/images/'.$image['hash'].'/neutral') }}" style="max-width:168px; max-height:118px;"></a>
														@endif
													</div>
													@endforeach
												</div>
												@endforeach
											</div>
										</div>
										@endforeach
									</div>
									<!-- Controls -->
									@if( $imageCount > 6 )
									<a class="left carousel-control" href="#carousel-generic" role="button" data-slide="prev">
										<span class="icon-arrow-left"></span>
										<span class="sr-only">Previous</span>
									</a>
									<a class="right carousel-control" href="#carousel-generic" role="button" data-slide="next">
										<span class="icon-arrow-right"></span>
										<span class="sr-only">Next</span>
									</a>
									@endif
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
			<div class="product-holder pull-top">
				<div class="container">
					{{-- Right Column Mobile Version --}}
					<div class="widget package-overview visible-xs">
						<div class="heading-wrap">
							<span class="from">from</span>
							<span class="price">{{ number_format( $product->default_price, 2 ) }}€</span>
							<ul class="ratings green list-unstyled list-inline">
								@for( $i=1; $i<= $productRating; $i++ )
								<li><span class="icon-star"></span></li>
								@endfor
							</ul>
							<span class="reviews">{{ count($reviews) }} Reviews</span>
						</div>
						<ul class="list-unstyled overviews">
							@if( !empty($product->languageDetail->start_times) )
							<li class="depature">
								<strong class="heading">Departure Times:</strong>
								<p>{!! HTML::decode($product->languageDetail->start_times) !!}</p>
							</li>
							@endif

							@if( !empty($product->languageDetail->running_days) )
							<li class="running">
								<strong class="heading">Running Days:</strong>
								<p>{!! HTML::decode($product->languageDetail->running_days) !!}</p>
							</li>
							@endif

							@if( !empty($product->languageDetail->duration) )							
							<li class="duration">
								<strong class="heading">Duration:</strong>
								<p>{!! HTML::decode($product->languageDetail->duration) !!}</p>
							</li>
							@endif

							@if( !empty($product->start_times) )
							<li class="duration">
								<strong class="heading">Departure:</strong>
								<p>{!! HTML::decode($product->start_times) !!}</p>
							</li>
							@endif

							@if( !empty($product->languageDetail->departpoint) )
							<li class="meeting">
								<strong class="heading">Meeting Point:</strong>
								<p>{!! HTML::decode($product->languageDetail->departpoint) !!}</p>
							</li>
							@endif

							@if( !empty($product->languageDetail->inclusions) )
							<li class="inclusion">
								<strong class="heading">Inclusion:</strong>
								{!! HTML::decode(str_ireplace('<ul>', '<ul class="list-unstyled inner-list">', $product->languageDetail->inclusions)) !!}
							</li>
							@endif

							@if( !empty($product->languageDetail->exclusions) )
							<li class="exclusion">
								<strong class="heading">Exclusion:</strong>
								{!! HTML::decode(str_ireplace('<ul>', '<ul class="list-unstyled inner-list">', $product->languageDetail->exclusions)) !!}
							</li>
							@endif
						</ul>
					</div>
					<form id="booking-form" class="booking-form" action="/products/{{ $product->id }}/book">
						<span class="form-title">Book here</span>
						<div id="booking-form-container" class="col-holder">
							@include("products.booking-form")
						</div>
					</form>
					<script id="bookings-warning" type="text/x-handlebars-template">
					    <ul id="multiple-warning">
					        @{{#each errors as |error errorId| }}
					        <li class="alert alert-warning">@{{error}}</li>
					        @{{/each}}
					    </ul>
					</script>
					<nav class="breadcrumb-holder text-right hidden-sm hidden-xs">
						<ol class="breadcrumb">
							<li><a href="/">Home</a></li>
							{{--<li><a href="/{{Request::segment(1)}}">{{ ucwords(str_replace('-',' ',Request::segment(1))) }}</a></li>--}}
							<li><a href="/{{Request::segment(1)}}/{{Request::segment(2)}}">{{ ucwords(str_replace("-", " ", $product->city->languageDetail->slug)) }}</a></li>
							<li class="active">{{ $product->name }}</li>
						</ol>
					</nav>
					<div class="content-box row">
						<div class="col-sm-8">
							<div role="tabpanel" id="tabpanel" class="product-tab">
								<ul class="nav nav-tabs nav-justified" role="tablist">
									
									<li role="presentation" class="active"><a href="#about" aria-controls="about" role="tab" data-toggle="tab"><span class="hold">About</span></a></li>
									
									<li role="presentation"><a href="#info" aria-controls="info" role="tab" data-toggle="tab"><span class="hold">Additional info</span></a></li>
									
									@if( count($faqs) > 0 )
									<li role="presentation"><a href="#faq" aria-controls="faq" role="tab" data-toggle="tab"><span class="hold">Faq</span></a></li>
									@endif

									@if( count($reviews) > 0 )
									<li role="presentation"><a href="#review" aria-controls="review" role="tab" data-toggle="tab"><span class="hold">reviews</span></a></li>
									@endif
								</ul>
								
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="about">
										@if( !empty($product->languageDetail->highlights) )
										<div class="box highlights">
											<span class="title"><a href="#">highlights</a></span>
											{!! HTML::decode(str_ireplace('<ul>', '<ul class="custom-list large list-unstyled">', $product->languageDetail->highlights)) !!}
										</div>
										@endif

										@if( !empty($product->languageDetail->description) )
										<div class="box description">
											<span class="title"><a href="#">Description</a></span>
											<div class="img-holder">
												<img src="/images/{{ $product->getImage( Config::get('constants.PRODUCT_DETAIL_INLINE_IMAGE') )->hash }}/neutral" alt="{{ $product->getImage( Config::get('constants.PRODUCT_DETAIL_INLINE_IMAGE'))->alt_text }}" width="606" height="323">
											</div>
											<div class="text-details">
												{!! HTML::decode($product->languageDetail->description) !!}
											</div>
										</div>
										@endif


										@if( !empty( $product->languageDetail->itinerary )  or !empty( $product->languageDetail->itinerary_map ) )
										<div class="box itinerary">
											<span class="title"><a href="#">itinerary</a></span>
											@if( !empty( $product->languageDetail->itinerary_map ) )
											<div class="map-holder">
												<object id="map" type="text/html" data="{{ $product->languageDetail->itinerary_map }}" style="width:100%; height:451px;">
												</object>
											</div>
											@endif
											<div class="details">
												{!! HTML::decode($product->languageDetail->itinerary) !!}
											</div>
										</div>
										@endif
									</div>

									<div role="tabpanel" class="tab-pane" id="info">
										<div class="info-tab">
											{{-- Start/Depart point --}}
											@if( !empty( $product->languageDetail->departpoint )  or !empty($product->languageDetail->departure_point_map) )
											<section class="infos">
												<h3>start point</h3>
												@if( !empty( $product->languageDetail->departure_point_map ) )
												<div class="map-holder">
													<object id="map" type="text/html" data="{{ $product->languageDetail->departure_point_map }}" style="width:100%; height:451px;">
													</object>
												</div>
												@endif
												{!! HTML::decode(str_ireplace('<ul>', '<ul class="list-unstyled plan-point">', $product->languageDetail->departpoint)) !!}
											</section>
											@endif

											{{-- End point --}}
											@if( !empty($product->languageDetail->endpoint) )
											<section class="infos">
												<h3>end point</h3>
												{!! HTML::decode(str_ireplace('<ul>', '<ul class="list-unstyled plan-point">', $product->languageDetail->endpoint)) !!}
											</section>
											@endif

											{{-- Additional Info --}}
											@if( !empty($product->languageDetail->additionalinfo) )
											<section class="infos">
												<h3>special notes</h3>
												{!! HTML::decode( $product->languageDetail->additionalinfo ) !!}
											</section>
											@endif


											{{-- What To Bring --}}
											@if( !empty($product->languageDetail->what_to_bring) )
											<section class="infos">
												<h3>What to Bring</h3>
												{!! HTML::decode( $product->languageDetail->what_to_bring ) !!}
											</section>
											@endif

											{{-- Running Days --}}
											@if( !empty($product->languageDetail->running_days) )
											<section class="infos">
												<h3>Running Days</h3>
												{!! HTML::decode( $product->languageDetail->running_days ) !!}
											</section>
											@endif

											{{-- Cancelation Policy --}}
											@if( !empty($product->languageDetail->cancelpolicy) )
											<section class="infos">
												<h3>Cancellation Policy</h3>
												{!! HTML::decode( $product->languageDetail->cancelpolicy ) !!}
											</section>
											@endif
										</div>
									</div>
									<div role="tabpanel" class="tab-pane {{ count($faqs) == 0 ? 'hidden' : '' }}" id="faq">
										<section class="faq-tab">
											<h3>Faq</h3>
											<ul class="list-unstyled faq-box">
												@foreach($faqs as $faq)
												<li>
													<strong class="question">{{ $faq->question }}</strong>
													<p>{{ $faq->answer }}</p>
												</li>
												@endforeach
											</ul>
										</section>
									</div>
									<div role="tabpanel" class="tab-pane" id="review">
										<div class="review-tab">
											<h3>Reviews</h3>
											<ul class="reviews list-unstyled">
												@foreach( $reviews as $key => $review )
												<li class="{{ $key % 2 == 1 ? 'align-right' : '' }}">
													<div class="img-holder user-logo-main">
														<img src="/assets/images/app/user-placeholder.png" alt="images description" width="75" height="75">
														<span class="name">{{ $review->name }}</span>
													</div>
													<div class="blockquote">
														<div class="hold">
															<span class="quote line-bar">“{{ $review->title }}”</span>
															<ul class="ratings green list-unstyled list-inline">
																@for( $i=1; $i<= $review->rating; $i++ )
																<li><span class="icon-star"></span></li>
																@endfor
															</ul>
															<p>{{ $review->comment }}</p>
														</div>
													</div>
												</li>
												@endforeach
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						{{-- Right Column Desktop Version --}}
						<div class="col-sm-4">
							<div class="widget package-overview hidden-xs">
								<div class="heading-wrap">
									<span class="from">from</span>
									<span class="price">{{ number_format( $product->default_price, 2 ) }}€</span>
									<ul class="ratings green list-unstyled list-inline">
										@for( $i=1; $i<= $productRating; $i++ )
										<li><span class="icon-star"></span></li>
										@endfor
									</ul>
									<span class="reviews">{{ count($reviews) }} Reviews</span>
								</div>
								<ul class="list-unstyled overviews">
									@if( !empty($product->languageDetail->start_times) )
									<li class="depature">
										<strong class="heading">Departure Times:</strong>
										<p>{!! HTML::decode($product->languageDetail->start_times) !!}</p>
									</li>
									@endif

									@if( !empty($product->languageDetail->running_days) )
									<li class="running">
										<strong class="heading">Running Days:</strong>
										<p>{!! HTML::decode($product->languageDetail->running_days) !!}</p>
									</li>
									@endif

									@if( !empty($product->languageDetail->duration) )
									<li class="duration">
										<strong class="heading">Duration:</strong>
										<p>{!! HTML::decode($product->languageDetail->duration) !!}</p>
									</li>
									@endif

									@if( !empty($product->start_times) )
									<li class="duration">
										<strong class="heading">Departure:</strong>
										<p>{!! HTML::decode($product->start_times) !!}</p>
									</li>
									@endif

									@if( !empty($product->languageDetail->departpoint) )
									<li class="meeting">
										<strong class="heading">Meeting Point:</strong>
										<p>{!! HTML::decode($product->languageDetail->departpoint) !!}</p>
									</li>
									@endif

									@if( !empty($product->languageDetail->inclusions) )
									<li class="inclusion">
										<strong class="heading">Inclusion:</strong>
										{!! HTML::decode(str_ireplace('<ul>', '<ul class="list-unstyled inner-list">', $product->languageDetail->inclusions)) !!}
									</li>
									@endif

									@if( !empty($product->languageDetail->exclusions) )
									<li class="exclusion">
										<strong class="heading">Exclusion:</strong>
										{!! HTML::decode(str_ireplace('<ul>', '<ul class="list-unstyled inner-list">', $product->languageDetail->exclusions)) !!}
									</li>
									@endif
								</ul>
							</div>
							<div class="widget powered-box">
								<strong class="title">Powered by:</strong>
								<div class="logo-holder">
									<a href="#"><img src="/images/providers/{{$product->provider->id}}" alt="{{$product->provider->name}}" width="263" height="127"></a>
								</div>
							</div>
							@if( count($latestReviews) > 0 )
							<div class="widget">
								<div class="review-aside">
									<div class="bg-stretch">
										<img src="/assets/images/app/img37.jpg" alt="image description" width="309" height="492">
									</div>
									<ul class="reviews list-unstyled">
										@foreach( $latestReviews as $key => $review )
										<li class="{{ $key % 2 == 1 ? 'align-right' : '' }}">
											@if( $key % 2 == 0 )
											<div class="img-holder user-logo-right">
												<img src="/assets/images/app/user-placeholder.png" alt="images description" width="78" height="78">
											</div>
											@endif
											<div class="blockquote">
												<div class="hold">
													<span class="quote">"{{ $review->title }}"</span>
													<div class="meta">
														<ul class="rating list-inline list-unstyled">
															@for( $i=1; $i<= $review->rating; $i++ )
															<li><img src="/assets/images/app/rating-icon.png" alt="{{ $review->title }}" width="12" height="12"></li>
															@endfor
														</ul>
														<span class="info">Reviewed <time datetime="{{ $review->created_at }}">{{ Carbon::parse($review->created_at)->format('d M Y') }}</time> <span class="device"><img src="/assets/images/app/mobile.png" alt="" width="8" height="13"></span></span>
													</div>
													<a target="_blank" href="http://www.tripadvisor.com/Attraction_Review-g187791-d6908370-Reviews-EcoArt_Travel-Rome_Lazio.html" class="more">See all reviews of EcoArt Travel  > </a>
												</div>
											</div>
											@if( $key % 2 == 1 )
											<div class="img-holder">
												<img src="/assets/images/app/user-placeholder.png" alt="images description" width="78" height="78">
											</div>
											@endif
										</li>
										@endforeach
										
									</ul>
									<div class="btn-holder">
										<a target="_blank" href="http://www.tripadvisor.com/Attraction_Review-g187791-d6908370-Reviews-EcoArt_Travel-Rome_Lazio.html" class="btn btn-success">DISCOVER all reviews</a>
									</div>
								</div>
							</div>
							@endif

							@foreach( $recommendedProducts as $key=>$rProduct )
							<div class="widget recommended-box">
								<article class="thumbnail">
									<div class="top-box">
										<img alt="{{ $rProduct->images()->first()->alt_text }}" src="{{ URL::to('/images/'.$rProduct->images()->first()->hash . '/product-list-thumb') }}" width="309" height="195">
										<strong class="title"><a href="#">recommended</a></strong>
									</div>
									<div class="caption">
										<h2><a href="{{ URL::to('/'.$rProduct->languageDetail->language->code.'/'.$citySlug.'/'.$rProduct->languageDetail->url) }}">{{ $rProduct->languageDetail->name }}</a></h2>
										{!! HTML::decode(str_ireplace('<ul>', '<ul class="list-unstyled detail-list">', $rProduct->languageDetail->minidescription)) !!}
										<div class="row">
											<div class="col-xs-6">
												<div class="time"><span class="icon-clock"></span>
													{!! HTML::decode($rProduct->languageDetail->duration) !!}
												</div>
												<ul class="ratings green list-unstyled list-inline">
													@for($i=1; $i<=$rProduct->averageRating; $i++)
													<li><span class="icon-star"></span></li>
													@endfor
												</ul>
												<span class="review">{{ $rProduct->reviewsCount }} Reviews</span>
											</div>
											<div class="col-xs-6 text-right">
												<span class="price">{{ number_format( $rProduct->default_price, 2 ) }}€</span>
												<a  class="btn btn-success" href="{{ URL::to('/'.$rProduct->languageDetail->language->code.'/'.$citySlug.'/'.$rProduct->languageDetail->url) }}">Discover</a>
											</div>
										</div>
									</div>
								</article>
							</div>
							@endforeach
							
						</div>
					</div>
				</div>
			</div>
			<div class="subscribe-block">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<span class="text">Would you like to subscribe to our newsletter?</span>
						</div>
						<div class="col-sm-6">
							<form class="form-inline subscribe-form" action="#">
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-addon"><span class="icon-envelope"></span></div>
										<input type="text" class="form-control">
										<div class="input-group-addon add">
											<button type="submit" class="btn btn-success"><span class="icon-arrow"></span></button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
@endsection

@section('script')
<script type="text/javascript">
	
	$(function () {

		$(document).ready(function() {      
		   $('.carousel').carousel('pause');
		   loadProductLanguages();
		});

	    $('#booking-date').datetimepicker({
	        //defaultDate: "{{ date('m/d/Y') }}",
	        locale: 'en',
	        format: 'DD/MM/YYYY',
    		extraFormats: [ 'DD/MM/YY' ],
    		disabledDates: {!! json_encode($offDates) !!},
    		{{-- minDate: '{{ Carbon::today()->addDays(2)->toDateString() }}', --}}
    		minDate: '{{ $calendarStartDate }}',
    		@if($calendarEndDate)
    		maxDate: '{{ $calendarEndDate }}',
    		@endif
	        // disabledDates: [
	        //     moment("6/25/2015"),
	        //     new Date(2015, 5 - 1, 2),
	        //     "5/3/2015 00:53",
	        //     "5/27/2015 00:53"
	        // ],
	        daysOfWeekDisabled: {!! json_encode($disabledCalendarDays) !!}

	    }).on("dp.change", function(e){
	    	$('#product-option-id').val("");
	    	$('#language-id-field').val(0).change();
	    	//$('#no-adult').trigger("change");
	    	loadProductLanguages();
	    });
	});

	function loadProductOption(){
        var travelDate = $("#travel-date-field").val();
        var languageId = $("#language-id-field").val();
        loadSelectData("#product-option-id","products/options/product",{ product_id : '{{$product->id}}' , language_id : languageId  , travel_date : travelDate }, false);
        
    }

    function loadProductLanguages(){
        var travelDate = $("#travel-date-field").val();
        loadSelectData2("#language-id-field","products/options/language",{ product_id : '{{$product->id}}', travel_date : travelDate });
    }


	$(".booking-form").on("change","#language-id-field",function(){
        loadProductOption();
	});

	$(".booking-form").on("change","#product-option-id", function() {
        var prodoptId = $(this).val();
		$.get( "/services/products/options/childprice", {product_option_id : prodoptId}).done(function(data){
            var readonly = (data === "true");
             if(readonly){
                $("#no-children").val(0);
                $("#no-children").trigger("change");
            }
            $("#no-children").prop('disabled', readonly);

            if(readonly)
            {
            	$('#no-children-container').hide(); 
            }
            else
            {
                $('#no-children-container').show();
                $.get( "/services/products/options/childAge", {product_option_id : prodoptId}).done(function(data){
                    var obj = $.parseJSON(data);
                    var str = "Age "+obj.childAge_from+" - "+obj.childAgeTo ;                   
                    $('span#child_rate').html(str)
                });
                    
            }
            
		});
        
    });

	function computeTourPrice(){

        var productOptionId = $("#product-option-id").val();
        var adultNo = $("#no-adult").val();
        var childrenNo = $("#no-children").val();
        var promoId = ''

        if( productOptionId < 1 ) {
        	$("#tour-price").text(0 + ' €');
        	return;
        }

        $.get( "/services/bookings/compute/tourprice", { product_option_id : productOptionId , adult_no : adultNo, child_no : childrenNo , promo_id : promoId}).done(function( data ) {
            $("#tour-price").text(data + ' €');
            
        });
    }


    $('#no-adult, #no-children, #language-id-field, #product-option-id').change(function(){
        var productOptionId = $("#product-option-id").val();
        $.get( "/services/products/options/AdultAge", {product_option_id : productOptionId}).done(function(data){
            var obj = $.parseJSON(data);
            console.log(obj)
            var str = "Age "+obj.adult_age_from+" - "+obj.adult_age_to;
            $('span#adult_rate').html(str)
        });
    	computeTourPrice();
    });

    function submitBookingForm( bookingForm )
    {
    	$.post(
    		bookingForm.attr('action'), 
    		bookingForm.serialize(),
    		function(response)
    		{
    			if( response === 'Success' )
    			{
    				document.location.href = "/shopping-cart";
    			}
    			else
    			{
    				$('#booking-form-errors').html( response );
    			}
    		});
    }


    $("#booking-form").submit(function(e){

        e.preventDefault();

        $('#booking-form-errors').html('');

        var bookingForm = $(this);
        var dateValue = $("#travel-date-field").val();
        var productOptionId = $("#product-option-id").val();
        var totalPerson = (parseInt($("#no-adult").val()) || 0) + (parseInt($("#no-children").val()) || 0);
        var language = $("#language-id-field").val();
        var referenceNo = null;
        var bookingForm = $("#booking-form");
        var id = bookingForm.data("id");

        params = { date: dateValue, product_option_id: productOptionId , total : totalPerson, reference_no : referenceNo , language : language, id : id};
        

        if(productOptionId && dateValue){
            $.get( "/services/bookings/validate-date", params).done(function(data){
                data = $.parseJSON(data);
                if(data.wcount>0){
                    var warning = $("#bookings-warning").html();
                    var template = Handlebars.compile(warning);
                    var confirmText = template({ errors : data.w});
                    swal({
                            title: "Choose another date.",
                            html: confirmText,
                            type: "error",
                            showCancelButton: false,
                            confirmButtonColor: "#d9534f",
                            confirmButtonText: "Ok",
                            //cancelButtonText: "Cancel",
                            closeOnConfirm: true,   closeOnCancel: true },
                        function(isConfirm){
                            // do nothing. let the user change travelDate.
                            setTimeout(function(){
                            	$('#booking-date .icon-calender').click();
                            }, 200);
                        }
                    );
                } else {
                    submitBookingForm( bookingForm );
                }
            });
        } else {
            submitBookingForm( bookingForm );
        }
    });


	$(document).ready(function()
	{
		// add video thumbnail
		$('a.g-video').each(function(index, El){
			embedStr = $(El).find('.embed-code').val();
			var altText = $(El).find('.embed-code').attr('alt');
			
			// first fetch thumbnailPath
			var thumbnailPath = '';
			if( embedStr.indexOf('vimeo') > 0 ) // check for vimeo video
			{
                            //Add video icon for vimeo on video thumb image
                            $(this).find('i.fa').addClass('fa-play').css({'position': 'absolute','top': '33px','left': '60px'});
                            var match = embedStr.match(/player\.vimeo\.com\/video\/([0-9]*)/);
                            videoId = match[1];	
                            $.getJSON('http://www.vimeo.com/api/v2/video/' + videoId + '.json?callback=?', {format: "json"}, function(data) {
                                thumbnailPath = data[0].thumbnail_large;
                            });
			}
			else // youtube video
			{
                            //Add video icon for youtube on video thumb image
                            $(this).find('i.fa').addClass('fa-play').css({'position': 'absolute','top': '33px','left': '60px'});
                            var match = embedStr.match(/youtube\.com\/embed\/(.*)[\?,\"]/);
                            videoId = match[1];	

                            thumbnailPath = 'http://img.youtube.com/vi/'+ videoId +'/0.jpg';

			}
						
		});

		// add click event to video thumbnails
		$('a.g-video').click(function(e){

			e.preventDefault();

			$('#video-player').html( $(this).find('.embed-code').val() );

		});

		// add click event to image thumbnails
		$('a.g-image').click(function(e){

			e.preventDefault();
			fullsizeImgPath = $(this).find('img').data('fullsize');

			imageStr = '<img src="'+ fullsizeImgPath +'" style="width:100%;" />';
			$('#video-player').html( imageStr );

		});

		// load first video if any
		// firstVideoLink = $('a.g-video:first');
		// if( firstVideoLink )
		// {
		// 	$('#video-player').html( $( firstVideoLink ).find('.embed-code').val() );
		// }

		// load first image if any
		firstItemLink = $('a.g-item:first');
		if( firstItemLink )
		{
			if( $(firstItemLink).hasClass('g-image') )
			{
				fullsizeImgPath = $(firstItemLink).find('img').data('fullsize');

				imageStr = '<img src="'+ fullsizeImgPath +'" style="width:100%;" />';
				$('#video-player').html( imageStr );
			}

			if( $(firstItemLink).hasClass('g-video') )
			{
				$('#video-player').html( $( firstItemLink ).find('.embed-code').val() );
			}
		}
	});

	function addThumbnail( El, thumbnailPath, altText )
	{
		imgStr = '<img src="'+ thumbnailPath +'" alt="'+ altText +'" style="max-width:168px; max-height:118px;">';
		$(El).find('img').remove();
		$(El).append( imgStr );
	}

</script>
@endsection
