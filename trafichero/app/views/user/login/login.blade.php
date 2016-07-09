<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700,900' rel='stylesheet' type='text/css' />
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css' />

    <!-- Styles -->
    <link rel="stylesheet" href="font-awesome-4.2.0/css/font-awesome.css" type="text/css" /><!-- Font Awesome -->
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" /><!-- Bootstrap -->
    <link rel="stylesheet" href="css/style.css" type="text/css" /><!-- Style -->
    <link rel="stylesheet" href="css/responsive.css" type="text/css" /><!-- Responsive -->

</head>
<body style="background-image: url('images/resource/login-bg.jpg')">

<div class="login-sec">
    <div class="login">
        <div class="login-form">
            <span><img src="images/logo.png" alt="" /></span>
            <h5><strong>Identify</strong> Yourself</h5>
           {{ Form::open(array('route' => 'do_login', 'method' => 'post', 'id' => 'form', 'data-toggle' => 'validator', 'role' => 'form')) }}
                <fieldset>{{ Form::email('email', null, array('placeholder'=>'Email Address memb', 'required' => '', 'autofocus' => '')) }}<i class="fa fa-user"></i></fieldset>
                <fieldset>{{ Form::password('password', array('placeholder'=>'Password', 'required' => '')) }}<i class="fa fa-unlock-alt"></i></fieldset>
                <label><input type="checkbox" />Remember me</label><button type="submit" class="blue">LOG IN</button>
            {{ Form::close() }}
            </form>
            <a href="#" title="">Forgot Password?</a>
        </div>
        <ul class="reg-social-btns">
            <li><a href="#" title=""><i class="fa fa-facebook"></i></a></li>
            <li><a href="#" title=""><i class="fa fa-twitter"></i></a></li>
            <li><a href="#" title=""><i class="fa fa-github"></i></a></li>
            <li><a href="#" title=""><i class="fa fa-google-plus"></i></a></li>
        </ul>
        <span>Copyright © 2014 Azan Admin LLC</span>
    </div>
</div><!-- Log in Sec -->

</body>
</html>
@section('scripts')
{{HTML::script('js/jquery.js')}}
{{HTML::script('js/formValidation.js')}}
{{HTML::script('js/bootstrap.js')}}

<script type="text/javascript">

    $(document).ready(function() {
        $('#form').formValidation({
            err: {
                container: 'tooltip'
            },
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
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
                        identical: {
                            field: 'confirmPassword',
                            message: 'The password and its confirm are not the same'
                        },
                        different: {
                            field: 'username',
                            message: 'The password can\'t be the same as username'
                        },
                        stringLength: {
                            min: 6,
                            max: 12,
                            message: 'The username must be more than 6 and less than 12 characters long'
                        }
                    }
                }
            }
        });
    });

</script>
@stop