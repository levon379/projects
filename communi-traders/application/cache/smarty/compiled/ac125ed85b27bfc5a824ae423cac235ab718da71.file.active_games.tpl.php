<?php /* Smarty version Smarty 3.1.0, created on 2013-06-30 19:44:30
         compiled from "application/views/active_games.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20026273835187042f966404-26947848%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac125ed85b27bfc5a824ae423cac235ab718da71' => 
    array (
      0 => 'application/views/active_games.tpl',
      1 => 1372610668,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20026273835187042f966404-26947848',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_5187042fa4efc',
  'variables' => 
  array (
    'currentTrades' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5187042fa4efc')) {function content_5187042fa4efc($_smarty_tpl) {?><table class="table open_games_table">
    <thead>
        <tr>
            <th>Asset</th>
            <th>Strat.</th>
            <th>Invest.</th>
            <th>Entry</th>
            <th>Expiry</th>
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
                <?php if ($_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['url']!=''){?>
                    <td><a href="<?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['asset_short'];?>
</a></td>
                <?php }else{ ?>
                    <td><?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['asset_short'];?>
</td>
                <?php }?>
                <td><?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['strategy'];?>
</td>
                <td>$&nbsp;<?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['investment'];?>
</td>
                <td>$&nbsp;<?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['price'];?>
</td>
                <?php if ($_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']=='In'){?>
                    <td class="history_trade in_money_small"><?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['expired_at'];?>
</td>
                <?php }else{ ?>
                    <td class="history_trade out_money_small"><?php echo $_smarty_tpl->tpl_vars['currentTrades']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['expired_at'];?>
</td>
                <?php }?>                 
            </tr>
        <?php endfor; endif; ?>
    </tbody>
</table>
<?php }} ?>