@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/admin-company" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="{{ URL::asset('css/chosen.min.css') }}" />
	<link rel="stylesheet" href="{{ URL::asset('css/datepicker3.css') }}" />
	<link rel="stylesheet" href="{{ URL::asset('css/admin-form.css') }}" />
	<link rel="stylesheet" href="{{ URL::asset('css/admin-company.css') }}" />
	<link rel="stylesheet" href="css/admin.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
 Company Administration | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<h1>Company Administration</h1>

@if($view=='index')
	<a href="/{{{$adminVars['adminURI']}}}/0/edit"><i class="fa fa-plus fa-lg fa-grey"></i> Add New Company</a>
	<a href="/admin-user/0/edit"><i class="fa fa-plus fa-lg fa-grey"></i> Add New User</a>
	<div class="table-responsive">

    <!-- Companies  -->
		<table class="table table-bordered table-striped"> 
			<thead>
				<tr>
					<th>Name</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($items as $itemVar)
					<tr bgcolor='{{{ $itemVar->status_color }}}'>
						<td><i class="fa fa-caret-right fa-lg"></i>{{{ $itemVar->name }}}</td>
						<td>{{{ $itemVar->status_name }}}</td>
						<td>
							  <a href="/{{ $adminVars['adminURI'].'/'.$itemVar->id }}/edit" class="table-link"><i class="fa fa-pencil fa-lg"></i></a>
							  <script type="text/javascript">$(document).ready(function() {$("#link{{ $itemVar->id }}").popConfirm();});</script>
							  <a href="/{{$adminVars['adminURI'].'/'.$itemVar->id }}/destroy" class="table-link" id="link{{ $itemVar->id }}"><i class="fa fa-trash-o fa-lg confirmation-callback"></i></a>
							  <a href="/admin-company-address/{{ $itemVar->id }}/" class="table-link"><i class="fa fa-flip-horizontal fa-truck fa-lg"></i></a>
						</td>
					</tr>
					
					{{-- Users --}}
            @foreach ($itemVar->sub as $subitemVar)
              <tr bgcolor='{{{ $subitemVar->status_color }}}' class="user-row">
                <td>{{{ $subitemVar->name }}}</td>
                <td>{{{ $subitemVar->status_name }}}</td>
                <td>
                    <a href="/admin-user/{{ $subitemVar->id }}/edit" class="table-link"><i class="fa fa-pencil fa-lg"></i></a>
                    <script type="text/javascript">$(document).ready(function() {$("#plink{{$subitemVar->id}}").popConfirm();});</script>
                    <a href="/admin-user/{{ $subitemVar->id }}/destroy" class="table-link" id="plink{{ $subitemVar->id }}"><i class="fa fa-trash-o fa-lg confirmation-callback"></i></a>
                </td>
              </tr>  
            @endforeach

				@endforeach
			</tbody> 
		</table>
	</div>

@elseif($view=='form')

	Please enter or modify the details below:
        <br>
        <a href="/admin-company/{{{$details->id}}}/uploads"><i class="fa fa-plus fa-lg fa-grey"></i> Company Files</a>
    @if ($errors->has())
        @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
        @endforeach
    @endif
 
    {{ Form::open(['role' => 'form', 'url' => '/'.$adminVars['adminURI'].'/'.$details->id.'/store']) }}
 
 	<div class="row SectionHeader">
 		Name &amp; Address
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
				<label for="company_type_id">Company Type</label><span class="req">*</span>
				<select name="company_type_id" id="company_type_id" class="form-control input-lg">
				  <option value="" disabled>Choose One... </option>
				  @foreach ($formOptions['companyTypeOptions'] as $qKey => $qVal)
					<option value="{{{ $qVal['id'] }}}" @if($qVal['id'] == $details->company_type_id) selected @endif>
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
				 <label for="address">Address</label><span class="req">*</span>
				 <input placeholder="Address" class="form-control" name="address" type="text" value="{{{ $details->address }}}" id="address">
			 </div>
			 <div class='form-group'>
				 <label for="address2">Address 2</label>
				 <input placeholder="Unit, etc" class="form-control" name="address2" type="text" value="{{{ $details->address2 }}}" id="address2">
			 </div>
			 <div class='form-group'>
				 <label for="city">City</label><span class="req">*</span>
				 <input placeholder="City" class="form-control" name="city" type="text" value="{{{ $details->city }}}" id="city">
			 </div>
		</div>
		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="province_id">Province</label><span class="req">*</span>
				<select name="province_id" id="province_id" class="form-control input-lg">
				  <option value="" disabled>Choose One... </option>
				  @foreach ($formOptions['provinceOptions'] as $qKey => $qVal)
					<option value="{{{ $qVal['id'] }}}" @if($qVal['id'] == $details->province_id) selected @endif>
					  {{{ $qVal['name'] }}}
					</option>
				  @endforeach
				 </select>
			 </div>
			 <div class='form-group'>
				 <label for="country_id">Country</label><span class="req">*</span>
				<select name="country_id" id="country_id" class="form-control input-lg">
				  <option value="" disabled>Choose One... </option>
				  @foreach ($formOptions['countryOptions'] as $qKey => $qVal)
					<option value="{{{ $qVal['id'] }}}" @if($qVal['id'] == $details->country_id) selected @endif>
					  {{{ $qVal['name'] }}}
					</option>
				  @endforeach
				 </select>
			 </div>
			 <div class='form-group'>
				 <label for="postal_code">Postal Code</label><span class="req">*</span>
				 <input placeholder="A1A 1A1" class="form-control" name="postal_code" type="text" value="{{{ $details->postal_code }}}" id="postal_code">
			 </div>
		</div>
	</div>
 	<div class="row SectionHeader">
 		Contact Info
 	</div>
 	<div class="row">
		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="default_email">Primary Email</label><span class="req">*</span>
				 <input placeholder="name@domain.com" class="form-control" name="default_email" type="text" value="{{{ $details->default_email }}}" id="default_emails">
			 </div>
			 <div class='form-group'>
				 <label for="website">Website</label><span class="req">*</span>
				 <input placeholder="www.domain.com" class="form-control" name="website" type="text" value="{{{ $details->website }}}" id="website">
			 </div>
		</div>
		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="phone">Phone</label><span class="req">*</span>
				 <input placeholder="###-###-####" class="form-control" name="phone" type="text" value="{{{ $details->phone }}}" id="phone">
			 </div>
			 <div class='form-group'>
				 <label for="fax">Fax</label>
				 <input placeholder="###-###-####" class="form-control" name="fax" type="text" value="{{{ $details->fax }}}" id="fax">
			 </div>
		</div>
	</div>
 	<div class="row SectionHeader">
 		Status & Credit
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
			 <div class='form-group'>
				 <label for="message">Message</label>
				 <input placeholder="" class="form-control" name="message" type="text" value="{{{ $details->message }}}" id="message">
			 </div>
		</div>
		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="credit_limit">Credit Limit</label><span class="req">*</span>
				 <input placeholder="$00000" class="form-control" name="credit_limit" type="text" value="{{{ $details->credit_limit }}}" id="credit_limit">
			 </div>
			 <div class='form-group'>
				 <label for="credit_limit_exp">Credit Limit Expiry</label><span class="req">*</span>
				 <input name="credit_limit_exp" id="credit_limit_exp" class="datepicker form-control input-lg" value="@if(!empty($details->credit_limit_exp)) {{{ $details->credit_limit_exp }}} @else {{{ date("M j Y") }}} @endif" placeholder="MMM dd yyyy">
			 </div>
		</div>
	</div>
 	<div class="row">	
		<div class="col-md-8">
			 <div class='form-group'>
				 <label for="payable_notes">Payable Notes</label>
				 <textarea rows=5 class="form-control" name="payable_notes" id="payable_notes">{{{ $details->payable_notes }}}</textarea>
			 </div>
		</div>
	</div>
 	<div class="row SectionHeader">
 		Other Emails
 	</div>
 	<div class="row">
		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="shipping_email">Shipping Email</label><span class="req">*</span>
				 <input placeholder="name@domain.com" class="form-control" name="shipping_email" type="text" value="{{{ $details->shipping_email }}}" id="shipping_email">
			 </div>
			 <div class='form-group'>
				 <label for="receiving_email">Receiving Email</label><span class="req">*</span>
				 <input placeholder="name@domain.com" class="form-control" name="receiving_email" type="text" value="{{{ $details->receiving_email }}}" id="receiving_email">
			 </div>
			 <div class='form-group'>
				 <label for="logistics_email">Logistics Email</label><span class="req">*</span>
				 <input placeholder="name@domain.com" class="form-control" name="logistics_email" type="text" value="{{{ $details->logistics_email }}}" id="logistics_email">
			 </div>
		</div>		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="ap_email">AP Email</label><span class="req">*</span>
				 <input placeholder="name@domain.com" class="form-control" name="ap_email" type="text" value="{{{ $details->ap_email }}}" id="ap_email">
			 </div>
			 <div class='form-group'>
				 <label for="ar_email">AR Email</label><span class="req">*</span>
				 <input placeholder="name@domain.com" class="form-control" name="ar_email" type="text" value="{{{ $details->ar_email }}}" id="ar_email">
			 </div>
		</div>
	</div>
 	<div class="row SectionHeader">
 		Misc
 	</div>
 	<div class="row">
		<div class="col-md-8">
			 <div class='form-group'>
				 <label for="internal_notes">Internal Notes</label>
				 <textarea rows=5 class="form-control" name="internal_notes" id="internal_notes">{{{ $details->internal_notes }}}</textarea>
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
<script src="{{{ URL::asset('js/admin-company.js') }}}" type="text/javascript" charset="utf-8"></script>
@stop
    
