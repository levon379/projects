<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>CommuniTraders - Analysis tool - Dashboard</title>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link href="{$url}assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="{$url}assets/css/admin_style.css" rel="stylesheet" type="text/css"/>
        <link href="{$url}assets/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
        <link href="{$url}assets/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css"/>
        <link href="{$url}assets/css/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="{$url}assets/js/jquery.js"></script>
        <script type="text/javascript" src="{$url}assets/js/jquery-ui.js"></script>
        <script type="text/javascript" src="{$url}assets/js/jquery.cookie.js"></script>
        <script type="text/javascript" src="{$url}assets/js/bootstrap.js"></script>
        <script type="text/javascript" src="{$url}assets/js/moment.js"></script>
        <script type="text/javascript" src="{$url}assets/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="{$url}assets/js/bootstrap-datetimepicker.js"></script>
		 <script type="text/javascript" src="{$url}assets/js/daterangepicker.js"></script>
        <script type="text/javascript" src="{$url}assets/js/admin.js"></script>
		
		 
			
    </head>
    <body data-spy="scroll" data-target=".subnav" data-offset="50" data-twttr-rendered="true"> 
        <div id="main_container">
            <div id="header">
                <div class="dashboard-title pull-left">
                CommuniTraders - Analysis tool - Dashboard</div>
                <div class="dashboard-notifications pull-right">
                    <div class="rss-notification pull-left"><i class="fa fa-rss"></i></div>
                    <div class="twitter-notification pull-left"><i class="fa fa-twitter"></i></div>
                    <div class="mail-notification pull-left"><i class="fa fa-envelope"></i>
                        <span class="fa-stack" style="font-size: 10px;">
                            <i class="fa fa-circle fa-stack-2x" style="color: #5cb85c"></i>
                            <span class="fa fa-stack-1x fa-inverse" style="font-size: 14px;">1</span>
                        </span>
                    </div>
                    <div class="admin-notification pull-left"><i class="fa fa-flag"></i>
                        <span class="fa-stack" style="font-size: 10px;">
                            <i class="fa fa-circle fa-stack-2x" style="color: #d9534f"></i>
                            <span class="fa fa-stack-1x fa-inverse" style="font-size: 14px;">3</span>
                        </span>
                        <span class="fa-stack" style="font-size: 10px;">
                            <i class="fa fa-circle fa-stack-2x" style="color: #f0ad4e"></i>
                            <span class="fa fa-stack-1x fa-inverse" style="font-size: 14px;">2</span>
                        </span>
                    </div>
                    <a href="{$url}admin/logout">Logout</a>
                </div>
            </div>
            <div id="content_box">
