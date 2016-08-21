@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Service Option <small>{{ ucwords($mode) }} <strong>({{ isset($serviceOption) ? $serviceOption->service->name : $service->name }})</strong></small></h1></div>
<div class="row breadcrumb-row">
    <div class="btn-group btn-breadcrumb col-lg-12">
        <a href="/admin/services" class="btn btn-default"><i class="fa fa-home"></i></a>
        <a href="/admin/services" class="btn btn-default"><div>Services</div></a>
        <a href="/admin/services/{{ $service->id }}/options" class="btn btn-default"><div>Options</div></a>
		@if($mode == 'add')
			<a href="/admin/services/{{ $service->id }}/options/add" class="btn btn-default active"><div>{{ ucwords($mode) }} Service Option</div></a>
		@else
			<a href="/admin/services/options/{{ $serviceOption->id }}/edit" class="btn btn-default active"><div>{{ ucwords($mode) }} Service Option</div></a>
		@endif
    </div>
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
        <div class="validation-summary-errors alert alert-danger">
            <ul>
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </ul>
        </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">{{ ucwords($mode) }} Service Option </div>
            <div class="panel-body">
                <form action="@if (isset($serviceType)){{ URL::to('/admin/services/options/' . $serviceOption->id . '/edit') }}@endif" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="service_id" value="{{ isset($serviceOption) ? $serviceOption->service_id : $service->id }}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($serviceOption) ? $serviceOption->name : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="unit-price">Unit Price</label>
                        <input type="text" class="form-control inputmask" name="unit_price" id="unit-price" autocomplete="off" value="{{ App\Libraries\Helpers::formatPrice(Input::old('unit_price', isset($serviceOption) ? $serviceOption->unit_price : null)) }} €">
                    </div>
					<div class="form-group">
                        <label for="iva">IVA</label>
                        <input type="text" class="form-control inputmask" name="iva" id="iva" autocomplete="off" value="{{ App\Libraries\Helpers::formatPrice(Input::old('iva', isset($serviceOption) ? $serviceOption->iva : null)) }} €">
                    </div>
					<div class="form-group">
                        <label for="unit-price-plus-iva">Total Unit Price + IVA</label>
                        <input type="text" class="form-control inputmask" name="unit_price_plus_iva" id="unit-price-plus-iva" autocomplete="off" value="{{ App\Libraries\Helpers::formatPrice(Input::old('unit_price_plus_iva', isset($serviceOption) ? $serviceOption->unit_price_plus_iva : null)) }} €" readOnly>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description">{!! Input::old('description', isset($serviceOption) ? $serviceOption->description : null) !!}</textarea>
                    </div>
                    <button type="submit" class="btn btn-purple">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
    $(document).ready(function(){
        $("#unit-price, #iva, #unit-price-plus-iva").inputmask('decimal',{
            radixPoint : ',',
            autoGroup : false ,
            digits : 2 ,
            digitsOptional : false,
            suffix: ' €',
            placeholder: '0'
        });
		
		$("#unit-price, #iva").on("change paste keyup keydown blur", function() {
            computeTotal();
		});

        function computeTotal(){
            var total = parseFloat(cleanPrice($("#unit-price").val())) + parseFloat(cleanPrice($("#iva").val()));
            total = Math.round(total*100)/100;
            $("#unit-price-plus-iva").val(total);
        }
		
    });

</script>
@stop