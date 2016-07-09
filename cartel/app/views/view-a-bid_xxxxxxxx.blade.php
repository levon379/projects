@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/view-a-bid" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="{{ URL::asset('css/view-a-bid.css') }}" />
@show

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Bid Details | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')
            
            
{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
<h1>Bid Details</h1>

{{-- Product Type --}}
{{-- ----------------------------------------------------- --}}
<div class="row">
  <div class="col-md-12">
    <h1 class="product-type">
   Post to {{{ $product_details['post_type']   }}}
    </h1>
  </div>
</div>

{{-- Place of Origin Flash --}}
{{-- ----------------------------------------------------- --}}
<div class="panel panel-default">
  <div class="panel-body row">
    <div class="col-md-4">
      <img src="{{ URL::asset($bid_details['place_of_origin_image']) }}"
        height="150" width="300" alt="{{{ $product_details["place_of_origin_name"] }}}" />
        
    </div>

    {{-- Product name and variety --}}
    {{-- ----------------------------------------------------- --}}
    <div class="col-md-4" style="margin-top: 1.5em;">
      <h2 class="product">{{{ $product_details['product_name'] }}}      </h2>
      <h3 class="product-variety">{{{ $product_details['variety_name'] }}}</h3>
    </div>
    
    {{-- Qty, Min Qty, Asking Price --}}
    {{-- ----------------------------------------------------- --}}
    <div class="col-md-4" style="margin-top: .5em;">
      <table class="table">
        <tbody>
          <tr>
            <td><abbr title="Quantity">Qty</abbr></td>
            <td>{{{ $product_details['qty'] }}}</td>
          </tr>
          <tr>
            <td>Min <abbr title="Quantity">Qty</abbr></td>
            <td>{{{ $product_details["minqty"] }}}</td>
          </tr>
            <tr>
              <td>
				  @if($product_details['post_type'] == "buy")
					Your Offering Price
				  @elseif($product_details['post_type'] == "sell")
				  	Your Asking Price
				  @endif
				  </td>
              <td>{{{ $bid_details["price"] }}}</td>
            </tr>
         
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Product Details --}}
{{-- ----------------------------------------------------- --}}
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        Product Details
      </div>
      <div class="panel-body">
        <table class="table table-product-details">
          <tbody>
          
            <tr>
              {{-- PCs or Package Count ------------------------------  --}}              
              <td>PCs or Package Count</td>
              <td>
                  {{{ $product_details["carton_pieces"] }}}
              </td>
              
              {{-- Weight / Package ----------------------------------  --}}              
              <td>Weight / Package</td>
              <td>
                {{{ $product_details["carton_weight"] . " " .
                    $product_details["carton_weight_type_name"]. "/".
                    $product_details["carton_package_name"]
                    
                }}} 
              </td>
            </tr>
            
            <tr>
              {{--  Bulk ---------------------------------------------- --}}              
              <td>Bulk</td>
              <td>
                {{{ $product_details["bulk_weight"] . " " .
                    $product_details["bulk_weight_type_name"]. "/".
                    $product_details["bulk_package_name"]
                }}}
              </td>
              
              {{-- Weight/ Carton -------------------------------------- --}}              
              <td>Weight / Carton</td>
              <td>
                {{{--- $product_details["weightCarton"] . " " .
                    $product_details["weightCartonType"] ---}}}
              </td>
            </tr>
            
            <tr>
            
              {{-- Maturtiy ------------------------------------------- --}}              
              <td>Maturity</td>
              <td> {{{ $product_details["maturity_name"] }}} </td>
              
              {{-- Color----------------------------------------------k --}}              
              <td>Colour</td>
              <td>{{{ $product_details["colour_name"] }}}</td>
            </tr>
            
            <tr>
            
              {{-- Quality --}}              
              <td>Quality</td>
              <td>{{{ $product_details["quality_name"] }}}</td>
              
              {{-- Availability --}}              
              <td>Availability</td>
              <td>
                  {{{ $product_details["availability_date"] }}} 
                  between 
                  {{{ $product_details["availability_start"] }}} 
                  and 
                  {{{ $product_details["availability_end"] }}}
              </td>
            </tr>
            
          </tbody>
        </table>
      </div>
    </div>
      </div>
  <div class="col-md-6">
    <div class="panel panel-success">
      <div class="panel-heading">
        Offer      </div>
      <div class="panel-body">
                  <p>
                    Below is an OFFER to SELL you a product you posted to BUY.
                    Enter your password to ACCEPT or DECLINE this OFFER.
                  </p>
                <div class="row">
          <div class="col-md-12">
            <table class="table table-bid">
              <tr>
                <td>Bid Qty</td>
                <td>{{{ $bid_details["quality_name"] }}}</td>
              </tr>
              <tr>
                <td>Bid Price</td>
                <td>${{{ $bid_details["quality_name"] }}}</td>
              </tr>
            </table>
          </div>
        </div>
        <form action="crud?action=bid-details" method="post">
        <div class="form-group row">
          <label for="password" class="col-md-5 control-label">
            Verify Password<span class="req">*</span>
          </label>
          <div class="col-md-7">
            <input type="password" name="password" id="password"
                  class="form-control input-lg" placeholder="Your Password" />
          </div>
        </div>
          <div class="form-group row text-center">
            <button type="submit" class="btn btn-primary btn-lg" name="status"
                    value="accept">
                    Accept
            </button>
            <button type="submit" class="btn btn-danger btn-lg" name="status"
            value="decline">
              Decline
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

  <div class="panel panel-default">
    <div class="panel-heading">
      Description / Comments
    </div>
    <div class="panel-body description">
      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit,
      deleniti corporis, minus ipsum ea deserunt eveniet earum eius natus
      soluta officiis necessitatibus alias? Magnam ratione distinctio
      similique, pariatur veniam quas. 
      </div>
  </div>
@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
  <script src="{{ URL::asset('js/view-a-bid.js') }}"></script>
@stop
