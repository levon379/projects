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
                <link rel="stylesheet" type="text/css" href="http://cloud.github.com/downloads/lafeber/world-flags-sprite/flags32.css" />
		{{HTML::style('font-awesome-4.2.0/css/font-awesome.css')}}
		{{HTML::style('css/daterangepicker-bs3.css')}}
		{{HTML::style('css/bootstrap.css')}}
		{{HTML::style('css/rickshaw.css')}}
		{{HTML::style('css/style.css')}}
		{{HTML::style('css/responsive.css')}}
		@yield('styles')
	</head>
<body>

<div class="main">
	<div id="live-chat">
		<div class="clearfix gray chat-header">
			<a href="#" class="chat-close">-</a>
			<h4>Labrina Scholar</h4>
			<span class="chat-message-counter">3</span>
		</div>
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
			<p class="chat-feedback">Your partner is typing… <img src="{{ URL::asset('images/typing-loading.gif')}}" alt="" /></p>
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
			<a href="dashboard.html" title=""><img src="{{ URL::asset('images/logo2.png')}}" alt="" /></a>
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
							<a title=""><span><img src="{{ URL::asset('images/resource/sender1.jpg')}}" alt="" /></span><i>Labrina Scholer</i>Hi! How are you?...<h6>2 min ago..</h6><p class="status blue">New</p></a>
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
			  <img src="{{ URL::asset('images/resource/me.jpg')}}" alt="" />Labrina Scholer<i class="caret"></i>
			</a>
			<div class="profile drop-list">
				<ul>
					<li><a href="#" title=""><i class="fa fa-edit"></i> New post</a></li>
					<li><a href="#" title=""><i class="fa fa-wrench"></i> Setting</a></li>
					<li><a href="profile.html" title=""><i class="fa fa-user"></i> Profile</a></li>
					<li><a href="faq.html" title=""><i class="fa fa-info"></i> Help</a></li>
				</ul>
			</div><!-- Profile DropDown -->

		</div>
	</header><!-- Header -->
	<div class="page-container menu-left">
		<aside class="sidebar">
			<div class="profile-stats">
				<div class="mini-profile">
					<span><img src="{{ URL::asset('images/resource/me.jpg')}}" alt="" /></span>
					<h3>Labrina Scholer</h3>
					<h6 class="status online"><i></i> Online</h6>
					<a href="index.html" title="Logout" class="logout red" data-toggle="tooltip" data-placement=
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
						<h2><a title=""><i class="fa fa-home"></i><span>Dashboards</span></a><i class="blue">3</i></h2>
						<div class="sub-menu">
							<ul>
								<li><a href="dashboard.html" title="">Dashboard 1</a></li>
								<li><a href="dashboard2.html" title="">Dashboard 2</a></li>
								<li><a href="dashboard3.html" title="">Dashboard 3</a></li>
								<li><a title="">Landing Page</a><span class="badge red">Soon</span></li>
							</ul>
						</div>
					</div>
					<div class="single-menu">
						<h2><a title=""><i class="fa fa-desktop"></i><span>Layouts</span></a></h2>
						<div class="sub-menu">
							<ul>
								<li><a href="blank.html" title="">Blank</a></li>
								<li><a href="collapse-sidebar-left.html" title="">Collapse Sidebar Left</a></li>
								<li><a href="collapse-sidebar-right.html" title="">Collapse Sidebar Right</a></li>
								<li><a href="menu-horizontal.html" title="">Menu Horizontal</a></li>
								<li><a href="panel-left-menu-right.html" title="">Panel Left Menu Right</a></li>
								<li><a href="panel-right-menu-left.html" title="">Panel Right Menu Left</a></li>
								<li><a href="sidebar-left.html" title="">Sidebar left</a></li>
								<li><a href="sidebar-right.html" title="">Sidebar Right</a></li>

							</ul>
						</div>
					</div>
					<div class="single-menu">
						<h2><a href="widgets.html" title=""><i class="fa fa-flask"></i><span>Widgets</span></a></h2>
					</div>
					<div class="single-menu">
						<h2><a title=""><i class="fa fa-heart-o"></i><span>UI Elements</span></a></h2>
						<div class="sub-menu">
							<ul>
								<li><a href="inbox.html" title="">Mail Box</a></li>
								<li><a href="profile.html" title="">Profile</a></li>
								<li><a href="buttons.html" title="">Buttons</a></li>
								<li><a href="timeline.html" title="">Timeline</a></li>
								<li><a href="typography.html" title="">Typography</a></li>
								<li><a href="calendars.html" title="">Calendars</a></li>
								<li><a href="upload-crop.html" title="">Upload Crop</a></li>
								<li><a href="tour.html" title="">Page Tour</a></li>
								<li><a href="tree-list.html" title="">Tree List</a></li>
								<li><a href="collapse.html" title="">Collapse</a></li>
								<li><a href="editor.html" title="">Editor</a></li>
								<li><a href="form.html" title="">Forms</a></li>
								<li><a href="gallery-dynamic.html" title="">Gallery Dynamic</a></li>
								<li><a href="gallery-static.html" title="">Gallery Static</a></li>
								<li><a href="grids.html" title="">Grids</a></li>
								<li><a href="icons.html" title="">Icons</a></li>
								<li><a href="notifications.html" title="">Notification</a></li>
								<li><a href="price-table.html" title="">Price Tables</a></li>
								<li><a href="range-slider.html" title="">Range Slider</a></li>
								<li><a href="slider.html" title="">Slider</a></li>
								<li><a href="sortable.html" title="">Sortable</a></li>
								<li><a href="tables.html" title="">Tables</a></li>
								<li><a href="tasks.html" title="">Tasks</a></li>
								<li><a href="tasks-widget.html" title="">Task Widgets</a></li>
							</ul>
						</div>
					</div>
					<div class="single-menu">
						<h2><a href="form.html" title=""><i class="fa fa-paperclip"></i><span>Form Stuffs</span></a></h2>
					</div>
					<div class="single-menu">
						<h2><a href="charts.html" title=""><i class="fa fa-bar-chart"></i><span>Charts</span></a></h2>
					</div>
					<div class="single-menu">
						<h2><a title=""><i class="fa fa-paper-plane-o"></i><span>Pages</span></a></h2>
						<div class="sub-menu">
							<ul>
								<li><a href="404.html" title="">404 Error</a></li>
								<li><a href="blank.html" title="">Blank</a></li>
								<li><a href="contact.html" title="">Contact</a></li>
								<li><a href="google-map.html" title="">Google Map</a></li>
								<li><a href="vector-map.html" title="">Vector Map</a></li>
								<li><a href="invoice.html" title="">Invoice</a></li>
								<li><a href="pattern-login.html" title="">Pattern Login</a></li>
								<li><a href="index.html" title="">Simple Login</a></li>
							</ul>
						</div>
					</div>
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
{{HTML::script('js/d3.v2.js')}}
{{HTML::script('js/rickshaw.min.js')}}
{{HTML::script('js/html5lightbox.js')}}
{{HTML::script('js/grid-filter.js')}}
{{HTML::script('js/jquery.sparkline.min.js')}}

@yield('scripts')
</body>
</html>