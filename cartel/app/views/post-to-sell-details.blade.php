@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/post-to-sell-details" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/post-to-buy-details.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Post To Buy - Details | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')
            
<h1>Post To Sell - Details</h1>

<!-- <div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;">
    33%
  </div>
</div> -->

<p>{{{ $msg }}}</p>

<form action="post-to-sell-preview" method="post">

  <div class="panel panel-default">
    <div class="panel-heading">Product Information</div>
    <table class="table">
      <tr>
        <td>Type of Product</td>
        <td>{{{ $productType }}}</td>
      </tr>
      <tr>
        <td>Place of Origin</td>
        <td>{{{ $placeOfOrigin }}}</td>
      </tr>
      <tr>
        <td>Product</td>
        <td>{{{ $product }}}</td>
      </tr>
      <tr>
        <td>Variety</td>
        <td>{{{ $variety }}}</td>
      </tr>
    </table>
  </div>

  <div class="form-group row">
    <button id="edit-product-info" class="btn btn-lg btn-primary"><i class="fa fa-angle-double-left fa-white"></i> Edit Product Information</button>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      Product Quantity &amp; Pricing
    </div>
    <div class="panel-body">
      <div class="form-group">
        <div class="row">
          <label for="qty" class="col-sm-3 control-label"><abbr title="Quantity">Qty</abbr><span class="req">*</span></label>
          <div class="col-sm-3">
            <input type="number" class="form-control input-lg" name="qty" id="qty" value="{{{ $qty }}}" placeholder="0">
          </div>
          <label for="askingPrice" class="col-sm-3 control-label">Asking Price<span class="req">*</span></label>
          <div class="col-sm-3">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-usd" style="font-size: 18px;"></i></span>
              <input type="number" step="any" class="form-control input-lg" name="askingPrice" id="askingPrice" value="{{{ $askingPrice }}}" placeholder="0.00">
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="row">
          <label for="minQty" class="col-sm-3 control-label">Min <abbr title="Quantity">Qty</abbr><span class="req">*</span></label>
          <div class="col-sm-3">
            <input type="number" class="form-control input-lg" name="minQty" id="minQty" value="{{{ $minQty }}}" placeholder="0">
          </div>
          <!-- <label for="delete" class="col-sm-3 control-label">Delete</label>
          <div class="col-sm-3">
            <select name="delete" id="delete" class="form-control input-lg">
              <option @if($delete == "no") selected="selected" @endif value="no">No</option>
              <option @if($delete == "yes") selected="selected" @endif value="yes">Yes</option>
            </select>
          </div> -->
        </div>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      Product Details
    </div>
    <div class="panel-body">
      <input type="hidden" value="{{{ $productType }}}" name="productType">
      <input type="hidden" value="{{{ $product }}}" name="product" class="productDetails">
      <input type="hidden" value="{{{ $placeOfOrigin }}}" name="placeOfOrigin">
      <input type="hidden" value="{{{ $variety }}}" name="variety" class="productDetails">
      <div class="form-group">
        <div class="row">
          <label for="pcsCount" class="control-label col-sm-3">PCs or PKGs / Carton<span class="req">*</span></label>
          <div class="col-sm-3">
            <input type="number" min="0" name="pcsCount" id="pcsCount" class="form-control input-lg" value="{{{ $pcsCount }}}" placeholder="0" @if($bulk == "yes") readonly @endif>
          </div>
          <div class="weight-package">
            <label for="weightPackage" class="control-label col-sm-2">Weight / Package<span class="req">*</span></label>
            <div class="col-sm-2">
              <input type="number" min="0" id="weightPackage" class="form-control input-lg" name="weightPackage" value="{{{ $weightPackage }}}" placeholder="0" @if($bulk == "yes") readonly @endif>
            </div>
            <div class="col-sm-2">
              <select name="weightPackageType" id="weightPackageType" class="form-control input-lg" @if($bulk == "yes") disabled @endif>
                <option @if($weightPackageType == "oz") selected="selected" @endif value="oz">oz</option>
                <option @if($weightPackageType == "lbs") selected="selected" @endif value="lbs">lbs</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="row">
          <label class="col-sm-3">Bulk<span class="req">*</span></label>
          <div class="radio col-sm-3">
            <label>
              <input type="radio" name="bulk" id="bulkNo" value="no" @if($bulk == "no") checked="checked" @else checked="checked" @endif>
              No
            </label>
            <label>
              <input type="radio" name="bulk" id="bulkYes" value="yes" @if($bulk == "yes") checked="checked" @endif >
              Yes
            </label>
          </div>
          <label for="weightCarton" class="col-sm-2 control-label">Weight / Carton<span class="req">*</span></label>
          <div class="col-sm-2">
            <input type="number" min="0" step="any" name="weightCarton" id="weightCarton" class="form-control input-lg" value="{{{ $weightCarton }}}" @if($bulk == "no" || empty($bulk)) readonly @endif>
          </div>
          <div class="col-sm-2">
            <select name="weightCartonType" id="weightCartonType" class="form-control input-lg" @if($bulk == "no" || empty($bulk)) disabled @endif>
              <option @if($weightCartonType == "lb") selected="selected" @endif value="lb">lb</option>
              <option @if($weightCartonType == "kb") selected="selected" @endif value="kb">kb</option>
            </select>
            <!-- <input type="text" name="weightCartonType" id="weightCartonType" class="form-control input-lg" value="{{{ $weightCartonType }}}" readonly> -->
                </div>
        </div>
      </div>
      <div class="form-group">
        <div class="row">
          <label for="maturity" class="col-sm-3 control-label">Maturity<span class="req">*</span></label>
          <div class="col-sm-3">
            <select name="maturity" id="maturity" class="form-control input-lg">
              <option value="" selected disabled>Maturity</option>
                @foreach ($maturityOptions as $mKey => $mVal)
                <option @if($mVal == $maturity) selected="selected" value="{{{ $mVal }}}">{{{ $mVal }}}</option>
                @endforeach
            </select>
          </div>
          <label for="colour" class="col-sm-2 control-label">Colour<span class="req">*</span></label>
          <div class="col-sm-4">
            <select name="colour" id="colour" class="form-control input-lg">
              <option value="" selected disabled>Colour</option>
                @foreach ($colorsOptions as $colourKey => $colourValue)
                <option @if($colourValue == $colour) selected="selected" @endif value="{{{ $colourValue }}}">{{{ $colourValue }}}</option>
                @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="row">
          <label for="quality" class="col-sm-3 control-label">Quality<span class="req">*</span></label>
          <div class="col-sm-3">
            <!-- <input type="text" name="quality" id="quality" class="form-control input-lg" value="{{{ $quality }}}" placeholder="Quality"> -->
            <select name="quality" id="quality" class="form-control input-lg">
              <option value="" selected disabled>Quality</option>
                @foreach($qualityOptions as $qKey => $qVal)
                  <option @if($qVal == $quality) selected="selected" @endif value="{{{ $qVal }}}">{{{ $qVal }}}</option>
                @endforeach
            </select>
          </div>
          <label for="available" class="col-sm-2 control-label">Available<span class="req">*</span></label>
          <div class="col-sm-4">
            <select name="available" id="available" class="form-control input-lg">
              <option value="" selected disabled>Available</option>
                @foreach($availableOptions as $availKey => $availValue)
                  <option @if($availValue == $available) selected="selected" @endif value="{{{ $availValue }}}">{{{ $availValue }}}</option>
                @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="row">
          <label for="description" class="col-sm-3 control-label">
            Description/<br />Comments
          </label>
          <div class="col-sm-9">
            <textarea name="description" id="description" cols="30" rows="5" class="form-control input-lg">{{{ $description }}}</textarea>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="panel panel-default">
    <div class="panel-heading">
      Display, Shipping Address
    </div>
    <div class="panel-body">
      <div class="form-group">
        <div class="row">
          <label for="display" class="col-sm-3"><abbr title="Would you like to display this post now?">Display</abbr><span class="req">*</span></label>
          <div class="radio col-sm-3">
            <label>
              <input type="radio" name="display" id="displayYes" value="yes" @if($display == "yes") checked="checked" @else checked="checked" @endif>
              Yes
            </label>
            <label>
              <input type="radio" name="display" id="displayNo" value="no" @if($display == "no") checked="checked" @endif>
              No
            </label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="row">
          <label for="shippingAddress" class="col-sm-3 control-label">Shipping Address<span class="req">*</span></label>
          <div class="col-sm-5">
            <select name="shippingAddress" id="shippingAddress" class="form-control input-lg">
              <option value="" selected disabled>Shipping Address</option>
                @foreach ($shippingAddressOptions as $shipKey => $shipVal)
                  <option @if($shipVal == $shippingAddress) selected="selected" @endif  value="{{{ $shipVal }}}">{{{ $shipVal }}}</option>
                @endforeach
              <option @if($shippingAddress == "other") selected="selected" @endif value="other">Add New Shipping Address...</option>
            </select>
          </div>
        </div>
      </div>
      <div class="form-group other-shipping-address" style="@if($shippingAddress == 'other') display: block @endif">
        <div class="row">
          <label for="otherShippingAddress" class="control-label col-sm-3">Street Address<span class="req">*</span></label>
          <div class="col-sm-9">
            <input type="text" name="otherShippingAddress" id="otherShippingAddress" class="form-control input-lg other-shipping-address-input" placeholder="Street Address" value="{{{ $otherShippingAddress }}}">
          </div>
        </div>
        <div class="row other-shipping-middle-row">
          <label for="city" class="control-label col-sm-3">City<span class="req">*</span></label>
          <div class="col-sm-3">
            <input type="text" class="form-control input-lg other-shipping-address-input" name="city" value="{{{ $city }}}" id="city" placeholder="City">
          </div>
          <label for="province" class="control-label col-sm-2">Province<span class="req">*</span></label>
          <div class="col-sm-4">
            <input type="text" class="form-control input-lg other-shipping-address-input" name="province" value="{{{ $province }}}" id="province" placeholder="Province">
          </div>
        </div>
        <div class="row">
          <label for="postal" class="control-label col-sm-3">Postal Code<span class="req">*</span></label>
          <div class="col-sm-3">
            <input type="text" class="form-control input-lg other-shipping-address-input" name="postal" value="{{{ $postal }}}" id="postal" placeholder="Postal Code">
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="row">
          <div class="col-sm-offset-3 col-sm-4">
            <button id="preview-post" class="btn btn-primary btn-lg">Preview Post <i class="fa fa-angle-double-right fa-white"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

@stop {{-- content --}}

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
	<script src="js/post-to-buy-details-bv.js"></script>
	<script src="js/post-to-buy.js"></script>
@stop
