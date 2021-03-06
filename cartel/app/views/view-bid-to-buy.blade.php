@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/bid-to-buy-details" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/bid-to-buy.css') }}" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Bid To Buy - Bid Details  | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')
  <h1>Bid To Buy - Bid Details</h1>

  <p>Below are the details of a product that a member wishes to <b>SELL</b>.
  Describe the product you would like to <b>BUY</b>. Enter your password and
  place your bid. <br><br> Roll your mouse over a 
  <i class='fa fa-times' style='color: #a94442;'></i> to see its error
  message.</p>


  <section class="product-bid-to-buy">

    <div class="row" style="margin-bottom: 1em;">
      <div class="col-md-12">
        <h1 class="product-type">
        {{{ $bid_details->productType_name }}}
        
        </h1>
      </div>
    </div>

    <div class="panel panel-default">
     <div class="row" style="margin-top: 1em;">
        <div class="panel-body">
         <div class="col-md-4">
            @if($bid_details->place_of_origin_image != '')
              <img src="{{ URL::asset('images/labels/'.$bid_details->place_of_origin_image) }}" height="150" width="300"
                  alt="{{{ $bid_details->place_of_origin_name }}}">
            @else
              <img src="{{ URL::asset('images/labels/no_image.png') }}" class="img-label" alt="No Image" width="100" />
            @endif
         </div>
         <div class="col-md-4" style="margin-top: 1.5em;">
           <h2 class="product">{{{ $bid_details->product_name }}}</h2>
           <h3 class="product-variety">{{{ $bid_details->variety_name }}}</h3>
         </div>
         <div class="col-md-4" style="margin-top: .5em;">
           <table class="table">
             <tbody>
               <tr>
                 <td>Your <abbr title="Quantity">Qty</abbr></td>
                 <td>{{{ $product_details->qty }}}</td>
               </tr>
               <tr>
                 <td>Your <abbr title="Minimum Quantity">Min Qty: </abbr></td>
                 <td>{{{ $product_details->minqty }}}</td>
               </tr>
               <tr>
                 <td>Your Asking Price</td>
                 <td>${{{ $product_details->price }}}</td>
               </tr>
             </tbody>
           </table>
         </div>
       </div>
     </div>
    </div>

    <div class="row">
      <div class="col-md-5">
        <div class="panel panel-default">
          <div class="panel-heading">Bid Product Details</div>
          <div class="panel-body">
            <table class="table table-product-details">
              <tbody>

                @if($bid_details->isbulk == 'no')
                  <tr>
                    <td>PCs or PKGs</td>
                    <td>
                      {{{ $bid_details->carton_pieces }}}
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Weight / {{{ $bid_details->carton_package_name }}}
                    </td>
                    <td>
                      {{{ $bid_details->carton_weight . " " . $bid_details->carton_weight_type_name }}}
                    </td>
                  </tr>
                @endif
                
                <tr>
                  <td>Bulk Weight / {{{ $bid_details->bulk_package_name }}}</td>
                  <td>{{{ $bid_details->bulk_weight . " " . $bid_details->bulk_weight_type_name }}}</td>
                </tr>
                <tr>
                  <td>Bulk</td>
                  <td>{{{ ucwords($bid_details->isbulk) }}}</td>
                </tr>
                <tr>
                  <td>Maturity</td>
                  <td>{{{ $bid_details->maturity_name }}}</td>
                </tr>
                <tr>
                  <td>Colour</td>
                  <td>{{{ $bid_details->colour_name }}}</td>
                </tr>
                <tr>
                  <td>Quality</td>
                  <td>{{{ $bid_details->quality_name }}}</td>
                </tr>
                <tr>
                  <td>Availability</td>
                  <td>
					  {{{ $bid_details->availability_date }}} <BR>
					  between <BR>
					  {{{ $bid_details->availability_start }}} 
					  and 
					  {{{ $bid_details->availability_end }}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
      Bid Details
      </div>
      <div class="panel-body">
        @if(isset($msg))
          <p>{{{ $msg }}}</p>
        @endif
        
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bid">
              <tr>
                <td>Bid Qty</td>
                <td>{{{ $bid_details->qty }}}</td>
              </tr>
              <tr>
                <td>Bid Price</td>
                <td>${{{ $bid_details->price }}}</td>
              </tr>
            </table>
          </div>
        </div>
        <form action="/view-bid/{{{ $bid_details->id }}}/store" method="post">
        <div class="form-group row">
          <label for="password" class="col-md-5 control-label">Verify Password<span class="req">*</span></label>
          <div class="col-md-7">
            <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Your Password">
          </div>
        </div>
          <div class="form-group row text-center">
            <button type="submit" class="btn btn-primary btn-lg" name="decision" value="accept">Accept</button>
            <button type="submit" class="btn btn-danger btn-lg" name="decision" value="decline">Decline</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@if($bid_details->description)
  <div class="panel panel-default">
    <div class="panel-heading">
      Description / Comments
    </div>
    <div class="panel-body description">
      {{{ $bid_details->description }}}
    </div>
  </div>
@endif
    
  </section>
@stop {{-- content --}}

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
	<script src="{{ URL::asset('js/chosen.jquery.min.js') }}"></script>
	<script src="{{ URL::asset('js/chosen.js') }}"></script>
	<script src="{{ URL::asset('js/bid-to-buy.js') }}"></script>
@stop
