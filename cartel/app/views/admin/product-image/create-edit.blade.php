@extends('layouts.master')

{{-- make sure $edit_page is set --}}
@if(!isset($edit_page))
      <?php $edit_page = false; ?>
@endif

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/admin-origin" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="{{ URL::asset('css/chosen.min.css') }}" />
	<link rel="stylesheet" href="{{ URL::asset('css/admin.css') }}" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
 Add Product Image | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- ----------------------------------------------------- --}}
{{-- JS Head   --}}
{{-- ----------------------------------------------------- --}}

@section('js_head')
  <!-- PHP arrays to Javascript arrays -->
  <script type="text/javascript">
    var varietyOptions = {{ json_encode($formOptions['varietyOptions']) }};
    
    // If creating a new product image
    var selectedCategory = "{{ Input::old('category_id') }}";
    var selectedVariety = "{{ Input::old('variety_id') }}";

    // If there's no old input, check if there's back-button autofill that way
    // the variety is shown if the category has varieties
    if(Math.floor(selectedCategory) != selectedCategory || !($.isNumeric(selectedCategory))) {
      // If there's back button input
      if(Math.floor($("#product").val())== $("#product").val() && $.isNumeric($("#product").val())) {
        selectedCategory = $("#product").val();
      }
    }
    
    // If editing an existing product image
    @if($edit_page == true)
      @if($product_image['parent_id'] === 0)
        selectedVariety = 0;
        selectedCategory = {{ $product_image['category_id'] }}
      @else
        selectedVariety = {{ $product_image['category_id'] }}
        selectedCategory = {{ $product_image['parent_id'] }}
      @endif 
    @endif
    
  </script>
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')
  <h1>Add Product Image</h1>

  <a href="/admin_menu">Back to Admin Menu</a><br />
  <a href="/admin-product-image">Back to Product Image List</a><br />
  
  {{-- Create --}}
  @if(!$edit_page)
    {{ Form::open(array('url'=>'admin-product-image', 'method' => 'post', 'files' => true)) }} 
  {{-- Edit  --}}
  @else
    {{ Form::open(array('url'=>"admin-product-image/".$product_image['id'], 'method' => 'put', 'files' => true)) }} 
  @endif

    <!-- Product -->
    <div class="row">
      <div class="form-group">
        <label for="category_id" class="col-sm-3">Product <span class="req">*</span></label>
        <div class="col-sm-9">
          <select data-placeholder="Choose or Type a Product..." name="category_id" id="product" class="form-control chosen-select">
            <option value="0" disabled selected="selected">Choose or Type a Product...</option>
            @foreach($formOptions['productOptions'] as $key => $val)
            
              {{-- create page --}}
              @if(!$edit_page)
                <option value="{{{ $val['id'] }}}" @if(Input::old('category_id') == $val['id']) selected="selected" @endif>
                  {{{ $val['name']  }}}
                </option>
                
              {{-- edit page --}}
              @else
                <option value="{{{ $val['id'] }}}" 
                  @if($product_image['category_id'] == $val['id'] && $product_image['parent_id'] == 0)
                    selected="selected"
                  @elseif($product_image['parent_id'] == $val['id'] && $product_image['parent_id'] != 0)
                    selected="selected"
                  @endif >
                  {{{ $val['name']  }}}
                </option>
              @endif
              
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
    
    <!-- Colour -->
    <div class="row" id="colorRow">
      <div class="form-group">
        <label for="color_id" class="col-sm-3">Color <span class="req">*</span></label>
        <div class="col-sm-9">
          <select data-placeholder="Choose or Type a Colour..." name="colour_id" class="form-control chosen-select" id="color">
            <option value="" disabled selected>Choose or Type a Colour...</option>
            @foreach($formOptions['coloursOptions'] as $key => $val)
              @if(!$edit_page)
                <option value="{{{ $val['id'] }}}" @if(Input::old('colour_id') == $val['id']) selected="selected" @endif>
                  {{{ $val['name']  }}}
                </option>
              @else
                <option value="{{{ $val['id'] }}}" @if($product_image['colour_id'] == $val['id']) selected="selected" @endif>
                  {{{ $val['name']  }}}
                </option>
              @endif
            @endforeach
          </select>
        </div>
      </div>
    </div>

    {{-- Create page --}}
    @if(!$edit_page)
      <div class="row" id="imageRow">
        <div class="form-group">
          <label for="image" class="col-sm-3">Image File</label>
          <div class="col-sm-3">
            {{ Form::file('image') }}
          </div>
        </div>
      </div>
      
    {{-- Edit page --}}
    @else
      <!-- thumbnail -->
      <div class="row" id="imageRow">
        <div class="form-group">
          <label for="image" class="col-sm-3">Image File</label>
          <div class="col-sm-3">
            <img src="{{{ URL::asset('uplds/productimages/th-'.$product_image['filename']) }}}" />
          </div>
        </div>
      </div>
      <!-- new file -->
      <div class="row" id="imageRow">
        <div class="form-group">
          <label for="image" class="col-sm-3">New Image File</label>
          <div class="col-sm-3">
            {{ Form::file('image') }}
          </div>
        </div>
      </div>
    @endif
    
    <div class="row" id="submitRow">
      <div class="form-group col-sm-3">
        {{ Form::submit('Submit') }}
      </div>
    </div>
  {{ Form::close() }}
@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
	<script src="{{ URL::asset('js/chosen.jquery.min.js') }}"></script>
	<script src="{{ URL::asset('js/chosen.js') }}"></script>
	<script src="{{ URL::asset('js/admin-add-product-image.js') }}"></script>
@stop
    
