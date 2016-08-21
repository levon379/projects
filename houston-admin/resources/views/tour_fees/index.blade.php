@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Tour Fees<small></small></h1></div>
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! Session::get('success') !!}
</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! Session::get('error') !!}
</div>
@endif
@if($errors->any())
<div class="validation-summary-errors alert alert-danger">
	<ul>
		{!! implode('', $errors->all('<li class="error">:message</li>')) !!}
	</ul>
</div>
@endif
<div class="row">
	<div class="col-md-4">
       
        <div class="panel panel-default">
            <div class="panel-heading">{{ ucwords($mode) }} Tour Fee</div>
            <div class="panel-body">
                <form action="{{ URL::to($mode == 'add' ? '/admin/tour-fees/add' : '/admin/tour-fees/' . $tourFee->id . '/edit') }}" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group">
                        <label for="product">Product</label>
                        <select class="form-control select2" id="product_id" name="product_id">
                            @foreach ($products as $product)
                                @if($mode == 'add')
                                    <option value="{{$product->id}}" {{ Input::old('product_id') == $product->id ? 'selected' : '' }}>{{$product->name}}</option>
                                @else
                                    <option value="{{$product->id}}" {{ Input::old('product_id',$tourFee->product_id) === $product->id ? 'selected' : '' }}>{{$product->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
					<div class="form-group">
                        <label for="wage">Wage</label>
                        <input type="text" class="form-control" name="wage" id="wage" placeholder="Wage" autocomplete="off" value="{{ App\Libraries\Helpers::formatPrice(Input::old('wage', isset($tourFee) ? $tourFee->wage : null)) }} €">
                    </div>
                    <button type="submit" class="btn btn-purple">Submit</button>
                </form>

            </div>
        </div>
    </div>
    <div class="col-md-8">

        <div class="panel panel-default">
            <div class="panel-heading">Tour Fees</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Wage</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tourFees as $tourFee)
                        <tr>
                            <td>{{ $tourFee->product->name }}</td>
                            <td>{{ App\Libraries\Helpers::formatPrice($tourFee->wage) }} €</td>
                            <td>
                                <form action="/admin/tour-fees/{{ $tourFee->id }}/delete" method="post" class="delete-row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <a href="/admin/tour-fees/{{ $tourFee->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
    $(document).ready(function(){
        $("#wage").inputmask('decimal',{
            radixPoint : ',',
            autoGroup : false ,
            digits : 2 ,
            digitsOptional : false,
            suffix: ' €',
            placeholder: '0'
        });

        var confirmText = "This tour fee will be deleted";
        swlConfirm(confirmText);
    });

</script>
@stop