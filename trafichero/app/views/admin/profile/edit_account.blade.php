@extends('layout.default')
@section('styles')
<style type="text/css">
    .form_item {
        height: 48px;
    }
</style>
@stop
@section('content')
<?php // var_dump(Session::get('error_mes'));die; ?>
<div class="content-sec" role="tabpanel">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <!--<li role="presentation" class="active">-->
        <li role="presentation" class="<?php if(!Session::get('change')) echo "active"; ?>">
            <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Change account settings</a>
        </li>
        <li role="presentation" class="<?php if(Session::get('change')) echo "active"; ?>">
            <a href="#password" aria-controls="password" role="tab" data-toggle="tab">Change account password</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane <?php if(!Session::get('change')) echo "active"; ?>" id="settings" style="">

            <div class="clearfix">&nbsp;</div>
            {{ Form::open(array('route' => ['update-admin-account'], 'method' => 'post', 'class'=>'form-signin')) }}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4>Change
                            <br>
                            <small>Account Settings</small>
                        </h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group form_item @if ($errors->has('login')) has-error @endif">
                        {{ Form::label('login','Username*',array('id'=>'','class'=>'col-sm-2 control-label')) }}
                        <!--<label class="col-sm-2 control-label">Username*</label>-->
                        <div class="col-sm-6">
                            {{ Form::text('login', Auth::user()->login, array('class'=>'form-control', 'required', 'autofocus' => '', 'data-parsley-minlength'=>"2", 'data-parsley-maxlength'=>"25")) }}
                            @if ($errors->has('login')) <p class="help-block" style="line-height: 14px ;">{{ $errors->first('login') }}</p> @endif
                        </div>
                        <div class="col-sm-4">
                            <code>length - from 2 to 25 symbols</code>
                        </div>
                    </div>
                    <!--                <div class="form-group col-sm-6">
                                        {{ Form::text('username', Auth::user()->login, array('class'=>'form-control', 'placeholder'=>'Username*', 'required', 'autofocus' => '')) }}
                                    </div>-->
                    <div class="form-group form_item @if ($errors->has('first_name')) has-error @endif">
                        {{ Form::label('first_name','First Name*',array('id'=>'','class'=>'col-sm-2 control-label')) }}
                        <!--<label class="col-sm-2 control-label">First Name*</label>-->
                        <div class="col-sm-6">
                            {{ Form::text('first_name', Auth::user()->first_name, array('class'=>'form-control', 'required', 'data-parsley-minlength'=>"2", 'data-parsley-maxlength'=>"35")) }}
                            @if ($errors->has('first_name')) <p class="help-block" style="line-height: 14px ;">{{ $errors->first('first_name') }}</p> @endif
                        </div>
                        <div class="col-sm-4">
                            <code>length - from 2 to 35 symbols</code>
                        </div>
                    </div>
                    <!--                <div class="form-group col-sm-6">
                                        {{ Form::text('firstname', Auth::user()->firs_tname, array('class'=>'form-control', 'placeholder'=>'First Name*', 'required', 'autofocus' => '')) }}
                                    </div>-->
                    <div class="form-group form_item @if ($errors->has('last_name')) has-error @endif">
                        {{ Form::label('last_name','Last name*',array('id'=>'','class'=>'col-sm-2 control-label')) }}
                        <!--<label class="col-sm-2 control-label">Last name*</label>-->
                        <div class="col-sm-6">
                            {{ Form::text('last_name', Auth::user()->last_name, array('class'=>'form-control', 'required', 'autofocus' => '', 'data-parsley-minlength'=>"2", 'data-parsley-maxlength'=>"35")) }}
                            @if ($errors->has('last_name')) <p class="help-block" style="line-height: 14px ;">{{ $errors->first('last_name') }}</p> @endif
                        </div>
                        <div class="col-sm-4">
                            <code>length - from 2 to 35 symbols</code>
                        </div>
                    </div>
                    <!--                <div class="form-group col-sm-6">
                                        {{ Form::text('lastname', Auth::user()->last_name, array('class'=>'form-control', 'placeholder'=>'Last name*', 'required', 'autofocus' => '')) }}
                                    </div>-->
                    <div class="form-group form_item @if ($errors->has('email')) has-error @endif">
                        {{ Form::label('email','E-mail*',array('id'=>'','class'=>'col-sm-2 control-label')) }}
                        <!--<label class="col-sm-2 control-label">E-mail*</label>-->
                        <div class="col-sm-6">
                            {{ Form::email('email', Auth::user()->email, array('class'=>'form-control', 'required', 'autofocus' => '')) }}
                            @if ($errors->has('email')) <p class="help-block" style="line-height: 14px ;">{{ $errors->first('email') }}</p> @endif
                        </div>
                        <div class="col-sm-4">
                            <code>type - email</code>
                        </div>
                    </div>
                    <!--                <div class="form-group col-sm-6">
                                        {{ Form::email('email', Auth::user()->email, array('class'=>'form-control', 'placeholder'=>'Email Address*', 'required')) }}
                                    </div>-->
                    <div class="form-group form_item @if ($errors->has('correct_password')) has-error @endif">
                        {{ Form::label('','Password*',array('id'=>'','class'=>'col-sm-2 control-label')) }}
                        <!--<label class="col-sm-2 control-label">Old Password*</label>-->
                        <div class="col-sm-6">
                            <!--<input type="password" name="correct_password" required="required" data-parsley-minlength="5" data-parsley-maxlength="25" class="form-control" value="">-->
                            {{ Form::password('correct_password', array('class' => 'form-control', 'required', 'data-parsley-minlength'=>"6", 'data-parsley-maxlength'=>"12"))  }}
                            @if ($errors->has('correct_password')) <p class="help-block" style="line-height: 14px ;">{{ $errors->first('correct_password') }}</p> @endif
                        </div>
                        <div class="col-sm-4">
                            <code>length - from 6 to 12 symbols</code>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-center">
                    {{ Form::submit("Save", array('class'=>'btn btn-info')) }}
                    <!--<button type="submit" name="save_brand" class="btn btn-info"><?php //echo "Save";  ?></button>-->
                </div>
            </div>
            {{ Form::close() }}

        </div>
        <div role="tabpanel" class="tab-pane <?php if(Session::get('change')) echo "active"; ?>" id="password" style="">

            <div class="clearfix">&nbsp;</div>
            {{ Form::open(array('route' => ['update-admin-account-password'], 'method' => 'post', 'class'=>'form-signin')) }}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4>Change
                            <br>
                            <small>Account Password</small>
                        </h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group form_item @if ($errors->has('new_password')) has-error @endif">
                        {{ Form::label('new_password','New Password*',array('id'=>'','class'=>'col-sm-2 control-label')) }}
                        <!--<label class="col-sm-2 control-label">New Password*</label>-->
                        <div class="col-sm-6">
                            <!--<input type="password" name="new_password" required="required" data-parsley-minlength="5" data-parsley-maxlength="25" class="form-control" value="">-->
                            {{ Form::password('new_password', array('class' => 'form-control', 'required', 'autofocus' => '', 'data-parsley-minlength'=>"5", 'data-parsley-maxlength'=>"25"))  }}
                            @if ($errors->has('new_password')) <p class="help-block" style="line-height: 14px ;">{{ $errors->first('new_password') }}</p> @endif
                        </div>
                        <div class="col-sm-4">
                            <code>length - from 6 to 12 symbols</code>
                        </div>
                    </div>
<!--                    <div class="form-group">
                        {{ Form::password('newpassword', array('class' => 'form-control', 'placeholder' => 'New Password*'))  }}
                    </div>-->
                    <div class="form-group form_item @if ($errors->has('new_password_confirmation')) has-error @endif">
                        {{ Form::label('new_password_confirmation','Confirm New Password*',array('id'=>'','class'=>'col-sm-2 control-label')) }}
                        <!--<label class="col-sm-2 control-label">Confirm New Password*</label>-->
                        <div class="col-sm-6">
                            <!--<input type="password" name="conf_new_password" required="required" data-parsley-minlength="5" data-parsley-maxlength="25" class="form-control" value="">-->
                            {{ Form::password('new_password_confirmation', array('class' => 'form-control', 'required', 'data-parsley-minlength'=>"6", 'data-parsley-maxlength'=>"12"))  }}
                            @if ($errors->has('new_password_confirmation')) <p class="help-block" style="line-height: 14px ;">{{ $errors->first('new_password_confirmation') }}</p> @endif
                        </div>
                        <div class="col-sm-4">
                            <code>length - from 6 to 12 symbols</code>
                        </div>
                    </div>
                    <div class="form-group form_item @if ($errors->has('old_password')) has-error @endif">
                        {{ Form::label('old_password','Old Password*',array('id'=>'','class'=>'col-sm-2 control-label')) }}
                        <!--<label class="col-sm-2 control-label">Old Password*</label>-->
                        <div class="col-sm-6">
                            <!--<input type="password" name="old_password" required="required" data-parsley-minlength="5" data-parsley-maxlength="25" class="form-control" value="">-->
                            {{ Form::password('old_password', array('class' => 'form-control', 'required', 'data-parsley-minlength'=>"6", 'data-parsley-maxlength'=>"12"))  }}
                            @if ($errors->has('old_password')) <p class="help-block" style="line-height: 14px ;">{{ $errors->first('old_password') }}</p> @endif
                        </div>
                        <div class="col-sm-4">
                            <code>length - from 6 to 12 symbols</code>
                        </div>
                    </div>
<!--                    <div class="form-group">
                        {{ Form::password('oldpassword', array('class' => 'form-control', 'placeholder' => 'Old Password*', 'required'))  }}
                    </div>-->
<!--                    <div class="form-group">
                        {{ Form::submit('Update Account', array('class'=>'btn btn-large btn-primary btn-block'))}}
                    </div>-->
                </div>
                <div class="panel-footer text-center">
                    {{ Form::submit("Save", array('class'=>'btn btn-info')) }}
                    <!--<button type="submit" name="save_brand" class="btn btn-info"><?php //echo "Save";  ?></button>-->
                </div>
            </div>
            {{ Form::close() }}

        </div>
    </div>

</div>


@stop