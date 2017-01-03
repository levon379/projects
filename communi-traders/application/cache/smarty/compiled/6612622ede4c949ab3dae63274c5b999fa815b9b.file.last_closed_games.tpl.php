<?php /* Smarty version Smarty 3.1.0, created on 2013-06-30 19:50:25
         compiled from "application/views/last_closed_games.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17629431545185ebd7b6d870-06343518%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6612622ede4c949ab3dae63274c5b999fa815b9b' => 
    array (
      0 => 'application/views/last_closed_games.tpl',
      1 => 1372611022,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17629431545185ebd7b6d870-06343518',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_5185ebd7c241e',
  'variables' => 
  array (
    'last_closed' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5185ebd7c241e')) {function content_5185ebd7c241e($_smarty_tpl) {?><table class="table open_games_table">
    <thead>
        <tr>
            <th>Asset</th>
            <th>Strat.</th>
            <th>Invest.</th>
            <th>Entry</th>
            <th>Closed</th>
        </tr>
    </thead>
    <tbody>
        <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['last_closed']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                    <?php if ($_smarty_tpl->tpl_vars['last_closed']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['url']!=''){?>
                        <td><a href="<?php echo $_smarty_tpl->tpl_vars['last_closed']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['last_closed']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['asset_short'];?>
</a></td>
                    <?php }else{ ?>
                        <td><?php echo $_smarty_tpl->tpl_vars['last_closed']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['asset_short'];?>
</td>
                    <?php }?>
                <td><?php echo $_smarty_tpl->tpl_vars['last_closed']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['strategy'];?>
</td>
                <td>$&nbsp;<?php echo $_smarty_tpl->tpl_vars['last_closed']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['investment'];?>
</td>
                <td>$&nbsp;<?php echo $_smarty_tpl->tpl_vars['last_closed']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['price'];?>
</td>
                <?php if ($_smarty_tpl->tpl_vars['last_closed']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['game_result']==1){?>
                    <td class="in_money_small"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
">More</a><td>
                <?php }else{ ?>
                    <td class="out_money_small"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
">More</a><td>
                <?php }?>       
            </tr>
        <?php endfor; endif; ?>
    </tbody>
</table>
<?php }} ?>