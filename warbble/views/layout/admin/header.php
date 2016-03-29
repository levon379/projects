<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Dashboard</title>
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo $base_url; ?>assets/admin-new/css/bootstrap.min.css" rel="stylesheet">
        <!--Stylesheets -->
        <link href="<?php echo $base_url; ?>assets/admin-new/css/sb-admin.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>assets/admin-new/css/fonts.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>assets/admin-new/css/font-awesome.min.css">
        <link rel="icon" href="<?php echo $base_url; ?>assets/admin-new/img/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>assets/admin-new/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>assets/admin-new/css/responsive.css">
        <link href="<?php echo $base_url; ?>assets/admin/css/notification.css" rel="stylesheet">

        <?php foreach ($csses as $css): ?>
            <link href="<?php echo $base_url; ?>assets/<?php echo $css['type'] . '/css/' . $css['file'] ?>" rel="stylesheet">
        <?php endforeach; ?>

        <!-- Custom Fonts -->
        <script src="<?php echo $base_url; ?>assets/admin-new/js/jquery-1.11.2.min.js"></script>
        <?php if (!empty($js_variables)): ?>
            <script type="text/javascript">
    <?php foreach ($js_variables as $var_key => $var_value): ?>
        <?php if ($var_value == '{}' || $var_value == '[]'): ?>
                        window.<?= $var_key ?> = <?= $var_value ?>;
        <?php elseif (is_numeric($var_value)): ?>
                        window.<?= $var_key ?> = <?= $var_value ?>;
        <?php elseif (is_string($var_value)): ?>
                        window.<?= $var_key ?> = '<?= $var_value ?>';
        <?php elseif (is_array($var_value) || is_object($var_value)): ?>
                        window.<?= $var_key ?> = JSON.parse('<?= json_encode($var_value) ?>');
        <?php endif; ?>
    <?php endforeach; ?>
            </script>
        <?php endif; ?>
        <?php foreach ($js_scripts as $script): ?>
            <?php if ($script['location'] == 'outside'): ?>
                <script src="<?php echo $script['url'] ?>" ></script>
            <?php endif; ?>
            <?php if ($script['location'] == 'header'): ?>
                <script src="<?php echo $base_url; ?>assets/<?php echo $script['type'] . '/js/' . $script['file'] ?>"></script>
            <?php endif; ?>
        <?php endforeach; ?>
        <script src="<?php echo $base_url; ?>assets/admin/js/notification.js"></script>
        <script src="<?php echo $base_url; ?>assets/admin/js/moment.min.js"></script>
    </head>
    <body <?php if (isset($post) && $post): ?> class="bg_gray"  <?php endif; ?> >
        <div id="wrapper" class="wrapper_">
            <nav class="navbar navbar-inverse navbar-fixed-top accound_section">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand nav_logo logo" href="<?php echo $base_url; ?>Dashboard"><img src="<?php echo $base_url; ?>assets/admin/img/logo.png" alt="logo"></a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav nav_admin">
                    <li>
                        <a href="#" >Help</a>
                    </li>
                    <li data-toggle="popover" tabindex="0" data-content="">
                        <a href="javascript:;" class="modal-link">
                            <div class="notif_">
                                <i class="fa fa-bell"></i>
                                <?php if ($count_notification): ?>
                                    <span class="badge badge_">5<?= $count_notification; ?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php if (!empty($userlogin->avatar)) { ?>
                                <img class="avatar" src="<?PHP echo $base_url . $userlogin->avatar ?>" alt="">
                            <?PHP } ?>
                            <?= $userlogin->first_name ?>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo $base_url; ?>Users/myaccount">
                                    <i class="fa fa-fw fa-user"></i>Profile
                                </a>
                            </li>
                            <li>
                                <a href="#" class="">
                                    <i class="fa fa-fw fa-envelope"></i>Messages
                                </a>
                            </li>
                            <li>
                                <a href="#" class="">
                                    <i class="fa fa-picture-o"></i>
                                    <span>Albums</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url; ?>Users/upgrade">
                                    <i class="fa fa-fw fa-gear"></i>Upgrade
                                </a>
                            </li>
                            <li>
                                <a href="<?= $base_url . "Users/logout" ?>">
                                    <i class="fa fa-fw fa-power-off"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                    </ul>
                    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                        <?php $main_menu->render() ?>
                    </div>
            </nav>
            <div id="page-wrapper" class="page_wrp <?php if (isset($post) && $post): ?>bg_grey<?php endif; ?>">
                <?php if (isset($post) && $post): ?> 
                    <div class="admin_tab"> 
                    <?php endif; ?>

