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
                        <a href="javascript:void(0)" id="pricing">Pricing</a>
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
                       
                        <?php if (!$signup): ?>
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