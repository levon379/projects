@extends('layout.default')
@section('content')
    @if(!isset($settings))
        <div class="form-group text-right">
            {{ HTML::link(URL::route('addSetting-get'), 'Add Setting', array('class' => 'btn btn-warning', 'role' => 'button')) }}
        </div>
    @endif
    <table class="table table-striped table-bordered search showColumns showRefresh showToggle" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Shop name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Currency</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($settings as $setting)
            <tr>
                <td>{{$setting->shop_name}}</td>
                <td>{{$setting->address}}</td>
                <td>{{$setting->email}}</td>
                <td>{{$setting->currency}}</td>
                <td class="text-center">
                    {{ HTML::link(URL::route('edit-settings', ['id' => $setting->id]), 'Edit', array('class' => 'btn btn-warning btn-xs', 'role' => 'button')) }}
                    |
                    {{ HTML::link(URL::route('delete-settings', ['id' => $setting->id]), 'Delete', array('class' => 'btn btn-danger btn-xs', 'role' => 'button')) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop