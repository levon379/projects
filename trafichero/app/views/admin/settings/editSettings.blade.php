@extends('layout.default')
@section('content')
<div class="col-lg-5 col-lg-offset-3">
{{Form::open(array('route' => ['update-settings', $settings->id], 'method' => 'post')) }}
    <div class="form-group">
    {{ Form::text('shop_name', $settings->shop_name, array('class'=>'form-control', 'placeholder'=>'Product code', 'required')) }}
    </div>
    <div class="form-group">
    {{ Form::text('address', $settings->address, array('class'=>'form-control', 'placeholder'=>'Product Name', 'required')) }}
    </div>
    <div class="form-group">
    {{ Form::email('email', $settings->email, array('class'=>'form-control', 'placeholder'=>'Product description', 'required')) }}
    </div>
    <div class="form-group">
    {{ Form::select('currency', array(
                            'currency'=>'Select currency',
                            'United States dollar'=>'USD ($)',
                            'Euro'=>'EUR (€)',
                            'Japanese yen'=>'JPY (¥)',
                            'Pound sterling'=>'GBP (£)',
                            'Australian dollar'=>'AUD ($)',
                            'Swiss franc'=>'CHF (Fr)',
                             ), $settings->currency, array('class'=>'form-control', 'placeholder'=>'Shop currency', 'required')) }}
    </div>
    <div class="form-group hidden">
    {{ Form::hidden('id', $settings->id) }}
    </div>
    <div class="form-group text-center">
    {{ Form::submit('Update Settings', array('class'=>'btn btn-large btn-warning'))}}
    </div>
{{ Form::close() }}
</div>
<div class="form-group text-right">
    {{ HTML::link(URL::previous(), 'Go back', array('class' => 'btn btn-info btn-xs', 'role' => 'button')) }}
</div>
@stop
