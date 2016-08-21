@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Users & Guides <small>{{ ucwords($mode) }}</small></h1></div>
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
            <div class="panel-heading">{{ ucwords($mode) }} User</div>
            <div class="panel-body">
                <form action="@if (isset($user)){{ URL::to('/admin/users/' . $user->id . '/edit') }}@endif" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" autocomplete="off" @if ($mode == 'edit'){{ 'disabled' }} @endif value="{{ Input::old('username', isset($user) ? $user->username : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="firstname" placeholder="First Name" autocomplete="off" value="{{ Input::old('first_name', isset($user) ? $user->firstname : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="lastname" placeholder="Last Name" autocomplete="off" value="{{ Input::old('last_name', isset($user) ? $user->lastname : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" autocomplete="off" value="{{ Input::old('email', isset($user) ? $user->email : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <p class="help-block">@if (isset($user)){{ "Leave this blank if you don't want to change the password" }} @endif</p>
                        <p class="help-block">A password should be 8 characters long or more, has a number, a letter and a symbol </p>
                    </div>
                    <div class="form-group">
                        <label for="telno">Telephone Number</label>
                        <input type="text" class="form-control" name="tel_no" id="telno" placeholder="Telephone Number" autocomplete="off" value="{{ Input::old('tel_no', isset($user) ? $user->tel_no : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" name="notes">{!! Input::old('notes', isset($user) ? $user->notes : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="user-type">User Type</label>
                        <select class="form-control select2" id="user-type" name="user_type_id">
                            @foreach ($userTypes as $userType)
                                @if($mode == 'add')
                                    <option value="{{$userType->id}}" {{ Input::old('user_type_id') == $userType->id ? 'selected' : '' }}>{{$userType->name}}</option>
                                @else
                                    <option value="{{$userType->id}}" {{ Input::old('user_type_id',$user->user_type_id) === $userType->id ? 'selected' : '' }}>{{$userType->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="language-panel">
                        <label>Languages</label>
                        <input class="form-control" type="text" name="languages" id="languages" placeholder="Choose Language/s" value="{{ Input::old('languages', isset($language_selection) ? $language_selection : null) }}"/>
                    </div>
                    <div class="form-group" id="patentino-panel">
                        <label class="cr-styled">
                            @if ($mode == 'add')
                            <input type="checkbox" name="patentino" {{ Input::old('patentino',false) ? 'checked' : '' }}>
                            @else
                            <input type="checkbox" name="patentino" {{ Input::old('patentino',$user->patentino) ? 'checked' : '' }}>
                            @endif
                            <i class="fa"></i>
                        </label>
                        Patentino
                    </div>
                    <div class="form-group" id="ncc-panel">
                        <label class="cr-styled">
                            @if ($mode == 'add')
                            <input type="checkbox" name="ncc" {{ Input::old('ncc',false) ? 'checked' : '' }}>
                            @else
                            <input type="checkbox" name="ncc" {{ Input::old('ncc',$user->ncc) ? 'checked' : '' }}>
                            @endif
                            <i class="fa"></i>
                        </label>
                        NCC
                    </div>
                    <div class="form-group">
                        <label class="cr-styled">
                            <input type="hidden" class="disabled-flag-value" name="disabled_flag_value" value="{{ $enabled ? '1' : '0' }}">
                            @if ($mode == 'add')
                                <input type="checkbox" class="disabled-flag" name="disabled" {{ $enabled ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" class="disabled-flag" name="disabled" {{ $enabled ? 'checked' : ''}}>
                            @endif
                            <i class="fa"></i>
                        </label>
                        Enabled
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

            $('#user-type').on('change', function (e) {

                showHideLanguages(this.value);

            });

            showHideLanguages($('#user-type').val());


            function showHideLanguages(id){
                // 3 is for guides
                if(id != 3){
                    $("#language-panel").hide();
                    $("#patentino-panel").hide();
                    $("#ncc-panel").hide();
                } else {
                    $("#language-panel").show();
                    $("#patentino-panel").show();
                    $("#ncc-panel").show();
                }
            }

            $("form").on("change",".disabled-flag",function(){
                var isChecked  = $(this).is(':checked');
                var checkValue = $(this).closest(".cr-styled").find(".disabled-flag-value");
                var value = isChecked ? 1 : 0;
                checkValue.val(value);
                console.log(checkValue.val());
            });

            $('#languages').select2({
                multiple: true,
                ajax: {
                    dataType: "json",
                    url: "/admin/services/languages",
                    results: function (data) {
                        var results = [];
                        $.each(data, function(index, language){
                            results.push({
                                id: language.id,
                                text: language.name
                            });
                        });
                        return {
                            results: results
                        };
                    }
                },
                initSelection: function(element, callback) {
                    var ids = $(element).val().split(',');
                    var result = [];
                    $.each(ids, function(index, value) {
                        $.ajax("/admin/services/languages/" + value, {
                            dataType: "json",
                            async: false
                        }).done(function(data) {
                            result.push({
                                id: data.id,
                                text: data.name
                            });
                        });
                    });
                    callback(result);
                }
            });
        });
    </script>
@stop