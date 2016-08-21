<section class="two-col white green-bg">
	<div class="column img-holder">
		<div class="photo">
			<span class="img">
				<?php
					$image = $product->getImage(3);
					$imageUrl = $product->getImageUrl($image, 'neutral', url("/assets/images/app/img05.jpg"));
				?>
				<img src="{{ $imageUrl }}" alt="{{ $image->alt_text or "" }}" width="242" height="217">
			</span>
		</div>
	</div>
	<div class="column description">
		<div class="heading-wrap">
			<h2 class="line-bar"><a href='{{ $product->getUrl() }}'>{{ $product->name }}</a></h2>
			<div class="rating-box">
				<ul class="ratings list-unstyled list-inline">
					<?php $stars = (int) $product->averageRating ?>
					@for ($i = 0; $i < $stars; $i++)
						<li><span class="icon-star"></span></li>
					@endfor
					<li style="visibility:hidden"><span class="icon-star"></span></li>
				</ul>
			</div>
		</div>
		<div class="detail-box small-detail-box">
			<div class="price-holder">
				<span class="price">{{ $product->default_price }}€</span>
			</div>
			<div class="btn-holder">
				<a href='{{ $product->getUrl() }}' class="btn btn-success">Discover</a>
			</div>
		</div>
	</div>
</section>