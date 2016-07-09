@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/admin-category" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/admin.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
 {{{$adminVars['adminWordCap']}}} Administration | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<h1>{{{$adminVars['adminWordCap']}}} Administration</h1>

@if($view=='show')

 	<div class="row SectionHeader">
 		<div class="col-md-4">
			<b>Order#:</b> {{{ $orderInfo->accounting_number_display }}}<BR>
		 </div>
 		<div class="col-md-4">
			<b>Bid to {{ ucfirst($orderInfo->bid_type) }}</b>
		 </div>
 		<div class="col-md-4">
			<b>Date:</b> {{{ $orderInfo->created_at }}}
		</div>
 	</div>
 	<div class="row SpacerRow">&nbsp;
 	</div>

 	<div class="row" SectionHeader>
 		<div class="col-md-2">
			<b>Posting Details</b>
		 </div>
 		<div class="col-md-10">
			(posted by {{{ $orderInfo->originalPosterInfo['companyInfo']['name'] }}} - <A HREF="mailto:{{{ $orderInfo->originalPosterInfo['email'] }}}">{{{ $orderInfo->originalPosterInfo['name'] }}}</A>)
		 </div>
	</div>
 	<div class="row">
 		<div class="col-md-2">
			<b>Qty:</b><BR>
			<b>Min Qty:</b><BR>
			<b>Price:</b><BR>
			<b>Product Type:</b><BR>
			<b>Product:</b><BR>
		</div>
 		<div class="col-md-4">
			{{{ $orderInfo->productInfo->qty}}}<BR>
			{{{ $orderInfo->productInfo->minqty}}}<BR>
			${{{ Util::makeMoney($orderInfo->productInfo->price)}}}<BR>
			{{{ $orderInfo->productInfo->productType_name}}}<BR>
			{{{ $orderInfo->productInfo->product_name }}}
				@if($orderInfo->productInfo->variety_name<>'')
					{{{ ' - '.$orderInfo->productInfo->variety_name }}}
				@endif <BR>
			<BR>
		</div>
 		<div class="col-md-2">
			<b>Origin:</b><BR>
			<b>Maturity:</b><BR>
			<b>Colour:</b><BR>
			<b>Quality:</b><BR>
			<b>Availability:</b><BR>
			<b>Description:</b><BR>
		 </div>
 		<div class="col-md-4">
			{{{ $orderInfo->productInfo->place_of_origin_name }}}<BR>
			{{{ $orderInfo->productInfo->maturity_name }}}<BR>
			{{{ $orderInfo->productInfo->colour_name }}}<BR>
			{{{ $orderInfo->productInfo->quality_name }}}<BR>
			{{{ $orderInfo->productInfo->availability_date }}} - {{{ $orderInfo->productInfo->availability_start }}}-{{{ $orderInfo->productInfo->availability_end }}}<BR>
			{{{ $orderInfo->productInfo->description }}}<BR>
		</div>
	</div>

 	<div class="row" SectionHeader>
 		<div class="col-md-12">
			<b>Bid Details</b>
		 </div>
	</div>
 	<div class="row">
 		<div class="col-md-2">
			<b>Qty:</b><BR>
			<b>Price:</b><BR>
			<b>Product Type:</b><BR>
			<b>Product:</b><BR>
		</div>
 		<div class="col-md-4">
			{{{ $orderInfo->bidInfo->qty}}}<BR>
			${{{ Util::makeMoney($orderInfo->bidInfo->price)}}}<BR>
			<BR>
			{{{ $orderInfo->bidInfo->productType_name}}}<BR>
			{{{ $orderInfo->bidInfo->product_name }}}
				@if($orderInfo->bidInfo->variety_name<>'')
					{{{ ' - '.$orderInfo->bidInfo->variety_name }}}
				@endif <BR>
		</div>
 		<div class="col-md-2">
			<b>Origin:</b><BR>
			<b>Maturity:</b><BR>
			<b>Colour:</b><BR>
			<b>Quality:</b><BR>
			<b>Availability:</b><BR>
			<b>Description:</b><BR>
		 </div>
 		<div class="col-md-4">
			{{{ $orderInfo->bidInfo->place_of_origin_name }}}<BR>
			{{{ $orderInfo->bidInfo->maturity_name }}}<BR>
			{{{ $orderInfo->bidInfo->colour_name }}}<BR>
			{{{ $orderInfo->bidInfo->quality_name }}}<BR>
			{{{ $orderInfo->bidInfo->availability_date }}} - {{{ $orderInfo->bidInfo->availability_start }}}-{{{ $orderInfo->bidInfo->availability_end }}}<BR>
			{{{ $orderInfo->bidInfo->description }}}<BR>
		</div>
	</div>
 	<div class="row SpacerRow">&nbsp;
 	</div>

 	<div class="row SectionHeader">
 		<div class="col-md-6">
			<b>Buyer Details</b>
		 </div>
 		<div class="col-md-6">
			<b>Seller Details</b>
		</div>
	</div>
 	<div class="row">
 		<div class="col-md-6">
			{{{ $orderInfo->buyerInfo['companyInfo']['name'] }}} - {{{ $orderInfo->buyerInfo['name'] }}}<BR>
			{{{ $orderInfo->buyerInfo['office_phone'] }}} &nbsp; Cell: {{{ $orderInfo->buyerInfo['cell_phone'] }}}<BR>
			<A HREF="mailto:{{{ $orderInfo->buyerInfo['email'] }}}">{{{ $orderInfo->buyerInfo['email'] }}}</A>
		 </div>
 		<div class="col-md-6">
			{{{ $orderInfo->sellerInfo['companyInfo']['name'] }}} - {{{ $orderInfo->sellerInfo['name'] }}}<BR>
			{{{ $orderInfo->sellerInfo['office_phone'] }}} &nbsp; Cell: {{{ $orderInfo->sellerInfo['cell_phone'] }}}<BR>
			<A HREF="mailto:{{{ $orderInfo->sellerInfo['email'] }}}">{{{ $orderInfo->sellerInfo['email'] }}}</A>
		</div>
	</div>
 	<div class="row SpacerRow">&nbsp;
 	</div>

 	<div class="row SectionHeader">
 		<div class="col-md-6">
			<b>Buyer Misc Charges</b>
		 </div>
 		<div class="col-md-6">
			<b>Seller Misc Charges</b>
		</div>
	</div>
 	<div class="row">
 		<div class="col-md-6">
			xxx
		 </div>
 		<div class="col-md-6">
			xxx
		</div>
	</div>
 	<div class="row SpacerRow">&nbsp;
 	</div>

 	<div class="row SectionHeader">
 		<div class="col-md-6">
			<b>Receivables</b>
		 </div>
 		<div class="col-md-6">
			<b>Payables</b>
		</div>
	</div>
 	<div class="row">
 		<div class="col-md-2">
			<b>Subtotal:</b><BR>
			<b>Misc Charges:</b><BR>
			<b>Brokerage:</b><BR>
			<b>Bid HST:</b><BR>
			<b>Total:</b><BR>
		</div>
 		<div class="col-md-4">
			${{{ Util::makeMoney($orderInfo->product_amount)}}}<BR>
			${{{ Util::makeMoney($orderInfo->misc_charges_amount)}}}<BR>
			${{{ Util::makeMoney($orderInfo->bol_brokerage_amount)}}}<BR>
			${{{ Util::makeMoney($orderInfo->bol_total_taxes)}}}<BR>
			${{{ Util::makeMoney($orderInfo->bol_grand_total)}}}<BR>
		</div>
 		<div class="col-md-2">
			<b>Subtotal:</b><BR>
			<b>Misc Charges:</b><BR>
			<b>Brokerage:</b><BR>
			<b>Bid HST:</b><BR>
			<b>Total:</b><BR>
		</div>
 		<div class="col-md-4">
			${{{ Util::makeMoney($orderInfo->product_amount)}}}<BR>
			${{{ Util::makeMoney($orderInfo->misc_charges_amount)}}}<BR>
			${{{ Util::makeMoney($orderInfo->po_brokerage_amount)}}}<BR>
			${{{ Util::makeMoney($orderInfo->po_total_taxes)}}}<BR>
			${{{ Util::makeMoney($orderInfo->po_grand_total)}}}<BR>
		</div>
	</div>
 	<div class="row SpacerRow">&nbsp;
 	</div>

 	<div class="row SectionHeader">
 		<div class="col-md-12">
			<b>POs and Invoices</b>
		 </div>
	</div>
 	<div class="row">
 		<div class="col-md-6">
			xxx
		 </div>
 		<div class="col-md-6">
			xxx
		</div>
	</div>
 	<div class="row SpacerRow">&nbsp;
 	</div>

 	<div class="row SectionHeader">
 		<div class="col-md-12">
			<b>Comments</b>
		 </div>
	</div>
 	<div class="row">
 		<div class="col-md-6">
			xxx
		 </div>
 		<div class="col-md-6">
			xxx
		</div>
	</div>
 	<div class="row">
 		<div class="col-md-6">
			xxx
		 </div>
 		<div class="col-md-6">
			xxx
		</div>
	</div>
 	<div class="row">
 		<div class="col-md-6">
			xxx
		 </div>
 		<div class="col-md-6">
			xxx
		</div>
	</div>
 	<div class="row">
 		<div class="col-md-6">
			xxx
		 </div>
 		<div class="col-md-6">
			xxx
		</div>
	</div>
 	<div class="row">
 		<div class="col-md-6">
			xxx
		 </div>
 		<div class="col-md-6">
			xxx
		</div>
	</div>
	
	
			<?php /*    --- We`ll eventually loop some rows for Misc Charges
			  <tr>
				@if($viewInfo['showPricing'])    
					<td bgcolor='#e2f1e2' ALIGN=center>1</td>
					<td bgcolor='#e2f1e2'>charge desciption</td>
					<td bgcolor='#e2f1e2' ALIGN=right>Util::makeMoney($amount)</td>
					<td bgcolor='#e2f1e2' ALIGN=right>GST_rate%</td>
					<td bgcolor='#e2f1e2' ALIGN=right>$line amount</td>
				@elseif
					<td bgcolor='#e2f1e2' ALIGN=right>---&nbsp;</td>
					<td bgcolor='#e2f1e2' ALIGN=right>---&nbsp;</td>
					<td bgcolor='#e2f1e2' ALIGN=right>---&nbsp;</td>
					<td bgcolor='#e2f1e2' ALIGN=right>---&nbsp;</td>
					<td bgcolor='#e2f1e2' ALIGN=right>---&nbsp;</td>
				@endif
			  </tr>
			*/  ?>





























@elseif($view=='form')

	Please enter or modify the details below:

    @if ($errors->has())
        @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
        @endforeach
    @endif
 
    {{ Form::open(['role' => 'form', 'url' => '/'.$adminVars['adminURI'].'/'.$details->id.'/store']) }}
 
 	<div class="row SectionHeader">
 		Name & Company
 	</div>
 	<div class="row">
 		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="name">Name</label><span class="req">*</span>
				 <input placeholder="Name" class="form-control" name="name" type="text" value="{{{ $details->name }}}" id="name">
			 </div>
		 </div>
 		<div class="col-md-4">
			 <div class='form-group'>
				<label for="company_id">Company</label><span class="req">*</span>
				<select name="company_id" id="company_id" class="form-control input-lg">
                  <option value="" disabled selected>Choose One...</option>
				  @foreach ($formOptions['companyIDOptions'] as $qKey => $qVal)
					<option value="{{{ $qVal['id'] }}}" @if($qVal['id'] == $details->company_id) selected @endif>
					  {{{ $qVal['name'] }}}
					</option>
				  @endforeach
				 </select>
			</div>
		</div>
	</div>
 	<div class="row SectionHeader">
 		Contact Details
 	</div>
 	<div class="row">
 		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="code">Email</label><span class="req">*</span>
				 <input placeholder="name@domain.com" class="form-control" name="email" type="text" value="{{{ $details->email }}}" id="email">
			 </div>
			 <div class='form-group'>
				 <label for="code">Email2</label>
				 <input placeholder="name@domain.com" class="form-control" name="email2" type="text" value="{{{ $details->email2 }}}" id="email2">
			 </div>
		</div>
 		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="code">Office Phone</label><span class="req">*</span>
				 <input placeholder="###-###-####" class="form-control" name="office_phone" type="text" value="{{{ $details->office_phone }}}" id="office_phone">
			 </div>
			 <div class='form-group'>
				 <label for="code">Mobile Phone</label><span class="req">*</span>
				 <input placeholder="###-###-####" class="form-control" name="cell_phone" type="text" value="{{{ $details->cell_phone }}}" id="cell_phone">
			 </div>
		 </div>
	</div>
 	<div class="row SectionHeader">
 		Login & Status
 	</div>
 	<div class="row">
 		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="code">Username</label><span class="req">*</span>
				 <input placeholder="username" class="form-control" name="username" type="text" value="{{{ $details->username }}}" id="username">
			 </div>
		</div>
 		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="code">Password</label>
				 <input placeholder="" class="form-control" name="password" type="text" value="" id="password">
				 <h6>(Leave blank unless changing)</h6>
			 </div>
		</div>
	</div>
 	<div class="row">
 		<div class="col-md-4">
			<div class='form-group'>
				<label for="status_id">Status</label><span class="req">*</span>
				<select name="status_id" id="status_id" class="form-control input-lg">
				  <option value="" disabled>Choose One... </option>
				  @foreach ($formOptions['statusOptions'] as $qKey => $qVal)
					<option value="{{{ $qVal['id'] }}}" @if($qVal['id'] == $details->status_id) selected @endif>
					  {{{ $qVal['name'] }}}
					</option>
				  @endforeach
				 </select>
			</div>
		</div>
 		<div class="col-md-4">
			 <div class='form-group'>
				<label for="defaultlanguage_id">Default Language</label><span class="req">*</span>
				<select name="defaultlanguage_id" id="defaultlanguage_id" class="form-control input-lg">
                  <option value="" disabled selected>Choose One...</option>
				  @foreach ($formOptions['languageOptions'] as $qKey => $qVal)
					<option value="{{{ $qVal['id'] }}}" @if($qVal['id'] == $details->defaultlanguage_id) selected @endif>
					  {{{ $qVal['name'] }}}
					</option>
				  @endforeach
				 </select>
			</div>
		</div>
	</div>
 	<div class="row">
 		<div class="col-md-4">
			 <div class='form-group'>
				<label for="perm_groups">Permission Group</label><span class="req">*</span>
				<select name="perm_groups" id="perm_groups" class="form-control input-lg">
                  <option value="" disabled selected>Choose One...</option>
				  @foreach ($formOptions['permGroupOptions'] as $qKey => $qVal)
					<option value="{{{ $qVal['id'] }}}" @if($qVal['id'] == $details->perm_groups) selected @endif>
					  {{{ $qVal['name'] }}}
					</option>
				  @endforeach
				 </select>
			</div>
		</div>
	</div>
 	<div class="row">
 		<div class="col-md-4">
			<div class='form-group'>
			   <input class="btn btn-primary" type="submit" value="Save &raquo;">
			</div>
	    </div>
    </div>
 
    {{ Form::close() }}
 
@endif {{-- end of $view check --}}

@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
    
