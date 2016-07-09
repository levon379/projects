@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/post-to-buy-details" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/bid-details.css" />
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
            
<h1>Post To Buy - Details</h1>

<form action="post-to-buy" method="post">

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
  <input type="hidden" value="{{{ $productType }}}" name="productType">
  <input type="hidden" value="{{{ $product }}}" name="product" class="productDetails">
  <input type="hidden" value="{{{ $placeOfOrigin }}}" name="placeOfOrigin">
  <input type="hidden" value="{{{ $variety }}}" name="variety" class="productDetails">
  <div class="form-group row">
    <button id="edit-product-info" class="btn btn-lg btn-primary"><i class="fa fa-angle-double-left fa-white"></i> Edit Product Information</button>
  </div>
</form>

<form action="post-to-buy-preview" method="post" id="post-to-buy-detail-form">
  <div class="panel panel-default">
    <div class="panel-heading">
      Product Quantity &amp; Pricing
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label"><abbr title="Quantity">Qty</abbr><span class="req">*</span></label>
          <div class="col-sm-3">
            <input type="number" min="0" class="form-control input-lg" name="qty" id="qty" value="{{{ $details->qty }}}" placeholder="0">
          </div>
        </div>
        <div class="form-group">
          <label for="offeringPrice" class="col-sm-3 control-label">Offering Price<span class="req">*</span></label>
          <div class="col-sm-3 input-group-container">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-usd" style="font-size: 18px;"></i></span>
              <input type="number" min="0" step="any" class="form-control input-lg" name="offeringPrice" id="offeringPrice" value="{{{ $details->offeringPrice }}}" placeholder="0.00">
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="row">
          <label for="minQty" class="col-sm-3 control-label">Min <abbr title="Quantity">Qty</abbr><span class="req">*</span></label>
          <div class="col-sm-3">
            <input type="number" min="0" class="form-control input-lg" name="minQty" id="minQty" value="{{{ $details->minQty }}}" placeholder="0">
          </div>
          <!-- <label for="delete" class="col-sm-3 control-label">Delete</label>
          <div class="col-sm-3">
            <select name="delete" id="delete" class="form-control input-lg">
              <option @if($details->delete == "no") selected="selected" @endif value="no">No</option>
              <option @if($details->delete == "yes") selected="selected" @endif value="yes">Yes</option>
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
      <div class="row row-pcs-wp" @if($details->bulk == "yes") style="display:none" @endif >
        <div class="form-group">
          <label for="pcsCount" class="control-label col-sm-3">PCs or PKGs / Carton<span class="req">*</span></label>
          <div class="col-sm-3">
            <input type="number" min="0" name="pcsCount" id="pcsCount" class="form-control input-lg" value="{{{ $details->pcsCount }}}" placeholder="0" @if($details->bulk == "yes") readonly @endif>
          </div>
        </div>
        <div class="form-group">
          <div class="weight-package">
            <label for="weightPackage" class="control-label col-sm-2">Weight / Package<span class="req">*</span></label>
            <div class="col-sm-2">
              <input type="number" min="0" id="weightPackage" class="form-control input-lg" name="weightPackage" value="{{{ $details->weightPackage }}}" placeholder="0" @if($details->bulk == "yes") readonly @endif >
            </div>
            <div class="col-sm-2">
              <select name="weightPackageType" id="weightPackageType" class="form-control input-lg" @if($details->bulk == "yes") disabled @endif>
                <option @if($details->weightPackageType == "oz") selected="selected" @endif value="oz">oz</option>
                <option @if($details->weightPackageType == "g") selected="selected" @endif value="g">g</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <label class="col-sm-3">Bulk<span class="req">*</span></label>
          <div class="radio col-sm-3">
            <label>
              <input type="radio" name="bulk" id="bulkNo" value="no" @if($details->bulk == "no") checked="checked" @else checked="checked" @endif />
              No
            </label>
            <label>
              <input type="radio" name="bulk" id="bulkYes" value="yes" @if($details->bulk == "yes") checked="checked" @endif />
              Yes
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="weightCarton" class="col-sm-2 control-label">Weight / Carton<span class="req">*</span></label>
          <div class="col-sm-2">
            <input type="number" min="0" step="any" name="weightCarton" id="weightCarton" class="form-control input-lg" value="{{{ $weightCarton }}}" @if($details->bulk == "no" || empty($details->bulk)) readonly @endif>
          </div>
          <div class="col-sm-2">
            <select name="weightCartonType" id="weightCartonType" class="form-control input-lg" @if($details->bulk == "no" || empty($details->bulk)) disabled @endif>
              <option @if($weightCartonType == "lb") selected="selected" @endif value="lb">lb</option>
              <option @if($weightCartonType == "kb") selected="selected" @endif value="kb">kb</option>
            </select>
            <!-- <input type="text" name="weightCartonType" id="weightCartonType" class="form-control input-lg" value="{{{ $weightCartonType }}}" readonly> -->
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <label for="maturity" class="col-sm-3 control-label">Maturity<span class="req">*</span></label>
          <div class="col-sm-3">
            <select name="maturity" id="maturity" class="form-control input-lg">
              <option value="" selected disabled>Maturity</option>
                @foreach ($maturityOptions as $mKey => $mVal)
                  <option @if($mVal == $details->maturity) selected="selected" @endif value="{{{ $mVal }}}">
                    {{{ $mVal }}}
                  </option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="colour" class="col-sm-2 control-label">Colour<span class="req">*</span></label>
          <div class="col-sm-4">
            <select name="colour" id="colour" class="form-control input-lg">
              <option value="" selected disabled>Colour</option>
                @foreach ($colorsOptions as $colourKey => $colourValue)
                  <option @if($colourValue == $details->colour) selected="selected" @endif value="{{{ $colourValue }}}">
                    {{{ $colourValue }}}
                  </option>
                @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <label for="quality" class="col-sm-3 control-label">Quality<span class="req">*</span></label>
          <div class="col-sm-3">
            <!-- <input type="text" name="quality" id="quality" class="form-control input-lg" value="{{{ $details->quality }}}" placeholder="Quality"> -->
            <select name="quality" id="quality" class="form-control input-lg">
              <option value="" selected disabled>Quality</option>
                @foreach($qualityOptions as $qKey => $qVal)
                  <option @if($qVal == $details->quality) selected="selected" @endif value="{{{ $qVal }}}">{{{ $qVal }}}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="available" class="col-sm-2 control-label">Available<span class="req">*</span></label>
          <div class="col-sm-4">
            <select name="available" id="available" class="form-control input-lg">
              <option value="" selected disabled>Available</option>
                @foreach ($availableOptions as $availKey => $availValue)
                  <option @if($availValue == $details->available) selected="selected" @endif value="{{{ $availValue }}}">
                    {{{ $availValue }}}
                  </option>
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
            <textarea name="description" id="description" cols="30" rows="5" class="form-control input-lg">
              {{{ $details->description }}}
            </textarea>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="panel panel-default">
    <div class="panel-heading">
      Display, Receiving Address
    </div>
    <div class="panel-body">
      <div class="form-group">
        <div class="row">
          <label for="display" class="col-sm-3"><abbr title="Would you like to display this post now?">Display</abbr><span class="req">*</span></label>
          <div class="radio col-sm-3">
            <label>
              <input type="radio" name="display" id="displayYes" value="yes" @if($details->display == "yes") checked="checked" @else checked="checked") @endif>
              Yes
            </label>
            <label>
              <input type="radio" name="display" id="displayNo" value="no" @if($details->display == "no") checked="checked" @endif>
              No
            </label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="row">
          <label for="receivingAddress" class="col-sm-3 control-label">Receiving Address<span class="req">*</span></label>
          <div class="col-sm-5">
            <select name="receivingAddress" id="receivingAddress" class="form-control input-lg">
              <option value="" selected disabled>Receiving Address</option>
                @foreach ($receivingAddressOptions as $receiveKey => $receiveVal)
                  <option @if($receiveVal == $details->receivingAddress) selected="selected" @endif value="{{{ $receiveVal }}}">
                    {{{ $receiveVal }}}
                  </option>
                @endforeach
              <option @if($details->receivingAddress == "other") selected="selected" @endif value="other">Add New Receiving Address...</option>
            </select>
          </div>
        </div>
      </div>
      <div class="other-receiving-address" style="@if($details->receivingAddress == 'other') display:block @endif ">
        <div class="row">
          <div class="form-group">
            <label for="otherReceivingAddress" class="control-label col-sm-3">Street Address<span class="req">*</span></label>
            <div class="col-sm-9">
              <input type="text" name="otherReceivingAddress" id="otherReceivingAddress" class="form-control input-lg other-receiving-address-input" placeholder="Street Address" value="{{{ $details->otherReceivingAddress }}}">
            </div>
          </div>
        </div>
        <div class="row other-receiving-middle-row">
          <label for="city" class="control-label col-sm-3">City<span class="req">*</span></label>
          <div class="col-sm-3">
            <input type="text" class="form-control input-lg other-receiving-address-input" name="city" value="{{{ $details->city }}}" id="city" placeholder="City">
          </div>
          <label for="province" class="control-label col-sm-2">Province<span class="req">*</span></label>
          <div class="col-sm-4">
            <input type="text" class="form-control input-lg other-receiving-address-input" name="province" value="{{{ $details->province }}}" id="province" placeholder="Province">
          </div>
        </div>
        <div class="row">
          <label for="postal" class="control-label col-sm-3">Postal Code<span class="req">*</span></label>
          <div class="col-sm-3">
            <input type="text" class="form-control input-lg other-receiving-address-input" name="postal" value="{{{ $details->postal }}}" id="postal" placeholder="Postal Code">
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
