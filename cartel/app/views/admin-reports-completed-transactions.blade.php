@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/admin-reports-completed-transactions" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/admin.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
 Reports - Completed Transactions| Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<h1>Completed Transactions Report</h1>

	<div align='right'>
    <b>Report Date:</b> {{{date('Y-m-d H:i:s')}}}
  </div>
  
	<div class="table-responsive">
		<table class="table table-bordered"> 
			<thead>
				<tr>
					<th>Tr#</th>
					<th>Date/Time</th>
					<th>Chargeable Qty</th>
					<th>Receivable<BR>Buyer Company</th>
					<th>Amount</th>
					<th>Payable<BR>Vendor Company</th>
					<th>Amount</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($items as $itemVar)
				<tr>
          <!-- accounting_number_display -->
					<td bgcolor='{{{$itemVar->date_color}}}'>
            <a href='/admin-order/{{{$itemVar->id}}}/show'>{{{$itemVar->accounting_number}}}</a>
          </td>
          
          <!-- created_at -->
					<td bgcolor='{{{$itemVar->date_color}}}'>
            {{{$itemVar->created_at}}}
          </td>
          
          <!-- chargeable_qty -->
					<td bgcolor='{{{$itemVar->date_color}}}'>
            {{{$itemVar->chargeable_qty}}}
          </td>
          
          <!-- Buyer company_name -->
					<td bgcolor='{{{$itemVar->receivable_status_color}}}'>
            <a href='/admin-company/{{{$itemVar->buyerInfo->companyInfo->id}}}/edit/'>{{{$itemVar->buyerInfo->companyInfo->name}}}</a>
          </td>
          
          <!-- po_grand_total -->
					<td bgcolor='{{{$itemVar->receivable_status_color}}}'>
            ${{ Util::makeMoney($itemVar->po_grand_total)}}
          </td>
          
          <!-- Seller company name -->
					<td bgcolor='{{{$itemVar->payable_status_color}}}'>
            <a href='/admin-company/{{{$itemVar->sellerInfo->companyInfo->id}}}/edit/'>{{{$itemVar->sellerInfo->companyInfo->name}}}</a>
          </td>
          
          <!-- bol_grand_total -->
					<td bgcolor='{{{$itemVar->payable_status_color}}}'>
            ${{ Util::makeMoney($itemVar->bol_grand_total)}}
          </td>
				</tr>
        
				<tr bgcolor_='{{{$itemVar->id}}}'>

          <!-- Nothing -->
					<td bgcolor='{{{$itemVar->date_color}}}'>
            &nbsp;
          </td>
          
          <!-- qty -->
					<td bgcolor='{{{$itemVar->date_color}}}'>
            Bid Qty: {{{$itemVar->bidInfo->qty}}}
          </td>
          
          <!-- Product and variety -->
					<td bgcolor='{{{$itemVar->date_color}}}' colspan='3'>
            {{{$itemVar->bidInfo->product_name}}}
            @if($itemVar->bidInfo->variety_name)
              - {{{$itemVar->bidInfo->variety_name}}}
            @endif
          </td>
          
          <!-- Link to the PO .pdf -->
					<td bgcolor='{{{$itemVar->date_color}}}'>
            <a href='//uplds/orderpdfs/{{{$itemVar->accounting_number}}}.pdf'>View PO</a>
          </td>
          
          <!-- Link to the BOL .pdf -->
					<td bgcolor='{{{$itemVar->date_color}}}'>
            <a href='//uplds/orderpdfs/{{{$itemVar->accounting_number}}}.pdf'>View BOL</a>
          </td>
				</tr>
        
				@endforeach
			</tbody> 
		</table>
	</div>
@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
