@extends('layouts.master')

@section('content')
			<div class="banner">
				<ul class="random-images">
					<li>
						<div class="bg-stretch">
							<img class="fadeIn" src="/assets/images/app/img15.jpg" alt="image description" width="2200" height="940">
						</div>
					</li>
					<li>
						<div class="bg-stretch">
							<img class="fadeIn" src="/assets/images/app/img42.jpg" alt="image description" width="2198" height="940">
						</div>
					</li>
					<li>
						<div class="bg-stretch">
							<img class="fadeIn" src="/assets/images/app/img40.jpg" alt="image description" width="2198" height="940">
						</div>
					</li>
				</ul>
				<div class="container">
					<div class="row">
						<div class="col-md-5 col-md-offset-7 col-sm-7 col-sm-offset-5">
							<div class="welcome-block add">
								<div class="heading-wrap">
									<div class="row">
										<div class="col-md-6 col-sm-7">
											<strong class="title line-bar">Welcome to <span>Rome</span></strong>
										</div>
										<div class="col-md-6 col-sm-5 text-right">
											<div class="logo-wrap">
												<a href="#"><img src="/assets/images/app/trip-advisor.png" alt="2014 travellers choice tripadvisior" width="72" height="67"></a>
											</div>
										</div>
									</div>
								</div>
								 <p>Explore the beauties of Rome from aboard your very own modern “chariot”: the SegwayPT. Sightseeing has never been easier, more fun, or greener! All Rome by Segway tours are proudly powered by EcoArt Travel and have been consistently rated the best of the best with a perfect 5 star rating on Trip Advisor!</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="package-block pull-top">
				<div class="container">
					<form id="filter-form" class="form-inline destination-form" action="">
						<input type="hidden" id="sCategories" name="sCategories" value="{{$sCategories}}" />
						<input type="hidden" id="sortBy" name="sortBy" value="{{$sortBy}}" />
						<input type="hidden" id="sortOrder" name="sortOrder" value="{{$sortOrder}}" />
						
						<label for="departure_city_id">Where are you going?</label>
						<div class="form-group">
							 <select id="departure_city_id" name="sCity" class="form-control hidden">
								<option value="1">Rome</option>
							</select>
							<span class="form-control">Rome</span>
						</div>
						<div class="form-group">
							<div class="input-group date" id="arrival-date">
								<input type="text" class="form-control" placeholder="Arrival" data-date-format="DD/MM/YYYY" name="sArrivalDate" value="{{$sArrivalDate}}" />
								<span class="input-group-addon">
									<span class="icon-calender"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group date" id="departure-date">
								<input type="text" class="form-control" placeholder="Depature" data-date-format="DD/MM/YYYY" name="sDepartureDate" value="{{$sDepartureDate}}"  />
								<span class="input-group-addon">
									<span class="icon-calender"></span>
								</span>
							</div>
						</div>
						<button type="submit" class="btn btn-success">Search<span class="icon-arrow"></span></button>
					</form>
					<nav class="package-type text-center">
						<ul class="list-unstyled list-inline">
							<li><a href="#" data-id="all" class="s-categories btn btn-default">All Tours &amp; Activities</a></li>
							@foreach( $categories as $category )
							<li class="r-categories-li"><a href="#" data-id="{{ $category->id }}" class="r-categories s-categories btn btn-default">{{ $category->name }}</a></li>
							@endforeach
						</ul>
					</nav>
					<a name="sortingMenu" href="#"></a>
					<div class="sorting-block text-right">
						<span class="title">Sort by:</span>
						<ul class="list-inline list-unstyled">
							<li><a name="ratingHighToLow" href="#" data-by="rating" data-order="DESC" class="s-sort {{ Input::get('sortBy') == 'rating' ? 'active' : '' }}">Rating</a></li>
							<li><a name="priceLowToHigh" href="#" data-by="price" data-order="ASC" class="s-sort {{ (Input::get('sortOrder') == 'ASC'  and Input::get('sortBy') == 'price') ? 'active' : '' }}">Price Low to High</a></li>
							<li><a name="priceHighToLow" href="#" data-by="price" data-order="DESC" class="s-sort {{ (Input::get('sortOrder') == 'DESC' and Input::get('sortBy') == 'price') ? 'active' : '' }}">Price High to Low</a></li>
						</ul>
					</div>
					<div class="product-box">
						<div class="row">
							@if( count($products) == 0 )
							<div class="alert alert-warning" role="alert">
								<strong>Sorry!</strong> We have found nothing for you. Please change your filters to expand your search results.
							</div>
							@endif

							@foreach($products as $product)
							<div class="col-sm-4">
								{{-- <article class="thumbnail hot-offer offer-ribbon large"> --}}
								<article class="thumbnail">
									<div class="img-holder">
										@if( $product->getImage( Config::get('constants.PRODUCT_LIST_PAGE_PRODUCT_IMAGE') ) )
										<img alt="{{ $product->getImage( Config::get('constants.PRODUCT_LIST_PAGE_PRODUCT_IMAGE') )->alt_text }}" src="/images/{{ $product->getImage( Config::get('constants.PRODUCT_LIST_PAGE_PRODUCT_IMAGE') )->hash }}/neutral" width="308" />
										@endif
									</div>
									<div class="caption arrow-up">
										<h2><a href="{{ "/".$locale."/".$product->city->languageDetail->slug."/".$product->languageDetail->url }}">{{ $product->languageDetail->name }}</a></h2>
										{!! HTML::decode(str_ireplace('<ul>', '<ul class="list-unstyled detail-list">', $product->languageDetail->minidescription)) !!}
										<div class="row">
											<div class="col-xs-6">
												<div class="time"><span class="icon-clock"></span> {!! HTML::decode($product->languageDetail->duration) !!}</div>
												<ul class="ratings purple list-unstyled list-inline">
													@for($i=1; $i<=$product->averageRating; $i++)
													<li><span class="icon-star"></span></li>
													@endfor
												</ul>
												<span class="review">{{ $product->reviewsCount }} Reviews</span>
											</div>
											<div class="col-xs-6 text-right">
												{{-- <div class="price-holder">
													<span class="old-price">65.00€</span>
													<span class="offer-price">40.00€</span>
												</div>
												<a class="btn btn-info" href="#">Discover</a>
												 --}}
												<span class="price">{{ number_format( $product->default_price, 2 ) }}€</span>
												<a class="btn btn-success" href="{{ "/".$locale."/".$product->city->languageDetail->slug."/".$product->languageDetail->url }}">Discover</a>
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
	$.urlParam = function(name){
	    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	    if (results==null){
	       return null;
	    }
	    else{
	       return results[1] || 0;
	    }
	}
    $(function () {
    	$(window).trigger("hashchange");
        $('#arrival-date').datetimepicker({
        	locale: 'en',
	        format: 'DD/MM/YYYY',
    		extraFormats: [ 'DD/MM/YY' ]
        });
        $('#departure-date').datetimepicker({
        	locale: 'en',
	        format: 'DD/MM/YYYY',
    		extraFormats: [ 'DD/MM/YY' ]
        });
        $("#arrival-date").on("dp.change", function (e) {
            $('#departure-date').data("DateTimePicker").minDate(e.date);
        });
        $("#departure-date").on("dp.change", function (e) {
            $('#arrival-date').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>

<script type="text/javascript">

	// on click of sort-links set the hidden field value in form
	$(function() {
		$('.s-sort').click(function(e) {
			e.preventDefault();
			$('#sortBy').val( $(this).data('by') );
			$('#sortOrder').val( $(this).data('order') );
			var $form = $("#filter-form");
			var pageUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
			var formUrl = pageUrl + "?" + $form.serialize();
			formUrl += "#sortingMenu";
			$form.attr({
				"action" : formUrl,
				"method" : "GET"
			});
			$form.submit();
		});
	});

	// on click of s-categories set the hidden field value in form
	$(function() {
		$('.s-categories').click(function(e) {
			e.preventDefault();

			// first toggle class
			$(this).parent().toggleClass('active');

			var categories =[];

			if( $('#sCategories').val() != "" )
			{
				categories = $('#sCategories').val().split(',');
			}
			else
			{
				categories = [];
			}
			
			if( $(this).parent().hasClass('active') )
			{
				// add categoryID
				if(categories.indexOf('all') > -1 && $(this).data('id') != "all")
				{
					categories = [];
					categories.push( String($(this).data('id')) );
				}
				else
				{
					categories.push( String($(this).data('id')) );
				}
				
			}
			else
			{
				// remove categoryID
				idx = categories.indexOf( String($(this).data('id')) );

				if (idx > -1)
				{
				    categories.splice(idx, 1);
				}
			}
			
			$('#sCategories').val( categories );

			highlightCategories();

			$('#filter-form').submit();

		});

		highlightCategories();
	});

	function highlightCategories( )
	{
		var categories = [];

		if( $('#sCategories').val() != "" )
		{
			categories = $('#sCategories').val().split(',');
		}
		else
		{
			categories = [];
		}
		
		var allCategoriesChecked = $('.r-categories-li.active').length == $('.r-categories').length;

		if( categories.length == 0 || categories.indexOf('all') > -1 || allCategoriesChecked)
		{
			categories = ['all'];
		}

		$('.s-categories').parent().removeClass('active');

		if( categories.indexOf('all') > -1 )
		{
			$('.s-categories:first').parent().addClass('active');
		}
		else
		{
			$(categories).each(function(index, catId){
				$('.s-categories[data-id="'+catId+'"]').parent().addClass('active');
			});	
		}

		$('#sCategories').val( categories );
		
	}
</script>
@endsection
