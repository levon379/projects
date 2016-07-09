@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/other-postings" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/create-edit-a-post.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Other Postings | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<!-- Page Title -->
<h1>@lang('site_content.create_edit_a_post_Header')</h1>

<!-- menu icons -->
@include('create-edit-a-post.layouts.create-edit-a-post-icons')
            
<a name="favorite-postings"></a>
<h2>@lang('site_content.create_edit_a_post_Favorite_Posts_Header')</h2>

<!-- "Wanted to Buy" table -->
<h3>@lang('site_content.create_edit_a_post_Post_To_Buy_Header')</h3>
<table class="table buy">
  <thead>
    <tr>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Origin')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Product_Type')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Category_Variety')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Colour')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Packaging')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Qty_Price')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Posted_By')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Repost_Product')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Delete')</th>
    </tr>
  </thead>
  
  <tbody>
    @foreach($buyFavoriteProduct as $bpKey => $bpVal)
		<tr>
          
        <!-- Prodct images -->
        <td class="product-images">
          @include('create-edit-a-post.layouts.product-image')
        </td>

        <!-- Product Type -->
        <td>
          {{{ $bpVal->productType_name }}}
        </td>

        <!-- Product/Variety -->
        <td>
          {{{ $bpVal->product_name }}}
          <br>
          @if($bpVal->variety_name != '') / {{{ $bpVal->variety_name }}}@endif
          @include('create-edit-a-post.layouts.place-of-origin-image')
        </td>
        </td>
        
        <!-- Color -->
        <td>
          {{{ $bpVal->colour_name }}}
        </td>
        
        <!-- Packaging -->
        <td>
          @if($bpVal->isbulk == "1")
            @lang('site_content.create_edit_a_post_Product_Column_Bulk_Label')<br>
            {{{ $bpVal->bulk_weight.' '.$bpVal->bulk_weight_type_name.' / '.$bpVal->bulk_package_name }}}
          @else
            {{{ $bpVal->bulk_weight." ".$bpVal->bulk_weight_type_name." / ".$bpVal->bulk_package_name }}}<br />
            {{{ $bpVal->carton_pieces.' x '.$bpVal->carton_weight.' '.$bpVal->carton_weight_type_name.' / '.$bpVal->carton_package_name }}}
          @endif
        </td>
        
        <!-- Qty / Price -->
        <td>
          {{{ $bpVal->qty }}} / 
          <br>
          <span class="price">
          @lang('site_content.global_Currency_Symbol'){{{ $bpVal->price }}}
          </span>
        </td>
        
        <!-- Posted By-->
        <td>
          {{{ $bpVal->user }}}
        </td>

        <!-- Repost Product -->
        <td class="text-center td-icon">
          <a href="/post-to-buy/{{{ $bpVal->id }}}/repost" class="table-link">
            <i class="fa fa-recycle fa-lg fa-green"></i><br>
            <span class="icon-text">@lang('site_content.create_edit_a_post_Product_Column_Repost_Label')</span>
          </a>
        </td>
      
        <!-- Delete -->
        <td class="text-center td-icon">
          <script type="text/javascript">$(document).ready(function() {$("#link{{$bpVal->id}}").popConfirm();});</script>
          <a href="/post-to-buy/{{{ $bpVal->id }}}/delete" class="table-link" id='link{{$bpVal->id}}'>
            <i class="fa fa-trash-o fa-lg fa-green"></i><br>
            <span class="icon-text">@lang('site_content.create_edit_a_post_Product_Column_Delete_Label')</span>
          </a>
        </td>

      </tr>
    @endforeach
  </tbody>
</table>

<!-- "For Sale" table -->
<h3>@lang('site_content.create_edit_a_post_Post_To_Sell_Header')</h3>
<table class="table sell">
  <thead>
    <tr>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Origin')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Product_Type')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Category_Variety')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Colour')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Packaging')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Qty_Price')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Posted_By')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Repost_Product')</th>
      <th>@lang('site_content.create_edit_a_post_Product_Column_Header_Delete')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($sellFavoriteProduct as $spKey => $spVal)
		<tr>
      
        <!-- Place of Origin -->
        <td> 
          @if($spVal->place_of_origin_image != '')
            <img src="{{ URL::asset('images/labels/'.$spVal->place_of_origin_image) }}" class="img-label" alt="{{{ str_replace(" ", "-", $spVal->place_of_origin_name) }}}" width="100" />
          @else
            <img src="{{ URL::asset('images/labels/no_image.png') }}" class="img-label" alt="No Image" width="100" />
          @endif
        </td>
        
        <!-- Product Type -->
        <td> {{{ $spVal->productType_name }}} </td>
        
        <!-- Product -->
        <!-- / Variety -->
        <td> 
          {{{ $spVal->product_name }}}
          <br>
          @if($spVal->variety_name<>'') / {{{ $spVal->variety_name }}}@endif
        </td>
        
        <!-- Colour -->
        <td> {{{ $spVal->colour_name }}} </td>
        
        <!-- Packaging -->
        <td>
          @if($spVal->isbulk == "1")
            @lang('site_content.create_edit_a_post_Product_Column_Bulk_Label')<br>
            {{{ $spVal->bulk_weight.' '.$spVal->bulk_weight_type_name.' / '.$spVal->bulk_package_name }}}
          @else
            {{{ $spVal->bulk_weight." ".$spVal->bulk_weight_type_name." / ".$spVal->bulk_package_name }}}<br />
            {{{ $spVal->carton_pieces.' x '.$spVal->carton_weight.' '.$spVal->carton_weight_type_name.' / '.$spVal->carton_package_name }}}
          @endif
        </td>
        
        <!-- Quantity -->
        <td>
          {{{ $spVal->qty }}} / 
          <br>
          <span class="price">
          @lang('site_content.global_Currency_Symbol'){{{ $spVal->price }}}
          </span>
        </td>
        
        <!-- Posted By-->
        <td> {{{ $spVal->user }}} </td>
        
        <!-- Repost Product -->
        <td class="text-center td-icon">
          <a href="/post-to-sell/{{{ $spVal->id }}}/repost" class="table-link">
            <i class="fa fa-recycle fa-lg fa-red"></i><br>
            <span class="icon-text">@lang('site_content.create_edit_a_post_Product_Column_Repost_Label')</span>
          </a>
        </td>

        <!-- Delete -->
        <td class="text-center td-icon">
		  <script type="text/javascript">$(document).ready(function() {$("#link{{$spVal->id}}").popConfirm();});</script>
		  <a href="/post-to-sell/{{{ $spVal->id }}}/delete" class="table-link" id='link{{$spVal->id}}'>
            <i class="fa fa-trash-o fa-lg fa-green"></i><br>
            <span class="icon-text">@lang('site_content.create_edit_a_post_Product_Column_Delete_Label')</span>
          </a>
        </td>   
          
      </tr>
    @endforeach
  </tbody>
</table>


@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
    
