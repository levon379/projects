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
 Company Address Administration | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

<h1>Company Address Administration</h1>

<b>Company:</b> {{{ $companyInfo->company_name }}}
<br /><br />
	Enter or modify the details below:

{{ Form::open(['role' => 'form', 'url' => '/admin-company-address/'.$companyInfo->id.'/'.$details->id.'/store']) }}

  <!-- Name -->
 	<div class="row">
 		<div class="col-md-4">
			 <div class='form-group'>
				 <label for="company">Name</label><span class="req">*</span>
				 <input placeholder="Company Name" class="form-control" name="company" type="text" value="{{{ $details->company }}}" id="company">
			 </div>
		</div>
	</div>
  
 	<div class="row">
		<div class="col-md-4">
    
       <!-- Address  1 -->
			 <div class='form-group'>
				 <label for="address">Address</label><span class="req">*</span>
				 <input placeholder="Address" class="form-control" name="address" type="text" value="{{{ $details->address }}}" id="address">
			 </div>
       
       <!-- Address  2 -->
			 <div class='form-group'>
				 <label for="address2">Address 2</label>
				 <input placeholder="Unit, etc" class="form-control" name="address2" type="text" value="{{{ $details->address2 }}}" id="address2">
			 </div>

       <!-- City -->
			 <div class='form-group'>
				 <label for="city">City</label><span class="req">*</span>
				 <input placeholder="City" class="form-control" name="city" type="text" value="{{{ $details->city }}}" id="city">
			 </div>
		</div>
    
		<div class="col-md-4">
       <!-- Province -->
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
       
       <!-- Country -->
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
       
       <!-- Postal Code -->
			 <div class='form-group'>
				 <label for="postal_code">Postal Code</label><span class="req">*</span>
				 <input placeholder="A1A 1A1" class="form-control" name="postal_code" type="text" value="{{{ $details->postal_code }}}" id="postal_code">
			 </div>
		</div>
	</div> 


  <!-- Ship / Receive -->
 	<div class="row">
 		<div class="col-md-4">
			<div class='form-group'>
				<label for="ship_or_recv">Ship/Recv</label><span class="req">*</span>
				<select name="ship_or_recv" id="ship_or_recv" class="form-control input-lg">
				  <option value="" disabled>Choose One... </option>
				  @foreach ($formOptions['shipRecvOptions'] as $qKey => $qVal)
					<option value="{{{ $qKey }}}" @if($qKey == $details->ship_or_recv) selected @endif>
					  {{{ $qVal }}} 
					</option>
				  @endforeach
				 </select>
			</div>
		</div>

    <!-- Status -->
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
			   <input class="btn btn-primary" type="submit" value="Save &raquo;">
			</div>
    </div>
  </div>
{{ Form::close() }}
@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
    
