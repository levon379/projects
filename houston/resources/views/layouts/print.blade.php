<!DOCTYPE html>
<html lang="en">

<head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Houston Ecoart</title>

	<meta name="description" content="">
    <link href='http://fonts.googleapis.com/css?family=Montserrat:700' rel='stylesheet'>
    <link href='http://fonts.googleapis.com/css?family=Lato:700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="/assets/css/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/vouchers/print-voucher.css">

</head>
<body>
    @yield('content')
    <!-- JQuery v1.11.2 -->
	<script src="/assets/js/jquery/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="/assets/js/plugins/print-this/print-this.js" type="text/javascript"></script>

	<script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-56821827-1', 'auto');
        ga('send', 'pageview');
    
    </script>

    @yield('script','')

</body>
</html>
