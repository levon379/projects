<?php $this->beginPage() ?><!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?=Yii::$app->name?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <!-- Open Sans font from Google CDN -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">

    <!-- Pixel Admin's stylesheets -->
    <link href="<?php echo $this->theme->baseUrl; ?>/assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->theme->baseUrl; ?>/assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->theme->baseUrl; ?>/assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->theme->baseUrl; ?>/assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->theme->baseUrl; ?>/assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">
    <style>
        .has-success .help-block {
            display:none;
        }
    </style>
    <?php $this->head() ?>
    <!--[if lt IE 9]>
    <script src="assets/javascripts/ie.min.js"></script>
    <![endif]-->

</head>


<!-- 1. $BODY ======================================================================================

	Body

	Classes:
	* 'theme-{THEME NAME}'
	* 'right-to-left'     - Sets text direction to right-to-left
-->
<body class="theme-default page-signin-alt"><?php $this->beginBody() ?>



<!-- 2. $MAIN_NAVIGATION ===========================================================================

	Main navigation
-->
<div class="signin-header">
    <a href="index.html" class="logo">
        Postradamus
    </a> <!-- / .logo -->
    <a href="http://1s0s.com/postradamus/" class="btn btn-primary">Sign Up</a>
</div> <!-- / .header -->

<h1 class="form-header">Sign in to your Account</h1>

<?php
foreach(Yii::$app->session->getAllFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '"><a class="close" data-dismiss="alert" href="#">x</a>' . $message . "</div>\n";
}
?>
<?php echo $content; ?>


<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js">'+"<"+"/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->


<!-- Pixel Admin's javascripts -->
<script src="<?php echo $this->theme->baseUrl; ?>/assets/javascripts/bootstrap.min.js"></script>
<script src="<?php echo $this->theme->baseUrl; ?>/assets/javascripts/pixel-admin.min.js"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>