<?php /* Smarty version Smarty 3.1.0, created on 2013-05-06 09:55:11
         compiled from "application/views/active_games_per.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1231703426518753cfa79329-09999828%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ade8555fb6f35213fd22207f6c47754246465804' => 
    array (
      0 => 'application/views/active_games_per.tpl',
      1 => 1363679023,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1231703426518753cfa79329-09999828',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'currentTrades' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_518753cfc10ef',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_518753cfc10ef')) {function content_518753cfc10ef($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'application/third_party/smarty/plugins/modifier.date_format.php';
?><table class="table table-bordered">
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
    <tbody>
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
<?php }} ?>