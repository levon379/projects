<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	
	@if (isset($metaData["description"]))
		<meta name="description" content="{{ $metaData["description"] }}"> 
	@elseif( isset($product->languageDetail->meta_description) )
		<meta name="description" content="{{ $product->languageDetail->meta_description }}">
	@endif

	@if (isset($metaData["keywords"]))
		<meta name="keywords" content="{{ $metaData["keywords"] }}"> 
	@elseif( isset($product->languageDetail->meta_tags) )
		<meta name="keywords" content="{{ $product->languageDetail->meta_tags }}">
	@endif


	@if (isset($metaData["title"]))
		<meta name="title" content="{{ $metaData["title"] }}"> 
	@elseif( isset($product->languageDetail->meta_title) )
		<meta name="title" content="{{ $product->languageDetail->meta_title }}">
	@endif


	<meta name="viewport" content="width=device-width, initial-scale=1">
	@if (isset($metaData["title"]))
		<title>{{ $metaData["title"] }} | EcoArt Travel</title> 
	@else
		<title>{{ isset($product->languageDetail->meta_title) ? $product->languageDetail->meta_title : 'Eco art travel' }}</title>
	@endif

	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet'>
	<link rel="stylesheet" href="/assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="/assets/css/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css">
	<link rel="stylesheet" href="/assets/css/app/all.css?v=2.60">
	<link rel="stylesheet" href="/assets/css/fontawesome/font-awesome.min.css?v=2.60">
	
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="/assets/css/plugins/sweet-alert/sweetalert2.css" />
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-51590181-1', 'auto');
        ga('send', 'pageview');

        var _iub = _iub || [];
        _iub.csConfiguration = {
            cookiePolicyId: 540382,
            siteId: 268120,
            lang: "en"
        };
        (function (w, d) {
            var loader = function () { var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src = "//cdn.iubenda.com/cookie_solution/iubenda_cs.js"; tag.parentNode.insertBefore(s, tag); };
            if (w.addEventListener) { w.addEventListener("load", loader, false); } else if (w.attachEvent) { w.attachEvent("onload", loader); } else { w.onload = loader; }
        })(window, document);
    </script>
</head>
<body>
<div id="wrapper">
	<header id="header">
		<div class="container">
			<div class="header-top row">
				<div class="col-sm-6 hidden-xs">
					<div class="logo">
						<a href="{{ url("/") }}"><img src="/assets/images/app/logo.png" alt="Eco art travel" width="139" height="75"></a>
					</div>
					<span class="slogan">Extraordinary ways to explore Italy.</span>
				</div>
				<div class="col-sm-6">
					<a href="#" class="link">EcoArtTravel.com</a>
				</div>
			</div>
		</div>
		<div class="header-bottom">
			<div class="container">
				<nav id="nav" class="navbar navbar-default">
					<div class="container-fluid"> 
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="row">
							<div class="collapse navbar-collapse" id="navbar-collapse-1">
								<div class="menu-logo hidden-sm hidden-md hidden-lg">
									<a href="#" class="logo-m"><img src="/assets/images/app/logo.png" alt="Eco art travel" width="139" height="75"></a>
									<span class="text">Extraordinary ways to explore Italy.</span>
								</div>
								<ul class="nav navbar-nav">
									<li><a href="#">EcoArtTravel.com</a></li>
									<li><a href="/en/rome-tours" class="{{ Request::is('en/rome-tours*') || Request::is('en/rome-tours/*/*')? 'active' : '' }}">Rome Tours</a></li>
									<li><a href="/en/rome-segway-tours" class="{{ Request::is('en/rome-segway-tours*') || Request::is('en/rome-segway-tours/*/*')? 'active' : '' }}">Segway Tours</a></li>
									<li><a href="/en/day-trips-from-rome" class="{{ Request::is('en/day-trips-from-rome*') || Request::is('en/day-trips-from-rome/*/*')? 'active' : '' }}">Day Trips</a></li>
									<li><a href="/en/rome-tickets" class="{{ Request::is('en/rome-tickets*') || Request::is('en/rome-tickets/*/*')? 'active' : '' }}">Tickets</a></li>
									<li><a href="/en/rome-transfers" class="{{ Request::is('en/rome-transfers*') || Request::is('en/rome-transfers/*/*')? 'active' : '' }}">Transfers</a></li>
									<li><a href='{{ url("/en/about-ecoart-travel") }}' class="{{ Request::is('en/about-ecoart-travel*') || Request::is('en/about-ecoart-travel/*/*')? 'active' : '' }}">Why Us?</a></li>
								</ul>
								<a href="/shopping-cart" class="btn btn-info navbar-right"><span class="icon-cart"></span> {{number_format(\Session::get('cart.totalCartValue'), 2)}}</a>
							</div>
						</div>
						<!-- /.navbar-collapse --> 
					</div>
					<!-- /.container-fluid --> 
				</nav>
				<a href="/shopping-cart" class="cart-btn hidden-lg hidden-md hidden-sm"><span class="icon-cart"></span></a>
			</div>
		</div>
	</header>
	<div class="side-push">
		<div class="side-push-hold">
			<main id="main" role="main">
			@yield('content')
			</main>
            @include('partials.footer')
			<div class="fixed-block">

				<div class="open-close">
					<span class="share opener"><a href="#">share</a></span>
					<div class="slide">
						<ul class="social-networks list-unstyled">
							<li class="facebook"><a target="_blank" href="http://www.facebook.com/EcoArtTravel">facebook</a></li>
							<li class="twitter"><a target="_blank" href="http://twitter.com/EcoArtTravel">twitter</a></li>
							<li class="google"><a target="_blank" href="http://plus.google.com/106492955635093825444/posts">google</a></li>
							<li class="youtube"><a target="_blank" href="https://www.youtube.com/channel/UCRP1EG2s_YlSGM7r4em2kCA">youtube</a></li>
						</ul>
					</div>
				</div>

				<div class="btn-contact">
					<a href="#" id="contact-slide" class="toogle">contact</a>
				</div>
			</div>
			<div class="contact-push">
				<section class="address-box">
					<h2 class="line-bar">Contact us</h2>
					<ul class="address-details list-unstyled">
						<li class="phone">
							Give us a ring! <br> 
							<span class="number">+39 06 775 918 22</span> 
							<span class="number">Toll Free (Italy) 800 25 00 77</span>
						</li>
						<li class="address">
							<address>Via Celimontana 32 <br> Rome (RM) 00184 - ITALY</address>
						</li>
                                                <li>
                                <a href="https://www.iubenda.com/privacy-policy/540382" target="_blank">Privacy Policy</a>                     
                            </li>
					</ul>
					<div class="map">
						<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1485.1447539279593!2d12.499276785710316!3d41.88663051786684!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132f61b78c0d5c0f%3A0x7bbfa4a6734b1e26!2sEcoArt+Travel!5e0!3m2!1sit!2sit!4v1432289832652" width="281" height="200" frameborder="0" style="border:0"></iframe>
					</div>
				</section>
				<section class="write-box">
					<h2 class="line-bar">Write to us</h2>
					<form action="#" id="contactUsForm">
						<div class="form-group">
							<div class="input-wrap name">
								<input type="text" class="form-control" name="name" placeholder="Your Name...">
							</div>
						</div>
						<div class="form-group">
							<div class="input-wrap email">
								<input type="email" class="form-control" name="email" placeholder="Mail...">
							</div>
						</div>
						<div class="form-group">
							<div class="input-wrap message">
								<textarea cols="5" rows="5" name="message" class="form-control" placeholder="Your Message..."></textarea>
							</div>
						</div>
						<div class="btn-submit">
							<button type="submit" class="btn btn-success" data-loading-text="Sending...">Send</button>
						</div>
					</form>
				</section>
			</div>
		</div>
	</div>
	<!-- Preloader Section -->
	<!-- <div class="preload-block">
		<div class="loader">
			<h4>Loading...</h4>
			<div id="squaresWaveG">
				<div id="squaresWaveG_1" class="squaresWaveG"></div>
				<div id="squaresWaveG_2" class="squaresWaveG"></div>
				<div id="squaresWaveG_3" class="squaresWaveG"></div>
				<div id="squaresWaveG_4" class="squaresWaveG"></div>
				<div id="squaresWaveG_5" class="squaresWaveG"></div>
				<div id="squaresWaveG_6" class="squaresWaveG"></div>
				<div id="squaresWaveG_7" class="squaresWaveG"></div>
				<div id="squaresWaveG_8" class="squaresWaveG"></div> 
			</div>
		</div>
	</div> -->
</div>
<script src="/assets/js/jquery/jquery-1.11.2.min.js"></script>
<script src="/assets/js/app/plugins.js"></script>
<script src="/assets/js/plugins/bootstrap-tabcollapse/bootstrap-tabcollapse.js"></script>
<!-- moment.js and datepicker.js is for datepicker -->
<script src="/assets/js/moment/moment.js"></script>
<script src="/assets/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="/assets/js/jquery/jquery.main.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="/assets/js/app/custom.js"></script>
<script src="/assets/js/plugins/inputmask/jquery.inputmask.bundle.js"></script>

<!-- HandleBarsJs -->
<script src="/assets/js/plugins/handlebars/handlebars-v3.0.0.js"></script>

<!-- Sweet Alert -->
<script src="/assets/js/plugins/sweet-alert/sweetalert2.min.js"></script>
<script>
	if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
		var msViewportStyle = document.createElement('style')
		msViewportStyle.appendChild(
			document.createTextNode(
				'@-ms-viewport{width:auto!important}'
			)
		)
		document.querySelector('head').appendChild(msViewportStyle)
	}
</script>
<script>
	$(document).ready(function () {
                $('#contact-slide-footer').click(function(e) {
                    e.preventDefault();
                    $('#contact-slide').click();
                });
	   $(window).scroll(function() {
			if ($(".contact-push").offset().top > 250) {
			    $(".contact-push").addClass("fixed-top");
			} else {
			    $(".contact-push").removeClass("fixed-top");
			}
		});
		/* Contact Us Form */
		$("#contactUsForm").on({
		   	submit: function(e){
		   		var self = this;
		   		var name = $(this).find("input[name='name']").val();
		   		var email = $(this).find("input[name='email']").val();
		   		var message = $(this).find("textarea[name='message']").val();
		   		if(name && email && message){
		   			// now send message
		   			var btn = $(this).find(".btn-submit > button").button('loading');
		   			$.get("{{ url('contact/sendemail') }}", {
		   				name: name,
		   				email: email,
		   				message: message
		   			}, function(response){
		   				if(response.success === true){
		   					btn.button('reset');
		   					var responseDiv = document.createElement("div");
		   					responseDiv.className = "response-box alert alert-success";
		   					responseDiv.innerHTML = response.message;
		   					var againButton = document.createElement("a");
		   					$(againButton).attr("href", "#");
		   					againButton.className = "send-again show";
		   					againButton.innerHTML = "Show Contact Form";
		   					$(againButton).click(function(e){
		   						e.preventDefault();
		   						$(this).parents(".contact-push").find(".write-box").removeClass('sr-only');
		   						$(this).parents(".response-box").remove();
		   					});
		   					responseDiv.appendChild(againButton);
		   					$(self).parents("section.write-box").addClass("sr-only").parents(".contact-push").append(responseDiv);
		   				}else{
		   					btn.button('reset');
		   					var responseDiv = document.createElement("div");
		   					responseDiv.className = "response-box alert alert-danger";
		   					responseDiv.innerHTML = response.message;
		   					var againButton = document.createElement("a");
		   					$(againButton).attr("href", "#");
		   					againButton.className = "send-again show";
		   					againButton.innerHTML = "Show Contact Form";
		   					$(againButton).click(function(e){
		   						e.preventDefault();
		   						$(this).parents(".contact-push").find(".write-box").removeClass('sr-only');
		   						$(this).parents(".response-box").remove();
		   					});
		   					responseDiv.appendChild(againButton);
		   					$(self).parents("section.write-box").addClass("sr-only").parents(".contact-push").append(responseDiv);
		   				}
		   			});
		   		}
		   		return false;
		   	}
		});
	});
</script>
<script>
	$(window).load(function(){
		$('.preload-block').fadeOut(1000);
	});
	$('#myTab').tabCollapse();
    
</script>
@yield('script','')
<script src="http://code.tidio.co/g8rbvsdsjargbb8wlbrxccblmu0xs0dy.js"></script>
</body>
</html>