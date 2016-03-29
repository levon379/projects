<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Warbble Portal</title>

        <link href="<?php echo BASE_URL; ?>assets/front/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/front/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/front/css/fonts.css">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/front/css/bootstrap.vertical-tabs.css">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/front/css/responsive.css"> 
        <!-- Optional theme 
        <link rel="stylesheet" href="<?php //echo BASE_URL;  ?>assets/front/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php //echo BASE_URL;  ?>assets/front/css/bootstrap-social.css">-->
        <!--<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/front/style.css">-->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/front/css/style.css"> <!-- Gem style -->


        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo BASE_URL; ?>assets/front/js/jquery-1.11.2.min.js"></script>

        <script src="<?php echo BASE_URL; ?>assets/front/js/bootstrap.min.js"></script>

    <!-- <script src="<?php echo BASE_URL; ?>assets/front/js/main-script.js"></script>-->
        <script src="<?php echo BASE_URL; ?>assets/front/js/modernizr.js"></script><!--  Modernizr -->
        <script src="<?php echo BASE_URL; ?>assets/front/js/jquery.validate.js"></script>

        <script src="<?php echo BASE_URL; ?>assets/front/js/main.js"></script>
        <?php if (!isset($userlogin) or sizeof($userlogin) <= 0) : ?>
        <script type="text/javascript" id="cookiebanner"
                src="<?php echo BASE_URL; ?>assets/front/js/cookiebanner.js"
                data-height="20px"
                data-fg="#fff"
                data-bg="#263a4d"
                data-close-text="Got It."
                data-linkmsg='OKAY'
                data-moreinfo='<?php echo BASE_URL; ?>home/cookies'
                data-message="We use cookies to ensure that we give you the best experience. We’ll assume you’re ok with this, but you can read more here.">
        </script>
        <style>
            div.cookiebanner-close{

            }
            div.cookiebanner>span>a{
                color: #f6497a !important;
            }
        </style>
        <?php endif; ?>
        <script src="https://www.google.com/recaptcha/api.js"></script>
        
    </head>
    <body>
        <?php if ($login): ?>
            <div class="signup_bg">
            <?php elseif ($privacy_policy): ?>
                <section class="section_privacy">
                <?php elseif ($our_blog): ?>
                    <section class="section_ourblog">
                <?php elseif ($help): ?>
                    <div class="help_bg">
                <?php elseif ($aboutus): ?>
                    <div class="about_section">
                        <?php elseif ($careers): ?>
                    <div class="section_carrer">
                    <?php elseif ($termsofservice): ?>
                        <section class="section_terms">
                        <?php else: ?>
                            <section class="section_hero">
                            <?php endif; ?>
                            <div class="container-fluid">
                                <div class="col-sm-12">
                                    <header class="nav_header">
                                        <div class="navbar-header">
                                            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar">
                                                <span class="sr-only">Toggle navigation</span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </button>
                                            <a class="navbar-brand logo" href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>assets/front/img/logo.png" alt="logo"></a>
                                        </div>
                                        <nav id="bs-navbar" class="collapse navbar-collapse">
                                            <ul class="nav navbar-nav navbar-right navbar_nav">
                                                <li class="active">
                                                    <?php if ($home): ?>
                                                        <a href="javascript:void(0)" id="features">Features</a>
                                                    <?php else: ?>
                                                        <a href="<?php echo BASE_URL; ?>?content=features">Features</a>
                                                    <?php endif; ?>
                                                </li>
                                                <li>
                                                    <a href="<?php echo BASE_URL; ?>?content=pricing">Pricing</a>
                                                </li>
                                                <li>
                                                    <a href="#">Partners</a>
                                                </li>
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle dropdown_more" data-toggle="dropdown" role="button" aria-haspopup="true">More <i class="fa fa-angle-down"></i></a>
                                                    <ul class="dropdown-menu">
                                                        <li class="dropdown_more_arrow"><img src="<?php echo BASE_URL; ?>assets/front/img/dropdown_arrow.png"></li>
                                                        <li role="presentation">
                                                            <a class="letter_spacing_2" role="menuitem" tabindex="-1" href="<?php echo BASE_URL; ?>home/aboutus">About Us</a>
                                                        </li>
                                                        <li role="presentation">
                                                            <a class="letter_spacing_2" role="menuitem" tabindex="-1" href="<?php echo BASE_URL; ?>home/blog">Blog</a>
                                                        </li>
                                                        <li class="dropdown_more_active" role="presentation">
                                                            <a class="letter_spacing_2" role="menuitem" tabindex="-1" href="<?php echo BASE_URL; ?>home/careers">Careers</a>
                                                        </li>
                                                        <li role="presentation">
                                                            <a class="letter_spacing_2" role="menuitem" tabindex="-1" href="<?php echo BASE_URL; ?>home/help">Help</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <?php if (!isset($userlogin) or sizeof($userlogin) <= 0) : ?>
                                                    <li class="header_login" >
                                                        <a class="style_clr" href="<?php echo BASE_URL; ?>login">Log in</a>								
                                                    </li>
                                                    <?php if(!$signup):?>
                                                    <li class="header_signup">
                                                        <a class="btn btn-lg btn-primary get_started btn_" href="<?php echo BASE_URL; ?>singup">Let’s Get Started</a>
                                                    </li>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <li class="header_login">
                                                        <a href="<?php echo BASE_URL; ?>Dashboard">Hi, <strong><?= @$userlogin->first_name ?></strong></a>
                                                    </li>
                                                    <li><a href="<?php echo BASE_URL; ?>logout">Logout</a></li>

                                                <?php endif; ?>
                                            </ul>
                                        </nav>
                                    </header>    
                                </div>
                            </div><!--/.nav-collapse -->