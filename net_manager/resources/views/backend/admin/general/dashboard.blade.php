@extends('layouts.backend')

@section('stylesheets')

@append
@section('content')
        <!-- Page content-->
        <div class="content-wrapper">
            <div class="content-heading">
                <!-- START Language list-->
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" data-toggle="dropdown" class="btn btn-default">English</button>
                        <ul role="menu" class="dropdown-menu dropdown-menu-right animated fadeInUpShort">
                            <li><a href="#" data-set-lang="en">English</a>
                            </li>
                            <li><a href="#" data-set-lang="nl">Nederlands</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END Language list    -->
                Dashboard
                <small data-localize="dashboard.WELCOME">Welcome to NetManager!</small>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <!-- START widget-->
                    <div class="panel widget bg-primary">
                        <div class="row row-table">
                            <div class="col-xs-4 text-center bg-primary-dark pv-lg">
                                <em class="icon-cloud-upload fa-3x"></em>
                            </div>
                            <div class="col-xs-8 pv-lg">
                                <div class="h2 mt0">10</div>
                                <div class="text-uppercase">Locations</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <!-- START widget-->
                    <div class="panel widget bg-purple">
                        <div class="row row-table">
                            <div class="col-xs-4 text-center bg-purple-dark pv-lg">
                                <em class="icon-globe fa-3x"></em>
                            </div>
                            <div class="col-xs-8 pv-lg">
                                <div class="h2 mt0">100
                                </div>
                                <div class="text-uppercase">Players</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <!-- START widget-->
                    <div class="panel widget bg-green">
                        <div class="row row-table">
                            <div class="col-xs-4 text-center bg-green-dark pv-lg">
                                <em class="icon-bubbles fa-3x"></em>
                            </div>
                            <div class="col-xs-8 pv-lg">
                                <div class="h2 mt0">50</div>
                                <div class="text-uppercase">Coaches</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <!-- START date widget-->
                    <div class="panel widget">
                        <div class="row row-table">
                            <div class="col-xs-4 text-center bg-green pv-lg">
                                <!-- See formats: https://docs.angularjs.org/api/ng/filter/date-->
                                <div data-now="" data-format="MMMM" class="text-sm">July</div>
                                <br>
                                <div data-now="" data-format="D" class="h2 mt0">17</div>
                            </div>
                            <div class="col-xs-8 pv-lg">
                                <div data-now="" data-format="dd" class="text-uppercase">Sunday</div>
                                <br>
                                <div data-now="" data-format="h:mm" class="h2 mt0">1:35</div>
                                <div data-now="" data-format="a" class="text-muted text-sm">am</div>
                            </div>
                        </div>
                    </div>
                    <!-- END date widget    -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- START panel tab-->
                    <div role="tabpanel" class="panel panel-transparent">
                        <!-- Nav tabs-->
                        <ul role="tablist" class="nav nav-tabs nav-justified">
                            <li role="presentation" class="active">
                                <a aria-expanded="true" href="#home" aria-controls="home" role="tab" data-toggle="tab"
                                   class="bb0">
                                    <em class="fa fa-clock-o fa-fw"></em>Activity log</a>
                            </li>
                            <li class="" role="presentation">
                                <a aria-expanded="false" href="#profile" aria-controls="profile" role="tab"
                                   data-toggle="tab" class="bb0">
                                    <em class="fa fa-money fa-fw"></em>Payments</a>
                            </li>
                        </ul>
                        <!-- Tab panes-->
                        <div class="tab-content p0 bg-white">
                            <div id="home" role="tabpanel" class="tab-pane active">
                                <!-- START list group-->
                                <div class="list-group mb0">
                                    <a href="#" class="list-group-item bt0">
                                        <span class="label label-purple pull-right">just now</span>
                                        <em class="fa fa-fw fa-calendar mr"></em>Calendar updated</a>
                                    <a href="#" class="list-group-item">
                                        <span class="label label-purple pull-right">4 minutes ago</span>
                                        <em class="fa fa-fw fa-comment mr"></em>Commented on a post</a>
                                    <a href="#" class="list-group-item">
                                        <span class="label label-purple pull-right">23 minutes ago</span>
                                        <em class="fa fa-fw fa-truck mr"></em>Order 392 shipped</a>
                                    <a href="#" class="list-group-item">
                                        <span class="label label-purple pull-right">46 minutes ago</span>
                                        <em class="fa fa-fw fa-money mr"></em>Invoice 653 has been paid</a>
                                    <a href="#" class="list-group-item">
                                        <span class="label label-purple pull-right">1 hour ago</span>
                                        <em class="fa fa-fw fa-user mr"></em>A new user has been added</a>
                                    <a href="#" class="list-group-item">
                                        <span class="label label-purple pull-right">2 hours ago</span>
                                        <em class="fa fa-fw fa-check mr"></em>Completed task: "pick up dry cleaning"</a>
                                    <a href="#" class="list-group-item">
                                        <span class="label label-purple pull-right">yesterday</span>
                                        <em class="fa fa-fw fa-globe mr"></em>Saved the world</a>
                                    <a href="#" class="list-group-item">
                                        <span class="label label-purple pull-right">two days ago</span>
                                        <em class="fa fa-fw fa-check mr"></em>Completed task: "fix error on sales page"</a>
                                    <a href="#" class="list-group-item">
                                        <span class="label label-purple pull-right">two days ago</span>
                                        <em class="fa fa-fw fa-check mr"></em>Completed task: "fix error on sales page"</a>
                                </div>
                                <!-- END list group-->
                                <div class="panel-footer text-right"><a href="#" class="btn btn-default btn-sm">View All
                                        Activity </a>
                                </div>
                            </div>
                            <div id="profile" role="tabpanel" class="tab-pane">
                                <!-- START table responsive-->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Order Date</th>
                                            <th>Order Time</th>
                                            <th>Amount (USD)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>3326</td>
                                            <td>10/21/2013</td>
                                            <td>3:29 PM</td>
                                            <td>$321.33</td>
                                        </tr>
                                        <tr>
                                            <td>3325</td>
                                            <td>10/21/2013</td>
                                            <td>3:20 PM</td>
                                            <td>$234.34</td>
                                        </tr>
                                        <tr>
                                            <td>3324</td>
                                            <td>10/21/2013</td>
                                            <td>3:03 PM</td>
                                            <td>$724.17</td>
                                        </tr>
                                        <tr>
                                            <td>3323</td>
                                            <td>10/21/2013</td>
                                            <td>3:00 PM</td>
                                            <td>$23.71</td>
                                        </tr>
                                        <tr>
                                            <td>3322</td>
                                            <td>10/21/2013</td>
                                            <td>2:49 PM</td>
                                            <td>$8345.23</td>
                                        </tr>
                                        <tr>
                                            <td>3321</td>
                                            <td>10/21/2013</td>
                                            <td>2:23 PM</td>
                                            <td>$245.12</td>
                                        </tr>
                                        <tr>
                                            <td>3320</td>
                                            <td>10/21/2013</td>
                                            <td>2:15 PM</td>
                                            <td>$5663.54</td>
                                        </tr>
                                        <tr>
                                            <td>3319</td>
                                            <td>10/21/2013</td>
                                            <td>2:13 PM</td>
                                            <td>$943.45</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END table responsive-->
                                <div class="panel-footer text-right"><a href="#" class="btn btn-default btn-sm">View All
                                        Transactions</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END panel tab-->
                </div>
            </div>
        </div>
        {{--<div class="unwrap mv-lg">--}}
            {{--<!-- START chart-->--}}
            {{--<div id="panelChart9" class="panel">--}}
                {{--<div class="panel-heading">--}}
                    {{--<!-- START button group-->--}}
                    {{--<div class="pull-right btn-group">--}}
                        {{--<button type="button" data-toggle="dropdown" class="dropdown-toggle btn btn-default btn-sm">--}}
                            {{--All time--}}
                        {{--</button>--}}
                        {{--<ul role="menu" class="dropdown-menu fadeInLeft animated">--}}
                            {{--<li><a href="#">Daily</a>--}}
                            {{--</li>--}}
                            {{--<li><a href="#">Monthly</a>--}}
                            {{--</li>--}}
                            {{--<li class="divider"></li>--}}
                            {{--<li><a href="#">All time</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<!-- END button group-->--}}

                {{--</div>--}}

            {{--</div>--}}
            {{--<!-- END chart-->--}}
        {{--</div>--}}
        {{--<!-- START radial charts-->--}}
        {{--<div class="row mb-lg">--}}
            {{--<div class="col-sm-3 col-xs-6 text-center">--}}
                {{--<p>Current Project</p>--}}
                {{--<canvas data-classyloader="" data-height="150px" data-diameter="60" data-font-size="25px"--}}
                        {{--data-percentage="60" data-speed="30" data-line-color="#23b7e5"--}}
                        {{--data-remaining-line-color="#edf2f6" data-line-width="2"></canvas>--}}
            {{--</div>--}}
            {{--<div class="col-sm-3 col-xs-6 text-center">--}}
                {{--<p>Current Progress</p>--}}
                {{--<canvas data-classyloader="" data-height="150px" data-diameter="60" data-font-size="25px"--}}
                        {{--data-percentage="30" data-speed="30" data-line-color="#f532e5"--}}
                        {{--data-remaining-line-color="#edf2f6" data-line-width="2"></canvas>--}}
            {{--</div>--}}
            {{--<div class="col-sm-3 col-xs-6 text-center">--}}
                {{--<p>Space Usage</p>--}}
                {{--<canvas data-classyloader="" data-height="150px" data-diameter="60" data-font-size="25px"--}}
                        {{--data-percentage="50" data-speed="30" data-line-color="#7266ba"--}}
                        {{--data-remaining-line-color="#edf2f6" data-line-width="2"></canvas>--}}
            {{--</div>--}}
            {{--<div class="col-sm-3 col-xs-6 text-center">--}}
                {{--<p>Interactions</p>--}}
                {{--<canvas data-classyloader="" data-height="150px" data-diameter="60" data-font-size="25px"--}}
                        {{--data-percentage="75" data-speed="30" data-line-color="#ff902b"--}}
                        {{--data-remaining-line-color="#edf2f6" data-line-width="2"></canvas>--}}
            {{--</div>--}}
        {{--</div>--}}
        <!-- START radial charts-->
        <!-- START Multiple List group-->
        {{--<div class="list-group">--}}
            {{--<a href="#" class="list-group-item">--}}
                {{--<table class="wd-wide">--}}
                    {{--<tbody>--}}
                    {{--<tr>--}}
                        {{--<td class="wd-xs">--}}
                            {{--<div class="ph">--}}
                                {{--<img src="img/dummy.png" alt=""--}}
                                     {{--class="media-box-object img-responsive img-rounded thumb64">--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<div class="ph">--}}
                                {{--<h4 class="media-box-heading">Project A</h4>--}}
                                {{--<small class="text-muted">Vestibulum ante ipsum primis in faucibus orci</small>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td class="wd-sm hidden-xs hidden-sm">--}}
                            {{--<div class="ph">--}}
                                {{--<p class="m0">Last change</p>--}}
                                {{--<small class="text-muted">4 weeks ago</small>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td class="wd-xs hidden-xs hidden-sm">--}}
                            {{--<div class="ph">--}}
                                {{--<p class="m0 text-muted">--}}
                                    {{--<em class="icon-users mr fa-lg"></em>26</p>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td class="wd-xs hidden-xs hidden-sm">--}}
                            {{--<div class="ph">--}}
                                {{--<p class="m0 text-muted">--}}
                                    {{--<em class="icon-doc mr fa-lg"></em>3500</p>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td class="wd-sm">--}}
                            {{--<div class="ph">--}}
                                {{--<progressbar value="80" type="success" class="m0 progress-xs">80%</progressbar>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--</tbody>--}}
                {{--</table>--}}
            {{--</a>--}}
        {{--</div>--}}
        {{--<div class="list-group">--}}
            {{--<a href="#" class="list-group-item">--}}
                {{--<table class="wd-wide">--}}
                    {{--<tbody>--}}
                    {{--<tr>--}}
                        {{--<td class="wd-xs">--}}
                            {{--<div class="ph">--}}
                                {{--<img src="img/dummy.png" alt=""--}}
                                     {{--class="media-box-object img-responsive img-rounded thumb64">--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<div class="ph">--}}
                                {{--<h4 class="media-box-heading">Project X</h4>--}}
                                {{--<small class="text-muted">Vestibulum ante ipsum primis in faucibus orci</small>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td class="wd-sm hidden-xs hidden-sm">--}}
                            {{--<div class="ph">--}}
                                {{--<p class="m0">Last change</p>--}}
                                {{--<small class="text-muted">Today at 06:23 am</small>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td class="wd-xs hidden-xs hidden-sm">--}}
                            {{--<div class="ph">--}}
                                {{--<p class="m0 text-muted">--}}
                                    {{--<em class="icon-users mr fa-lg"></em>3</p>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td class="wd-xs hidden-xs hidden-sm">--}}
                            {{--<div class="ph">--}}
                                {{--<p class="m0 text-muted">--}}
                                    {{--<em class="icon-doc mr fa-lg"></em>150</p>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td class="wd-sm">--}}
                            {{--<div class="ph">--}}
                                {{--<progressbar value="50" type="purple" class="m0 progress-xs">50</progressbar>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--</tbody>--}}
                {{--</table>--}}
            {{--</a>--}}
        {{--</div>--}}
        {{--<div class="list-group">--}}
            {{--<a href="#" class="list-group-item">--}}
                {{--<table class="wd-wide">--}}
                    {{--<tbody>--}}
                    {{--<tr>--}}
                        {{--<td class="wd-xs">--}}
                            {{--<div class="ph">--}}
                                {{--<img src="img/dummy.png" alt=""--}}
                                     {{--class="media-box-object img-responsive img-rounded thumb64">--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<div class="ph">--}}
                                {{--<h4 class="media-box-heading">Project Z</h4>--}}
                                {{--<small class="text-muted">Vestibulum ante ipsum primis in faucibus orci</small>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td class="wd-sm hidden-xs hidden-sm">--}}
                            {{--<div class="ph">--}}
                                {{--<p class="m0">Last change</p>--}}
                                {{--<small class="text-muted">Yesterday at 10:20 pm</small>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td class="wd-xs hidden-xs hidden-sm">--}}
                            {{--<div class="ph">--}}
                                {{--<p class="m0 text-muted">--}}
                                    {{--<em class="icon-users mr fa-lg"></em>15</p>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td class="wd-xs hidden-xs hidden-sm">--}}
                            {{--<div class="ph">--}}
                                {{--<p class="m0 text-muted">--}}
                                    {{--<em class="icon-doc mr fa-lg"></em>480</p>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td class="wd-sm">--}}
                            {{--<div class="ph">--}}
                                {{--<progressbar value="20" type="green" class="m0 progress-xs">20%</progressbar>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--</tbody>--}}
                {{--</table>--}}
            {{--</a>--}}
            {{--<!-- END dashboard main content-->--}}
        {{--</div>--}}
        <!-- END Multiple List group-->
        {{--</div>--}}
    <!-- Page footer-->
    <footer>
        <span>&copy; 2016 - NetManager</span>
    </footer>
@endsection
