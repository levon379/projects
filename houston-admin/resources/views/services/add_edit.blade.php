@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Service <small>{{ ucwords($mode) }}</small></h1></div>
<div class="row breadcrumb-row">
    <div class="btn-group btn-breadcrumb col-lg-12">
        <a href="/admin/services" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/services" class="btn btn-default"><div>Services</div></a>
		@if($mode == 'add')
			<a href="{{ URL::to('/admin/services/add') }}" class="btn btn-default active"><div>{{ ucwords($mode) }} Service</div></a>
		@else
			<a href="{{ URL::to('/admin/services/' . $service->id . '/edit') }}" class="btn btn-default active"><div>{{ ucwords($mode) }} Service</div></a>
		@endif
    </div>
	@if($mode == 'edit')
    <div class="col-lg-12">
        <h4><a class="operation-link" href="/admin/services/{{ $service->id }}/options">View Options <i class="fa fa-eye operation-icon"></i></a></h4>
    </div>
	@endif
</div>
<div class="row">
    <div class="col-md-6">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        @if($errors->any())
		<div class="form-group">
        <div class="validation-summary-errors alert alert-danger">
            <ul>
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </ul>
        </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">{{ ucwords($mode) }} Service</div>
            <div class="panel-body">
                <form action="@if (isset($service)){{ URL::to('/admin/services/' . $service->id . '/edit') }}@endif" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($service) ? $service->name : null) }}">
                    </div>
                    <div class="form-group {{ $errors->has('contactname') ? 'has-error' : '' }}">
                        <label for="contact-name">Contact Name</label>
                        <input type="text" class="form-control" name="contact_name" id="contact-name" placeholder="Contact Name" autocomplete="off" value="{{ Input::old('contact_name', isset($service) ? $service->contact_name : null) }}">
                    </div>
                    <div class="form-group {{ $errors->has('contacttel') ? 'has-error' : '' }}">
                        <label for="contact-tel">Contact Telephone Number</label>
                        <input type="text" class="form-control" name="contact_tel" id="contact-tel" placeholder="Contact Telephone Number" autocomplete="off" value="{{ Input::old('contact_tel', isset($service) ? $service->contact_tel : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="vatno">Vat No.</label>
                        <input type="text" class="form-control" name="vat_no" id="vatno" placeholder="Vat No." autocomplete="off" value="{{ Input::old('vat_no', isset($service) ? $service->vat_no : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" autocomplete="off" value="{{ Input::old('email', isset($service) ? $service->email : null) }}">
                    </div>
                    <div class="form-group {{ $errors->has('serviceType') ? 'has-error' : '' }}">
                        <label for="service-type">Service Type</label>
                        <select class="form-control select2" id="service-type" name="service_type_id">
                            @foreach ($serviceTypes as $serviceType)
                                @if($mode == 'add')
                                    <option value="{{$serviceType->id}}" {{ Input::old('service_type_id') == $serviceType->id ? 'selected' : '' }}>{{$serviceType->name}}</option>
                                @else
                                    <option value="{{$serviceType->id}}" {{ Input::old('service_type_id',$service->service_type_id) === $serviceType->id ? 'selected' : '' }}>{{$serviceType->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
					<div class="form-group {{ $errors->has('address_line_1') ? 'has-error' : '' }}">
                        <label for="address-line-1">Address Line 1</label>
                        <input type="text" class="form-control" name="address_line_1" id="address-line-1" placeholder="Address Line 1" autocomplete="off" value="{{ Input::old('address_line_1', isset($service) ? $service->address_line_1 : null) }}">
                    </div>
					<div class="form-group {{ $errors->has('address_line_2') ? 'has-error' : '' }}">
                        <label for="address-line-2">Address Line 2</label>
                        <input type="text" class="form-control" name="address_line_2" id="address-line-2" placeholder="Address Line 2" autocomplete="off" value="{{ Input::old('address_line_2', isset($service) ? $service->address_line_2 : null) }}">
                    </div>
					<div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                        <label for="city">City</label>
                        <input type="text" class="form-control" name="city" id="city" placeholder="City" autocomplete="off" value="{{ Input::old('city', isset($service) ? $service->city : null) }}">
                    </div>
					<div class="form-group {{ $errors->has('state_province') ? 'has-error' : '' }}">
                        <label for="state-province">State/Province</label>
                        <input type="text" class="form-control" name="state_province" id="state-province" placeholder="State/Province" autocomplete="off" value="{{ Input::old('state_province', isset($service) ? $service->state_province : null) }}">
                    </div>
					<div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                        <label for="country">Country</label>
                        <input type="text" class="form-control" name="country" id="country" placeholder="Country" autocomplete="off" value="{{ Input::old('country', isset($service) ? $service->country : null) }}">
                    </div>
					<div class="form-group {{ $errors->has('zip') ? 'has-error' : '' }}">
                        <label for="zip">ZIP</label>
                        <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip" autocomplete="off" value="{{ Input::old('zip', isset($service) ? $service->zip : null) }}">
                    </div>
					<div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" name="notes" id="notes">{!! Input::old('notes', isset($service) ? $service->notes : null) !!}</textarea>
                    </div>
                    <button type="submit" class="btn btn-purple">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>

@stop