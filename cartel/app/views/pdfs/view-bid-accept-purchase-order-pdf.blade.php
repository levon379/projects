@extends('layouts.master-pdf')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/view-bid" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/view-a-bid.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Email Testing | Cartel Marketing Inc. | Leamington, Ontario
@stop6

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

@if(Config::get('mail.pretend'))
	<?php
	$pageData=$viewData['pageData'];
	$orderInfo=$viewData['orderInfo'];
	$viewInfo=$viewData['viewInfo'];
	?>
@else
	<?php 
	$pageData=$viewData['pageData'];
	$orderInfo=$viewData['orderInfo'];
	$viewInfo=$viewData['viewInfo'];
	?>
@endif     
            

<div style='width:730px'>
<table width='100%' border='0'>
  <tr>
    <td align='left' valign='top'>
    	<img src='{{ public_path('images/cartel-logo.png') }}' width='285'>
    </td>
    <td valign='top' align='right'>
		<b>Date: {{{ $orderInfo->created_at }}}<BR>
		<font size='3'>{{{ $viewInfo['titleLabel'] }}} PURCHASE ORDER</font><BR>
		<font size='3'>Order#: {{{ $orderInfo->accounting_number_display }}}</font></b>
    </td>
  </tr>
</table>
<BR>
<table width='100%' border='0' cellpadding='2' cellspacing='2'>
  <tr bgcolor='#f4cecd'>
    <td width='50%'> <b>Purchased From:</b></td>
    <td width='50%'> <b>Salesman:</b></td>
  </tr>
  <tr>
    <td width='50%'>
    	{{{ $orderInfo->sellerInfo->companyInfo->name }}}<BR>
		{{{ $orderInfo->sellerInfo->companyInfo->address.' '.$orderInfo->sellerInfo->companyInfo->address2 }}}<BR>
		{{{ $orderInfo->sellerInfo->companyInfo->city.', '.$orderInfo->sellerInfo->companyInfo->province_name.', '.$orderInfo->sellerInfo->companyInfo->postal_code }}}, {{{ $orderInfo->sellerInfo->companyInfo->country_name }}}
    </td>
    <td width='50%'>
    	{{{ $orderInfo->sellerInfo->name }}}<BR>
	    Phone: {{{ $orderInfo->sellerInfo->office_phone }}}<BR>
	    Email: {{{ $orderInfo->sellerInfo->email }}}
    </td>
  </tr>
  <tr bgcolor='#f4cecd'>
    <td width='50%'><b>Shipped From:</b></td>
    <td width='50%'><b> Contact:</b></td>
  </tr>
  <tr>
    <td width='50%'>
    	{{{ $orderInfo->sellerInfo->pickupAddress->company }}}<BR>
    	{{{ $orderInfo->sellerInfo->pickupAddress->address.' '.$orderInfo->sellerInfo->pickupAddress->address2 }}}<BR>
    	{{{ $orderInfo->sellerInfo->pickupAddress->city.', '.$orderInfo->sellerInfo->companyInfo->province_name.', '.$orderInfo->sellerInfo->companyInfo->postal_code }}}, {{{ $orderInfo->sellerInfo->companyInfo->country_name }}}
    </td>
    <td width='50%'>
    	Shipping Dept<BR>
    	Phone: {{{ $orderInfo->sellerInfo->companyInfo->phone }}}<BR>
	    Email: {{{ $orderInfo->sellerInfo->companyInfo->shipping_email }}}
    </td>
  </tr>
</table>		
<br><table width='100%' border='0'>
  <tr bgcolor='#f4cecd'>
    <td width='10%'><b>Qty</b></td>
    <td width='43%'><b> Product</b></td>
    <td width='15%' ALIGN=right><b> Price </b></td>
    <td width='15%' ALIGN=right><b> Tax </b></td>
    <td width='17%' ALIGN=right><b>Total</b></td>
  </tr>
  <tr>
    <td  bgcolor='#fae7e6' ALIGN=center>{{{ $orderInfo->chargeable_qty }}}</td>
    <td bgcolor='#fae7e6'>{{{ $orderInfo->bidInfo->productType_name.' - '.$orderInfo->bidInfo->product_name }}}
    @if($orderInfo->bidInfo->variety_name<>'')
    	{{{ ' - '.$orderInfo->bidInfo->variety_name }}}
    @endif
    </td>
	@if($viewInfo['showPricing'])    
		<td bgcolor='#fae7e6' ALIGN=right>${{ Util::makeMoney($orderInfo->bidInfo->price) }}</td>
		<td bgcolor='#fae7e6' ALIGN=right>
		@if($orderInfo->taxes->tax_product )
			{{{ $orderInfo->taxes->rate }}}%
		@else
			0%
		@endif
		</td>
		<td bgcolor='#fae7e6' ALIGN=right>${{ Util::makeMoney($orderInfo->product_amount) }}</td>
	@else
		<td bgcolor='#fae7e6' ALIGN=right>---&nbsp;</td>
		<td bgcolor='#fae7e6' ALIGN=right>---&nbsp;</td>
		<td bgcolor='#fae7e6' ALIGN=right>---&nbsp;</td>
	@endif
  </tr>


	
	@if($viewInfo['showMiscCharges'])
		<?php /*    --- We`ll eventually loop some rows for Misc Charges
		  <tr>
			@if($viewInfo['showMiscCharges'])    
				<td bgcolor='#fae7e6' ALIGN=center>1</td>
				<td bgcolor='#fae7e6'>charge desciption</td>
				<td bgcolor='#fae7e6' ALIGN=right>Util::makeMoney(amount)</td>
				<td bgcolor='#fae7e6' ALIGN=right>GST_rate%</td>
				<td bgcolor='#fae7e6' ALIGN=right>$line amount</td>
			@elseif
				<td bgcolor='#fae7e6' ALIGN=right>---&nbsp;</td>
				<td bgcolor='#fae7e6' ALIGN=right>---&nbsp;</td>
				<td bgcolor='#fae7e6' ALIGN=right>---&nbsp;</td>
				<td bgcolor='#fae7e6' ALIGN=right>---&nbsp;</td>
				<td bgcolor='#fae7e6' ALIGN=right>---&nbsp;</td>
			@endif
		  </tr>
		*/  ?>
	@endif

  <tr>
    <td>&nbsp;</td>
    <td>Freight &amp; Brokerage
		@if($viewInfo['showBrokerageValues'])
			({{{ $orderInfo->brokerageInfo->display }}})
		@endif
    </td>
    <td>&nbsp;</td>
    <td align='right'>13%</td>
    <td bgcolor='#fae7e6' ALIGN=right>
		@if($viewInfo['showBrokerageValues'])
			${{ Util::makeMoney($orderInfo->po_brokerage_amount) }}
		@else
			$ TBD
		@endif
	</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td>Total Taxes</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor='#fae7e6' ALIGN=right>
		@if($viewInfo['showPricing'])
			${{ Util::makeMoney($orderInfo->po_total_taxes) }}
		@else
			$ TBD
		@endif
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> <b>TOTAL</b></td>
    <td bgcolor='#fae7e6' ALIGN=right>
		@if($viewInfo['showPricing'])
			${{ Util::makeMoney($orderInfo->po_grand_total) }}
		@else
			$ TBD
		@endif
    </td>
  </tr>
</table>
<table width='100%' border='0'>
  <tr bgcolor='#f4cecd'>
    <td colspan=4>
      <div align='left'><b>Product Details:</b></div>
    </td>
  </tr>
  <tr bgcolor='#fae7e6'>
    <td width='20%'><div align='right'><b>Origin:</b></div></td>
    <td width='30%'> {{{ $orderInfo->bidInfo->place_of_origin_name }}}</td>
    <td width='20%'><div align='right'><b>Bulk:</b></div></td>
    <td width='30%'> {{{ $orderInfo->bidInfo->isbulk }}}</td>
  </tr>
  <tr bgcolor='#fae7e6'>
    <td><div align='right'><b>Maturity:</b></div></td>
    <td> {{{ $orderInfo->bidInfo->maturity_name }}}</td>
    <td width='10%'><div align='right'><b>Weight / {{{ $orderInfo->bidInfo->bulk_weight_type_name }}}:</b></div></td>
    <td width='40%'> {{{ $orderInfo->bidInfo->bulk_weight." ".$orderInfo->bidInfo->bulk_package_name }}}</td>
  </tr>
  <tr bgcolor='#fae7e6'>
    <td><div align='right'><b>Colour:</b></div></td>
    <td> {{{ $orderInfo->bidInfo->colour_name }}}</td>
    <td width='10%'><div align='right'><b>PCs or PKGs:</b></div></td>
    <td width='40%'> {{{ $orderInfo->bidInfo->carton_pieces }}}</td>
  </tr>
  <tr bgcolor='#fae7e6'>
    <td><div align='right'><b>Quality:</b></div></td>
    <td> {{{ $orderInfo->bidInfo->quality_name }}}</td>
    <td width='10%'><div align='right'><b>Weight / {{{ $orderInfo->bidInfo->carton_package_name }}}:</b></div></td>
    <td width='40%'> {{{ $orderInfo->bidInfo->carton_weight." ".$orderInfo->bidInfo->carton_weight_type_name }}}</td>
  </tr>
  <tr bgcolor='#fae7e6'>
    <td><div align='right'><b>Availability:</b></div></td>
    <td colspan=3> {{{ $orderInfo->bidInfo->availability_date }}} between {{{ $orderInfo->bidInfo->availability_start }}} and {{{ $orderInfo->bidInfo->availability_end }}}</FONT></td>
  </tr>
  <tr bgcolor='#fae7e6'>
    <td><div align='right'><b>Comments:</b></div></td>
    <td colspan=3> {{{ $orderInfo->bidInfo->description }}} </td>
  </tr>
  <tr bgcolor='#fae7e6'>
    <td><div align='right'><b>Customer PO:</b></div></td>
    <td colspan=3> {{{ $orderInfo->customerPO }}} <BR> {{{ $orderInfo->customerPO_comments }}}</td>
  </tr>
</table>

@if(!$viewInfo['showBrokerageValues'])
	I have accurately prepared the above product for shipment.<BR><BR>
	<table width='100%' cellpadding='0' cellspacing='0' border='0'>
	  <tr>
		<td width='20%' height='2' COLSPAN='2'><b>Qty Shipped:<BR><BR>______________</b></td>
		<td width='40%'>&nbsp;<b>Shipper's Signature:<BR><BR> _____________________________</b></td>
		<td width='40%'>&nbsp;<b>Print Name:<BR><BR> _____________________________</b></td>
	  </tr>
	</table>
	<BR><p><b>Please attach a signed copy of this Purchase Order to your Bill of Lading.</b></p>
@endif

<p align='center'>__________________________________________________________</p>
<div align='center'><b>Phone: {{{ $pageData['companyPhone'] }}} * Fax: {{{ $pageData['companyFax'] }}}</b><BR>
<b>{{{ $pageData['companyAddress'] }}} * {{{ $pageData['companyCity'] }}}, {{{ $pageData['companyProvince'] }}} * {{{ $pageData['companyPostal'] }}}
<BR><A HREF='mailto:{{{ $pageData['companyEmail'] }}}'>{{{ $pageData['companyEmail'] }}}</A>
</b></div>
</div>

@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@stop
    
