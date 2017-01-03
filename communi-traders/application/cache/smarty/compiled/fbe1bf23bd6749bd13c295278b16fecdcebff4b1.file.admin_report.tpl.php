<?php /* Smarty version Smarty 3.1.0, created on 2013-07-30 15:48:37
         compiled from "application/views/admin_report.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19671093651866ffa6cfb26-55951608%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fbe1bf23bd6749bd13c295278b16fecdcebff4b1' => 
    array (
      0 => 'application/views/admin_report.tpl',
      1 => 1375101851,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19671093651866ffa6cfb26-55951608',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_51866ffaa0a06',
  'variables' => 
  array (
    'action' => 0,
    'url' => 0,
    'user_info' => 0,
    'asset_info' => 0,
    'strategy_info' => 0,
    'expire_info' => 0,
    'asset_expire_info' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51866ffaa0a06')) {function content_51866ffaa0a06($_smarty_tpl) {?><div id="export_to_xls">
    <?php if ($_smarty_tpl->tpl_vars['action']->value=='read'){?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/export_by_read"><img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/images/xls.jpeg"/></a>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['action']->value=='by_asset'){?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/export_by_asset"><img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/images/xls.jpeg"/></a>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['action']->value=='by_strategies'){?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/export_by_strategies"><img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/images/xls.jpeg"/></a>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['action']->value=='by_expire'){?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/export_by_expire"><img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/images/xls.jpeg"/></a>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['action']->value=='by_asset_expire'){?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/export_by_asset_expire"><img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/images/xls.jpeg"/></a>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['action']->value=='this_week_registrations'){?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/export_this_week_registrations"><img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/images/xls.jpeg"/></a>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['action']->value=='this_week_all_users'){?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/export_this_week_registrations"><img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/images/xls.jpeg"/></a>
    <?php }?>
</div>
<div class="table_menu">
        <ul class="nav nav-pills">
            <li <?php if ($_smarty_tpl->tpl_vars['action']->value=='read'){?>class="active"<?php }?>>
                <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/read">By List of user</a>
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['action']->value=='by_asset'){?>class="active"<?php }?>>
                <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/by_asset">By List of asset</a>
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['action']->value=='by_strategies'){?>class="active"<?php }?>>
                <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/by_strategies">By List of Strategies</a>
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['action']->value=='by_expire'){?>class="active"<?php }?>>
                <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/by_expire">By List of expires</a>
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['action']->value=='by_asset_expire'){?>class="active"<?php }?>>
                <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/by_asset_expire">By Asset/Expire</a>
            </li>

            <li <?php if ($_smarty_tpl->tpl_vars['action']->value=='this_week_registrations'){?>class="active"<?php }?>>
                <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/this_week_registrations">This week: registered</a>
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['action']->value=='this_week_all_users'){?>class="active"<?php }?>>
                <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/this_week_all_users">This week: all users</a>
            </li>
        </ul>
</div>
<input type="hidden" name="is_report" id="is_report" value="1" />
<?php if ($_smarty_tpl->tpl_vars['action']->value=='by_asset'||$_smarty_tpl->tpl_vars['action']->value=='by_asset_expire'){?>
    <input type="hidden" name="is_paginate" id="is_paginate" value="0" />
<?php }else{ ?>
    <input type="hidden" name="is_paginate" id="is_paginate" value="1" />
<?php }?>
<div id="reports">
        <table id="all" class="table table-bordered"> 
        <?php if ($_smarty_tpl->tpl_vars['action']->value=='read'){?>
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Country</th>
                <th>Open Trades</th>
                <th>Closed Trades</th>
                <th>Total of Shares</th>
                <th>Winning Ratio</th>
                <th>Losing Ratio</th>
                <th>Last Logged</th>
                <th>How many times logged in</th>
                <th>Logged Last month</th>
            </tr>
        </thead>
        <tbody>
            <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['user_info']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['username'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['email'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['country'];?>
</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['open_games'];?>
</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['closed_games'];?>
</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['total_shares'];?>
</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['winn_rate'];?>
</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['loose_rate'];?>
</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['last_logged'];?>
</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['h_m_t_loged'];?>
</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['l_m_logged'];?>
</td>
            </tr>
            <?php endfor; endif; ?>
        </tbody>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['action']->value=='by_asset'){?>
        <thead>
            <tr>
                <th>Asset</th>
                <th>Open Trades</th>
                <th>Closed Trades</th>
                <th>Winning Ratio</th>
                <th>Losing Ratio</th>
            </tr>
        </thead>
            <tbody>
            <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['asset_info']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['asset_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['asset'];?>
</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['asset_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['open_trades'];?>
</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['asset_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['closed_trades'];?>
</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['asset_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['winning_rate'];?>
%</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['asset_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['loosing_rate'];?>
%</td>
            </tr>
            <?php endfor; endif; ?>
            </tbody>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['action']->value=='by_strategies'){?>
        <thead>
            <tr>
                <th>Strategy</th>
                <th>Open Trades</th>
                <th>Closed Trades</th>
                <th>Winning Ratio</th>
                <th>Loosing Ratio</th>
            </tr>
        </thead>
            <tbody>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['strategy_info']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['strategy_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['strategy'];?>
</td>
                    <td align="center"><?php echo $_smarty_tpl->tpl_vars['strategy_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['open_trades'];?>
</td>
                    <td align="center"><?php echo $_smarty_tpl->tpl_vars['strategy_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['closed_trades'];?>
</td>
                    <td align="center"><?php echo $_smarty_tpl->tpl_vars['strategy_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['winning_rates'];?>
%</td>
                    <td align="center"><?php echo $_smarty_tpl->tpl_vars['strategy_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['loosing_rates'];?>
%</td>
                </tr>
                <?php endfor; endif; ?>
            </tbody>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['action']->value=='by_expire'){?>
        <thead>
            <tr>
                <th>Expire name</th>
                <th>Open Trades</th>
                <th>Closed Trades</th>
                <th>Winning Ratio</th>
                <th>Loosing Ratio</th>
            </tr>
        </thead>
            <tbody>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['expire_info']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['expire'];?>
</td>
                    <td align="center"><?php echo $_smarty_tpl->tpl_vars['expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['open_trades'];?>
</td>
                    <td align="center"><?php echo $_smarty_tpl->tpl_vars['expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['closed_trades'];?>
</td>
                    <td align="center"><?php echo $_smarty_tpl->tpl_vars['expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['winning_rates'];?>
%</td>
                    <td align="center"><?php echo $_smarty_tpl->tpl_vars['expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['loosing_rates'];?>
%</td>
                </tr>
                <?php endfor; endif; ?>
            </tbody>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['action']->value=='by_asset_expire'){?>
        <thead>
            <tr>
                <th>Assest/expiry</th>
                <th>60 seconds</th>
                <th>15 miutes</th>
                <th>1 hour</th>
                <th>4 hours</th>
                <th>1 day</th>
                <th>3 days</th>
                <th>1 week</th>
                <th>1 month</th>
            </tr>
        </thead>
            <tbody>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['asset_expire_info']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                <tr>
                    <td align="center">&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['asset_expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['asset'];?>
&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['asset_expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['60sec'];?>
&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['asset_expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['15min'];?>
&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['asset_expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['1h'];?>
&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['asset_expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['4h'];?>
&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['asset_expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['1d'];?>
&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['asset_expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['3d'];?>
&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['asset_expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['1w'];?>
&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['asset_expire_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['1mon'];?>
&nbsp;&nbsp;</td>
                </tr>
                <?php endfor; endif; ?>
            </tbody>
        <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['action']->value=='this_week_registrations'){?>
                <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>Open Trades</th>
                    <th>Closed Trades</th>
                    <th>Total of Shares</th>
                    <th>Winning Ratio</th>
                    <th>Losing Ratio</th>
                </tr>
                </thead>
                <tbody>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['user_info']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['username'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['email'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['country'];?>
</td>
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['open_games'];?>
</td>
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['closed_games'];?>
</td>
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['total_shares'];?>
</td>
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['winn_rate'];?>
</td>
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['loose_rate'];?>
</td>
                    </tr>
                <?php endfor; endif; ?>
                </tbody>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['action']->value=='this_week_all_users'){?>
                <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>Open Trades</th>
                    <th>Closed Trades</th>
                    <th>Total of Shares</th>
                    <th>Winning Ratio</th>
                    <th>Losing Ratio</th>
                </tr>
                </thead>
                <tbody>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['user_info']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['username'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['email'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['country'];?>
</td>
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['open_games'];?>
</td>
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['closed_games'];?>
</td>
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['total_shares'];?>
</td>
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['winn_rate'];?>
</td>
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['user_info']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['loose_rate'];?>
</td>
                    </tr>
                <?php endfor; endif; ?>
                </tbody>
            <?php }?>
        </table>
</div>
<?php }} ?>