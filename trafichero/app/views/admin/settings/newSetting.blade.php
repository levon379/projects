@extends('layout.default')
@section('content')
<div class="col-lg-5 col-lg-offset-3">
{{Form::open(array('route' => 'addSetting-post', 'method' => 'post')) }}
    <div class="form-group">
    {{ Form::text('shop_name', null, array('class'=>'form-control', 'placeholder'=>'Shop name', 'required')) }}
    </div>
    <div class="form-group">
    {{ Form::text('address', null, array('class'=>'form-control', 'placeholder'=>'Shop address', 'required')) }}
    </div>
    <div class="form-group">
    {{ Form::email('email', null, array('class'=>'form-control', 'placeholder'=>'Shop email', 'required')) }}
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
                                     ), null, array('class'=>'form-control', 'placeholder'=>'Shop currency', 'required')) }}
    </div>
    <div class="form-group text-center">
    {{ Form::submit('Add Setting', array('class'=>'btn btn-large btn-warning'))}}
    </div>
{{ Form::close() }}
</div>
<div class="form-group text-right">
    {{ HTML::link(URL::previous(), 'Go back', array('class' => 'btn btn-info btn-xs', 'role' => 'button')) }}
</div>
@stop