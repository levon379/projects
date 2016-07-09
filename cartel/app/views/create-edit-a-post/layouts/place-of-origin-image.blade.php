{{--  Place of origin image for all create-edit-a-post pages --}}
<div class="place-of-origin-image">
  @if($bpVal->place_of_origin_image != '')
    <img src="{{ URL::asset('images/labels/'.$bpVal->place_of_origin_image) }}" alt="{{{ str_replace(" ", "-", $bpVal->place_of_origin_name) }}}"  />
  @else
    <img src="{{ URL::asset('images/labels/no_image.png') }}" class="img-label" alt="No Image" />
  @endif
</div>
