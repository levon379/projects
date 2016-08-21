<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Houston Ecoart</title>

	<meta name="description" content="">

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="/assets/css/bootstrap/bootstrap.css" />

    <!-- Fonts  -->
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,500,600,700,300' rel='stylesheet' type='text/css'>

    <!-- Base Styling  -->
    <link rel="stylesheet" href="/assets/css/app/app.v1.css" />

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        body {
            display: table;
            position: absolute;
            height: 100%;
            width: 100%;
        }

        .container {
            display: table-cell;
            vertical-align: middle;
        }
    </style>

</head>
<body>


    <div class="container login-container">
    	<div class="row login-row">
    	<div class="col-lg-4 login">
        	<h3 class="text-center"><img src="/assets/images/ecoart/logo.png"/></h3>
            <hr class="clean">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form role="form" role="form" method="POST" action="/auth/login">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group input-group">
              	<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="text" class="form-control"  placeholder="Username" name="username" value="{{ old('email') }}">
              </div>
              <div class="form-group input-group">
              	<span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="password" class="form-control"  placeholder="Password" name="password">
              </div>
              <div class="form-group">
                <label class="cr-styled">
                    <input type="checkbox" name="remember" ng-model="todo.done">
                    <i class="fa"></i>
                </label>
                Remember me
              </div>
        	  <button type="submit" class="btn btn-purple btn-block">Sign in</button>
            </form>
            <hr>

            <p class="text-center text-gray">Dont have account yet!</p>
            <button type="submit" class="btn btn-default btn-block">Create Account</button>
        </div>
        </div>
    </div>



    <!-- JQuery v1.9.1 -->
	<script src="/assets/js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="/assets/js/plugins/underscore/underscore-min.js"></script>
    <!-- Bootstrap -->
    <script src="/assets/js/bootstrap/bootstrap.min.js"></script>

    <!-- Globalize -->
    <script src="/assets/js/globalize/globalize.min.js"></script>

    <!-- NanoScroll -->
    <script src="/assets/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>



	<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-56821827-1', 'auto');
    ga('send', 'pageview');

    </script>
</body>
</html>
