<div class="preloader"><div class="img"><img src='/CommuniTraders/assets/css/img/ajax-loader.gif' alt='loading...' /><br/><img src='/CommuniTraders/assets/css/img/ajax-loader-text.gif' alt='loading...' /></div></div>
<div id="preshare" class="modal fade in">
<!-- Modal Leader Board-->
<div class="pst_main" id="pst_modal" tabindex="-1" role="dialog" aria-labelledby="pst_modal" aria-hidden="true">
  <div class="pst_text_border">
    <div class="pst_text_wrap">
        <div class="pst_text_content">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="pst_modal_x()">&times;</button>
           <p>Pssst... CommuniTrader!</p><br/>
           <h2>The whole idea behind CommuniTraders is sharing!</h2><br/>
           <p>Share your Trading ideas, knowledge, insights & toughts with the community.</p><br/>
           <p>Help yourself and the other members become better binary options traders.</p><br/>
           <p style="font-size: 16px;">Cheers,<br/>CommuniTraders Team</p>
        </div>
        <div class="pst_text_bottom" style="display: inline-block;width: 101%;">
            <input type="checkbox" id="pst_message"><label for="pst_message">Do not show this message again</label>
            <div class ="post_page_share_btn" style="display: inline-block;"><a href="#"><div class="post_share">Share</div></a><a href="#" onclick="pst_modal_no()"><div class="post_nothanks">No Thanks</div></a> </div>
        </div>
    </div>
  </div>
</div> <!-- End Modal PST -->
    <div class="container-fluid" style="width: 60%">
        <div class="row">
            <!-- <div class="pull-left steps">
                <div class="row">
                    <div class ="step1"><div class="steps_heading">1</div></div>
                </div>
                <div class="row">
                    <div class ="step2"><div class="steps_heading">2</div></div>
                </div>
                <div class="row">
                    <div class ="step3"><div class="steps_heading">3</div></div>
                </div>
            </div> -->
            <div class="col-md-12 post_page_wrap">
                <div class="row">

                    <div class="col-md-12 post_page_header">
                       <div class="row">
                            <div class="col-md-1">
                                <div class="blue_left step1" style="height: 52px"></div>
                            </div>
                            <div class="col-md-11">  <h4>Trade sent successfully!</h4>
                                <h2>Share your Trade</h2>
                                <div class="box_right_time">{$smarty.now|date_format:'%H:%M:%S %d-%a-%m-%Y'}</div>
                            </div>
                       </div>
                    </div>
                </div>
                <div class="row">
                        <div class ="col-md-12 post_page_title">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="blue_left step1"><div class="steps_heading">1</div></div>
                                </div>
                                <div class="col-md-11">
                                    <div id="box_title" class="col-md-5 form-horizontal">
                                        <label class="control-label" for="title">Title:</label>
                                        <input type="text" class="text_field form-control" value="{$inputRows.comment_header|default:''}" id="title" name="title" placeholder="Enter a Title for your Analysis Here"/>
                                    </div>
                                    <div class="col-md-7">
                                            <div class="title_pl">P&L<br><span>$85</span></div> <div class="title_investment">Investments<br><span>$100</span></div><div class="title_time">{$smarty.now|date_format:'%d-%a-%m-%Y'}<br><span>{$smarty.now|date_format:'%H:%M:%S'}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-8 pull-left post_page_wrap_left">
                           <div class="row">
                                    <div class="col-md-1">
                                         <div class="blue_left step2"><div class="steps_heading">2</div></div>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="helper">
                                            <ul>
                                                <li class="help"><a href="#"><span class="glyphicon glyphicon-question-sign"></span>Help</a></li>
                                                <li class="remove-all"><a href="#" title="Remove all annotations from the chart."><span class="glyphicon glyphicon-remove"></span>Remove all</a></li>

                                            </ul>
                                        </div>
                                            <div class ="post_page_chart"><div id="chartContainer1"></div>
                                                <div id="tool_box">

                                                <div id="chart_box">
                                                    <div class="left-toolbar">
                                                        <ul id="colorpicker">
                                                            <li><a href="#"><span class="color-000000"></span></a></li>
                                                            <li><a href="#"><span class="color-993300"></span></a></li>
                                                            <li><a href="#"><span class="color-800000"></span></a></li>
                                                            <li><a href="#"><span class="color-FF6600"></span></a></li>
                                                            <li><a href="#"><span class="color-FF0000"></span></a></li>
                                                            <li><a href="#"><span class="color-FF9900"></span></a></li>
                                                            <li><a href="#"><span class="color-FF00FF"></span></a></li>
                                                            <li><a href="#"><span class="color-DB2A0E"></span></a></li>
                                                            <li><a href="#"><span class="color-FFCC00"></span></a></li>
                                                            <li><a href="#"><span class="color-FFCC99"></span></a></li>
                                                            <li><a href="#"><span class="color-333300"></span></a></li>
                                                            <li><a href="#"><span class="color-003300"></span></a></li>
                                                            <li><a href="#"><span class="color-808000"></span></a></li>
                                                            <li><a href="#"><span class="color-008000"></span></a></li>
                                                            <li><a href="#"><span class="color-99CC00"></span></a></li>
                                                            <li><a href="#"><span class="color-339966"></span></a></li>
                                                            <li><a href="#"><span class="color-FFFF00"></span></a></li>
                                                            <li><a href="#"><span class="color-00FF00"></span></a></li>
                                                            <li><a href="#"><span class="color-FFFF99"></span></a></li>
                                                            <li><a href="#"><span class="color-CCFFCC"></span></a></li>
                                                            <li><a href="#"><span class="color-003366"></span></a></li>
                                                            <li><a href="#"><span class="color-000080"></span></a></li>
                                                            <li><a href="#"><span class="color-008080"></span></a></li>
                                                            <li><a href="#"><span class="color-0000FF"></span></a></li>
                                                            <li><a href="#"><span class="color-33CCCC"></span></a></li>
                                                            <li><a href="#"><span class="color-3366FF"></span></a></li>
                                                            <li><a href="#"><span class="color-00FFFF"></span></a></li>
                                                            <li><a href="#"><span class="color-00CCFF"></span></a></li>
                                                            <li><a href="#"><span class="color-CCFFFF"></span></a></li>
                                                            <li><a href="#"><span class="color-99CCFF"></span></a></li>
                                                            <li><a href="#"><span class="color-333399"></span></a></li>
                                                            <li><a href="#"><span class="color-333333"></span></a></li>
                                                            <li><a href="#"><span class="color-666699"></span></a></li>
                                                            <li><a href="#"><span class="color-808080"></span></a></li>
                                                            <li><a href="#"><span class="color-800080"></span></a></li>
                                                            <li><a href="#"><span class="color-969696"></span></a></li>
                                                            <li><a href="#"><span class="color-993366"></span></a></li>
                                                            <li><a href="#"><span class="color-C0C0C0"></span></a></li>
                                                            <li><a href="#"><span class="color-CC99FF"></span></a></li>
                                                            <li><a href="#"><span class="color-FFFFFF"></span></a></li>
                                                        </ul>


                                                    </div>

                                                </div>
                                                    <div class="upper-toolbar">
                                                        <ul id="main-toolset">
                                                            <li class="tool"><a href="#" title="Select Tool" class="SelectionTool"></a></li>
                                                            <li class="spacer"><span></span></li>
                                                            <li class="tool"><a href="#" title="Line" class="Line"></a></li>
                                                            <li class="tool"><a href="#" title="Horizontal Line" class="HorizontalLine"></a></li>
                                                            <li class="tool"><a href="#" title="Vertical Line" class="VerticalLine"></a></li>
                                                            <li class="tool"><a href="#" title="Infinite Line" class="InfiniteLine"></a></li>
                                                            <li class="tool"><a href="#" title="Ray" class="Ray"></a></li>
                                                            <li class="spacer"><span></span></li>
                                                            <li class="tool"><a href="#" title="Trend Channel" class="TrendChannel"></a></li>
                                                            <li class="tool"><a href="#" title="Fibonacci Retracement" class="FibonacciRetracement"></a></li>
                                                            <li class="spacer"><span></span></li>
                                                            <li class="tool"><a href="#" title="Up Arrow" class="UpArrow"></a></li>
                                                            <li class="tool"><a href="#" title="Down Arrow" class="DownArrow"></a></li>
                                                            <li class="tool"><a href="#" title="Left Arrow" class="LeftArrow"></a></li>
                                                            <li class="tool"><a href="#" title="Right Arrow" class="RightArrow"></a></li>
                                                            <li class="spacer"><span></span></li>
                                                            <li class="tool"><a href="#" title="Label" class="Label"></a></li>

                                                        <!--    <li class="remove-all"><a href="#" title="Remove all annotations from the chart."></a></li>
                                                            <li class="help"><a href="#"></a></li> -->
                                                        </ul>

                                                    </div>
                                                    <ul id="text-tools" class="additional-toolset">
                                                        <li class="spacer"></li>
                                                        <li><a href="#" title="Increase text size" class="increase-text-size"></a></li>
                                                        <li><a href="#" title="Decrease text size" class="decrease-text-size"></a></li>
                                                        <li><a href="#" title="Bold text" class="bold-text"></a></li>
                                                        <li><a href="#" title="Italic text" class="italic-text"></a></li>
                                                    </ul>
                                                    <ul id="line-tools" class="additional-toolset">
                                                        <li class="spacer"></li>
                                                        <li><a href="#" title="Brush size 1px" class="brush-1px"></a></li>
                                                        <li><a href="#" title="Brush size 2px" class="brush-2px"></a></li>
                                                        <li><a href="#" title="Brush size 3px" class="brush-3px"></a></li>
                                                        <li><a href="#" title="Brush size 4px" class="brush-4px"></a></li>
                                                        <li><a href="#" title="Dashed line" class="dashed-line"></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                               <div class="row">

                                    <div class ="col-md-12 post_page_description">
                                         <div class="row">
                                                <div class="col-md-1">
                                                    <div class="blue_left step3"><div class="steps_heading">3</div></div>
                                                </div>
                                                <div class="col-md-11">
                                                    <h4>Description:</h4>
                                                    <div class="announcer"></div>
                                                    <div id="message_box">
                                                        <textarea id="comment_field" name="comment_field"></textarea>
                                                        <div id="placeholder">Explain your analysis, Why you chose this strategy? Why you chose this expiry?
                                                            What is your money management strategy for this trade?</div>
                                                    </div>
                                                </div>
                                         </div>
                                    </div>
                               </div>

                           </div>

                        <div class="col-md-4  pull-left post_page_wrap_right">
                            <div class="row">
                                <div class ="post_page_table">
                                    <ul>
                                        <li>
                                            <h4>Assets</h4>
                                            <div id="post_page_asset">S&P 500</div>
                                        </li>
                                        <li>
                                            <h4>Expire</h4>
                                            <div id="post_page_expire">1 Week</div>
                                        </li>
                                        <li>
                                            <h4>Strategy</h4>
                                            <div id="post_page_strategy">Call</div>
                                        </li>
                                        <li>
                                            <h4>Entry Price</h4>
                                            <div id="post_page_entry_price">1 688.2200</div>
                                        </li>
                                        <li>
                                            <h4>Cur/Exp Price</h4>
                                            <div id="post_page_ce_price">1 688.9800</div>
                                        </li>
                                        <li>
                                            <h4>Trade’s LIVE status</h4>
                                            <div id="post_page_status">In</div>
                                        </li>
                                    </ul>
                                    <div id="trade_battons_box">
                                        <h4>Disclosure</h4>

                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="1">
                                            <label class="radio">I Don't have an open trade on my account.
                                        </label>

                                            <input type="radio" name="optionsRadios" id="optionsRadios2" checked="checked" value="2">
                                            <label class="radio">I Do have an open trade on my account.
                                        </label>
                                    </div>
                            </div>

                                    <div class ="post_page_share_btn"><a href="#"><div class="post_share">Share</div></a><a href="#" onclick="pst_modal()"><div class="post_nothanks">No Thanks</div></a> </div>

                            </div>
                         </div>
                    </div>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>
    </div><!-- END Main Preshare windows -->

<div class="container-fluid">
    <div class="row">

        <div class="navbar" role="navigation">


            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand brand" href="#"><img class="img_logo" src="{$url}assets/images/metro/logo.png" alt=""/> </a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right header-menu">
                <!--    <li class="forumlink"><a href="http://t.binaryoptionsthatsuck.com">Forum</a></li>
                    <li class="leaderlink"><a href="#myLeaderBoard" data-toggle="modal" onclick="getLeadersBoard(); return FALSE">Leader Board</a></li>
                    <li class="settingslink"><a href="#">Settings</a></li>  -->
                    <li class="forumlink"><a href="http://t.binaryoptionsthatsuck.com">Forum</a></li>
                    <li class="leaderlink"><a href="#myModal" data-toggle="modal">Help</a></li>
                    <li class="helplink"><a href="#myLeaderBoard" data-toggle="modal" onclick="getLeadersBoard(); return FALSE">Leader Board</a></li>
                    <li class="communilink"><a href="#"><div class="menuicon"></div><div style="font-size: 14px;">Communi</div><div style="width: 150px;">Open Trades</div><span>Communi Open Trades</span></a></li>
                    <li class="userlink"><a href="#"><div class="menuicon"></div><div style="font-size: 14px;">Welcome,</div> <div>&nbsp;{$username}</div><span>Welcome, &nbsp;{$username}</span></a>
                        <div class="notifications_number">12</div>
                        <div class="notifications">
                           <div class="container-fluid">
                            <div class="row">

                                <div class="notifications_arrow"></div>
                                <h3>CommuniTraders Notifications</h3>
                            </div>
                            <div class="row">
                                <ul>
                                    <li><div class="avatar_small"><img src="http://t.binaryoptionsthatsuck.com/CommuniTraders/assets/images/metro/unknown_small.png"></div>Your EURUSD trade has expired IN the money! You made $45<br/><span>15 min ago</span></li>
                                    <li><div class="avatar_small"><img src="http://t.binaryoptionsthatsuck.com/CommuniTraders/assets/images/metro/unknown_small.png"></div>Martin K followed you<br/><span>15 min ago</span></li>
                                    <li><div class="avatar_small"><img src="http://t.binaryoptionsthatsuck.com/CommuniTraders/assets/images/metro/unknown_small.png"></div>Martin K commented your post<br/><span>20 min ago</span></li>
                                </ul>
                            </div>
                            <div class="row">
                            <div class="notifications_more">
                                <a href="#">See More Notifications</a>
                            </div>
                            </div>
                           </div>
                        </div><!-- Notifications -->
                    </li>
                    <li class="accountlink"><a href="#"><div class="menuicon"></div><div style="font-size: 14px;">Open Real Money</div><div>Account</div><span>Open Real Money Account</span></a></li>
                    <!--
                    <li><a class="pull-left forumlink" data-toggle="tooltip" href="http://t.binaryoptionsthatsuck.com">Forum</a></li>
                    <li><a class="pull-left leaderlink" href="#myLeaderBoard" data-toggle="modal" onclick="getLeadersBoard(); return FALSE">Leader Board</a></li>
                    <li><a class="pull-left settingslink">Settings</a></li>
                    <li><a class="pull-left helplink">Help</a></li>
                    <li style="width: 170px"><a class="pull-left communilink"><div class="menuicon"></div><div style="font-size: 14px;width: 112px;">Communi</div><div style="width: 150px;">Open Trades</div></a></li>
                    <li style="width: 170px"><a class="pull-left userlink"><div class="menuicon"></div><div style="font-size: 14px">Welcome,</div> <div>&nbsp;{$username}</div></a></li>
                    <li style="width: 170px"><a class="pull-left accountlink"><div class="menuicon"></div><div style="font-size: 14px;width: 154px;">Open Real Money</div><div>Account</div></a></li>

          -->
                </ul>

            </div>
        </div>

    </div>
</div>

