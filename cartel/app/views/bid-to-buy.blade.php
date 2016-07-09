@extends('layouts.master')


{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/bid-to-buy" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="{{ URL::asset('css/chosen.min.css') }}" />
	<link rel="stylesheet" href="{{ URL::asset('css/bid-to-buy.css') }}" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Bid To Buy | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- ----------------------------------------------------- --}}
{{-- JS Head   --}}
{{-- ----------------------------------------------------- --}}
@section('js_head')
  <!-- PHP arrays to Javascript arrays -->
  <script type="text/javascript">
  
    /* Get available units (kg, lb, oz) */
    var weightCartonTypeOptions = {{ json_encode($formOptions['cartonWeightTypeOptions']) }};
    var weightPackageTypeOptions = {{ json_encode($formOptions['bulkWeightTypeOptions']) }};
    
    /* Province Data */
    var placeOfOrigin = @if($prod_details->origin_id !== '') {{ $prod_details->origin_id }} @else "" @endif;
    var provinceOptions = {{ json_encode($formOptions['provinceOptions']) }};
    var selectedProvince = @if($prod_details->province_id !== '') {{ $prod_details->province_id }} @else "" @endif;

    /* Other Province Data */
    var otherProvinceOptions = {{ json_encode($formOptions['otherProvinceOptions']) }};
    
    /* Variety Data */
    var product = @if($prod_details->category_id !== '') {{ $prod_details->category_id }} @else "" @endif;
    var varietyOptions = {{ json_encode($formOptions['varietyOptions'])  }};
    
    var selectedVariety = @if($prod_details->category_id !== '') {{ $prod_details->category_id }} @else "" @endif;

  </script>
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<h1>Bid To Buy</h1>
<section class="product-bid-to-buy">

  <!-- ================================================================= -->
  <!-- dislay product type name -->
  <!-- ================================================================= -->
  <div class="row" style="margin-bottom: 1em;">
    <div class="col-md-12">
      <h1 class="product-type"> {{{ $prod_details->productType_name }}}</h1>
    </div>
  </div>
  
  <!-- ================================================================= -->
  <!--Display origin, product name and qty's -->
  <!-- ================================================================= -->
  <div class="panel panel-default">
   <div class="row" style="margin-top: 1em;">
      <div class="panel-body">

      <!-- Product Image -->
       <div class="col-md-4">
          @if($product_image_filename != "")
            <img src="/uplds/productimages/{{{ $product_image_filename }}}" />
          @else
            <img src="/images/labels/no_image.png" class="big-no-image"/>
          @endif
          
       </div>
       
      <!-- Product Name/ Place of Origin -->
       <div class="col-md-4" style="margin-top: 1.5em;">
         <!--  Parent category -->
         <h2 class="product">
           {{{ $prod_details->product_name }}}
         </h2>
         <!-- Child category -->
         @if($prod_details->variety_parent_id)
	         <h3 class="product-variety">{{{ $prod_details->variety_name }}}</h3>
         @endif
          
         <!-- Place of origin -->
         @if($prod_details->place_of_origin_image != '')
           <img src="{{ URL::asset('images/labels/'.$prod_details->place_of_origin_image ) }}" 
                height="25" width="50" alt="{{{ $prod_details->place_of_origin_name }}}">
         @else
           <img src="{{ URL::asset('images/labels/no_image.png') }}" class="img-label" alt="No Image" width="100" />
         @endif
         
       </div>

        <!--  Table -->
       <div class="col-md-4" style="margin-top: .5em;">
         <table class="table">
           <tbody>
             <!-- Qty -->
             <tr>
               <td><abbr title="Quantity">Qty</abbr></td>
               <td>{{{ $prod_details->qty }}}</td>
             </tr>
             <!-- Min Qty -->
             <tr>
               <td>Min <abbr title="Quantity">Qty</abbr></td>
               <td>{{{ $prod_details->minqty }}}</td>
             </tr>
             <!-- Asking Price -->
             <tr>
               <td>Asking Price</td>
               <td>${{{ $prod_details->price }}}</td>
             </tr>
           </tbody>
         </table>
       </div>
       
     </div><!-- panel-body -->
   </div> <!-- row -->
  </div> <!-- panel panel-default -->
     
  <!-- ================================================================= -->
  <!-- Product Details -->
  <!-- ================================================================= -->
  <div class="row">
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading">Product Details</div>
        <div class="panel-body">
          <table class="table table-product-details">
            <tbody>
              @if($prod_details->isbulk == 0)
                <tr>
                  <td>PCs or PKGs</td>
                  <td>
                    @if($prod_details->isbulk == 0)
                      {{{ $prod_details->carton_pieces }}} 
                    @else
                      "N/A"
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>Weight / {{{ $prod_details->carton_package_name }}}</td>
                  <td>
                    @if($prod_details->isbulk == 0)
                      {{{ $prod_details->carton_weight . " " . $prod_details->carton_weight_type_name }}} 
                    @else
                      "N/A"
                    @endif
                  </td>
                </tr>
              @endif
              <tr>
                <td>Weight / {{{ $prod_details->bulk_package_name  }}}</td>
                <td>{{{ $prod_details->bulk_weight . " " . $prod_details->bulk_weight_type_name }}}</td>
              </tr>
              <tr>
                <td>Bulk</td>
                <td>{{{ ucwords($prod_details->isbulk) }}}</td>
              </tr>
              <tr>
                <td>Maturity</td>
                <td>{{{ $prod_details->maturity_name }}}</td>
              </tr>
              <tr>
                <td>Colour</td>
                <td>{{{ $prod_details->colour_name }}}</td>
              </tr>
              <tr>
                <td>Quality</td>
                <td>{{{ $prod_details->quality_name }}}</td>
              </tr>
              <tr>
                <td>Availability</td>
                <td>
                  {{{ $prod_details->availability_date }}} 
                  between 
                  {{{ $prod_details->availability_start }}} 
                  and 
                  {{{ $prod_details->availability_end }}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  <!-- ================================================================= -->
  <!-- Place a Bid to Buy -->
  <!-- ================================================================= -->
    <div class="col-md-7">
      <div class="panel panel-default">
      
        <!-- Header -->
        <div class="panel-heading"> Place a Bid to Buy </div>
        
        <div class="panel-body">
          <form  action='{{{ $form_action }}}' method="post" id="bid-to-buy-form">  {{---   id="bid-to-buy-form"  ---}}
          {{ Form::hidden('product_id', $prod_details->id)	}}
	      
            
            <!-- Quantity -->
            <div class="row">
              <div class="form-group">
                <label for="quantity" class="control-label col-md-5">Quantity<span class="req">*</span></label>
                <div class="col-md-5">
                  <input type="number" min="{{{ $prod_details->minqty }}}" name="qty" id="quantity" class="form-control input-lg" value="{{{ $prod_details->qty }}}">
                </div>
                <div class="col-q">
                  {{-- <i class="fa fa-question" rel="tooltip" data-toggle="tooltip" data-placement="right" title="This will tell you something about the current box."></i> --}}
                </div>
              </div>
            </div>
            
            <!-- Price -->
            <div class="row">
              <div class="form-group">
                <label for="price" class="control-label col-md-5">Price</label>
                <div class="col-md-5">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-usd" style="font-size: 18px;"></i></span>
                    <input type="number" step="any" class="form-control input-lg" name="price" id="price" value="{{{ $prod_details->price }}}" readonly>
                  </div>
                </div>
              </div>
            </div>
   
            <!-- ============================= -->
            <!-- Receiving Address Select -->
            <!-- ============================= -->
            <div class="row">
              <div class="form-group">
                <label for="receivingAddress" class="col-md-5 control-label">Select a Delivery Address</label>
                <div class="col-md-7">
                  <select name="company_address_id" id="receivingAddress" class="form-control input-lg chosen-select" >
                    <option value="" selected disabled>Receiving Address</option>
                    @foreach ($formOptions['shiprecvAddressOptions'] as $key => $val)
                      <option @if($val->id == $prod_details->company_address_id) selected="selected" @endif value="{{{ $val->id }}}">
						  {{{ $val->company.' - '.$val->address.',' }}}
						  @if($val->address2<>'') {{{ $val->address2.', ' }}}@endif
						  {{{ $val->city.', '.$val->pname.', '.$val->cname.', '.$val->postal_code }}}
                      </option>
                    @endforeach
                    <option value="other">Add New Receiving Address...</option>
                  </select>
                </div>
              </div>
            </div>
            
            <!-- ============================= -->
            <!-- Other Receiving Address Input -->
            <!-- ============================= -->
            <div class="other-receiving-address">
            
              <!-- Company Name -->
              <div class="row">
                <div class="form-group" style="margin-top: 0;">
                  <label for="other_company" class="col-sm-5">@lang('site_content.post_to_Company_Label')</label>
                  <div class="col-sm-7">
                    <input type="text" name="other_company" class="form-control input-lg" placeholder="@lang('site_content.post_to_Company_Label')" value="">
                  </div>
                </div>
              </div>            
            
              <!-- Stree Address -->
              <div class="row">
                <div class="form-group">
                  <label for="otherReceivingAddress" class="control-label col-md-5">Street Address<span class="req">*</span></label>
                  <div class="col-md-7">
                    <input type="text" name="other_address" id="other_address" class="form-control input-lg other-receiving-address-input" placeholder="Street Address">
                  </div>
                </div>
              </div>
              
              <!-- Stree Address 2 -->
              <div class="row">
                <div class="form-group" >
                  <label for="otherReceivingAddress" class="control-label col-md-5">Street Address 2<span class="req">*</span></label>
                  <div class="col-md-7">
                    <input type="text" name="other_address2" class="form-control input-lg other-receiving-address-input" placeholder="Street Address">
                  </div>
                </div>
              </div>
                            
              <!-- City -->
              <div class="row">
                <div class="form-group other-receiving-middle-row">
                  <label for="city" class="control-label col-md-5">City<span class="req">*</span></label>
                  <div class="col-md-7">
                    <input type="text" class="form-control input-lg other-receiving-address-input" name="other_city" id="city" placeholder="City">
                  </div>
                </div>
              </div>
              
              <!-- Other Country  -->
              <div class="row">
                <div id="otherCountryGroup" class="form-group">
                  <label for="otherCountry" class="col-sm-5">Country</label>
                  <div class="col-sm-7">
                    <select data-placeholder="Choose a Country"
                            id="otherCountry" 
                            name="other_country_id" 
                            class="form-control input-lg">
                      <option value="" disabled selected>Choose a Country</option>
                      @foreach ($formOptions['otherCountryOptions'] as $key => $val)
                        <option value="{{{ $val['id'] }}}"> {{{ $val['name'] }}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div> <!-- Row -->
              
          <!-- Other Province -->
          <div class="row">
            <div id="otherProvinceGroup" class="form-group">
              <label for="other_province_id" class="col-sm-5">Province/State<span class="req">*</span></label>
              <div class="col-sm-7">
                <select data-placeholder="Choose a Province or State"
                    id="otherProvince" 
                    name="other_province_id" 
                    class="form-control input-lg">
                  <option value="" disabled selected>Choose a Province</option>
                </select>
              </div>
            </div>
          </div> <!-- Row -->
            
              <!-- Postal Code -->
              <div class="row">
                <div class="form-group">
                  <label for="other_postal_code" class="control-label col-md-5">Postal Code<span class="req">*</span></label>
                  <div class="col-md-7">
                    <input type="text" class="form-control input-lg other-receiving-address-input" name="other_postal_code" id="postal" placeholder="Postal Code">
                  </div>
                </div>
              </div>
              
            </div><!-- Other Receiving Address -->
            
            <!-- Password -->
            <div class="row">
              <div class="form-group">
                <label for="password" class="control-label col-md-5">Verify Password<span class="req">*</span></label>
                <div class="col-md-6">
                  <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Your Password">
                </div>
              </div>
            </div>
            
            <!-- Submit Button -->
            <div class="row">
              <div class="form-group">
                <div class="col-md-offset-5 col-md-7">
                  {{-- <input type="submit" class="btn btn-lg btn-primary" value="Place a Bid to Buy"> --}}
                  <button type="submit" class="btn btn-primary btn-lg preview-post">Place a Bid to Buy</button>
                </div>
              </div>
            </div>
            
          </form>
        </div><!-- panel-body -->
        
      </div><!-- panel panel-default -->
      
    </div><!-- col-md-7 -->
  </div><!-- row -->

  <!-- ================================================================= -->
  <!-- Description/Comments  -->
  <!-- ================================================================= -->
  @if($prod_details->description)
    <div class="panel panel-default">
      <div class="panel-heading">Description / Comments</div>
      <div class="panel-body description">
        {{{ $prod_details->description }}}
      </div>
    </div>
  @endif

  <!-- ================================================================= -->
  <!-- Post to buy button -->
  <!-- ================================================================= -->
  <div class="panel panel-default" style="border-bottom-right-radius: 60px;">
    <div class="panel-heading">
      Post to Buy
    </div>
    <div class="panel-body">
      <p>
        This text will say something about what the below button does. Don't like the asking price? Post to Buy this product!
      </p>
      <form action="/post-to-buy/{{{ $prod_details->id }}}/counter-repost" method="post">
        <input type="submit" id="post-to-buy" class="btn btn-lg btn-primary" name="post-to-buy" value="Post To Buy ">
      </form>
    </div>
  </div>

</section>

@stop {{-- content --}}

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
	<script src="{{ URL::asset('js/chosen.jquery.min.js') }}"></script>
	<script src="{{ URL::asset('js/chosen.js') }}"></script>
	<script src="{{ URL::asset('js/bid-to-buy.js') }}"></script>
@stop
