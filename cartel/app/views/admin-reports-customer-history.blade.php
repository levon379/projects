@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/admin-reports-recent-bids" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/admin.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
 Reports - Recent Bids | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<h1>Customer History Report</h1>
  {{ Form::open(['role' => 'form', 'url' => '/admin-reports-recent-bids/']) }}
    <div class="row">	
    
      <div class="col-md-4">
        <div class='form-group'>
          <label for="start_date">Start Date (yyyy-mm-dd)</label><span class="req">*</span>
          <input name="start_date" id="start_date" class="datepicker form-control input-lg" value="{{{ $formOptions['start_date'] }}}" placeholder="MMM dd yyyy">
        </div>
      </div>
      
      <div class="col-md-4">
        <div class='form-group'>
          <label for="end_date">End Date (yyyy-mm-dd)</label><span class="req">*</span>
          <input name="end_date" id="end_date" class="datepicker form-control input-lg" value="{{{ $formOptions['end_date'] }}}" placeholder="MMM dd yyyy">
        </div>
      </div>
      
      <div class="col-md-4">
          <label for="end_date">&nbsp;</label>
        <div class='form-group'>
          <input class="btn btn-primary" type="submit" value="Search &raquo;">
        </div>
      </div>
      
    </div>
  {{ Form::close() }}

	<div align='right'><b>Report Date:</b>{{{ date('Y-m-d H:i:s') }}}</div>
  
	<div class="table-responsive">
		<table class="table table-bordered table-striped"> 
			<thead>
				<tr>
					<th>Date/Time</th>
					<th>Bidder Company / Name</th>
					<th>Posting Company / Name</th>
					<th>Bid Status</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($bidList as $itemVar)
				<tr bgcolor='{{{ $itemVar->status_color }}}'>
        
          <!-- created at -->
					<td>
            {{{ $itemVar->created_at }}}
          </td>
          
					<td>
						<a href='/admin-company/{{{$itemVar->bidder_company_id}}}/edit/'>
              {{{ $itemVar->bidder_company_name }}}
            </a>
            <br />
						<a href='/admin-user/{{{ $itemVar->bidder_id }}}/edit'>
              {{{ $itemVar->bidder_name }}}
            </a>
					</td>
          
					<td>
						<a href='/admin-company/{{{ $itemVar->product_owner_company_id }}}/edit/'>
              {{{ $itemVar->product_owner_company_name }}}
            </a>
            <br />
						<a href='/admin-user/{{{ $itemVar->product_owner_id }}}/edit'>
              {{{ $itemVar->product_owner_name }}}
            </a>
					</td>
          
					<td>
						{{{ $itemVar->bid_status }}}<br />
						@if($itemVar->accounting_number)
              <a href='/admin-transaction//{{{ $itemVar->product_owner_id }}}/show'>
                {{{ $itemVar->accounting_prefix.$itemVar->accounting_number }}}
              </a>
              <br />
            @endif
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
