<?php
use backend\assets\AppAsset;
// You can use the registerAssetBundle function if you'd like
//$this->registerAssetBundle('yii\web\YiiAsset');
//$this->registerAssetBundle('yii\bootstrap\BootstrapAsset');
//$this->registerCssFile();

AppAsset::register($this);

?><?php $this->beginPage() ?><!DOCTYPE html>
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
    <link href='http://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Creepster' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
    <script src="<?php echo $this->theme->baseUrl; ?>/assets/javascripts/ie.min.js"></script>
    <![endif]-->
    <?php $this->head() ?>

    <!-- Pixel Admin's stylesheets -->
    <link href="<?php echo $this->theme->baseUrl; ?>/assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->theme->baseUrl; ?>/assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->theme->baseUrl; ?>/assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->theme->baseUrl; ?>/assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">
    <style>
        .button-column { white-space: nowrap; font-size:120% }
        .lower-canvas, .fpd-content { background-color: white; }
        .has-success .help-block {
            display:none;
        }

        .panel-group {
            margin-bottom:0;
        }

        .tour-tour > .popover-title {
            background-color: rgba(255, 245, 13, 1);
            border-bottom-color: #ddd;
            border-radius: 0;
            font-weight: bold;
        }

        .view_item, .edit_image {
            display:none;
            position:absolute;
            right:10px;
            top:10px;
            color:white;
            background-color: #df3823;
            border-radius: 4px;
            padding-right: 4px;
            padding-left: 4px
        }

        .view_item:hover, .edit_image:hover {
            color: white;
        }

        .box {
            max-width: 240px;
            margin: 5px;
            padding: 5px;
            float: left;
            width: 100%;
        }
        .error-summary {
            color: #a94442;
            background: #fdf7f7;
            border-left: 3px solid #eed3d7;
            padding: 10px 20px;
            margin: 0 0 15px 0;
        }
        .form-group {
            margin-top:10px;
            margin-bottom: 0;
        }

        .tab-content {
            padding:0;
        }

        .sorter
        {
            margin: 10px 0;
            padding: 0;
            list-style-type: none;
        }

        .asc, .desc { font-weight: bold; }

        .sorter li { margin-left: 15px; display: inline; }


        *, *:before, *:after {box-sizing:  border-box !important;}

        .myrow {
            -moz-column-width: 22em;
            -webkit-column-width: 22em;
            -moz-column-gap: 1em;
            -webkit-column-gap:1em;
        }

        .item {
            display: inline-block;
            padding:  1rem;
            width:  100%;
            cursor: pointer;
        }

        .thumbnail {
            position:relative;
            display: block;
            margin-bottom:0;
        }

        .help-block {
            font-size: 80%
        }
        .editable-container.editable-inline, .editableform > .control-group, .editable-input, .editableform .form-control {
            width:99%;
        }
        .panel-footer-controls {
            float: right;
        }
        .caption > p { word-wrap: break-word; }

        #loading { z-index: 10000; position:absolute; top:0px; left:0px; height:100%; width:100%; background-color:white/*rgba(0,0,0,0.25)*/; color:#000; text-align:center; }

        .play {
            background: url('http://cdn1.iconfinder.com/data/icons/iconslandplayer/PNG/64x64/CircleBlue/Play1Pressed.png') center center no-repeat;
            position: absolute;
            opacity: 0.7;
            top: 25%;
            left: 50%;
            width: 70px;
            height: 70px;
            margin: -35px 0 0 -35px;
            z-index: 10;
        }
        .show_more_link {
            font-size:80%
        }

        .select-image {
            max-width: 25px;
            max-height: 25px;
            margin-right:7px
        }

    </style>
    <?= \yii\helpers\Html::csrfMetaTags() ?>
    <?php

    $this->registerJs("

    $('.box').on('mouseover', function(e) {
        $(this).find('.view_item').show();
    });
    $('.box').on('mouseout', function(e) {
        $(this).find('.view_item').hide();
    });
    $('.list_image').on('mouseover', function(e) {
        $(this).find('.edit_image').show();
    });
    $('.list_image').on('mouseout', function(e) {
        $('.edit_image').hide();
    });

        $(function() {
            $('.show_more_link').each(function() {
                show_more($(this), 'load');
            });
        });

        $('.show_more_link').on('click', function(e) {
            e.preventDefault();
            show_more($(this), 'click');
        });

        function show_more(elem, action)
        {
            if(action == 'load')
            {
                if(typeof(Storage) !== 'undefined' && localStorage.getItem(elem.attr('id')) == 'show')
                {
                   elem.text('More Options');
                }
                else
                {
                   elem.text('Less Options');
                }
            }
            if(elem.text() == 'More Options')
                {
                   elem.text('Less Options');
                   elem.parent().next().show('fast');
                   if(elem.hasClass('scroll_bottom') && action != 'load')
                   {
                       $('html, body').animate({ scrollTop: $(document).height() }, 'fast');
                   }

                    if(typeof(Storage) !== 'undefined') {
                        // Code for localStorage/sessionStorage.
                        localStorage.setItem(elem.attr('id'), 'show');
                    } else {
                        // Sorry! No Web Storage support..
                    }
                }
                else
                {
                   elem.text('More Options');
                   elem.parent().next().hide('slow');

                    if(typeof(Storage) !== 'undefined') {
                        // Code for localStorage/sessionStorage.
                        localStorage.setItem(elem.attr('id'), 'hide');
                    } else {
                        // Sorry! No Web Storage support..
                    }
                }
            }

        /*
        $('.thumbnail').on('mouseover', function() {
           $('.thumbnail').css('opacity', '0.75');
           $(this).css('opacity', '1');
        });
        $('.thumbnail').on('mouseout', function() {
           $('.thumbnail').css('opacity', '1');
        });
        */
            $('.select2').select2({
                    allowClear: true,
                    placeholder: \"(Choose one)\"
            });
            $('#jumpto_menu').on('change', function() {
                location.href = $(this).val();
            });
            $('#jumpto_menu option[value=\"' + window.location.pathname + window.location.search + '\"]').attr('selected', 'selected');

$('.tooltips').tooltip();
/*
myvar = setTimeout(function(){
document.getElementById('loading').style.display = 'none';
clearTimeout(myvar);
}, 30000);*/
        ");

    $this->registerJs('
$("#videoModal").on("hidden.bs.modal", function (e) {
    var video = $("#youtube-video").attr("src");
    $("#youtube-video").attr("src","");
    $("#youtube-video").attr("src",video);
});
');
    ?>
</head>

<body class="theme-adminflare main-menu-animated">

<?php $this->beginBody() ?>

<script>var init = [];</script>
<?php /* ?>
<div id="loading">
        <h1 style="margin-top:200px">Loading...</h1><img src="<?=Yii::$app->params['imageUrl']?>loading.gif">
</div>
 <?php */ ?>

<div id="main-wrapper">

    <!-- 2. $MAIN_NAVIGATION ===========================================================================

        Main navigation
    -->
    <div id="main-navbar" class="navbar navbar-inverse" role="navigation">
        <!-- Main menu toggle -->
        <button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>

        <div class="navbar-inner">
            <!-- Main navbar header -->
            <div class="navbar-header">

                <!-- Logo -->
                <link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
                <a href="<?php echo \Yii::$app->urlManager->createUrl('/site/index'); ?>" class="navbar-brand" style="font-family: 'Audiowide', cursive; font-size:100%">
                    <div><img alt="Pixel Admin" src="<?php echo Yii::$app->params['imageUrl']; ?>/postradamus-logo.png"></div>
                    <?=strtoupper(Yii::$app->name)?>
                </a>

                <!-- Main navbar toggle -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>

            </div> <!-- / .navbar-header -->

            <div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
                <div>
                    <ul class="nav navbar-nav navbar-right">
                        <?php /* ?>
    <li>
        <a href="<?php echo \Yii::$app->urlManager->createUrl('/site/index'); ?>">Home</a>
    </li>
    <li style="line-height:46px; padding: 0 15px">
        Jump To:
        <select id="jumpto_menu">
            <option value="<?php echo \Yii::$app->urlManager->createUrl('/site/index'); ?>"></option>
            <option value="<?php echo \Yii::$app->urlManager->createUrl('/site/index'); ?>">Dashboard</option>
            <optgroup label="Content">
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/content/facebook'); ?>">Facebook</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/content/twitter'); ?>">Twitter</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/content/pinterest'); ?>">Pinterest</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/content/instagram'); ?>">Instagram</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/content/youtube'); ?>">YouTube</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/content/amazon'); ?>">Amazon</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/content/imgur'); ?>">Imgur</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/content/webpage'); ?>">Webpage</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/content/upload'); ?>">Find on Computer</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/content/list'); ?>">Find in Existing List</option>
            </optgroup>
            <optgroup label="Lists">
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/list/index'); ?>">Manage Lists</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/list/create'); ?>">New List</option>
            </optgroup>
            <optgroup label="Export">
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/export/facebook-api'); ?>">Facebook Direct (Easy)</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/export/facebook-macro'); ?>">Facebook Macro (Advanced)</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/export/csv'); ?>">CSV</option>
            </optgroup>
            <optgroup label="Settings">
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/setting/update'); ?>">General</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/user/index'); ?>">Users</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/connection-facebook/update'); ?>">Facebook Connection</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/connection-amazon/index'); ?>">Amazon Connection</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/schedule/index'); ?>">Schedules</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/post-template/index'); ?>">Post Templates</option>
                <option value="<?php echo \Yii::$app->urlManager->createUrl('/post-type/index'); ?>">Post Types</option>
            </optgroup>
        </select>
    </li>
<?php */ ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php
                                $campaign = \common\models\cCampaign::find()->where(['id' => Yii::$app->session->get('campaign_id')])->one();
                                if($campaign->image_url)
                                {
                                    $image_url = Yii::$app->params['imageUrl'] . 'campaigns/' . $campaign->user_id . '/' . $campaign->image_url;
                                }
                                elseif($campaign->id != 0)
                                {
                                    $image_url = 'https://cdn1.iconfinder.com/data/icons/humano2/128x128/places/kde-folder.png';
                                }
                                else
                                {
                                    $image_url = 'https://cdn1.iconfinder.com/data/icons/humano2/128x128/places/kde-folder-bookmarks.png';
                                }
                                ?>
                                <img alt="Pixel Admin" src="<?=$image_url?>" style="max-height:18px; margin-bottom:2px; margin-right:3px">
                                <?php echo ($campaign->name ? $campaign->name : 'Master Campaign'); ?> <span class="fa fa-chevron-circle-down"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=Yii::$app->urlManager->createUrl(['campaign/switch', 'id' => 0])?>"><img alt="Pixel Admin" src="https://cdn1.iconfinder.com/data/icons/humano2/128x128/places/kde-folder-bookmarks.png" style="max-height:18px; max-width: 18px; margin-bottom:2px; margin-right:3px"> Master Campaign</a></li>

                                <?php
                                $campaigns = \common\models\cCampaign::find()->orderBy('name')->all();
                                foreach($campaigns as $campaign) {
                                    if(!$campaign->image_url)
                                    {
                                        $image_url = 'https://cdn1.iconfinder.com/data/icons/humano2/128x128/places/kde-folder.png';
                                    }
                                    elseif(Yii::$app->user->identity->getField('parent_id') != 0)
                                    {
                                        $image_url = Yii::$app->params['imageUrl'] . 'campaigns/' . Yii::$app->user->identity->getField('parent_id') . '/' . $campaign->image_url;
                                    }else{
                                        $image_url = Yii::$app->params['imageUrl'] . 'campaigns/' . Yii::$app->user->id . '/' . $campaign->image_url;
                                    }
                                    ?>
                                    <li style="margin-left:15px"><a href="<?=Yii::$app->urlManager->createUrl(['campaign/switch', 'id' => $campaign->id])?>"><img src="<?php echo $image_url; ?>" alt="" class="" style="max-height:18px; max-width:18px"> <?=$campaign->name?></a></li>
                                <?php } ?>
                                <li class="divider"></li>
                                <li><a href="<?=Yii::$app->urlManager->createUrl(['campaign/create', 'id' => 0])?>"><span class="fa fa-plus-square"></span> New Campaign</a></li>
                            </ul>
                        </li>
                    </ul> <!-- / .navbar-nav -->

                    <div class="right clearfix">

                    </div> <!-- / .right -->
                </div>
            </div> <!-- / #main-navbar-collapse -->
        </div> <!-- / .navbar-inner -->
    </div> <!-- / #main-navbar -->
    <!-- /2. $END_MAIN_NAVIGATION -->

    <div id="main-menu" role="navigation">
        <div id="main-menu-inner">
            <div class="menu-content top" id="menu-content-demo">
                <!-- Menu custom content demo
                     CSS:        styles/pixel-admin-less/demo.less or styles/pixel-admin-scss/_demo.scss
                     Javascript: html/assets/demo/demo.js
                 -->
                <div>
                    <div class="text-bg"><span class="text-slim">Welcome,</span> <span class="text-semibold"><?php if(is_object(Yii::$app->user->identity)) { echo Yii::$app->user->identity->getField('first_name'); } ?></span></div>

                    <a href="http://www.gravatar.com" target="new"><img src="http://www.gravatar.com/avatar/<?php if(is_object(Yii::$app->user->identity)) { echo md5(strtolower(trim(Yii::$app->user->identity->getField('email')))); } ?>" alt="" class=""></a>
                    <div class="btn-group">
                        <a href="<?php echo \Yii::$app->urlManager->createUrl('site/index'); ?>" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-dashboard"></i></a>
                        <a href="<?php echo \Yii::$app->urlManager->createUrl('profile/update'); ?>" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-user"></i></a>
                        <?php /* ?><a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-user"></i></a><?php */ ?>
                        <a href="<?php echo \Yii::$app->urlManager->createUrl('setting/update'); ?>" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-cog"></i></a>
                        <a href="<?php echo \Yii::$app->urlManager->createUrl('site/logout'); ?>" class="btn btn-xs btn-danger btn-outline dark"><i class="fa fa-power-off"></i></a>
                    </div>
                </div>
            </div>
            <ul class="navigation">
                <li>
                    <a href="<?=\Yii::$app->urlManager->createUrl('site/index')?>"><i class="menu-icon fa fa-dashboard"></i><span class="mm-text" style="font-size:110%">Dashboard</span></a>
                </li>
                <li class="mm-dropdown">
                    <a href="#" id="content_link"><i class="menu-icon fa fa-picture-o"></i><span class="mm-text" style="font-size:110%">1. Content</span></a>
                    <ul>
                        <li class="mm-dropdown">
                            <a href="#" id="find_on_web_link"><i class="menu-icon fa fa-globe"></i><span class="mm-text">Find on Web</span></a>
                            <ul>
                                <li>
                                    <a id="facebook_link" tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/facebook')?>"><i class="menu-icon fa fa-facebook"></i><span class="mm-text">Facebook</span></a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/twitter-search')?>"><i class="menu-icon fa fa-twitter"></i><span class="mm-text">Twitter</span></a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/pinterest')?>"><i class="menu-icon fa fa-pinterest"></i><span class="mm-text">Pinterest</span></a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/instagram')?>"><i class="menu-icon fa fa-instagram"></i><span class="mm-text">Instagram</span></a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/youtube')?>"><i class="menu-icon fa fa-youtube"></i><span class="mm-text">YouTube</span></a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/amazon')?>"><i class="menu-icon fa fa-book"></i><span class="mm-text">Amazon</span></a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/reddit')?>"><i class="menu-icon fa fa-reddit"></i><span class="mm-text">Reddit</span></a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/tumblr')?>"><i class="menu-icon fa fa-tumblr"></i><span class="mm-text">Tumblr</span></a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/imgur')?>"><i class="menu-icon fa fa-circle"></i><span class="mm-text">Imgur</span></a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/webpage')?>"><i class="menu-icon fa fa-globe"></i><span class="mm-text">Webpage</span></a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/feed')?>"><i class="menu-icon fa fa-rss"></i><span class="mm-text">Feeds</span><?php /* ?><span class="label label-success">New</span><?php */ ?></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/upload')?>"><i class="menu-icon fa fa-upload"></i><span class="mm-text">Find on Computer</span></a>
                        </li>
                        <li>
                            <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/list')?>"><i class="menu-icon fa fa-folder-open"></i><span class="mm-text">Find in Existing List</span></a>
                        </li>
                        <li>
                            <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('content/csv')?>"><i class="menu-icon fa fa-list-alt"></i><span class="mm-text">Import from CSV</span><span class="label label-success">New</span></a>
                        </li>
                    </ul>
                </li>
                <li class="mm-dropdown">
                    <a href="#"><i class="menu-icon fa fa-tasks"></i><span class="mm-text" style="font-size:110%">2. Lists</span></a>
                    <ul>
                        <li>
                            <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('list/not-ready')?>"><i class="menu-icon fa fa-ban"></i><span class="mm-text">Not Ready (<?php echo \common\models\cList::findNotReady()->count(); ?>)</span></a>
                        </li>
                        <li>
                            <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('list/ready')?>"><i class="menu-icon fa fa-check-circle"></i><span class="mm-text">Ready (<?php echo \common\models\cList::findReady()->count(); ?>)</span></a>
                        </li>
                        <li>
                            <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('list/sending')?>"><i class="menu-icon fa fa-rocket"></i><span class="mm-text">Sending (<?php echo \common\models\cList::findSending()->count();?>)</span></a>
                        </li>
                        <li>
                            <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('list/sent')?>"><i class="menu-icon fa fa-rocket"></i><span class="mm-text">Sent (<?php echo \common\models\cList::findSent()->count();?>)</span></a>
                        </li>
                        <li>
                            <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('list/create')?>"><i class="menu-icon fa fa-plus-square"></i><span class="mm-text">New List</span></a>
                        </li>
                    </ul>
                </li>
                <li class="mm-dropdown">
                    <a tabindex="-1" href="#"><i class="menu-icon fa fa-download"></i><span class="mm-text" style="font-size:110%">3. Export</span></a>
                    <ul>
                        <li>
                            <a href="<?=\Yii::$app->urlManager->createUrl('export/facebook-api')?>"><i class="menu-icon fa fa-facebook"></i><span class="mm-text">Facebook</span></a>
                        </li>
                        <?php /* ?><li>
                <a href="<?=\Yii::$app->urlManager->createUrl('export/rss')?>"><i class="menu-icon fa fa-rss-square"></i><span class="mm-text">RSS</span></a>
            </li><?php */ ?>
                        <li>
                            <a href="<?=\Yii::$app->urlManager->createUrl('export/pinterest')?>"><i class="menu-icon fa fa-pinterest"></i><span class="mm-text">Pinterest</span></a>
                        </li>
                        <li>
                            <a href="<?=\Yii::$app->urlManager->createUrl('export/wordpress')?>"><i class="menu-icon fa fa-wordpress"></i><span class="mm-text">Wordpress</span></a>
                        </li>
                        <li>
                            <a href="<?=\Yii::$app->urlManager->createUrl('export/csv')?>"><i class="menu-icon fa fa-list-alt"></i><span class="mm-text">CSV</span></a>
                        </li>
                        <li>
                            <a href="<?=\Yii::$app->urlManager->createUrl('export/facebook-macro')?>"><i class="menu-icon fa fa-facebook"></i><span class="mm-text">FB Macro</span></a>
                        </li>
                    </ul>
                </li>
                <?php /* ?>
    <li class="mm-dropdown">
        <a tabindex="-1" href="#"><i class="menu-icon fa fa-clock-o"></i><span class="mm-text" style="font-size:110%">4. Qeued Posts</span></a>
        <ul>
            <li>
                <a href="<?=\Yii::$app->urlManager->createUrl('export/facebook-api')?>"><i class="menu-icon fa fa-facebook"></i><span class="mm-text">Scheduled</span></a>
            </li>
            <li>
                <a href="<?=\Yii::$app->urlManager->createUrl('export/facebook-macro')?>"><i class="menu-icon fa fa-facebook"></i><span class="mm-text">Sent</span></a>
            </li>
        </ul>
    </li>
 <?php */ ?>
                <li class="mm-dropdown">
                    <a href="#"><i class="menu-icon fa fa-cogs"></i><span class="mm-text" style="font-size:110%">Settings</span></a>
                    <ul>
                        <li>
                            <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('setting/update')?>"><i class="menu-icon fa fa-cog"></i><span class="mm-text">General</span></a>
                        </li>
                        <?php if(Yii::$app->user->identity->getField('parent_id') == 0) { ?>
                            <li>
                                <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('campaign/index')?>"><i class="menu-icon fa fa-suitcase"></i><span class="mm-text">Campaigns</span></a>
                            </li>
                        <?php } ?>
                        <?php if(Yii::$app->user->identity->getField('parent_id') == 0) { ?>
                            <li>
                                <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('user/index')?>"><i class="menu-icon fa fa-user"></i><span class="mm-text">Users</span></a>
                            </li>
                        <?php } ?>
                        <?php if(Yii::$app->user->identity->getField('parent_id') == 0) { ?>
                            <li class="mm-dropdown">
                                <a tabindex="-1" href="#"><i class="menu-icon fa fa-bolt"></i><span class="mm-text">Connections</span></a>
                                <ul>
                                    <li>
                                        <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('connection-facebook/update')?>"><i class="menu-icon fa fa-facebook"></i><span class="mm-text">Facebook</span></a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('connection-amazon/index')?>"><i class="menu-icon fa fa-book"></i><span class="mm-text">Amazon</span></a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('connection-pinterest/update')?>"><i class="menu-icon fa fa-pinterest"></i><span class="mm-text">Pinterest</span></a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('connection-wordpress/update')?>"><i class="menu-icon fa fa-wordpress"></i><span class="mm-text">Wordpress</span></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php /* ?><li>
                <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('call-to-action/index')?>"><i class="menu-icon fa fa-bullhorn"></i><span class="mm-text">Call to Actions</span></a>
            </li><?php */ ?>
                        <li>
                            <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('schedule/index')?>"><i class="menu-icon fa fa-calendar"></i><span class="mm-text">Schedules</span></a>
                        </li>
                        <li>
                            <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('post-template/index')?>"><i class="menu-icon fa fa-text-height"></i><span class="mm-text">Post Templates</span></a>
                        </li>
                        <li>
                            <a tabindex="-1" href="<?=\Yii::$app->urlManager->createUrl('post-type/index')?>"><i class="menu-icon fa fa-money"></i><span class="mm-text">Post Types</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
            </li>
            </ul> <!-- / .navigation -->

            <div class="menu-content">
                <a href="https://1s0s.freshdesk.com/support/home" class="btn btn-primary btn-block"><i class="menu-icon fa fa-question-circle"></i> Help</a>
                <a href="http://1s0s.com/instapost/index.php?r=site/index&access_code=postradamus" class="btn btn-success btn-block"><i class="menu-icon fa fa-th-large"></i> Bonus: InstaPost</a>
            </div>
        </div> <!-- / #main-menu-inner -->
    </div> <!-- / #main-menu -->
    <!-- /4. $MAIN_MENU -->


    <div id="content-wrapper">
        <?php
        echo \yii\widgets\Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink' => ['label' => 'Dashboard', 'url' => Yii::$app->urlManager->createUrl('site/index')],
            'options' => ['class' => 'breadcrumb breadcrumb-page'],
        ]);
        ?>

        <?php
        foreach(Yii::$app->session->getAllFlashes() as $key => $message) {
            echo '<div class="alert alert-' . $key . '"><a class="close" data-dismiss="alert" href="#">x</a>' . $message . "</div>\n";
        }
        ?>

        <?php echo $this->context->before_panel; ?>

        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title"><?= \yii\helpers\Html::encode($this->title) ?></span>
                <?php echo $this->context->panel_heading_controls; ?>
            </div>

            <div class="panel-body">

                <?php if($this->params['help']['message'] != '') { ?>
                    <div class="note note-info padding-xs-vr">
                        <?php if($this->params['help']['modal_body']) { ?>
                            <a href="#" data-toggle="modal" data-target="#videoModal"><img src="<?php echo Yii::$app->params['imageUrl']; ?>video-icon.png" style="float: left; margin-right:15px; margin-top:3px"></a>
                        <?php } ?>
                        <h4>What is this?</h4> <?php echo $this->params['help']['message']; ?>
                    </div>

                    <?php if($this->params['help']['modal_body']) { ?>
                        <div id="videoModal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="myModalLabel">Video Help</h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo $this->params['help']['modal_body']; ?>
                                    </div> <!-- / .modal-body -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div> <!-- / .modal-content -->
                            </div> <!-- / .modal-dialog -->
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php if($this->params['error']['message'] != '') { ?>
                    <div class="note note-danger padding-xs-vr">
                        <?php if($this->params['error']['modal_body']) { ?>
                            <a href="#" data-toggle="modal" data-target="#videoModal"><img src="<?php echo Yii::$app->params['imageUrl']; ?>video-icon.png" style="float: left; margin-right:15px; margin-top:3px"></a>
                        <?php } ?>
                        <h4>Oops. There's a problem.</h4> <?php echo $this->params['error']['message']; ?>
                    </div>

                    <?php if($this->params['error']['modal_body']) { ?>
                        <div id="videoModal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="myModalLabel">Video Help</h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo $this->params['error']['modal_body']; ?>
                                    </div> <!-- / .modal-body -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div> <!-- / .modal-content -->
                            </div> <!-- / .modal-dialog -->
                        </div>
                    <?php } ?>
                <?php } ?>

                <!-- Content here -->
                <?php echo $content; ?>

            </div> <!-- / #content-wrapper -->
            <div id="main-menu-bg"></div>
        </div> <!-- / #main-wrapper -->

        <!-- Pixel Admin's javascripts --><?php /* ?>
<script src="<?php echo $this->theme->baseUrl; ?>/assets/javascripts/bootstrap.min.js"></script>
<script src="<?php echo $this->theme->baseUrl; ?>/assets/javascripts/pixel-admin.min.js"></script><?php */ ?>

        <?php $this->endBody() ?>
        <script type="text/javascript">
            /*
             $( document ).ready(function() {
             document.getElementById('loading').style.display = 'none';
             });*/

            init.push(function () {
            })
            window.PixelAdmin.start(init);
        </script>

        <?php

        $this->registerJs("
$(function () {

jQuery(document).ready(function() {
    jQuery('img.lazy').lazy({
        afterLoad: function(element) {
            // this will be called after the image is finally loaded
            if(element.hasClass('fb-img'))
            {
                $.ajax('" . Yii::$app->urlManager->createUrl('content/fb-get-large-image') . "', {
                   data: {
                        object_id: element.data('object-id'),
                        page_id: element.data('page-id')
                   },
                   method: 'get',
                   context: this,
                   dataType: 'json'
                }).done(function(data) {
                    if(data.img_src != false && data.img_src != null)
                    {
                        element.attr('src', data.img_src).load(function() {
                             var container = $('#mason-container');
                             container.masonry();
                             dimImages(element);
                        });
                        element.parent().attr('href', data.img_src);
                    }
                    element.removeClass('fb-img');
                });
            }
            container.masonry();
            dimImages(element);
        }
    });
});

$(\"input[name='dim-options']\").change(function(){
    $('img.lazy').each(function (index) {
        dimImages($(this));
    });
});

function dimImages(element)
{
    if(element.hasClass('photo-post'))
    {
       if($('#dim-small').is(':checked') == true && (element[0].naturalWidth < 504 || element[0].naturalHeight < 504))
       {
           $(element).parent().parent().css('opacity', '.20');
       }
       else if($('#dim-tiny').is(':checked') == true && (element[0].naturalWidth < 199 || element[0].naturalHeight < 199))
       {
           $(element).parent().parent().css('opacity', '.20');
       }
       else
       {
           $(element).parent().parent().css('opacity', '1');
       }
    }
    if(element.hasClass('link-post'))
    {
       if($('#dim-small').is(':checked') == true && (element[0].naturalWidth < 484 || element[0].naturalHeight < 252))
       {
           $(element).parent().parent().css('opacity', '.20');
       }
       else if($('#dim-tiny').is(':checked') == true && (element[0].naturalWidth < 199 || element[0].naturalHeight < 199))
       {
           $(element).parent().parent().css('opacity', '.20');
       }
       else
       {
           $(element).parent().parent().css('opacity', '1');
       }
    }
}

var container = $('#mason-container');
imagesLoaded( container, function() {
    var reMasonry = function () {
        container.masonry();
    };
    // trigger masonry
    $('#mason-container').masonry({
        columnWidth: 250,
        animate: false,
        isFitWidth: true,
		transitionDuration: 0
    });
    $('.box').click(function () {
        var _this = $(this);
        size = _this.hasClass('large') ? {
           width: 230,
        } : {
           width: 440,
        };
        _this.toggleClass('large').animate(230, reMasonry);
    });
    });
});
");
        ?>
        <?php
        if (isset($this->blocks['viewJs'])):
            echo $this->blocks['viewJs'] ;
        else:
        endif;
        ?>
</body>
</html>
<?php $this->endPage() ?>