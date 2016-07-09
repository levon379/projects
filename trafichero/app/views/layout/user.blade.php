<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel</title>
        <title>Login and Registration Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700,900' rel='stylesheet' type='text/css' />
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css' />
        {{HTML::style('font-awesome-4.2.0/css/font-awesome.css')}}
        {{HTML::style('css/daterangepicker-bs3.css')}}
        {{HTML::style('css/bootstrap.css')}}
        {{HTML::style('css/rickshaw.css')}}
        {{HTML::style('css/style.css')}}
        {{HTML::style('css/responsive.css')}}
        {{HTML::style('css/hover.css')}}
        @yield('styles')
    </head>
    <body>
<?php // echo "<pre>";var_dump($user_sites);die; ?>
        <div class="main">
            <div id="live-chat">
                <!--<div class="clearfix gray chat-header">
                        <a href="#" class="chat-close">-</a>
                        <h4>{{Auth::User()->first_name}} {{Auth::User()->last_name}}</h4>
                        <span class="chat-message-counter">3</span>
                </div>-->
                <div class="chat" style="display:none;">
                    <div class="chat-history">
                        <div class="chat-message">
                            <img src="{{ URL::asset('images/resource/sender1.jpg')}}" alt="" width="32" height="32" />
                            <div class="chat-message-content">
                                <span class="chat-time">11:54</span>
                                <h5>John Doe</h5>
                                <p>Lorem ipsum dolor. Error, explicabo quasi ratione odio dolorum harum.</p>
                            </div> <!-- end chat-message-content -->
                        </div> <!-- end chat-message -->
                        <div class="chat-message">
                            <img src="{{ URL::asset('images/resource/sender2.jpg')}}" alt="" width="32" height="32" />
                            <div class="chat-message-content">
                                <span class="chat-time">12:43</span>
                                <h5>Marco Biedermann</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            </div> <!-- end chat-message-content -->
                        </div> <!-- end chat-message -->
                        <div class="chat-message">
                            <img src="{{ URL::asset('images/resource/sender1.jpg')}}" alt="" width="32" height="32" />
                            <div class="chat-message-content">
                                <span class="chat-time">12:23</span>
                                <h5>John Doe</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                            </div> <!-- end chat-message-content -->
                        </div> <!-- end chat-message -->
                    </div> <!-- end chat-history -->
                    <p class="chat-feedback">Your partner is typing… <img src="{{ URL::asset('images/ajax-loader.gif')}}" alt="" /></p>
                    <form action="#" method="post">
                        <fieldset>
                            <input type="text" placeholder="Type your message…" autofocus>
                            <input type="hidden">
                        </fieldset>
                    </form>
                </div> <!-- end chat -->
            </div> <!-- end live-chat -->

            <header class="header">
                <div class="logo">
                    <a href="dashboard" title=""><img src="{{ URL::asset('images/logo2.png')}}" alt="" /></a>
                    <a title="" class="toggle-menu"><i class="fa fa-bars"></i></a>
                </div>
                <form class="search"><input type="text" placeholder="Search..." /><button type="button"><i class="fa fa-search"></i></button></form>
                <div class="custom-dropdowns">
                    <div class="message-list dropdown">
                        <a title=""><span class="blue">4</span><i class="fa fa-envelope-o"></i></a>
                        <div class="message drop-list">
                            <span>You have 4 New Messages</span>
                            <ul>
                                <li>
                                    <a title=""><span><img src="{{ URL::asset('images/resource/sender1.jpg')}}" alt="" /></span><i>{{Auth::User()->first_name}} {{Auth::User()->last_name}}</i>Hi! How are you?...<h6>2 min ago..</h6><p class="status blue">New</p></a>
                                </li>
                                <li>
                                    <a href="#" title=""><span><img src="{{ URL::asset('images/resource/sender2.jpg')}}" alt="" /></span><i>Jonathan</i>Hi! How are you?...<h6>2 min ago..</h6><p class="status red">Unsent</p></a>
                                </li>
                                <li>
                                    <a href="#" title=""><span><img src="{{ URL::asset('images/resource/sender3.jpg')}}" alt="" /></span><i>Barada knol</i>Hi! How are you?...<h6>2 min ago..</h6><p class="status green">Reply</p></a>
                                </li>
                                <li>
                                    <a href="#" title=""><span><img src="{{ URL::asset('images/resource/sender4.jpg')}}" alt="" /></span><i>Samtha Gee</i>Hi! How are you?...<h6>2 min ago..</h6><p class="status">New</p></a>
                                </li>
                            </ul>
                            <a href="inbox.html" title="">See All Messages</a>
                        </div>
                    </div><!-- Message List -->
                    <div class="notification-list dropdown">
                        <a title=""><span class="green">3</span><i class="fa fa-bell-o"></i></a>
                        <div class="notification drop-list">
                            <span>You have 3 New Notifications</span>
                            <ul>
                                <li>
                                    <a href="#" title=""><span><i class="fa fa-bug red"></i></span>Server 3 is Over Loader Please Check... <h6>2 min ago..</h6></a>
                                </li>
                                <li>
                                    <a href="#" title=""><span><img src="{{ URL::asset('images/resource/sender2.jpg')}}" alt="" /></span><i>MD Daisal</i>New User Registered<h6>4 min ago..</h6><p class="status red">Urgent</p></a>
                                </li>
                                <li>
                                    <a href="#" title=""><span><i class="fa fa-bullhorn green"></i></span>Envato Has change the policies<h6>7 min ago..</h6></a>
                                </li>
                            </ul>
                            <a href="#" title="">See All Notifications</a>
                        </div>
                    </div><!-- Notification List -->
                    <div class="activity-list dropdown">
                        <a title=""><span class="red">4</span><i class="fa fa-clock-o"></i></a>
                        <div class="activity drop-list">
                            <span>Recent Activity</span>
                            <ul>
                                <li>
                                    <a href="#" title=""><span><img src="{{ URL::asset('images/resource/sender2.jpg')}}" alt="" /></span><i>Jona Than</i>Uploading new files<h6>2 min ago..</h6><p class="status green">Online</p></a>
                                    <div class="progress">
                                        <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar blue">
                                            60%
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="#" title=""><span><img src="{{ URL::asset('images/resource/sender1.jpg')}}" alt="" /></span><i>Bela Nisaa</i>Downloading new Documents<h6>2 min ago..</h6></a>
                                    <div class="progress">
                                        <div style="width: 34%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="34" role="progressbar" class="progress-bar red">
                                            34%
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <a href="#" title="">See All Activity</a>
                        </div>
                    </div><!-- Activity List -->
                </div>
                <a title="" class="slide-panel-btn"><i class="fa fa-gear fa-spin"></i></a>
                <div class="dropdown profile">
                    <a title="">
                        <img src="{{ URL::asset('images/resource/me.jpg')}}" alt="" />{{Auth::User()->first_name}} {{Auth::User()->last_name}}<i class="caret"></i>
                    </a>
                    <div class="profile drop-list">
                        <ul>
                            <li><a href="#" title=""><i class="fa fa-edit"></i> New post</a></li>
                            <li><a href="#" title=""><i class="fa fa-wrench"></i> Setting</a></li>
                            <li><a href="/profile" title=""><i class="fa fa-user"></i> Profile</a></li>
                            <li><a href="/logout"<?php // echo route('member_logout');  ?> title=""><i class="fa fa-power-off"></i>Log Out</a></li>
                        </ul>
                    </div><!-- Profile DropDown -->

                </div>
            </header><!-- Header -->
            <div class="page-container menu-left">
                <aside class="sidebar">
                    <div class="profile-stats">
                        <div class="mini-profile">
                            <span><img src="{{ URL::asset('images/resource/me.jpg')}}" alt="" /></span>
                            <h3>{{Auth::User()->first_name}} {{Auth::User()->last_name}}</h3>
                            <h6 class="status online"><i></i> Online</h6>
                            <a href="/logout" title="Logout" class="logout red" data-toggle="tooltip" data-placement=
                               "right"><i class="fa fa-power-off"></i></a>
                        </div>
                        <div class="quick-stats">
                            <h5>Today Report</h5>
                            <ul>
                                <li><span>456<i>Sales</i></span></li>
                                <li><span>2,345<i>Order</i></span></li>
                                <li><span>$120<i>Revenue</i></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="menu-sec">
                        <div id="menu-toogle" class="menus">
                            <div class="single-menu">
                                <h2 class="<?php if (isset($home) && $home): ?> active <?php else: ?>  <?php endif ?>">
                                    <?php if(isset($site_id) && !empty($site_id)) $current_site = $site_id; elseif(!empty($user_sites)) $current_site = $user_sites[0]->idsite; else $current_site = 0; ?>
                                    <a href="<?php echo route('user_dashboard',['id' => $current_site]); ?>" title="">
                                        <i class="fa fa-home"></i>
                                        <span>Home</span>
                                    </a>
                                    <i class="blue">3</i>
                                </h2>
                                <div class="sub-menu">
                                    <ul>
                                        <li>{{HTML::link(URL::route('visitors',['id' => $current_site]), 'Visitor List') }}</li>
                                        <li> {{HTML::link(URL::route('visualization',['id' => $current_site]), 'Visualization') }}</li>
                                        <li>{{HTML::link(URL::route('history',['id' => $current_site]), 'History') }}</li>
                                        <!--<li><a title="">Landing Page</a><span class="badge red">Soon</span></li>-->
                                    </ul>
                                </div>
                            </div>
                            <div class="single-menu">
                                <h2 class="<?php if (isset($user_section) && $user_section): ?> active <?php else: ?> <?php endif ?>"><a title=""><i class="fa fa-desktop"></i><span>MANAGE</span></a></h2>
                                <div class="sub-menu">
                                    <ul>
                                        <li>{{HTML::link(URL::route('sitelist'), 'Site List') }}</li>
                                        <!--<li><a href="collapse-sidebar-right.html" title="">Collapse Sidebar Right</a></li>
                                        <li><a href="menu-horizontal.html" title="">Menu Horizontal</a></li>
                                        <li><a href="panel-left-menu-right.html" title="">Panel Left Menu Right</a></li>
                                        <li><a href="panel-right-menu-left.html" title="">Panel Right Menu Left</a></li>
                                        <li><a href="sidebar-left.html" title="">Sidebar left</a></li>
                                        <li><a href="sidebar-right.html" title="">Sidebar Right</a></li>-->

                                    </ul>
                                </div>
                            </div>
                            <?php if(!empty($user_sites)) { ?>
                            <div class="single-menu">
                                <h2 class="">
                                    <a title="">
                                        <i class="fa fa-desktop"></i>
                                        <span>
                                            <?php if(isset($site_name) && !empty($site_name)) echo $site_name; elseif(!empty($user_sites)) echo $user_sites[0]->name; ?>
                                        </span>
                                    </a>
                                    <i class="blue"><?php echo count($user_sites); ?></i>
                                </h2>
                                <div class="sub-menu">
                                    <ul>
                                        <?php foreach($user_sites as $user_site) { ?>
                                            <li>{{HTML::link(URL::route('user_dashboard',['id' => $user_site->idsite]), $user_site->name) }}</li>
                                        <?php ;} ?>
                                    </ul>
                                </div>
                            </div>
                            <?php ;} ?>

                        </div>
                        <p>2014 Copyright Azan by <a href="http://themeforest.net/user/themenum/portfolio?ref=themenum" title="">Themenum</a></p>
                    </div><!-- Menu Sec -->
                </aside><!-- Aside Sidebar -->
                @yield('content')
            </div><!-- Page Container -->
        </div><!-- main -->

        <!-- Script -->

        {{HTML::script('js/modernizr.js')}}
        {{HTML::script('js/jquery-1.11.1.js')}}
        {{HTML::script('js/script.js')}}
        {{HTML::script('js/bootstrap.js')}}
        {{HTML::script('js/enscroll.js')}}
        {{HTML::script('js/chart.js')}}
        {{HTML::script('js/daterangepicker.js')}}
        {{HTML::script('js/moment.js')}}
        {{HTML::script('js/jquery-jvectormap.js')}}
        {{HTML::script('js/jquery-jvectormap-world-en.js')}}
        {{HTML::script('js/gdp-data.js')}}
        {{HTML::script('js/raphael-min.js')}}
        {{HTML::script('js/d3.v3.min.js')}}
        {{HTML::script('js/rickshaw.min.js')}}
        {{HTML::script('js/html5lightbox.js')}}
        {{HTML::script('js/grid-filter.js')}}
        {{HTML::script('js/jquery.sparkline.min.js')}}

        @yield('scripts')
    </body>
</html>