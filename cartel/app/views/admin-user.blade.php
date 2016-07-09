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

@if($view=='index')

@elseif($view=='list')
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
    @foreach ($pageData as $qKey => $qVal)

    <tr>
        <th class="company_name">{{{ $qKey }}}<span>({{ count($pageData[$qKey])}})</span></th>

        @foreach ($qVal as $key => $user)
            @if($user->is_online == 1)
                <tr class="online_user">
                    <td class="user_name">{{{ $user->name }}}</td>
                    <td>Yes</td>
                    <td>{{date('d/m/Y H:i:s',strtotime($user->updated_at))}}</td>
                </tr>
            @else
                <tr >
                    <td class="user_name">{{{ $user->name }}}</td>
                    <td>No</td>
                    <td>{{ date('d/m/Y H:i:s',strtotime($user->updated_at))}}</td>
                </tr>
            @endif
    @endforeach



    @endforeach
</table>


@elseif($view=='form')
<h1>User Administration</h1>
Please enter or modify the details below:

{{ Form::open(['role' => 'form', 'url' => '/'.$adminVars['adminURI'].'/'.$details->id.'/store', 'enctype'=>'multipart/form-data']) }}
<div class="row SectionHeader">
    Name &amp; Company
</div>
<div class="row">
    <div class="col-md-4">
        <div class='form-group'>
            <label for="name">Name</label><span class="req">*</span>

            {{-- {{{ $details['name'] }}} --}}
            <input placeholder="Name" class="form-control" name="name" type="text" value="{{{ $details->name }}}" id="name">
        </div>
    </div>
    <div class="col-md-4">
        <div class='form-group'>
            <label for="company_id">Company</label><span class="req">*</span>
            <select name="company_id" id="company_id" class="form-control input-lg">
                <option value="" disabled selected>Choose One...</option>
                @foreach ($formOptions['companyIDOptions'] as $qKey => $qVal)
                <option value="{{{ $qVal['id'] }}}" @if($qVal['id'] == $details->company_id) selected @endif>
                        {{{ $qVal['name'] }}}
            </option>
            @endforeach
        </select>
    </div>
</div>
</div>
<div class="row SectionHeader">
    Contact Details
</div>
<div class="row">
    <div class="col-md-4">
        <div class='form-group'>
            <label for="code">Email</label><span class="req">*</span>
            <input placeholder="name@domain.com" class="form-control" name="email" type="text" value="{{{ $details->email }}}" id="email">
        </div>
        <div class='form-group'>
            <label for="code">Email 2</label>
            <input placeholder="name@domain.com" class="form-control" name="email2" type="text" value="{{{ $details->email2 }}}" id="email2">
        </div>
    </div>
    <div class="col-md-4">
        <div class='form-group'>
            <label for="code">Office Phone</label><span class="req">*</span>
            <input placeholder="###-###-####" class="form-control" name="office_phone" type="text" value="{{{ $details->office_phone }}}" id="office_phone">
        </div>
        <div class='form-group'>
            <label for="code">Mobile Phone</label><span class="req">*</span>
            <input placeholder="###-###-####" class="form-control" name="cell_phone" type="text" value="{{{ $details->cell_phone }}}" id="cell_phone">
        </div>
    </div>
</div>
<div class="row SectionHeader">
    Login &amp; Status
</div>
<div class="row">
    <div class="col-md-4">
        <div class='form-group'>
            <label for="code">Username</label><span class="req">*</span>
            <input placeholder="username" class="form-control" name="username" type="text" value="{{{ $details->username }}}" id="username">
        </div>
    </div>
    <div class="col-md-4">
        <div class='form-group'>
            <label for="code">Password</label>
            <input placeholder="" class="form-control" name="password" type="text" value="" id="password">
            <h6>(Leave blank unless changing)</h6>
        </div>
    </div>
</div>
<div class="row">
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
</div>
<div class="col-md-4">
    <div class='form-group'>
        <label for="defaultlanguage_id">Default Language</label><span class="req">*</span>
        <select name="defaultlanguage_id" id="defaultlanguage_id" class="form-control input-lg">
            <option value="" disabled selected>Choose One...</option>
            @foreach ($formOptions['languageOptions'] as $qKey => $qVal)
            <option value="{{{ $qVal['id'] }}}" @if($qVal['id'] == $details->defaultlanguage_id) selected @endif>
                    {{{ $qVal['name'] }}}
        </option>
        @endforeach
    </select>
</div>
</div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class='form-group'>
            <label for="perm_groups">Permission Group</label><span class="req">*</span>
            <select name="perm_groups" id="perm_groups" class="form-control input-lg">
                <option value="" disabled selected>Choose One...</option>
                @foreach ($formOptions['permGroupOptions'] as $qKey => $qVal)
                <option value="{{{ $qVal['id'] }}}" @if($qVal['id'] == $details->perm_groups) selected @endif>
                        {{{ $qVal['name'] }}}
            </option>
            @endforeach
        </select>
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class='form-group'>
            <input class="btn btn-primary" type="submit" value="Save &raquo;">
        </div>
    </div>
</div>

{{ Form::close() }}

@endif {{-- end of $view check --}}

@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop

