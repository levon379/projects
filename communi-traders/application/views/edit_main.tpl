<div id="edit_main">
            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_hht" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel_hht">How to trade</h3>
        </div>
        <div class="modal-body">
            <p>
            <table class="htt_modal_table">
                <tr>
                    <td id="first_colum">
                        <h4>How it works?</h4>
                        <p>Choose the asset to trade</p>
                        <p>&darr;</p>
                        <p>Choose your <b>Strategy</b></p>
                        <p>&darr;</p>
                        <p>Choose an <b>expire</b></p>
                        <p>&darr;</p>
                        <p>Set the <b>Investment</b></p>
                        <p>&darr;</p>
                        <p>
                            Enter your <b>price/s</b>
                            (only if it's boundary or touch option)
                        </p>
                        <p>&darr;</p>
                        <p>Add <b>text</b> or <b>drawing</b> to the analysis</p>
                        <p>&darr;</p>
                        <p>
                            Add <b>title and describe</b>, Why you<br /> think
                            its a great trade?
                        </p>
                        <p>&darr;</p>
                        <p>
                            <b>"Share"</b>
                            or Just Press <b>"Trade!"</b> To see how your trade
                            did after expire.
                        </p>
                    </td>
                    <td id="second_colum">
                        <h4>Your Balance</h4>
                        <p>
                            Your accaunt is privided with<br />
                            an initial amount of <b>$20.000</b>
                        </p>
                        <p>&darr;</p>
                        <p>Maximun investment is <b>$2.000</b></p>
                        <p>&darr;</p>
                        <p>Minimum trade is <b>$10</b></p>
                        <p>&darr;</p>
                        <p>Increments are <b>10$</b></p>
                        <p>&darr;</p>
                        <p><b>Win and share!</b></p>
                        <p><br/><br/><h5>My Performance</h5>
                        <p>
                            In <b>My Performance</b> you can<br/> see
                            your past trade statistic.<br />
                            For ex: what is your or another
                            forum member <b>Best Trading
                                Strategy?</b>
                        </p>
                    </td>
                    <td id="third_colum">
                        <h4>Strategies</h4>
                        <p>
                            <b>Call</b> - price has to close
                            above entry price to be in the
                            money, after the expiry.
                        </p><br />
                        <p>
                            <b>Put</b> - price has to close
                            below entry price to be in the
                            money, after the expiry.
                        </p><br />
                        <p>
                            <b>Touch</b> - Price has to reach a
                            specific value until the expiry
                            is over to be in the money.
                        </p><br />
                        <p>
                            <b>No Touch</b> - Price doesn't has
                            to be reach a specific value
                            until the expiry is over to be
                            in the money.
                        </p><br />
                        <p>
                            <b>Bounderi Out</b> - Price has to
                            go or above 3 or below 1 to
                            be In the money, (current
                            price is in the middle at 2).
                            User Has to be able to place
                            two prices. ( 1,3)
                        </p>
                        <p>
                            <b>Bounderi inside</b> - Price has
                            to stay between two numbers
                            for ex: below 3 and above 1
                            to be In the money. (current
                            price is in the middle at 2).
                            User Has to be able to place
                            two prices. ( 1,3)
                        </p>
                    </td>
                    <td id="fourth_colum">
                        <h4>Sharing And Trading</h4>
                        <p>
                            Each trade you do at
                            CommuniTraders can be
                            shared with the rest of the
                            forum members with the
                            "Share" button. If you prefer
                            not  to share and just trade
                            for fun you can use the
                            "Trade!"  button , which will
                            just save your  trade into
                            your trading <b>Profile</b>. In your
                            user profile you will be able
                            to see your performance
                            report, open and closed
                            trades as well, along with
                            great statistics for yourself
                            and also other Communi Traders.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td id="fifth_colum" colspan="4">
                        <br />
                        We are inviting you to share your stock analysis , Ideas and market outlook at CommuniTraders Forum! Enjoy!
                        BinaryOptionsThatSuck.com Team
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div id="myCalendar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_calendar" aria-hidden="true">       
        <div class="modal-header calendar_header">
            <button type="button" class="close close_white" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel_calendar">Financial calendar</h3>
        </div>
        <div class="modal-body">
            <table class="table">
                <thead class="table_header_leader">
                    <tr>
                        <th>Date (GMT)</th>
                        <th>Event</th>
                        <th>Cons.</th>
                        <th>Actual</th>
                        <th>Previous</th>
                    </tr>
                </thead>
                <tbody id="event_block">

                </tbody>
            </table>
        </div>
    </div>     
    <div id="myLeaderBoard" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_leader" aria-hidden="true">       
        <div class="modal-header calendar_header">
            <button type="button" class="close close_white" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel_leader">CommuniTraders Leaders Board</h3>
        </div>
        <div class="modal-body">
            <table class="table">
                <thead class="table_header_leader">
                    <tr>
                        <th></th>
                        <th>Avatar</th>
                        <th>NickName</th>
                        <th>% Winning Rates</th>
                        <th># Winning Trades</th>
                        <th>Best Strategy</th>
                        <th>Best Asset</th>
                    </tr>
                </thead>
                <tbody id="leader_block">
                </tbody>
            </table>
        </div>
    </div>
        <div id="edit_menu">
            <input type="hidden" id="curr_game" name="curr_game" value="{$game_id}" />
            <input type="hidden" id="asset" name="asset" value="{$asset}" />
            <input type="hidden" id="short_asset" name="short_asset" value="{$short_asset}" />
            <div id="static_header">
                <div id="static_slogan" class="edit_slogan">Drawing</div>
                <div id="tool_menu_static" class="edit_slogan">
                    <div id="navigation">                           
                        <div class="menu_tab">
                            <div class="menu_a menu_tab_border">
                                <div class="a_text">
                                    <a href="{$url}">CommuniTraders</a>
                                </div>
                            </div>
                        </div>
                        <div class="menu_tab menu_tab_border">
                            <div class="menu_a">
                                <div class="a_text">
                                    <a href="{$url}myperformance">My performance</a>
                                </div>
                            </div>
                        </div>
                        <div class="menu_tab menu_tab_border">
                            <div class="menu_a">
                                <div class="a_text">
                                    <a href="#myModal" data-toggle="modal">How To Trade</a>
                                </div>
                            </div>
                        </div>
                        <div class="menu_tab menu_tab_border">
                            <div class="menu_a">
                                <div class="a_text">
                                    <a href="#myCalendar" data-toggle="modal" onclick="getCalendar(); return FALSE">Financial Calendar</a>
                                </div>
                            </div>
                        </div>
                        <div class="menu_tab menu_tab_border">
                            <div class="menu_a">
                                <div class="a_text">
                                    <a href="#myLeaderBoard" data-toggle="modal" onclick="getLeadersBoard(); return FALSE">Leaders Board</a>
                                </div>
                            </div>
                        </div>                      
                    </div>    
                </div>
            </div>
        </div>
    <div id="edit_center_block">
        <div id="edit_chart_box">
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
                                <li class="remove-all"><a href="#" title="Remove all annotations from the chart."></a></li>
                                <li class="help"><a href="#"></a></li>
                            </ul>
                        </div>
                        <div id="chart_box" class="edit_left_toolbar">
                            <div class="left-toolbar edit_left_toolbar">
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
                            <div id="chartContainer" class="edit_chart_container"></div>
                        </div>
            </div>
    </div>
    <div id="edit_footer">
        <input type="hidden" id="prepare_img" name="prepare_img" value="">
        <div id="edit_footer_menu">
            <button class="btn" id="save_edit" onclick="exportImage(); return FALSE">Save</button>
        </div>
    </div>
</div>
