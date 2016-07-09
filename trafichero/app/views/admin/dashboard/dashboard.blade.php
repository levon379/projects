@extends('layout.default')
@section('content')

        <div class="content-sec">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="dashboard.html" title=""><i class="fa fa-home"></i></a>/</li>
                    <li><a title="">Dashboard</a></li>
                </ul>
            </div><!-- breadcrumbs -->
            <div class="container">
                
               
                <div class="row">
                    <div class="masonary-grids">
                       

                       

                       
                        <div class="col-md-6">
                            <div class="widget-area">
                                <h2 class="widget-title"><strong>Server</strong> Loaded</h2>
                                <div class="server-load-sec">
                                    <ul class="panel-function">
                                        <li class="dropdown">
                                            <a  role="button" data-toggle="dropdown" href="#"> <b class="caret"></b></a>
                                            <ul  class="dropdown-menu" role="menu" >
                                                <li role="presentation"><a title="" class="hide-btn"><i class="fa fa-minus"></i></a></li>
                                                <li role="presentation"><a title="" class="close-sec"><i class="fa fa-close"></i></a></li>
                                            </ul>
                                        </li>
                                    </ul><!-- Panel Function -->
                                    <div class="widget">
                                        <div class="server-status">
                                            <div class="full-width">
                                                <div class="server">
                                                    <span class="server1"><i></i> Server 1</span>
                                                    <span class="server2"><i></i> Server 2</span>
                                                    <div data-toggle="buttons" class="btn-group btn-group-sm">
                                                        <label class="btn btn-default active">
                                                            <input type="radio" checked=""  name="options" />Server #1
                                                        </label>
                                                        <label class="btn btn-default">
                                                            <input type="radio"  name="options" />Server #2
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="serverload-chart"></div>
                                            </div>
                                            <h3>System Status</h3>
                                            <div class="status-progress-sec">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="status-progress">
                                                            <span>Data Bases (23/100)</span>
                                                            <div class="progress">
                                                                <div style="width: 90%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="90" role="progressbar" class="progress-bar gray">
                                                                </div>
                                                            </div>
                                                        </div><!-- Server Status progress -->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="status-progress">
                                                            <span>Memory Usage 50%</span>
                                                            <div class="progress">
                                                                <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar gray">
                                                                </div>
                                                            </div>
                                                        </div><!-- Server Status progress -->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="status-progress">
                                                            <span>Domains (2/10)</span>
                                                            <div class="progress">
                                                                <div style="width: 40%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar gray">
                                                                </div>
                                                            </div>
                                                        </div><!-- Server Status progress -->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="status-progress">
                                                            <span>Disk Usage 80%</span>
                                                            <div class="progress">
                                                                <div style="width: 75%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" role="progressbar" class="progress-bar gray">
                                                                </div>
                                                            </div>
                                                        </div><!-- Server Status progress -->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="status-progress">
                                                            <span>Email Accounts (56/100)</span>
                                                            <div class="progress">
                                                                <div style="width: 25%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" role="progressbar" class="progress-bar gray">
                                                                </div>
                                                            </div>
                                                        </div><!-- Server Status progress -->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="status-progress">
                                                            <span>CPU Usage (34.05-23 cpus)</span>
                                                            <div class="progress">
                                                                <div style="width: 95%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="95" role="progressbar" class="progress-bar gray">
                                                                </div>
                                                            </div>
                                                        </div><!-- Server Status progress -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- Widget Area -->
                        </div>

                        <div class="col-md-6">
                            <div class="widget-area pattern">
                                <div class="mini-profile-widget">
                                    <div class="mini-profile-area"> 
                                        <span><img src="{{ URL::asset('images/resource/me.jpg')}}" alt="" /></span>
                                        <h3>{{Auth::User()->first_name}} {{Auth::User()->last_name}}</h3>
                                        <i>Administrator</i>
                                        <ul class="social-btns">
                                            <li><a href="#" title=""><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#" title=""><i class="fa fa-google-plus"></i></a></li>
                                            <li><a href="#" title=""><i class="fa fa-twitter"></i></a></li>
                                        </ul>
                                    </div>
                                    <p>Print this page to PDF for the complete set of vectors. Or to use on the desktop.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="widget-area no-padding">
                                <div class="earning-widget">
                                    <div class="earning-graph blue">
                                        <h3>$340<i>+125.00%</i></h3>
                                        <span>Monday</span>
                                        <div class="full-width"><div id="chart"></div></div>
                                    </div>
                                    <div class="earning-status">
                                        <ul>
                                            <li><span>Market</span><h4>$12,234.000</h4></li>
                                            <li><span>Referrel</span><h4>$50,335.000</h4></li>
                                            <li><span>Total</span><h4>$200.000</h4></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="widget-area blank">
                                <div class="full-width">
                                    <h2 class="widget-title"><strong>Country</strong> Visitors</h2>
                                    <ul class="panel-function">
                                        <li class="dropdown">
                                            <a  role="button" data-toggle="dropdown" href="#"> <b class="caret"></b></a>
                                            <ul  class="dropdown-menu" role="menu" >
                                                <li role="presentation"><a title="" class="hide-btn"><i class="fa fa-minus"></i></a></li>
                                                <li role="presentation"><a title="" class="close-sec"><i class="fa fa-close"></i></a></li>
                                            </ul>
                                        </li>
                                    </ul><!-- Panel Function -->
                                    <div class="widget">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div id="map" style="width: 100%; height: 300px" class="map-vector"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="visit-table">
                                                    <ul>
                                                        <li class="table-head"><h2 class="location">Location</h2><h2 class="visit">Visits</h2></li>
                                                        <li><span class="location"><img src="{{ URL::asset('images/resource/us-flag.jpg')}}" alt="" />United States</span><i class="visit">2298</i></li>
                                                        <li><span class="location"><img src="{{ URL::asset('images/resource/china-flag.jpg')}}" alt="" />China</span><i class="visit">13244</i></li>
                                                        <li><span class="location"><img src="{{ URL::asset('images/resource/turkey-flag.jpg')}}" alt="" />Turkey</span><i class="visit">234</i></li>
                                                        <li><span class="location"><img src="{{ URL::asset('images/resource/australia-flag.jpg')}}" alt="" />Australia</span><i class="visit">2345</i></li>
                                                        <li><span class="location"><img src="{{ URL::asset('images/resource/india-flag.jpg')}}" alt="" />India</span><i class="visit">756</i></li>
                                                        <li><span class="location"><img src="{{ URL::asset('images/resource/brazil-flag.jpg')}}" alt="" />Brazil</span><i class="visit">65570</i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="widget-area no-padding">
                                <div class="my-profile-widget">
                                    <div class="profile-widget-head">
                                        <h3>{{Auth::User()->first_name}} {{Auth::User()->last_name}}</h3>
                                        <i>Administrator</i>
                                        <span><img src="{{ URL::asset('images/resource/me.jpg')}}" alt="" /></span>
                                    </div>
                                  <!--  <h4>@labrina_scholar</h4>-->
                                    <span class="blue"><i class="fa fa-map-marker"></i>San Francisco</span>
                                    <p>Print this page to PDF for te completet of vectors. Or to use othe the Font Aweo Awesome</p>
                                    <a href="#" title="">http://themeforest.net</a>
                                    <ul class="social-btns">
                                        <li><a title="" href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a title="" href="#"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a title="" href="#"><i class="fa fa-twitter"></i></a></li>
                                    </ul>
                                </div><!-- My Profile Widget -->
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="widget-area">
                                <h2 class="widget-title"><strong>User</strong> Timeline</h2>
                                <ul class="panel-function">
                                    <li class="dropdown">
                                        <a  role="button" data-toggle="dropdown" href="#"> <b class="caret"></b></a>
                                        <ul  class="dropdown-menu" role="menu" >
                                            <li role="presentation"><a title="" class="hide-btn"><i class="fa fa-minus"></i></a></li>
                                            <li role="presentation"><a title="" class="close-sec"><i class="fa fa-close"></i></a></li>
                                        </ul>
                                    </li>
                                </ul><!-- Panel Function -->
                                <div class="widget">
                                    <div class="timeline-sec"  id="timeline-scroll">
                                        <ul>
                                            <li>
                                                <div class="timeline">
                                                    <div class="user-timeline">
                                                        <span><img src="{{ URL::asset('images/resource/sender2.jpg')}}" alt="" /></span>
                                                    </div>
                                                    <div class="timeline-detail">
                                                        <div class="timeline-head">
                                                            <h3>Jonathan Gardel<span>2 min ago</span><i class="red">Admin</i></h3>
                                                            <div class="social-share">
                                                                <a title=""><i class="fa fa-share-alt"></i></a>
                                                                <ul class="social-btns">
                                                                    <li><a title="Facebook" data-toggle="tooltip" data-placement="left" href="#"><i class="fa fa-facebook"></i></a></li>
                                                                    <li><a title="Google" data-toggle="tooltip" data-placement="left" href="#"><i class="fa fa-google-plus"></i></a></li>
                                                                    <li><a title="Twitter" data-toggle="tooltip"  data-placement="left" href="#"><i class="fa fa-twitter"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="timeline-content">
                                                            <p>Set it as the font <a href="#" title="">John Doe</a> in your applition, and copy and paste the icons. Print this page.</p>
                                                            <div class="progress w-tooltip">
                                                                <div style="width: 70%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" role="progressbar" class="red progress-bar">
                                                                    <span><i>uploading</i>70%</span>
                                                                </div>
                                                            </div>
                                                            <div data-toggle="buttons" class="btn-group btn-group-sm">
                                                                <label class="btn btn-default">
                                                                    <input type="radio" checked=""  name="options" /><i class="fa fa-comment-o"></i> Reply
                                                                </label>
                                                                <label class="btn btn-default">
                                                                    <input type="radio"  name="options" /> <i class="fa fa-thumbs-o-up"></i> Like
                                                                </label>
                                                            </div>
                                                            <form class="post-reply">
                                                                <textarea placeholder="Write your comment"></textarea>
                                                                <i class="fa fa-comments-o"></i>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="timeline">
                                                    <div class="user-timeline">
                                                        <span><img src="{{ URL::asset('images/resource/sender3.jpg')}}" alt="" /></span>
                                                    </div>
                                                    <div class="timeline-detail">
                                                        <div class="timeline-head">
                                                            <h3>Yameen khandil<span>2 hours ago</span><i class="blue">Mod</i></h3>
                                                            <div class="social-share">
                                                                <a title=""><i class="fa fa-share-alt"></i></a>
                                                                <ul class="social-btns">
                                                                    <li><a title="Facebook" data-toggle="tooltip" data-placement="left" href="#"><i class="fa fa-facebook"></i></a></li>
                                                                    <li><a title="Google" data-toggle="tooltip" data-placement="left" href="#"><i class="fa fa-google-plus"></i></a></li>
                                                                    <li><a title="Twitter" data-toggle="tooltip"  data-placement="left" href="#"><i class="fa fa-twitter"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="timeline-content">
                                                            <p>at <a href="#" title="">Khana Zidi</a> Jonathan DOe Uploaded 4 new photos.</p>
                                                            <div class="timeline-gallery">
                                                                <ul>
                                                                    <li><a title="Gallery Image" class="html5lightbox" href="{{ URL::asset('images/resource/view.gif')}}"><i class="fa fa-search"></i><img src="{{ URL::asset('images/resource/gallery1.jpg')}}" alt="" /></a></li>
                                                                    <li><a title="Gallery Image" class="html5lightbox" href="{{ URL::asset('images/resource/view.gif')}}"><i class="fa fa-search"></i><img src="{{ URL::asset('images/resource/gallery2.jpg')}}" alt="" /></a></li>
                                                                    <li><a title="Gallery Image" class="html5lightbox" href="{{ URL::asset('images/resource/view.gif')}}"><i class="fa fa-search"></i><img src="{{ URL::asset('images/resource/gallery3.jpg')}}" alt="" /></a></li>
                                                                    <li><a title="Gallery Image" class="html5lightbox" href="{{ URL::asset('images/resource/view.gif')}}"><i class="fa fa-search"></i><img src="{{ URL::asset('images/resource/gallery4.jpg')}}" alt="" /></a></li>
                                                                </ul>
                                                            </div>
                                                            <div data-toggle="buttons" class="btn-group btn-group-sm">
                                                                <label class="btn btn-default">
                                                                    <input type="radio" checked=""  name="options" /><i class="fa fa-comment-o"></i> Reply
                                                                </label>
                                                                <label class="btn btn-default">
                                                                    <input type="radio"  name="options" /> <i class="fa fa-thumbs-o-up"></i> Like
                                                                </label>
                                                            </div>
                                                            <form class="post-reply">
                                                                <textarea placeholder="Write your comment"></textarea>
                                                                <i class="fa fa-comments-o"></i>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="timeline">
                                                    <div class="user-timeline">
                                                        <span><img src="{{ URL::asset('images/resource/sender1.jpg')}}" alt="" /></span>
                                                    </div>
                                                    <div class="timeline-detail">
                                                        <div class="timeline-head">
                                                            <h3>Brindal Dazi<span>4 min ago</span><i class="green">User</i></h3>
                                                            <div class="social-share">
                                                                <a title=""><i class="fa fa-share-alt"></i></a>
                                                                <ul class="social-btns">
                                                                    <li><a title="Facebook" data-toggle="tooltip" data-placement="left" href="#"><i class="fa fa-facebook"></i></a></li>
                                                                    <li><a title="Google" data-toggle="tooltip" data-placement="left" href="#"><i class="fa fa-google-plus"></i></a></li>
                                                                    <li><a title="Twitter" data-toggle="tooltip"  data-placement="left" href="#"><i class="fa fa-twitter"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="timeline-content">
                                                            <p>Set it as the font <a href="#" title="">John Doe</a> in your applition, and copy and paste the icons. Print this page to PDF for te completet of vectors. Or to use othe the Font Aweo Awesome</p>
                                                            <div data-toggle="buttons" class="btn-group btn-group-sm">
                                                                <label class="btn btn-default">
                                                                    <input type="radio" checked=""  name="options" /><i class="fa fa-comment-o"></i> Reply
                                                                </label>
                                                                <label class="btn btn-default">
                                                                    <input type="radio"  name="options" /> <i class="fa fa-thumbs-o-up"></i> Like
                                                                </label>
                                                            </div>
                                                            <form class="post-reply">
                                                                <textarea placeholder="Write your comment"></textarea>
                                                                <i class="fa fa-comments-o"></i>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- Content Sec -->
        <div class="slide-panel" id="panel-scroll">
            <ul role="tablist" class="nav nav-tabs panel-tab-btn">
                <li class="active"><a data-toggle="tab" role="tab" href="#tab1"><i class="fa fa-inbox"></i><span>Your Emails</span></a></li>
                <li><a data-toggle="tab" role="tab" href="#tab2"><i class="fa fa-wrench"></i><span>Your Setting</span></a></li>
            </ul>
            <div class="tab-content panel-tab">
                <div id="tab1" class="tab-pane fade in active">
                    <div class="recent-mails-widget">
                        <form><div id="searchMail"></div></form>
                        <h3>Recent Emails</h3>
                        <ul id="mail-list" class="mail-list">
                            <li>
                                <div class="title">
                                    <span><img src="{{ URL::asset('images/resource/sender1.jpg')}}" alt="" /><i class="online"></i></span>
                                    <h3><a href="#" title="">Kim Hostwood</a><span>5 min ago</span></h3>
                                    <a href="#"  data-toggle="tooltip" data-placement="left" title="Attachment"><i class="fa fa-paperclip"></i></a>
                                </div>
                                <h4>Themeforest Admin Template</h4>
                                <p>This product is so good that i manage to buy it 1 for me and 3 for my families.</p>
                            </li>
                            <li>
                                <div class="title">
                                    <span><img src="{{ URL::asset('images/resource/sender2.jpg')}}" alt="" /><i class="online"></i></span>
                                    <h3><a href="#" title="">John Doe</a><span>2 hours ago</span></h3>
                                    <a href="#"  data-toggle="tooltip" data-placement="left" title="Attachment"><i class="fa fa-paperclip"></i></a>
                                </div>
                                <h4>Themeforest Admin Template</h4>
                                <p>This product is so good that i manage to buy it 1 for me and 3 for my families.</p>
                            </li>
                            <li>
                                <div class="title">
                                    <span><img src="{{ URL::asset('images/resource/sender3.jpg')}}" alt="" /><i class="offline"></i></span>
                                    <h3><a href="#" title="">Jonathan Doe</a><span>8 min ago</span></h3>
                                    <a href="#"  data-toggle="tooltip" data-placement="left" title="Attachment"><i class="fa fa-paperclip"></i></a>
                                </div>
                                <h4>Themeforest Admin Template</h4>
                                <p>This product is so good that i manage to buy it 1 for me and 3 for my families.</p>
                            </li>
                        </ul>
                        <a href="inbox.html" title="" class="red">View All Messages</a>
                    </div><!-- Recent Email Widget -->

                    <div class="file-transfer-widget">
                        <h3>FILE TRANSFER <i class="fa fa-angle-down"></i></h3>
                        <div class="toggle">
                            <ul>
                                <li>
                                    <i class="fa fa-file-excel-o"></i><h4>my-excel.xls<i>20 min ago</i></h4>
                                    <div class="progress">
                                        <div style="width: 90%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="90" role="progressbar" class="progress-bar red">
                                            90%
                                        </div>
                                    </div>
                                    <div class="file-action-btn">
                                        <a href="#" title="Approve" class="green" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-check"></i></a>
                                        <a href="#" title="Cancel" class="red" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-close"></i></a>
                                    </div>
                                </li>
                                <li>
                                    <i class="fa fa-file-pdf-o"></i><h4>my-cv.pdf<i>8 min ago</i></h4>
                                    <div class="progress">
                                        <div style="width: 40%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar blue">
                                            40%
                                        </div>
                                    </div>
                                    <div class="file-action-btn">
                                        <a href="#" title="Approve" class="green" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-check"></i></a>
                                        <a href="#" title="Cancel" class="red" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-close"></i></a>
                                    </div>
                                </li>
                                <li>
                                    <i class="fa fa-file-video-o"></i><h4>portfolio-shoot.mp4<i>12 min ago</i></h4>
                                    <div class="progress">
                                        <div style="width: 70%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" role="progressbar" class="progress-bar green">
                                            70%
                                        </div>
                                    </div>
                                    <div class="file-action-btn">
                                        <a href="#" title="Approve" class="green" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-check"></i></a>
                                        <a href="#" title="Cancel" class="red" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-close"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div><!-- File Transfer -->
                </div>
                <div id="tab2" class="tab-pane fade">
                    <div class="setting-widget">
                        <form>
                            <h3>Accounts</h3>
                            <div class="toggle-setting">
                                <span>Office Account</span>
                                <label class="toggle-switch">
                                    <input type="checkbox">
                                    <span data-unchecked="Off" data-checked="On"></span>
                                </label>
                            </div>
                            <div class="toggle-setting">
                                <span>Personal Account</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked>
                                    <span data-unchecked="Off" data-checked="On"></span>
                                </label>
                            </div>
                            <div class="toggle-setting">
                                <span>Business Account</span>
                                <label class="toggle-switch">
                                    <input type="checkbox">
                                    <span data-unchecked="Off" data-checked="On"></span>
                                </label>
                            </div>
                        </form>

                        <form>
                            <h3>General Setting</h3>
                            <div class="toggle-setting">
                                <span>Notifications</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked>
                                    <span data-unchecked="Off" data-checked="On"></span>
                                </label>
                            </div>
                            <div class="toggle-setting">
                                <span>Notification Sound</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked>
                                    <span data-unchecked="Off" data-checked="On"></span>
                                </label>
                            </div>
                            <div class="toggle-setting">
                                <span>My Profile</span>
                                <label class="toggle-switch">
                                    <input type="checkbox">
                                    <span data-unchecked="Off" data-checked="On"></span>
                                </label>
                            </div>
                            <div class="toggle-setting">
                                <span>Show Online</span>
                                <label class="toggle-switch">
                                    <input type="checkbox">
                                    <span data-unchecked="Off" data-checked="On"></span>
                                </label>
                            </div>
                            <div class="toggle-setting">
                                <span>Public Profile</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked>
                                    <span data-unchecked="Off" data-checked="On"></span>
                                </label>
                            </div>
                        </form>
                    </div><!-- Setting Widget -->
                </div>
            </div>
        </div><!-- Slide Panel -->
    </div><!-- Page Container -->
@stop

@section('scripts')
<script type="text/javascript">
    function random_num( field, interval, range ){

        setInterval(function()
        {
            var chars = "0123456789";
            var string_length = range;
            var randomstring = '';
            for (var i=0; i<string_length; i++) {
                var rnum = Math.floor(Math.random() * chars.length);
                randomstring += chars.substring(rnum,rnum+1);
            }
            var a = jQuery("#"+field).html(randomstring);
            console.log(a);
        }, interval);
    };
</script>
<script>
    jQuery(document).ready(function(){
        random_num( 'random', 3000, 3 );
    });
</script>
<script>
    // set up our data series with 50 random data points

    var seriesData = [ [], [], [] ];
    var random = new Rickshaw.Fixtures.RandomData(150);

    for (var i = 0; i < 100; i++) {
        random.addData(seriesData);
    }

    // instantiate our graph!

    var graph = new Rickshaw.Graph( {
        element: document.getElementById("chart"),
        renderer: 'scatterplot',
        series: [
            {
                color: "#ffffff",
                data: seriesData[0],
            }, {
                color: "#eeeeee",
                data: seriesData[1],
            }
        ]
    } );

    graph.renderer.dotSize = 3;

    new Rickshaw.Graph.HoverDetail({ graph: graph });

    graph.render();

</script>
<script type="text/javascript">
    $(document).ready(function() {
        var graph;

        var seriesData = [ [], []];
        var random = new Rickshaw.Fixtures.RandomData(50);

        for (var i = 0; i < 50; i++) {
            random.addData(seriesData);
        }

        graph = new Rickshaw.Graph( {
            element: document.querySelector("#serverload-chart"),
            height: 198,
            renderer: 'area',
            series: [
                {
                    data: seriesData[0],
                    color: '#b3b3b3',
                    name:'File Server'
                },{
                    data: seriesData[1],
                    color: '#505050',
                    name:'Mail Server'
                }
            ]
        } );

        var hoverDetail = new Rickshaw.Graph.HoverDetail( {
            graph: graph,
        });

        setInterval( function() {
            random.removeData(seriesData);
            random.addData(seriesData);
            graph.update();

        },1000);


        $('#reportrange').daterangepicker(
                {
                    startDate: moment().subtract('days', 29),
                    endDate: moment(),
                    minDate: '01/01/2012',
                    maxDate: '12/31/2014',
                    dateLimit: { days: 60 },
                    showDropdowns: true,
                    showWeekNumbers: true,
                    timePicker: false,
                    timePickerIncrement: 1,
                    timePicker12Hour: true,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                        'Last 7 Days': [moment().subtract('days', 6), moment()],
                        'Last 30 Days': [moment().subtract('days', 29), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                    },
                    opens: 'left',
                    buttonClasses: ['btn btn-default'],
                    applyClass: 'btn-small btn-primary',
                    cancelClass: 'btn-small',
                    format: 'MM/DD/YYYY',
                    separator: ' to ',
                    locale: {
                        applyLabel: 'Submit',
                        fromLabel: 'From',
                        toLabel: 'To',
                        customRangeLabel: 'Custom Range',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        firstDay: 1
                    }
                },
                function(start, end) {
                    console.log("Callback has been called!");
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
        );
        //Set the initial state of the picker label
        $('#reportrange span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

        $(function(){
            $('#map').vectorMap({map: 'world_en'});
        })


        $("#pie").sparkline([1,1,2], {
            type: 'pie',
            width: '40',
            height: '40',
            sliceColors: ['#2dcb73','#fd6a59','#17c3e5','#109618','#66aa00','#dd4477','#0099c6','#990099 ']});

        $("#pie2").sparkline([2,2,2], {
            type: 'pie',
            width: '40',
            height: '40',
            sliceColors: ['#2dcb73','#fd6a59','#17c3e5','#109618','#66aa00','#dd4477','#0099c6','#990099 ']});

        $("#pie3").sparkline([1,1,2,3,2], {
            type: 'pie',
            width: '40',
            height: '40',
            sliceColors: ['#2dcb73','#fd6a59','#17c3e5','#109618','#66aa00','#dd4477','#0099c6','#990099 ']});

    });
</script>
@stop