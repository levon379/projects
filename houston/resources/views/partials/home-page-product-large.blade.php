<article class="offer-block">
	<div class="image-holder">
		<span class="img">
			<?php
				$image = $product->getImage(1);
				$imageUrl = $product->getImageUrl($image, 'neutral', url("/assets/images/app/img03.jpg"));
			?>
			<img src="{{ $imageUrl }}" alt="{{ $image->alt_text or "image" }}" width="600" height="475">
		</span>
	</div>
	<div class="description">
		<header class="heading-wrap">
			<h2 class="line-bar"><a href='{{ $product->getUrl() }}'>{{ $product->name }}</a></h2>
			<div class="rating-box">
				<ul class="ratings purple list-unstyled list-inline">
					<?php $stars = (int) $product->averageRating ?>
					@for ($i = 0; $i < $stars; $i++)
						<li><span class="icon-star"></span></li>
					@endfor
					<li style="visibility:hidden"><span class="icon-star"></span></li>
				</ul>
			</div>
		</header>
		<p>{!! (count($product->language_details)) ? $product->language_details->first()->minidescription : "" !!}</p>
		<footer class="detail-box">
			<div class="price-holder">
				{{-- <span class="old-price">65.00€</span>--}}
				<span class="offer-price">{{ $product->default_price }}€</span>
			</div>
			<div class="btn-holder">
				<a href='{{ $product->getUrl() }}' class="btn btn-success">Discover</a>
			</div>
		</footer>
	</div>
</article>