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
  User Administration | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')
  <h1>Report - Online Users</h1>
  <div class="report_date-div">
      <h3 class="report_date-h3">Report Date: </h3>
      <p class="report_date-p"> {{ date('d/m/Y H:i:s')}}</p>
  </div>
  
  <table class="table table-bordered table-striped">
    <tr>
      <th></th>
      <th>Currently On</th>
      <th>Last Site Access</th>
    </tr>
    
    @foreach ($companies as $company)
    <tr>
      <th class="company_name">{{{ $company->name }}} {{ count($company->users) }}</th>

      @foreach ($company->users as $user)
        @if($user->is_online > 0)
          <tr class="online_user">
            <td class="user_name">{{{ $user->name }}}</td>
              <td>Yes</td>
              <td>{{date('d/m/Y H:i:s', strtotime($user->last_online)) }}</td>
          </tr>
        @else
          <tr >
            <td class="user_name">{{{ $user->name }}}</td>
            <td>No</td>
            <td>{{ date('d/m/Y H:i:s', strtotime($user->last_online)) }}</td>
          </tr>
        @endif
      @endforeach
      
    @endforeach
</table>
@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop

