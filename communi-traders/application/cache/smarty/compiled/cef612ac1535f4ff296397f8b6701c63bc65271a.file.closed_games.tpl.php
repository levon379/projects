<?php /* Smarty version Smarty 3.1.0, created on 2013-05-05 08:19:25
         compiled from "application/views/closed_games.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10165978715185ebddb41e79-14117689%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cef612ac1535f4ff296397f8b6701c63bc65271a' => 
    array (
      0 => 'application/views/closed_games.tpl',
      1 => 1363242640,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10165978715185ebddb41e79-14117689',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user_name' => 0,
    'finishedTrades' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_5185ebddc55aa',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5185ebddc55aa')) {function content_5185ebddc55aa($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'application/third_party/smarty/plugins/modifier.date_format.php';
?><table class="table table-bordered">
    <thead>
        <tr class="table_header">
            <th colspan="8"><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
&nbsp;&nbsp; Trading Log&nbsp;&nbsp;(Closed Trades)</th>
        </tr>
        <tr>
            <th>Date start trade</th>
            <th>Asset</th>
            <th>Strategy</th>
            <th>Investment</th>
            <th>P&amp;L</th>
            <th>Price</th>
            <th>Expiry</th>
            <th>In/Out Of the money</th>
        </tr>
    </thead>
    <tbody>
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
                <?php if ($_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['game_result']==0){?>
                <td bgcolor="#E87D8B">
                    &nbsp;$&nbsp;-<?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['pl'];?>

                </td>
                <?php }else{ ?>
                <td bgcolor="#15B841">
                    &nbsp;$&nbsp;<?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['pl'];?>

                </td>
                <?php }?>
                <td>$&nbsp;<?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['price'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['expiry_name'];?>
</td>
                <?php if ($_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['game_result']==1){?>
                    <td bgcolor="#15B841"><a href="#" onclick="loadClosedGame(<?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['id'];?>
, '<?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['asset'];?>
');">&nbsp;In</a></td>
                <?php }else{ ?>
                    <td><a href="#" onclick="loadClosedGame(<?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['id'];?>
, '<?php echo $_smarty_tpl->tpl_vars['finishedTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ft']['index']]['asset'];?>
');">&nbsp;Out</a></td>                                    
                <?php }?>
             </tr>
        <?php endfor; endif; ?> 
    </tbody>
</table>
<?php }} ?>