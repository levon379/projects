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

    <!-- Bootstrap jasny CSS -->
    <link rel="stylesheet" href="/assets/css/plugins/jasny-bootstrap/jasny-bootstrap.css"/>

    <!-- Bootstrap fileinput CSS -->
    <link rel="stylesheet" href="/assets/css/plugins/fileinput/fileinput.css" />

    <!-- Bootstrap multiselect CSS -->
    <link rel="stylesheet" href="/assets/css/plugins/bootstrap-multiselect/bootstrap-multiselect.css" />

    <!-- Bootstrap datepicker CSS -->
    <link rel="stylesheet" href="/assets/css/plugins/bootstrap-datepicker/bootstrap-datepicker.css" />

    <!-- Bootstrap select2 CSS -->
    <link rel="stylesheet" href="/assets/css/plugins/bootstrap-select2/select2.css" />

    <!-- Bootstrap select2-bootstrap CSS -->
    <link rel="stylesheet" href="/assets/css/plugins/bootstrap-select2/select2-bootstrap.css" />

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="/assets/css/plugins/sweet-alert/sweetalert2.css" />


    <!-- Calendar Styling  -->
    <link rel="stylesheet" href="/assets/css/plugins/calendar/calendar.css" />

	<!-- Typeahead Styling  -->
    <link rel="stylesheet" href="/assets/css/plugins/typeahead/typeahead.css" />

    <!-- TagsInput Styling  -->
    <link rel="stylesheet" href="/assets/css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" />

    <!-- DateTime Picker  -->
    <link rel="stylesheet" href="/assets/css/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css" />

    <!-- Switch Buttons  -->
    <link rel="stylesheet" href="/assets/css/switch-buttons/switch-buttons.css" />

	<!-- datatables Styling  -->
    <link rel="stylesheet" href="/assets/css/plugins/datatables/jquery.dataTables.css" />

    <!-- Fonts  -->
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,500,600,700,300' rel='stylesheet' type='text/css'>

    <!-- Minicolors -->
    <link rel="stylesheet" href="/assets/css/plugins/minicolors/jquery.minicolors.css">

    <!-- Base Styling  -->
    <link rel="stylesheet" href="/assets/css/app/app.v1.css?v=19" />

	<!-- Froala Wysiwyg Editor Styling -->
	<link href="/assets/css/plugins/froala-wysiwyg/froala_editor.min.css" rel="stylesheet" type="text/css">
	<link href="/assets/css/plugins/froala-wysiwyg/froala_style.min.css" rel="stylesheet" type="text/css">
	
	<!-- Starrr Plugin -->
	<link href="/assets/css/plugins/bootstrap-starrr/starrr.min.css" rel="stylesheet" type="text/css">
	
	<!-- Editable Plugin -->
	<link href="/assets/css/plugins/bootstrap-editable/bootstrap-editable.css" rel="stylesheet" type="text/css">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

    <div id="main-wrapper" class="{{ (isset($_COOKIE['sidebar_closed']) and ($_COOKIE['sidebar_closed'] === 'yes')) ? 'collapsed-main' : '' }}">
        <aside class="left-panel {{ (isset($_COOKIE['sidebar_closed']) and ($_COOKIE['sidebar_closed'] === 'yes')) ? 'collapsed' : '' }}">

                <div class="user text-center">
                      <a href="{{ URL::to('/admin') }}"><img src="/assets/images/ecoart/logo-sm.png" class="img-responsive">
                      <h4 class="user-name">{{ Auth::user()->firstname." ".Auth::user()->lastname }}</h4>

                    <div class="dropdown user-login">
                        <a class="btn btn-xs dropdown-toggle btn-rounded" href="/auth/logout">
                            <i class="fa fa-circle status-icon signout"></i> Signout
                        </a>
                        <a class="btn btn-xs dropdown-toggle btn-rounded" href="/admin/profile">
                            <i class="fa fa-circle status-icon available"></i> Edit Profile
                        </a>
                    </div>
                </div>



                <nav class="navigation">
                    <ul class="list-unstyled">
                        <li class="has-submenu {{ Request::is('admin') || Request::is('admin/tour-manager*')  || Request::is('admin/statistics*') || Request::is('admin/tour-assignment-calendar*')? 'active' : '' }}"><a href="#"><i class="fa fa-bookmark-o"></i> <span class="nav-label">Dashboard</span></a>
                            <ul class="list-unstyled">
                                @if(Auth::user()->user_type_id != \App\UserType::GUIDE)
                                <li class="{{ Request::is('admin/tour-manager*') ? 'active' : '' }}"><a href="/admin/tour-manager?sd={{Carbon\Carbon::parse('now')->format('d/m/Y')}}">Tour Manager</a></li>
                                @endif
                                <li class="{{ Request::is('admin/tour-assignment-calendar*') ? 'active' : '' }}"><a href="/admin/tour-assignment-calendar">Tour Assignment Calendar</a></li>
                                @if(Auth::user()->user_type_id != \App\UserType::GUIDE)
                                <li class="{{ Request::is('admin/statistics') ? 'active' : '' }}"><a href="/admin/statistics">Statistics</a></li>
                                @endif
                            </ul>
                        </li>
                        @if(Auth::user()->user_type_id != \App\UserType::GUIDE)
                        <li class="has-submenu {{ Request::is('admin/bookings*') || Request::is('admin/orders*') || Request::is('admin/source/add') || Request::is('admin/source/list') ? 'active' : '' }}"><a href="#"><i class="fa fa-bullhorn"></i> <span class="nav-label">Bookings</span></a>
                            <ul class="list-unstyled">
                                {{--
                                <li class="{{ Request::is('admin/bookings') ? 'active' : '' }}"><a href="/admin/bookings">Bookings</a></li>
                                --}}
                                <li class="{{ Request::is('admin/bookings/add') ? 'active' : '' }}"><a href="/admin/bookings/add">Add Booking</a></li>
                                <li class="{{ Request::is('admin/bookings/search*') ? 'active' : '' }}"><a href="/admin/bookings/search?bf={{Carbon\Carbon::parse('now')->format('d/m/Y')}}&bt={{Carbon\Carbon::parse('now')->format('d/m/Y')}}">Bookings Search</a></li>
                                <li class="{{ Request::is('admin/source/list') ? 'active' : '' }}"><a href="/admin/source/list">Net Rates List</a></li>
                                <li class="{{ Request::is('admin/source/add') ? 'active' : '' }}"><a href="/admin/source/add">Add Net Rates</a></li>
                                <li class="{{ Request::is('admin/orders') ? 'active' : '' }}"><a href="/admin/orders">Orders</a></li>
                                <li class="{{ Request::is('admin/vouchers') ? 'active' : '' }}"><a href="/admin/vouchers">Vouchers</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu {{ Request::is('admin/reviews*') || Request::is('admin/feedback-emails*')? 'active' : '' }}"><a href="#"><i class="fa fa-pencil-square-o"></i> <span class="nav-label">Reviews</span></a>
                            <ul class="list-unstyled">
                                <li class="{{ Request::is('admin/reviews') ? 'active' : '' }}"><a href="/admin/reviews">Reviews</a></li>
                                <li class="{{ Request::is('admin/reviews/sources') ? 'active' : '' }}"><a href="/admin/reviews/sources">Review Sources</a></li>
                                <li class="{{ Request::is('admin/feedback-emails') ? 'active' : '' }}"><a href="/admin/feedback-emails">Feedback Emails</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu {{ Request::is('admin/promos*') ? 'active' : '' }}"><a href="#"><i class="fa fa-bullhorn"></i> <span class="nav-label">Promos</span></a>
                            <ul class="list-unstyled">
                                <li class="{{ Request::is('admin/promos') ? 'active' : '' }}"><a href="/admin/promos">Promos</a></li>
                                <li class="{{ Request::is('admin/promos/types') ? 'active' : '' }}"><a href="/admin/promos/types">Promo Types</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu {{ Request::is('admin/products*') || Request::is('admin/categories*') || Request::is('admin/addons*')? 'active' : '' }}"><a href="#"><i class="fa fa-dropbox"></i> <span class="nav-label">Products</span></a>
                            <ul class="list-unstyled">
                                <li class="{{ Request::is('admin/products') ? 'active' : '' }}"><a href="/admin/products">Products</a></li>
                                <li class="{{ Request::is('admin/products/types') ? 'active' : '' }}"><a href="/admin/products/types">Product Types</a></li>
                                <li class="{{ Request::is('admin/products/images/placements') ? 'active' : '' }}"><a href="/admin/products/images/placements">Product Image Placements</a></li>
                                <li class="{{ Request::is('admin/products/videos/placements') ? 'active' : '' }}"><a href="/admin/products/videos/placements">Product Video Placements</a></li>
                                <li class="{{ Request::is('admin/categories') ? 'active' : '' }}"><a href="/admin/categories">Categories</a></li>
                                <li class="{{ Request::is('admin/addons') ? 'active' : '' }}"><a href="/admin/addons">Addons</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu {{ Request::is('admin/services*') ? 'active' : '' }}"><a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Services</span></a>
                            <ul class="list-unstyled">
                                <li class="{{ Request::is('admin/services') || Request::is('admin/services/options/*') || Request::is('admin/services/*/options') ? 'active' : '' }}"><a href="/admin/services">Services</a></li>
                                <li class="{{ Request::is('admin/services/types') ? 'active' : '' }}"><a href="/admin/services/types">Service Types</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu {{ Request::is('admin/forms*') || Request::is('admin/users*') || Request::is('admin/availability*') || Request::is('admin/sources*') || Request::is('admin/payment-methods*') || Request::is('admin/websites*') || Request::is('admin/providers*') || Request::is('admin/languages*') || Request::is('admin/departure-city*') || Request::is('admin/currency*') || Request::is('admin/tour-fees*') || Request::is('admin/faqs*') ? 'active' : '' }}"><a href="#"><i class="fa fa-bars"></i> <span class="nav-label">Forms</span></a>
                            <ul class="list-unstyled">
                                <li class="{{ Request::is('admin/users') ? 'active' : '' }}"><a href="/admin/users">Users</a></li>
                                <li class="{{ Request::is('admin/users/types') ? 'active' : '' }}"><a href="/admin/users/types">User Types</a></li>
                                <li class="{{ Request::is('admin/availability/slots') ? 'active' : '' }}"><a href="/admin/availability/slots">Availability Slots</a></li>
                                <li class="{{ Request::is('admin/availability/rules') ? 'active' : '' }}"><a href="/admin/availability/rules">Availability Rules</a></li>
                                <li class="{{ Request::is('admin/sources/groups') ? 'active' : '' }}"><a href="/admin/sources/groups">Source Groups</a></li>
                                <li class="{{ Request::is('admin/sources/names') ? 'active' : '' }}"><a href="/admin/sources/names">Source Names</a></li>
                                <li class="{{ Request::is('admin/payment-methods') ? 'active' : '' }}"><a href="/admin/payment-methods">Payment Methods</a></li>
                                <li class="{{ Request::is('admin/websites') ? 'active' : '' }}"><a href="/admin/websites">Websites</a></li>
                                <li class="{{ Request::is('admin/providers') ? 'active' : '' }}"><a href="/admin/providers">Providers</a></li>
                                <li class="{{ Request::is('admin/languages') ? 'active' : '' }}"><a href="/admin/languages">Languages</a></li>
                                <li class="{{ Request::is('admin/departure-city') ? 'active' : '' }}"><a href="/admin/departure-city">Departure City</a></li>
                                <li class="{{ Request::is('admin/currency') ? 'active' : '' }}"><a href="/admin/currency">Currency</a></li>
                                <li class="{{ Request::is('admin/tour-fees') ? 'active' : '' }}"><a href="/admin/tour-fees">Tour Fees</a></li>
                                <li class="{{ Request::is('admin/faqs') ? 'active' : '' }}"><a href="/admin/faqs">FAQs</a></li>
                           </ul>
                        </li>
                        @endif

                    </ul>
                </nav>

        </aside>
        <!-- Aside Ends-->

        <section class="content">

            <header class="top-head container-fluid">
                <button type="button" class="navbar-toggle pull-left">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </header>
            <!-- Header Ends -->


            <div class="warper container-fluid">
                @yield('content')
            </div>
            <!-- Warper Ends Here (working area) -->

            <!--

            <footer class="container-fluid footer">
                Copyright &copy; 2014 <a href="http://houston.ecoart.com/" target="_blank">Houston Ecoart</a>
                <a href="#" class="pull-right scrollToTop"><i class="fa fa-chevron-up"></i></a>
            </footer>

            -->

        </section>
    </div>

    <!-- Content Block Ends Here (right box)-->


    <!-- JQuery v1.11.2 -->
	<script src="/assets/js/jquery/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="/assets/js/jquery/jquery-ui.js" type="text/javascript"></script>
    <script src="/assets/js/plugins/underscore/underscore-min.js"></script>
    <!-- Bootstrap -->
    <script src="/assets/js/bootstrap/bootstrap.min.js"></script>

    <!-- Bootstrap jasny -->
    <script src="/assets/js/plugins/jasny-bootstrap/jasny-bootstrap.js"></script>

    <!-- Bootstrap fileinput -->
    <script src="/assets/js/plugins/fileinput/fileinput.min.js"></script>

    <!-- Bootstrap multiselect -->
    <script src="/assets/js/plugins/bootstrap-multiselect/bootstrap-multiselect.js"></script>

    <!-- Bootstrap datepicker -->
    <script src="/assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

    <!-- Bootstrap select2 -->
    <script src="/assets/js/plugins/bootstrap-select2/select2.min.js"></script>

    <!-- Sweet Alert -->
    <script src="/assets/js/plugins/sweet-alert/sweetalert2.min.js"></script>
    
    <!-- Globalize -->
    <script src="/assets/js/globalize/globalize.min.js"></script>
    
    <!-- NanoScroll -->
    <script src="/assets/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
    
    <!-- Chart JS -->
    <script src="/assets/js/plugins/DevExpressChartJS/dx.chartjs.js"></script>
    <script src="/assets/js/plugins/DevExpressChartJS/world.js"></script>
   	<!-- For Demo Charts -->
    <script src="/assets/js/plugins/DevExpressChartJS/demo-charts.js"></script>
    <script src="/assets/js/plugins/DevExpressChartJS/demo-vectorMap.js"></script>
    
    <!-- Sparkline JS -->
    <script src="/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- For Demo Sparkline -->
    <script src="/assets/js/plugins/sparkline/jquery.sparkline.demo.js"></script>
    
    <!-- Angular JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.14/angular.min.js"></script>
    <!-- ToDo List Plugin -->
    
    
    <!-- Calendar JS -->
    <script src="/assets/js/plugins/calendar/calendar.js"></script>
    <!-- Calendar Conf -->
	
    <!-- NiceScroll -->
    <script src="/assets/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
    
	<!-- TypeaHead -->
    <script src="/assets/js/plugins/typehead/typeahead.bundle.js"></script>
    <script src="/assets/js/plugins/typehead/typeahead.bundle-conf.js"></script>
    
    <!-- InputMask -->
    <script src="/assets/js/plugins/inputmask/jquery.inputmask.bundle.js"></script>
    
    <!-- TagsInput -->
    <script src="/assets/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    
    <!-- moment -->
    <script src="/assets/js/moment/moment.js"></script>
    
    <!-- DateTime Picker -->
    <script src="/assets/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>

    <!-- HandleBarsJs -->
    <script src="/assets/js/plugins/handlebars/handlebars-v3.0.0.js"></script>
    
    <!-- Custom JQuery -->
	<script src="/assets/js/app/custom.js?v=9" type="text/javascript"></script>

    <!-- Custom Js.Cookie.js -->
    <script src="/assets/js/app/js.cookie.js" type="text/javascript"></script>
    
	<!-- Sparkline JS -->
    <script src="/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>

	<!-- Data Table -->
    <script src="/assets/js/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/assets/js/plugins/datatables/DT_bootstrap.js"></script>
    <script src="/assets/js/plugins/datatables/jquery.dataTables-conf.js"></script>

	<!-- Froala Wysiwyg -->
	<script src="/assets/js/plugins/froala-wysiwyg/froala_editor.min.js"></script>
	<!--[if lt IE 9]>
	<script src="/assets/js/plugins/froala-wysiwyg/froala_editor_ie8.min.js"></script>
	<![endif]-->
	
	<!-- Froala Wysiwyg Plugins -->
	<script src="/assets/js/plugins/froala-wysiwyg/plugins/block_styles.min.js"></script>
	<script src="/assets/js/plugins/froala-wysiwyg/plugins/colors.min.js"></script>
	<script src="/assets/js/plugins/froala-wysiwyg/plugins/char_counter.min.js"></script>
	<script src="/assets/js/plugins/froala-wysiwyg/plugins/file_upload.min.js"></script>
	<script src="/assets/js/plugins/froala-wysiwyg/plugins/font_family.min.js"></script>
	<script src="/assets/js/plugins/froala-wysiwyg/plugins/font_size.min.js"></script>
	<script src="/assets/js/plugins/froala-wysiwyg/plugins/fullscreen.min.js"></script>
	<script src="/assets/js/plugins/froala-wysiwyg/plugins/lists.min.js"></script>
	<script src="/assets/js/plugins/froala-wysiwyg/plugins/inline_styles.min.js"></script>
	<script src="/assets/js/plugins/froala-wysiwyg/plugins/media_manager.min.js"></script>
	<script src="/assets/js/plugins/froala-wysiwyg/plugins/tables.min.js"></script>
	<script src="/assets/js/plugins/froala-wysiwyg/plugins/urls.min.js"></script>
	<script src="/assets/js/plugins/froala-wysiwyg/plugins/video.min.js"></script>
	
	<!-- Starrr Plugin -->
	<script src="/assets/js/plugins/bootstrap-starrr/starrr.min.js"></script>
	
	<!-- Editable Plugin -->
	<script src="/assets/js/plugins/bootstrap-editable/bootstrap-editable.js"></script>

    <!-- Minicolors -->
	<script src="/assets/js/plugins/minicolors/jquery.minicolors.js"></script>

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
