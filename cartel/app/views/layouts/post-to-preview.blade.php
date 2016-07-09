@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/{{{ $canonical }}}" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="{{{ $post_to_preview_css }}}" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
{{{ $title }}}
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<img src="{{{ $header_icon }}}" height="126" width="126" 
      alt="{{{ $header_alt }}}" class="{{{ $header_class }}}" />

<h1>{{{ $header_h1 }}}</h1>

  <div class="product-preview">

    <div class="row">
      <div class="col-md-12">
        <h1 class="product-type">{{{ $prod_details->productType_name }}}</h1>
      </div>
    </div>

      <div class="panel panel-default">
        <div class="row">
          <div class="panel-body">
            <div class="col-md-4">
              @if($prod_details->place_of_origin_image != '')
                <img src="{{ URL::asset('images/labels/'.$prod_details->place_of_origin_image) }}" height="150" width="300" alt="{{{ $prod_details->place_of_origin_name }}}">
              @else
                <img src="{{ URL::asset('images/labels/no_image.png') }}" class="img-label" alt="No Image" width="100" />
              @endif
            </div>
            <div class="col-md-4" style="margin-top: 1.5em;">
              <h2 class="product">{{{ $prod_details->product_name }}}</h2>
              <h3 class="product-variety">{{{ $prod_details->variety_name }}}</h3>
            </div>
            <div class="col-md-4" style="margin-top: .5em;">
              <table class="table">
                <tbody>
                  <tr>
                    <td><abbr title="Quantity">Qty</abbr></td>
                    <td>{{{ $prod_details->qty }}}</td>
                  </tr>
                  <tr>
                    <td>Min <abbr title="Quantity">Qty</abbr></td>
                    <td>{{{ $prod_details->minqty }}}</td>
                  </tr>
                  <tr>
                    <td>Offering Price</td>
                    <td>${{{ $prod_details->price }}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading">Product Details</div>
      <div class="panel-body">
        <table class="table table-product-details">
          <tbody>
            @if($prod_details->isbulk == 0)
              <tr>
                <td># of Pieces</td>
                <td> @if(!$prod_details->isbulk) {{{ $prod_details->carton_pieces }}} @else N/A @endif </td>
                <td>Weight / {{{ $prod_details->carton_package_name }}}</td>
                <td>@if(!$prod_details->isbulk) {{{ $prod_details->carton_weight." " . $prod_details->carton_weight_type_name }}} @else N/A @endif</td>
              </tr>
            @endif
            <tr>
              <td>Bulk</td>
              <td>@if(!($prod_details->isbulk)) No @else Yes @endif</td>
              
              <td>Weight / {{{ $prod_details->bulk_package_name }}}</td>
              <td>{{{ $prod_details->bulk_weight . " " . $prod_details->bulk_weight_type_name }}}</td>
            </tr>
            <tr>
              <td>Maturity</td>
              <td>{{{ $prod_details->maturity_name }}}</td>
              <td>Colour</td>
              <td>{{{ $prod_details->colour_name }}}</td>
            </tr>
            <tr>
              <td>Quality</td>
              <td>{{{ $prod_details->quality_name }}}</td>
              <td>Availability</td>
              <td>{{{ $prod_details->availability_date }}} between {{{ $prod_details->availability_start }}} and {{{ $prod_details->availability_end }}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    @if($prod_details->description)
      <div class="panel panel-default">
        <div class="panel-heading">Description / Comments</div>
        <div class="panel-body description">
          {{{ $prod_details->description }}}
        </div>
      </div>
    @endif

    <div class="panel panel-default">
      <div class="panel-heading">{{{ $address_header }}}</div>
        <div class="panel-body address">
          <address>
            {{{ $prod_details->address->address }}}<br>
            @if($prod_details->address->address2<>'')
              {{{ $prod_details->address->address2 }}}<br>
            @endif
            {{{ $prod_details->address->city . ", " . strtoupper(substr($prod_details->address->province_code, 0, 2)) }}}<br>
            {{{ $prod_details->address->country_name }}}<BR>
            {{{ $prod_details->address->postal_code }}}
          </address>
      </div>
    </div><!-- panel panel-default -->
    
  </div> <!-- product-preview -->

  <div class="panel panel-default" style="border-bottom-right-radius: 60px;">
    <div class="panel-heading">Create Post</div>
    <div class="panel-body">
    
      <!-- Password Verification removed -->
      <!-- <div class="row"> -->
        <!-- <div class="form-group"> -->
          <!-- <label for="password" class="col-sm-3 control-label">Verify Password<span class="req">*</span></label> -->
          <!-- <div class="col-sm-4"> -->
            <!-- <input type="password" id="password" name="password" class="form-control input-lg" placeholder="Your Password"> -->
          <!-- </div> -->
        <!-- </div> -->
      <!-- </div> -->
      
      <div class="form-group">
        <div class="row">
          <div class="col-sm-4">
            <a href="{{{ $submit_route }}}" id="create-post" class="btn btn-primary btn-lg">Create Post</a>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="form-group">
    <a href="{{{ $edit_route }}}" id="edit-product-details" class="btn btn-primary btn-lg"><i class="fa fa-angle-double-left fa-white"></i> Edit Product Details</a>
  </div>


@stop {{-- content --}}


{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
	<script src="js/post-to-buy-preview.js"></script>
@stop
