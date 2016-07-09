@extends('layout.default')
@section('styles')
<style type="text/css">
    .info_1 {
          background-color: #d9edf7;
    }
</style>
@stop
@section('content')
<div class="content-sec">
    <div class="breadcrumbs">
        <ul>
            <li><a href="" title=""><i class="fa fa-home"></i></a>/</li>
            <li><a title="">Profile</a></li>
        </ul>
    </div><!-- breadcrumbs -->
    <div class="container">
        <table class = "table">
            <tbody>
                <tr class = "info_1">
                    <th>
                        Username
                    </th>
                    <td>
                        {{Auth::user()->login}}
                    </td>
                </tr>
                <tr>
                    <th>
                        First Name
                    </th>
                    <td>
                        {{Auth::user()->first_name}}
                    </td>
                </tr>
                <tr class = "info_1">
                    <th>
                        Last name
                    </th>
                    <td>
                        {{Auth::user()->last_name}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Email
                    </th>
                    <td>
                        {{Auth::user()->email}}
                    </td>
                </tr>
            </tbody>
        </table>
        {{ HTML::link(URL::route('edit-admin-account'), 'Change Account', array('class' => 'btn btn-primary btn-block', 'role' => 'button')) }}
        <?php if(Session::get('error_mes')) echo "<p class='has-error'>".Session::get('error_mes')."</p>"; ?>
        <?php if(Session::get('message')) echo "<p class='has-error'>".Session::get('message')."</p>"; ?>
        @stop
        