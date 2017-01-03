<?php /* Smarty version Smarty 3.1.0, created on 2013-06-25 17:49:07
         compiled from "application/views/leader_board_block.tpl" */ ?>
<?php /*%%SmartyHeaderCode:123626226251867cb175b172-86145427%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '61fe24fde0848123a36986baf4e7c2feff68b8a2' => 
    array (
      0 => 'application/views/leader_board_block.tpl',
      1 => 1372099786,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '123626226251867cb175b172-86145427',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_51867cb194ca1',
  'variables' => 
  array (
    'leaders' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51867cb194ca1')) {function content_51867cb194ca1($_smarty_tpl) {?><?php if (!is_callable('smarty_function_counter')) include 'application/third_party/smarty/plugins/function.counter.php';
?><?php echo smarty_function_counter(array('start'=>0),$_smarty_tpl);?>

<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['leaders']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
    <td style="width: 4%;text-align: center;">#<?php echo smarty_function_counter(array(),$_smarty_tpl);?>
</td>
    <td style="width: 10%; text-align: center;"><img src="<?php echo $_smarty_tpl->tpl_vars['leaders']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['img'];?>
"></td>
    <td style="width: 15%; text-align: center;"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
profile/<?php echo $_smarty_tpl->tpl_vars['leaders']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['username'];?>
/<?php echo $_smarty_tpl->tpl_vars['leaders']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['user_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['leaders']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['username'];?>
</a></td>
    <td style="width: 15%; text-align: center;"><?php echo $_smarty_tpl->tpl_vars['leaders']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['w_trades'];?>
</td>
    <td style="width: 15%; text-align: center;"><?php echo $_smarty_tpl->tpl_vars['leaders']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['w_rates'];?>
%</td>
    <td style="width: 15%; text-align: center;"><?php echo $_smarty_tpl->tpl_vars['leaders']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['b_strat'];?>
</td>
    <td style="width: 15%; text-align: center;"><?php echo $_smarty_tpl->tpl_vars['leaders']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['b_asset'];?>
</td>
</tr>
<?php endfor; endif; ?>
<?php }} ?>