<!DOCTYPE html>
<html>
<head>
    <title>Login and Registration Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{HTML::style('css/bootstrap.css')}}
    {{HTML::style('css/formValidation.css')}}
    {{HTML::style('css/site.css')}}
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if(Session::has('message'))
                <p class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ Session::get('message') }}</p>
            @endif
            @if(Session::has('error'))
                <p class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ Session::get('error') }}</p>
            @endif
            @if($errors->first())
                <!-- if there are login errors, show them here -->
                <p class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ $errors->first('email') }}
                    {{ $errors->first('password') }}
                </p>
            @endif
        </div>
        <div class="wrapper">
            {{Form::open(array('url' => 'admin/postRegister', 'class'=>'form-signin form-horizontal fv-form fv-form-bootstrap', 'method' => 'post', 'id' => 'form_register', 'data-toggle' => 'validator', 'role' => 'form')) }}
            <h2 class="form-signin-heading">Register</h2>
            <div class="form-group">
            {{Form::label('username','User')}}
            {{Form::text('username', null, array('class' => 'form-control','placeholder' => 'Pick a username', 'required' => '', 'autofocus' => ''))}}
            </div>
            <div class="form-group">
            {{Form::label('password','Password')}}
            {{Form::password('password',array('class' => 'form-control','placeholder' => 'Create a password', 'required' => ''))}}
            </div>
            <div class="form-group">
            {{Form::label('email','Email')}}
            {{Form::email('email','',array('class' => 'form-control','placeholder' => 'Your email', 'required' => ''))}}
            </div>
            <div class="form-group">
                {{ Form::submit('Login', array('class'=>'btn btn-large btn-primary btn-block'))}}
            </div>
            {{Form::close() }}
        </div>
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Remind password</h4>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(array('route'=> 'password-reminder', 'method' => 'post')) }}
                        <div class="input-group">
                            {{ Form::text('email',Input::old('email'),array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
                            <span class="input-group-btn">
                                {{ Form::submit('Send Reminder', array('class'=>'btn btn-warning'))}}
                            </span>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</div>
{{HTML::script('js/jquery.js')}}
{{HTML::script('js/formValidation.js')}}
{{HTML::script('js/bootstrap.m.js')}}
{{HTML::script('js/bootstrap.js')}}
        <script type="text/javascript">

            $(document).ready(function() {
                $('#form_register').formValidation({
                    err: {
                        container: 'tooltip'
                    },
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        username: {
                            message: 'The username is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The username is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 30,
                                    message: 'The username must be more than 2 and less than 30 characters long'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z0-9_\-\.]+$/,
                                    message: 'The username can only consist of alphabetical, number, dot and underscore'
                                },
                                different: {
                                    field: 'password',
                                    message: 'The username and password can\'t be the same as each other'
                                }
                            }
                        },
                        email: {
                            validators: {
                                notEmpty: {
                                    message: 'The email address is required and can\'t be empty'
                                },
                                emailAddress: {
                                    message: 'The input is not a valid email address'
                                }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: 'The password is required and can\'t be empty'
                                },
                                different: {
                                    field: 'username',
                                    message: 'The password can\'t be the same as username'
                                },
                                stringLength: {
                                    min: 6,
                                    max: 12,
                                    message: 'The password must be more than 6 and less than 12 characters long'
                                }
                            }
                        }
                    }
                });
            });
        </script>

</body>
</html>