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
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/front/css/style.css"> <!-- Gem style -->
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/front/css/responsive.css"> 
        <!-- Optional theme 
        <link rel="stylesheet" href="<?php //echo BASE_URL;   ?>assets/front/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php //echo BASE_URL;   ?>assets/front/css/bootstrap-social.css">-->
        <!--<link rel="stylesheet" href="<?php //echo BASE_URL;   ?>assets/front/style.css">-->



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
        <script src="<?php echo BASE_URL; ?>assets/front/js/main-old.js"></script> <!-- Gem jQuery -->
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
        <script src="https://www.google.com/recaptcha/api.js"></script>

    </head>
    <body>
        <?php if ($login): ?>
            <div class="pass_bg">
            <?php elseif ($privacy_policy): ?>
                <section class="section_privacy">
                <?php elseif ($signup): ?>
                    <div class="signup_bg">
                    <?php elseif ($help): ?>
                        <div class="help_bg">
                        <?php else: ?>
                            <div class="section_hero">
                            <?php endif; ?>
                            <?php $this->view('front/init/header_menu', array('userlogin' => $userlogin)) ?>
