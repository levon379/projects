@extends('layouts.master')

{{-- Meta ca0nical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/create-edit-a-post" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/create-edit-a-post.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Create / Edit a Post | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- ----------------------------------------------------- --}}
{{-- JS Head   --}}
{{-- ----------------------------------------------------- --}}
@section('js_head')
  <script type="text/javascript">
    var showModalPopup = {{{ $showModalPopup or false }}};
  </script>
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<!-- Page Title -->
<h1>@lang('site_content.create_edit_a_post_Header')</h1>

<!-- menu icons -->
@include('create-edit-a-post.layouts.create-edit-a-post-icons')

<h2>@lang('site_content.create_edit_a_post_Active_Posts_Header')</h2>

<!-- "Wanted to Buy" table -->
<h3>@lang('site_content.create_edit_a_post_Post_To_Buy_Header')</h3>
<table class="buy">
  <thead>
    <tr>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Origin')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Product_Type')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Category_Variety')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Colour')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Packaging')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Qty_Price')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Posted_By')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Active_Bid')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Edit')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Delete')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Make_Favorite')</th>
    </tr>
  </thead>
  
  <tbody>
    @foreach($buyProduct as $bpKey => $bpVal)
      <!-- If Product has a bid, make it blink like a mad-man, and set to active class for jQuery selector -->
        @if($bpVal->active_bid_id)
          <tr class="active-row">
        @else
          <tr>
        @endif
          
        <!-- Product Images -->
        <td class="product-images">
          @include('create-edit-a-post.layouts.product-image')
        </td>

        <!-- Product Type -->
        <td>
          {{{ $bpVal->productType_name }}}
          <br />( Prod# {{{ $bpVal->id }}} )
          <br />( Bid# {{{ $bpVal->active_bid_id }}} )
        </td>

        <!-- Product/Variety -->
        <td>
          {{{ $bpVal->product_name }}}
          <br />
          @if($bpVal->variety_name != '') / {{{ $bpVal->variety_name }}}@endif
          @include('create-edit-a-post.layouts.place-of-origin-image')
        </td>
        
        <!-- Color -->
        <td>
          {{{ $bpVal->colour_name }}}
        </td>
        
        <!-- Packaging -->
        <td>
          @if($bpVal->isbulk == "1")
            @lang('site_content.create_edit_a_post_Product_Column_Bulk_Label')<br />
            {{{ $bpVal->bulk_weight.' '.$bpVal->bulk_weight_type_name.' / '.$bpVal->bulk_package_name }}}
          @else
            {{{ $bpVal->bulk_weight." ".$bpVal->bulk_weight_type_name." / ".$bpVal->bulk_package_name }}}<br />
            {{{ $bpVal->carton_pieces.' x '.$bpVal->carton_weight.' '.$bpVal->carton_weight_type_name.' / '.$bpVal->carton_package_name }}}
          @endif
        </td>
        
        <!-- Qty / Price -->
        <td>
          {{{ $bpVal->qty }}} / 
          <br />
          <span class="price">
          @lang('site_content.global_Currency_Symbol'){{{ $bpVal->price }}}
          </span>
        </td>
        
        <!-- Posted By-->
        <td>
          {{{ $bpVal->user }}}
        </td>

        <!-- Active Bid -->
        <td class="text-center td-icon">
          @if($bpVal->status_id==54) 
			  @if($bpVal->active_bid_id)
			  	<a href="/view-bid/{{{ $bpVal->active_bid_id }}}/view" class="table-link">
				<i class="fa fa-check fa-lg fa-green"></i><br />
				<span class="icon-text fa-green">@lang('site_content.create_edit_a_post_Product_Column_Active_Bid_Label')</span>
				</a>
			  @else
				<i class="fa fa-times fa-lg fa-green"></i><br />
				<span class="icon-text fa-green">@lang('site_content.create_edit_a_post_Product_Column_No_Bid_Label')</span>
			  @endif
		  @elseif($bpVal->status_id==79) 
			<i class="fa fa-smile-o fa-lg fa-green"></i><br />
			<span class="icon-text fa-green">@lang('site_content.create_edit_a_post_Product_Column_SoldOut_Product_Label')</span>
		  @else
			<i class="fa fa-exclamation fa-lg fa-green"></i><br />
			<span class="icon-text fa-green">@lang('site_content.create_edit_a_post_Product_Column_Inactive_Product_Label')</span>
		  @endif
        </td>        

        <!-- Edit -->
        <td class="text-center td-icon">
			@if(!$bpVal->active_bid_id && $bpVal->status_id<>79)
			  <a href="/post-to-buy/{{{ $bpVal->id }}}/edit" class="table-link">
				<i class="fa fa-pencil fa-lg fa-green"></i><br />
				<span class="icon-text">@lang('site_content.create_edit_a_post_Product_Column_Edit_Label')</span>
			  </a>
			@endif
        </td>

        <!-- Delete -->
        <td class="text-center td-icon">
			@if(!$bpVal->active_bid_id && $bpVal->status_id<>79)
			  <script type="text/javascript">$(document).ready(function() {$("#link{{$bpVal->id}}").popConfirm();});</script>
			  <a href="/post-to-buy/{{{ $bpVal->id }}}/delete" class="table-link" id='link{{$bpVal->id}}'>
				<i class="fa fa-trash-o fa-lg fa-green"></i><br />
				<span class="icon-text">@lang('site_content.create_edit_a_post_Product_Column_Delete_Label')</span>
			  </a>
			@endif
        </td>

        <!-- Make Favorite -->
        <td class="text-center td-icon">
          <a href="/post-to-buy/{{{ $bpVal->id }}}/favorite" class="table-link">
            <i class="fa fa-heart-o fa-lg fa-green"></i><br />
            <span class="icon-text">@lang('site_content.create_edit_a_post_Product_Column_Make_Favorite_Label')</span>
          </a>
        </td>

      </tr>
    @endforeach
  </tbody>
</table>

<!-- "For Sale" table -->
<h3>@lang('site_content.create_edit_a_post_Post_To_Sell_Header')</h3>
<table class="sell">
  <thead>
    <tr>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Origin')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Product_Type')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Category_Variety')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Colour')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Packaging')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Qty_Price')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Posted_By')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Active_Bid')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Edit')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Delete')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Make_Favorite')</th>
    </tr>
  </thead>
  
  <tbody>
    @foreach($sellProduct as $spKey => $spVal)
      <!-- If Product has a bid, make it blink like a mad-man, and set to active class for jQuery selector -->
      @if($spVal->active_bid_id)
        <tr class="active-row">
      @else
        <tr>
      @endif
      
        <!-- Place of Origin -->
        <td class="origin"> 
          @if($spVal->place_of_origin_image != '')
            <img src="{{ URL::asset('images/labels/'.$spVal->place_of_origin_image) }}" class="img-label" alt="{{{ str_replace(" ", "-", $spVal->place_of_origin_name) }}}" width="100" />
          @else
            <img src="{{ URL::asset('images/labels/no_image.png') }}" class="img-label" alt="No Image" width="100" />
          @endif
        </td>
        
        <!-- Product Type -->
        <td>
	      {{{ $spVal->productType_name }}} 
<br />( Prod# {{{ $spVal->id }}} )
<br />( Bid# {{{ $spVal->active_bid_id }}} )
        </td>
        
        <!-- Product -->
        <!-- / Variety -->
        <td> 
          {{{ $spVal->product_name }}}
          <br />
          {{{ $spVal->variety_name }}}
        </td>
        
        <!-- Colour -->
        <td> {{{ $spVal->colour_name }}} </td>
        
        <!-- Packaging -->
        <td>
          @if($spVal->isbulk == "1")
            @lang('site_content.create_edit_a_post_Product_Column_Bulk_Label')<br />
            {{{ $spVal->bulk_weight.' '.$spVal->bulk_weight_type_name.' / '.$spVal->bulk_package_name }}}
          @else
            {{{ $spVal->bulk_weight." ".$spVal->bulk_weight_type_name." / ".$spVal->bulk_package_name }}}<br />
            {{{ $spVal->carton_pieces.' x '.$spVal->carton_weight.' '.$spVal->carton_weight_type_name.' / '.$spVal->carton_package_name }}}
          @endif
        </td>
        
        <!-- Quantity -->
        <td>
          {{{ $spVal->qty }}} / 
          <br />
          <span class="price">
          @lang('site_content.global_Currency_Symbol'){{{ $spVal->price }}}
          </span>
        </td>
        
        <!-- Posted By-->
        <td> {{{ $spVal->user }}} </td>

        <!-- Active Bid -->
        <td class="text-center td-icon">
          @if($spVal->status_id==54) 
			  @if($spVal->active_bid_id)
			  	<a href="/view-bid/{{{ $spVal->active_bid_id }}}/view" class="table-link">
				<i class="fa fa-check fa-lg fa-red"></i><br />
				<span class="icon-text fa-red">@lang('site_content.create_edit_a_post_Product_Column_Active_Bid_Label')</span>
				</a>
			  @else
				<i class="fa fa-times fa-lg fa-red"></i><br />
				<span class="icon-text fa-red">@lang('site_content.create_edit_a_post_Product_Column_No_Bid_Label')</span>
			  @endif
		  @elseif($spVal->status_id==79) 
			<i class="fa fa-smile-o fa-lg fa-green"></i><br />
			<span class="icon-text fa-green">@lang('site_content.create_edit_a_post_Product_Column_SoldOut_Product_Label')</span>
		  @else
			<i class="fa fa-exclamation fa-lg fa-red"></i><br />
			<span class="icon-text fa-red">@lang('site_content.create_edit_a_post_Product_Column_Inactive_Product_Label')</span>
		  @endif
        </td>        
               
        <!-- Edit -->
        <td class="text-center td-icon">
			@if(!$spVal->active_bid_id && $spVal->status_id<>79)
			  <a href="/post-to-sell/{{{ $spVal->id }}}/edit" class="table-link">
				<i class="fa fa-pencil fa-lg fa-red"></i><br />
				<span class="icon-text">@lang('site_content.create_edit_a_post_Product_Column_Edit_Label')</span>
			  </a>
			@endif
        </td>

        <!-- Delete -->
        <td class="text-center td-icon">
			@if(!$spVal->active_bid_id && $spVal->status_id<>79)
			  <script type="text/javascript">$(document).ready(function() {$("#link{{$spVal->id}}").popConfirm();});</script>
			  <a href="/post-to-sell/{{{ $spVal->id }}}/delete" class="table-link" id='link{{$spVal->id}}'>
				<i class="fa fa-trash-o fa fa-lg fa-red"></i><br />
				<span class="icon-text">@lang('site_content.create_edit_a_post_Product_Column_Delete_Label')</span>
			  </a>
			@endif
        </td>

        <!-- Make Favorite -->
        <td class="text-center td-icon">
          <a href="/post-to-sell/{{{ $spVal->id }}}/favorite" class="table-link">
            <i class="fa fa-heart-o fa-lg fa-red"></i><br />
            <span class="icon-text">@lang('site_content.create_edit_a_post_Product_Column_Make_Favorite_Label')</span>
          </a>
        </td>
          
      </tr>
    @endforeach
  </tbody>
</table>


@stop {{-- content --}}
    

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
  <script src="js/create-edit-a-post.js"></script>
@stop

