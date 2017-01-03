<?php /* Smarty version Smarty 3.1.0, created on 2013-05-14 08:35:26
         compiled from "application/views/statistic_main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18770971525185ebdcc0fad3-55407393%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ec48446b05f387a24da9991c6508c35bae627b7b' => 
    array (
      0 => 'application/views/statistic_main.tpl',
      1 => 1368509462,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18770971525185ebdcc0fad3-55407393',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_5185ebdd45ee3',
  'variables' => 
  array (
    'url' => 0,
    'user_name' => 0,
    'forum_url' => 0,
    'user_id' => 0,
    'aboutRows' => 0,
    'send' => 0,
    'currentTrades' => 0,
    'performanceRows' => 0,
    'key' => 0,
    'finishedTrades' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5185ebdd45ee3')) {function content_5185ebdd45ee3($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'application/third_party/smarty/plugins/modifier.date_format.php';
?><div class="body_wrapper table_static_box">
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_hht" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel_hht">How To Trade</h3>
        </div>
        <div class="modal-body">
            <p>
            <table class="htt_modal_table">
                <tr>
                    <td id="first_colum">
                        <h4>How it works?</h4>
                        <p>Choose the <b>Asset</b> to trade</p>
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
                            Add <b>title</b> and <b>description</b>, Why you<br /> think
                            its a great trade?
                        </p>
                        <p>&darr;</p>
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
                            which will just save your trade into <a href="/CommuniTraders/myperformance">My Performance.</a>
                            In your user profile you will be able to see your performance report,
                            open and closed trades as well,
                            along with great statistics for yourself and also other CommuniTraders.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td id="fifth_colum" colspan="4">
                        <br />
                        <b>We invite you to share your asset analysis, Ideas and market outlook at CommuniTraders Forum! <br />
                            Take Advantage of the Crowd's Wisdom!<br />
                            BinaryOptionsThatSuck.com Team<br />
                            Please Read Our</b> <a href="http://forums.binaryoptionsthatsuck.com/threads/4357-Basic-Disclaimer-Communitraders/">Disclaimer</a>
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
                <thead>
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
<div class="modal-header">
        <table class="table fch">
                <thead class="table_header_leader">
                    <tr>
<th style="width: 4%;"/>
<th style="width: 10%;">Avatar</th>
<th style="width: 15%;">NickName</th>
<th style="width: 15%;">% Winning Rates</th>
<th style="width: 15%;"># Winning Trades</th>
<th style="width: 15%;">Best Strategy</th>
<th style="width: 15%;">Best Asset</th>
</tr>
                </thead>
            </table></div>
        <div class="modal-body">
            <table class="table">
                <thead class="table_header_leader">               
                </thead>
                <tbody id="leader_block">
                </tbody>
            </table>
        </div>
    </div>
    <div id="static_header">
        <div id="static_slogan">My Performance</div>
        <div id="tool_menu_static">
            <div id="navigation">
                <div class="menu_tab">
                    <div class="menu_a menu_tab_border">
                        <div class="a_text">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
">CommuniTraders</a>
                        </div>
                    </div>
                </div>
                <div class="menu_tab menu_tab_border">
                    <div class="menu_a">
                        <div class="a_text">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
myperformance/<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
">My Performance</a>
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

    <div id="table_cntainer" class="report_font">
        <div id="reports_left_part">
            <input id="main_page_tool" type="hidden" value="0">
            <div id="about">
                <table class="table table-bordered td_name">
                    <thead>
                        <tr class="table_header">
                            <th>About <?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</th>
                            <th><a href="<?php echo $_smarty_tpl->tpl_vars['forum_url']->value;?>
members/<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
" class = "profile_link">Edit</a></th>
                        </tr>
                        <tr class="table_header_blue">
                            <th colspan="2"><a href="#" class="table_header_blue"></a></th>
                        </tr>
                    </thead>
                    <tbody class="reports_block">
                        <tr>
                            <td>Country</td>
                            <td ><?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['country'];?>
</td>
                        </tr>
                        <tr>
                            <td class="td_name">Occupation</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['occupation'];?>
</td>
                        </tr>
                        <tr>
                            <td class="td_name table_header_second"><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
 Trading Experience</td>
                            <td class="td_name table_header_second"><?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['expirience'];?>
</td>
                        </tr>
                        <tr>
                            <td class="td_name">Win Trades Ratio</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['winTradesRate'];?>
</td>
                        </tr>
                        <tr>
                            <td>P&L</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['pl'];?>
</td>
                        </tr>
                        <tr>
                            <td class="td_name">Broker Name</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['broker'];?>
</td>
                        </tr>
                        <tr>
                            <td class="td_name">
                                <?php if ($_smarty_tpl->tpl_vars['send']->value==0){?>
                                    <input type="checkbox" id="email_alert" name="email_alert" value="<?php echo $_smarty_tpl->tpl_vars['send']->value;?>
" onChange="sendEmailAlert(); return false;">Get Email Alert
                                <?php }else{ ?>
                                    <input type="checkbox" checked id="email_alert" name="email_alert" value="<?php echo $_smarty_tpl->tpl_vars['send']->value;?>
" onChange="sendEmailAlert(); return false;">Get Email Alert
                                <?php }?>
                            </td>
                            <td id="is_alert">
                                <?php if ($_smarty_tpl->tpl_vars['send']->value==0){?>
                                    No
                                <?php }else{ ?>
                                    Yes
                                <?php }?>
                            </td>
                        </tr>
                        <tr>
                            <td class="td_name">Demo/Live</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['demolive'];?>
</td>
                        </tr>
                        <tr>
                            <td class="td_name">Reset His Demo Account</td>
                            <?php if ($_smarty_tpl->tpl_vars['aboutRows']->value['resetCounter']==0){?>
                                <td>never</td>
                            <?php }else{ ?>
                                <td><?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['resetCounter'];?>
&nbsp;Times</td>
                            <?php }?>
                        </tr>
                        <tr>
                            <td class="td_name">Current Account Balance</td>
                            <td>
                                $&nbsp;<?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['balance'];?>

                                <?php if ($_smarty_tpl->tpl_vars['aboutRows']->value['balance']<=100){?>
                                    <div id="reset">
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
ajax/renewBalance" class="btn btn-info">Renew Balance</a>
                                    </div>
                                <?php }?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="open_trades_per">
                <table id="all_open" class="table table-bordered">
                    <thead>
                        <tr class="table_header">
                            <th colspan="9"><a href="#" class="table_header_log">Open Positions</a></th>
                        </tr>
                        <tr class="table_header_perpel">
                            <th colspan="9"><a href="#" class="table_header_perpel"></a></th>
                        </tr>
                        <tr class="open_games_th">
                            <th>Asset</th>
                            <th>Strategy</th>
                            <th>Investment</th>
                            <th>&nbsp;&nbsp;&nbsp;Price&nbsp;&nbsp;&nbsp;</th>
                            <th>Curr.Price</th>
                            <th>Expiry</th>
                            <th>In/Out Of the money</th>
                            <th>Time left for expire</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody class="reports_block">
                        <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['currentTrades']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
                            <tr class="history_trade" id="active_games_<?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
">
                                <!--<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['created_at'],"%m.%d.%Y");?>
</td>-->
                                <td><?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['asset'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['strategy'];?>
</td>
                                <td>$&nbsp;<?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['investment'];?>
</td>
                                <?php if ($_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['strategy']=='bounderi inside'){?>
                                    <td>$&nbsp;<?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['price_from'];?>
 - <?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['price_to'];?>
</td>
                                <?php }elseif($_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['strategy']=='bounderi out'){?>
                                    <td>$&nbsp;<?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['price_from'];?>
 - <?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['price_to'];?>
</td>
                                <?php }else{ ?>
                                    <td>$&nbsp;<?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['price'];?>
</td>
                                <?php }?>
                                <td>$&nbsp;<?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['curr_price'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['expiry_name'];?>
</td>
                                <?php if ($_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']=='In'){?>
                                    <td class="in_money"><?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status'];?>
</td>
                                <?php }else{ ?>
                                    <td class="out_money"><?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status'];?>
</td>
                                <?php }?>
                                <td><?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['time_remains'];?>
</td>
                                <?php if ($_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['is_post']==1){?>
                                    <td><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
edit/<?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
">Edit</a></td>
                                <?php }else{ ?>
                                    <td></td>
                                <?php }?>
                            </tr>
                        <?php endfor; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="reports_right_part">
            <div id="container"></div><br/>
            <div id="performance_table">
                <table class="table table-bordered td_name">
                    <thead>
                        <tr class="table_header">
                            <th colspan="6"><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
 Performance Report:</th>
                        </tr>
                        <tr class="table_header_yellow">
                            <th colspan="6"><a href="#" class="table_header_yellow"></a></th>
                        </tr>
                        <tr class="open_games_th">
                            <th></th>
                            <th>Today</th>
                            <th>This Week</th>
                            <th>This Month</th>
                            <th>This Year</th>
                            <th>All time</th>
                        </tr>
                    </thead>
                    <tbody class="reports_block">
                        <tr>
                            <td>Number of winning trades</td>
                            <td>
                                <?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winningTrades']['dayResult'];?>

                            </td>
                            <td>
                                <?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winningTrades']['weekResult'];?>

                            </td>
                            <td>
                                <?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winningTrades']['monthResult'];?>

                            </td>
                            <td>
                                <?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winningTrades']['yearResult'];?>

                            </td>
                            <td>
                                <?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winningTrades']['allTimePeriod'];?>

                            </td>
                        </tr>
                        <tr>
                            <td>Number Of Bad Trades</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['badTrades']['dayResult'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['badTrades']['weekResult'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['badTrades']['monthResult'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['badTrades']['yearResult'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['badTrades']['allTimePeriod'];?>
</td>
                        </tr>
                        <tr>
                            <td>Win Trades Rate</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winTradesRate']['day'];?>
 %</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winTradesRate']['week'];?>
 %</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winTradesRate']['month'];?>
 %</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winTradesRate']['year'];?>
 %</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winTradesRate']['allTime'];?>
 %</td>
                        </tr>
                        <tr>
                            <td>Loose Trades Rate</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['loseTradesRate']['day'];?>
 %</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['loseTradesRate']['week'];?>
 %</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['loseTradesRate']['month'];?>
 %</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['loseTradesRate']['year'];?>
 %</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['loseTradesRate']['allTime'];?>
 %</td>
                        </tr>
                        <tr>
                            <td>Best Asset</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestAsset']['dayRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestAsset']['weekRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestAsset']['monthRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestAsset']['yearRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestAsset']['allTimeRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                        </tr>
                        <tr>
                            <td>Worst Asset</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstAsset']['dayRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstAsset']['weekRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstAsset']['monthRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstAsset']['yearRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstAsset']['allTimeRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                        </tr>
                        <tr>
                            <td>Best Strategy</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestStrategy']['dayRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestStrategy']['weekRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestStrategy']['monthRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestStrategy']['yearRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestStrategy']['allTimeRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                        </tr>
                        <tr>
                            <td>Worst Strategy</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstStrategy']['dayRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstStrategy']['weekRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstStrategy']['monthRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstStrategy']['yearRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstStrategy']['allTimeRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                        </tr>
                        <tr>
                            <td>Success Rate Of Calls Strategy</td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyDay'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['call'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyWeek'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['call'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyMonth'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['call'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyYear'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['call'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyAllTime'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['call'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate Of Puts Strategy</td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyDay'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['put'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyWeek'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['put'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyMonth'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['put'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyYear'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['put'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyAllTime'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['put'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate Of Touch Strategy</td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyDay'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyWeek'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyMonth'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyYear'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyAllTime'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate Of No Touch Strategy</td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyDay'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['no touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyWeek'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['no touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyMonth'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['no touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyYear'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['no touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyAllTime'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['no touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate Of Boundery Out  Strategy</td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyDay'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi out'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyWeek'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi out'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyMonth'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi out'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyYear'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi out'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyAllTime'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi out'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate Of Boundary In  Strategy</td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyDay'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi out'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyWeek'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi inside'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyMonth'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi inside'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyYear'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi inside'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                            <td>
                                <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyAllTime'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi inside'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="statistic_box">
                <div id="closed_trades">
                    <table id="all" class="table table-bordered">
                        <thead>
                            <tr class="table_header">
                                <th colspan="8"><a href="#" class="table_header_log">Trade History</a></th>
                            </tr>
                            <tr class="table_header_yellow">
                                <th colspan="8"><a href="#" class="table_header_yellow"></a></th>
                            </tr>
                            <tr class="open_games_th">
                                <th>Date start trade</th>
                                <th>Asset</th>
                                <th>Strategy</th>
                                <th>Investment</th>
                                <th>P&amp;L</th>
                                <th>Price</th>
                                <th>Expiry</th>
                                <th>Expiry Price</th>
                                <th>In/Out Of the money</th>
                            </tr>
                        </thead>
                        <tbody class="reports_block">
                            <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ft']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['name'] = 'ft';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['finishedTrades']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ft']['total']);
?>
                                <tr class="history_trade">
                                    <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['created_at'],"%m.%d.%Y");?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['asset'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['strategy'];?>
</td>
                                    <td>$&nbsp;<?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['investment'];?>
</td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['game_result']==1){?>
                                            $&nbsp;<?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['pl'];?>

                                        <?php }else{ ?>
                                            -$&nbsp;<?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['pl'];?>

                                        <?php }?>
                                    </td>
                                    <td>$&nbsp;<?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['price'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['expiry_name'];?>
</td>
                                    <td>$<?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['f_price'];?>
</td>
                                    <?php if ($_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['game_result']==1){?>
                                        <td class="in_money">&nbsp;In</td>
                                    <?php }else{ ?>
                                        <td class="out_money">&nbsp;Out</td>
                                    </tr>
                                <?php }?>
                            <?php endfor; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="static_bottom"></div></div></div>
<?php }} ?>