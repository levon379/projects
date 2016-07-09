<head>
  <meta http-equiv="content-type" content="text/html" charset="UTF-8" />
  <title> @yield('title') </title>
  
@yield('canonical')

<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/main.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/bootstrapValidator.min.css') }}" />

<script src="{{ URL::asset('js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/main.js') }}"></script>
<script src="{{ URL::asset('js/bootstrapValidator.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.popconfirm.js') }}"></script>

@yield('css')

<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="/images/favicon.ico" type="image/x-icon">

@yield('js_head')
@yield('head')
@yield('keywords')
@yield('description')
  
</head>
