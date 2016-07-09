@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
<link rel="canonical" href="http://www.example.com/admin-origin" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
<link rel="stylesheet" href="css/admin.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
Top Companies | Cartel Marketing Inc. | Leamington, Ontario
@stop


{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')
<div id='content_all'>
@if(isset($messages))
     
      <p style="background-color:#336531;">&nbsp;{{ $messages[0] }}</p>
   
  @endif
    <h1>Top Companies - Last 30 Days</h1>
    
    <div class="col-md-12">
        <form action="/admin-reports/top-companies" method="post">
            <label for ='30_day'>30 Day Minumum: $</label><input type="text" name="30_day" id='30_day' value="">
            <label for ='365_day'>365 Day Minumum: $</label><input type="text" name="365_day" id='365_day' value="">
            <input class="btn btn-primary" type="submit" value="Store">
        </form>
    </div>
    <table class="table table-bordered table-striped">

        <tr>
            <th>Company Name</th>
            <th><a href="/admin-reports/top-companies/30">Brokerage (30 days)</a></th>
            <th><a href="/admin-reports/top-companies/365">Brokerage (365 days)</a></th>
        </tr>
        
        @if($days == 31)
          @foreach ($monthly_results as $key => $val)
            <tr style="font-size: 25px;" >
              <td>{{{ $val["name"] }}}</td>
              <td>{{{ $val["brokerage"] }}}</td>
              <td>{{{ $yearly_results[$key]["brokerage"] }}}</td>
            </tr>   
          @endforeach
        @else
          @foreach ($yearly_results as $key => $val)
            <tr style="font-size: 25px;" >
              <td>{{{ $val["name"] }}}</td>
              <td>{{{ $monthly_results[$key]["brokerage"] }}}</td>
              <td>{{{ $val["brokerage"] }}}</td>
            </tr>   
          @endforeach
        @endif

        
        
    </table>
</div>

@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
