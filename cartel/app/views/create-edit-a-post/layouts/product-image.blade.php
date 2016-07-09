@if($bpVal->product_image_filename != '')
  <img src="{{ URL::asset('uplds/productimages/'.$bpVal->product_image_filename) }}" class="product-image" alt="{{{ str_replace(" ", "-", $bpVal->place_of_origin_name) }}}" width="100" />
@else
  <img src="{{ URL::asset('images/labels/no_image.png') }}" class="product-image" alt="No Image" width="100" />
@endif
