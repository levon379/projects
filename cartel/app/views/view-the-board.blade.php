@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/view-the-board" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
  <style>
  </style>
	<link rel="stylesheet" href="css/view-the-board.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  View The Board | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- ----------------------------------------------------- --}}
{{-- JS Head   --}}
{{-- ----------------------------------------------------- --}}
@section('js_head')
  <!-- PHP arrays to Javascript arrays -->
  <script type="text/javascript">
    var showModalPopup = {{{ $showModalPopup or false }}};
  </script>
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')
<div class="board">
  <div class="leftcontent">
    {{-- ----------------------------------------------------------------- --}}
    {{-- Left Side "Jump" icon links --}}
    {{-- ----------------------------------------------------------------- --}}
    <section class="left">
      @foreach ($boardProductTypes as $pt_key=>$pt_value) 
        <div class="icongroup"> 
          <div class="icontext">{{{ $pt_value->name }}}</div>
          <a class="{{{ $pt_value->jump_link }}}" title="{{{ $pt_value->name }}}" data-toggle="tooltip" data-placement="top">
            <img class="{{{ $pt_value->jump_link }}} icon" src="{{{ URL::asset('images/icons/'.$pt_value->jump_link.'.png') }}}" alt="{{{ $pt_value->jump_link }}}" />
          </a>
        </div> 
      @endforeach
    </section> 
    
    <div class="bid-to-buy">
    
      {{-- ----------------------------------------------------------------- --}}
      {{-- Bid to Buy Header --}}
      {{-- ----------------------------------------------------------------- --}}
      <h2 class="heading">Bid to Buy (Supply)</h2>
      <div id="buyscroll">
        <?php $color = current($bgcolor); // Get the first bgcolor ?>
        
        @foreach ($buyProducts as $key => $category)
        
          <!-- Category jump anchor -->
          <a id="{{ $key }}-buytarget"></a>
          
          <!-- ======================================================= -->
          <!-- No Results Board listing row -->
          <!-- ======================================================= -->
          @if($buyProducts[$key]==0)
            <div class="panel panel-default" style="background-color:{{{ $color }}}">
              <div class="panel-body row blank-row">
                <p class="empty-board-listing">
                  @lang('site_content.view_the_board_Empty_Buy_Category', array('product_type_name'=>$boardProductTypes[$key]->name))
                </p>
              </div>
            </div>
          
          <!-- ======================================================= -->
          <!-- Board listing row -->
          <!-- ======================================================= -->
          @else
            @foreach ($category as $product)
              <?php 
                /* Check if product is listed from the current user's company,
                -users can't bid on their own company's product */
                $panel_class="";
                $mycompany = false;
                if($product->user_company_id == $userInfo->company_id){
                  $panel_class= "mycompany";
                  $mycompany = true;
                }
              ?>
                
              <div class="panel panel-default board-listing {{{ $panel_class }}}" 
                   data-url="bid-to-buy/{{{ $product->id }}}/bid" 
                   style="background-color: @if($bgcolor[$product->productType_name])  
                                              {{{ $bgcolor[$product->productType_name] }}} 
                                            @else 
                                              #fff 
                                            @endif">
                <div class="{{ $panel_class or "" }} panel-body row">
                
                  <!-- ----------------------------------------------------- -->
                  <!-- col 1 -->
                  <!-- ----------------------------------------------------- -->
                  <div class="product-col1">
                    @if($product->product_image_filename != "")
                      <img src="/uplds/productimages/th-{{{ $product->product_image_filename }}}" />
                    @else
                      <img src="/images/labels/no_image.png" class="big-no-image"/>
                    @endif
                  </div>
                  
                  <!-- ----------------------------------------------------- -->
                  <!-- col 2 -->
                  <!-- ----------------------------------------------------- -->
                  <div class="product-col2">
                    <h4><strong>{{{ $product->product_name }}}</strong></h4>
                    <p class="product-variety">
                      @if(trim($product->variety_name) != '')
                        {{{ '('.$product->variety_name.')' }}}
                      @endif
                    </p>
                    @if($mycompany)
                      <p class="your-sell">Your Post to Sell</p>
                    @endif
                    @if($product->place_of_origin_image != '')
                      <img src="images/labels/{{{ $product->place_of_origin_image }}}" 
                           alt="{{{ $product->place_of_origin_name }}}" 
                           title="{{{ $product->place_of_origin_name }}}" 
                           class="origin" 
                           width="112" 
                           height="65" />
                    @endif
                    
                    <p class="packaging">
                      @if($product->isbulk == "1")
                        {{{ $product->bulk_weight.' '.$product->bulk_weight_type_name.' / '.$product->bulk_package_name }}}
                      @else
                        {{{ $product->bulk_weight." ".$product->bulk_weight_type_name." / ".$product->bulk_package_name }}}
                      @endif
                    </p>
                  </div>
                  
                  <!-- ----------------------------------------------------- -->
                  <!-- col 3 -->
                  <!-- ----------------------------------------------------- -->
                  <div class="product-col3">
                    <p class="product-colour">{{{ $product->colour_name }}}</p>
                    <p class="packaging">
                      @if($product->isbulk == "1")
                      @else
                        {{{ $product->carton_pieces.' x '.$product->carton_weight.' '.$product->carton_weight_type_name.' / '.$product->carton_package_name }}}
                      @endif
                    </p>
                  </div>
                  
                  <!-- ----------------------------------------------------- -->
                  <!-- col 4 -->
                  <!-- ----------------------------------------------------- -->
                  <div class="product-col4">
                    @if($product->active_bid_id)
                      <p class="has-bid">Item has a bid!</p>
                    @else
                      @if($product->status_id==79)
                        <div class="solddiv"><p class="sold">{Sold}</p></div>
                      @else
                        <p class="qty">{{{ $product->qty }}}</p>
                        <p class="price">${{{ $product->price }}}</p>
                      @endif
                    @endif
                  </div>
                </div> <!-- row -->
              </div> <!-- panel -->
              <!-- ======================================================= -->
            @endforeach
          @endif
          <?php $color = next($bgcolor); // Advance to the next bgcolor ?>
        @endforeach
        <?php reset($bgcolor);  // Reset to the first bg color?>
      </div> <!-- Scroll div -->
    </div>
  </div><!-- left content-->


<!-- left -->
{{-- ====================================================================== --}}
{{-- ====================================================================== --}}
{{-- ====================================================================== --}}
<!-- right -->

  <div class="rightcontent">
  
    {{-- ----------------------------------------------------------------- --}}
    {{-- Left Side "Jump" icon links --}}
    {{-- ----------------------------------------------------------------- --}}
    <section class="right">
      @foreach ($boardProductTypes as $pt_key=>$pt_value) 
        <div class="icongroup"> 
          <div class="icontext">{{{ $pt_value->name }}}</div>
          <a class="{{{ $pt_value->jump_link }}}" title="{{{ $pt_value->name }}}">
            <img class="{{{ $pt_value->jump_link }}} icon" src="{{{ URL::asset('images/icons/'.$pt_value->jump_link.'.png') }}}" alt="{{{ $pt_value->jump_link }}}" />
          </a>
        </div>
      @endforeach
    </section> <!-- right -->

    {{-- ----------------------------------------------------------------- --}}
    {{-- bid to sell listings --}}
    {{-- ----------------------------------------------------------------- --}}
    <div class="bid-to-sell">
      <h2 class="heading">Bid to Sell (Demand)</h2>
      
      <div id="sellscroll">
      
        <?php $color = current($bgcolor); // Get the first bgcolor ?>
        
        <!-- ======================================================= -->
        <!-- No Results Board listing row -->
        <!-- ======================================================= -->
        @foreach ($sellProducts as $key => $category)
          <a id="{{ $key  }}-selltarget"></a>
          @if($sellProducts[$key]==0)
            <div class="panel panel-default" style="background-color:{{{ $color }}}">
              <div class="panel-body row blank-row">
                <p class="empty-board-listing">
                  @lang('site_content.view_the_board_Empty_Sell_Category', array('product_type_name'=>$boardProductTypes[$key]->name))
                </p>
              </div><!-- row -->
            </div><!-- panel -->
          @else
            @foreach ($category as $product)
              <?php 
                $panel_class="";
                $mycompany = false;
                if( $product->address->company_id == $userInfo->company_id ) {
                  $panel_class= "mycompany";
                  $mycompany = true;
                } ?>
              
              <!-- ================= -->
              <!-- Board listing row -->
              <!-- ================= -->
              <div class="panel panel-default board-listing {{{ $panel_class }}}" data-url="bid-to-sell/{{{ $product->id }}}/bid" style="background-color: @if($bgcolor[$product->productType_name])  {{{ $bgcolor[$product->productType_name] }}} @else #fff @endif">
                <div class="{{ $panel_class or "" }} panel-body row">
                
                  <!-- ----------------------------------------------------- -->
                  <!-- col 1 -->
                  <!-- ----------------------------------------------------- -->
                  <div class="product-col1">
                    @if($product->product_image_filename != "")
                      <img src="/uplds/productimages/th-{{{ $product->product_image_filename }}}" />
                    @else
                      <img src="/images/labels/no_image.png" class="big-no-image"/>
                    @endif
                  </div>
                  
                  <!-- ----------------------------------------------------- -->
                  <!-- col 2 -->
                  <!-- ----------------------------------------------------- -->
                  <div class="product-col2">
                    <h4><strong>{{{ $product->product_name }}}</strong></h4>
                    <p class="product-variety">
                      @if(trim($product->variety_name) != '')
                        {{{ trim('('.$product->variety_name.')') }}}
                      @endif
                    </p>
                    @if($mycompany)
                      <p class="your-buy">Your Post to Buy</p>
                    @endif
                    @if($product->place_of_origin_image != '')
                      <img src="images/labels/{{{ $product->place_of_origin_image }}}" alt="{{{ $product->place_of_origin_name }}}" title="{{{ $product->place_of_origin_name }}}" class="origin" width="112" height="65">
                    @endif
                    
                    <p class="packaging">
                      @if($product->isbulk == "1")
                        {{{ $product->bulk_weight.' '.$product->bulk_weight_type_name.' / '.$product->bulk_package_name }}}
                      @else
                        {{{ $product->bulk_weight." ".$product->bulk_weight_type_name." / ".$product->bulk_package_name }}}
                      @endif
                    </p>
                  </div>
                  
                  <!-- ----------------------------------------------------- -->
                  <!-- col 3 -->
                  <!-- ----------------------------------------------------- -->
                  <div class="product-col3">
                    <p class="product-colour">{{{ $product->colour_name }}}</p>
                    <p class="packaging">
                      @if($product->isbulk == "1")
                      @else
                        {{{ $product->carton_pieces.' x '.$product->carton_weight.' '.$product->carton_weight_type_name.' / '.$product->carton_package_name }}}
                      @endif
                    </p>
                  </div>
                  
                  <!-- ----------------------------------------------------- -->
                  <!-- col 4 -->
                  <!-- ----------------------------------------------------- -->
                  <div class="product-col4">
                    @if($product->active_bid_id)
                      <p class="has-bid"><br>Item has a bid!</p>
                    @else
                      @if($product->status_id==79)
                        <div class="solddiv"><p class="sold">{Sold}</p></div>
                      @else 
                        <p class="qty">{{{ $product->qty }}}</p>
                        <p class="price">${{{ $product->price }}}</p>
                      @endif
                    @endif
                  </div>
                </div> <!-- row -->
              </div><!-- panel -->
            @endforeach
          @endif
          <?php $color = next($bgcolor); // Advance to the next bgcolor ?>
        @endforeach
        <?php reset($bgcolor);  // Reset to the first bg color ?>
      </div> <!-- scroll -->
    </div>
  </div> <!-- right content -->
</div>
@stop {{-- content --}}


{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
	<script src="js/view-the-board.js"></script>
@stop
