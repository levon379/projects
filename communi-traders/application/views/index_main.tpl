<div class="container-fluid" style="min-width: 1600px">
<div class="row">
<div id="main_container">

<!-- Modal -->
<div class="modal fade" id="account_demo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="welcome_logo"></div>
      </div>
      <div class="modal-body">
          <p>Welcome into</p><h2>CommuniTraders 2.0</h2><br/>
          <p>You're Rich! We've added <span class="add_money"> $20,000</span><span style="font-size: 24px !important;" class="add_money">.00</span></p>
          <p style="padding-top: 5px;">to your <span class="demo_account">Demo Account</span></p><br/>
          <br/><br/>
          <p class="greet">Happy Trading ,<br/> CommuniTraders Team<span></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default close_welcome" onclick="" data-dismiss="modal">Start Trading</button>
      </div>
    </div>
  </div>
</div>
{if (empty($login_log[0]['last_login']))}
	{literal}
		<script>
			$('#account_demo').modal('show');
		</script>
	{/literal}
{/if}
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header help_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalLabel">How To Trade</h3>
            </div>
            <div class="modal-body">
                <table class="htt_modal_table">
                    <tr>
                        <td id="first_colum">
                            <h4>How it works?</h4>
                            <p>Choose the <b>Asset</b> to trade</p>
                            <p><span class="glyphicon glyphicon-arrow-down"></span></p>
                            <p>Choose your <b>Strategy</b></p>
                            <p><span class="glyphicon glyphicon-arrow-down"></span></p>
                            <p>Choose an <b>expire</b></p>
                            <p><span class="glyphicon glyphicon-arrow-down"></span></p>
                            <p>Set the <b>Investment</b></p>
                            <p><span class="glyphicon glyphicon-arrow-down"></span></p>
                            <p>
                                Enter your <b>price/s</b>
                                (only if it's boundary or touch option)
                            </p>
                            <p><span class="glyphicon glyphicon-arrow-down"></span></p>
                            <p>Add <b>text</b> or <b>drawing</b> to the analysis</p>
                            <p><span class="glyphicon glyphicon-arrow-down"></span></p>
                            <p>
                                Add <b>title</b> and <b>description</b>, Why you<br /> think
                                its a great trade?
                            </p>
                            <p><span class="glyphicon glyphicon-arrow-down"></span></p>
                            <p>
                                <b>"Trade & Share"</b> or just<br />
                                press <b>"Trade!"</b> to see how<br />
                                your trade did after expiry.
                            </p>
                        </td>
                        <td id="second_colum">
                            <h4>Your Balance</h4>
                            <p>
                                Your accaunt is privided with<br />
                                an initial amount of <b>$20.000</b>
                            </p>
                            <p><span class="glyphicon glyphicon-arrow-down"></span></p>
                            <p>Maximun investment is <b>$2.000</b></p>
                            <p><span class="glyphicon glyphicon-arrow-down"></span></p>
                            <p>Minimum trade is <b>$10</b></p>
                            <p><span class="glyphicon glyphicon-arrow-down"></span></p>
                            <p>Increments are <b>10$</b></p>
                            <p><span class="glyphicon glyphicon-arrow-down"></span></p>
                            <p><b>Win and share!</b></p>
                            <p><br/><br/><h5>My Performance</h5>
                            <p>
                                In <b>My Performance</b> you can<br/> see
                                your past trade statistics and others as well.<br />
                                For ex.: what is your or another
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
                            </p><br />
                            <p>
                                <b>Bounderi inside</b> - price has to stay
                                between two numbers.
                                For ex.: below 3 and above 1 to be in the money
                                (current price is in the middle of 2).
                                The user has to be able to place two prices (1, 3).
                            </p>
                        </td>
                        <td id="fourth_colum">
                            <h4>Sharing And Trading</h4>
                            <p>
                                Each trade you do at
                                CommuniTraders can be shared
                                with the rest of the forum
                                members with the <b>"Trade & Share"</b> button.
                                If you prefer not to share and just trade for practice,
                                you can use the <b>"Trade!"</b> button,
                                which will just save your trade into <a href="/CommuniTraders/myperformance/{$username}">My Performance.</a>
                                In your user profile you will be able to see your performance report,
                                open and closed trades as well,
                                along with great statistics for yourself and also other CommuniTraders.
                            </p>
                        </td>
                    </tr>
                 </table>
            </div>
            <div class="modal-footer">
                <b>We invite you to share your asset analysis, Ideas and market outlook at CommuniTraders Forum! <br />
                    Take Advantage of the Crowd's Wisdom!<br />
                    BinaryOptionsThatSuck.com Team<br />
                    Please Read Our</b> <a href="http://forums.binaryoptionsthatsuck.com/threads/4357-Basic-Disclaimer-Communitraders/">Disclaimer</a>
            </div>
        </div>
    </div>
</div>



    <div id="myCalendar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_calendar" aria-hidden="true">       
        <div class="modal-header calendar_header">
            <button type="button" class="close close_white" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel_calendar">Financial calendar</h3>
        </div>
<div class="modal-header">
        <table class="table fch">
                <thead class="table_header_leader">
                    <tr>
                        <th style="width: 126px;">Date (GMT)</th>
                        <th style="width: 445px;">Event</th>
                        <th style="width: 107px;">Cons.</th>
                        <th style="width: 115px;">Actual</th>
                        <th style="width: 122px;">Previous</th>
                    </tr>
                </thead>
            </table></div>
        <div class="modal-body">
            <table class="table">
                <thead class="table_header_leader">
                  
                </thead>
                <tbody id="event_block">

                </tbody>
            </table>
        </div>
    </div>     
<!-- Modal Leader Board-->
<div class="modal fade" id="myLeaderBoard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_leader" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header leaderboard_header">
            <button type="button" class="close close_white" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel_leader">Top 15 CommuniTraders Leaderboard</h3>
            <div class="modal_buttons current_lb" id="leaderboard_week"><a href="javascript:void(0)" onclick="getLeadersBoard('week');">This week</a></div>
			<div class="modal_buttons" id="leaderboard_month"><a href="javascript:void(0)" onclick="getLeadersBoard('month');">This month</a></div>
			<div class="modal_buttons" id="leaderboard_all"><a href="javascript:void(0)" onclick="getLeadersBoard('all');">Top overall</a></div>
        </div>
        <div>
                            <div class="modal-body">
                                <table class="table">
                                    <thead class="table_header_leader">
                                    <tr>
                                        <th>Rank</th>
                                        <th>NickName</th>
                                        <th>Avatar</th>
                                        <th>Total Trades</th>
                                        <th>Win Trades</th>
                                        <th>Win Rate</th>
                                        <th><a href="javascript:void(0);" onclick="order_by_pl();">P&amp;L%</a></th>
                                    </tr>
                                    </thead>
                                    <tbody id="leader_block">
                                    </tbody>
                                </table>
                            </div>
                </div>
        </div>
    </div>
</div> <!-- End Modal Leader Board -->

<form method="get" id="post_form" enctype="multipart/form-data">
    <div class ="container-fluid" id="parts_container">

        <div class ="col-md-3" id="box_left">
            <div class="box_left_heading"><span>1</span>&nbsp;Select</div>


            <div class="container-fluid">
            <div class="row">

                <div class="ct_tab_left">
                <h2>Assets & Strategy</h2>
                    <div class="container-fluid">
                    <div class="row">
                        <!-- Nav tabs Main Strategy -->
                        <ul class="nav nav-tabs strategy">
                            <li class="active" id="high_tab"><a href="#high" data-toggle="tab">High / Low</a></li>
                            <li id="boundary_tab"><a href="#boundary" data-toggle="tab">Boundary</a></li>
                            <li id="touch_tab"><a href="#touch" data-toggle="tab">One touch</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="high" >

                                    <!-- Nav tabs Choose Trade options-->
                                    <ul id="list_tip" class="nav nav-tabs nav-stacked ct_tabs_options">
                                        <li ><a href="#indices" data-toggle="tab">Indices</a><span>open</span></li>
                                        <li class="active"><a href="#currencies" data-toggle="tab">Currencies</a><span>open</span></li>
                                        <li><a href="#commodities" data-toggle="tab">Commodities</a><span>closed</span></li>
										<!-- *************************************** -->
										{foreach from=$time key=k item=val}
                                        <li><a href="#{$val.name}" data-toggle="tab">{$val.name}</a><span class={if $val.isclosed}'closed'{else} 'open' {/if}>{if $val.isclosed}closed{else} open {/if}</span></li>
										{/foreach}
										<!-- *************************************** 
										
                                       <!-- <li><a href="#europe" data-toggle="tab">Europe</a><span class=</span></li>
                                        <li><a href="#australia" data-toggle="tab">Australia</a><span class=</span></li>-->
                                        <li><a href="#favorites_high" data-toggle="tab">Favorites</a></li>
                                    </ul>
                                    <div class="tab-content ct_tabs_options_list">

                                    <div class="tab-pane fade" id="indices">
										<ol id="what_indices">
											<div class="ajax_loader" >
										<span>Waiting for data...</span>
										<img src="{$url}/assets/images/ajax-loader.gif" alt="Load..." >
										</div>
										</ol>
                                    </div>
                                    <div class="tab-pane fade in active" id="currencies">

                                        <ol id="what_currencies">
											<div class="ajax_loader" >
										<span>Waiting for data...</span>
										<img src="{$url}/assets/images/ajax-loader.gif" alt="Load..." >
										</div>
                                        </ol>
                                    </div>
                                    <div class="tab-pane fade" id="commodities">
                                        <ol id="what_commodities">
											<div class="ajax_loader" >
										<span>Waiting for data...</span>
										<img src="{$url}/assets/images/ajax-loader.gif" alt="Load..." >
										</div>
                                        </ol>
                                    </div>
								{foreach from=$time key=k item=val}
                                    <div class="tab-pane fade" id="{$val.name}">
                                        <div  class="ct_symbols_list">{$val.name}</div>
                                    </div>
								{/foreach}
                                   <!-- <div class="tab-pane fade" id="europe">
                                        <div  class="ct_symbols_list">Europe</div>
                                    </div>
                                    <div class="tab-pane fade" id="australia">
                                        <div  class="ct_symbols_list">Australia</div>
                                    </div> -->
                                        <div class="tab-pane fade" id="favorites_high">
                                            <div  class="ct_symbols_list">Please choose your favorite trade:</div>
                                        </div>

                                    </div>
                            </div><!-- End High Low tab -->
                          <div class="tab-pane fade" id="boundary">

                                <!-- Nav tabs Choose Trade options-->
                                <ul class="nav nav-tabs nav-stacked ct_tabs_options">
                                    <li><a href="#b_indices" data-toggle="tab">Indices</a><span>open</span></li>
                                    <li class="active"><a href="#b_currencies" data-toggle="tab">Currencies</a><span>open</span></li>
                                    <li><a href="#b_commodities" data-toggle="tab">Commodities</a><span>open</span></li>
									{foreach from=$time key=k item=val}
                                        <li><a href="#{$val.name}" data-toggle="tab">{$val.name}</a><span class={if $val.isclosed}'closed'{else} 'open' {/if}>{if $val.isclosed}closed{else} open {/if}</span></li>
										{/foreach}
									
                                  <!--  <li><a href="#b_usa" data-toggle="tab">USA</a><span>open</span></li>
									
                                    <li><a href="#b_europe" data-toggle="tab">Europe</a><span class="closed">closed</span></li>
                                    <li><a href="#b_australia" data-toggle="tab">Australia</a><span>open</span></li>-->
                                    <li><a href="#b_favorites" data-toggle="tab">Favorites</a></li>
                                </ul>
                                <div class="tab-content ct_tabs_options_list">

                                    <div class="tab-pane fade" id="b_indices">
                                        <ol id="what_b_indices">
										<div class="ajax_loader" >
										<span>Waiting for data...</span>
										<img src="{$url}/assets/images/ajax-loader.gif" alt="Load..." >
										</div>
                                        </ol>
                                    </div>
                                    <div class="tab-pane fade in active" id="b_currencies">
                                        <ol id="what_b_currencies">
										<div class="ajax_loader" >
										<span>Waiting for data...</span>
										<img src="{$url}/assets/images/ajax-loader.gif" alt="Load..." >
										</div>
                                        </ol>
                                    </div>
                                    <div class="tab-pane fade" id="b_commodities">
                                        <ol id="what_b_commodities">
											<div class="ajax_loader" >
										<span>Waiting for data...</span>
										<img src="{$url}/assets/images/ajax-loader.gif" alt="Load..." >
										</div>
                                        </ol>

                                    </div>

                                    <div class="tab-pane fade" id="b_usa">
                                        <div  class="ct_symbols_list">USA</div>
                                    </div>
                                    <div class="tab-pane fade" id="b_europe">
                                        <div  class="ct_symbols_list">Europe</div>
                                    </div>
                                    <div class="tab-pane fade" id="b_australia">
                                        <div  class="ct_symbols_list">Australia</div>
                                    </div>
                                    <div class="tab-pane fade" id="b_favorites">
                                        <div  class="ct_symbols_list">Please choose your favorite trade:</div>
                                    </div>

                            </div>

                            </div><!-- End Boundary tab -->
                            <div class="tab-pane fade" id="touch">
                                <!-- Nav tabs Choose Trade options-->
                                <ul class="nav nav-tabs nav-stacked ct_tabs_options">
                                    <li><a href="#t_indices" data-toggle="tab">Indices</a><span>open</span></li>
                                    <li class="active"><a href="#t_currencies" data-toggle="tab">Currencies</a><span>open</span></li>
                                    <li><a href="#t_commodities" data-toggle="tab">Commodities</a><span>open</span></li>
                                   {foreach from=$time key=k item=val}
                                        <li><a href="#{$val.name}" data-toggle="tab">{$val.name}</a><span class={if $val.isclosed}'closed'{else} 'open' {/if}>{if $val.isclosed}closed{else} open {/if}</span></li>
										{/foreach}
                                    <li><a href="#t_favorites" data-toggle="tab">Favorites</a></li>
                                </ul>
                                <div class="tab-content ct_tabs_options_list">

                                    <div class="tab-pane fade" id="t_indices">
                                        <ol id="what_t_indices">
										<div class="ajax_loader" >
										<span>Waiting for data...</span>
										<img src="{$url}/assets/images/ajax-loader.gif" alt="Load..." >
										</div>
                                        </ol>
                                    </div>
                                    <div class="tab-pane fade in active" id="t_currencies">
                                        <ol id="what_t_currencies">
										<div class="ajax_loader" >
										<span>Waiting for data...</span>
										<img src="{$url}/assets/images/ajax-loader.gif" alt="Load..." >
										</div>
                                        </ol>
                                    </div>
                                    <div class="tab-pane fade" id="t_commodities">
                                        <ol id="what_t_commodities">
										<div class="ajax_loader" >
										<span>Waiting for data...</span>
										<img src="{$url}/assets/images/ajax-loader.gif" alt="Load..." >
										</div>
                                        </ol>

                                    </div>

                                    <div class="tab-pane fade" id="t_usa">
                                        <div  class="ct_symbols_list">USA</div>
                                    </div>
                                    <div class="tab-pane fade" id="t_europe">
                                        <div  class="ct_symbols_list">Europe</div>
                                    </div>
                                    <div class="tab-pane fade" id="t_australia">
                                        <div  class="ct_symbols_list">Australia</div>
                                    </div>
                                    <div class="tab-pane fade" id="t_favorites">
                                        <div  class="ct_symbols_list">Please choose your favorite trade:</div>
                                    </div>


                                </div>


                            </div><!-- End Touch tab -->

                        </div>
                    </div>
                        </div>

                </div>
            </div>

            <div class="row">
                <div id="box_currentinfo">
                    <div id="account_info">
                        <div class ="col-md-4 ai_one" id="info_oppos">$250<br/><span>Open position</span></div>
                        <div class ="col-md-4 ai_two" id="info_pl">$150<br/><span>Today\'s P&L</span></div>
                        <div class ="col-md-4 ai_three" id="info_balance">$19900<br/><span>Balance</span></div>
                    </div>
                </div>
             </div>

        </div>

        </div><!-- END box_left -->
        <div class ="col-md-9" id="box_right">

            <div class="box_right_heading"><span>2</span>&nbsp;Set & Trade <div class="box_right_time" id="doc_time"></div></div>
			{literal}<script type="text/javascript">clock();</script>{/literal}
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-4" style="padding: 0">
                    <div class="ct_tab_mid">

                        <div class="tab-pane" id="high_tab_content">
                            <h2 class="asd_asset">Your Trade</h2>
							<div id="select_status_high"></div>
                            <div class="row" id="you_think_high_low" style="margin-bottom: 10px; display: none;"><div class="message-info"><span>Will the <span class="asd_asset"></span> at <span id="time_than_high_low"></span> close Higher or Lower than the current price?</span></div></div>
                            <div class="content-fluid">
                                <div class="row" style="margin-bottom: 15px;">
                                   <div class="col-md-5 col-md-offset-1 btn_wrap_high">
                                       <input id="radio_high" class="check_strategy" type="radio" name="rdio" value="high" />
                                       <label class="green" for="radio_high"><span></span>High</label></div>
                                    <div class="col-md-6 amount_wrap"><label class="control-label" for="hl_invest">Amount ( $ ):</label>
                                        <input id="hl_invest"  class="text_field form-control" value="100" type="text" style="width: 80%" />
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                          <div class="col-md-5 col-md-offset-1 price_wrap"><div class="curr_price_1">
						  <span class="glyphicon glyphicon-minus"></span></div></div>
						  <div class="col-md-6"><input id="trade_btn_hl" class="btn trade_btn" value="Trade" onclick="run({$reply_to_thread}); return false;" />
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 btn_wrap_low"><input id="radio_low" class="check_strategy" type="radio" name="rdio" value="low" /><label class="red" for="radio_low"><span></span>Low</label></div><div class="col-md-6 expire_wrap">
                                    Expires
									<!-----This  Don't Change This HTML PART,...This part is used in JavaScript -->
                                        <select  class="selectpicker high" onchange="select_high_low(this.options[this.selectedIndex].text);" data-style="btn-info">
										<option selected value="">Please Select</option>
                                            <optgroup label="Less Than Hour">
										  {foreach from=$expiry key=k item=val}
                                                {if $val.sort>=1 && $val.sort<=6}
                                                <option value="{$val.expiry_value}">{$val.expiry_name}</option>
												{/if}
											{/foreach}
                                            </optgroup>
                                            <optgroup label="Less Than Day">
                                                {foreach from=$expiry key=k item=val}
                                               {if $val.sort>=7 && $val.sort<=10}
                                                <option value="{$val.expiry_value}">{$val.expiry_name}</option>
												{/if}
												{/foreach}
                                            </optgroup>
                                            <optgroup label="More Than Day">
                                                {foreach from=$expiry key=k item=val}
                                               {if $val.sort>=11 && $val.sort<=13}
                                                <option value="{$val.expiry_value}">{$val.expiry_name}</option>
												{/if}
												{/foreach}
                                            </optgroup>
                                        </select>
										<!-- ***************************************************************************-->
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 message">Out of the money<br/><span id="low_money">$0</span>(-85%)</div><div class="col-md-6 message">In the money<br/><span id="high_money">$0</span>(+85%)</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-md-offset-1 stmessage"></div>
                                </div>

                            </div><!-- END content-fluid -->
                        </div>
                        <div class="tab-pane" id="boundary_tab_content">
                            <h2 class="asd_asset">Your Trade</h2>
							<div id="select_status_boundary"></div>
                            <div class="row" id="you_think_boundary" style="margin-bottom: 10px; display:none;"><div class="message-info"><span>Will the market price be located In or Out of the range between the target prices at <span id="time_than_boundary"></span>?</span></div></div>
                            <div class="content-fluid">
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 btn_wrap_in"><input id="radio_in" class="check_strategy" type="radio" name="rdio" value="boundary_inside" />
									<label class="green" for="radio_in"><span></span>In</label></div>
									<div class="col-md-6 amount_wrap"><label class="control-label" for="io_invest">Amount ( $ ):</label>
									<input id="io_invest" class="text_field form-control" value="100" type="text" style="width: 80%"/> </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 price_wrap boundary_wrap">
                                        <div class="boundary_price_top"><span class="glyphicon glyphicon-minus"></span></div>
                                        <div class="curr_price_1"><span class="glyphicon glyphicon-minus"></span></div>
                                        <div class="boundary_price_bottom"><span class="glyphicon glyphicon-minus"></span></div></div>
                                    <div class="col-md-6"><input id="trade_btn_boundary" class="btn trade_btn" type="button" value="Trade" onclick="run({$reply_to_thread});return false;" /></div>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 btn_wrap_out"><input id="radio_out" class="check_strategy" type="radio" name="rdio" value="boundary_out" /><label class="red" for="radio_out"><span></span>Out</label></div><div class="col-md-6 expire_wrap">
                                        Expires
                                        <select class="selectpicker boundary"  onchange="select_boundary(this.options[this.selectedIndex].text);" data-style="btn-info">
										<option selected value="">Please Select</option>
                                          <optgroup label="Less Than Hour">
										  {foreach from=$expiry key=k item=val}
                                                {if $val.sort>=1 && $val.sort<=6}
                                                <option value="{$val.expiry_value}">{$val.expiry_name}</option>
												{/if}
											{/foreach}
                                            </optgroup>
                                            <optgroup label="Less Than Day">
                                                {foreach from=$expiry key=k item=val}
                                               {if $val.sort>=7 && $val.sort<=10}
                                                <option value="{$val.expiry_value}">{$val.expiry_name}</option>
												{/if}
												{/foreach}
                                            </optgroup>
                                            <optgroup label="More Than Day">
                                                {foreach from=$expiry key=k item=val}
                                               {if $val.sort>=11 && $val.sort<=13}
                                                <option value="{$val.expiry_value}">{$val.expiry_name}</option>
												{/if}
												{/foreach}
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 message">Expires Inbound<br/><span id="out_money">$0</span>(-85%)</div><div class="col-md-6 message">Expires Outbound<br/><span id="in_money">$0</span>(+85%)</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-md-offset-1 stmessage"></div>
                                </div>
                            </div><!-- END content-fluid -->
                        </div>
                        <div class="tab-pane" id="touch_tab_content">
                            <h2 class="asd_asset">Your Trade</h2>
							<div id="select_status_touch"></div>
                            <ul class="nav nav-tabs one_touch">

                                <li class="active"><a href="#tab_touch" data-toggle="tab">Touch</a></li>
                                <li><a href="#tab_no_touch" data-toggle="tab">No Touch</a></li>

                            </ul>
                            <div class="tab-content">
                            <div class="tab-pane active fade in" id="tab_touch">

                            <div class="row" id="you_think_time_than_one_touch" style="margin-bottom: 10px; display:none; "><div class="message-info"><span>Will the market price Touch or Not Touch the target price anytime before <span id="time_than_one_touch"></span>?</span></div></div>
                            <div class="content-fluid">
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 btn_wrap_touch">
                                        <input id="radio_touch" class="check_strategy" type="radio" name="rdio" value="touch_up" />
                                        <label class="green" for="radio_touch"><span></span>Touch</br>UP</label>
                                    </div>
                                    <div class="col-md-6 amount_wrap">
                                        <label class="control-label" for="touch_invest">Amount ( $ ):</label>
                                        <input id="touch_invest" class="text_field form-control" value="100" type="text" style="width: 80%" />
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 price_wrap">
                                        <div class="curr_price_1"><span class="glyphicon glyphicon-minus"></span></div>
                                        <div class="touch_target_price"><span class="glyphicon glyphicon-minus"></span></div>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="trade_btn_touch" class="btn trade_btn" type="button" value="Trade" onclick="run({$reply_to_thread});return false;"/>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 btn_wrap_no_touch">
                                        <input id="radio_no_touch" class="check_strategy" type="radio" name="rdio" value="touch_down" />
                                        <label class="red" for="radio_no_touch"><span></span>Touch</br>Down</label>
                                    </div>
                                    <div class="col-md-6 expire_wrap">
                                        Expires
                                        <select class="selectpicker touch"  onchange="select_one_touch(this.options[this.selectedIndex].text);" data-style="btn-info">
										<option selected value="">Please Select</option>
                                            <optgroup label="Less Than Hour">
											{foreach from=$expiry key=k item=val}
                                                {if $val.sort>=1 && $val.sort<=6}
                                                <option value="{$val.expiry_value}">{$val.expiry_name}</option>
												{/if}
											{/foreach}
                                            </optgroup>
                                            <optgroup label="Less Than Day">
                                                {foreach from=$expiry key=k item=val}
                                               {if $val.sort>=7 && $val.sort<=10}
                                                <option value="{$val.expiry_value}">{$val.expiry_name}</option>
												{/if}
												{/foreach}
                                            </optgroup>
                                            <optgroup label="More Than Day">
                                                {foreach from=$expiry key=k item=val}
                                               {if $val.sort>=11 && $val.sort<=13}
                                                <option value="{$val.expiry_value}">{$val.expiry_name}</option>
												{/if}
												{/foreach}
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 message"><div class="touch_message_out">-</div><span id="notouch_money">$0</span>(-85%)</div><div class="col-md-6 message "><div class="touch_message_in">-</div><span id="touch_money">$0</span>(+85%)</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-md-offset-1 stmessage"></div>
                                </div>
                            </div><!-- END content-fluid -->
                            </div><!-- END tab_touch -->

                        <div class="tab-pane" id="tab_no_touch">
								<div id="select_status_no_touch"></div>
                            <div class="row" id="you_think_no_touch" style="margin-bottom: 10px; display:none"><div class="message-info">
							<span>Will the market price Touch or Not Touch the target price anytime before <span id="time_than_no_touch"></span>?</span></div>
							</div>
                            <div class="content-fluid">
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 btn_wrap_no_touch_up">
                                        <input id="radio_no_touch_up" class="check_strategy" type="radio" name="rdio" value="no_touch_up" />
                                        <label class="green" for="radio_no_touch_up"><span></span>No Touch</br>Up</label></div>
                                    <div class="col-md-6 amount_wrap">
                                        <label class="control-label" for="no_touch_invest">Amount ( $ ):</label>
                                        <input id="no_touch_invest" value="100" class="text_field form-control" type="text" style="width: 80%" />
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 price_wrap">
                                        <div class="curr_price_1"><span class="glyphicon glyphicon-minus"></span></div>
                                        <div class="touch_target_price"><span class="glyphicon glyphicon-minus"></span></div>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="trade_btn_no_touch" class="btn trade_btn" type="button" value="Trade" onclick="run({$reply_to_thread}); return false;""/>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 btn_wrap_no_touch_down">
                                        <input id="radio_no_touch_down" class="check_strategy" type="radio" name="rdio" value="no_touch_down" />
                                        <label class="red" for="radio_no_touch_down"><span></span>No Touch</br>Down</label>
                                    </div>
                                    <div class="col-md-6 expire_wrap">
                                        Expires
                                        <select class="selectpicker no_touch" onchange="select_no_touch(this.options[this.selectedIndex].text);"  data-style="btn-info">
											<option value="">Please Select</option>
											<optgroup label="Less Than Hour">
											{foreach from=$expiry key=k item=val}
                                               {if $val.sort>=1 && $val.sort<=6}
                                                <option value="{$val.expiry_value}">{$val.expiry_name}</option>
												{/if}
											{/foreach}
                                            </optgroup>
                                            <optgroup label="Less Than Day">
                                                {foreach from=$expiry key=k item=val}
                                               {if $val.sort>=7 && $val.sort<=10}
                                                <option value="{$val.expiry_value}">{$val.expiry_name}</option>
												{/if}
												{/foreach}
                                            </optgroup>
                                            <optgroup label="More Than Day">
                                                {foreach from=$expiry key=k item=val}
                                               {if $val.sort>=11 && $val.sort<=13}
                                                <option value="{$val.expiry_value}">{$val.expiry_name}</option>
												{/if}
												{/foreach}
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-5 col-md-offset-1 message"><div class="touch_message_out">-</div><span id="notouch_down_money">$0</span>(-85%)</div><div class="col-md-6 message"><div class="touch_message_in">-</div><span id="notouch_up_money">$0</span>(+85%)</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-md-offset-1 stmessage"></div>
                                </div>
                            </div><!-- END content-fluid -->
                        </div><!-- END tab_no_touch -->
                                </div>
                    </div><!-- END touch_tab_content -->
                    </div>

                </div>


                <div class ="col-md-8" style="padding: 0">
                    <div class="ct_tab_right">
                    <div class="left_arrow"></div>
                        <div class="price_top"><div class="curr_price_1"><span class="glyphicon glyphicon-minus"></span></div></div>
                        <div id="chartContainer"></div>
                    </div>
                </div>
            </div>

            <div id="trade_value">
                <input id="game_id" name="game_id" type="hidden" value="0">
            </div>
			<input id="userCache" type="hidden" value="{$userCache.user_cache}">
            <input id="isstart" type="hidden" value="0">
            <input id="is_post" type="hidden" value="0">
            <input id="is_full_screen" type="hidden" value="0">
            <input id="current_price" type="hidden" value="0">
            <input id="already_selected" type="hidden" value="0">
            <input id="main_page_tool" type="hidden" value="1">
            <input id="user_id" type="hidden" value="{$userid}">
            <input id="run_w_g" type="hidden" value="0">
            <input id="high_price" type="hidden" value="0">
            <input id="low_price" type="hidden" value="0">
            <input id="t_r_min" type="hidden" value="0">
            <input id="t_r_max" type="hidden" value="0">
            <input id="default_asset" type="hidden" value="{$default_asset}" />
			
            <input type="hidden" id="forumid" name="forumid" value="{$location}"/>
            </form>
            <div class="row">
                    <div class ="col-md-12" style="padding: 0">
                        <div class="ct_tab_bottom">

                            <!-- Nav tabs Bottom page Choose Open Trades/ History options -->
                            <ul class="nav nav-tabs nav-stacked ct_tabs_bottom">
                                <li><a href="#open-trades" data-toggle="tab">Open Trades</a></li>
                                <li><a href="#trade-history" data-toggle="tab">Trade History</a></li>
                                <li class="active"><a href="#news" data-toggle="tab">News</a></li>
                               <!-- <li><a href="#settings" data-toggle="tab">Settings</a></li>
                                <li class="disabled"><a href="#my-wall" data-toggle="tab">My Wall</a></li> -->

                            </ul>
                            <div class="tab-content ct_tabs_bottom_list">

                                <div class="tab-pane fade" id="open-trades">
                                    <div class="game_acc_cont">
                                        <div id="open_trades" class="main_ot"></div>
                                        <div id="open_trades_per" class="main_ot"></div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="trade-history">
                                    <div class="game_acc_cont">
                                        <div id="close_trades" class="main_ot"></div>
                                    </div>
                                </div>
                                <div class="tab-pane fade in active" id="news">
                                    <div class="assets_name_news"></div>
                                    <div class="news_box">
                                        {section name=i loop=$news}
                                            <div class="news_title"><h5><a href="{$news[i].link}" target="_blank">{$news[i].title}</a></h5></div>
                                            <div class="news_date">{$news[i].pub_date}</div>
                                            <div class="news_content">{if $news[i].description ne 'NULL'}{$news[i].description}{/if}</div>
                                        {/section}
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="settings">
                                    <div  class="ct_symbols_list">Settings</div>
                                </div>
                                <div class="tab-pane fade" id="my-wall">
                                    <div  class="ct_symbols_list">My Wall</div>
                                </div>

                            </div>

                        </div>

                    </div>


            </div>


        </div>

            </div>
            </div>



        </div><!-- end of all -->
    </div>

</div>
