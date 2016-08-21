<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Bootstrap Admin App + jQuery">
    <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
    <title>NetManager 2.0</title>
    <!-- =============== VENDOR STYLES ===============-->
    <!-- FONT AWESOME-->
    <link rel="stylesheet" href="/backend/vendor/fontawesome/css/font-awesome.min.css">
    <!-- SIMPLE LINE ICONS-->
    <link rel="stylesheet" href="/backend/vendor/simple-line-icons/css/simple-line-icons.css">
    <!-- ANIMATE.CSS-->
    <link rel="stylesheet" href="/backend/vendor/animate.css/animate.min.css">
    <!-- WHIRL (spinners)-->
    <link rel="stylesheet" href="/backend/vendor/whirl/dist/whirl.css">
    <!-- =============== PAGE VENDOR STYLES ===============-->
    <!-- WEATHER ICONS-->
    <link rel="stylesheet" href="/backend/vendor/weather-icons/css/weather-icons.min.css">
    <!-- =============== BOOTSTRAP STYLES ===============-->
    <link rel="stylesheet" href="/backend/app/css/bootstrap.css" id="bscss">
    <!-- =============== Chosen Min CSS ===============-->
    <link rel="stylesheet" href="/backend/vendor/chosen_v1.2.0/chosen.min.css" id="bscss">
    <!-- =============== Jqcloud ===============-->
    <link rel="stylesheet" href="/backend/vendor/jqcloud2/dist/jqcloud.css" id="bscss">
    <!-- =============== APP STYLES ===============-->
    <link rel="stylesheet" href="/backend/app/css/app.css" id="maincss">
</head>

<body>
<div class="wrapper">
    <!-- start top navbar-->
    <header class="topnavbar-wrapper">
        <!-- START Top Navbar-->
        <nav role="navigation" class="navbar topnavbar">
            <!-- START navbar header-->
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#/" class="navbar-brand">
                    <div class="brand-logo">
                        <span style="color:#fff"> NetManager 2.0 </span>
                    </div>
                    <div class="brand-logo-collapsed">
                        <img src="img/logo-single.png" alt="App Logo" class="img-responsive">
                    </div>

                </a>

            </div>
            <div class="organization-dropdown col-md-3" style="padding: 10px;">
                <select class="form-control">
                    <option value="1">Organization 1</option>
                    <option value="2">Organization 2</option>
                    <option value="3">Organization 3</option>
                </select>
            </div>
            <!-- END navbar header-->
            <!-- START Nav wrapper-->
            <div class="navbar-collapse collapse">
                <!-- START Left navbar-->
                <ul class="nav navbar-nav">
                    {{--<li></li>--}}
                    {{--<li><a href="#dashboard" data-toggle="dropdown">Dashboard</a>--}}

                    {{--</li>--}}
                    {{--<li><a href="widgets.html">Widgets</a>--}}
                    {{--</li>--}}
                </ul>
                <!-- END Left navbar-->
                <!-- START Right Navbar-->
                <ul class="nav navbar-nav navbar-right">
                    <!-- START lock screen-->
                    <li class="dropdown">
                        <a href="lock.html" title="Lock screen">
                            <em class="icon-lock"></em>
                        </a>
                    </li>
                    <!-- END lock screen-->
                    <!-- Search icon-->
                    <li>
                        <a href="#" data-search-open="">
                            <em class="icon-magnifier"></em>
                        </a>
                    </li>
                    <!-- Fullscreen (only desktops)-->
                    <li class="visible-lg">
                        <a href="#" data-toggle-fullscreen="">
                            <em class="fa fa-expand"></em>
                        </a>
                    </li>
                    <!-- START Alert menu-->
                    <li class="dropdown dropdown-list">
                        <a href="#" data-toggle="dropdown">
                            <em class="icon-bell"></em>
                            <div class="label label-danger">11</div>
                        </a>
                        <!-- START Dropdown menu-->
                        <ul class="dropdown-menu animated flipInX">
                            <li>
                                <!-- START list group-->
                                <div class="list-group">
                                    <!-- list item-->
                                    <a href="#" class="list-group-item">
                                        <div class="media-box">
                                            <div class="pull-left">
                                                <em class="fa fa-twitter fa-2x text-info"></em>
                                            </div>
                                            <div class="media-box-body clearfix">
                                                <p class="m0">New followers</p>
                                                <p class="m0 text-muted">
                                                    <small>1 new follower</small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- list item-->
                                    <a href="#" class="list-group-item">
                                        <div class="media-box">
                                            <div class="pull-left">
                                                <em class="fa fa-envelope fa-2x text-warning"></em>
                                            </div>
                                            <div class="media-box-body clearfix">
                                                <p class="m0">New e-mails</p>
                                                <p class="m0 text-muted">
                                                    <small>You have 10 new emails</small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- list item-->
                                    <a href="#" class="list-group-item">
                                        <div class="media-box">
                                            <div class="pull-left">
                                                <em class="fa fa-tasks fa-2x text-success"></em>
                                            </div>
                                            <div class="media-box-body clearfix">
                                                <p class="m0">Pending Tasks</p>
                                                <p class="m0 text-muted">
                                                    <small>11 pending task</small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- last list item -->
                                    <a href="#" class="list-group-item">
                                        <small>More notifications</small>
                                        <span class="label label-danger pull-right">14</span>
                                    </a>
                                </div>
                                <!-- END list group-->
                            </li>
                        </ul>
                        <!-- END Dropdown menu-->
                    </li>
                    <!-- END Alert menu-->
                    <!-- START Contacts button-->
                    <li>
                        <a href="#" data-toggle-state="offsidebar-open" data-no-persist="true">
                            <em class="icon-notebook"></em>
                        </a>
                    </li>
                    <!-- END Contacts menu-->
                </ul>
                <!-- END Right Navbar-->
            </div>
            <!-- END Nav wrapper-->
            <!-- START Search form-->
            <form role="search" action="search.html" class="navbar-form">
                <div class="form-group has-feedback">
                    <input type="text" placeholder="Type and hit enter ..." class="form-control">
                    <div data-search-dismiss="" class="fa fa-times form-control-feedback"></div>
                </div>
                <button type="submit" class="hidden btn btn-default">Submit</button>
            </form>
            <!-- END Search form-->
        </nav>
        <!-- END Top Navbar-->
    </header>
    <!-- start sidenav-->
    @include('backend.partials.sidebar')
    
    <section>
        @yield('content')
    </section>
</div>
<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
@yield('javascripts')
<!-- MODERNIZR-->
<script src="/backend/vendor/modernizr/modernizr.custom.js"></script>
<!-- MATCHMEDIA POLYFILL-->
<script src="/backend/vendor/matchMedia/matchMedia.js"></script>
<!-- JQUERY-->
<script src="/backend/vendor/jquery/dist/jquery.js"></script>
<!-- BOOTSTRAP-->
<script src="/backend/vendor/bootstrap/dist/js/bootstrap.js"></script>
<!-- STORAGE API-->
<script src="/backend/vendor/jQuery-Storage-API/jquery.storageapi.js"></script>
<!-- JQUERY EASING-->
<script src="/backend/vendor/jquery.easing/js/jquery.easing.js"></script>
<!-- ANIMO-->
<script src="/backend/vendor/animo.js/animo.js"></script>
<!-- SLIMSCROLL-->
<script src="/backend/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<!-- SCREENFULL-->
<script src="/backend/vendor/screenfull/dist/screenfull.js"></script>
<!-- LOCALIZE-->
<script src="/backend/vendor/jquery-localize-i18n/dist/jquery.localize.js"></script>
<!-- RTL demo-->
<script src="/backend/app/js/demo/demo-rtl.js"></script>
<!-- =============== PAGE VENDOR SCRIPTS ===============-->
<!-- SPARKLINE-->
<script src="/backend/vendor/sparkline/index.js"></script>
<!-- FLOT CHART-->
<script src="/backend/vendor/Flot/jquery.flot.js"></script>
<script src="/backend/vendor/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="/backend/vendor/Flot/jquery.flot.resize.js"></script>
<script src="/backend/vendor/Flot/jquery.flot.pie.js"></script>
<script src="/backend/vendor/Flot/jquery.flot.time.js"></script>
<script src="/backend/vendor/Flot/jquery.flot.categories.js"></script>
<script src="/backend/vendor/flot-spline/js/jquery.flot.spline.min.js"></script>
<!-- CLASSY LOADER-->
<script src="/backend/vendor/jquery-classyloader/js/jquery.classyloader.min.js"></script>
<!-- MOMENT JS-->
<script src="/backend/vendor/moment/min/moment-with-locales.min.js"></script>
<!-- SKYCONS-->
<script src="/backend/vendor/skycons/skycons.js"></script>
<!-- DEMO-->
<script src="/backend/app/js/demo/demo-flot.js"></script>
<!-- =============== APP SCRIPTS ===============-->
<script src="/backend/app/js/app.js"></script>
<script src="/ckeditor/ckeditor.js"></script>
<script src="/backend/vendor/chosen_v1.2.0/chosen.jquery.min.js"></script>
<script src="/backend/vendor/jqcloud2/dist/jqcloud.js"></script>
@yield('javascriptckedit')
</body>
</html>
