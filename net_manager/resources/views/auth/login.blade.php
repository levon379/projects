<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title></title>
    <link rel="stylesheet" href="/backend/vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/backend/vendor/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="/backend/app/css/bootstrap.css" id="bscss">
    <link rel="stylesheet" href="/backend/app/css/app.css" id="maincss">
</head>
<body>
   <div class="wrapper">
      <div class="block-center mt-xl wd-xl">
         <!-- START panel-->
         <div class="panel panel-dark panel-flat">
            <div class="panel-heading text-center">
               <a href="/">
                    360tennis.nl
                  {{-- <img src="img/logo.png" alt="Image" class="block-center img-rounded"> --}}
               </a>
            </div>
            <div class="panel-body">
                <p class="text-center pv">SIGN IN TO CONTINUE.</p>
                <form class="form-horizontal" role="form" method="POST" class="mb-lg" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input name="email" type="email" class="form-control"  value="{{ old('email') }}"  placeholder="Email">
                        <span class="fa fa-envelope form-control-feedback text-muted"></span>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input name="password" type="password" class="form-control" placeholder="Password">
                        <span class="fa fa-lock form-control-feedback text-muted"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="clearfix">
                        <div class="checkbox c-checkbox pull-left mt0">
                            <label>
                               <input type="checkbox" name="remember">
                               <span class="fa fa-check"></span>Remember Me
                            </label>
                        </div>
                        <div class="pull-right">
                            <a href="{{ url('/password/reset') }}" class="text-muted">Forgot your password?</a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary mt-lg">Login</button>
                </form>
                <p class="pt-lg text-center">Need to Signup?</p>
                <a href="/register" class="btn btn-block btn-default">Register Now</a>
            </div>
         </div>
         <!-- END panel-->
      </div>
   </div>
   <!-- =============== VENDOR SCRIPTS ===============-->
   <!-- JQUERY-->
   <script src="/backend/vendor/jquery/dist/jquery.js"></script>
   <!-- BOOTSTRAP-->
   <script src="/backend/vendor/bootstrap/dist/js/bootstrap.js"></script>
   <!-- PARSLEY-->
   <script src="/backend/vendor/parsleyjs/dist/parsley.min.js"></script>
   <!-- =============== APP SCRIPTS ===============-->
   <script src="/backend/app/js/app.js"></script>
</body>

</html>
