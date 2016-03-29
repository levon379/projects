<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta name="description" content="description">
    <meta name="author" content="Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo $base_url; ?>assets/admin/plugins/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" >
    <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css' >
    <?php foreach($csses as $css): ?>
        <link href="<?php echo $base_url; ?>assets/<?php echo $css['type'] . '/css/' . $css['file'] ?>" rel="stylesheet">
    <?php endforeach; ?>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css' >
    <link href="/assets/admin/css/bootstrap-chosen.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>assets/admin/css/style.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>assets/admin/css/responsive.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" ></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="<?php echo $base_url; ?>assets/admin/plugins/bootstrap/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
    <script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
    <![endif]-->
    <?php if(!empty($js_variables)): ?>
        <script type="text/javascript">
            <?php foreach($js_variables as $var_key => $var_value): ?>
                <?php if($var_value == '{}' || $var_value == '[]'): ?>
                    window.<?= $var_key ?> = <?= $var_value ?>;
                <?php elseif(is_numeric($var_value)): ?>
                    window.<?= $var_key ?> = <?= $var_value ?>;
                <?php elseif(is_string($var_value)): ?>
                    window.<?= $var_key ?> = '<?= $var_value ?>';
                <?php elseif(is_array($var_value) || is_object($var_value)): ?>
                    window.<?= $var_key ?> = JSON.parse('<?= json_encode($var_value) ?>');
                <?php endif; ?>
            <?php endforeach; ?>
        </script>
    <?php endif; ?>
    <?php foreach($js_scripts as $script): ?>
        <?php if($script['location'] == 'outside'): ?>
            <script src="<?php echo $script['url'] ?>" ></script>
        <?php endif; ?>
        <?php if($script['location'] == 'header'): ?>
            <script src="<?php echo $base_url; ?>assets/<?php echo $script['type'] . '/js/' . $script['file'] ?>"></script>
        <?php endif; ?>
    <?php endforeach; ?>
</head>
<body>
<!--Start Header-->
<div id="screensaver">
    <canvas id="canvas"></canvas>
    <i class="fa fa-lock" id="screen_unlock"></i>
</div>
<div id="modalbox">
    <div class="devoops-modal">
        <div class="devoops-modal-header">
            <div class="modal-header-name">
                <span>Basic table</span>
            </div>
            <div class="box-icons">
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="devoops-modal-inner">
        </div>
        <div class="devoops-modal-bottom">
        </div>
    </div>
</div>
<header class="navbar">
    <div class="container-fluid expanded-panel">
        <div class="row">
            <div class="hidden-lg hidden-md hidden-sm">
                <div class="mobile-menu col-xs-2">
                    <div class="navbar-header">
                        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div id="logo" class="col-sm-2 col-xs-10">
                <a href="#" class="text-center text-uppercase main-logo"></a>
            </div>
            <div class="mobile-menu-collapse hidden-lg hidden-md hidden-sm">
                <?php $main_menu->render_mobile() ?>
            </div>
            <div id="top-panel" class="col-xs-12 col-sm-10">
                <div class="row">
                    <div class="col-xs-6 col-sm-4">
                        <div id="search">
                            <i class="fa fa-search"></i>
                            <input type="text" placeholder="Search"/>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-8 top-panel-right">
                        <ul class="nav navbar-nav pull-right panel-menu usr-menu">
                            <li class="bell-notify">
                                <a href="<?= $base_url; ?>Notification/index" class="modal-link">
                                    <img src="<?php echo $base_url; ?>assets/admin/images/bell.png" alt=""/>
                                    <?php if($count_notification): ?>
                                        <span class="badge"><?= $count_notification; ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle account" data-toggle="dropdown">
                                    <i class="fa fa-angle-down"></i>
                                    <?php if( !empty( $userlogin->avatar ) ){ ?>
                                        <div class="hh-avatar avatar">
                                            <span><img src="<?PHP echo $base_url.$userlogin->avatar ?>" width="40" height="40" alt="Avatar" /></span>
                                        </div>
                                    <?PHP } else { ?>
                                        <div class="hh-avatar avatar color-<?PHP echo $userlogin->user_id%10 ?>">
                                            <span class="first_name_letter"><?PHP echo $userlogin->first_name[0] ?></span>
                                        </div>
                                    <?PHP } ?>
                                    <div class="user-mini pull-left">
                                        <span><?=$userlogin->first_name?></span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo $base_url; ?>Users/myaccount">
                                            <i class="fa fa-user"></i>
                                            <span>Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="">
                                            <i class="fa fa-envelope"></i>
                                            <span>Messages</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="">
                                            <i class="fa fa-picture-o"></i>
                                            <span>Albums</span>
                                        </a>
                                    </li>
                                    <li style="display: none;">
                                        <a href="#" class="">
                                            <i class="fa fa-tasks"></i>
                                            <span>Tasks</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $base_url; ?>Users/upgrade">
                                            <i class="fa fa-cog"></i>
                                            <span>Upgrade</span>
                                        </a>
                                    </li>
                                    <?php /*if (isset($_SESSION['login']['parent_id'])): ?>
                                    <li>

                                        <a href="<?php echo base_url('Users/loginAs/' . $_SESSION['login']['parent_id']) ?>">

                                            <i class="fa fa-power-off"></i>

                                            <span>Login back</span>

                                        </a>

                                    </li>
                                    <?php endif;*/ ?>
                                    <li>
                                        <a href="<?=$base_url."Users/logout"?>">
                                            <i class="fa fa-power-off"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--End Header-->
<div id="main" class="container-fluid"><!--MAIN-->
    <div class="row"><!--ROW-->
        <div id="sidebar-left" class="col-xs-2 col-sm-2"><!--SIDEBAR-->
            <?php $main_menu->render() ?>
        </div><!--#SIDEBAR-->
        <div id="content" class="col-xs-12 col-sm-10"><!--CONTENT-->