<?php /* Smarty version Smarty 3.1.0, created on 2013-06-30 16:38:01
         compiled from "application/views/index_main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:285721535185f63c493b71-23888849%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b6a1e012dea43585ffb6f49ac08523c770e87a83' => 
    array (
      0 => 'application/views/index_main.tpl',
      1 => 1372599430,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '285721535185f63c493b71-23888849',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_5185f63c8cefa',
  'variables' => 
  array (
    'username' => 0,
    'url' => 0,
    'inputRows' => 0,
    'link' => 0,
    'userCache' => 0,
    'symbols_company' => 0,
    'symbols_indices' => 0,
    'symbols_currency' => 0,
    'symbols_metall' => 0,
    'strategy' => 0,
    'expiry' => 0,
    'investment' => 0,
    'default_asset' => 0,
    'reply_to_thread' => 0,
    'location' => 0,
    'news' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5185f63c8cefa')) {function content_5185f63c8cefa($_smarty_tpl) {?><div id="main_container">
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
                            which will just save your trade into <a href="/CommuniTraders/myperformance/<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
">My Performance.</a> 
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
                <thead class="table_header_leader">
                  
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
<th style="width: 10%;text-align:center;">Avatar</th>
<th style="width: 15%;text-align:center;">NickName</th>
<th style="width: 15%;text-align:center;"># Winning Trades</th>
<th style="width: 15%;text-align:center;">P&L%</th>
<th style="width: 15%;text-align:center;">Best Strategy</th>
<th style="width: 15%;text-align:center;">Best Asset</th>
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
    <div id="parts_container">
        <div id="box_left">
            <div id="box_left_container">
                <form action="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
newpost/newthread" method="post" id="post_form" enctype="multipart/form-data">
                    <div id="blockrow">                     
                        <div id="navigation">                           
                            <div class="menu_tab">
                                <div class="menu_a menu_tab_border">
                                    <div class="a_text">
                                        <a data-toggle="tooltip"  href="http://forums.binaryoptionsthatsuck.com">Forum</a>
                                    </div>
                                </div>
                            </div>
                            <div class="menu_tab menu_tab_border">
                                <div class="menu_a">
                                    <div class="a_text">
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
myperformance/<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
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
                        <div id="box_currentinfo">
                            <div id="account_info">
                                <div id="info_balance">Balance:&nbsp;</div>
                                <div id="info_oppos">Open Position:&nbsp;</div>
                                <div id="info_pl">Today's P&amp;L:&nbsp;</div>
                            </div>
                        </div>                     
                    </div>  
                    <div id="nav_block">
                        <div id="box_title" class="form-horizontal">
                            <label class="control_label" for="title">Title:</label>
                            <input type="text" class="primary_full_textbox" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['inputRows']->value['comment_header'])===null||$tmp==='' ? '' : $tmp);?>
" id="title" name="title" placeholder="Enter a Title for your Analysis Here"/>
                        </div>
                        <div id=switch_rt>
                            <div id="rt_box">
                                <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
">Switch To Real Trading</a>                    
                            </div>
                        </div>
                    </div>
                    <div id="tool_box">    
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
                            <div id="chartContainer"></div>
                        </div>
                        <div id="select_status"></div>
                        <input id="userCache" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['userCache']->value;?>
">
                        <div id="lower_box">
                            <div class="modal fade hide" id="start_dialog">
                                <div class="modal-header" id="dialog"> </div>
                            </div>
                            <div id="post_box">
                                <div id="dashboard">
                                    <div id="dashboard_container">
                                        <select id="what" onChange="runWithoutGame()" class="chzn-select">
                                            <option selected="selected" value="">Assets&nbsp;-></option>
                                            <optgroup label="STOCK">
                                                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['co']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['co']['name'] = 'co';
$_smarty_tpl->tpl_vars['smarty']->value['section']['co']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['symbols_company']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['co']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['co']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['co']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['co']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['co']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['co']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['co']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['co']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['co']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['co']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['co']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['co']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['co']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['co']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['co']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['co']['total']);
?> 
                                                    <option value="<?php echo $_smarty_tpl->tpl_vars['symbols_company']->value[$_smarty_tpl->getVariable('smarty')->value['section']['co']['index']]['short_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['symbols_company']->value[$_smarty_tpl->getVariable('smarty')->value['section']['co']['index']]['full_name'];?>
</option>
                                                <?php endfor; endif; ?> 
                                            </optgroup>
                                            <optgroup label="INDICES">
                                                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['symbols_indices']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                                    <option value="<?php echo $_smarty_tpl->tpl_vars['symbols_indices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['short_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['symbols_indices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['full_name'];?>
</option>
                                                <?php endfor; endif; ?> 
                                            </optgroup>
                                            <optgroup label="CURRENCY PAIRS">
                                                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['c']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['name'] = 'c';
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['symbols_currency']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['c']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['c']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['c']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['c']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['c']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['c']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['total']);
?> 
                                                    <option value="<?php echo $_smarty_tpl->tpl_vars['symbols_currency']->value[$_smarty_tpl->getVariable('smarty')->value['section']['c']['index']]['short_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['symbols_currency']->value[$_smarty_tpl->getVariable('smarty')->value['section']['c']['index']]['full_name'];?>
</option>
                                                <?php endfor; endif; ?> 
                                            </optgroup>
                                            <optgroup label="COMMODITIES">
                                                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['m']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['name'] = 'm';
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['symbols_metall']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total']);
?> 
                                                    <option value="<?php echo $_smarty_tpl->tpl_vars['symbols_metall']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['short_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['symbols_metall']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['full_name'];?>
</option>
                                                <?php endfor; endif; ?> 
                                            </optgroup>
                                        </select>
                                      <div id="strategy_select" onmouseout="hidePromt();">
                                            <div id="strategy_val">
                                                <input id="strategy" type="hidden" value="">
                                            </div>
                                            <ul class="nav" id="strategy_ul" role="navigation" onmouseout="hidePromt();">
                                                <li class="dropdown">
                                                    <a id="drop1" href="#" role="button" class="dropdown-toggle" onmouseout="hidePromt();" data-toggle="dropdown">
                                                        Strategy&nbsp;->
                                                    </a>
                                                    <span id="caret_box" class="caret"></span>
                                                    <ul class="dropdown-menu" id="dropdown_items" aria-labelledby="drop1">
                                                        <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['s']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['name'] = 's';
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['strategy']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total']);
?> 
                                                            <li onmouseover="showPromt('<?php echo $_smarty_tpl->tpl_vars['strategy']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['short_name'];?>
');">
                                                            <a href="#" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo $_smarty_tpl->tpl_vars['strategy']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['promt'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['strategy']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['short_name'];?>
" onclick="setStrategyInput('<?php echo $_smarty_tpl->tpl_vars['strategy']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['short_name'];?>
','<?php echo $_smarty_tpl->tpl_vars['strategy']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['full_name'];?>
'); return false;"><?php echo $_smarty_tpl->tpl_vars['strategy']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['full_name'];?>
</a>
                                                            <div class="tooltip fade right in" style="display: block; top: -5px; left: 160px;">
                                                            <div class="tooltip-inner"><div id="strategy_promt"></div>
                                                            </div>
                                                            </li>
                                                        <?php endfor; endif; ?> 
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <select id="expire" class="select_small chzn-select">
                                            <option selected value="">Expiry&nbsp;-></option>
                                            <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ex']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['name'] = 'ex';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['expiry']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ex']['total']);
?> 
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['expiry']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ex']['index']]['expiry_value'];?>
"><?php echo $_smarty_tpl->tpl_vars['expiry']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ex']['index']]['expiry_name'];?>
</option>
                                            <?php endfor; endif; ?> 
                                        </select>
                                        &nbsp;&nbsp;&nbsp;&nbsp;                                      
                                        <select id="investment" class="chzn-select">
                                            <option selected value="">Investment&nbsp;-></option>
                                            <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['inv']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['name'] = 'inv';
$_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['investment']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['inv']['total']);
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['investment']->value[$_smarty_tpl->getVariable('smarty')->value['section']['inv']['index']]['value'];?>
">$<?php echo $_smarty_tpl->tpl_vars['investment']->value[$_smarty_tpl->getVariable('smarty')->value['section']['inv']['index']]['value'];?>
</option>                                                                          
                                            <?php endfor; endif; ?> 
                                        </select>
                                        <div id="price_input">
                                            <input id="price" type="text" value="Input price" onClick="appear_disapeare(this.id);">
                                        </div>     
                                        <div id="trade_value">
                                            <input id="game_id" name="game_id" type="hidden" value="0">
                                        </div>
                                        <input id="isstart" type="hidden" value="0">                          
                                        <input id="is_post" type="hidden" value="0">
                                        <input id="is_full_screen" type="hidden" value="0">
                                        <input id="current_price" type="hidden" value="0">
                                        <input id="already_selected" type="hidden" value="0">
                                        <input id="main_page_tool" type="hidden" value="1"> 
                                        <input id="run_w_g" type="hidden" value="0"> 
                                        <input id="high_price" type="hidden" value="0">
                                        <input id="low_price" type="hidden" value="0">
                                        <input id="t_r_min" type="hidden" value="0">
                                        <input id="t_r_max" type="hidden" value="0"> 
                                        <input id="default_asset" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['default_asset']->value;?>
" />
                                    </div>
                                    <div id="button_container">
                                        <a href="" class="share" onclick="run(1, <?php echo $_smarty_tpl->tpl_vars['reply_to_thread']->value;?>
); return false;"><img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/images/share_btn.png" alt=""></a>
                                        <?php if ($_smarty_tpl->tpl_vars['reply_to_thread']->value==0){?>
                                        <br/>
                                        <a href="" class="share" onclick="run(0, 0); return false;"><img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/images/trade_btn.png" alt=""></a>
                                        <?php }?>
                                    </div>
                                </div>    
                                <div id="message_box">
                                    <div id="placeholder">Explain your analysis, Why you chose this strategy? Why you chose this expiry?
What is your money management strategy for this trade?</div>
                                    <textarea id="comment_field" name="comment_field"></textarea>
                                </div>
                                <div id="action_box">
                                    <div id="trade_battons_box">
                                        <span>Disclosure:</span>
                                        <label class="radio">
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="1">
                                            I Don't have an open trade on my account.
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="2">
                                            I Do have an open trade on my account.
                                        </label>
                                    </div>                   
                                </div>                              
                            </div>
                            <div id="info_box">                             
                                <div id="assets_details_box">
                                    <div id="assets_details_header">
                                        <div class="info_a">
                                            <a href="#">
                                                <div class="assets_name_details"></div>
                                            </a>
                                        </div>
                                    </div>
                                    <div id="green_line"></div>
                                    <div id="assets_details_content">
                                        <div class="pad_box">
                                            <div class="pb_left">
                                                <div id="asd_asset">
                                                </div>
                                                <div id="curr_price_1" >

                                                </div>
                                                <div id="curr_price_2">

                                                </div>
                                                <div id="curr_price_3">

                                                </div>
                                            </div>  
                                            <div class="pb_right">
                                                Payout
                                                <p>
                                                    85%
                                                </p>
                                            </div> 
                                            <div id="slider_r">
                                                <div id="fiftytwo">
                                                    <div id="fiftytwo_left"></div>                                                  
                                                    <div id="fiftytwo_right"></div>
                                                    <div id="small_box_line" style="margin-left:43%">
                                                        <div id="left_small">
                                                        </div>
                                                        <div id="right_small">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="psevdoslider">
                                                    <div id="psevdoslider_box" style="margin-left:45%">
                                                        <div id="green_box">                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="slider_bottom">                                                   
                                                    <div id="fiftytwo_left_price">100.52</div>
                                                    <div id="fiftytwo_right_price">800.49</div>
                                                    <div id="small_box_price" style="margin-left:43%">
                                                        <div id="left_small_price">
                                                            450.57
                                                        </div>
                                                        <div id="right_small_price">
                                                            500.15
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="assets_details_bottom">
                                        <div class="box_dev"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="forumid" name="forumid" value="<?php echo $_smarty_tpl->tpl_vars['location']->value;?>
"/>
                </form>
            </div>
        </div>
        <div id="box_right">
            <div class="accordion accordion_ot">
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                            Open Trades
                            <img class="box_arrow" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/images/arrow_box.png" alt="">
                        </a>
                    </div>
                    <div class="blue_line"></div>
                    <div id="collapseOne" class="accordion-body collapse in">
                        <div class="accordion-inner">
                            <div class="game_acc_cont">
                                <div id="open_trades" class="main_ot"></div>
                            </div>
                        </div>
                        <div class="open_trades_bottom">
                            <div class="box_dev"></div>
                        </div>
                    </div>
                </div>
            </div>
                        <div class="accordion accordion_ot">
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFife">
                            Closed Trades
                            <img class="box_arrow" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/images/arrow_box.png" alt="">
                        </a>
                    </div>
                    <div class="blue_line"></div>
                    <div id="collapseFife" class="accordion-body collapse in">
                        <div class="accordion-inner">
                            <div class="game_acc_cont">
                                <div id="close_trades" class="main_ot"></div>
                            </div>
                        </div>
                        <div class="open_trades_bottom">
                            <div class="box_dev"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion" id="accordion_fn">
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                            <div class="assets_name_news"></div> 
                            <img class="box_arrow" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/images/arrow_box.png" alt="">                    
                        </a>                        
                    </div>
                    <div id="orange_line"></div>
                    <div id="collapseTwo" class="accordion-body collapse in">
                        <div class="accordion-inner">
                            <div class="news_box">
                                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['news']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                    <div class="news_title"><h5><a href="<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['title'];?>
</a></h5></div>
                                    <div class="news_date"><?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['pub_date'];?>
</div>
                                    <div class="news_content"><?php if ($_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['description']!='NULL'){?><?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['description'];?>
<?php }?></div>
                                <?php endfor; endif; ?>
                            </div>
                        </div>
                        <div id="news_trades_bottom">
                            <div class="box_dev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of all -->
</div>
<?php }} ?>