<?php echo $isRepost; ?>
@extends('layouts.master')

{{-- ----------------------------------------------------- --}}
{{-- CSS   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="{{ URL::asset('css/chosen.min.css') }}" />
	<link rel="stylesheet" href="{{ URL::asset('css/datepicker3.css') }}" />
	<link rel="stylesheet" href="{{ URL::asset('css/'. $post_to_css) }}" />
@stop
{{-- ----------------------------------------------------- --}}
{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/{{{ $canonical }}}" />
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
    {{--var otherSelectedProvince = @if($prod_details->other_province_id !== '') {{ $prod_details->other_province_id }} @else "" @endif;--}}
    
    /* Variety Data */
    var product = @if($prod_details->category_id !== '') {{ $prod_details->category_id }} @else "" @endif;
    var varietyOptions = {{ json_encode($formOptions['varietyOptions'])  }};

    var selectedVariety = @if(isset($prod_details->variety_id) && is_numeric($prod_details->variety_id)) {{ $prod_details->variety_id }} @else "" @endif;

    /* The current date/time on the server */
    var currentDate =  $.trim("@if(isset($prod_details->availability_date) && !$isRepost) {{{ $prod_details->availability_date }}} @else {{{ date("M j Y") }}} @endif");
    var currentHours = {{ date('H'); }};
  </script>
@stop

{{-- ----------------------------------------------------- --}}
{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  {{{ $title }}} | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- ----------------------------------------------------- --}}
{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<!-- Header Logo -->
<img src="{{ URL::asset('images/'. $header_icon) }}" height="126" width="126" alt="{{{ $header_alt }}}" class="{{{ $header_class }}}">

<!-- Header Title -->
<h1>{{{ $header_h1 }}}</h1>

<div class="clearfix"></div>

{{ Form::open(array('url' => $form_action, 'method' => 'post', 'id' => 'post-to-buy-form')) }}
<div class="panel-group" id="steps">

  <!-- ============================================================= -->
  <!-- Product Information Tab                                       -->
  <!-- ============================================================= -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <a href="#step-one" data-toggle="collapse" data-parent="#steps"><i class="fa fa-minus {{ $fa_color }}"></i> {{ Lang::get('site_content.post_to_Panel_Heading_Product_Info') }} </a>
    </div>
    <div id="step-one" class="panel-collapse collapse in" data-toggle="false">
      <div class="panel-body panel-product-info">
      
          <!-- Place (Contry) of Origin -->
          <div class="row">
          
            <div class="form-group" id="placeOfOriginGroup">
              <!-- Country -->
              <label class="col-sm-3" for="placeOfOrigin">{{ Lang::get('site_content.post_to_Place_Of_Origin_Label') }}<span class="req">*</span></label>
              <div class="col-sm-9">
                <select data-placeholder="{{ Lang::get('site_content.post_to_Place_Of_Origin_Option') }}..." id="placeOfOrigin" name="origin_id" class="form-control chosen-select width">
                  <option value="" disabled selected>{{ Lang::get('site_content.post_to_Place_Of_Origin_Option') }}...</option>
                    @foreach ($formOptions['placeOfOriginOptions'] as $key => $val)
                      <option value="{{{ $val['id'] }}}" @if($val['id'] == $prod_details->origin_id) selected="selected" @endif>
                        {{{ $val['name'] }}}
                      </option>
                    @endforeach
                </select>
              </div>
            </div>
          </div> <!-- row -->
              
          <!-- Province/State -->
          <div class="row">
            <div id="provinceGroup" class="form-group">
              <!-- Province Label -->
              <label for="province" class="col-sm-3"> {{ Lang::get('site_content.post_to_Province_State_Label') }} <span class="req">*</span> </label>
              <div class="col-sm-9">
                <select data-placeholder="{{ Lang::get('site_content.post_to_Province_State_Option') }}..."
                        class="form-control chosen-select"
                        id="province" 
                        name="province_id">
                  <option value="" disabled selected>{{ Lang::get('site_content.post_to_Province_State_Option') }}...</option>
                </select>
              </div>
            </div>
          </div> <!-- Row -->
              
          <!-- Type of Product -->
          <div class="row">
            <div class="form-group">
              <label for="product_type_id" class="col-sm-3">{{ Lang::get('site_content.post_to_Type_Of_Product_Label') }} <span class="req">*</span></label>
              <div class="col-sm-9">
                <select data-placeholder="{{ Lang::get('site_content.post_to_Type_Of_Product_Option') }}..."
                        name="product_type_id" id="productType"
                        class="form-control chosen-select">
                  <option value="" disabled selected>{{ Lang::get('site_content.post_to_Type_Of_Product_Option') }}...</option>
                    @foreach ($formOptions['productTypeOptions'] as $key => $val)
                      <option value="{{{ $val['id'] }}}" @if($val['id'] == $prod_details->product_type_id) selected="selected" @endif>
                        {{{ $val['name'] }}}
                      </option>
                    @endforeach
                </select>
              </div>
            </div>
          </div> <!-- row -->

          <!-- Product -->
          <div class="row">
            <div class="form-group">
              <label for="category_id" class="col-sm-3">Product <span class="req">*</span></label>
              <div class="col-sm-9">
                <select data-placeholder="Choose or Type a Product..." name="category_id" id="product" class="form-control chosen-select">
                  <option value="" disabled selected>Choose or Type a Product...</option>
                  @foreach($formOptions['productOptions'] as $key => $val)
                    <option value="{{{ $val['id'] }}}" @if($val['id'] == $prod_details->category_id) selected="selected" @endif >
                      {{{ $val['name']  }}}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <!-- Variety -->
          <div class="row" id="varietyRow">
            <div class="form-group">
              <label for="variety_id" class="col-sm-3">Variety <span class="req">*</span></label>
              <div class="col-sm-9">
                <select data-placeholder="Choose or Type a Variety..." name="variety_id" class="form-control chosen-select" id="variety">
                  <option value="" disabled selected>Choose or Type a Variety...</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Variety Other -->
          <div class="row" id="varietyOtherRow">
            <div class="form-group">
                <label for="varietyOptions" class="col-sm-2 col-sm-offset-3">Other Variety</label>
              <div class="col-sm-3">
                <input type="text" class="form-control input-lg" name="varietyOther" id="varietyOther" value="{{ $prod_details->varietyOther }}" >
              </div>
            </div>
          </div>

      </div>
    </div>
  </div>
   
  <!-- ============================================================= -->
  <!-- Product Quantity and Pricing Tab                              -->
  <!-- ============================================================= -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <a href="#step-two" data-toggle="collapse" data-parent="#steps"><i class="fa fa-plus {{{ $fa_color }}}"></i> {{ Lang::get('site_content.post_to_Panel_Heading_Product_Qty_Pricing') }}</a>
    </div>
    <div id="step-two" class="panel-collapse collapse">
      <div class="panel-body">
      
          <div class="row">
          
            <div class="form-group">
              <label for="Qty" class="col-sm-3">{{ Lang::get('site_content.post_to_Qty_Label') }}<span class="req">*</span></label>
              <div class="col-sm-3">
                <input type="number" min="0" class="form-control input-lg" name="qty" id="qty" value="{{{ $prod_details->qty }}}" placeholder="0">
              </div>
            </div>
            
            <div class="form-group">
              <label for="offeringPrice" class="col-sm-2">{{ Lang::get('site_content.post_to_Offering_Price_Label') }}<span class="req">*</span></label>
              <div class="col-sm-4 input-group-container">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-usd" style="font-size: 18px;"></i></span>
                  <input type="text" class="form-control input-lg" name="price" id="offeringPrice" value="{{{ $prod_details->price }}}" placeholder="0.00">
                </div>
              </div>
            </div>
            
          </div>
          <div class="form-group">
          
            <div class="row">
              <label for="minQty" class="col-sm-3">{{ Lang::get('site_content.post_to_Min_Qty_Label') }}<span class="req">*</span></label>
              <div class="col-sm-3">
                <input type="number" min="0" class="form-control input-lg" name="minqty" id="minQty" value="{{{ $prod_details->minqty }}}" placeholder="0">
              </div>
              </div>
            </div>
      </div>
    </div>
  </div>

  <!-- ============================================================= -->
  <!-- Product Details Tab                                           -->
  <!-- ============================================================= -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <a href="#step-three" data-toggle="collapse" data-parent="#steps"><i class="fa fa-plus {{{ $fa_color }}}"></i> {{ Lang::get('site_content.post_to_Panel_Heading_Product_Details') }}</a>
    </div>
    <div id="step-three" class="panel-collapse collapse">
      <div class="panel-body">
      
        <!-- ================================================================= -->
          <!-- Bulk Weight Row (Package)-->
          <div class="row">
            
              <!-- Bulk Weight -->
            <div class="form-group">
              <label for="weightPackage" class="col-sm-3">{{ Lang::get('site_content.post_to_Weight_Master_Container_Label') }}<span class="req">*</span></label>
              <div class="col-sm-3">
                <input type="text" min="0" step="any" name="bulk_weight" id="weightPackage" class="form-control input-lg" value="{{{ $prod_details->bulk_weight }}}" placeholder="0">
              </div>
            </div>
              
              <!-- Bulk Units -->
            <div class="form-group">
              <div class="col-sm-2">
                <select name="bulk_weight_type_id" id="weightPackageType" class="form-control input-lg">
                      <option value="" selected disabled>Weight</option>
                      @foreach ($formOptions['bulkWeightTypeOptions'] as $key => $val)
                        <option @if($prod_details->bulk_weight_type_id == $val['id']) selected="selected" @endif value="{{{ $val['id'] }}}">
                          {{{ $val['name'] }}}
                        </option>
                      @endforeach
                </select>
              </div>
            </div>
            
            <!-- Bulk Package Type -->
            <div class="form-group">
              <div class="col-sm-4">
                <select name="bulk_package_id" id="package" class="form-control input-lg">
                  <option value="" selected disabled>{{ Lang::get('site_content.post_to_Master_Weight_Container') }}</option>
                  @foreach ($formOptions['bulkPackageOptions'] as $key => $val)
                    <option @if($prod_details->bulk_package_id == $val['id']) selected="selected" @endif value="{{{ $val['id'] }}}">
                      {{{ $val['name'] }}}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            
          </div>
      
          <!-- Bulk -->
          <div class="row">
            <div class="form-group">
              <!-- Bulk label -->            
              <label class="col-sm-3">{{ Lang::get('site_content.post_to_Bulk_Label') }}<span class="req">*</span></label>
              <div class="radio col-sm-3">
                <label>
                  <input type="radio" name="isbulk" id="bulkYes" value="1" @if($prod_details->isbulk == 1) checked="checked" @endif />
                  {{ Lang::get('site_content.global_Yes') }}
                </label>
                <label>
                  <input type="radio" name="isbulk" id="bulkNo" value="0" @if($prod_details->isbulk == 0) checked="checked" @endif />
                  {{ Lang::get('site_content.global_No') }}
                </label>
              </div>
            </div>
          </div>
      
      
        <!-- ================================================================= -->
          <!-- Group dependant on bulk yes/no -->
          <div class="row-pcs-wp" @if($prod_details->isbulk == "1") style="display: none;" @endif>
          
            <!-- PCs / Master Ctn Row -->
            <div class="row">
              <div class="form-group">
                <label for="pcsCount" class="col-sm-3">{{ Lang::get('site_content.post_to_PCs_Master_Container_Label') }}<span class="req">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="carton_pieces" id="pcsCount" class="form-control input-lg" value="{{{ $prod_details->carton_pieces }}}" placeholder="0" @if($prod_details->isbulk == "1") readonly @endif />
                </div>
              </div>
            </div>
            
            <!-- Weight / PC Row -->
            <div class="row">
              <div class="weight-carton">
                
                  <!-- Weight / PC -->
                  <div class="col-sm-3 form-group">
                    <label for="carton_weight"> {{ Lang::get('site_content.post_to_Weight_PC_Label') }} <span class="req">*</span></label>
                  </div>
                  <div class="col-sm-3 form-group">
                    <input type="text" min="0" id="weightCarton"
                            class="form-control input-lg" name="carton_weight"
                            value="{{{ $prod_details->carton_weight }}}"
                            placeholder="0" 
                            @if($prod_details->isbulk == "1") readonly @endif />
                  </div>
                  
                  <!-- Weight Carton Units (ie oz)-->
                  <div class="col-sm-2 form-group">
                    <select name="carton_weight_type_id" id="weightCartonType" class="form-control input-lg" @if($prod_details->isbulk == "1") disabled @endif>
                      <option value="" selected disabled>Weight</option>
                      @foreach ($formOptions['cartonWeightTypeOptions'] as $key => $val)
                        <option @if($prod_details->carton_weight_type_id == $val['id']) selected="selected" @endif value="{{{ $val['id'] }}}">
                          {{{ $val['name'] }}}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  
                  <!-- The carton/clamshell.. selector carton-type -->
                  <div class="col-sm-4 form-group">
                    <select name="carton_package_id" id="carton" class="form-control input-lg">
                      <option value="" selected disabled>Package Type</option>
                      @foreach ($formOptions['cartonPackageOptions'] as $key => $val)
                        <option @if($prod_details->carton_package_id == $val['id']) selected="selected" @endif value="{{{ $val['id'] }}}">
                          {{{ $val['name'] }}}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  
              </div> <!-- weight carton -->
            </div><!-- row -->
            
          </div> <!-- End group dependant on bulk Yes(1)/No(0) -->
            
            
          <!-- Maturity --> 
          <div class="row">
            <div class="form-group">
              <div class="form-group">
                <label for="maturity" class="col-sm-3">{{ Lang::get('site_content.post_to_Maturity_Label') }}<span class="req">*</span></label>
              </div>
              <div class="col-sm-9">
                <select name="maturity_id" id="maturity" class="form-control input-lg">
                  <option value="" selected disabled>{{ Lang::get('site_content.post_to_Maturity_Label') }}</option>
                  @foreach ($formOptions['maturityOptions'] as $key => $val)
                    <option @if($val['id'] == $prod_details->maturity_id) selected="selected" @endif value="{{{ $val['id'] }}}">
                      {{{ $val['name'] }}}
                    </option>
                  @endforeach 
                </select>
              </div>
            </div>
          </div>

          <!-- Colour -->
          <div class="row">
            <div class="form-group">
              <label for="colour_id" class="col-sm-3">{{ Lang::get('site_content.post_to_Colour_Label') }}<span class="req">*</span></label>
              <div class="col-sm-9">
                <select name="colour_id" id="colour" class="form-control input-lg">
                  <option value="" selected disabled>{{ Lang::get('site_content.post_to_Colour_Label') }}</option>
                  @foreach ($formOptions['colorsOptions'] as $key => $val)
                    <option @if($val['id'] == $prod_details->colour_id) selected="selected" @endif value="{{{ $val['id'] }}}">
                      {{{ $val['name'] }}}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          
          <!-- Quality -->
          <div class="row">
            <div class="form-group">
              <label for="quality" class="col-sm-3">{{ Lang::get('site_content.post_to_Quality_Label') }}<span class="req">*</span></label>
              <div class="col-sm-9">
                <select name="quality_id" id="quality" class="form-control input-lg">
                  <option value="" selected disabled>{{ Lang::get('site_content.post_to_Quality_Label') }}</option>
                  @foreach ($formOptions['qualityOptions'] as $key => $val)
                    <option @if($val['id'] == $prod_details->quality_id) selected="selected" @endif value="{{{ $val['id'] }}}">
                      {{{ $val['name'] }}}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <!-- Available -->
          <div class="row">
            <!-- Available Label -->
            <div class="form-group col-sm-3">
              <label for="availability_date" class="">{{ Lang::get('site_content.post_to_Available_Label') }}<span class="req">*</span></label>
            </div>
            
            <!-- Available Datepicker -->
            <div class="form-group col-sm-3">
              <input name="availability_date" id="available" class="datepicker form-control input-lg" 
              value="@if(!empty($prod_details->availability_date) && !$isRepost) {{{ $prod_details->availability_date }}} @else {{{ date("M j Y") }}} @endif" placeholder="{{{ date("M j Y") }}}">
            </div>

            <!-- Between  -->
            <div class="form-group col-sm-2">
              <label for="fromDate" class="">{{ Lang::get('site_content.post_to_Between_Label') }}</label>
            </div>
              
            <!-- Between From -->
            <div class="form-group col-sm-2">
              <select name="availability_start" id="fromDate" class="input-lg">
                <option value="" selected disabled>From</option>
                
                <?php 
                  $current_24hour = idate('H'); // Current hour as integer
                  $valid_start_hour = $current_24hour + 1;
                  $pm_start_hour = max($valid_start_hour - 12, 0); // make negative numbers zero
                ?>
                
                <!-- 1:00 AM - 11:00 AM -->
                @for ($i = $valid_start_hour; $i <= 11; $i++)
                  <option @if($prod_details->availability_start == $i . ":00 AM") selected="selected" @endif value="{{{ $i . ":00 AM" }}}">
                    {{{ $i . ":00 AM" }}}
                  </option>
                @endfor
                
                <!--  12:00 PM - 11:00 PM -->
                @for ($j = $pm_start_hour; $j <= 11; $j++)
                  @if($j == 0) <?php  $j = 12 ?> @endif
                  <option @if($prod_details->availability_start == $j . ":00 PM") selected="selected" @endif value="{{{ $j . ":00 PM" }}}">
                    {{{ $j . ":00 PM" }}}
                  </option>
                  @if($j == 12) <?php  $j = 0 ?> @endif
                @endfor
                
                <!-- manually add 12:00 AM midnight -->
                <option @if($prod_details->availability_start == "12:00 AM") selected="selected" @endif value="12:00 AM">12:00 AM</option>
              </select>
            </div>
            
            <!-- Between To -->
            <div class="form-group col-sm-2">
                <select name="availability_end" id="toDate" class="input-lg">
                  <option value="" selected disabled>To</option>
                  
                  <!-- loop through 1:00 AM - 11:00 AM -->
                  @for ($i= $valid_start_hour; $i <= 11; $i++)
                    <option @if($prod_details->availability_end == $i . ":00 AM") selected="selected" @endif value="{{{ $i . ":00 AM" }}}">
                      {{{ $i . ":00 AM" }}}
                    </option>
                  @endfor
                  
                  <!-- loop through 1:00 PM - 11:00 PM -->
                  @for ($j=$pm_start_hour; $j <= 11; $j++)
                    @if($j == 0) <?php  $j = 12 ?> @endif
                    <option @if($prod_details->availability_end == $j . ":00 PM") selected="selected" @endif value="{{{ $j . ":00 PM" }}}">
                      {{{ $j . ":00 PM" }}}
                    </option>
                    @if($j == 12) <?php  $j = 0 ?> @endif
                  @endfor
                  
                  <!-- manually add 12:00 AM -->
                  <option @if($prod_details->availability_end == "12:00 AM") selected="selected" @endif value="12:00 AM">12:00 AM</option>
                </select>
            </div>
          </div>
          
          <!-- Description -->
          <div class="form-group">
            <div class="row">
              <label for="description" class="col-sm-3">
                {{ Lang::get('site_content.post_to_Description_Comments') }}
              </label>
              <div class="col-sm-9">
                <textarea name="description" id="description" cols="30" rows="4" class="form-control input-lg">{{{ $prod_details->description }}}</textarea>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>

  <!-- ============================================================= -->
  <!-- Receiving Address Tab                                 -->
  <!-- ============================================================= -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <a href="#step-four" data-toggle="collapse" data-parent="#steps"><i class="fa fa-plus {{{ $fa_color }}}"></i> {{ Lang::get('site_content.post_to_Panel_Heading_Display_Address', array('display_address'=>$display_address)) }}</a>
    </div>
    
    <div id="step-four" class="panel-collapse collapse">
      <div class="panel-body">
        
        <!-- Address Select -->
        <div class="form-group">
          <div class="row">
            <label for="{{{ $address_select_name }}}" class="col-sm-3">{{ Lang::get('site_content.post_to_Address_Label', array('display_address'=>$display_address)) }}<span class="req">*</span></label>
            <div class="col-sm-5">
              <select name="{{{ $address_select_name }}}" id="{{{ $address_select_id }}}" class="form-control input-lg">
                
                <!-- Placeholder text -->
                <option value="" selected disabled>{{ Lang::get('site_content.post_to_Address_Main_Option', array('display_address'=>$display_address)) }}</option>
                
                <!-- Pickup / Delivery option -->
                <option value="pickupdelivery">
                 {{ Lang::get('site_content.post_to_Address_For_Pickup') }}
                </option>
                
                {{-- ========================================= --}}
                {{-- post to buy page receiveing --}} 
                {{-- ========================================= --}}
                @if($page === "buy")
                  <!-- Address List -->
                  @foreach ($formOptions['shiprecvAddressOptions'] as $key => $val)
                    <option @if($val->id == $prod_details->company_address_id) selected="selected" @endif value="{{{ $val->id }}}">
                      {{{ $val->company.' - '.$val->address.',' }}}
                      @if($val->address2<>'') {{{ $val->address2.', ' }}}@endif
                      {{{ $val->city.', '.$val->pname.', '.$val->cname.', '.$val->postal_code }}}
                    </option>
                  @endforeach
                  <!-- Add a new address -->
                  <option @if($prod_details->company_address_id == "other") selected="selected" @endif value="other">{{ Lang::get('site_content.post_to_Address_Add_New_Receiving') }}...</option>
                {{-- ========================================= --}}
                {{-- post to sell page shipping --}} 
                {{-- ========================================= --}}
                @else
                  <!-- Address List -->
                  @foreach ($formOptions['shiprecvAddressOptions'] as $key => $val)
                    <option @if($val->id == $prod_details->company_address_id) selected="selected" @endif value="{{{ $val->id }}}">
                      {{{ $val->company.' - '.$val->address.',' }}}
                      @if($val->address2<>'') {{{ $val->address2.', ' }}}@endif
                      {{{ $val->city.', '.$val->pname.', '.$val->cname.', '.$val->postal_code }}}
                    </option>
                  @endforeach
                  
                  <!-- Add a new address -->
                  <option @if($prod_details->company_address_id == "other") selected="selected" @endif value="other">{{ Lang::get('site_content.post_to_Address_Add_New_Shipping') }}...</option>
                @endif
                 
              </select>
            </div>
          </div>
        </div>
        
        {{-- -------------------------------------------------------  --}}
        <!-- Other Address -->
        {{-- -------------------------------------------------------  --}}
        
        <!-- Street Address  -->
        <div class="other-{{{ $address }}}-address col-sm-offset-0" style="@if( /*$prod_details->address_select */"" == 'other') display: block @endif">
        
          <!-- Company Name -->
          <div class="row">
            <div class="form-group">
              <label for="other_company" class="col-sm-3">{{ Lang::get('site_content.post_to_Company_Label') }}</label>
              <div class="col-sm-5">
                <input type="text" name="other_company" class="form-control input-lg other-{{{ $address }}}-address-input" placeholder="{{ Lang::get('site_content.post_to_Company_Label') }}" value="">
              </div>
            </div>
          </div>            

          <div class="row">
            <div class="form-group">
              <label for="other_address" class="col-sm-3">{{ Lang::get('site_content.post_to_Address_Label') }}<span class="req">*</span></label>
              <div class="col-sm-5">
                <input type="text" name="other_address" id="{{{ $other_address_id }}}" class="form-control input-lg other-{{{ $address }}}-address-input" placeholder="{{ Lang::get('site_content.post_to_Address_Label') }}" value="">
              </div>
            </div>
          </div>
          
          <!-- Other Street Address2 -->
          <div class="row">
            <div class="form-group">
              <label for="other_address2" class="col-sm-3">{{ Lang::get('site_content.post_to_Address2_Label') }}<span class="req">*</span></label>
              <div class="col-sm-5">
                <input type="text" name="other_address2" id="{{{ $other_address_id2 }}}" class="form-control input-lg other-{{{ $address }}}-address-input" placeholder="{{ Lang::get('site_content.post_to_Address2_Placeholder') }}" value="">
              </div>
            </div>
          </div>            
          
          <!-- Other City -->
          <div class="row">
            <div class="form-group">
              <label for="city" class="col-sm-3">{{ Lang::get('site_content.post_to_City_Label') }}<span class="req">*</span></label>
              <div class="col-sm-3">
                <input type="text" class="form-control input-lg other-{{{ $address }}}-address-input" name="other_city" value="" id="city" placeholder="{{ Lang::get('site_content.post_to_City_Label') }}">
              </div>
            </div>
          </div> <!-- Row -->
          
          <!-- Other Country  -->
          <div class="row other-{{{ $address }}}-middle-row">
            <div id="otherCountryGroup" class="form-group">
              <label for="other_country_id" class="col-sm-3">Country</label>
              <div class="col-sm-4">
                <select data-placeholder="Choose a Country"
                        id="otherCountry" 
                        name="other_country_id" 
                        class="form-control input-lg">
                  <option value="" disabled selected>Choose or Type a Country</option>
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
              <label for="other_province_id" class="col-sm-3">Province/State<span class="req">*</span></label>
              <div class="col-sm-4">
                <select data-placeholder="Choose a Province or State"
                    id="otherProvince" 
                    name="other_province_id" 
                    class="form-control input-lg">
                  <option value="" disabled selected>Choose or Type a Province</option>
                </select>
              </div>
            </div>
          </div> <!-- Row -->
          
          <!--Postal Code -->
          <div class="row">
            <div class="form-group">
              <label for="other_postal_code" class="col-sm-3">{{ Lang::get('site_content.post_to_Postal_Code_Label') }}<span class="req">*</span></label>
              <div class="col-sm-3">
                <input type="text" class="form-control input-lg other-{{{ $address }}}-address-input" name="other_postal_code" value="" id="postal" placeholder="{{ Lang::get('site_content.post_to_Postal_Code_Label') }}">
              </div>
            </div>
          </div> <!-- row -->
        </div> <!-- other <ship/recieving> address wrapper -->
        
        <div class="row">
          <div class="form-group">
            <div class="row">
              <div class="col-sm-offset-3 col-sm-4">
                {{ Form::label('password', Lang::get('site_content.post_to_Password_Label'), array('class' => '')) }}<span class="req">*</span>
                {{ Form::password('password', array('id' => 'password_input', 'class' => 'form-control input-lg')) }}
                <button type="submit" class="btn btn-primary btn-lg preview-post">{{ Lang::get('site_content.post_to_Submit_Button') }}</button>
              </div>
            </div>
          </div>
        </div> <!-- Row -->
      </div> <!-- panel body -->
    </div> <!-- step four -->
  </div> <!-- panel -->
</div> <!-- panel group -->
</form>
@stop {{-- content --}}
    
    
{{-- ----------------------------------------------------- --}}
{{-- Bottom Scripts                                        --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
	<script src="{{ URL::asset('js/chosen.jquery.min.js') }}"></script>
	<script src="{{ URL::asset('js/chosen.js') }}"></script>
	<script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
  {{ $post_to_js }}
@stop
